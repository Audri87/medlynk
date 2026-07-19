# RVS-001 — Reference Vertical Slice Design

**Document ID**: RVS-001
**Title**: Clinical Contribution Lifecycle
**Status**: Release v1.0
**Version**: 1.0
**Classification**: Official Implementation Reference

**Implements**:

- SA-001 — Reference Architecture
- SA-002 — Platform Architecture
- SA-003 — Bounded Context Architecture
- SA-004 — Runtime Architecture
- SA-005 — Application & CQRS Architecture
- SA-006 — Event-Driven Architecture
- SA-007 — Persistence Architecture

**Validates**:

> "If a new developer joins MedLink tomorrow, can they implement this feature without wondering where each class belongs?"

---

## 1. Business Scenario

A Practitioner creates a Clinical Contribution to a Patient's Care Record — a structured clinical observation capturing findings, assessments, or interventions pertaining to that patient.

The contribution traverses three lifecycle states:

**Draft** — the contribution has been recorded but not yet verified against domain invariants.

**Validated** — the contribution satisfies all domain invariants; it is structurally and semantically coherent.

**Approved** — an authorized Practitioner has formally endorsed the contribution. The contribution is immutable from this point.

At each state transition, the Aggregate records a Domain Event.

After the transaction commits, the Application Runtime publishes those events to the Internal Event Bus.

Projections consume the published events, update Read Model stores, and make the updated timeline available for query.

The Practitioner's Workspace is refreshed from the updated Read Model, completing the lifecycle.

---

## 2. Actors

| Actor | Role in this Slice |
|---|---|
| Contributing Practitioner | Initiates the Clinical Contribution. Triggers Create and Validate. |
| Approving Practitioner | Holds approval authority. Triggers Approve. |
| Patient | Beneficiary. Passive in this technical flow — referenced by CareRecordId. |
| Application Runtime | Coordinates the transaction, collects pending Domain Events post-commit, publishes to Internal Event Bus. |

---

## 3. Use Cases

### UC-001 — Create Clinical Contribution

**Actor**: Contributing Practitioner

**Trigger**: Practitioner submits a new clinical observation for a Patient's Care Record.

**Precondition**: Practitioner identity is authenticated. CareRecordId is known.

**Command**: `CreateClinicalContribution`

**Outcome**: `ClinicalContribution` aggregate created in `Draft` state. `ClinicalContributionCreated` recorded.

**Postcondition**: Contribution persisted. Event published to Internal Event Bus.

---

### UC-002 — Validate Clinical Contribution

**Actor**: Contributing Practitioner (or system-dispatched after UC-001)

**Trigger**: Practitioner requests validation. Precondition: contribution is in `Draft` state.

**Precondition**: `ClinicalContribution` exists in `Draft` state.

**Command**: `ValidateClinicalContribution`

**Outcome (success)**: Contribution transitions to `Validated`. `ClinicalContributionValidated` recorded.

**Outcome (failure)**: Contribution remains in `Draft`. `ClinicalContributionValidationFailed` recorded.

**Postcondition**: Contribution persisted. Event published.

---

### UC-003 — Approve Clinical Contribution

**Actor**: Approving Practitioner

**Trigger**: Practitioner with approval authority endorses the contribution.

**Precondition**: `ClinicalContribution` exists in `Validated` state. Approving Practitioner identity is authenticated.

**Command**: `ApproveClinicalContribution`

**Outcome**: Contribution transitions to `Approved`. Immutability enforced. `ClinicalContributionApproved` recorded.

**Postcondition**: Contribution persisted. Event published.

---

### UC-004 — Query Patient Timeline

**Actor**: Practitioner (read access)

**Trigger**: Workspace load or explicit timeline refresh.

**Precondition**: `CareRecordId` is known. Patient Timeline Read Model is populated.

**Query**: `GetPatientTimeline`

**Outcome**: `PatientTimelineView` returned. Workspace rendered.

**Postcondition**: No state change. No transaction required.

---

## 4. Aggregate Roots

### ClinicalContribution

**Platform**: Clinical

**Bounded Context**: ClinicalContribution

**Identity**: `ClinicalContributionId` (UUID)

**Single Responsibility**: Enforces the complete lifecycle of one clinical contribution — from creation through validation to approval — and records a Domain Event for every state transition.

**States**: `Draft` → `Validated` → `Approved`

**Business Invariants**:

| # | Invariant |
|---|---|
| BI-001 | A ClinicalContribution must carry a non-empty ClinicalText at creation. |
| BI-002 | A ClinicalContribution must reference a valid CareRecordId at creation. |
| BI-003 | A ClinicalContribution must reference a ContributingPractitionerId at creation. |
| BI-004 | Validation may only be attempted when status is `Draft`. |
| BI-005 | Approval may only be attempted when status is `Validated`. |
| BI-006 | An `Approved` ClinicalContribution is immutable. No further state transitions are permitted. |
| BI-007 | Approval requires a distinct ApprovingPractitionerId (pending domain rule: may differ from ContributingPractitionerId). |

**Business Operations**:

| Operation | Precondition | Records |
|---|---|---|
| `create(careRecordId, practitionerId, clinicalText, timestamp)` | None — factory operation | `ClinicalContributionCreated` |
| `validate()` | Status = `Draft` | `ClinicalContributionValidated` or `ClinicalContributionValidationFailed` |
| `approve(approvingPractitionerId, timestamp)` | Status = `Validated` | `ClinicalContributionApproved` |

---

## 5. Entities

### ClinicalContent

**Belongs to**: `ClinicalContribution` aggregate

**Single Responsibility**: Holds the structured clinical payload of one contribution — text, clinical category, and recording timestamp.

**Identity**: Position within the Aggregate. No independent lifecycle. Not persisted separately.

**Fields**:

| Field | Type |
|---|---|
| text | `ClinicalText` |
| recordedAt | `ContributionTimestamp` |

---

### ContributorRole

**Belongs to**: `ClinicalContribution` aggregate

**Single Responsibility**: Captures the role the Contributing Practitioner held at the moment of contribution — per ADR-0007 (Roles on Relations).

**Identity**: Position within the Aggregate. No independent lifecycle. Not persisted separately.

**Fields**:

| Field | Type |
|---|---|
| practitionerId | `PractitionerId` |
| role | `ContributorRoleType` (Value Object — enumeration) |

---

## 6. Value Objects

| Value Object | Wraps | Invariant |
|---|---|---|
| `ClinicalContributionId` | UUID | Non-null. Immutable. Format-validated. |
| `CareRecordId` | UUID | Non-null. Immutable. |
| `PractitionerId` | UUID | Non-null. Immutable. |
| `ClinicalText` | string | Non-empty after trim. Immutable. Maximum length enforced. |
| `ContributionStatus` | enumeration | `Draft`, `Validated`, `Approved`. No other values permitted. |
| `ContributorRoleType` | enumeration | Per ADR-0007 role vocabulary. Immutable. |
| `ContributionTimestamp` | DateTimeImmutable (UTC) | Non-null. UTC enforced. Immutable. |
| `ApprovalReference` | `PractitionerId` + `ContributionTimestamp` | Captures approver identity and approval moment atomically. Immutable. |

