# MedLink Engineering Handbook

**Version**: 1.0
**Status**: Active
**Audience**: Engineers, AI Agents

---

> This handbook does not repeat the ADRs. It explains how to use them.
> Read an ADR to understand *why* a decision was made.
> Read this handbook to understand *how* to apply it.

---

## Part I — Vision

---

### Chapter 1 — Why MedLink Exists

MedLink is not medical software.

MedLink is a platform that organises the work of healthcare actors.

**Core mission:** Reduce the cognitive effort required to understand a clinical situation,
so practitioners can dedicate their energy to reasoning, decision-making, and their
relationship with patients.

This mission drives every architectural decision. When a feature is proposed, the first
question is not "can we build this?" — it is "does this reduce cognitive effort for the
practitioner, or does it add friction?"

The answer determines whether the feature should exist at all.

### Chapter 2 — The 20-Year Vision

The Platform Kernel must be valid in twenty years.

This is not a metaphor. It means: every class in `src/Kernel/` must survive the
replacement of every business platform, every framework version, and every database.

The platforms built on top of the Kernel will change. Clinical today. Learning, Conference,
Community, Research, AI, Marketplace in the future. The Kernel must remain untouched by
each of these additions.

Every architectural decision must be evaluated against this question:
*"In twenty years, will this decision have been a constraint or a foundation?"*

Decisions that embed framework assumptions, domain vocabulary, or technology specifics into
the Kernel are constraints. Decisions that protect the Kernel's independence are foundations.

### Chapter 3 — Engineering Values

These five values, in this order, govern every technical decision.

**1. Simplicity**
The simplest solution that correctly solves the problem is always preferred. Complexity
must be justified by a concrete requirement, not by theoretical future needs.

**2. Explicit**
Code that shows what it does is better than code that hides it. SQL over ORM. Direct
dependency injection over service locators. Named ports over generic interfaces. If a
reader must trace five layers of abstraction to understand what happens, the abstraction
is wrong.

**3. Robustness**
Correctness under failure matters more than convenience under success. The Outbox Pattern
instead of fire-and-forget. UPSERT instead of INSERT. At-least-once instead of
at-most-once. The failure case must be designed, not discovered in production.

**4. Testability**
Every component must be testable in isolation. The Domain layer must be testable without
a database. Application Handlers must be testable by mocking Ports. Infrastructure must
be tested with a real database. Untestable code is unfinished code.

**5. Evolvability**
The architecture must remain changeable. Platforms are isolated. The Kernel is protected.
Domain models evolve independently of persistence schemas. Read Models evolve
independently of Aggregates. The cost of change must stay flat over time.

---

## Part II — Architecture: How to Use the ADRs

---

The ADRs live in `docs/architecture/`. Each one answers *why* a decision was made.
This part answers *when* to consult each one and what question it answers for you.

### SA-005 — Application & CQRS Architecture

**Consult when:** Creating a Command, Query, Handler, or Port.

**What it tells you:**
- D-003: who owns the transaction boundary (the Runtime, not the Handler)
- D-005: Query Handlers access Read Models only — never Repositories
- D-008: Domain Events are collected during the transaction and published after commit
- The Handler never knows the Infrastructure implementation — only the Port

**Impact:** Every Handler you write must follow the collection pattern:
`repository.persist()` then `eventCollector.collect($aggregate->pullPendingEvents())`.

---

### SA-006 — Event Driven Architecture

**Consult when:** Creating a Projector, subscribing to Domain Events, planning a rebuild.

**What it tells you:**
- Projections are disposable — they are rebuilt from the Outbox
- A Projector is the only writer to its Projection table
- Domain Events carry the minimum payload for Projection maintenance

---

### SA-007 — Persistence Architecture

**Consult when:** Creating a Repository implementation or migration.

**What it tells you:**
- D-001: one Repository per Aggregate — no shared Repositories
- D-006: mapping lives inside the Repository implementation
- D-009: the Domain is persistence-ignorant — no annotations, no base classes

---

### SA-008 — Model Existence Principle

**Consult when:** About to create ANY new class.

**The single question to ask:** *If I removed this class and inlined its content into
its consumer, would a deptrac layer boundary be violated?*

If yes: create the class. If no: do not create the class.

**Impact:** No Projection Row classes. No Mapper classes unless the mapping is complex
and reused. No Wrapper classes around existing classes with no added behaviour.

---

### SA-009 — Persistence Technology Policy

**Consult when:** Writing any code that touches the database.

**Non-negotiable rules:**
- Domain: zero Doctrine dependency
- Application: zero persistence dependency
- Write Side: DBAL only
- Projection writes: DBAL + UPSERT (`ON CONFLICT DO UPDATE`)
- Read Side: DBAL → `array` → View DTO directly — no intermediate class

---

### SA-010 — Reliable Event Delivery

**Consult when:** Modifying the event publication path, implementing a Projector, planning a rebuild.

