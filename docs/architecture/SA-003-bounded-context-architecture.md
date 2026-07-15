# SA-003 — Bounded Context Architecture

**Document ID**: SA-003
**Title**: Bounded Context Architecture
**Status**: Draft v1.0
**Version**: 1.0

**Depends on**:

- SA-001 — Reference Architecture (Release v1.0)
- SA-002 — Platform Architecture (Release v1.0)
- SD-003 — Bounded Context Discovery
- SD-004 — Context Map

---

## 1. Purpose

### 1.1 Objective

This document defines the internal software architecture of a MedLink Bounded Context.

It answers one question:

> How is a MedLink Bounded Context architected?

It defines the layers, their responsibilities, the authorised building blocks, the dependency rules, and the interaction patterns every Bounded Context must follow.

### 1.2 Scope

This specification applies to every Bounded Context within every MedLink Platform.

It does not redefine business ownership or Bounded Context boundaries.

Those are frozen in SD-003 and SD-004.

CQRS and Event-Driven Architecture implementation details are deferred to SA-005 and SA-006.

---

## 2. Bounded Context Definition

A Bounded Context is the smallest autonomous software unit that owns a coherent business responsibility.

A Bounded Context owns:

- its Domain model;
- its Application layer;
- its Infrastructure layer;
- its Presentation layer.

Business ownership is exclusive.

No business rule may be implemented outside its owning Bounded Context.

A Bounded Context collaborates with other Bounded Contexts within the same Platform through Domain Events on the internal event bus.

A Bounded Context communicates with other Platforms exclusively through Integration Events published via the Platform Contract (SA-002 Section 5).

---

## 3. Layered Architecture

Every Bounded Context follows the same four-layer architecture.

```
  Presentation
       │
       ▼
  Application
       │
       ▼
     Domain
       ▲
       │
 Infrastructure
```

Each layer has a single architectural responsibility.

The Domain layer is the centre of the architecture.

All other layers exist to serve the Domain.

The following rules govern all layers.

**Presentation SHALL depend only on Application.**

**Application SHALL depend only on Domain.**

**Infrastructure SHALL implement Domain and Application Ports.**

**Domain SHALL NOT depend on any other layer.**

Framework dependencies SHALL remain confined to Infrastructure and Presentation.

---

## 4. Layer Responsibilities

| Layer | SHALL | SHALL NOT |
|---|---|---|
| Domain | Own business rules, invariants, and Aggregates | Depend on any framework, infrastructure, or other layer |
| Application | Execute use cases and coordinate the Domain | Contain SQL, HTTP, infrastructure concerns, or business logic |
| Infrastructure | Implement Ports, adapters, and technical concerns | Own business rules or depend on Presentation |
| Presentation | Expose user interactions and handle I/O serialisation | Own business rules or depend on Domain directly |

---

## 5. Building Blocks

Every building block belongs to exactly one layer.

### Domain

| Building Block | Description |
|---|---|
| Aggregate | Consistency boundary — enforces business invariants |
| Entity | Object with distinct identity tracked over time |
| Value Object | Immutable concept — equality based on value, not identity |
| Domain Event | Immutable business fact — records what happened |
| Repository | Persistence contract — interface defined in Domain, implemented in Infrastructure |
| Policy | Encapsulates a business decision or conditional rule |
| Specification | Composable, reusable business rule |
| Domain Service | Stateless Domain logic that does not belong to any Aggregate |
| Domain Exception | Business rule violation |

### Application

| Building Block | Description |
|---|---|
| Command | Expresses an intent to modify business state |
| Query | Expresses a request to read data |
| Handler | Executes exactly one Command or one Query |
| DTO | Carries Command or Query data — no behaviour |
| Port | Interface declaring a dependency — implementation provided by Infrastructure |
| Facade | Stable public entry point — the sole external surface of the Application layer |

### Infrastructure

| Building Block | Description |
|---|---|
| Repository Implementation | Implements the Domain Repository contract |
| Projection | Subscribes to Domain Events and builds Read Models |
| Read Model | Read-optimised representation of business data — produced by Projections, consumed by Queries, contains no business logic |
| Messaging | Internal event bus adapter — dispatches and receives Domain Events |
| Gateway | External system adapter — translates incoming Integration Events before they enter the Application layer |
| Persistence | Database mapping and schema concerns |

### Presentation

| Building Block | Description |
|---|---|
| Controller | HTTP adapter — dispatches Commands or Queries |
| API Resource | API exposure definition |
| Live Component | Stateful server-side UI component |
| Form | User input adapter |
| ViewModel | Read-only data structure assembled for rendering |

---

## 6. Dependency Rules

The following dependency diagram governs every Bounded Context.

```
  Presentation
       │
       ▼
  Application  ◄──────────────  Infrastructure
       │                               │
       ▼                               │
     Domain  ◄──────────────────────────
```

Infrastructure depends on both Domain (Repository contracts) and Application (Ports).

Application never imports Infrastructure concrete classes.

### Rule 1

Presentation depends on Application.

Presentation dispatches Commands and Queries.

Presentation never imports from Domain or Infrastructure directly.

### Rule 2