All Value Objects are immutable. Construction fails if invariants are violated. No setter methods.

---

## 7. Domain Events

Domain Events are immutable records of facts. They carry only the data required by downstream Projections. They are recorded by the Aggregate during a business operation and collected by the Application Runtime after transaction commit.

### ClinicalContributionCreated

**Meaning**: A new Clinical Contribution has been recorded in `Draft` state.

| Field | Type |
|---|---|
| `clinicalContributionId` | `ClinicalContributionId` |
| `careRecordId` | `CareRecordId` |
| `contributingPractitionerId` | `PractitionerId` |
| `clinicalText` | `ClinicalText` |
| `occurredAt` | `ContributionTimestamp` |

---

### ClinicalContributionValidated

**Meaning**: The contribution has passed all domain invariant checks. It is ready for approval.

| Field | Type |
|---|---|
| `clinicalContributionId` | `ClinicalContributionId` |
| `careRecordId` | `CareRecordId` |
| `occurredAt` | `ContributionTimestamp` |

---

### ClinicalContributionValidationFailed

**Meaning**: The contribution failed one or more domain invariant checks. It remains in `Draft`.

| Field | Type |
|---|---|
| `clinicalContributionId` | `ClinicalContributionId` |
| `careRecordId` | `CareRecordId` |
| `failureReason` | string |
| `occurredAt` | `ContributionTimestamp` |

---

### ClinicalContributionApproved

**Meaning**: An authorized Practitioner has formally endorsed the contribution. The contribution is now immutable.

| Field | Type |
|---|---|
| `clinicalContributionId` | `ClinicalContributionId` |
| `careRecordId` | `CareRecordId` |
| `approvingPractitionerId` | `PractitionerId` |
| `approvedAt` | `ContributionTimestamp` |

---

## 8. Commands

Commands express intent. Each Command is handled by exactly one Command Handler. Commands are dispatched via the `command.bus`.

### CreateClinicalContribution

**Intent**: Record a new clinical contribution in Draft state.

| Field | Type |
|---|---|
| `careRecordId` | `CareRecordId` |
| `contributingPractitionerId` | `PractitionerId` |
| `clinicalText` | `ClinicalText` |
| `requestedAt` | `ContributionTimestamp` |

---

### ValidateClinicalContribution

**Intent**: Trigger domain invariant validation on a Draft contribution.

| Field | Type |
|---|---|
| `clinicalContributionId` | `ClinicalContributionId` |

---

### ApproveClinicalContribution

**Intent**: Formally approve a Validated contribution.

| Field | Type |
|---|---|
| `clinicalContributionId` | `ClinicalContributionId` |
| `approvingPractitionerId` | `PractitionerId` |
| `approvedAt` | `ContributionTimestamp` |

---

## 9. Queries

Queries express information needs. Each Query is handled by exactly one Query Handler. Queries are dispatched via the `query.bus`. Queries carry no side effects.

### GetPatientTimeline

**Intent**: Retrieve the ordered timeline of approved clinical contributions for a Care Record.

| Field | Type |
|---|---|
| `careRecordId` | `CareRecordId` |
| `pageSize` | integer |
| `pageToken` | string (nullable) |

**Returns**: `PatientTimelineView`

---

### GetClinicalContributionDetail

**Intent**: Retrieve the full detail of one Clinical Contribution.

| Field | Type |
|---|---|
| `clinicalContributionId` | `ClinicalContributionId` |

**Returns**: `ClinicalContributionDetailView`

---

## 10. Command Handlers

Each Command Handler owns exactly one transaction boundary, on behalf of the Application Layer (SA-007 §6.2, SA-005 D-003).

### CreateClinicalContributionHandler

**Single Responsibility**: Execute the Create Clinical Contribution use case within one transaction boundary.

**Execution sequence**:

1. Runtime opens transaction.
2. Handler creates `ClinicalContribution` aggregate via factory operation `create(...)`.
3. Aggregate records `ClinicalContributionCreated` (pending — not yet published).
4. Handler calls `ClinicalContributionRepositoryPort.persist(aggregate)`.
5. Runtime commits transaction.
6. Runtime collects pending Domain Events from aggregate.
7. Runtime publishes `ClinicalContributionCreated` to Internal Event Bus.
8. Handler returns `ApplicationResult` (pending OD-001 resolution).

**Dependencies**:

- `ClinicalContributionRepositoryPort` (Application Port — never the implementation)
- `ClinicalContribution` (Domain Model)

**Does not depend on**:

- `ClinicalContributionRepository` (Infrastructure)
- Any Read Model Port
- Any event bus directly

---

### ValidateClinicalContributionHandler

**Single Responsibility**: Execute the Validate Clinical Contribution use case within one transaction boundary.

**Execution sequence**:

1. Runtime opens transaction.
2. Handler retrieves `ClinicalContribution` via `ClinicalContributionRepositoryPort.retrieve(id)`.
3. Handler calls `aggregate.validate()`.
4. Aggregate records `ClinicalContributionValidated` or `ClinicalContributionValidationFailed` (pending).
5. Handler calls `ClinicalContributionRepositoryPort.persist(aggregate)`.
6. Runtime commits transaction.
7. Runtime collects pending Domain Events.
8. Runtime publishes event to Internal Event Bus.
9. Handler returns `ApplicationResult`.

**Dependencies**:

- `ClinicalContributionRepositoryPort`
- `ClinicalContribution` (Domain Model)

---

### ApproveClinicalContributionHandler

**Single Responsibility**: Execute the Approve Clinical Contribution use case within one transaction boundary.

**Execution sequence**:

1. Runtime opens transaction.
2. Handler retrieves `ClinicalContribution` via `ClinicalContributionRepositoryPort.retrieve(id)`.
3. Aggregate enforces BI-005 — status must be `Validated`. Fails if not.
4. Handler calls `aggregate.approve(approvingPractitionerId, approvedAt)`.
5. Aggregate records `ClinicalContributionApproved` (pending).
6. Handler calls `ClinicalContributionRepositoryPort.persist(aggregate)`.
7. Runtime commits transaction.
8. Runtime collects pending Domain Events.
9. Runtime publishes `ClinicalContributionApproved` to Internal Event Bus.
10. Handler returns `ApplicationResult`.

**Dependencies**:

- `ClinicalContributionRepositoryPort`
- `ClinicalContribution` (Domain Model)

---

## 11. Query Handlers

Query Handlers access Read Model Ports exclusively. They never access Aggregate Repository Ports (SA-007 I-012). No transaction is required.

### GetPatientTimelineHandler

**Single Responsibility**: Retrieve the Patient Timeline View from the Read Model and return it to the caller.

**Execution sequence**:

1. Handler calls `PatientTimelineReadModelPort.getTimeline(careRecordId, pageSize, pageToken)`.
2. Returns `PatientTimelineView`.