**What it tells you:**
- Domain Events are written to `domain_event_outbox` in the same transaction as the Aggregate
- The Outbox Worker publishes them to `event.bus` asynchronously
- Delivery is at-least-once — idempotence is mandatory in every Projector
- Replay is possible by resetting `status = 'pending'` for selected outbox rows

---

### SA-011 — Read Model Strategy

**Consult when:** Creating a ViewRepository, designing a Projection table, implementing pagination.

**What it tells you:**
- Pagination: keyset on `(occurred_at, id)` — no offset/limit
- Index ownership: the ViewRepository defines its indexes in the same PR
- One Projection per access pattern
- JOINs and denormalisation are authorised and encouraged

---

### SA-012 — Platform Integration

**Consult when:** A feature needs data from another platform, or produces events for another platform.

**What it tells you:**
- Domain Events never cross platform boundaries
- Integration Events are the public contract between platforms
- No platform reads another platform's database tables — ever
- The ownership table defines which platform owns each concept

---

## Part III — Platform Architecture

---

### Directory Structure

```
src/
├── Kernel/                          # Platform Kernel — domain-agnostic forever
│   └── Domain/
│       └── Event/
│           └── BusinessEvent.php
│
├── Platforms/
│   └── Clinical/                    # One directory per Platform
│       ├── Domain/                  # Pure PHP — zero framework dependency
│       │   └── ClinicalContribution/
│       │       ├── ClinicalContribution.php        # Aggregate Root
│       │       ├── ContributorRole.php             # Entity on the Aggregate
│       │       ├── ClinicalContent.php             # Value Object on the Aggregate
│       │       ├── ValueObject/
│       │       │   ├── ClinicalContributionId.php
│       │       │   ├── CareRecordId.php
│       │       │   ├── ContributionStatus.php      # Pure PHP enum
│       │       │   ├── ContributionTimestamp.php
���       │       │   └── ClinicalText.php
│       │       ├── Event/
│       │       │   ├── ClinicalContributionCreated.php
│       │       │   ├── ClinicalContributionValidated.php
│       │       │   └── ClinicalContributionApproved.php
│       │       └── Exception/
│       │           ├── ContributionNotInDraftException.php
│       │           └── SelfApprovalAttemptedException.php
│       │
│       ├── Application/             # Use cases — depends on Domain + Shared only
│       │   ├── Command/             # Immutable intent carriers
│       │   │   ├── CreateClinicalContribution.php
│       │   │   ├── ValidateClinicalContribution.php
│       │   │   └── ApproveClinicalContribution.php
│       │   ├── CommandHandler/      # One Handler per Command
│       │   │   ├── CreateClinicalContributionHandler.php
│       │   │   ├── ValidateClinicalContributionHandler.php
│       │   │   └── ApproveClinicalContributionHandler.php
│       │   ├── Query/               # Immutable retrieval intents
│       │   │   ├── GetPatientTimeline.php
│       │   │   └── GetClinicalContributionDetail.php
│       │   ├── QueryHandler/        # One Handler per Query
│       │   │   ├── GetPatientTimelineHandler.php
│       │   │   └── GetClinicalContributionDetailHandler.php
│       │   ├── Port/                # Interfaces only — no implementations
│       │   │   ├── ClinicalContributionRepositoryPort.php  # Write side
│       │   │   ├── PatientTimelineReadModelPort.php         # Read side
│       │   │   ├── ClinicalContributionDetailReadModelPort.php
│       │   │   └── DomainEventCollectorPort.php
│       │   ├── ReadModel/           # View DTOs — immutable data shapes
│       │   │   ├── PatientTimelineView.php
│       │   │   ├── PatientTimelineEntry.php
│       │   │   └── ClinicalContributionDetailView.php
│       │   └── IntegrationEvent/    # Public event contracts (future)
│       │       └── v1/
│       │
│       └── Infrastructure/          # Framework adapters — depends on Application
│           ├── Persistence/
│           │   ├── Repository/      # Aggregate persistence — DBAL
│           │   │   └── ClinicalContributionRepository.php
│           │   ├── Projection/      # Event handlers — write Projection tables via DBAL UPSERT
│           │   │   ├── PatientTimelineProjection.php
│           │   │   └── ClinicalContributionDetailProjection.php
│           │   └── ReadModel/       # ViewRepository — DBAL SELECT → array → DTO
│           │       ├── PatientTimelineReadModel.php
│           │       └── ClinicalContributionDetailReadModel.php
│           ├── EventBus/
│           │   └── DomainEventCollector.php   # Implements CollectorPort + FlushablePort
│           └── Api/
│               ├── Resource/        # API Platform DTOs — HTTP contract only
│               ├── StateProcessor/  # Command dispatchers
│               └── StateProvider/   # Query dispatchers
│
└── Shared/                          # Cross-platform contracts
    ├── Domain/
    │   └── ValueObject/
    │       ├── ActorId.php
    │       └── ContextId.php
    ├── Application/
    │   ├── Event/
    │   │   └── DomainEvent.php           # Technical transport — NOT a Kernel concept
    │   └── Port/
    │       ├── DomainEventPublisherPort.php
    │       ├── DomainEventFlushablePort.php
    │       └── Workspace/
    └── Infrastructure/
        └── Messenger/
            ├── DomainEventBusPublisher.php
            └── DomainEventPublisherMiddleware.php
```

