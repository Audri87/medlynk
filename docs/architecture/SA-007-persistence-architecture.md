# SA-007 — Persistence Architecture

**Document ID**: SA-007
**Title**: Persistence Architecture
**Status**: Release v1.0
**Version**: 1.0

**Depends on**:

- SA-001 — Reference Architecture (Release v1.1)
- SA-002 — Platform Architecture (Release v1.0)
- SA-003 — Bounded Context Architecture (Release v1.0)
- SA-004 — Runtime Architecture (Release v1.0)
- SA-005 — Application & CQRS Architecture (Release v1.0)
- SA-006 — Event-Driven Architecture (Release v1.0)
- ADR-SA-007 — Architectural Decision Register (Approved)

**Implements**:

- ADR-SA-007 D-001 through D-011

**Does not define**:

- Persistence technology selection → OD-003
- Schema migration strategy → OD-004
- Repository retrieval semantics → OD-002
- Application Result vs void in the persistence context → OD-001
- Persistence coordination mechanism → runtime specification
- Concurrency control mechanism → runtime specification
- Persistence mapping strategy → runtime specification

---

## 1. Purpose

### 1.1 Objective

This document defines the Persistence Architecture of MedLink.

It formalises the architectural responsibilities, guarantees, boundaries, and dependency rules governing how business state is persisted, retrieved, and protected across all Platforms and Bounded Contexts.

It answers the following questions:

> Who holds exclusive persistence authority for each Aggregate Root?
> What may a Repository do, and what must it never do?
> Who owns the transaction boundary, and where does it begin and end?
> What guarantee does the architecture provide for atomic persistence?
> What guarantee does the architecture provide against concurrent state corruption?
> Where does persistence translation responsibility reside?
> How is Read Model persistence separated from Aggregate persistence?
> What operations may a Repository contract expose?
> How does the Domain Model remain independent of all persistence concerns?
> How does the architecture support multiple persistence technologies?
> Who owns schema evolution?

### 1.2 Normative Language

The key words SHALL, SHALL NOT, SHOULD, SHOULD NOT, and MAY in this document are to be interpreted as described in RFC 2119.

### 1.3 What this document does not define

- Persistence technology selection → OD-003
- Schema migration strategy → OD-004
- Repository retrieval semantics → OD-002
- Application Result in the persistence context → OD-001
- Persistence coordination mechanism → runtime specification
- Concurrency control mechanism → runtime specification
- Persistence mapping strategy → runtime specification

---

## 2. Scope

This specification applies to:

- every Platform within the MedLink Architecture;
- every Bounded Context persisting Aggregate state or Read Model state;
- every Repository implementing an Aggregate persistence port;
- every Projection writing to a Read Model store;
- every Application Handler managing a transaction boundary.

---

## 3. Architectural Principles

### SA-P-0010 — Single Architectural Responsibility

Every persistence building block defined in this document owns exactly one architectural responsibility.

| Building Block | Single Responsibility |
|---|---|
| Repository | Persists and retrieves the Aggregate Root it owns |
| Application Transaction | Coordinates all persistence operations within exactly one use case |
| Persistence Mapping | Translates Aggregate state to and from storage representation |
| Read Model Store | Persists pre-computed, retrieval-optimised state |
| Projection | Maintains exactly one Read Model scope from Domain Events |
| Concurrency Control | Prevents inconsistent Aggregate state under concurrent updates |
| Schema Evolution Component | Applies schema changes in the Infrastructure layer |

Responsibilities SHALL NOT overlap.

Any component accumulating more than one responsibility requires an Architecture Decision Record before implementation.

### SA-P-0011 — Cognitive Simplicity

Persistence architecture introduces operational and developmental complexity.

This specification minimises that complexity by:

- assigning one Repository per Aggregate Root — no shared contracts, no generic repositories;
- anchoring the transaction boundary at the Application Layer — one boundary per use case;
- eliminating persistence knowledge from the Domain Model — one place for each concern;
- separating Aggregate state persistence from Read Model persistence — independent stores, independent evolution.

No persistence abstraction is introduced beyond what domain ownership and CQRS separation require.

---

## 4. Repository Ownership

### 4.1 Principle

Each Aggregate Root has a single, authoritative persistence path. That path is its owning Repository. The ownership relationship is one-to-one and non-transferable.

### 4.2 Ownership Rules

Each Aggregate Root SHALL be persisted exclusively through its owning Repository.

Each Repository SHALL own exactly one Aggregate Root.

A Repository SHALL NOT own multiple Aggregate Roots.

No component other than the owning Repository SHALL persist or restore the Aggregate Root it owns.

### 4.3 Scope of Ownership

