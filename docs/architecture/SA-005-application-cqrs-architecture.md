# SA-005 — Application & CQRS Architecture

**Document ID**: SA-005
**Title**: Application & CQRS Architecture
**Status**: Release v1.0
**Version**: 1.0

**Depends on**:

- SA-001 — Reference Architecture (Release v1.1)
- SA-002 — Platform Architecture (Release v1.0)
- SA-003 — Bounded Context Architecture (Release v1.0)
- ADR-SA-005 — Architectural Decision Register (Approved)

**Implements**:

- ADR-SA-005 D-001 through D-009

**Does not define**:

- Runtime framework integration → SA-004
- Domain Event publication infrastructure → SA-006
- Persistence and Repository implementation → SA-007

---

## 1. Purpose

### 1.1 Objective

This document defines the Application Layer architecture of MedLink.

It formalizes the CQRS model, the building blocks of the Application Layer, and all rules governing their interactions.

It answers the following question:

> How is a MedLink application use case structured, executed, and isolated?

### 1.2 Normative Language

The key words MUST, MUST NOT, REQUIRED, SHALL, SHALL NOT, SHOULD, SHOULD NOT, RECOMMENDED, MAY, and OPTIONAL in this document are to be interpreted as described in RFC 2119.

### 1.3 Scope

This specification applies to every Bounded Context within every MedLink Platform.

It governs the design of Commands, Queries, Handlers, Application Results, Application Facades, Projections, and Read Models.

### 1.4 What this document does not define

- Symfony message bus configuration and handler registration → SA-004
- Domain Event publication infrastructure (transactional outbox, event bus wiring) → SA-006
- Repository implementation, ORM mapping, persistence strategy → SA-007
- Business Widget composition → SA-008
- Workspace runtime composition → SA-009

---

## 2. Application Layer

### 2.1 Definition

The Application Layer is the orchestration layer of the Bounded Context.

It sits between the Presentation Layer and the Domain Layer.

It implements Use Cases.

It coordinates Domain objects to execute business operations.

### 2.2 Responsibilities

The Application Layer SHALL:

- implement Use Cases as discrete, isolated units of execution;
- load and persist Aggregates through Repository contracts defined in the Domain;
- own transaction boundaries for write operations;
- collect and publish Domain Events produced by Aggregates;
- expose a stable synchronous contract to the rest of the system via the Application Facade;
- provide Query Handlers that retrieve data exclusively from Read Models.

The Application Layer SHALL NOT:

- contain business rules or business decisions;
- contain persistence logic (SQL, ORM, infrastructure adapters);
- import Presentation concerns (HTTP, serialisation, rendering);
- access another Bounded Context's internal Aggregates or Repositories directly.

### 2.3 Relation to the Domain Layer

The Application Layer serves the Domain.

It executes the Domain's decisions by:
- invoking Aggregate methods that enforce invariants;
- recording Domain Events produced as a result;
- persisting the resulting Aggregate state.

Business logic remains exclusively inside the Domain.

The Application Layer orchestrates — the Domain decides.

### 2.4 Relation to the Foundational Principle

SA-P-0010 (Single Architectural Responsibility) governs every Application Layer building block defined in this document.

Every building block owns exactly one responsibility. No two building blocks share a responsibility. If overlap is detected, the architecture SHALL be reconsidered before implementation proceeds.

---

## 3. CQRS Model

### 3.1 Principle

MedLink applies Command Query Responsibility Segregation (CQRS) at the Application Layer.

Write operations and read operations are strictly separated.

They flow through independent paths, carry independent contracts, and are independently evolvable.

### 3.2 Write Side

The write side modifies business state.

```
Command → Command Handler → Aggregate → Domain Event
```

The write side:
- accepts Commands expressing intent to change state;
- delegates all business decisions to Aggregates;
- produces Domain Events recording what happened;
- returns an Application Result or void.

The write side SHALL NEVER return Read Models.

### 3.3 Read Side

The read side retrieves business information.

```
Query → Query Handler → Read Model
```

The read side:
- accepts Queries expressing intent to retrieve data;
- reads exclusively from pre-computed Read Models;
- returns structured read data.

The read side SHALL NEVER modify business state.

### 3.4 Separation Guarantee

The two paths are architecturally independent.

A write path change SHALL NOT require a read path change.