### Layer Dependencies (enforced by deptrac)

```
Domain        → Kernel, Shared.Domain only
Application   → Domain, Shared
Infrastructure→ Application, Domain, External (Symfony, Doctrine, API Platform)
Kernel        → nothing
Shared        → Kernel, External
```

The Domain layer has **zero** dependency on Application or Infrastructure.
The Application layer has **zero** dependency on Infrastructure.
Violations fail the CI build.

---

## Part IV — DDD Building Blocks

---

### Aggregate

**Use when:** A cluster of objects must change together under a single invariant.

**Do not use when:** The object has no invariants to protect (use a Value Object or a
plain data class instead).

An Aggregate has:
- A private constructor — created only via named factory methods
- Invariant enforcement before any state change
- Domain Event recording via `pullPendingEvents()`
- No persistence knowledge

```php
// Correct — Aggregate with named factory, invariant, event recording
final class ClinicalContribution
{
    private array $pendingEvents = [];

    private function __construct(
        private readonly ClinicalContributionId $id,
        private ContributionStatus $status,
        // ...
    ) {}

    public static function create(...): self
    {
        // invariant checks
        $contribution = new self(...);
        $contribution->record(new ClinicalContributionCreated(...));
        return $contribution;
    }

    public function validate(PractitionerId $validatingPractitionerId): void
    {
        if (!$this->status->isDraft()) {
            throw new ContributionNotInDraftException(...);
        }
        $this->status = ContributionStatus::Validated;
        $this->record(new ClinicalContributionValidated(...));
    }

    public function pullPendingEvents(): array
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];
        return $events;
    }

    private function record(object $event): void
    {
        $this->pendingEvents[] = $event;
    }
}
```

**Keep Aggregates small.** An Aggregate that grows beyond 3-4 methods or 5-6 properties is
a signal that it may need to be split.

---

### Value Object

**Use when:** Identity does not matter — only the value matters.

**Do not use when:** You need to track lifecycle (use an Entity or Aggregate instead).

Value Objects are immutable. Two Value Objects with the same value are equal.

```php
// Correct — immutable, self-validating, no identity
final readonly class ClinicalText
{
    public function __construct(public readonly string $value)
    {
        if (trim($value) === '') {
            throw new InvalidClinicalTextException('Clinical text cannot be empty.');
        }
        if (mb_strlen($value) > 10000) {
            throw new InvalidClinicalTextException('Clinical text exceeds maximum length.');
        }
    }
}
```

Value Objects never depend on Infrastructure. They are tested without a database.

---

### Domain Event

**Use when:** A state change has business significance and downstream consumers need to react.

**Do not use when:** It is infrastructure noise (retry, cache invalidation, technical signal).

Naming pattern: `{Aggregate}{PastTense}` — `ClinicalContributionCreated`, not
`ContributionWasCreatedEvent`.

Domain Events:
- Are immutable (`readonly` properties)
- Carry only what is needed by Projectors — no full Aggregate state
- Are recorded inside the Aggregate and collected by the Handler

```php
final readonly class ClinicalContributionCreated
{
    public function __construct(
        public ClinicalContributionId $clinicalContributionId,
        public CareRecordId $careRecordId,
        public PractitionerId $contributingPractitionerId,
        public ContributionTimestamp $occurredAt,
    ) {}
}
```

---

### Repository

**Use when:** Persisting and retrieving an Aggregate Root.

**Do not use when:** You need to query data for display (use a ViewRepository instead).

Repository Port (Application layer — interface):
```php
interface ClinicalContributionRepositoryPort
{
    public function persist(ClinicalContribution $contribution): void;
    public function findById(ClinicalContributionId $id): ClinicalContribution;
}
```

Repository Implementation (Infrastructure layer — DBAL):
- Uses `ReflectionProperty` to read private Aggregate state without accessors
- Executes explicit SQL via DBAL
- Is the only class that translates between Aggregate and database representation

---

### Domain Service

**Use when:** Business logic spans multiple Aggregates and belongs to neither.

**Do not use when:** The logic can live in an Aggregate method (which is almost always).

Domain Services are rare. If you find yourself creating one for every feature, the
Aggregate design is probably wrong.

---

### Factory

**Use when:** Aggregate creation is complex — multiple dependencies, conditional
construction, or external data needed.

**Do not use when:** The constructor or a named factory method on the Aggregate handles it.

Factories live in the Domain layer. They depend only on Domain types.

---

## Part V — CQRS

---

### The Two Paths

CQRS means one thing: writes and reads never share a class.