The owning Repository is responsible for:

- restoring the Aggregate Root from its persisted representation;
- persisting the current Aggregate state after a business operation;
- maintaining the integrity of the Aggregate Root's persisted representation.

No other component holds these responsibilities for that Aggregate Root.

### 4.4 Domain Correspondence

Each Aggregate Root certified in Domain Engineering warrants exactly one Repository.

The count of Repositories in a Bounded Context SHALL equal the count of Aggregate Roots in that Bounded Context. This count is a domain signal, not an infrastructure decision.

---

## 5. Aggregate Persistence

### 5.1 Principle

A Repository persists business state. It does not coordinate business communication. These are independent architectural responsibilities with independent failure modes and independent recovery paths.

### 5.2 Scope

A Repository SHALL persist only the business state of its Aggregate Root.

### 5.3 Messaging Prohibition

A Repository SHALL NOT publish Domain Events.

A Repository SHALL NOT publish Integration Events.

A Repository SHALL NOT perform any messaging responsibility.

A Repository SHALL NOT trigger communication beyond the write to its persistence store.

### 5.4 Event Publication Boundary

Domain Event publication is the responsibility of the Application Runtime after a successful transaction commit (SA-005 §13.3–§13.5).

Integration Event publication is the responsibility of the Platform Integration Layer (SA-006 §6.3).

Neither responsibility belongs to the Repository.

Neither may be delegated to the Repository through any mechanism.

### 5.5 Failure Independence

Because the Repository performs only persistence, persistence failures and publication failures are independently classifiable and independently recoverable by the runtime.

A persistence failure does not cause a Domain Event publication failure.

A publication failure does not require a reversal of the persistence operation through the Repository.

---

## 6. Transaction Boundary

### 6.1 Principle

A transaction represents the scope of one business use case. The component that owns the business use case owns the transaction. Only the Application Layer has the visibility required to declare when a use case has fully succeeded.

### 6.2 Ownership

The transaction boundary SHALL belong to the Application Layer.

The Command Handler owns the transaction on behalf of the Application Layer. These statements describe the same architectural responsibility at different abstraction levels: SA-005 D-003 names the Command Handler as the concrete owner; SA-007 D-003 names the Application Layer as the architectural location of that ownership.

Each Application Use Case SHALL execute within exactly one transaction boundary.

The Application Layer SHALL open the transaction before any persistence operation begins.

The Application Layer SHALL commit the transaction after all use case operations succeed.

The Application Layer SHALL roll back the transaction if any operation within the use case fails.

### 6.3 Repository Participation

Repository implementations SHALL participate in the active transaction.

Repository implementations SHALL NOT own transaction management.

A Repository SHALL NOT open a transaction.

A Repository SHALL NOT commit a transaction.

A Repository SHALL NOT roll back a transaction.

### 6.4 Aggregate Boundary

Aggregate Roots SHALL remain transaction-agnostic (SA-005 D-003).

No Aggregate Root carries transaction management logic.

No Aggregate Root expresses awareness of transaction scope.

### 6.5 Post-commit Sequencing

Actions depending on a committed transaction — including Domain Event collection and publication — SHALL execute after the transaction commits.

No post-commit action SHALL execute if the transaction rolls back.

A rolled-back transaction leaves Aggregate state and Domain Event records in a consistent failed state: no partial update, no spurious event publication.

Pending Domain Events SHALL be discarded upon rollback.

---

## 7. Atomic Persistence Coordination

### 7.1 Principle

All persistence operations within a use case boundary succeed together or fail together. The architecture does not permit partial commits within a single Application transaction.

### 7.2 Guarantee

The runtime SHALL coordinate all persistence operations participating in the same Application transaction and commit them atomically.

If any participating operation fails, all operations in the transaction SHALL be rolled back.

No partial commit within a single Application transaction is permissible.

### 7.3 Mechanism Independence

The architecture SHALL NOT mandate a specific coordination mechanism.

The mechanism by which the runtime delivers atomic coordination is a runtime implementation concern.

SA-007 defines the atomicity guarantee. The runtime specification defines the coordination mechanism.

### 7.4 Transparency

The Domain layer and the Application layer are unaware of the coordination mechanism in use.

Coordination is an Infrastructure concern executed transparently within the transaction boundary owned by the Application Layer.

---

## 8. Aggregate State Consistency

### 8.1 Principle

An Aggregate Root's business invariants depend on a consistent starting state for every state transition. A transition applied to an inconsistent starting state produces a corrupt result, potentially violating domain invariants without detection.

### 8.2 Guarantee

The runtime SHALL preserve Aggregate consistency whenever concurrent updates to the same Aggregate Root occur.

