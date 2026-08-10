# ADR-SA-021 — Symfony Architecture

**Type :** Software Architecture Decision — Implémentation
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document définit le câblage Symfony des principes établis dans ADR-SA-017 à ADR-SA-020. Il est subordonné à ADR-SA-000 et à tous les documents de la Software Foundation v1.0.
**Périmètre :** Ce document est volontairement Symfony-spécifique. C'est le seul document de la Software Architecture qui peut nommer Symfony, Messenger, Doctrine, ou API Platform.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | Doctrine ne pénètre pas dans le Domain — §3 |
| P-02 — Aggregates gardiens | ✅ Conforme | Les Command Handlers n'ajoutent aucune logique métier |
| P-03 — Application Services orchestrent | ✅ Conforme | Les Handlers Messenger sont les Application Services — §2 |
| P-04 — Repositories retournent des Aggregates | ✅ Conforme | Les implémentations Doctrine retournent des Aggregates reconstitués — §3 |
| P-05 — Events immuables | ✅ Conforme | Les Domain Events sont readonly — §5 |
| P-06 — Une transaction | ✅ Conforme | doctrine_transaction middleware — §2 |
| P-07 — Publication post-commit | ✅ Conforme | DomainEventPublisherMiddleware post-commit — §5 |
| P-08 — Integration Events | ✅ Conforme | integration.bus séparé — §2 |
| P-09 — Frontières de plateforme | ✅ Conforme | Domain Events sur event.bus interne — §2 |
| P-10 — Read Models | ✅ Conforme | Query Handlers → DBAL direct — §4 |

---

## 1. Contexte

Les ADR-SA-017 à ADR-SA-020 définissent une architecture indépendante du framework. Cette ADR répond à la question : **comment Symfony implémente-t-il concrètement cette architecture ?**

Elle couvre :
- la configuration des bus Messenger,
- la stratégie de mapping Doctrine sans contamination du Domain,
- l'intégration API Platform,
- le câblage des ports et adaptateurs via le Dependency Injector,
- l'organisation des dossiers,
- les conventions de nommage.

---

## 2. Symfony Messenger — Configuration des Bus

### Définition des bus

```yaml
# config/packages/messenger.yaml
framework:
    messenger:
        buses:
            command.bus:
                middleware:
                    - app.middleware.transaction    # ouvre/committe/rollback — ADR-SA-018
                    - app.middleware.domain_events  # collecte et stocke les Domain Events — ADR-SA-019

            query.bus: ~

            event.bus:
                default_middleware: allow_no_handlers

            integration.bus:
                default_middleware: allow_no_handlers
```

### Rôle de chaque bus

| Bus | Rôle | Synchronisme |
|---|---|---|
| `command.bus` | Dispatche les Commands vers les Command Handlers | Synchrone |
| `query.bus` | Dispatche les Queries vers les Query Handlers | Synchrone |
| `event.bus` | Dispatche les Domain Events vers les Projectors et Handlers | Synchrone en process, asynchrone via transport |
| `integration.bus` | Dispatche les Integration Events vers les adaptateurs inter-plateforme | Asynchrone |

### Routage

```yaml
framework:
    messenger:
        routing:
            # Commands → synchrone, pas de transport
            App\Platforms\Clinical\Application\Command\*: command.bus

            # Queries → synchrone
            App\Platforms\Clinical\Application\Query\*: query.bus

            # Domain Events → dispatché depuis le relay Outbox
            App\Shared\Domain\Event\DomainEventInterface: event.bus

            # Integration Events → transport asynchrone
            App\Shared\Domain\Event\IntegrationEventInterface: integration.bus
```

### Middleware de transaction (TransactionMiddleware)

Le `app.middleware.transaction` implémente le `TransactionManagerPort` (ADR-SA-018) via `DoctrineTransactionManager` :

```
avant handle : begin()
après handle réussi : commit()
sur exception DomainException : rollback() → re-lève
sur exception concurrente : rollback() → retry (ADR-SA-018 §6)
sur autre exception : rollback() → re-lève
```

### Middleware de Domain Events (DomainEventPublisherMiddleware)

Le `app.middleware.domain_events` s'exécute **après** le commit (post-handle) :

```
après commit réussi :
    collecte les Domain Events accumulés
    INSERT INTO domain_events (Outbox) — ADR-SA-020
    (le relay dispatche ensuite vers event.bus — asynchrone)
```

---

## 3. Doctrine — Mapping sans contamination du Domain

### Problème