**Dependencies**:

- `PatientTimelineReadModelPort` (Application Port)

**Does not depend on**:

- `ClinicalContributionRepositoryPort`
- Any Aggregate or Domain Model
- Any transaction mechanism

---

### GetClinicalContributionDetailHandler

**Single Responsibility**: Retrieve the Clinical Contribution Detail View from the Read Model and return it.

**Execution sequence**:

1. Handler calls `ClinicalContributionDetailReadModelPort.getDetail(clinicalContributionId)`.
2. Returns `ClinicalContributionDetailView`.

**Dependencies**:

- `ClinicalContributionDetailReadModelPort` (Application Port)

---

## 12. Repository Ports

Repository Ports are contracts defined in the Application layer. They expose only retrieve and persist operations (SA-007 I-013, I-014).

### ClinicalContributionRepositoryPort

**Location**: `Application/Port/`

**Single Responsibility**: Define the persistence contract for the `ClinicalContribution` Aggregate Root.

**Operations**:

| Operation | Signature | Condition |
|---|---|---|
| `retrieve` | `retrieve(ClinicalContributionId): ClinicalContribution` | Returns the aggregate; behaviour when not found pending OD-002 |
| `persist` | `persist(ClinicalContribution): void` | Persists aggregate state |

**Prohibited from exposing**:

- Filtered collection retrieval
- Search operations
- Partial aggregate data
- Any Read Model data

---

## 13. Repository Implementations

Repository implementations reside in the Infrastructure layer. They implement the Application Port. They are invisible to Command Handlers.

### ClinicalContributionRepository

**Location**: `Infrastructure/Persistence/Repository/`

**Implements**: `ClinicalContributionRepositoryPort`

**Single Responsibility**: Translate `ClinicalContribution` aggregate state to and from its persistence representation, within the active Application transaction.

**Architectural guarantees delivered**:

| Guarantee | Source |
|---|---|
| Persists exactly one Aggregate Root: `ClinicalContribution` | SA-007 I-001, I-002 |
| Participates in the active Application transaction — does not own it | SA-007 I-007 |
| Does not publish Domain Events | SA-007 I-003 |
| Does not publish Integration Events | SA-007 I-004 |
| Translates Aggregate state ↔ persistence representation within Infrastructure layer | SA-007 I-010 |
| Concurrency control coordinated within Infrastructure layer | SA-007 I-009 |

**Does not depend on**:

- Any Command Handler
- Any event bus
- Any Read Model

---

## 14. Read Model Ports

Read Model Ports are contracts defined in the Application layer. They expose retrieval operations for Query Handlers.

### PatientTimelineReadModelPort

**Location**: `Application/Port/`

**Single Responsibility**: Define the retrieval contract for the Patient Timeline Read Model.

**Operations**:

| Operation | Signature |
|---|---|
| `getTimeline` | `getTimeline(CareRecordId, pageSize, pageToken): PatientTimelineView` |

---

### ClinicalContributionDetailReadModelPort

**Location**: `Application/Port/`

**Single Responsibility**: Define the retrieval contract for the Clinical Contribution Detail Read Model.

**Operations**:

| Operation | Signature |
|---|---|
| `getDetail` | `getDetail(ClinicalContributionId): ClinicalContributionDetailView` |

---

## 15. Read Model Implementations

Read Model implementations reside in the Infrastructure layer. They access Read Model stores that are independent from Aggregate Persistence stores (SA-007 I-011).

### PatientTimelineReadModel

**Location**: `Infrastructure/Persistence/ReadModel/`

**Implements**: `PatientTimelineReadModelPort`

**Single Responsibility**: Read the Patient Timeline from the Read Model store and return a `PatientTimelineView`.

**Architectural guarantees**:

- Reads from a store independent from the Aggregate Persistence store (SA-007 §10.3).
- Written exclusively by `PatientTimelineProjection` — this implementation has no write authority (SA-007 §10.4).

---

### ClinicalContributionDetailReadModel

**Location**: `Infrastructure/Persistence/ReadModel/`

**Implements**: `ClinicalContributionDetailReadModelPort`

**Single Responsibility**: Read Clinical Contribution detail from the Read Model store and return a `ClinicalContributionDetailView`.

**Architectural guarantees**:

- Store independent from Aggregate Persistence store.
- Written exclusively by `ClinicalContributionDetailProjection`.

---

## 16. Projections

Projections are the sole writers to their Read Model stores (SA-007 §10.4, SA-006 §12.6). Each Projection is an independent consumer of the Internal Event Bus. Failure of one Projection does not affect another (SA-006 §12.2). Each Projection is independently replayable (SA-007 §10.5).

### PatientTimelineProjection

**Location**: `Infrastructure/Persistence/Projection/`

**Single Responsibility**: Maintain the Patient Timeline Read Model by consuming Clinical Contribution Domain Events.

**Consumes**:

| Domain Event | Action |
|---|---|
| `ClinicalContributionCreated` | Appends a new pending entry to the timeline |
| `ClinicalContributionValidated` | Updates entry status to validated |
| `ClinicalContributionApproved` | Updates entry status to approved; marks entry as visible in timeline |

**Idempotency**: Each event is checked for prior processing before application (SA-006 §9).

**Sole writer to**: Patient Timeline Read Model store.

**Does not depend on**: `ClinicalContributionRepositoryPort`, Application Handlers, other Projections, Domain Services.

**Replayability**: Because the Read Model store is independent from the Aggregate Persistence store, the Projection may be reset and replayed from any point in the event stream without affecting business state (SA-007 §10.5).

---

### ClinicalContributionDetailProjection

**Location**: `Infrastructure/Persistence/Projection/`

**Single Responsibility**: Maintain the Clinical Contribution Detail Read Model.

**Consumes**:

| Domain Event | Action |
|---|---|
| `ClinicalContributionCreated` | Creates detail record with Draft status |
| `ClinicalContributionValidated` | Updates detail record status to Validated |
| `ClinicalContributionValidationFailed` | Records failure reason on detail record |
| `ClinicalContributionApproved` | Updates detail record status to Approved; records approver |

**Sole writer to**: Clinical Contribution Detail Read Model store.

---

### WorkspaceProjection

**Location**: `src/Workspace/Infrastructure/Persistence/Projection/`

**Single Responsibility**: Refresh the Practitioner Workspace Read Model when a Clinical Contribution is approved.

**Consumes**:

| Domain Event | Action |
|---|---|
| `ClinicalContributionApproved` | Appends workspace refresh signal for the contributing Practitioner's workspace |

**Sole writer to**: Practitioner Workspace Read Model store.

**Platform boundary note**: `ClinicalContributionApproved` is a Domain Event within the Clinical Platform. The Workspace module consumes it from the Internal Event Bus. Cross-Platform communication would use Integration Events dispatched by the Platform Integration Layer (SA-006 §6.3, ADR-0014).

---

## 17. Application Facades

### ClinicalContributionFacade

**Location**: `Application/`