No concurrent update SHALL produce a silent state corruption.

If two concurrent updates conflict, the runtime SHALL detect the conflict and prevent the losing update from being silently applied.

### 8.3 Mechanism Independence

The architecture SHALL NOT mandate a specific concurrency control mechanism.

The mechanism by which the runtime delivers consistency under concurrency is a runtime implementation concern.

SA-007 defines the consistency guarantee. The runtime specification defines the concurrency control mechanism.

### 8.4 Domain Independence

The Domain Model is not involved in concurrency control decisions.

No Aggregate Root carries concurrency control logic.

No Aggregate Root expresses awareness of concurrent access.

Concurrency control is coordinated within the Infrastructure layer.

---

## 9. Persistence Mapping

### 9.1 Principle

An Aggregate Root is a domain object whose structure reflects business concepts and invariants. A storage representation is a technical artifact whose structure reflects the requirements of the storage technology. The translation between them belongs in one defined location in the Infrastructure layer.

### 9.2 Mapping Responsibility

Repository implementations SHALL translate Aggregate state to and from persistence representations.

The translation from Aggregate state to storage representation SHALL occur when the Repository persists the Aggregate Root.

The translation from storage representation to Aggregate state SHALL occur when the Repository restores the Aggregate Root.

### 9.3 Mapping Location

Mapping logic SHALL reside in the Infrastructure layer.

Mapping logic SHALL NOT reside in the Domain layer.

Mapping logic SHALL NOT reside in the Application layer.

### 9.4 Dedicated Mapping Component

The architecture SHALL NOT require a dedicated mapping component separate from the Repository implementation.

Repository implementations MAY delegate internally within the Infrastructure boundary. This is a structural decision within the Infrastructure boundary and does not alter the mapping responsibility assigned to the Repository.

### 9.5 Strategy Independence

The mapping approach appropriate for each storage technology is a runtime implementation concern.

SA-007 defines mapping responsibility. The runtime specification defines the normalised mapping approach for the chosen storage technologies.

---

## 10. Read Model Persistence

### 10.1 Principle

CQRS separates the write path — which serves business consistency — from the read path — which serves information retrieval. This separation extends to persistence: Aggregate state and Read Model state are persisted in independent stores, with independent lifecycles and independent evolution paths.

### 10.2 Aggregate Repository Scope

Aggregate Repositories SHALL persist Aggregate state exclusively.

An Aggregate Repository SHALL NOT persist Read Model state.

An Aggregate Repository SHALL NOT serve operations for the read path.

### 10.3 Independence

Read Models SHALL be persisted independently of Aggregate state.

The store used for Read Models MAY differ from the store used for Aggregate state.

Read Model stores are selected for retrieval performance and query characteristics, not for business consistency guarantees.

Read Model schemas evolve independently of Aggregate persistence schemas.

### 10.4 Write Ownership

Projections are the sole components authorised to write to Read Model stores.

No other component — including Application Handlers, Repositories, Domain Services, and other Projections — SHALL write to a Read Model store (SA-005 I-017, SA-006 §12.6).

### 10.5 Disposability

Read Models are derived projections of Domain Events. Their persistence is rebuildable.

A Read Model MAY be rebuilt by replaying the Domain Events that produced it (SA-006 §12.5).

Clearing and rebuilding a Read Model store has no effect on Aggregate state.

### 10.6 Query Access

Query operations SHALL NOT access Aggregate Repositories.

Query Handlers access Read Model stores exclusively (SA-005 D-005).

---

## 11. Repository Contracts

### 11.1 Principle

A Repository contract is a port. Its scope defines the coupling surface between the Application layer and the persistence infrastructure. A contract focused on Aggregate retrieval and persistence is stable, independently evolvable, and consistent with SA-P-0010.

### 11.2 Permitted Operations

Repository contracts SHALL expose only operations required to retrieve and persist Aggregate Roots.

Permitted operations include:

- retrieve an Aggregate Root by its identity;
- retrieve an Aggregate Root by a business key where a business operation requires it and uniqueness is guaranteed by the Domain Model;
- persist an Aggregate Root.

### 11.3 Prohibited Operations

Read-oriented operations SHALL belong exclusively to the Query Model.

Repository contracts SHALL NOT expose:

- filtered collection retrieval;
- search operations;
- aggregate computations;
- projection retrieval returning partial Aggregate data;
- Read Model retrieval.

### 11.4 Contract Location

Repository contracts SHALL be defined in the Application layer as ports (SA-003 §5, SA-005 §8).

Repository implementations SHALL be located in the Infrastructure layer.

The Application layer depends on the contract. The Application layer SHALL NOT depend on the implementation.