Application depends on Domain.

Handlers load Aggregates, invoke Domain methods, and observe Domain Events.

Application accesses Infrastructure exclusively through Ports.

### Rule 3 — Read Path

Queries depend on Read Models built by Projections.

Queries never access Aggregates directly.

### Rule 4

Infrastructure implements Domain Repository contracts and Application Ports.

Infrastructure never exposes implementation details to Presentation.

### Rule 5

Domain has no external dependency.

The Domain layer imports nothing outside its own boundary.

### Rule 6

Bounded Contexts within the same Platform collaborate through:

- Domain Events for asynchronous collaboration.
- Application Contracts (Application Facades) for synchronous collaboration.

Direct imports between Domain Models remain prohibited.

### Rule 7

Any violation of Rules 1 through 6 requires an Architecture Decision Record before implementation.

---

## 7. Interaction Patterns

### 7.1 Write Flow

A write operation starts in Presentation and terminates with a Domain Event.

```
  Presentation (Controller)
          │
       Command
          │
          ▼
  Application (Handler)
          │  loads Aggregate, invokes Domain method
          ▼
  Domain (Aggregate)
          │  enforces invariants
          │
     Domain Event
          │
          ├──▶ Infrastructure (Projection) ──▶ Read Model updated
          │
          └──▶ Platform Integration Layer ──▶ Integration Event (if cross-Platform)
```

The Handler coordinates the flow.

The Aggregate makes the business decision.

The Handler never contains business logic.

### 7.2 Read Flow

A read operation starts in Presentation and returns a ViewModel assembled from a Read Model.

```
  Presentation (Controller)
          │
        Query
          │
          ▼
  Application (Handler)
          │
          ▼
  Infrastructure (Projection / Read Model)
          │
          ▼
  ViewModel (Presentation)
          ���
          ▼
       Response
```

Queries never touch Aggregates.

Read Models are the only source for Query responses.

### 7.3 Inbound Integration

An Integration Event arriving from another Platform is translated before entering the Application layer.

```
  Platform Contract
          │
   Integration Event
          │
          ▼
  Infrastructure (Gateway / ACL)
          │  translates to Command or Application DTO
          ▼
  Application Facade
          │
       Command
          │
          ▼
  Application (Handler) ──▶ Domain (Aggregate)
```

The Domain never sees the Integration Event.

The Gateway absorbs all external representation concerns.

### 7.4 Outbound Integration

A Domain Event produced by an Aggregate may trigger an Integration Event when the fact has cross-Platform significance.

```
  Domain (Aggregate)
          │
     Domain Event
          │
          ▼
  Platform Integration Layer
          │  derives Integration Event — not a Domain Event
          ▼
  Platform Contract ──▶ Other Platform
```

Integration Events are produced by the Platform Integration layer, not by the Domain.

---

## 8. Architectural Invariants

The following invariants apply to every Bounded Context without exception.

1. One Aggregate Root = one Repository contract.
2. Repository implementations belong to Infrastructure.
3. Domain Events SHALL NOT cross Platform boundaries. Within a Platform, Domain Events MAY be consumed by another Bounded Context through the internal event bus.
4. Integration Events are created by the Platform Integration layer, outside the Domain.
5. Commands modify business state through Aggregates only.
6. Commands SHALL NOT return Read Models or ViewModels.
7. Queries SHALL NOT modify business state.
8. Queries read through Read Models only — never through Aggregates.
9. Presentation never accesses Domain directly.
10. The Facade is the sole public surface of the Application layer.
11. Read Models are read-only — Projections build them; no layer writes to them directly.

---

## 9. Reference Structure

Every Bounded Context SHALL follow this internal structure.

```
{BoundedContext}/
│
├── Domain/
│   ├── Aggregate/
│   ├── Entity/
│   ├── ValueObject/
│   ├── DomainEvent/
│   ├── Repository/
│   ├── Policy/
│   ├── Specification/
│   ├── DomainService/
│   └── Exception/
│
├── Application/
│   ├── Command/
│   ├── Query/
│   ├── Handler/
│   ├── DTO/
│   ├── Port/
│   └── Facade/
│
├── Infrastructure/
│   ├── Persistence/
│   ├── Projection/
│   ├── ReadModel/
│   ├── Messaging/
│   ├── Gateway/
│   └── Cache/
│
└── Presentation/
    ├── Http/
    ├── Api/
    ├── LiveComponent/
    ├── Form/
    └── ViewModel/
```

Each directory contains only the building blocks defined in this specification.

Deviations require an Architecture Decision Record.

---

## 10. References

- SA-001 — Reference Architecture
- SA-002 — Platform Architecture
- SD-003 — Bounded Context Discovery
- SD-004 — Context Map
- ADR-0003 — Hexagonal Architecture
- ADR-0004 — CQRS
- ADR-0014 — Domain Events Shall Never Cross Platform Boundaries

---

## 11. Open Decisions

| ID | Decision | Status |
|---|---|---|
| OD-001 | Facade naming convention (`*Facade` vs `*ApplicationService`) | Open |
| OD-002 | One Handler per Command/Query vs grouped Handler classes | Open |