**Single Responsibility**: Provide the single entry point for all use cases in the ClinicalContribution Bounded Context. Dispatches Commands and Queries to their respective buses. Contains no business logic.

**Write operations dispatched**:

| Method | Dispatches | Bus |
|---|---|---|
| `createContribution(CreateClinicalContribution)` | `CreateClinicalContribution` command | `command.bus` |
| `validateContribution(ValidateClinicalContribution)` | `ValidateClinicalContribution` command | `command.bus` |
| `approveContribution(ApproveClinicalContribution)` | `ApproveClinicalContribution` command | `command.bus` |

**Read operations dispatched**:

| Method | Dispatches | Bus |
|---|---|---|
| `getPatientTimeline(GetPatientTimeline)` | `GetPatientTimeline` query | `query.bus` |
| `getContributionDetail(GetClinicalContributionDetail)` | `GetClinicalContributionDetail` query | `query.bus` |

**Does not contain**: business logic, validation logic, persistence logic, event publication logic.

**Consumed by**: API Platform State Processors and State Providers.

---

## 18. Runtime Responsibilities

The Application Runtime carries responsibilities that no Domain or Application class owns.

### Transaction Coordination

| Responsibility | Rule |
|---|---|
| Opens transaction before Command Handler executes | SA-007 §6.2 |
| Coordinates all `persist()` calls within the transaction atomically | SA-007 D-004 |
| Commits transaction after all use case operations succeed | SA-007 §6.2 |
| Rolls back on any failure | SA-007 §6.2 |
| Discards all pending Domain Events upon rollback | SA-007 §6.5 |

### Domain Event Lifecycle

| Responsibility | Rule |
|---|---|
| Collects pending Domain Events from the Aggregate after transaction commits | SA-005 §13.3 |
| Publishes collected events to Internal Event Bus | SA-005 §13.4, SA-006 §5 |
| Does not publish events if the transaction rolled back | SA-007 §6.5 |
| No events published inside the transaction boundary | SA-005 D-008 |

### Concurrency Control

| Responsibility | Rule |
|---|---|
| Preserves `ClinicalContribution` state consistency under concurrent updates | SA-007 D-005 |
| Detects conflicts; prevents silent state corruption | SA-007 §8.2 |
| Coordination within Infrastructure layer | SA-007 §8.4 |
| Mechanism not mandated by this specification | SA-007 §8.3 |

### Reliable Delivery

| Responsibility | Rule |
|---|---|
| Internal Event Bus provides at-least-once delivery to Projections | SA-006 §8 |
| Failed Projection executions are retried per retry policy | SA-006 §8.3 |
| Permanently undeliverable events reach Dead Letter Store | SA-006 §8.4 |

### Bus Routing

| Bus | Routes |
|---|---|
| `command.bus` | `CreateClinicalContribution` → `CreateClinicalContributionHandler` |
| `command.bus` | `ValidateClinicalContribution` → `ValidateClinicalContributionHandler` |
| `command.bus` | `ApproveClinicalContribution` → `ApproveClinicalContributionHandler` |
| `query.bus` | `GetPatientTimeline` → `GetPatientTimelineHandler` |
| `query.bus` | `GetClinicalContributionDetail` → `GetClinicalContributionDetailHandler` |
| `event.bus` | `ClinicalContributionApproved` → `PatientTimelineProjection` |
| `event.bus` | `ClinicalContributionApproved` → `ClinicalContributionDetailProjection` |
| `event.bus` | `ClinicalContributionApproved` → `WorkspaceProjection` |

---

## 19. Interaction Flow

### Write Path A — Create Clinical Contribution

```
1.  Practitioner → POST /api/v1/clinical-contributions
2.  API Platform → dispatches CreateClinicalContribution to command.bus
3.  command.bus → routes to CreateClinicalContributionHandler
4.  Runtime → opens transaction
5.  Handler → creates ClinicalContribution aggregate (factory)
6.  Aggregate → executes create() — records ClinicalContributionCreated (pending)
7.  Handler → calls ClinicalContributionRepositoryPort.persist(aggregate)
8.  ClinicalContributionRepository → translates aggregate state → persistence representation
9.  ClinicalContributionRepository → writes to Aggregate Persistence Store (within transaction)
10. Runtime → commits transaction
11. Runtime → collects ClinicalContributionCreated from aggregate
12. Runtime → publishes ClinicalContributionCreated to Internal Event Bus
13. Handler → returns ApplicationResult
14. API Platform → returns HTTP 201 to Practitioner
```

### Write Path B — Approve Clinical Contribution

```
1.  Practitioner → POST /api/v1/clinical-contributions/{id}/approve
2.  API Platform → dispatches ApproveClinicalContribution to command.bus
3.  command.bus → routes to ApproveClinicalContributionHandler
4.  Runtime → opens transaction
5.  Handler → calls ClinicalContributionRepositoryPort.retrieve(id)
6.  ClinicalContributionRepository → reads from Aggregate Persistence Store
7.  ClinicalContributionRepository → translates persistence representation → aggregate state
8.  Handler → calls aggregate.approve(approvingPractitionerId, approvedAt)
9.  Aggregate → enforces BI-005 (status must be Validated)
10. Aggregate → records ClinicalContributionApproved (pending)
11. Handler → calls ClinicalContributionRepositoryPort.persist(aggregate)
12. ClinicalContributionRepository → writes updated state to Aggregate Persistence Store
13. Runtime → commits transaction
14. Runtime → collects ClinicalContributionApproved
15. Runtime → publishes ClinicalContributionApproved to Internal Event Bus
16. Handler → returns ApplicationResult
```

### Projection Path — Patient Timeline Update

```
17. Internal Event Bus → delivers ClinicalContributionApproved to PatientTimelineProjection
18. PatientTimelineProjection → applies idempotency check
19. PatientTimelineProjection → derives PatientTimeline update from event payload
20. PatientTimelineProjection → writes update to Patient Timeline Read Model Store
21. PatientTimelineProjection → records event position (independent progress tracking)

    (Simultaneously, in parallel — independent of step 17-21:)

22. Internal Event Bus → delivers ClinicalContributionApproved to ClinicalContributionDetailProjection
23. ClinicalContributionDetailProjection → applies idempotency check
24. ClinicalContributionDetailProjection → updates ClinicalContributionDetail Read Model Store

25. Internal Event Bus → delivers ClinicalContributionApproved to WorkspaceProjection
26. WorkspaceProjection → applies idempotency check
27. WorkspaceProjection → writes workspace refresh signal to Practitioner Workspace Read Model Store
```

### Read Path — Query Patient Timeline (Workspace Refresh)

```
28. Practitioner → GET /api/v1/care-records/{id}/timeline
29. API Platform → dispatches GetPatientTimeline to query.bus
30. query.bus → routes to GetPatientTimelineHandler
31. Handler → calls PatientTimelineReadModelPort.getTimeline(careRecordId, pageSize, pageToken)
32. PatientTimelineReadModel → reads from Patient Timeline Read Model Store
33. PatientTimelineReadModel → returns PatientTimelineView
34. Handler → returns PatientTimelineView
35. API Platform → renders workspace with updated timeline
36. Practitioner → sees approved Clinical Contribution in timeline
```