---

## 12. Persistence Ignorance

### 12.1 Principle

The Domain Model is the most stable layer of the MedLink architecture. It embodies certified domain knowledge whose lifetime must exceed the lifetime of any persistence technology. The Domain Model must not carry knowledge of how it is stored.

### 12.2 Domain Independence

The Domain Model SHALL remain persistence ignorant.

Domain Models SHALL NOT depend on persistence technologies, storage representations, or persistence mechanisms.

Domain Models SHALL NOT carry persistence annotations or storage-specific attributes.

Domain Models SHALL NOT carry storage-specific base classes or storage-specific interfaces.

Domain Models SHALL NOT carry storage-specific types.

### 12.3 Scope of Persistence Ignorance

Persistence ignorance applies to the entire Domain layer:

- Aggregate Roots;
- Entities;
- Value Objects;
- Domain Events;
- Domain Services;
- Domain Policies.

No Domain layer component exposes a persistence concern.

### 12.4 Testability Consequence

A Domain Model carrying no persistence knowledge is testable in complete isolation, without any persistence infrastructure.

Domain business rules are verifiable independently of storage technologies, storage schemas, and storage availability.

### 12.5 Evolution Consequence

When a persistence technology changes, only the Infrastructure layer changes.

The Domain layer and the Application layer require no modification as a result of a persistence technology change.

---

## 13. Multi-Storage Strategy

### 13.1 Principle

Different Bounded Contexts have different persistence requirements. Aggregate state, Read Models, and event logs each have distinct access patterns. No single storage technology serves all patterns optimally. The architecture must not constrain Platform teams to a single storage technology.

### 13.2 Support Requirement

The architecture SHALL support multiple persistence technologies.

### 13.3 Independence Requirement

The Domain layer and the Application layer SHALL remain independent of any specific persistence technology.

The Domain layer SHALL NOT contain storage-technology-specific constructs.

The Application layer SHALL NOT contain storage-technology-specific constructs.

Storage technology selection is an Infrastructure concern deferred to OD-003.

### 13.4 Bounded Context Flexibility

A Bounded Context MAY use different storage technologies for Aggregate persistence and Read Model persistence.

Different Bounded Contexts within the same Platform MAY use different storage technologies.

### 13.5 Runtime Normalisation

The runtime specification SHALL define the normalised storage technologies available to MedLink Platforms.

Runtime normalisation establishes supported choices for the current runtime. It does not restrict the architectural support for multiple technologies and does not prevent future Platforms from adopting technologies appropriate to their access characteristics.

Runtime normalisation constrains the runtime, not the architecture.

---

## 14. Schema Evolution

### 14.1 Principle

As the Domain Model evolves, its persistence representation evolves correspondingly. Managing this evolution without interrupting deployed systems is an operational responsibility assigned exclusively to the Infrastructure layer.

### 14.2 Infrastructure Ownership

Schema evolution SHALL remain an Infrastructure responsibility.

The Domain layer SHALL NOT contain schema migration logic.

The Application layer SHALL NOT contain schema migration logic.

Schema changes SHALL be applied exclusively by Infrastructure-layer components.

### 14.3 Mechanism Independence

The architecture SHALL NOT mandate a specific schema migration mechanism.

The mechanism by which schema changes are applied is a runtime implementation concern deferred to OD-004.

### 14.4 Domain Layer Consequence

Because the Domain Model is persistence ignorant (§12), it carries no schema version information and no migration logic.

A business change implying a persistence schema change produces changes only in the Infrastructure layer.

No Domain layer or Application layer modification is required by a schema change alone.

---

## 15. Dependency Rules

### 15.1 Allowed Dependency Directions

The following dependencies are permitted by the persistence architecture.

| From | To | Condition |
|---|---|---|
| Presentation | Application Facade | Always |
| Presentation | Application Result | Always |
| Application Handler | Repository Contract (Port) | Always |
| Application Handler | Read Model Contract (Port) | Query Handlers only |
| Application Handler | Domain Model | Always |
| Domain Model | Domain Model | Within same Bounded Context |
| Infrastructure | Application Ports | Implements contracts |
| Repository Implementation | Domain Model | Read only — restores Aggregate state |
| Repository Implementation | Persistence Store | Always |
| Read Model Implementation | Read Model Store | Always |
| Projection | Domain Event | Within same Platform |
| Projection | Read Model Store | Write only — updates Read Model |

### 15.2 Prohibited Dependency Directions

The following dependencies are prohibited without exception. Violations require an Architecture Decision Record before implementation.

