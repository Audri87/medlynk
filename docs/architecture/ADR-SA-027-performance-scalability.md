# ADR-SA-027 — Performance & Scalability

**Type :** Software Architecture Decision — Politique transversale
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document gouverne la politique de performance et de scalabilité de MedLink. Il est subordonné à ADR-SA-000.
**Principe directeur :** Les règles de performance définissent des limites normatives, pas des objectifs d'optimisation. On ne dépasse pas les limites ; on n'optimise pas prématurément en-deçà.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | Aucune optimisation de performance dans le Domain |
| P-04 — Repositories retournent des Aggregates | ✅ Conforme | Les Query Handlers contournent les Repositories pour la performance — §4 |
| P-10 — Read Models | ✅ Conforme | Les Projections sont la couche de performance pour les reads — §5 |
| autres | ⚪ Sans objet | |

---

## 1. Contexte

MedLink est un système clinique. Les praticiens utilisent l'interface en consultation, souvent en mobilité, parfois en urgence. La performance n'est pas un luxe — une interface lente dégrade directement la qualité des soins.

Cette ADR établit les limites normatives de performance : pagination, batch, cache, projections, partitionnement, limites de taille, et SLO.

Elle ne décrit pas les optimisations applicatives spécifiques, qui sont traitées dans les ADRs de chaque Use Case.

---

## 2. Pagination

### Règle fondamentale

**La pagination par offset est interdite en production.**

`OFFSET N` nécessite de lire et ignorer N lignes avant de retourner les résultats. À N=10 000, PostgreSQL scanne 10 001 lignes pour en retourner 25. Cette complexité est O(N) — inacceptable pour une table à volume croissant.

### Keyset Pagination (Cursor-based)

MedLink utilise exclusivement la **keyset pagination** (ADR-SA-011) :

```sql
-- Page suivante : WHERE (occurred_at, id) < (:cursor_date, :cursor_id)
-- ORDER BY occurred_at DESC, id DESC
-- LIMIT :page_size
```

Le curseur est opaque pour le client (base64 encodé). Il encode les valeurs du dernier élément de la page courante.

### Limites de page

| Paramètre | Valeur par défaut | Maximum |
|---|---|---|
| Page size (API) | 25 | 100 |
| Page size (interne — batch processing) | 100 | 1000 |

Aucun endpoint ne retourne une liste non paginée. Si une liste est nécessairement complète (ex. : liste de codes), elle est retournée comme ressource statique, pas comme liste paginée.

### Ce qui est interdit

| Interdit | Raison |
|---|---|
| `OFFSET` en production | Complexité O(N) |
| `COUNT(*)` pour la pagination | Coût élevé sur tables volumineuses |
| Retourner une liste complète non paginée | Charge mémoire et réseau non bornée |
| Page size > 100 via API | Protection contre les clients mal écrits |

---

## 3. Batch Operations

### Batch écriture — Command per item

Chaque item d'un batch est traité par une Command indépendante avec sa propre transaction (P-06). Un batch de 50 items génère 50 transactions distinctes.

**Il n'existe pas de "batch transaction" couvrant N Aggregates.**

Ce choix découle directement de P-06. Un échec sur item 23 ne rollback pas les items 1-22.

### Limites de batch

| Type | Limite par lot | Comportement si dépassé |
|---|---|---|
| Batch write (API) | 50 items | 400 Bad Request |
| Batch read (Query Handler) | 1000 items via DBAL | Pagination obligatoire si > 1000 |
| Outbox relay (ADR-SA-020) | 100 events par cycle | Cycle suivant pour le reste |

### Traitement des erreurs en batch

Chaque item a son propre résultat (succès ou échec). La réponse d'un batch retourne un résultat par item :

```json
{
    "results": [
        { "index": 0, "status": "success", "id": "uuid-1" },
        { "index": 1, "status": "error",   "code": "clinical-activity-not-active" },
        { "index": 2, "status": "success", "id": "uuid-3" }
    ]
}
```

---

## 4. Cache

### Ce qui peut être caché