---

## 20. Folder Structure

The folder structure is illustrative and SHALL NOT be interpreted as a deployment structure. It mirrors architectural responsibilities — a file's location communicates its role.

```
src/
│
├── Platforms/
│   └── Clinical/
│       │
│       ├── Domain/
│       │   └── ClinicalContribution/
│       │       ├── ClinicalContribution              ← Aggregate Root
│       │       ├── ClinicalContent                   ← Entity
│       │       ├── ContributorRole                   ← Entity
│       │       ���── ClinicalContributionId            ← Value Object
│       │       ├── CareRecordId                      ← Value Object
│       │       ├── PractitionerId                    ← Value Object
│       │       ├── ClinicalText                      ← Value Object
│       │       ├── ContributionStatus                ← Value Object (enumeration)
│       │       ├── ContributorRoleType               ← Value Object (enumeration)
│       │       ├── ContributionTimestamp             ← Value Object
│       │       ├── ApprovalReference                 ← Value Object
│       │       └── Event/
│       │           ├── ClinicalContributionCreated   ← Domain Event
│       │           ├── ClinicalContributionValidated ← Domain Event
│       │           ├── ClinicalContributionValidationFailed ← Domain Event
│       │           └── ClinicalContributionApproved  ← Domain Event
│       │
│       ├── Application/
│       │   ├── Command/
│       │   │   ├── CreateClinicalContribution        ← Command
│       │   │   ├── ValidateClinicalContribution      ← Command
│       │   │   └── ApproveClinicalContribution       ← Command
│       │   ├── CommandHandler/
│       │   │   ├── CreateClinicalContributionHandler ← Command Handler
│       │   │   ├── ValidateClinicalContributionHandler ← Command Handler
│       │   │   └── ApproveClinicalContributionHandler  ← Command Handler
│       │   ├── Query/
│       │   │   ├── GetPatientTimeline                ← Query
│       │   │   └── GetClinicalContributionDetail     ← Query
│       │   ├── QueryHandler/
│       │   │   ├── GetPatientTimelineHandler         ← Query Handler
│       │   │   └── GetClinicalContributionDetailHandler ← Query Handler
│       │   ├── Port/
│       │   │   ├── ClinicalContributionRepositoryPort    ← Repository Port
│       │   │   ├── PatientTimelineReadModelPort           ← Read Model Port
│       │   │   └── ClinicalContributionDetailReadModelPort ← Read Model Port
│       │   ├── ReadModel/
│       │   │   ├── PatientTimelineView               ← Read Model DTO
│       │   │   └── ClinicalContributionDetailView    ← Read Model DTO
│       │   └── ClinicalContributionFacade            ← Application Facade
│       │
│       └── Infrastructure/
│           ├── Api/
│           │   ├── Resource/
│           │   │   └── ClinicalContributionResource  ← API Platform DTO
│           │   ├── StateProcessor/
│           │   │   └── ClinicalContributionStateProcessor ← dispatches Commands
│           │   └── StateProvider/
│           │       └── PatientTimelineStateProvider  ← dispatches Queries
│           └── Persistence/
│               ├── Repository/
│               │   └── ClinicalContributionRepository    ← Repository Implementation
│               ├── ReadModel/
│               │   ├── PatientTimelineReadModel           ← Read Model Implementation
│               │   └── ClinicalContributionDetailReadModel ← Read Model Implementation
│               └── Projection/
│                   ├── PatientTimelineProjection          ← Projection
│                   └── ClinicalContributionDetailProjection ← Projection
│
├── Workspace/
│   └── Infrastructure/
│       └── Persistence/
│           └── Projection/
│               └── WorkspaceProjection                   ← Projection (Workspace module)
│
└── Shared/
    └── Application/
        └── Event/
            └── DomainEvent                               ← Technical transport (not a Kernel concept)
```

---

## 21. Dependency Graph

Arrows indicate allowed dependency direction. Crossed arrows indicate prohibited dependencies.

```
┌─────────────────────────────────────────────────────────────────┐
│ Presentation Layer (Infrastructure/Api/)                         │
│   ClinicalContributionStateProcessor                            │
│   PatientTimelineStateProvider                                  │
│   ClinicalContributionResource                                  │
└──────────────────────────┬──────────────────────────────────────┘
                           │ dispatches to
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ Application Layer                                               │
│                                                                 │
│   ClinicalContributionFacade ──────────────────────────────┐   │
│          │ command.bus          │ query.bus                 │   │
│          ▼                      ▼                           │   │
│   Command Handlers        Query Handlers                    │   │
│     ├── depends on:         ├── depends on:                 │   │
│     │   RepositoryPort       │   ReadModelPort              │   │
│     │   Domain Model         └── never RepositoryPort       │   │
│     └── never: Implementation                               │   │
│                                                             │   │
│   Ports (contracts):                                        │   │
│     ClinicalContributionRepositoryPort ◄────────────────────┘   │
│     PatientTimelineReadModelPort                                │
│     ClinicalContributionDetailReadModelPort                     │
│                                                                 │
│   Read Model DTOs:                                              │
│     PatientTimelineView                                         │
│     ClinicalContributionDetailView                              │
└──────────────────────────┬──────────────────────────────────────┘
                           │ depends on
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│ Domain Layer (no outbound dependencies)                         │
│                                                                 │
│   ClinicalContribution (Aggregate Root)                         │
│     └── ClinicalContent (Entity)                               │
│     └── ContributorRole (Entity)                               │
│   Value Objects (immutable, self-validating)                    │
│   Domain Events (immutable facts)                               │
│                                                                 │
│   ✗ No dependency on Infrastructure                             │
│   ✗ No dependency on Application                                │
│   ✗ No persistence annotations                                  │
│   ��� No storage-specific types                                   │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│ Infrastructure Layer                                            │
│                                                                 │
│   ClinicalContributionRepository                                │
│     ├── implements: ClinicalContributionRepositoryPort          │
│     ├── depends on: ClinicalContribution (Domain — read only)   │
│     ├── depends on: Aggregate Persistence Store                 │
│     ✗ does NOT depend on: Domain Event Bus                      │
│     ✗ does NOT depend on: Command Handler                       │
│                                                                 │
│   PatientTimelineReadModel                                      │
│     ├── implements: PatientTimelineReadModelPort                │
│     ├── depends on: Patient Timeline Read Model Store           │
│     ✗ does NOT depend on: Aggregate Persistence Store           │
│     ✗ does NOT write to: Read Model Store (read only here)      │
│                                                                 │
│   PatientTimelineProjection                                     │
│     ├── consumes: Domain Events from Internal Event Bus         │
│     ├── writes to: Patient Timeline Read Model Store            │
│     ✗ does NOT depend on: ClinicalContributionRepositoryPort    │
│     ✗ does NOT depend on: other Projections                     │
│     ✗ does NOT depend on: Application Handler                   │
│     ✗ does NOT depend on: Domain Service                        │
└─────────────────────────────────────────────────────────────────┘

Prohibited dependencies (any occurrence is an architectural violation):

  Domain layer        ──✗──▶  Infrastructure layer
  Domain layer        ──✗──▶  Persistence annotations
  Application layer   ──✗──▶  Repository implementation
  Query Handler       ──✗──▶  ClinicalContributionRepositoryPort
  Repository          ──✗──▶  Domain Event Bus
  Projection          ──✗──▶  ClinicalContributionRepositoryPort
  Projection          ──✗──▶  Another Projection
  Presentation        ──✗──▶  Domain layer
  Presentation        ──✗──▶  Infrastructure layer
```