A Command Handler never reads from a Read Model.
A Query Handler never writes to an Aggregate or fires a Domain Event.
A Repository Port is never injected into a Query Handler.
A Read Model Port is never injected into a Command Handler.

deptrac enforces these rules. Violations fail the build.

---

### Write Path — Full Example

```
POST /api/v1/clinical/contributions
    ↓
ClinicalContributionStateProcessor (Infrastructure/Api)
    dispatches: CreateClinicalContribution command
    ↓
command.bus
    middleware: DomainEventPublisherMiddleware → writes events to domain_event_outbox
    middleware: doctrine_transaction → wraps everything below in a transaction
    ↓
CreateClinicalContributionHandler (Application/CommandHandler)
    1. ClinicalContribution::create(...)       → records ClinicalContributionCreated
    2. $this->repository->persist($contrib)   → DBAL INSERT
    3. $this->eventCollector->collect(         → holds events for post-commit
           $contrib->pullPendingEvents()
       )
    ↓
doctrine_transaction commits
    ↓
DomainEventPublisherMiddleware writes events to domain_event_outbox (same transaction)
    ↓
PostgreSQL transaction committed atomically:
    ├── clinical_contributions (Aggregate state)
    └── domain_event_outbox (Domain Events)
```

---

### Read Path — Full Example

```
GET /api/v1/patients/{careRecordId}/timeline?limit=20
    ↓
PatientTimelineStateProvider (Infrastructure/Api)
    dispatches: GetPatientTimeline query
    ↓
query.bus (no middleware, no transaction)
    ↓
GetPatientTimelineHandler (Application/QueryHandler)
    calls: $this->readModel->findByPatient($query->careRecordId, $query->cursor)
    ↓
PatientTimelineReadModelPort (Application/Port — interface)
    ↓
PatientTimelineReadModel (Infrastructure/Persistence/ReadModel — DBAL)
    executes: SELECT ... FROM patient_timeline WHERE care_record_id = ?
              AND (occurred_at, id) < (cursor_occurred_at, cursor_id)
              ORDER BY occurred_at DESC, id DESC LIMIT 20
    maps: array → PatientTimelineEntry → PatientTimelineView
    ↓
PatientTimelineView DTO returned to StateProvider
    ↓
StateProvider returns View DTO to API Platform for serialisation
    ↓
HTTP 200 JSON response
```

---

## Part VI — Event Driven: The Full Flow

---

This is the most important diagram in the project. Every event-driven feature follows
this exact path.

```
┌─────────────────────────────────────────────────────────────┐
│  USER REQUEST                                               │
│                                                             │
│  POST /api/v1/clinical/contributions                        │
└───────────────────────────┬─────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  PRESENTATION LAYER (Infrastructure)                        │
│                                                             │
│  ClinicalContributionStateProcessor                         │
│  → builds CreateClinicalContribution command                │
│  → dispatches to command.bus                                │
└───────────────────────────┬─────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  COMMAND BUS (Symfony Messenger)                            │
│                                                             │
│  Middleware 1: DomainEventPublisherMiddleware               │
│  Middleware 2: doctrine_transaction ← opens transaction     │
└───────────────────────────┬─────────────────────────────────┘
                            │ (inside transaction)
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  APPLICATION LAYER                                          │
│                                                             │
│  CreateClinicalContributionHandler                          │
│  1. ClinicalContribution::create()                          │
│     → records ClinicalContributionCreated (pending)         │
│  2. repository.persist(contribution)                        │
│     → DBAL INSERT INTO clinical_contributions               │
│  3. eventCollector.collect(events)                          │
│     → holds events in memory                                │
└───────────────────────────┬─────────────────────────────────┘
                            │ (transaction commits)
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  OUTBOX WRITE (DomainEventPublisherMiddleware)               │
│                                                             │
│  INSERT INTO domain_event_outbox                            │
│  (same transaction — atomic with Aggregate state)           │
│                                                             │
│  PostgreSQL commits:                                        │
│  ├── clinical_contributions ✓                               │
│  └── domain_event_outbox   ✓                                │
└───────────────────────────┬─────────────────────────────────┘
                            │ (HTTP response returned — 201 Created)
                            │
                            ▼  (asynchronous from here)
┌─────────────────────────────────────────────────────────────┐
│  OUTBOX WORKER (Symfony Messenger worker process)           │
│                                                             │
│  SELECT FROM domain_event_outbox WHERE status = 'pending'   │
│  ORDER BY occurred_at ASC                                   │
│  → for each row: dispatch event to event.bus                │
│  → on success: UPDATE status = 'published'                  │
│  → on failure: retry × 3, then DLQ                          │
└───────────────────────────┬─────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  EVENT BUS (Symfony Messenger)                              │
│                                                             │
│  ClinicalContributionCreated dispatched                     │
│  → all subscribed Projectors receive it                     │
└──────────────────┬────────────────────┬─────────────────────┘
                   │                    │
                   ▼                    ▼
┌──────────────────────────┐  ┌──────────────────────────────┐
│  PatientTimelineProjector │  │  ClinicalContribDetailProjector│
│                          │  │                              │
│  DBAL UPSERT:            │  │  DBAL UPSERT:                │
│  INSERT INTO             │  │  INSERT INTO                 │
│  patient_timeline        │  │  clinical_contribution_detail│
│  ON CONFLICT DO UPDATE   │  │  ON CONFLICT DO UPDATE       │
└──────────────────────────┘  └──────────────────────────────┘
                            │
                            │  (next user request — independent)
                            ▼
┌─────────────────────────────────────────────────────────────┐
│  READ REQUEST                                               │
│                                                             │
│  GET /api/v1/patients/{id}/timeline                         │
│  → PatientTimelineStateProvider                             │
│  → GetPatientTimeline query → query.bus                     │
│  → GetPatientTimelineHandler                                │
│  → PatientTimelineReadModel (DBAL SELECT)                   │
│  → array → PatientTimelineView DTO                          │
│  → HTTP 200 JSON                                            │
└─────────────────────────────────────────────────────────────┘
```