A read path change SHALL NOT require a write path change.

Under no circumstances SHALL a Command Handler invoke a Query Handler, or a Query Handler invoke a Command Handler.

---

## 4. Commands

### 4.1 Definition

A Command is an immutable data object that expresses an intent to modify business state.

A Command represents exactly one Use Case on the write side.

### 4.2 Structural Rules

Commands SHALL:

- be immutable after construction;
- carry only the data required to execute the intended Use Case;
- belong to the Application Layer;
- contain no business logic;
- contain no validation logic beyond structural integrity.

Commands SHALL NOT:

- produce side effects;
- reference Domain Model objects (Aggregates, Entities, Value Objects);
- reference Infrastructure objects;
- reference Read Models.

### 4.3 Naming Convention

Commands SHALL be named using the imperative form, reflecting the intent of the caller:

```
{Verb}{Subject}Command

StartClinicalActivityCommand
ValidateClinicalContributionCommand
RequestClinicalHandoverCommand
AcceptClinicalHandoverCommand
CloseClinicalActivityCommand
```

---

## 5. Queries

### 5.1 Definition

A Query is an immutable data object that expresses an intent to retrieve data.

A Query represents exactly one Use Case on the read side.

### 5.2 Structural Rules

Queries SHALL:

- be immutable after construction;
- carry only the parameters required to identify and filter the requested data;
- belong to the Application Layer;
- contain no business logic;
- produce no side effects.

Queries SHALL NOT:

- modify business state;
- reference Domain Model objects;
- reference Infrastructure objects.

### 5.3 Naming Convention

Queries SHOULD be named using a retrieval prefix, reflecting the intent of the caller:

```
Get{Resource}Query
Get{Resource}By{Criteria}Query
List{Resources}Query

GetClinicalActivityByIdQuery
GetPatientTimelineQuery
ListOpenActivitiesByPractitionerQuery
```

---

## 6. Command Handlers

### 6.1 Definition

A Command Handler is the component that executes exactly one Command.

It is the Application Layer's unit of use case implementation on the write side.

### 6.2 One Handler Per Use Case (D-001)

Each application Use Case SHALL be implemented by exactly one Command Handler.

A Command Handler SHALL implement one and only one business capability.

This is an absolute constraint derived from SA-P-0010 (Single Architectural Responsibility).

A Command Handler implementing multiple Commands constitutes an architectural violation.

### 6.3 Responsibilities

A Command Handler SHALL:

- receive exactly one Command type;
- open a transaction before any state mutation;
- load the required Aggregate(s) via Repository contracts;
- invoke the appropriate Aggregate method(s);
- persist the resulting Aggregate state;
- commit the transaction on success;
- rollback the transaction on failure;
- collect Domain Events pending publication after commit;
- delegate Domain Event publication to the Application Runtime after a successful commit;
- return an Application Result or void.

A Command Handler SHALL NOT:

- contain business rules or business decisions;
- construct Aggregates directly in place of a Repository;
- publish Domain Events before the transaction commits;
- return Aggregates, Domain Models, Read Models, or Infrastructure objects;
- access Aggregates or Repositories belonging to another Bounded Context.

### 6.4 Transaction Boundary

The transaction boundary is the Command Handler's responsibility (D-003).

The Handler defines where the transaction starts, where it commits, and where it rolls back.

This is specified in Section 9.

---

## 7. Query Handlers

### 7.1 Definition

A Query Handler is the component that executes exactly one Query.

It is the Application Layer's unit of use case implementation on the read side.

### 7.2 One Handler Per Use Case (D-001)

Each read Use Case SHALL be implemented by exactly one Query Handler.

A Query Handler SHALL implement one and only one read capability.

### 7.3 Responsibilities

A Query Handler SHALL:

- receive exactly one Query type;
- retrieve data exclusively from Read Models (D-005);
- assemble and return the requested data.

A Query Handler SHALL NOT:

- load Aggregates;
- invoke Domain Services;
- execute business rules;
- modify business state;
- open a transaction.

### 7.4 Read Model Access

Query Handlers access Read Models through Port interfaces defined in the Application Layer.

The concrete Read Model storage mechanism is defined in SA-007.

---

## 8. Application Results

### 8.1 Definition

An Application Result is an immutable data object returned by a Command Handler to acknowledge successful execution.