| From | To | Rule |
|---|---|---|
| Domain layer | Persistence infrastructure | SHALL NOT |
| Domain layer | Repository implementation | SHALL NOT |
| Domain layer | Storage-specific type | SHALL NOT |
| Domain layer | Storage-specific annotation | SHALL NOT |
| Application layer | Repository implementation | SHALL NOT |
| Application layer | Storage technology | SHALL NOT |
| Application layer | Schema migration component | SHALL NOT |
| Query Handler | Aggregate Repository contract | SHALL NOT |
| Repository | Domain Event bus | SHALL NOT |
| Repository | Integration Event publisher | SHALL NOT |
| Projection | Aggregate Repository contract | SHALL NOT |
| Projection | Another Projection | SHALL NOT |
| Projection | Application Handler | SHALL NOT |
| Projection | Domain Service | SHALL NOT |
| Read Model Store | Aggregate Persistence Store | SHALL NOT share boundary |
| Presentation | Domain layer | SHALL NOT |
| Presentation | Infrastructure layer | SHALL NOT |

### 15.3 Persistence Store Rules

Aggregate Persistence Stores and Read Model Stores are passive infrastructure components.

They do not depend on any application or domain component.

They do not communicate with each other.

Each Bounded Context's persistence store is owned exclusively by that Bounded Context.

No Bounded Context accesses another Bounded Context's persistence store directly.

---

## 16. Interaction Diagrams

### 16.1 Aggregate Persistence

How an Aggregate Root participates in the persistence flow without owning or initiating it.

**Diagram 16.1 — Aggregate Persistence**

```
Command Handler
        │ invokes business operation on Aggregate Root
        ▼
Aggregate Root
        │ executes business logic
        │ records Domain Event (pending — not published)
        │ returns updated state to Command Handler
        ▼
Command Handler
        │ passes Aggregate Root to Repository for persistence
        ▼
Repository
        │ translates Aggregate state → storage representation
        │ writes to Persistence Store (within active transaction)
        ▼
Persistence Store
```

The Aggregate Root does not contact the Repository.

The Aggregate Root does not manage the transaction.

The Aggregate Root does not publish events.

Persistence is initiated by the Command Handler, not by the Aggregate.

### 16.2 Repository Interaction

The two operations defined on a Repository contract: persist and retrieve.

**Diagram 16.2 — Repository Interaction**

**Persist:**

```
Command Handler
        │ calls Repository.persist(aggregateRoot)
        ▼
Repository
        │ translates Aggregate state → storage representation
        │ writes storage representation to Persistence Store
        │ (participates in active transaction — does not own it)
```

**Retrieve:**

```
Command Handler
        │ calls Repository.retrieve(identity)
        ▼
Repository
        │ reads storage representation from Persistence Store
        │ translates storage representation → Aggregate state
        │ returns restored Aggregate Root
        ▼
Command Handler
        │ Aggregate Root carries no persistence knowledge
```

No component outside the owning Repository accesses the Aggregate Root's storage representation.

### 16.3 Application Transaction

The complete transaction lifecycle from the Application Layer through persistence and into post-commit actions.

**Diagram 16.3 — Application Transaction**

```
Application Layer
        │ opens transaction
        ▼
Command Handler
        │ retrieves Aggregate Root via Repository
        │ invokes business operation
        │ Aggregate Root records Domain Event (pending)
        │ persists Aggregate Root via Repository
        ▼
Application Layer
        │ all persistence operations coordinated atomically
        │ transaction commits
        │ collects pending Domain Events from Aggregate Root
        ▼
Application Runtime
        │ publishes Domain Events to Internal Event Bus
        │ (post-commit — outside the transaction boundary)
```

Domain Event publication occurs after the transaction closes.

A rollback discards all pending Domain Events. No events are published.

### 16.4 Persistence Coordination

How the runtime coordinates multiple persistence operations atomically within a single Application transaction.

**Diagram 16.4 — Persistence Coordination**

```
Application Layer (transaction open)
        │
        ├──▶ Repository A
        │         │ operates on Aggregate Root A
        │         │ writes to Persistence Store A
        │
        └──▶ Repository B
                  │ operates on Aggregate Root B
                  │ writes to Persistence Store B
        │
Runtime coordinates atomic commit
        │
        ├── All operations succeed
        │       │
        │       ▼
        │   Transaction commits
        │   All writes visible together
        │
        └── Any operation fails
                │
                ▼
            Transaction rolls back
            All writes reversed
            No partial state visible
```

The Domain layer and Application layer are unaware of the coordination mechanism.

The coordination mechanism is a runtime implementation concern.

### 16.5 Projection Persistence

How Projections consume Domain Events and maintain Read Model state, independently of Aggregate persistence.