---

## 22. Sequence Diagram

Full lifecycle: Create → Approve → Projection Update → Query (Workspace Refresh).

The Validate path follows the same structure as Approve and is not separately diagrammed.

```
Practitioner   StateProcessor   Facade    command.bus   Handler    Runtime     Repository    PersistStore    EventBus    Projection   ReadModelStore   StateProvider   query.bus   ReadModelImpl
     │               │            │            │             │          │             │              │              │             │               │               │             │              │
     │ POST create   │            │            │             │          │             │              │              │             │               │               │             │              │
     │──────────────▶│            │            │             │          │             │              │              │             │               │               │             │              │
     │               │ dispatch   │            │             │          │             │              │              │             │               │               │             │              │
     │               │ command    │            │             │          │             │              │              │             │               │               │             │              │
     │               │───────────▶│            │             │          │             │              │              │             │               │               │             │              │
     │               │            │ route      │             │          │             │              │              │             │               │               │             │              │
     │               │            │───────────▶│             │          │             │              │              │             │               │               │             │              │
     │               │            │            │ route       │          │             │              │              │             │               │               │             │              │
     │               │            │            │────────────▶│          │             │              │              │             │               │               │             │              │
     │               │            │            │             │ open tx  │             │              │              │             │               │               │             │              │
     │               │            │            │             │─────────▶│             │              │              │             │               │               │             │              │
     │               │            │            │             │ create   │             │              │              │             │               │               │             │              │
     │               │            │            │             │ aggregate│             │              │              │             │               │               │             │              │
     │               │            │            │             │ [records ClinicalContributionCreated — pending]      │             │               │               │             │              │
     │               │            │            │             │          │             │              │              │             │               │               │             │              │
     │               │            │            │             │ persist  │             │              │              │             │               │               │             │              │
     │               │            │            │             │─────────────────────────────────────▶│              │             │               │               │             │              │
     │               │            │            │             │          │             │ write        │              │             │               │               │             │              │
     │               │            │            │             │          │             │─────────────▶│              │             │               │               │             │              │
     │               │            │            │             │          │ commit tx   │              │              │             │               │               │             │              │
     │               │            │            │             │          │◀────────────────────────────────────────  │             │               │               │             │              │
     │               │            │            │             │          │ collect events              │              │             │               │               │             │              │
     │               │            │            │             │          │ publish     │              │              │             │               │               │             │              │
     │               │            │            │             │          │────────────────────────────────────────────────────────▶│              │               │             │              │
     │               │            │            │             │ result   │             │              │              │             │               │               │             │              │
     │               │◀───────────────────────────────────────────────  │             │              │              │             │               │               │             │              │
     │ 201           │            │            │             │          │             │              │              │             │               │               │             │              │
     │◀──────────────│            │            │             │          │             │              │              │             │               │               │             │              │
     │               │            │            │             │          │             │              │              │             │               │               │             │              │
     │ POST approve  │            │            │             │          │             │              │              │             │               │               │             │              │
     │──────────────▶│ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─▶│          │             │              │              │             │               │               │             │              │
     │               │            │ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─▶│          │             │              │              │             │               │               │             │              │
     │               │            │            │ ─ ─ ─ ─ ─ ▶│          │             │              │              │             │               │               │             │              │
     │               │            │            │             │ open tx  │             │              │              │             │               │               │             │              │
     │               │            │            │             │─────────▶│             │              │              │             │               │               │             │              │
     │               │            │            │             │ retrieve │             │              │              │             │               │               │             │              │
     │               │            │            │             │─────────────────────────────────────▶│              │             │               │               │             │              │
     │               │            │            │             │          │             │ read         │              │             │               │               │             │              │
     │               │            │            │             │          │             │─────────────▶│              │             │               │               │             │              │
     │               │            │            │             │          │             │ translate    │              │             │               │               │             │              │
     │               │            │            │             │          │             │◀─────────────│              │             │               │               │             │              │
     │               │            │            │             │ aggregate│             │              │              │             │               │               │             │              │
     │               │            │            │             │◀─────────────────────────────────────│              │             │               │               │             │              │
     │               │            │            │             │ approve()│             │              │              │             │               │               │             │              │
     │               │            │            │             │ [records ClinicalContributionApproved — pending]     │             │               │               │             │              │
     │               │            │            │             │ persist  │             │              │              │             │               │               │             │              │
     │               │            │            │             │─────────────────────────────────────▶│              │             │               │               │             │              │
     │               │            │            │             │          │             │ write        │              │             │               │               │             │              │
     │               │            │            │             │          │             │─────────────▶│              │             │               │               │             │              │
     │               │            │            │             │          │ commit tx   │              │              │             │               │               │             │              │
     │               │            │            │             │          │ collect + publish                         │             │               │               │             │              │
     │               │            │            │             │          │────────────────────────────────────────────────────────▶│              │               │             │              │
     │               │            │            │             │ result   │             │              │              │             │               │               │             │              │
     │               │◀───────────────────────────────────────────────  │             │              │              │             │               │               │             │              │
     │ 200           │            │            │             │          │             │              │              │             │               │               │             │              │
     │◀──────────────│            │            │             │          │             │              │              │             │               │               │             │              │
     │               │            │            │             │          │             │              │              │             │               │               │             │              │
     │               │            │            │             │          │             │              │  deliver     │             │               │               │             │              │
     │               │            │            │             │          │             │              │  event       │             │               │               │             │              │
     │               │            │            │             │          │             │              │──────────────────────────▶│               │               │             │              │
     │               │            │            │             │          │             │              │              │ idempotency │               │               │             │              │
     │               │            │            │             │          │             │              │              │ check       │               │               │             │              │
     │               │            │            │             │          │             │              │              │ derive update               │               │             │              │
     │               │            │            │             │          │             │              │              │ write       │               │               │             │              │
     │               │            │            │             │          │             │              │              │─────────────────────────────────────────────▶│             │              │
     │               │            │            │             │          │             │              │              │             │ track position│               │             │              │
     │               │            │            │             │          │             │              │              │             │               │               │             │              │
     │ GET timeline  │            │            │             │          │             │              │              │             │               │               │             │              │
     │──────────────▶│ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─▶│             │              │
     │               │            │            │             │          │             │              │              │             │               │ dispatch      │             │              │
     │               │            │            │             │          │             │              │              │             │               │ query         │             │              │
     │               │            │            │             │          │             │              │              │             │               │───────────────────────────▶│              │
     │               │            │            │             │          │             │              │              │             │               │               │ route       │              │
     │               │            │            │             │          │             │              │              │             │               │               │────────────────────────────▶│
     │               │            │            │             │          │             │              │              │             │               │               │             │ read         │
     │               │            │            │             │          │             │              │              │             │               │◀──────────────────────────────────────────│
     │               │            │            │             │          │             │              │              │             │               │               │ return view │              │
     │               │            │            │             │          │             │              │              │             │               │               │◀────────────│              │
     │               │            │            │             │          │             │              │              │             │               │ return view   │             │              │
     │               │◀───────────────────────────────────────────────────────────────────────────────────────────────────────── │              │               │             │              │
     │ workspace     │            │            │             │          │             │              │              │             │               │               │             │              │
     │ refreshed     │            │            │             │          │             │              │              │             │               │               │             │              │
     │◀──────────────│            │            │             │          │             │              │              │             │               │               │             │              │
```