P-01 interdit toute dépendance Doctrine dans le Domain. Les attributs `#[Entity]`, `#[Column]`, `#[Id]` ne peuvent pas apparaître dans les classes du Domain.

### Solution — Mapping XML en Infrastructure

Les Aggregates du Domain sont des classes PHP pures. Le mapping Doctrine est déclaré en XML dans le répertoire Infrastructure, sans toucher aux classes du Domain.

```
src/Platforms/Clinical/Infrastructure/Persistence/Mapping/
└── ClinicalActivity.orm.xml
```

```xml
<!-- ClinicalActivity.orm.xml -->
<doctrine-mapping>
    <entity name="App\Platforms\Clinical\Domain\ClinicalActivity\ClinicalActivity"
            table="clinical_activities">
        <id name="id" type="clinical_activity_id" />
        <field name="status" type="string" column="status" />
        <field name="version" type="integer" column="version"
               options="{'default': 1}" />
        <!-- ... -->
    </entity>
</doctrine-mapping>
```

### Custom Types Doctrine

Les Value Objects du Domain sont mappés via des Custom Types Doctrine définis en Infrastructure :

```
src/Shared/Infrastructure/Doctrine/Type/
├── ClinicalActivityIdType.php   # UUID → ClinicalActivityId
├── PractitionerIdType.php
└── PatientIdType.php
```

Les Custom Types sont déclarés dans `config/packages/doctrine.yaml` :

```yaml
doctrine:
    dbal:
        types:
            clinical_activity_id: App\Shared\Infrastructure\Doctrine\Type\ClinicalActivityIdType
            practitioner_id: App\Shared\Infrastructure\Doctrine\Type\PractitionerIdType
```

### Repositories Doctrine

Les implémentations Doctrine implémentent les interfaces définies dans le Domain :

```
Domain (interface) :
    ClinicalActivityRepository {
        save(ClinicalActivity): void
        load(ClinicalActivityId): ClinicalActivity
    }

Infrastructure (implémentation) :
    DoctrineClinicalActivityRepository extends ServiceEntityRepository
        implements ClinicalActivityRepository
```

**Règle :** le Repository Doctrine ne retourne que l'Aggregate Root complet. Il n'expose aucune méthode de recherche partielle (P-04).

### Optimistic Locking

Le champ `version` est mappé via `<version>` en XML. Doctrine gère automatiquement l'incrémentation et la détection de conflit. La `OptimisticLockException` Doctrine est capturée par le TransactionMiddleware et déclenchera le retry (ADR-SA-018 §6).

---

## 4. Query Handlers — Lecture directe DBAL

Les Query Handlers n'utilisent pas de Repository. Ils accèdent directement à la base de données via DBAL (P-04, ADR-SA-009).

```
GetWorkspaceHandler {
    Connection $connection   ← DBAL, injecté via DI

    handle(GetWorkspaceQuery query):
        rows = connection.executeQuery(
            "SELECT ... FROM workspace_projection WHERE practitioner_id = ?",
            [query.practitionerId]
        )
        return WorkspaceReadModel::fromRows(rows)
}
```

**Règle :** les Query Handlers ne manipulent jamais d'Aggregate. Ils ne passent jamais par l'EntityManager. Ils ne produisent jamais de Domain Event.

---

## 5. Domain Events — Collecte et Relay

### Collecte dans l'Aggregate

Les Aggregates accumulent leurs Domain Events dans une liste interne via un trait `RecordsEvents` :

```php
// Shared/Domain/Event/RecordsEvents.php  (trait)
trait RecordsEvents
{
    private array $recordedEvents = [];

    protected function record(DomainEventInterface $event): void
    {
        $this->recordedEvents[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];
        return $events;
    }
}
```

**Note :** `releaseEvents()` est le mécanisme choisi pour satisfaire l'invariant d'ADR-SA-017 §8 ("les Domain Events doivent être collectables une fois la méthode terminée"). D'autres mécanismes (EventRecorder externe, Unit of Work centralisé) restent conformes à l'invariant — `releaseEvents()` est l'implémentation retenue pour Symfony.

### Domain Events — classe de base

```php
// Shared/Domain/Event/DomainEventInterface.php
interface DomainEventInterface
{
    public function eventId(): string;        // UUID unique — clé de déduplication
    public function occurredAt(): DateTimeImmutable;
    public function aggregateId(): string;
    public function aggregateType(): string;
}
```

Tous les Domain Events sont `readonly` (PHP 8.2+).

