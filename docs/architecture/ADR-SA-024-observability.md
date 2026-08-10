# ADR-SA-024 — Observability

**Type :** Software Architecture Decision — Politique transversale
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document gouverne les logs, métriques, traces et corrélation dans MedLink. Il est subordonné à ADR-SA-000.
**Contrainte HDS :** Aucune donnée patient ou donnée personnelle ne peut figurer dans les logs, métriques ou traces.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | Le Domain ne produit pas de logs — §2 |
| P-07 — Publication post-commit | ✅ Conforme | Le correlationId est propagé jusqu'aux Domain Events — §4 |
| autres | ⚪ Sans objet | |

---

## 1. Contexte

MedLink doit être observable à trois niveaux :
- **Logs** — comprendre ce qui s'est passé dans le passé
- **Métriques** — mesurer l'état actuel du système
- **Traces** — suivre le chemin d'une requête à travers les composants

Ces trois niveaux sont complémentaires. L'absence de l'un rend les deux autres insuffisants pour diagnostiquer un incident.

La contrainte HDS interdit la présence de données de santé dans les systèmes d'observabilité (qui ne sont pas eux-mêmes hébergés HDS).

---

## 2. Logs

### Format

Tous les logs sont en **JSON structuré**. Aucun log en texte libre n'est acceptable en production.

```json
{
    "timestamp": "2026-07-29T14:32:11.421Z",
    "level": "INFO",
    "message": "Command dispatched",
    "correlationId": "550e8400-e29b-41d4-a716-446655440000",
    "causationId": "7f6bcd4e-9e1a-4f2a-b3c1-dd4e9bfde891",
    "commandType": "ProduireContributionClinique",
    "actorId": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
    "organizationId": "6ba7b810-9dad-11d1-80b4-00c04fd430c8",
    "durationMs": 142
}
```

### Champs obligatoires

| Champ | Description | Présent |
|---|---|---|
| `timestamp` | ISO 8601 UTC | Toujours |
| `level` | DEBUG / INFO / WARNING / ERROR / CRITICAL | Toujours |
| `message` | Description de l'événement — sans données sensibles | Toujours |
| `correlationId` | Identifiant de la requête originale | Toujours si disponible |
| `causationId` | Identifiant de la cause (Command ou Event) | Toujours si disponible |
| `actorId` | Identifiant de l'acteur — jamais son nom | Si authentifié |
| `organizationId` | Identifiant de l'organisation | Si authentifié |

### Ce qui ne peut jamais figurer dans un log

| Interdit | Raison |
|---|---|
| Nom, prénom d'un patient ou d'un praticien | RGPD + HDS |
| Date de naissance, numéro de sécurité sociale | RGPD + HDS |
| Données cliniques (diagnostic, prescription, résultat) | HDS |
| Mot de passe, token, clé API | Sécurité |
| Stack trace complète dans les réponses HTTP | Sécurité — fuite d'information |

Les stack traces complètes sont loguées en interne (ERROR / CRITICAL) mais ne sont jamais envoyées au client.

### Couche responsable du log

| Couche | Ce qu'elle loggue |
|---|---|
| Domain | Rien — le Domain ne loggue pas |
| Application | Début et fin de Command, exceptions métier (INFO), exceptions infrastructure (ERROR) |
| Infrastructure | Connexions, retries, événements d'infrastructure (DEBUG/WARNING) |
| Interface | Requêtes HTTP reçues, réponses retournées, erreurs d'autorisation |

Le Domain ne loggue pas. Les Domain Events constituent sa trace immuable.

---

## 3. Métriques

### Métriques obligatoires

**Commandes :**

| Métrique | Type | Labels |
|---|---|---|
| `medlink_command_dispatched_total` | Counter | `command_type`, `status` (success/failure) |
| `medlink_command_duration_seconds` | Histogram | `command_type` |

**Queries :**

| Métrique | Type | Labels |
|---|---|---|
| `medlink_query_dispatched_total` | Counter | `query_type` |
| `medlink_query_duration_seconds` | Histogram | `query_type` |

**Outbox (ADR-SA-020) :**

| Métrique | Type | Description |
|---|---|---|
| `medlink_outbox_pending_total` | Gauge | Nombre d'événements PENDING |
| `medlink_outbox_dead_total` | Gauge | Nombre d'événements DEAD (DLQ) |
| `medlink_outbox_relay_lag_seconds` | Gauge | Âge du plus ancien événement PENDING |

**Transactions (ADR-SA-018) :**