---

## 23. Implementation Order

Implementation follows Domain-first, then Application ports, then Infrastructure. No Infrastructure component is created before the Domain contract it serves.

| Step | Layer | Deliverable | Validates |
|---|---|---|---|
| 1 | Domain | Value Objects — all 8 | Domain invariants |
| 2 | Domain | Domain Events — 4 | Immutable fact structure |
| 3 | Domain | `ClinicalContribution` Aggregate Root | All business invariants BI-001→BI-007 |
| 4 | Domain | Entities — `ClinicalContent`, `ContributorRole` | Aggregate composition |
| 5 | Domain | Unit tests — pure domain, no infrastructure | All business rules verified |
| 6 | Application | `ClinicalContributionRepositoryPort` | Persistence contract |
| 7 | Application | `PatientTimelineReadModelPort`, `ClinicalContributionDetailReadModelPort` | Read contracts |
| 8 | Application | Commands — 3 | Intent objects |
| 9 | Application | Queries — 2 | Information-need objects |
| 10 | Application | Read Model DTOs — `PatientTimelineView`, `ClinicalContributionDetailView` | Query return shapes |
| 11 | Application | `CreateClinicalContributionHandler` | UC-001 |
| 12 | Application | `ValidateClinicalContributionHandler` | UC-002 |
| 13 | Application | `ApproveClinicalContributionHandler` | UC-003 |
| 14 | Application | `GetPatientTimelineHandler` | UC-004 |
| 15 | Application | `GetClinicalContributionDetailHandler` | UC-004 (detail) |
| 16 | Application | `ClinicalContributionFacade` | Single entry point |
| 17 | Infrastructure | `ClinicalContributionRepository` | Persistence |
| 18 | Infrastructure | `PatientTimelineReadModel`, `ClinicalContributionDetailReadModel` | Read access |
| 19 | Infrastructure | `PatientTimelineProjection` | Patient Timeline maintenance |
| 20 | Infrastructure | `ClinicalContributionDetailProjection` | Detail maintenance |
| 21 | Infrastructure | `WorkspaceProjection` | Workspace refresh |
| 22 | Infrastructure | `ClinicalContributionStateProcessor`, `PatientTimelineStateProvider` | HTTP layer |
| 23 | Infrastructure | `ClinicalContributionResource` | API Platform DTO |
| 24 | Tests | Integration tests — full flow with real database | Handler + Repository |
| 25 | Tests | Functional tests — API endpoints | Full HTTP flow |

---

## 24. Architectural Validation Checklist

Each item maps to a specific invariant in SA-001 through SA-007. Every item shall be verifiable by code inspection.

### SA-001 — Reference Architecture

- [ ] `ClinicalContribution` carries no persistence annotations.
- [ ] `ClinicalContribution` carries no storage-specific base class.
- [ ] Domain layer has no `use` / `import` from `Infrastructure/`.
- [ ] Every class owns exactly one responsibility — no class serves two layers (SA-P-0010).
- [ ] Every abstraction introduced justifies its cognitive cost — no intermediate class exists without clear purpose (SA-P-0011).

### SA-002 — Platform Architecture

- [ ] `ClinicalContribution` is located under `Platforms/Clinical/` — not under `Kernel/`.
- [ ] No Kernel concept (Actor, Organization, BusinessEvent) was modified for this feature.
- [ ] Platform boundary is intact — no `ClinicalContribution` dependency exists in `Kernel/`.

### SA-003 — Bounded Context Architecture

- [ ] `ClinicalContributionRepositoryPort` is defined in `Application/Port/`.
- [ ] `ClinicalContributionRepository` is defined in `Infrastructure/Persistence/Repository/`.
- [ ] Command Handlers import `ClinicalContributionRepositoryPort` — never `ClinicalContributionRepository`.
- [ ] No import from another Bounded Context's `Infrastructure/Persistence/` exists.

### SA-004 — Runtime Architecture

- [ ] Commands dispatched via `command.bus` with `doctrine_transaction` middleware.
- [ ] Queries dispatched via `query.bus`.
- [ ] Domain Events routed via `event.bus` with `allow_no_handlers` default middleware.

### SA-005 — Application & CQRS Architecture

- [ ] `CreateClinicalContributionHandler` owns one transaction boundary — opens, commits, rolls back.
- [ ] `ApproveClinicalContributionHandler` owns one transaction boundary.
- [ ] `GetPatientTimelineHandler` accesses `PatientTimelineReadModelPort` only — never `ClinicalContributionRepositoryPort`.
- [ ] `GetClinicalContributionDetailHandler` accesses `ClinicalContributionDetailReadModelPort` only.
- [ ] No Projection writes to a Read Model store outside `Infrastructure/Persistence/Projection/`.
- [ ] Domain Events are published by the Application Runtime after transaction commit — not inside the transaction.
- [ ] `ClinicalContributionFacade` dispatches only — contains no business logic.
- [ ] `PatientTimelineView` is derived from Read Model — not from `ClinicalContribution` aggregate.

### SA-006 — Event-Driven Architecture

- [ ] `ClinicalContributionApproved` does not cross Platform boundaries as a Domain Event (ADR-0014).
- [ ] `PatientTimelineProjection` applies idempotency check before processing each event.
- [ ] A failure in `PatientTimelineProjection` does not affect `ClinicalContributionDetailProjection` or `WorkspaceProjection`.
- [ ] Each Projection independently tracks its position in the event stream.
- [ ] `PatientTimelineProjection` can be reset and replayed without affecting Aggregate state.

### SA-007 — Persistence Architecture