### Relay Outbox → event.bus

Le relay est un Symfony Command (`OutboxRelayCommand`) exécuté en continu (Supervisor) :

```
loop every 500ms:
    events = OutboxRepository.findPending(limit: 100)  // FOR UPDATE SKIP LOCKED
    for each event:
        bus.dispatch(event)
        OutboxRepository.markPublished(event.id)
```

Le relay utilise le `event.bus` pour dispatcher. Les Projectors et Handlers s'abonnent au `event.bus` via `#[AsMessageHandler(bus: 'event.bus')]`.

---

## 6. API Platform — Intégration

### Principe

API Platform est le **Primary Adapter** HTTP. Il ne contient aucune logique métier.

### State Processor (Commands)

```php
// Presentation/Api/Processor/CreateContributionProcessor.php
#[AsProcessor]
class CreateContributionProcessor implements ProcessorInterface
{
    public function process(mixed $data, Operation $operation, ...): mixed
    {
        $command = new ProduireContributionClinique(
            clinicalActivityId: new ClinicalActivityId($data->clinicalActivityId),
            patientId: new PatientId($data->patientId),
            auteurId: new PractitionerId($data->auteurId),
            // ...
        );

        $result = $this->commandBus->dispatch($command);

        return new ContributionCreatedResponse($result->contributionId());
    }
}
```

### State Provider (Queries)

```php
// Presentation/Api/Provider/WorkspaceProvider.php
#[AsProvider]
class WorkspaceProvider implements ProviderInterface
{
    public function provide(Operation $operation, array $uriVariables = [], ...): mixed
    {
        $query = new GetWorkspaceQuery(
            practitionerId: new PractitionerId($uriVariables['practitionerId'])
        );

        return $this->queryBus->dispatch($query);
    }
}
```

### API Resources

Les Resources API Platform sont des DTOs dans la couche Presentation. Elles ne sont jamais des Aggregates ni des Doctrine Entities.

```
src/Platforms/Clinical/Presentation/Api/Resource/
├── ContributionResource.php   ← DTO d'entrée (Command side)
└── WorkspaceResource.php      ← DTO de sortie (Query side)
```

---

## 7. Dependency Injection — Câblage des Ports

### Ports → Adaptateurs

```yaml
# config/services.yaml
services:
    # Transaction Manager
    App\Shared\Application\Port\TransactionManagerPort:
        alias: App\Shared\Infrastructure\Doctrine\DoctrineTransactionManager

    # Domain Event Publisher (Outbox store)
    App\Shared\Application\Port\DomainEventPublisherPort:
        alias: App\Shared\Infrastructure\Messenger\DomainEventPublisherMiddleware

    # Repository bindings — Clinical Platform
    App\Platforms\Clinical\Domain\ClinicalActivity\ClinicalActivityRepository:
        alias: App\Platforms\Clinical\Infrastructure\Persistence\DoctrineClinicalActivityRepository

    App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContributionRepository:
        alias: App\Platforms\Clinical\Infrastructure\Persistence\DoctrineClinicalContributionRepository
```

### Convention d'autowiring

Par défaut : `autowire: true`, `autoconfigure: true` pour `src/`. Les surcharges explicites dans `services.yaml` se limitent aux bindings d'interfaces et aux configurations spéciales.

---

## 8. Organisation des dossiers