It is the minimal acknowledgment of a completed Use Case.

### 8.2 Return Contract (D-009)

Command Handlers SHALL return one of the following:

- an Application Result;
- void.

Command Handlers SHALL NEVER return:

- Aggregates;
- Domain Models;
- Read Models;
- Infrastructure objects;
- any object that contains business rules or persistence concerns.

### 8.3 Content Rules

Application Results SHALL contain only the data immediately required by the caller after successful Use Case completion.

Typical content:

- the identifier of the created or modified resource;
- a status acknowledgment;
- a timestamp of the operation.

Application Results SHALL NOT evolve into View Models.

If presentation data is required after a write operation, the caller SHALL issue a Query.

### 8.4 Distinction from Read Models

| | Application Result | Read Model |
|---|---|---|
| Purpose | Acknowledge execution | Provide visualization data |
| Produced by | Command Handler | Projection |
| Consumed by | Presentation (write response) | Query Handler |
| Content | Minimal acknowledgment | Full read-optimised representation |
| Lifecycle | Transient — per request | Persistent — pre-computed |

---

## 9. Transaction Ownership

### 9.1 Principle (D-003)

Transaction boundaries belong to the Application Layer.

Command Handlers own the transaction lifecycle.

### 9.2 Transaction Lifecycle

For every write Use Case, a Command Handler SHALL define:

1. **Transaction start** — before any state mutation or Repository access;
2. **Commit** — after all mutations succeed and before Domain Events are published;
3. **Rollback** — when any mutation or business rule violation fails.

Domain Events SHALL remain pending until the transaction commits successfully (D-008).

Domain Events SHALL NOT be published if the transaction rolls back.

### 9.3 Aggregate Transaction Isolation

Aggregates SHALL remain transaction-agnostic (D-003).

An Aggregate has no knowledge of transactions.

An Aggregate enforces invariants and records events. The Handler manages consistency boundaries.

Persistence concerns SHALL NOT leak into the Domain Model.

The concrete transaction mechanism (middleware, decorator, unit of work) is defined in SA-007.

---

## 10. Application Facade

### 10.1 Definition (D-004)

The Application Facade is the stable, synchronous public contract of a Bounded Context.

It is the sole entry point into the Bounded Context's Application Layer for external synchronous callers.

### 10.2 One Facade Per Bounded Context

Each Bounded Context SHALL expose exactly one Application Facade.

This is an absolute constraint derived from SA-P-0010 (Single Architectural Responsibility).

The Facade owns the responsibility of defining what the Bounded Context offers to the outside world.

### 10.3 Responsibilities

The Application Facade SHALL:

- expose the public synchronous contract of the Bounded Context;
- delegate every operation to the appropriate Command Handler or Query Handler;
- remain a pure delegation surface.

The Application Facade SHALL NOT:

- contain business rules;
- contain orchestration logic;
- contain persistence logic;
- expose internal Aggregates, Repositories, or Domain Services.

Handlers SHALL remain private implementation details of the Bounded Context and SHALL NOT be directly accessible to Facade consumers.

### 10.4 Stability Constraint

The Application Facade is a published contract (SA-002 Section 3.5).

Its interface SHALL remain stable across internal evolutions of the Bounded Context.

Breaking changes to the Facade require an Architecture Decision Record.

### 10.5 Relation to the Platform Contract

The Application Facade is the synchronous component of the Platform Contract (SA-002 Section 3.5).

Other Bounded Contexts within the same Platform access this Bounded Context synchronously through the Facade.

---

## 11. Application Contracts

### 11.1 Definition (D-007)

Application Contracts are the data structures that define interactions with the Application Layer.

### 11.2 Components

Application Contracts consist of:

| Component | Direction | Description |
|---|---|---|
| Command | Inbound (write) | Expresses intent to modify state |
| Query | Inbound (read) | Expresses intent to retrieve data |
| Application Result | Outbound (write) | Acknowledges successful Use Case execution |
| Read Model | Outbound (read) | Provides pre-computed read-optimised data |

### 11.3 Structural Rules (D-007)

Application Contracts SHALL:

- contain data only;
- be immutable;
- belong to the Application Layer.

Application Contracts SHALL NOT:

- contain business logic;
- contain persistence logic;
- reference Domain Model internals;
- reference Infrastructure objects.