| Donnée | Cacheable | Stratégie |
|---|---|---|
| Projections (Read Models) | Oui | TTL + invalidation event-driven |
| Listes de référence statiques (codes, types) | Oui | TTL long (1h), sans invalidation |
| Résultats de Query Handler | Oui | TTL court, clé = query params + actorId |
| Aggregates | **Non** | Jamais — source de truth toujours fraîche en DB |
| Tokens d'authentification | Non (Identity Platform) | Hors périmètre |

### Cache des Projections — politique

Le cache des Projections est l'optimisation la plus impactante : les Projections sont déjà des données pré-calculées, leur cache réduit la charge DB sans risque de cohérence (les Projections sont recalculables).

| Projection | TTL | Invalidation |
|---|---|---|
| Workspace praticien | 5 minutes | Sur Domain Event modifiant le Workspace |
| Timeline patient | 2 minutes | Sur Domain Event modifiant la Timeline |
| Listes de référence | 1 heure | Sur changement de configuration |

### Invalidation event-driven

L'invalidation est déclenchée par les Domain Events (post-commit). Le consommateur d'invalidation est un Event Handler abonné sur `event.bus` qui supprime la clé de cache.

```
ContributionCreated reçu
    → CacheInvalidationHandler
    → supprime cache Workspace(practitionerId)
    → supprime cache Timeline(patientId)
```

### Ce qui est interdit

| Interdit | Raison |
|---|---|
| Cacher un Aggregate | Les décisions métier doivent reposer sur l'état frais |
| Cache infini (sans TTL) | Risque de staleness indétectée en cas d'invalidation ratée |
| Cacher des données patient en dehors d'une infrastructure HDS | Contrainte HDS |
| Cache partagé entre organizations | Isolation des données — ADR-SA-023 |

---

## 5. Projections comme couche de performance

### Principe

Les Projections sont la réponse principale aux besoins de performance en lecture (P-10). Avant d'optimiser une requête, la première question est :

**Existe-t-il une Projection qui répond à ce besoin ? Si non, faut-il en créer une ?**

Un Query Handler qui joint des tables de plusieurs Aggregates est un symptôme de Projection manquante.

### Dénormalisation

Les Projections sont volontairement dénormalisées. Répéter des données dans plusieurs Projections est correct — la cohérence est assurée par les Domain Events, pas par les jointures.

### Une Projection par pattern d'accès

Chaque Projection est optimisée pour un pattern de requête unique (ADR-SA-011). Utiliser une Projection généraliste pour plusieurs patterns entraîne des indexes inefficaces et des jointures non nécessaires.

---

## 6. Partitionnement

### Règle de déclenchement

Le partitionnement est une optimisation à activer sur critère mesurable. Il n'est pas activé prématurément.

| Table | Critère de déclenchement | Stratégie |
|---|---|---|
| `domain_events` | > 10 millions de lignes | Partitionnement par `occurred_at` (mensuel) |
| Projections à volume élevé | > 5 millions de lignes + queries lentes | Partitionnement par `organization_id` |
| `access_audit` (ADR-SA-023) | > 50 millions de lignes | Partitionnement par `accessed_at` (mensuel) |

### Partitionnement par organisation

Si le volume par organisation est hétérogène (quelques grandes organisations représentent 80% des données), le partitionnement par `organization_id` offre une isolation naturelle des données et améliore les performances de requête par tenant.

Ce partitionnement est une décision à prendre lors du passage à l'échelle — pas en MVP.

---

## 7. Limites de taille

| Artefact | Limite | Action si dépassée |
|---|---|---|
| Payload Domain Event (JSONB) | 1 MB | Externaliser les données volumineuses (S3) — stocker uniquement la référence |
| Requête API (body) | 10 MB | 413 Payload Too Large |
| Réponse API (sans pagination) | 5 MB | Pagination obligatoire |
| Fichier attaché (données cliniques) | Hors Aggregate | Stocker dans Object Storage, référencer par URL signée |
| État d'un Aggregate en mémoire | Pas de limite fixe | Un Aggregate > 50KB est un signal de design smell — revoir le modèle |

### Données volumineuses dans les Domain Events

Les Domain Events ne stockent jamais de fichiers binaires, d'images, ou de documents. Ils stockent des **références** :

```json
{
    "attachmentId": "uuid",
    "storageKey": "clinical/2026/07/uuid.pdf",
    "mediaType": "application/pdf",
    "sizeBytes": 524288
}
```

