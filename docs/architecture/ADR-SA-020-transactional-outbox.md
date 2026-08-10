# ADR-SA-020 — Transactional Outbox

**Type :** Software Architecture Decision — Mécanisme
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document définit l'implémentation concrète de la politique de publication établie dans ADR-SA-019. Il est subordonné à ADR-SA-000, ADR-SA-017, et ADR-SA-019.
**Note :** Ce document étend et précise ADR-SA-013. En cas de contradiction, ADR-SA-020 prévaut.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | L'Outbox est Infrastructure — le Domain l'ignore |
| P-02 — Aggregates gardiens | ⚪ Sans objet | |
| P-03 — Application Services orchestrent | ✅ Conforme | L'Application Service appelle Outbox.store() — §4 |
| P-04 — Repositories retournent des Aggregates | ⚪ Sans objet | |
| P-05 — Events immuables | ✅ Conforme | Le payload Outbox est en insert-only — §4 |
| P-06 — Une transaction | ✅ Conforme | L'Outbox est écrit dans la même transaction que l'Aggregate |
| P-07 — Publication post-commit | ✅ Conforme | C'est le mécanisme qui garantit P-07 — §5 |
| P-08 — Integration Events | ⚪ Sans objet | |
| P-09 — Frontières de plateforme | ⚪ Sans objet | |
| P-10 — Read Models | ⚪ Sans objet | |

---

## 1. Contexte

ADR-SA-019 définit la politique : at-least-once, post-commit, idempotence consommateur obligatoire, DLQ après épuisement des retries.

Cette ADR définit le mécanisme concret qui implémente cette politique :
- la structure de la table Outbox,
- les règles de stockage,
- les stratégies de relay,
- les scénarios de reprise après incident,
- le traitement des duplicatas,
- la gestion des poison messages.

---

## 2. Structure de la table Outbox

```sql
CREATE TABLE domain_events (
    id              UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
    aggregate_id    UUID        NOT NULL,
    aggregate_type  VARCHAR(255) NOT NULL,
    event_type      VARCHAR(255) NOT NULL,
    event_version   INTEGER     NOT NULL DEFAULT 1,
    payload         JSONB       NOT NULL,
    metadata        JSONB       NOT NULL DEFAULT '{}',
    occurred_at     TIMESTAMPTZ NOT NULL,
    published_at    TIMESTAMPTZ,
    status          VARCHAR(20) NOT NULL DEFAULT 'PENDING'
                    CHECK (status IN ('PENDING', 'PUBLISHED', 'DEAD')),
    retry_count     INTEGER     NOT NULL DEFAULT 0,
    last_error      TEXT,
    created_at      TIMESTAMPTZ NOT NULL DEFAULT NOW()
);
```

### Index obligatoires

```sql
-- Index principal du relay (PENDING ordonné par occurence)
CREATE INDEX idx_domain_events_relay
    ON domain_events (status, occurred_at)
    WHERE status = 'PENDING';

-- Index de recherche par Aggregate (audit, replay)
CREATE INDEX idx_domain_events_aggregate
    ON domain_events (aggregate_id, aggregate_type, occurred_at);

-- Index pour la DLQ
CREATE INDEX idx_domain_events_dead
    ON domain_events (status, occurred_at)
    WHERE status = 'DEAD';
```

### Description des champs

| Champ | Rôle |
|---|---|
| `id` | Identifiant unique de l'entrée Outbox — utilisé comme `eventId` pour la déduplication |
| `aggregate_id` | Identifiant de l'Aggregate qui a produit l'événement |
| `aggregate_type` | Type de l'Aggregate (ex : `ClinicalActivity`, `ClinicalContribution`) |
| `event_type` | Type de l'événement (ex : `ContributionCliniqueCreée`) — correspond aux types de DE-001 |
| `event_version` | Version du contrat de payload — permet la migration progressive |
| `payload` | Contenu de l'événement — JSONB immutable après insertion |
| `metadata` | Informations de contexte non métier (correlation_id, causation_id, tenant_id) |
| `occurred_at` | Horodatage de production dans le Domain |
| `published_at` | Horodatage de publication effective (null tant que PENDING) |
| `status` | `PENDING` → `PUBLISHED` ou `DEAD` |
| `retry_count` | Nombre de tentatives de publication échouées |
| `last_error` | Message d'erreur de la dernière tentative échouée |