**Diagram 16.5 — Projection Persistence**

```
Internal Event Bus
        │ delivers Domain Event (post-commit)
        ▼
Projection
        │ applies idempotency check (SA-006 §9)
        │ derives Read Model update from Domain Event payload
        ▼
Read Model Store
        │ updated
        (store is independent from Aggregate Persistence Store)
```

Projection execution is independent of Aggregate persistence.

Projection execution is independent of other Projections (SA-006 §12.2).

A Projection failure does not affect Aggregate state, other Projections, or other Read Model stores.

A failed Projection MAY be replayed independently (SA-006 §12.5).

### 16.6 Read Model Interaction

The read path from Query Handler to Read Model store, with no involvement of Aggregate Repositories.

**Diagram 16.6 — Read Model Interaction**

```
Query Handler
        │ calls Read Model Port.retrieve(criteria)
        ▼
Read Model Implementation
        │ reads from Read Model Store
        │ returns Query Result
        ▼
Query Handler
        │ returns Query Result to caller
```

No Aggregate Root is loaded on the read path.

No transaction boundary is required for a read-only Query execution.

The Aggregate Persistence Store is not contacted.

---

## 17. Architectural Invariants

The following invariants apply to every Platform and every Bounded Context without exception.

Violations require an Architecture Decision Record before implementation.

| # | Invariant | Decision Source |
|---|---|---|
| I-001 | Each Aggregate Root SHALL be persisted exclusively through its owning Repository. | ADR-SA-007 D-001 |
| I-002 | Each Repository SHALL own exactly one Aggregate Root. A Repository SHALL NOT own multiple Aggregate Roots. | ADR-SA-007 D-001 |
| I-003 | A Repository SHALL NOT publish Domain Events. | ADR-SA-007 D-002 |
| I-004 | A Repository SHALL NOT publish Integration Events or perform any messaging responsibility. | ADR-SA-007 D-002 |
| I-005 | Each Application Use Case SHALL execute within exactly one transaction boundary. | ADR-SA-007 D-003 |
| I-006 | The transaction boundary SHALL belong to the Application Layer. The Application Layer SHALL open, commit, and roll back the transaction. | ADR-SA-007 D-003 |
| I-007 | Repository implementations SHALL participate in the active transaction. They SHALL NOT open, commit, or roll back a transaction independently. | ADR-SA-007 D-003 |
| I-008 | All persistence operations participating in the same Application transaction SHALL be committed atomically. No partial commit within a single Application transaction is permissible. | ADR-SA-007 D-004 |
| I-009 | The runtime SHALL preserve Aggregate consistency under concurrent updates. No concurrent update SHALL produce a silent state corruption. | ADR-SA-007 D-005 |
| I-010 | Persistence mapping logic SHALL reside in the Infrastructure layer. It SHALL NOT reside in the Domain layer or the Application layer. | ADR-SA-007 D-006 |
| I-011 | Aggregate Repositories SHALL persist Aggregate state exclusively. They SHALL NOT persist Read Model state or serve operations for the read path. | ADR-SA-007 D-007 |
| I-012 | Query operations SHALL NOT access Aggregate Repositories. Query Handlers SHALL access Read Model stores exclusively. | ADR-SA-007 D-007 |
| I-013 | Repository contracts SHALL expose only operations required to retrieve and persist Aggregate Roots. | ADR-SA-007 D-008 |
| I-014 | Repository contracts SHALL NOT expose retrieval-oriented operations. Retrieval-oriented operations belong exclusively to the Query Model. | ADR-SA-007 D-008 |
| I-015 | The Domain Model SHALL remain persistence ignorant. Domain Models SHALL NOT depend on persistence technologies, storage representations, or persistence mechanisms. | ADR-SA-007 D-009 |
| I-016 | No Domain layer component SHALL carry persistence annotations, storage-specific base types, or storage-specific interfaces. | ADR-SA-007 D-009 |
| I-017 | The architecture SHALL support multiple persistence technologies. The Domain layer and the Application layer SHALL remain independent of any specific persistence technology. | ADR-SA-007 D-010 |
| I-018 | Schema evolution SHALL remain an Infrastructure responsibility. The Domain layer and the Application layer SHALL NOT contain schema migration logic. | ADR-SA-007 D-011 |

---

## 18. Reference Folder Structure

Every Bounded Context SHALL follow the persistence structure below.

This structure extends the SA-003 reference structure, the SA-005 Application layer structure, and the SA-006 Projection structure.

The reference folder structure is illustrative and SHALL NOT be interpreted as a deployment structure.