Le fichier réel est dans un Object Storage HDS. L'event contient la clé de référence.

---

## 8. SLO / SLA

### SLO (Service Level Objectives) — cibles internes

| Métrique | Target p50 | Target p95 | Target p99 |
|---|---|---|---|
| Latence lecture (Query) | < 100ms | < 500ms | < 2s |
| Latence écriture (Command) | < 200ms | < 1s | < 3s |
| Latence Outbox relay | — | < 30s | < 2min |
| Disponibilité service | — | — | 99.9% |
| Staleness des Projections | — | < 2min | < 5min |

**p99 lecture > 2s** : alerte Warning — investigation requise.
**p99 écriture > 3s** : alerte Critical — intervention immédiate.

### SLO Outbox

| Métrique | Seuil Warning | Seuil Critical |
|---|---|---|
| Âge du plus ancien PENDING | > 2 minutes | > 10 minutes |
| Profondeur DLQ (DEAD) | > 0 | > 10 |

### Mesure

Les SLOs sont mesurés via les métriques définies dans ADR-SA-024 §3. Tout SLO qui n'est pas mesuré n'est pas un SLO — c'est un souhait.

---

## 9. Règles de requêtes SQL

### Obligations

| Règle | Raison |
|---|---|
| `EXPLAIN ANALYZE` pour toute nouvelle requête de production | Détecter les Seq Scan non intentionnels |
| Index sur toute colonne de filtrage d'une Projection | Performance garantie à l'échelle |
| `FOR UPDATE SKIP LOCKED` pour les sélections concurrentes (Outbox) | Éviter les deadlocks |
| Limiter les JOINs dans les Query Handlers à 3 tables maximum | Au-delà : créer une Projection dédiée |
| Pas de requête sans clause `WHERE` sur les tables à volume élevé | Full table scan interdit |

### Anti-patterns

| Anti-pattern | Alternative |
|---|---|
| N+1 queries (une requête par item en boucle) | Batch load avec `WHERE id IN (...)` |
| `SELECT *` | Lister les colonnes nécessaires explicitement |
| Jointure Aggregate pour affichage | Créer une Projection dénormalisée |
| Transactions longues (> 5s) | Décomposer le traitement |

---

## 10. Directions de scalabilité

### Read scalability

La séparation CQRS (ADR-0004) permet d'ajouter des réplicas PostgreSQL en lecture sans modification applicative. Les Query Handlers sont dirigés vers les réplicas, les Command Handlers vers le primaire.

Activation : configuration de connexion uniquement — aucun changement de code.

### Write scalability

PostgreSQL est le goulot d'écriture. L'ordre de scalabilité :

1. **Vertical** : augmenter les ressources du primaire (CPU, RAM, IOPS) — premier levier
2. **Connection pooling** : PgBouncer pour mutualiser les connexions (recommandé dès 50 utilisateurs concurrents)
3. **Partitionnement** (§6) : distribuer la charge sur plusieurs tablespaces
4. **Sharding par organization** : dernier recours — complexité opérationnelle élevée

### Outbox relay scalability

Plusieurs instances de relay peuvent tourner en parallèle. `FOR UPDATE SKIP LOCKED` garantit que chaque event n'est traité que par une instance.

---

## 11. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Aucun scan complet d'une table à volume élevé | Keyset pagination + index obligatoire — §2, §9 |
| Un batch n'est pas une transaction globale | Une Command = une transaction — P-06, §3 |
| Les Aggregates ne sont jamais cachés | Politique de cache — §4 |
| Les SLOs sont mesurables | Métriques obligatoires — ADR-SA-024 §3 |
| Les Projections absorbent la charge de lecture | Query Handlers via Projections — §5 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle |
| ADR-SA-011 | Read Model Strategy — keyset pagination, une Projection par pattern |
| ADR-SA-018 | Transaction Management — P-06, une transaction par Command |
| ADR-SA-020 | Transactional Outbox — FOR UPDATE SKIP LOCKED, limits du relay |
| ADR-SA-024 | Observability — métriques de SLO, alertes |
| ADR-0004 | CQRS — fondement de la scalabilité lecture/écriture séparée |