### 11.4 Technology Decoupling

Application Contracts define interactions independently from Presentation technologies.

The same Application Contracts are consumed by REST controllers, CLI commands, batch processors, and any future entry points.

Presentation technology changes SHALL NOT require Application Contract changes.

---

## 12. Aggregate Orchestration

### 12.1 Intra-BC Orchestration (D-002)

A Command Handler MAY orchestrate multiple Aggregates belonging to the same Bounded Context.

When orchestrating multiple Aggregates, the Handler:
- loads each Aggregate via its respective Repository contract;
- invokes the appropriate method on each Aggregate in the required sequence;
- persists all Aggregates within the same transaction;
- collects Domain Events from all Aggregates.

### 12.2 Cross-BC Isolation (D-002)

A Command Handler SHALL NEVER directly access Aggregates or Repositories belonging to another Bounded Context.

This is an absolute constraint derived from SA-P-0010 (Single Architectural Responsibility) and SA-003 Rule 6.

Bounded Context autonomy is inviolable.

### 12.3 Cross-BC Collaboration

Cross-BC collaboration SHALL occur exclusively through the following two mechanisms:

**Synchronous** — Application Facade

The Handler invokes the target Bounded Context's Application Facade.

The Facade call occurs within the same execution context.

```
Handler (BC-A)
    │
    │ invokes Facade method
    ▼
Application Facade (BC-B)
    │
    │ delegates to Handler (BC-B)
    ▼
Handler (BC-B)
    │
    ▼
Aggregate (BC-B)
```

**Asynchronous** — Domain Events

A Domain Event produced by BC-A is consumed by a Domain Event Handler in BC-B.

BC-B reacts independently and asynchronously.

```
Aggregate (BC-A)
    │
    │ records Domain Event
    ▼
Application Runtime
    │
    │ publishes after commit
    ▼
Event Bus
    │
    ▼
Domain Event Handler (BC-B)
    │
    ▼
Handler (BC-B) or Projection (BC-B)
```

The choice between synchronous and asynchronous collaboration is governed by the consistency requirement of the business scenario.

---

## 13. Domain Event Lifecycle

### 13.1 Recording

Aggregates record Domain Events as a result of business operations (D-008).

An Aggregate that successfully completes a state change SHALL record the corresponding Domain Event in its internal pending event collection.

Domain Events are recorded inside the Aggregate — they are not dispatched from the Aggregate.

### 13.2 Pending State

Domain Events recorded by an Aggregate SHALL remain pending until the transaction commits successfully (D-008).

Pending Domain Events are held by the Aggregate until the Handler collects them after a successful commit.

### 13.3 Collection

After a successful commit, the Command Handler collects the pending Domain Events from all Aggregates that participated in the transaction.

### 13.4 Publication

Publication of Domain Events is performed by the Application Runtime after the transaction commits (D-008).

Aggregates SHALL NEVER publish Domain Events directly (D-008).

The publication mechanism (transactional outbox, synchronous dispatch, event bus) is defined in SA-006.

### 13.5 Failure Guarantee

If the transaction rolls back, pending Domain Events SHALL NOT be published.

A Domain Event represents a completed business fact.

Facts that did not persist SHALL NOT be announced.

### 13.6 Domain Event Lifecycle Summary

```
Aggregate method invoked
    │
    │ records Domain Event (pending — not published)
    ▼
Handler persists Aggregate
    │
    │ transaction commits
    ▼
Handler collects pending Domain Events from Aggregate
    │
    │ delegates to Application Runtime
    ▼
Application Runtime publishes Domain Events
    │
    ▼
Event Bus → Projections, Domain Event Handlers
```

If the transaction fails at any point before commit, the flow terminates. No events are published.

> **Note** — The collection sequence illustrated in this diagram is provided as an example only.
>
> The concrete Domain Event collection mechanism (Aggregate pull, observer, collector, or equivalent runtime strategy) remains intentionally open and is deferred to SA-006 (OD-003).

---

## 14. Projections and Read Models

### 14.1 Read Model Definition

A Read Model is a read-optimised, pre-computed representation of business data.

Read Models are built by Projections.

Read Models are consumed by Query Handlers.

Read Models are read-only. No layer writes to a Read Model directly except its owning Projection.

Read Models SHALL contain no business rules.

