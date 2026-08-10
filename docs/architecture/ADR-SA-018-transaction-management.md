# ADR-SA-018 — Transaction Management

**Type :** Software Architecture Decision — Fondation
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document gouverne le cycle de vie de toute transaction dans MedLink. Il est subordonné à ADR-SA-000 et ADR-SA-017.
**Indépendance :** Ce document est indépendant de tout framework. L'implémentation Symfony est traitée dans ADR-SA-021.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | Le Transaction Manager est un Port — le Domain ne le connaît pas |
| P-02 — Aggregates gardiens | ✅ Conforme | La transaction n'influe pas sur les règles métier |
| P-03 — Application Services orchestrent | ✅ Conforme | L'Application Service coordonne la frontière transactionnelle |
| P-04 — Repositories retournent des Aggregates | ✅ Conforme | Les Repositories opèrent dans la transaction courante |
| P-05 — Events immuables | ⚪ Sans objet | |
| P-06 — Une transaction | ✅ Conforme | Ce document définit précisément cette règle |
| P-07 — Publication post-commit | ✅ Conforme | Le commit précède toute publication — §6 |
| P-08 — Integration Events | ⚪ Sans objet | |
| P-09 — Frontières de plateforme | ⚪ Sans objet | |
| P-10 — Read Models | ⚪ Sans objet | |

---

## 1. Contexte

ADR-SA-017 établit que l'Application Service est responsable de la frontière transactionnelle. Il ouvre, coordonne, et committe la transaction.

Cette ADR définit précisément :
- comment le Transaction Manager est défini et où il réside,
- les règles de propagation,
- les déclencheurs de rollback,
- la politique de retry,
- le niveau d'isolation par défaut,
- le rôle du Unit of Work,
- le point exact du commit.

---

## 2. Transaction Manager Port

Le Transaction Manager est un **Port** défini dans la couche Application. Il est implémenté dans l'Infrastructure.

### Interface (Application Layer)

```
TransactionManagerPort {
    begin()    : void
    commit()   : void
    rollback() : void
    isActive() : bool
}
```

**Règles du Port :**
- Le Domain ne connaît pas ce Port — il ne gère pas de transaction
- L'Application Service utilise ce Port via injection de dépendance
- L'implémentation concrète réside dans l'Infrastructure
- Un seul `TransactionManagerPort` est actif par requête

---

## 3. Cycle de vie d'une transaction

### Séquence nominale

```
Application Service
    │
    ├── begin()
    │
    ├── Repository.load(id)          ← lecture dans la transaction
    │
    ├── Aggregate.method(args)       ← produit Domain Events
    │
    ├── Repository.save(aggregate)   ← écriture dans la transaction
    │
    ├── Outbox.store(events)         ← même transaction
    │
    ├── commit()                     ← point de commit unique
    │
    └── retourne résultat
```

### Séquence avec exception métier

```
Application Service
    │
    ├── begin()
    │
    ├── [exécution]
    │
    ├── DomainException levée
    │
    ├── rollback()
    │
    └── traduit en réponse d'erreur (Interface Layer)
```

### Séquence avec exception de concurrence

```
Application Service
    │
    ├── begin()
    │
    ├── [exécution]
    │
    ├── ConcurrencyException levée
    │
    ├── rollback()
    │
    ├── retry (jusqu'à maxRetries)
    │       └── si maxRetries atteint → propager
    │
    └── [succès ou échec définitif]
```

---

## 4. Propagation

### Règle

**Une Command = une transaction indépendante.**

Chaque Command Handler ouvre sa propre transaction via `begin()`. Il n'y a pas d'héritage de transaction entre Command Handlers.

### Cas du Domain Event Handler

Un Domain Event Handler réagit post-commit (ADR-SA-017 §8). S'il dispatche une Command en réaction, cette Command ouvre sa propre transaction indépendante. Les transactions ne se propagent pas à travers les Event Handlers.

### Cas des Aggregates consultatifs

La lecture d'un Aggregate consultatif (ADR-SA-017 §5) s'effectue dans la transaction courante ouverte par le Command Handler. Elle ne crée pas de sous-transaction.

### Ce qui est interdit

| Interdit | Raison |
|---|---|
| Transaction imbriquée | Complexité irréductible, impossible de garantir les invariants de P-06 |
| Transaction partagée entre deux Command Handlers | Violation de la frontière de Use Case |
| Transaction sans `begin()` explicite | Les Repositories ne doivent pas ouvrir de transaction implicite |

---

## 5. Rollback

### Déclencheurs

| Exception | Comportement | Action |
|---|---|---|
| `DomainException` (règle métier violée) | Attendue — déterministe | `rollback()` → traduit en réponse par Interface Layer |
| `ConcurrencyException` (version conflict) | Attendue — transitoire | `rollback()` → retry (§6) |
| Toute autre `Throwable` | Inattendue — infra | `rollback()` → propager |

### Garanties du rollback