```
src/
├── Kernel/                                          # Platform Kernel (CLAUDE.md)
│
├── Platforms/
│   └── Clinical/
│       ├── Domain/
│       │   ├── ClinicalActivity/
│       │   │   ├── ClinicalActivity.php             # Aggregate Root
│       │   │   ├── ClinicalActivityId.php           # Value Object
│       │   │   ├── ClinicalActivityRepository.php   # Interface
│       │   │   ├── Exception/
│       │   │   │   └── ClinicalActivityNotActive.php
│       │   │   └── Event/
│       │   │       └── ClinicalActivityStarted.php
│       │   └── ClinicalContribution/
│       │       ├── ClinicalContribution.php
│       │       ├── ClinicalContributionId.php
│       │       ├── ClinicalContributionRepository.php
│       │       └── Event/
│       │           ├── ContributionCliniqueCreée.php
│       │           └── ContributionCliniqueAmendée.php
│       │
│       ├── Application/
│       │   ├── Command/
│       │   │   └── ProduireContributionClinique/
│       │   │       ├── ProduireContributionCliniqueCommand.php
│       │   │       └── ProduireContributionCliniqueHandler.php
│       │   └── Query/
│       │       └── GetWorkspace/
│       │           ├── GetWorkspaceQuery.php
│       │           ├── GetWorkspaceHandler.php
│       │           └── WorkspaceReadModel.php
│       │
│       ├── Infrastructure/
│       │   ├── Persistence/
│       │   │   ├── DoctrineClinicalActivityRepository.php
│       │   │   ├── DoctrineClinicalContributionRepository.php
│       │   │   ├── Mapping/
│       │   │   │   ├── ClinicalActivity.orm.xml
│       │   │   │   └── ClinicalContribution.orm.xml
│       │   │   └── Projection/
│       │   │       └── WorkspaceProjection.php      # Projector
│       │   └── EventBus/
│       │       └── ClinicalIntegrationEventPublisher.php
│       │
│       └── Presentation/
│           └── Api/
│               ├── Resource/
│               │   └── ContributionResource.php
│               ├── Processor/
│               │   └── CreateContributionProcessor.php
│               └── Provider/
│                   └── WorkspaceProvider.php
│
└── Shared/
    ├── Domain/
    │   └── Event/
    │       ├── DomainEventInterface.php
    │       └── RecordsEvents.php                    # trait Aggregate
    │
    ├── Application/
    │   └── Port/
    │       ├── TransactionManagerPort.php
    │       └── DomainEventPublisherPort.php
    │
    └── Infrastructure/
        ├── Doctrine/
        │   ├── DoctrineTransactionManager.php
        │   ├── OutboxRepository.php
        │   └── Type/
        │       └── ClinicalActivityIdType.php
        └── Messenger/
            ├── TransactionMiddleware.php
            ├── DomainEventPublisherMiddleware.php
            └── OutboxRelayCommand.php               # Symfony Console Command
```

---

## 9. Conventions de nommage

| Concept | Convention | Exemple |
|---|---|---|
| Command | `{Verbe}{Nom}Command` | `ProduireContributionCliniqueCommand` |
| Command Handler | `{Verbe}{Nom}Handler` | `ProduireContributionCliniqueHandler` |
| Query | `Get{Nom}Query` | `GetWorkspaceQuery` |
| Query Handler | `Get{Nom}Handler` | `GetWorkspaceHandler` |
| Read Model | `{Nom}ReadModel` | `WorkspaceReadModel` |
| Domain Event | `{Aggregate}{ParticiPePassé}` | `ContributionCliniqueCreée` |
| Aggregate Root | `{Nom}` | `ClinicalActivity` |
| Value Object | `{Nom}` | `ClinicalActivityId` |
| Repository (interface) | `{Aggregate}Repository` | `ClinicalActivityRepository` |
| Repository (Doctrine) | `Doctrine{Aggregate}Repository` | `DoctrineClinicalActivityRepository` |
| Projector | `{Projection}Projection` | `WorkspaceProjection` |
| API Resource | `{Nom}Resource` | `ContributionResource` |
| State Processor | `{Action}{Nom}Processor` | `CreateContributionProcessor` |
| State Provider | `{Nom}Provider` | `WorkspaceProvider` |
| Middleware | `{Rôle}Middleware` | `TransactionMiddleware` |

---

## 10. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Doctrine ne pénètre pas dans le Domain | Mapping XML en Infrastructure — §3 |
| Une transaction par Command | `TransactionMiddleware` sur `command.bus` — §2 |
| Domain Events publiés post-commit uniquement | `DomainEventPublisherMiddleware` post-handle — §5 |
| Les Query Handlers ne touchent pas l'EntityManager | DBAL direct — §4 |
| Les API Resources ne sont pas des Aggregates | DTOs dans Presentation — §6 |
| Les interfaces Domain sont câblées à leurs adaptateurs | DI aliases explicites — §7 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle — autorité supérieure |
| ADR-SA-017 | Runtime Architecture — modèle d'exécution que ce document implémente |
| ADR-SA-018 | Transaction Management — `TransactionMiddleware` et retry |
| ADR-SA-019 | Domain Event Publication — politique implémentée par `DomainEventPublisherMiddleware` |
| ADR-SA-020 | Transactional Outbox — `OutboxRepository` et `OutboxRelayCommand` |
| ADR-SA-009 | Persistence Technology Policy — DBAL pour les Query Handlers |
| ADR-SA-011 | Read Model Strategy — Projections et accès lecture |
| ADR-0003 | Hexagonal Architecture — ports et adaptateurs câblés ici |