---

## 3. Règles de stockage

### R-01 — Insertion atomique

L'insertion dans `domain_events` se fait dans la **même transaction** que la persistance de l'Aggregate. Il n'existe aucun chemin pour insérer dans `domain_events` en dehors d'une transaction ouverte.

### R-02 — Insert-only

Le payload (`payload`, `metadata`, `occurred_at`, `aggregate_id`, `aggregate_type`, `event_type`) n'est **jamais modifié** après l'insertion initiale. Seuls `status`, `published_at`, `retry_count`, et `last_error` peuvent être mis à jour (par le relay).

### R-03 — Ordre d'insertion

Les événements d'une même transaction sont insérés dans l'ordre de leur production par l'Aggregate. L'`occurred_at` reflète l'ordre métier. Le relay lit par `(status, occurred_at)`.

### R-04 — UPSERT interdit

L'Outbox est append-only. Aucun UPSERT n'est autorisé. Si un événement identique est inséré deux fois (bug), deux entrées distinctes existent — la déduplication consommateur gère le doublon via `id`.

### R-05 — Pas de suppression

Les entrées PUBLISHED ne sont pas supprimées immédiatement. Elles sont conservées pour audit et replay. La durée de rétention est définie par la politique d'archivage (hors périmètre de cette ADR).

---

## 4. Relay — Stratégies

Le relay est le processus qui lit les événements PENDING et les dispatche vers le bus.

### Stratégie par défaut — Polling

**Fonctionnement :**
```
loop every N milliseconds:
    events = SELECT ... FROM domain_events
             WHERE status = 'PENDING'
             ORDER BY occurred_at
             LIMIT 100
             FOR UPDATE SKIP LOCKED

    for each event:
        dispatch(event) → bus
        UPDATE domain_events
            SET status = 'PUBLISHED', published_at = NOW()
            WHERE id = event.id
```

**`FOR UPDATE SKIP LOCKED`** : garantit qu'une seule instance de relay traite chaque événement, même avec plusieurs instances de relay en parallèle.

**Intervalle de polling par défaut :** 500ms. Configurable par environnement.

**Avantages :** simple, fiable, sans dépendance externe, fonctionne avec tout PostgreSQL.

**Inconvénients :** latence proportionnelle à l'intervalle de polling (au maximum 500ms par défaut).

### Stratégie alternative — CDC (Change Data Capture)

**Fonctionnement :** écoute le WAL (Write-Ahead Log) PostgreSQL pour détecter les insertions dans `domain_events` en temps réel.

**Outils :** logical replication PostgreSQL, Debezium, pg_logical.

**Avantages :** latence sub-seconde, charge DB réduite (pas de polling continu).

**Inconvénients :** complexité opérationnelle élevée, dépendance sur la configuration PostgreSQL (slot de réplication), outillage supplémentaire.

**Décision :** le Polling est le défaut. Le CDC est une optimisation autorisée, qui requiert une ADR dédiée justifiant le besoin de latence inférieure à 500ms.

---

## 5. Retry

Le relay applique la politique de retry définie dans ADR-SA-019 §8.1.

| Tentative | Délai avant retry |
|---|---|
| 1 | 1 seconde |
| 2 | 2 secondes |
| 3 | 4 secondes |
| 4 | 8 secondes |
| 5 | 16 secondes |
| > 5 | Status → `DEAD` |

À chaque échec : `retry_count++`, `last_error` mis à jour, status reste `PENDING`.

Après 5 échecs : `status = 'DEAD'`. L'événement sort de la boucle de relay standard.

---

## 6. Reprise après incident

### Scénario 1 — Crash du relay après dispatch, avant UPDATE

**Symptôme :** l'événement a été envoyé au bus mais son status reste `PENDING`.

**Comportement :** au redémarrage, le relay voit l'événement PENDING et le redispatche. Le consommateur reçoit un doublon. L'idempotence consommateur (ADR-SA-019 §7) absorbe le doublon sans effet.

**Intervention manuelle :** aucune.

### Scénario 2 — Crash du relay avant dispatch

**Symptôme :** l'événement n'a pas été envoyé. Son status est `PENDING`.

**Comportement :** au redémarrage, le relay reprend à partir des événements PENDING. L'événement est dispatché normalement.

**Intervention manuelle :** aucune.

### Scénario 3 — Rollback de la transaction applicative