### 14.2 Projection Definition (D-006)

A Projection is a component that subscribes to Domain Events and maintains one or more Read Models.

A Projection reacts to facts that have already occurred. It does not participate in business decisions.

### 14.3 Projection Rules (D-006)

Projections SHALL:

- subscribe to specific Domain Event types;
- update their owned Read Model(s) in response to each subscribed event.

Projections SHALL NOT:

- execute business rules;
- modify Aggregates;
- invoke Commands;
- participate in transactions owned by Command Handlers.

### 14.4 Projection Rebuilding

Because Read Models are derived views of Domain Events, any Read Model MAY be rebuilt from scratch by replaying the Domain Events it was built from.

A Projection is therefore stateless with respect to its source of truth. The Domain Event history is authoritative.

### 14.5 Query Handler Read Path (D-005)

Query Handlers SHALL access Read Models exclusively.

Query Handlers SHALL NOT:

- load Aggregates;
- invoke Domain Services;
- execute business rules;
- access persistent state except through Read Model Port interfaces.

The Query Handler is a pure data retrieval component.

### 14.6 Read Model Shaping

Read Models are shaped for their consumers.

A Read Model MAY be shaped specifically for a single screen, dashboard, or widget.

Shaping Read Models for consumers is the correct approach. Loading Domain Models and transforming them in the Presentation Layer is a violation of CQRS separation.

---

## 15. Dependency Rules

### 15.1 Within the Application Layer

Commands, Queries, and Results are data contracts. They have no dependencies.

Handlers depend on:
- Domain Layer Repository interfaces and Aggregate types;
- Port interfaces for external concerns (email, notification, external query);
- Application Facades of other Bounded Contexts (for synchronous cross-BC calls).

Handlers SHALL NOT depend on:
- Infrastructure implementations directly;
- Presentation classes;
- Read Models (Command Handlers only — see Rule 15.4).

### 15.2 Application → Domain

The Application Layer depends on the Domain Layer.

Handlers access the Domain exclusively through:
- Aggregate types defined in the Domain;
- Repository interfaces defined in the Domain;
- Domain Event types defined in the Domain.

The Application Layer SHALL NOT depend on Infrastructure implementations.

### 15.3 Application → Infrastructure (via Ports)

When the Application Layer requires an external capability (sending a notification, persisting a Read Model, querying an external system), it defines a Port interface.

Port interfaces are defined in the Application Layer.

Infrastructure provides the implementation.

The Application Layer binds to the Port interface — never to the implementation.

### 15.4 Read Path Dependency

Query Handlers depend on Read Model Port interfaces defined in the Application Layer.

Command Handlers SHALL NOT depend on Read Model Port interfaces.

Command Handlers SHALL NOT access Read Models.

### 15.5 Cross-BC Dependency

A component in Bounded Context A MAY depend on the Application Facade of Bounded Context B.

A component in Bounded Context A SHALL NOT depend on:
- Domain classes of Bounded Context B;
- Application Handler classes of Bounded Context B;
- Infrastructure classes of Bounded Context B;
- Repository interfaces of Bounded Context B.

### 15.6 Cross-Platform Dependency

The Application Layer SHALL NOT reference any class from another Platform.

Cross-Platform interaction occurs through Integration Events published via Platform Contracts (SA-002 Section 5, ADR-0014).

---

## 16. Interaction Patterns

### 16.1 Write Flow

A write operation starts at the Presentation Layer and terminates after Domain Event publication.

```
Presentation (Controller)
        │
     Command
        │
        ▼
Application (Command Handler)
        │ 1. opens transaction
        │
        │ 2. loads Aggregate(s) via Repository
        ▼
Domain (Aggregate)
        │ enforces invariants
        │ modifies state
        │ records Domain Events (pending)
        ▼
Application (Command Handler)
        │ 3. persists Aggregate(s)
        │ 4. commits transaction
        │ 5. collects pending Domain Events
        │ 6. delegates to Application Runtime
        │ 7. returns Application Result | void
        ▼
Presentation

Application Runtime (post-commit)
        │ publishes Domain Events
        ▼
Event Bus
        │
        ├──▶ Projections (Read Model updates)
        └──▶ Domain Event Handlers (cross-BC reactions)
```

### 16.2 Read Flow