- [ ] `ClinicalContribution` is persisted exclusively through `ClinicalContributionRepository` (I-001).
- [ ] `ClinicalContributionRepository` owns exactly one Aggregate Root (I-002).
- [ ] `ClinicalContributionRepository` does not publish Domain Events (I-003).
- [ ] `ClinicalContributionRepository` does not publish Integration Events (I-004).
- [ ] Each Command Handler executes within exactly one transaction boundary (I-005).
- [ ] Transaction boundary belongs to the Command Handler on behalf of Application Layer (I-006).
- [ ] `ClinicalContributionRepository` participates in the transaction — does not open or commit it (I-007).
- [ ] All persistence operations within each Command Handler transaction commit atomically (I-008).
- [ ] No concurrent update on `ClinicalContribution` produces silent state corruption (I-009).
- [ ] Persistence mapping logic resides only in `Infrastructure/` (I-010).
- [ ] `ClinicalContributionRepository` does not persist Read Model state (I-011).
- [ ] Query Handlers do not access `ClinicalContributionRepositoryPort` (I-012).
- [ ] `ClinicalContributionRepositoryPort` exposes only `retrieve` and `persist` (I-013, I-014).
- [ ] `ClinicalContribution` carries no persistence annotation or storage-specific type (I-015, I-016).
- [ ] Patient Timeline Read Model store is independent from Aggregate Persistence store (I-017).
- [ ] Schema evolution for `ClinicalContribution` persistence is managed in `Infrastructure/` only (I-018).

---

## 25. Expected Learning Points

### LP-001 — The Aggregate records; the Runtime publishes.

`ClinicalContribution.approve()` records `ClinicalContributionApproved` as a pending event. The Aggregate does not publish it. The Application Runtime collects it after the transaction commits and publishes it to the Internal Event Bus. A developer who tries to publish inside the Aggregate or inside the Repository is violating SA-005 D-008 and SA-007 D-002.

---

### LP-002 — Command Handler and Application Layer describe the same ownership at different levels.

SA-005 D-003 assigns transaction ownership to Command Handlers. SA-007 D-003 assigns it to the Application Layer. These are not contradictions. The Command Handler owns the transaction on behalf of the Application Layer. A developer reading SA-005 and SA-007 in parallel should recognize these as the same architectural fact stated at two abstraction levels (SA-007 §6.2).

---

### LP-003 — The Repository participates; it does not lead.

`ClinicalContributionRepository` participates in the active transaction opened by the Command Handler. It does not open transactions, commit them, or roll them back. It does not control its own isolation. A developer who adds `beginTransaction()` to the Repository is taking a responsibility that belongs to the Application Layer.

---

### LP-004 — The read path never touches the Aggregate.

`GetPatientTimelineHandler` calls `PatientTimelineReadModelPort.getTimeline(...)`. It never calls `ClinicalContributionRepositoryPort.retrieve(...)`. The Patient Timeline is built by the Projection, stored in a dedicated Read Model store, and read by the Query Handler from that store. Aggregate Repositories are write-path infrastructure — invisible on the read path.

---

### LP-005 — Projections are independently replayable because stores are independent.

Because the Patient Timeline Read Model store is structurally independent from the Aggregate Persistence store, `PatientTimelineProjection` can be reset and replayed without touching business state. A developer who merges Aggregate and Read Model state into one store removes this property and violates SA-007 D-007.

---

### LP-006 — The folder location communicates the architectural role.

A developer can determine the layer, responsibility, and allowed dependencies of any file by reading its path:

| Path | Meaning |
|---|---|
| `Domain/ClinicalContribution/ClinicalContribution` | Aggregate Root — no persistence, no infrastructure |
| `Application/Port/ClinicalContributionRepositoryPort` | Persistence contract — not an implementation |
| `Application/CommandHandler/ApproveClinicalContributionHandler` | Transaction owner, business orchestrator |
| `Application/QueryHandler/GetPatientTimelineHandler` | Read-only, no transaction, no Repository |
| `Infrastructure/Persistence/Repository/ClinicalContributionRepository` | Persistence implementation — invisible to Application layer |
| `Infrastructure/Persistence/ReadModel/PatientTimelineReadModel` | Read implementation — invisible to Projections |
| `Infrastructure/Persistence/Projection/PatientTimelineProjection` | Sole writer to Patient Timeline Read Model store |

No file's purpose is ambiguous from its location.

---

### LP-007 — Value Objects enforce invariants at the boundary.

`ClinicalText` construction fails if the text is empty. `ContributionStatus` admits no values outside `Draft`, `Validated`, `Approved`. No invalid state can reach the Aggregate. A developer who accepts a plain `string` instead of `ClinicalText` in a Command Handler or Aggregate operation has moved invariant enforcement out of the Domain and into the caller — violating the Domain's responsibility for its own correctness.

---

### LP-008 — One Repository per Aggregate Root is a domain count, not an infrastructure choice.

The number of Repository implementations in the Clinical Platform's ClinicalContribution Bounded Context equals the number of Aggregate Roots. This count is determined by Domain Engineering, not by infrastructure convenience. A developer who creates a `ClinicalContributionAndCareRecordRepository` is violating SA-007 I-002 and merging domain boundaries.

---

### LP-009 — Pending Domain Events are discarded upon rollback, not deferred.

If `ApproveClinicalContributionHandler` fails after `ClinicalContribution` records `ClinicalContributionApproved` but before commit, the transaction rolls back and all pending events are discarded. They are not queued, deferred, or retried. The event never existed in the observable system. This is a structural guarantee of the persistence architecture, not a runtime implementation choice.

---

### LP-010 — The architecture answers "where does this belong?" for every component.

At any point during implementation, a developer can determine which layer and which location owns a component by asking:

1. Does it enforce a business rule? → Domain layer.
2. Does it define a persistence contract? → Application/Port/.
3. Does it orchestrate a use case and own a transaction? → Application/CommandHandler/.
4. Does it return a Read Model view? → Application/QueryHandler/.
5. Does it translate business state to storage? → Infrastructure/Persistence/Repository/.
6. Does it write to a Read Model store from Domain Events? → Infrastructure/Persistence/Projection/.
7. Does it read from a Read Model store? → Infrastructure/Persistence/ReadModel/.
8. Does it expose HTTP? → Infrastructure/Api/.

If none of these applies, the component should not exist.

---

## References

- SA-001 — Reference Architecture (SA-P-0010, SA-P-0011, SA-P-005, SA-P-006)
- SA-002 — Platform Architecture (§3 Platform Building Blocks)
- SA-003 — Bounded Context Architecture (§5 Building Blocks, §7 Infrastructure Layer)
- SA-004 — Runtime Architecture (bus configuration, routing)
- SA-005 — Application & CQRS Architecture (D-003, D-005, D-006, D-008, §7, §8, §13, §14)
- SA-006 — Event-Driven Architecture (§5, §6, §8, §9, §12)
- SA-007 — Persistence Architecture (D-001–D-011, I-001–I-018, §6, §10, §11)
- ADR-0003 — Hexagonal Architecture
- ADR-0004 — CQRS
- ADR-0007 — Clinical Contribution Relationships — Roles on Relations
- ADR-0014 — Domain Events Shall Never Cross Platform Boundaries