- Le rollback annule l'intégralité de la transaction : Aggregate + Domain Events (Outbox)
- Aucun état partiel n'est possible
- Aucun Domain Event n'est persisté si le rollback est déclenché
- `rollback()` est idempotent : appelé sur une transaction inactive, il ne lève pas d'exception

---

## 6. Retry

### Politique par type d'exception

| Exception | Retry ? | Politique |
|---|---|---|
| `DomainException` | Non | Déterministe — même entrée = même échec |
| `ConcurrencyException` | Oui | Maximum 3 tentatives, backoff exponentiel (50ms, 100ms, 200ms) |
| Erreurs d'infrastructure | Non | Retry à la couche Infrastructure (transport, pool de connexion) |

### Implémentation du retry

Le retry est la responsabilité de l'Application Service (ou d'un décorateur autour de lui). Il réexécute l'intégralité du Use Case — y compris `begin()` — depuis le début. Il ne réutilise pas l'état de la tentative précédente.

```
maxRetries = 3
attempt = 0

loop:
    try:
        begin()
        [execute use case]
        commit()
        return result
    catch ConcurrencyException:
        rollback()
        attempt++
        if attempt >= maxRetries: raise
        wait(backoff(attempt))
        continue loop
    catch DomainException:
        rollback()
        raise
    catch Throwable:
        rollback()
        raise
```

---

## 7. Isolation

### Niveau par défaut

**READ COMMITTED** — niveau par défaut de PostgreSQL.

Garantit qu'une lecture ne voit que des données committées. Acceptable pour la majorité des Use Cases de MedLink.

### Niveaux alternatifs

| Niveau | Usage | Condition |
|---|---|---|
| `READ COMMITTED` | Défaut | Tous les Use Cases sauf exception |
| `REPEATABLE READ` | Lecture cohérente de plusieurs Aggregates dans la même transaction | Justifié dans l'ADR du Use Case concerné |
| `SERIALIZABLE` | Prévention de phénomènes d'écriture concurrente complexes | Interdit sans ADR dédiée — impact performance |

### Optimistic Locking

L'escalade du niveau d'isolation est la solution de dernier recours. Le mécanisme préféré pour gérer la concurrence est le **verrouillage optimiste** au niveau de l'Aggregate (champ `version` incrémenté à chaque modification). La `ConcurrencyException` résultante déclenche le retry (§6).

---

## 8. Unit of Work

L'Application Service joue le rôle de coordinateur du Unit of Work :

1. Il ouvre la transaction (`begin()`)
2. Il détermine quel Aggregate est l'Aggregate principal
3. Il instrumente la séquence : load → method → save → store events
4. Il committe (`commit()`)

Le Unit of Work ne persiste pas d'état entre deux requêtes. Chaque Command Handler est une exécution stateless du Unit of Work.

### Ce que le Unit of Work ne fait pas

- Il ne suit pas les modifications de plusieurs Aggregates (P-06 — un seul Aggregate modifié)
- Il ne flush pas automatiquement à la fin de la transaction sans instruction explicite
- Il n'est pas un service singleton partagé entre Command Handlers

---

## 9. Interaction avec les Repositories

| Opération | Comportement dans la transaction |
|---|---|
| `Repository.load(id)` | Exécutée dans la transaction courante (isolation level actif) |
| `Repository.save(aggregate)` | Enqueues la persistance — s'exécute dans la transaction courante |
| `Outbox.store(events)` | Exécutée dans la même transaction que `save()` |

**Règle fondamentale :** les Repositories ne gèrent pas de transaction. Ils opèrent dans la transaction ouverte par l'Application Service. Un Repository appelé sans transaction active lève une exception d'infrastructure.

---

## 10. Point exact du commit

Le commit est appelé **une seule fois**, après :

| Opération | Ordre |
|---|---|
| `Aggregate.save()` — état persisté | 1 |
| `Outbox.store(events)` — événements persistés | 2 |
| `commit()` — transaction committée | 3 |

Et avant :

| Opération | Ordre |
|---|---|
| Domain Event dispatch | 4 — post-commit |
| Réponse retournée à l'appelant | 5 — post-commit |

Le commit ne peut pas être appelé avant que l'Outbox soit remplie. Il ne peut pas être appelé après le dispatch des événements.

---

## 11. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Aucune transaction imbriquée | Propagation MANDATORY-NEW — §4 |
| Aucun état partiel en cas de rollback | Atomicité Aggregate + Outbox — §3, §10 |
| Aucun Domain Event persisté après rollback | `rollback()` annule toute la transaction — §5 |
| Un seul commit par Command | Commit point unique — §10 |
| Les Repositories ne gèrent pas de transaction | Séparation des responsabilités — §9 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle — autorité supérieure |
| ADR-SA-017 | Runtime Architecture — contexte et responsabilité de l'Application Service |
| ADR-SA-019 | Domain Event Publication — politique de collecte et publication |
| ADR-SA-020 | Transactional Outbox — implémentation de l'Outbox.store() |
| ADR-SA-021 | Symfony Architecture — implémentation concrète du Transaction Manager |