A read operation starts at the Presentation Layer and returns pre-computed data.

```
Presentation (Controller)
        │
      Query
        │
        ▼
Application (Query Handler)
        │
        │ reads via Read Model Port
        ▼
Infrastructure (Read Model)
        │
        ▼
Application (Query Handler)
        │ returns read data
        ▼
Presentation
        │ assembles ViewModel → Response
```

The Query Handler never reaches the Domain Layer.

### 16.3 Cross-BC Synchronous Flow

When Bounded Context A needs to invoke a synchronous operation in Bounded Context B:

```
Handler (BC-A)
        │
        │ invokes Facade method
        ▼
Application Facade (BC-B)
        │ delegates
        ▼
Handler (BC-B)
        │ opens its own transaction
        ▼
Domain (BC-B Aggregate)
        │
        ▼
Handler (BC-B) commits, returns Application Result
        │
        ▼
Handler (BC-A) continues
```

BC-A and BC-B each manage their own transaction boundaries.

### 16.4 Cross-BC Asynchronous Flow

When a business fact in BC-A triggers a reaction in BC-B:

```
Domain (BC-A Aggregate)
        │ records Domain Event
        ▼
Handler (BC-A) commits, publishes Domain Event
        │
        ▼
Event Bus
        │
        ▼
Domain Event Handler (BC-B)
        │ may dispatch a Command (BC-B)
        │ or update a Read Model via Projection
        ▼
Handler (BC-B) or Projection (BC-B)
```

BC-A has no knowledge of BC-B's reaction.

### 16.5 Domain Event → Projection Flow

When a Domain Event triggers a Read Model update:

```
Event Bus
        │
        │ Domain Event dispatched
        ▼
Projection
        │ subscribes to this Domain Event type
        │ applies transformation
        │ updates Read Model
        ▼
Read Model (updated — available for next Query)
```

Projections are the only writers of Read Models.

---

## 17. Architectural Invariants

The following invariants apply to every Bounded Context without exception.

Violations require an Architecture Decision Record before implementation.

| # | Invariant |
|---|---|
| I-001 | Each Use Case SHALL be implemented by exactly one Handler. |
| I-002 | A Command Handler SHALL implement one and only one business capability. |
| I-003 | A Query Handler SHALL implement one and only one read capability. |
| I-004 | Command Handlers SHALL own the transaction boundary. |
| I-005 | Aggregates SHALL remain transaction-agnostic. |
| I-006 | Domain Events SHALL remain pending until the transaction commits. |
| I-007 | Domain Events SHALL be published by the Application Runtime — never by Aggregates directly. |
| I-008 | Domain Events SHALL NOT be published if the transaction rolls back. |
| I-009 | Command Handlers SHALL NOT return Aggregates, Domain Models, Read Models, or Infrastructure objects. |
| I-010 | Command Handlers SHALL NOT access Aggregates or Repositories from another Bounded Context. |
| I-011 | Query Handlers SHALL access Read Models exclusively. |
| I-012 | Query Handlers SHALL NOT load Aggregates or execute business rules. |
| I-013 | Projections SHALL NOT execute business rules, modify Aggregates, or invoke Commands. |
| I-014 | Each Bounded Context SHALL expose exactly one Application Facade. |
| I-015 | The Application Facade SHALL contain no business rules, orchestration logic, or persistence logic. |
| I-016 | Application Contracts (Commands, Queries, Results) SHALL contain data only — no business logic. |
| I-017 | Read Models SHALL be read-only. No layer other than their owning Projection SHALL write to a Read Model. |
| I-018 | The write path and the read path SHALL remain independently evolvable. |

---

## 18. Reference Structure

Every Bounded Context SHALL follow the Application Layer structure below.

```
{BoundedContext}/
│
├── Application/
│   │
│   ├── Command/                       ← Write-side contracts (inbound)
│   │   └── {UseCase}Command.php
│   │
│   ├── Query/                         ← Read-side contracts (inbound)
│   │   └── Get{Resource}Query.php
│   │   └── List{Resources}Query.php
│   │
│   ├── Handler/                       ← Use Case implementations
│   │   └── {UseCase}CommandHandler.php
│   │   └── Get{Resource}QueryHandler.php
│   │
│   ├── Result/                        ← Write-side contracts (outbound)
│   │   └── {UseCase}Result.php
│   │
│   ├── DTO/                           ← Read-side contracts (outbound)
│   │   └── {Resource}QueryResult.php
│   │
│   ├── Port/                          ← Interfaces for external dependencies
│   │   └── {Capability}PortInterface.php
│   │
│   └── Facade/                        ← Sole public synchronous surface
│       └── {BoundedContext}Facade.php
```