| Métrique | Type | Labels |
|---|---|---|
| `medlink_transaction_retry_total` | Counter | `reason` (concurrency, infrastructure) |
| `medlink_transaction_rollback_total` | Counter | `reason` |

### Seuils d'alerte minimaux

| Métrique | Seuil | Sévérité |
|---|---|---|
| `medlink_outbox_dead_total` | > 0 | Warning |
| `medlink_outbox_relay_lag_seconds` | > 120s | Critical |
| `medlink_command_duration_seconds` p99 | > 2s | Warning |
| Taux d'erreur 5xx | > 1% sur 5 minutes | Critical |

---

## 4. CorrelationId et CausationId

### Définitions

**correlationId** : identifiant unique généré à l'entrée d'une requête (HTTP, message de bus, job planifié). Il traverse tous les composants impliqués dans le traitement de cette requête, y compris les Domain Events produits et les réactions asynchrones.

**causationId** : identifiant de la cause immédiate de l'opération courante. Pour une Command déclenchée par HTTP : l'ID de la requête HTTP. Pour une Command déclenchée par un Domain Event : l'`eventId` du Domain Event.

### Propagation

```
HTTP Request (corrId: A, causId: A)
    │
    ▼
Command Handler (corrId: A, causId: A)
    │
    ▼
Domain Event produit (corrId: A, causId: A)
    │
    ▼ (via Outbox relay)
Event Handler / Projector (corrId: A, causId: event.id)
    │
    ▼
Nouvelle Command si applicable (corrId: A, causId: event.id)
```

Le `correlationId` est invariant sur toute la chaîne. Le `causationId` change à chaque niveau de causalité.

### Stockage dans les Domain Events

Les Domain Events portent les deux identifiants dans leur `metadata` (ADR-SA-020 §2) :

```json
{
    "metadata": {
        "correlationId": "550e8400-e29b-41d4-a716-446655440000",
        "causationId": "7f6bcd4e-9e1a-4f2a-b3c1-dd4e9bfde891"
    }
}
```

Cette propagation dans les events permet de reconstruire toute la chaîne causale d'un incident à partir des logs ou de la table `domain_events`.

---

## 5. Traces distribuées

### Standard

OpenTelemetry (OTEL) est le standard retenu pour le tracing distribué. Il est indépendant du vendeur et compatible avec Jaeger, Tempo (Grafana), et Datadog.

### Spans obligatoires

| Span | Début | Fin |
|---|---|---|
| `http.request` | Réception de la requête HTTP | Réponse retournée |
| `command.dispatch` | Dispatch de la Command | Fin du Command Handler |
| `db.query` | Début d'une requête SQL | Fin de la requête |
| `outbox.relay` | Dispatch d'un event depuis l'Outbox | Confirmation de publication |

### Attributs OTEL

| Attribut | Valeur |
|---|---|
| `medlink.correlation_id` | correlationId propagé |
| `medlink.command_type` | type de la Command |
| `medlink.actor_id` | actorId (jamais de données personnelles) |

### Relation avec correlationId

Le `correlationId` MedLink est mappé sur le `trace_id` OTEL lorsque c'est possible. Cette cohérence permet de corréler les logs et les traces dans les dashboards.

---

## 6. Dashboards

### Dashboards obligatoires

| Dashboard | Contenu |
|---|---|
| **API Health** | Latence p50/p95/p99 par endpoint, taux d'erreur 4xx/5xx |
| **Outbox Health** | Profondeur PENDING, profondeur DLQ, âge du plus ancien PENDING, taux de relay |
| **Command Flow** | Volume et taux de succès par type de Command, retries, rollbacks |
| **Infrastructure** | Connexions DB actives, pool saturation, mémoire, CPU |

### Ce que les dashboards n'affichent jamais

- Noms de patients
- Données cliniques
- Toute donnée permettant d'identifier un individu

Les dashboards affichent des identifiants opaques (UUID) et des compteurs agrégés.

---

## 7. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Toute requête est traçable de bout en bout | correlationId obligatoire — §4 |
| La chaîne causale est reconstituable | causationId dans les Domain Events — §4 |
| Aucune donnée patient dans l'observabilité | Politique PII — §2, §6 |
| Le Domain ne produit pas de side effects observabilité | Log uniquement dans Application/Infrastructure — §2 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle |
| ADR-SA-018 | Transaction Management — métriques de retry/rollback |
| ADR-SA-019 | Domain Event Publication — propagation du correlationId |
| ADR-SA-020 | Transactional Outbox — métriques Outbox obligatoires |
| ADR-SA-022 | Error Handling — niveaux de log par exception |
| ADR-SA-023 | Security — audit trail complémentaire |