**Key invariant:** The HTTP response (201 Created) is returned before Projectors execute.
The Read Side reflects the write after eventual consistency — not immediately.
This is correct and by design.

---

## Part VII — Symfony Organisation

---

### Service Container

Services are autowired by default. Explicit wiring in `config/services.yaml` is required
only when:
- A service has multiple implementations of the same interface (Port disambiguation)
- Tagged iterators are used (WorkspaceContributor, AttentionProvider, WorkItemProvider)
- A specific bus must be injected (`@command.bus`, `@event.bus`)

### Messenger Buses

```yaml
# config/packages/messenger.yaml
framework:
    messenger:
        default_bus: command.bus
        buses:
            command.bus:
                middleware:
                    - App\Shared\Infrastructure\Messenger\DomainEventPublisherMiddleware
                    - doctrine_transaction

            query.bus: ~

            event.bus:
                default_middleware: allow_no_handlers

            integration.bus:                    # future — inter-platform
                default_middleware: allow_no_handlers
```

### Message Routing

| Message type | Bus | Synchronous? | Middleware |
|---|---|---|---|
| Command | command.bus | Yes | Outbox write + transaction |
| Query | query.bus | Yes | None |
| Domain Event | event.bus | No (async worker) | None |
| Integration Event | integration.bus | No (async worker) | None |

### deptrac

Run before every commit:
```bash
vendor/bin/deptrac analyse
```

Zero violations is mandatory. An `allowed` violation requires documentation in
`deptrac.yaml` with a comment explaining the exception.

---

## Part VIII — PostgreSQL Conventions

---

### Naming

| Element | Convention | Example |
|---|---|---|
| Table | snake_case, plural | `clinical_contributions` |
| Column | snake_case | `care_record_id` |
| Primary key | `id UUID` | `id UUID PRIMARY KEY DEFAULT gen_random_uuid()` |
| Foreign key | `{table_singular}_id` | `care_record_id` |
| Index | `idx_{table}_{columns}` | `idx_patient_timeline_care_record` |
| Timestamp | always `TIMESTAMPTZ` | `occurred_at TIMESTAMPTZ NOT NULL` |

### Mandatory Columns

Every Aggregate table:
```sql
id          UUID        PRIMARY KEY DEFAULT gen_random_uuid(),
created_at  TIMESTAMPTZ NOT NULL DEFAULT NOW(),
updated_at  TIMESTAMPTZ NOT NULL DEFAULT NOW()
```

Every Projection table:
```sql
id          UUID        PRIMARY KEY,  -- same as Aggregate ID
occurred_at TIMESTAMPTZ NOT NULL,     -- from Domain Event
created_at  TIMESTAMPTZ NOT NULL DEFAULT NOW(),
updated_at  TIMESTAMPTZ NOT NULL DEFAULT NOW()
```

### UPSERT Template (Projection writes)

```sql
INSERT INTO patient_timeline (id, care_record_id, clinical_text, status, occurred_at)
VALUES (:id, :careRecordId, :clinicalText, :status, :occurredAt)
ON CONFLICT (id) DO UPDATE SET
    clinical_text = EXCLUDED.clinical_text,
    status        = EXCLUDED.status,
    updated_at    = NOW()
WHERE patient_timeline.occurred_at <= EXCLUDED.occurred_at
```

The `WHERE` clause on the UPSERT prevents an older event replay from overwriting
a newer state. Always include it when `occurred_at` is available.

### Migrations

- Migrations are **manual** — never auto-generated from Doctrine entities
- Each migration is reviewed in the PR alongside the Repository or Projector it supports
- Migrations run automatically on deployment: `doctrine:migrations:migrate --no-interaction`
- Rollback migrations must be written for every destructive change (column drop, type change)

### Indexes

Define indexes in the migration that creates the table. The ViewRepository that queries
the table owns the index definition. At minimum:

```sql
-- For temporal keyset pagination
CREATE INDEX idx_patient_timeline_care_record
    ON patient_timeline (care_record_id, occurred_at DESC, id DESC);
```

---

## Part IX — API Platform

---

### The Three Components

**Resource** — the HTTP contract. A DTO that represents what the API exposes.
No business logic. No domain types. Primitive PHP types only.

**State Provider** — handles GET requests. Builds a Query and dispatches it to
`query.bus`. Maps the returned View DTO to a Resource if needed.

**State Processor** — handles POST/PUT/PATCH/DELETE. Builds a Command and dispatches
it to `command.bus`. Returns nothing or a confirmation.

### What Never Appears in API Components

- `EntityManagerInterface`
- `ClinicalContributionRepositoryPort` or any Repository
- Domain Aggregate classes
- Domain Event classes
- Any business logic or invariant check

The API layer is HTTP translation only. The business logic lives in the Application
and Domain layers.

### Example

```php
// Correct — State Processor dispatches a Command only
final class ClinicalContributionStateProcessor
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {}

    public function process(ClinicalContributionResource $data, array $context = []): void
    {
        $this->commandBus->dispatch(new CreateClinicalContribution(
            clinicalContributionId: ClinicalContributionId::generate(),
            careRecordId: new CareRecordId($data->careRecordId),
            // ...
        ));
    }
}
```

---

## Part X — Messenger: Three Buses

---

### command.bus

- **Purpose:** Execute a write use case
- **Synchronous:** Yes — the caller waits for the Handler to complete
- **Middleware stack (in order):**
  1. `DomainEventPublisherMiddleware` — writes Domain Events to the Outbox
  2. `doctrine_transaction` — wraps the Handler in a PostgreSQL transaction
- **Rule:** Only Command objects are dispatched here. Never Domain Events.

### query.bus

- **Purpose:** Execute a read use case
- **Synchronous:** Yes — the caller waits for the View DTO
- **Middleware stack:** None
- **Rule:** Only Query objects are dispatched here. Never Commands or Events.

### event.bus

- **Purpose:** Deliver Domain Events to Projectors
- **Synchronous:** No — the Outbox Worker dispatches here asynchronously
- **Middleware stack:** `allow_no_handlers` (events may have zero Projectors — not an error)
- **Rule:** Only Domain Event objects are dispatched here. Never Commands or Queries.

### integration.bus

- **Purpose:** Deliver Integration Events to other platforms
- **Synchronous:** No — asynchronous
- **Middleware stack:** `allow_no_handlers`
- **Rule:** Only Integration Event objects (implementing `IntegrationEventInterface`) are
  dispatched here. Never Domain Events.

---

## Part XI — Quality

---

### PR Checklist (author)

Before opening a Pull Request, verify every item:

**Architecture**
- [ ] Every new class passes the Existence Test (ADR-SA-008)
- [ ] No Domain layer dependency on Doctrine, Symfony, or Application
- [ ] No Application layer dependency on Infrastructure implementations
- [ ] deptrac: zero violations (`vendor/bin/deptrac analyse`)

**Write Side**
- [ ] Command Handler calls `repository.persist()` then `eventCollector.collect()`
- [ ] No Read Model Port in any Command Handler
- [ ] Repository uses DBAL only — no Doctrine ORM

**Read Side**
- [ ] Query Handler calls Read Model Port only — no Repository Port
- [ ] ViewRepository maps `array → DTO` directly — no intermediate class
- [ ] Pagination uses keyset on `(occurred_at, id)` for temporal lists

**Projections**
- [ ] Every Projector uses UPSERT (`ON CONFLICT DO UPDATE`)
- [ ] Projector is idempotent — receiving the same event twice produces the same result

**Domain Events**
- [ ] Domain Events written to `domain_event_outbox` in the same transaction
- [ ] No Domain Event crosses a platform boundary

**Tests**
- [ ] Unit tests for Aggregate — no database
- [ ] Integration tests for Repository and ViewRepository — real database
- [ ] Integration tests for Projectors — real database
- [ ] All tests pass: `php bin/phpunit`

**Migration**
- [ ] Migration file included if new table or column
- [ ] Indexes included in the migration
- [ ] Migration reviewed alongside the Repository or Projector it supports

---

### Review Checklist (reviewer)

- [ ] Does every new class pass the Existence Test?
- [ ] Does the PR description state the justification for any new model class?
- [ ] Are there any Doctrine ORM imports?
- [ ] Are there any cross-layer dependency violations not caught by deptrac?
- [ ] Does any Projector INSERT without `ON CONFLICT`?
- [ ] Does any Query Handler access a Repository Port?
- [ ] Does any Command Handler access a Read Model Port?
- [ ] Are there integration tests for the new persistence code?

---

### Architecture Checklist (before any new component)

Answer these eight questions before writing a single line of code:

1. Which Platform?
2. Which Domain Context?
3. Which Aggregate is affected?
4. Is this a Command (write) or a Query (read)?
5. Which Domain Events does it produce?
6. Which Projections must be updated?
7. Does any new class fail the Existence Test?
8. Does this require a new Port, or can an existing Port be extended?

If you cannot answer all eight — stop and clarify before implementing.

---

## Part XII — Patterns

---

### Authorised Patterns

| Pattern | Location | Why |
|---|---|---|
| ✅ Aggregate Root | Domain | Enforces invariants, records events |
| ✅ Value Object | Domain | Immutable, self-validating |
| ✅ Domain Event | Domain | Immutable business fact |
| ✅ Repository Port | Application | Persistence contract for Aggregate |
| ✅ Read Model Port | Application | Retrieval contract for View |
| ✅ View DTO | Application/ReadModel | Immutable Application contract |
| ✅ Command Handler | Application | Orchestrates one write use case |
| ✅ Query Handler | Application | Orchestrates one read use case |
| ✅ Repository Implementation | Infrastructure | DBAL + Reflection |
| ✅ Projector | Infrastructure | event.bus handler, DBAL UPSERT |
| ✅ ViewRepository | Infrastructure | DBAL SELECT → array → DTO |
| ✅ State Processor | Infrastructure/Api | HTTP → Command dispatch |
| ✅ State Provider | Infrastructure/Api | HTTP → Query dispatch |
| ✅ API Resource | Infrastructure/Api | HTTP contract — primitives only |

### Forbidden Patterns

| Pattern | Why Forbidden |
|---|---|
| ❌ Doctrine Entity anywhere | Violates persistence ignorance; enables entity drift |
| ❌ Active Record | Domain object persists itself — couples domain to infrastructure |
| ❌ Service Locator | Hidden runtime coupling — use DI instead |
| ❌ Repository for Query access | CQRS violation — use ViewRepository |
| ❌ Projection Row class | Fails Existence Test — use array → DTO directly |
| ❌ ORM annotation in Domain | Domain depends on Infrastructure — Persistence Ignorance violation |
| ❌ Symfony import in Domain | Framework Independence violation |
| ❌ Business logic in API Resource | Presentation layer must be pure HTTP translation |
| ❌ Command Handler with Read Model Port | CQRS violation |
| ❌ Query Handler with Repository Port | CQRS violation |
| ❌ Direct DB read from another Platform's tables | Platform Integration violation (ADR-SA-012) |
| ❌ Domain Event on integration.bus | Cross-boundary Domain Event — ADR-0014 violation |
| ❌ INSERT without ON CONFLICT in Projector | Non-idempotent Projection — architecturally incorrect |

---

## Part XIII — Workflows

---

### Create a Command Handler

1. **Define the Command** in `Application/Command/` — immutable, readonly, Domain types only.
2. **Define or extend the Repository Port** in `Application/Port/` if a new operation is needed.
3. **Write the Handler** in `Application/CommandHandler/`:
   - Constructor: inject `RepositoryPort` + `DomainEventCollectorPort` only
   - `__invoke`: call Aggregate → persist → collect events
4. **Wire in `services.yaml`** only if autowire cannot resolve (rare).
5. **Write unit tests** in `tests/Unit/` — mock Ports, no database.

---

### Create a Query Handler

1. **Define the Query** in `Application/Query/` — immutable, readonly.
2. **Define the View DTO** in `Application/ReadModel/` — immutable, readonly.
3. **Define the Read Model Port** in `Application/Port/` — interface only.
4. **Write the Handler** in `Application/QueryHandler/`:
   - Constructor: inject `ReadModelPort` only
   - `__invoke`: call Port → return View DTO
5. **Write the ViewRepository** in `Infrastructure/Persistence/ReadModel/`:
   - DBAL SELECT with keyset pagination
   - Direct `array → View DTO` mapping inline
   - Define indexes in a migration file
6. **Wire the Port → Implementation** in `services.yaml`.
7. **Write integration tests** in `tests/Integration/` — real database.

---

### Create a Projector

1. **Identify the Domain Event** to subscribe to.
2. **Identify the Projection table** — create a migration if it does not exist.
3. **Write the Projector** in `Infrastructure/Persistence/Projection/`:
   - `#[AsMessageHandler(bus: 'event.bus')]`
   - DBAL UPSERT with `ON CONFLICT DO UPDATE`
   - Include a `WHERE occurred_at <=` guard against out-of-order replay
4. **Write integration tests** — verify idempotence by processing the same event twice.

---

### Create a Migration

1. Generate the migration file: `php bin/console doctrine:migrations:generate`
2. Write the SQL manually — no auto-generation from entities.
3. Include:
   - Table creation with all mandatory columns
   - Indexes for the primary query pattern
   - Rollback SQL in `down()`
4. Test locally: `php bin/console doctrine:migrations:migrate`
5. Include the migration in the same PR as the Repository or Projector.

---

### Create an ADR

When a new architectural decision must be made:

1. Create the file in `docs/architecture/ADR-SA-0XX-short-name.md`
2. Include: Purpose, Context, Problem, Decision(s), Consequences, Relation to other ADRs
3. Each Decision must describe a guarantee, not a mechanism
4. Reference the ADR in `CLAUDE.md`'s Reference Documents table
5. Link related ADRs via cross-references

---

## Part XIV — AI Development

---

This section defines how Claude operates on MedLink. It is as much a part of the
Engineering Handbook as any other section.

### Before Starting Any PR

Read in this order:

1. `CLAUDE.md` — engineering constitution and reference document index
2. This handbook — `docs/ENGINEERING-HANDBOOK.md`
3. The ADRs relevant to the PR scope (use Part II of this handbook to identify them)
4. The existing code in the affected area — read actual files before writing

Do not start implementing until the ADR dependencies for the PR are understood.

### Planning Phase

Before writing any code, answer the eight Architecture Checklist questions from Part XI.

If any answer is uncertain, ask. Implementing with an uncertain architecture decision
produces code that may need to be entirely rewritten. Asking costs one message.
Rewriting costs a PR.

### Implementation Rules

**What Claude MUST do:**

- Apply the Existence Test (ADR-SA-008) before creating any new class
- Use DBAL only for all persistence — no Doctrine ORM (ADR-SA-009)
- Write UPSERT (`ON CONFLICT DO UPDATE`) in every Projector (ADR-SA-009 D-004)
- Map `array → View DTO` directly in ViewRepository — no intermediate class
- Use keyset pagination on `(occurred_at, id)` for temporal lists (ADR-SA-011)
- Collect Domain Events via `DomainEventCollectorPort` — never dispatch directly to event.bus
- Follow the naming conventions in Part VIII for SQL
- Write tests: unit for Domain, integration for Infrastructure

**What Claude MUST NOT do:**

- Create a `ProjectionRow` or any class that fails the Existence Test
- Add `#[ORM\Entity]` or any Doctrine ORM annotation anywhere
- Import a Doctrine or Symfony class in the Domain layer
- Inject a Repository Port into a Query Handler
- Inject a Read Model Port into a Command Handler
- Write an INSERT in a Projector without `ON CONFLICT`
- Read another platform's database tables directly
- Skip deptrac verification
- Skip tests
- Mark a PR as complete before running `vendor/bin/deptrac analyse` and `php bin/phpunit`

### Verification Steps

After every implementation, run in this order:

```bash
# 1. Architecture boundary verification
vendor/bin/deptrac analyse

# 2. All tests
php bin/phpunit

# 3. Static analysis (if configured)
vendor/bin/phpstan analyse src
```

Zero deptrac violations is mandatory. If a test fails, fix it before reporting completion.

### Self-Review

Before reporting a PR as complete, apply the full PR Checklist from Part XI.

For each checklist item, verify it against the actual code written — not against the
intent. "I intended to write idempotent Projectors" is not a verification. Opening
the Projector file and confirming `ON CONFLICT DO UPDATE` is present is a verification.

### Reporting Completion

When a PR is complete, report:

1. What was implemented (list of files created or modified)
2. deptrac result (number of allowed violations, number of new violations)
3. Test result (number of tests, number of failures)
4. Any architectural decisions made during implementation that deviate from the plan
5. Any open questions for the next PR

Do not report completion if deptrac has new violations or tests are failing.

### When Architecture Is Unclear

If the PR instructions require a decision not covered by an existing ADR, stop and ask.

Do not implement a workaround. Do not make an arbitrary choice and proceed. A 15-second
clarification question prevents a PR rewrite.

Example questions worth asking:
- "This feature needs data from both Clinical and Identity. Should I create a local
  Projection or wait for ADR-SA-012 integration events to be implemented?"
- "This Projector needs to handle two different Domain Events. Should they be two separate
  Projector classes or one with two `__invoke` methods?"
- "This Query returns a list that is not temporal — what should the keyset cursor be based on?"

These are architectural questions. The answer is not in the code. Ask.

---

## Appendix — Quick Reference

---

### The Eight Questions (before any feature)

1. Which Platform?
2. Which Domain Context?
3. Which Aggregate?
4. Command or Query?
5. Which Domain Events?
6. Which Projections?
7. Does any new class fail the Existence Test?
8. New Port needed or existing Port extendable?

### The Existence Test (before any new class)

> If I removed this class and inlined its content into its consumer,
> would a deptrac layer boundary be violated?

Yes → create the class.
No → do not create the class.

### Non-Negotiable Rules

1. Domain: zero Doctrine dependency
2. Application: zero persistence dependency
3. Projectors: always UPSERT
4. Projectors: always idempotent
5. ViewRepository: DBAL → array → DTO — no intermediate class
6. Domain Events: never cross platform boundaries
7. Platforms: never read another platform's tables
8. deptrac: zero violations before merge

---

*Engineering Handbook v1.0 — MedLink — 2026-07-25*