**Symptôme :** la transaction applicative a été annulée (exception métier ou infrastructure).

**Comportement :** l'insertion dans `domain_events` fait partie de la même transaction. Si la transaction est annulée, l'insertion est annulée. Aucun événement orphelin n'existe dans l'Outbox.

**Intervention manuelle :** aucune.

### Scénario 4 — Panne prolongée du bus

**Symptôme :** les dispatches échouent. `retry_count` augmente pour tous les événements PENDING.

**Comportement :** après épuisement des retries, les événements passent en `DEAD`. À la reprise du bus, ils doivent être replayed manuellement depuis la DLQ.

**Intervention manuelle :** nécessaire — replay depuis DLQ après rétablissement du bus.

---

## 7. Duplication

La duplication est un comportement attendu du pattern at-least-once. Elle se produit dans les scénarios de crash entre dispatch et UPDATE.

**Fréquence attendue :** rare en opération normale — principalement lors de redémarrages du relay ou de timeouts réseau.

**Gestion :**
- Le relay n'essaie pas d'éviter la duplication
- La déduplication est la responsabilité du consommateur (ADR-SA-019 §7)
- Le `id` de l'entrée Outbox est l'`eventId` de déduplication

**Ce qui ne constitue pas une duplication :**
- Deux événements distincts du même type sur le même Aggregate (deux faits métier distincts)
- Un événement de retry intentionnel depuis la DLQ

---

## 8. Poison Messages et Dead Letter Queue

### Définition

Un **poison message** est un événement qui échoue à être publié ou consommé de manière répétée et définitive. Causes typiques :
- Bus définitivement indisponible (panne prolongée)
- Format de payload invalide (bug de sérialisation)
- Bug consommateur non corrigé pendant la fenêtre de retry

### Cycle de vie d'un poison message

```
PENDING → [retry ×5] → DEAD
```

Un événement `DEAD` :
- N'est plus sélectionné par la boucle de relay standard
- Est visible dans la vue DLQ (requête sur `status = 'DEAD'`)
- Déclenche une alerte monitoring

### Résolution

**Étape 1 — Diagnostiquer**

```sql
SELECT event_type, last_error, retry_count, occurred_at
FROM domain_events
WHERE status = 'DEAD'
ORDER BY occurred_at;
```

**Étape 2 — Corriger**

Identifier et corriger la cause racine (bug consommateur, bus, payload corrompu).

**Étape 3 — Replayer**

```sql
UPDATE domain_events
SET status = 'PENDING', retry_count = 0, last_error = NULL
WHERE id = :event_id;
```

Le relay standard reprend le relais. L'idempotence consommateur absorbe les éventuels doublons.

**Étape 4 — Supprimer (cas exceptionnel)**

Si l'événement est définitivement non traitable et sa suppression est validée par une décision métier :
```sql
DELETE FROM domain_events WHERE id = :event_id;
```

Cette opération requiert une décision explicite documentée — elle n'est jamais automatique.

### Monitoring obligatoire

| Métrique | Seuil d'alerte | Sévérité |
|---|---|---|
| `COUNT(*) WHERE status = 'DEAD'` | > 0 | Warning |
| `COUNT(*) WHERE status = 'PENDING' AND occurred_at < NOW() - INTERVAL '5 minutes'` | > 0 | Critical |
| Âge du plus ancien événement PENDING | > 2 minutes | Warning |

---

## 9. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Aucun événement Outbox sans transaction committée | Insert atomique avec Aggregate — R-01 |
| Aucun payload modifié après insertion | Insert-only — R-02 |
| Aucun événement traité simultanément par deux relay | `FOR UPDATE SKIP LOCKED` — §4 |
| Aucune perte définitive en opération normale | PENDING → retry → DEAD → replay manuel |
| Les duplicatas sont absorbés sans effet | Idempotence consommateur — ADR-SA-019 §7 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle — autorité supérieure |
| ADR-SA-013 | Domain Event Publication — document précédent, supplanté sur les points en contradiction |
| ADR-SA-017 | Runtime Architecture — contexte général |
| ADR-SA-018 | Transaction Management — atomicité Aggregate + Outbox |
| ADR-SA-019 | Domain Event Publication — politique que ce document implémente |
| ADR-SA-021 | Symfony Architecture — implémentation concrète du relay et du repository Outbox |