```
{BoundedContext}/
│
├── Domain/                              ← Business rules only — no persistence concerns
│   └── {AggregateName}/
│       └── {AggregateName}             ← Aggregate Root — no storage knowledge
│           (Entities, Value Objects, Domain Events — no storage constructs)
│
├── Application/
│   └── Port/                           ← Persistence contracts — ports, not implementations
│       ├── {AggregateName}RepositoryPort         ← Retrieve and persist only
│       └── {ReadModelScope}ReadModelPort         ← Retrieval only
│
└── Infrastructure/
    └── Persistence/                    ← All persistence knowledge lives here
        │
        ├── Repository/                 ← Aggregate persistence responsibility
        │   ���── {AggregateName}Repository         ← One per Aggregate Root
        │
        ├── ReadModel/                  ← Read Model persistence responsibility
        │   └── {ReadModelScope}ReadModel         ← Independent from Aggregate store
        │
        └── Projection/                 ← Read Model maintenance responsibility
            └── {ReadModelScope}Projection        ← Sole writer to its Read Model store
```

### Structural Rules

- `Domain/` contains no persistence annotations, storage-specific types, base classes, or migration logic. All Domain layer components are plain business objects.
- `Application/Port/` contains Repository contracts and Read Model access contracts. Repository contracts expose only the operations permitted by §11.2. Read Model contracts expose only retrieval operations. Neither contract exposes the other's operations.
- `Infrastructure/Persistence/Repository/` contains exactly one Repository implementation per Aggregate Root. No implementation owns more than one Aggregate Root. No implementation contains event publication logic.
- `Infrastructure/Persistence/ReadModel/` contains Read Model implementations accessing stores independent from Aggregate Persistence Stores.
- `Infrastructure/Persistence/Projection/` contains Projection implementations. Each Projection is the sole writer to its Read Model store and independently tracks its progress through the Domain Event stream.
- Schema evolution components reside within `Infrastructure/Persistence/` and are invisible to the Domain and Application layers.
- No cross-Bounded-Context imports are permitted within `Infrastructure/Persistence/`.

### Naming Conventions

| Artifact | Convention | Example |
|---|---|---|
| Repository port | `{AggregateName}RepositoryPort` | `ClinicalActivityRepositoryPort` |
| Repository implementation | `{AggregateName}Repository` | `ClinicalActivityRepository` |
| Read Model port | `{ReadModelScope}ReadModelPort` | `PatientTimelineReadModelPort` |
| Read Model implementation | `{ReadModelScope}ReadModel` | `PatientTimelineReadModel` |
| Projection | `{ReadModelScope}Projection` | `PatientTimelineProjection` |

---

## 19. Cross-document Alignment

### 19.1 SA-001 — Reference Architecture

SA-001 SA-P-005 (Dependency Direction) establishes that Infrastructure implements Domain contracts and that the Domain layer never depends on Infrastructure.

SA-007 §12 enforces this principle in the persistence layer through persistence ignorance. I-015 and I-016 make the prohibition independently verifiable.

SA-001 SA-P-006 (Framework Independence) establishes that business rules remain independent of frameworks. SA-007 extends this to the persistence layer: no framework-specific or storage-specific construct appears in the Domain or Application layers. All persistence framework dependencies are confined to the Infrastructure layer.

SA-001 SA-P-0010 (Single Architectural Responsibility) is applied in §3 with an explicit building block table. Each persistence building block in this document owns exactly one responsibility.

### 19.2 SA-002 — Platform Architecture

SA-002 §3 defines Platform Building Blocks including Infrastructure as a first-class layer.

SA-007 locates all persistence implementation — Repository implementations, mapping logic, concurrency control, and schema evolution — exclusively in the Infrastructure layer, consistent with SA-002's Platform layering model.

No cross-Platform persistence dependency is permitted. Each Platform owns its persistence stores independently.

### 19.3 SA-003 — Bounded Context Architecture

SA-003 §5 defines Repository as an Application-layer port with an Infrastructure-layer implementation.

SA-007 §11 and §18 formalise this structure. Repository ports are Application-layer contracts. Repository implementations are Infrastructure-layer adapters. No other layer holds persistence authority for any Aggregate Root.

SA-003 §7 (Infrastructure Layer) designates Infrastructure as the location for persistence adapters. SA-007 §9 and §18 confirm this: mapping logic, concurrency control, and schema evolution components reside in the Infrastructure layer.

### 19.4 SA-004 — Runtime Architecture

SA-004 defines the runtime implementation specification of the MedLink Architecture.

SA-007 provides the technology-neutral persistence architecture that SA-004 implements. SA-004 defines how the guarantees established in SA-007 are delivered within the chosen runtime: which approach coordinates transactions (OD-001), how concurrency is controlled, and how schema changes are applied (OD-004).