### Structural Rules

- One file per Command. One file per Query. One file per Handler.
- The `Handler/` directory SHALL NOT contain shared base classes aggregating multiple use cases.
- The `Facade/` directory SHALL contain exactly one file per Bounded Context.
- The `Port/` directory contains interfaces only. Implementations belong to `Infrastructure/`.
- The `DTO/` directory contains read-optimised data contracts returned by Query Handlers. These are Application Layer artifacts (`{Resource}QueryResult`) distinct from the Infrastructure Read Models stored in `Infrastructure/ReadModel/`.

### Naming Conventions

| Artifact | Convention | Example |
|---|---|---|
| Command | `{Verb}{Subject}Command` | `StartClinicalActivityCommand` |
| Query | `Get{Resource}Query` / `List{Resources}Query` | `GetPatientTimelineQuery` |
| Command Handler | `{UseCase}CommandHandler` | `StartClinicalActivityCommandHandler` |
| Query Handler | `Get{Resource}QueryHandler` | `GetPatientTimelineQueryHandler` |
| Application Result | `{UseCase}Result` | `StartClinicalActivityResult` |
| Query Result DTO | `{Resource}QueryResult` | `PatientTimelineQueryResult` |
| Port | `{Capability}PortInterface` | `NotificationPortInterface` |
| Facade | `{BoundedContext}Facade` | `ClinicalWorkFacade` |

---

## 19. Open Decisions

| ID | Decision | Status |
|---|---|---|
| OD-001 | Application Result vs void — when to return a Result vs void (guidance for common cases) | Open |
| OD-002 | Port granularity — one Port per external system vs one Port per operation | Open |
| OD-003 | Domain Event collection mechanism — pull from Aggregate vs observer pattern. SA-005 approves the architectural principle: Domain Events remain pending until the transaction commits; publication occurs only after a successful commit; Aggregates never publish directly. SA-006 defines the concrete collection and publication mechanism (transactional outbox, synchronous dispatch, pull pattern, or observer). | Open — deferred to SA-006 |
| OD-004 | Cross-BC synchronous Facade call — error propagation contract | Open |

---

## 20. Cross-Document Alignment

### 20.1 Supersession — EH-001 Chapter 15

EH-001 — Understanding MedLink Architecture, Chapter 15 ("Why Commands Never Return Read Models") states that Command Handlers return void.

SA-005 Section 8 (D-009) supersedes this rule.

The certified rule is:

> Command Handlers SHALL return an Application Result or void.

EH-001 Chapter 15 SHALL be updated to reflect this distinction after SA-005 reaches Release status.

Until EH-001 is updated, SA-005 is the authoritative source on Command Handler return contracts.

### 20.2 Architectural Principle vs Implementation Mechanism — SA-006

SA-005 Section 13 establishes the following architectural principle (D-008):

> Domain Events remain pending until the transaction commits. Publication occurs only after a successful commit. Aggregates never publish directly.

This principle is certified by SA-005.

The concrete implementation mechanism — including the collection pattern (pull from Aggregate, observer), the publication channel (synchronous bus, transactional outbox), and the runtime integration — is an open decision (OD-003) deferred to SA-006 — Domain Event & Integration Event Architecture.

SA-006 SHALL implement this principle without altering it.

---

## 21. References

- SA-001 — Reference Architecture (SA-P-0010: Single Architectural Responsibility)
- SA-002 — Platform Architecture (Section 3.5: Platform Contract, Section 5: Collaboration)
- SA-003 — Bounded Context Architecture (Section 5: Building Blocks, Section 6: Dependency Rules, Section 8: Invariants)
- SA-004 — Symfony Runtime Architecture (Section 5: Service Organisation)
- ADR-SA-005 — Architectural Decision Register D-001 through D-009
- ADR-0003 — Hexagonal Architecture
- ADR-0004 — CQRS
- ADR-0014 — Domain Events Shall Never Cross Platform Boundaries