SA-007 does not contradict SA-004. SA-004 does not modify any guarantee established by SA-007.

### 19.5 SA-005 — Application & CQRS Architecture

**Transaction ownership**: SA-005 D-003 assigns transaction ownership to Command Handlers and declares Aggregates transaction-agnostic. SA-007 D-003 expresses the persistence consequence: the transaction opened by the Command Handler is the transaction in which all Repository operations execute. SA-007 §6.2 clarifies that the Command Handler owns the transaction on behalf of the Application Layer — these statements describe the same architectural responsibility at different abstraction levels. I-005, I-006, and I-007 make this independently verifiable.

**CQRS persistence separation**: SA-005 D-005 (Query Handlers access Read Models exclusively) and SA-005 D-006 (Projections maintain Read Models) are enforced at the persistence level by SA-007 D-007. I-011 and I-012 make this verifiable at the structural level.

**Domain Event publication**: SA-005 D-008 (Domain Events published after commit by Application Runtime) is protected by SA-007 D-002. Repositories do not publish events. I-003 makes this independently verifiable.

**Read Model write ownership**: SA-005 I-017 (only the owning Projection writes to a Read Model) is reinforced by SA-007 §10.4. Projections are the sole writers to Read Model stores.

**Independent evolvability**: SA-005 I-018 (write path and read path remain independently evolvable) is structurally guaranteed by SA-007 D-007: independent persistence stores cannot constrain each other's evolution.

**Repository Port**: SA-005 §8 defines the Repository Port as an Application-layer contract. SA-007 §11 formalises the scope of that contract.

### 19.6 SA-006 — Event-Driven Architecture

**Projection Architecture**: SA-006 §12 defines Projections as independent consumers of the Internal Event Bus maintaining Read Models. SA-007 §10 and §18 define the persistence infrastructure those Projections use: a dedicated Read Model store, independent from Aggregate persistence, with the Projection as the sole writer.

**Projection Replay**: SA-006 §12.5 (Projections MAY be replayed independently) is structurally enabled by SA-007 §10.5. Read Models are disposable because they are persisted independently from Aggregate state.

**Event Publication Boundary**: SA-006 I-003 (Aggregates SHALL NEVER create Integration Events) and I-004 (Application Handlers SHALL NEVER create Integration Events) are reinforced at the persistence layer by SA-007 D-002. I-003 and I-004 extend this prohibition to Repository implementations.

---

## 20. Open Decisions

The following decisions are open. They remain implementation concerns and SHALL NOT be resolved without promotion through a future Architecture Decision Record.

| ID | Decision | Architectural Scope |
|---|---|---|
| OD-001 | **Application Result in the persistence context** — whether persistence-generated data (such as system-assigned identities) influences the Application Result returned by the Command Handler, or whether the Command Handler derives Application Results independently of Repository output. This Open Decision is owned by SA-005 (SA-005 §20 OD-001). It is referenced here only because persistence-generated information MAY influence the Application Result. Resolution belongs to SA-005. | §11.2, SA-005 §20 OD-001 |
| OD-002 | **Repository retrieval semantics** — the defined contract behaviour of a Repository when the requested Aggregate Root does not exist: whether the contract signals absence through an empty result, a typed absence value, a domain exception, or another defined response | §11.2 |
| OD-003 | **Persistence technology selection** — which storage technologies are normalised for Aggregate state, Read Model state, and event logs in the MedLink runtime | §13.5 |
| OD-004 | **Schema migration strategy** — the tooling, sequencing approach, and rollback strategy for applying persistence schema changes in the MedLink runtime | §14.3 |

---

## 21. References

- SA-001 — Reference Architecture (SA-P-0010, SA-P-0011, SA-P-005, SA-P-006)
- SA-002 — Platform Architecture (§3 Platform Building Blocks)
- SA-003 — Bounded Context Architecture (§5 Building Blocks — Repository, §7 Infrastructure Layer)
- SA-004 — Runtime Architecture (runtime implementation specification of SA-007 guarantees)
- SA-005 — Application & CQRS Architecture (D-003 Transaction Ownership, D-005 Query Model, D-006 Projection Model, D-008 Domain Event Publication, §8 Repository Port, §13 Domain Event Lifecycle, §14 Projections, I-017, I-018)
- SA-006 — Event-Driven Architecture (§6.3 Platform Integration Layer, §12 Projection Architecture, §12.5 Replay, §12.6 Read Model Update, I-003, I-004)
- ADR-SA-007 — Architectural Decision Register D-001 through D-011
- ADR-0003 — Hexagonal Architecture
- ADR-0004 — CQRS
