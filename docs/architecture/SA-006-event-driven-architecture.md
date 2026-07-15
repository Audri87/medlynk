# SA-006 — Event-Driven Architecture

**Document ID**: SA-006
**Title**: Event-Driven Architecture
**Status**: Release v1.0
**Version**: 1.0

**Depends on**:

- SA-001 — Reference Architecture (Release v1.1)
- SA-002 — Platform Architecture (Release v1.0)
- SA-003 — Bounded Context Architecture (Release v1.0)
- SA-005 — Application & CQRS Architecture (Release v1.0)
- ADR-SA-006 — Architectural Decision Register (Approved)

**Implements**:

- ADR-SA-006 D-001 through D-011

**Extends**:

- SA-005 §13 — Domain Event Lifecycle (from publication onward)

**Does not define**:

- Domain Event creation, recording, and collection → SA-005 §13.1–§13.3
- Durability mechanism implementation → SA-007
- Domain Event collection pattern (pull vs observer) → runtime specification
- Presentation, Command, Query, Handler definitions → SA-005

---

## 1. Purpose

### 1.1 Objective

This document defines the Event-Driven Architecture of MedLink.

It answers the following questions:

> How do Domain Events flow within a Platform after publication?
> How do Integration Events cross Platform boundaries?
> How is event delivery made reliable?
> How do Projections execute in isolation?
> How are delivery failures recovered?
> When is synchronous collaboration permitted versus asynchronous?

It extends SA-005 §13 (Domain Event Lifecycle) from the moment the Application Runtime publishes Domain Events to the Internal Event Bus.

### 1.2 Normative Language

The key words MUST, MUST NOT, REQUIRED, SHALL, SHALL NOT, SHOULD, SHOULD NOT, RECOMMENDED, MAY, and OPTIONAL in this document are to be interpreted as described in RFC 2119.

### 1.3 Scope

This specification applies to:

- every Platform within the MedLink Architecture;
- every Bounded Context publishing or consuming events;
- every Platform Integration Layer;
- every Projection consuming Domain Events;
- every Integration Event Consumer receiving cross-Platform events.

### 1.4 What this document does not define

- Domain Event creation and recording inside Aggregates → SA-005 §13.1–§13.2
- Domain Event pending state, commit guarantee, and collection → SA-005 §13.2–§13.3
- Projection rules and Read Model definitions → SA-005 §14
- Application Handler responsibilities → SA-005 §6–§7
- Persistence and durability mechanism implementation → SA-007
- Domain Event collection pattern (pull vs observer) → runtime specification

---

## 2. Architectural Principles

### SA-P-0010 — Single Architectural Responsibility

Every event-driven building block defined in this document owns exactly one architectural responsibility.

| Building Block | Single Responsibility |
|---|---|
| Domain Event | Carries an internal business fact within its Platform |
| Integration Event | Carries a cross-Platform communication contract |
| Internal Event Bus | Routes Domain Events within a Platform boundary |
| Platform Integration Layer | Translates Domain Events into Integration Events |
| Projection | Maintains exactly one Read Model scope |
| Integration Event Consumer | Receives and applies Integration Events idempotently |
| Dead Letter Store | Isolates permanently failed events for operational recovery |

Responsibilities SHALL NOT overlap. Any overlap detected during Architecture Review requires an Architecture Decision Record before implementation.

### SA-P-0011 — Cognitive Simplicity

Every concept in this document is justified by a corresponding reduction in system complexity or risk.

Event-Driven Architecture adds operational complexity. This document minimises that complexity by:

- maintaining a two-event taxonomy only (Domain Event, Integration Event);
- prohibiting global event ordering where no business requirement justifies it;
- favouring backward-compatible event evolution over version proliferation;
- enforcing Projection isolation so failures remain local.

No additional event type or bus abstraction is introduced beyond what the approved decisions require.

---

## 3. Event Types

### 3.1 Event Taxonomy

MedLink defines exactly two event types.

Each type has a distinct scope, distinct owner, and distinct lifecycle.

| Dimension | Domain Event | Integration Event |
|---|---|---|
| Scope | Internal to the Platform | Cross-Platform |
| Owner | Bounded Context (Domain layer) | Platform Integration Layer |
| Created by | Aggregate | Platform Integration Layer |
| Crosses BC boundary | MAY within same Platform | Not applicable |
| Crosses Platform boundary | SHALL NEVER | Always |
| Transport | Internal Event Bus | Platform Contract |
| Carries | Internal domain semantics | Stable public contract data |
| Consumer | Projections, Domain Event Handlers within same Platform | Integration Event Consumers in other Platforms |

No third event type is recognised by this architecture.

### 3.2 Domain Event

#### 3.2.1 Definition

A Domain Event is an immutable record of a business fact that occurred inside a Bounded Context.

It is defined by the Domain layer of the originating Bounded Context and carries the vocabulary of that Bounded Context's Domain Model.

#### 3.2.2 Ownership

Domain Events are owned by the Bounded Context that produces them.

No component outside the originating Bounded Context's Domain layer MAY define a Domain Event.

#### 3.2.3 Boundaries

Domain Events MAY cross Bounded Context boundaries within the same Platform via the Internal Event Bus.

Domain Events SHALL NEVER cross Platform boundaries.

If a business fact must be communicated to another Platform, the Platform Integration Layer derives an Integration Event from the Domain Event.

#### 3.2.4 Lifecycle

The Domain Event lifecycle from creation to publication is specified in SA-005 §13.

SA-006 governs the Domain Event lifecycle from publication to the Internal Event Bus onward.

### 3.3 Integration Event

#### 3.3.1 Definition

An Integration Event is an immutable record of a business fact published by a Platform to external consumers.

It is purpose-built for cross-Platform communication. It carries only the data required by external consumers, expressed in a vocabulary stable across Platform evolution.

#### 3.3.2 Ownership

Integration Events are owned by the Platform Integration Layer.

No component outside the Platform Integration Layer MAY define or produce an Integration Event.

Aggregates SHALL NEVER define or produce Integration Events.

Application Handlers SHALL NEVER define or produce Integration Events.

#### 3.3.3 Boundaries

Integration Events cross Platform boundaries via the Platform Contract.

Receiving Platforms consume Integration Events through Anti-Corruption Layers (SA-003 §7.3).

The receiving Platform's Domain Model SHALL NOT depend on the originating Platform's Integration Events.

#### 3.3.4 Relation to Domain Events

Integration Events are derived from Domain Events by the Platform Integration Layer.

An Integration Event is not a Domain Event. It is a distinct artifact with distinct ownership and a distinct contract lifecycle.

---

## 4. Event Lifecycle

### 4.1 Overview

The complete event lifecycle spans two specifications.

SA-005 §13 defines steps 1–4. SA-006 defines steps 5–8.

| Step | Owner | Specification |
|---|---|---|
| 1. Creation | Aggregate | SA-005 §13.1 |
| 2. Recording | Aggregate | SA-005 §13.1–§13.2 |
| 3. Collection | Application Runtime | SA-005 §13.3 |
| 4. Pre-publication guarantee | Application Runtime | SA-005 §13.4–§13.5 |
| 5. Publication to Internal Event Bus | Application Runtime | SA-006 §4.3 |
| 6. Intra-Platform routing | Internal Event Bus | SA-006 §5 |
| 7. Integration Event derivation | Platform Integration Layer | SA-006 §6 |
| 8. Cross-Platform publication | Platform Integration Layer | SA-006 §6–§8 |

### 4.2 Creation, Recording, and Collection

These steps are fully defined in SA-005 §13.1–§13.3 and are not redefined here.

The relevant guarantee from SA-005: Domain Events SHALL remain pending until the transaction commits. They SHALL NOT be published if the transaction rolls back. The Application Runtime collects pending Domain Events from Aggregates after a successful commit.

### 4.3 Publication to the Internal Event Bus

After collecting pending Domain Events, the Application Runtime publishes them to the Platform's Internal Event Bus.

Publication to the Internal Event Bus SHALL occur only after a successful transaction commit.

The Application Runtime SHALL NOT publish Domain Events to the Internal Event Bus before the transaction commits.

The concrete mechanism by which the Application Runtime publishes to the Internal Event Bus is a runtime specification concern. The architectural principle is: post-commit, every collected Domain Event reaches the Internal Event Bus exactly once under normal conditions and at least once under failure conditions.

### 4.4 Consumption

From the Internal Event Bus, Domain Events are consumed independently by:

- **Projections** — update Read Models (§12);
- **Domain Event Handlers** — trigger reactions in other Bounded Contexts within the same Platform;
- **Platform Integration Layer** — translates selected Domain Events into Integration Events for cross-Platform publication (§6).

Each consumer is an isolated, independent subscriber.

A Domain Event Handler is a specialised Application Handler whose trigger is a Domain Event rather than a Command or Query. It executes in response to a Domain Event and produces a reaction within the same Platform. Domain Event Handlers are subject to the same Application Layer rules as Command Handlers and Query Handlers (SA-003 §5, SA-005 §6–§7). They do not expose Integration Events and do not cross Platform boundaries.

### 4.5 Synchronous vs Asynchronous Collaboration

The architecture distinguishes two collaboration modes.

**Synchronous collaboration** SHALL be used only when the initiating business use case cannot complete without the requested response.

**Asynchronous collaboration** is the default for all post-completion reactions.

All post-completion reactions SHALL be implemented asynchronously using Integration Events (§3.3, §6).

A reaction is any behaviour triggered by the completion of a business use case that does not affect the outcome of that use case. Reactions SHALL NEVER constrain the producing Platform's availability or response time.

This principle ensures that the write path of the producing Platform remains focused on its own business operation and remains independently evolvable.

---

## 5. Internal Event Bus

### 5.1 Definition

The Internal Event Bus is the intra-Platform event routing component.

It is the transport mechanism through which Domain Events flow within a Platform boundary.

### 5.2 Ownership

Each Platform SHALL own exactly one Internal Event Bus.

The Internal Event Bus is a Platform-level component. It is not owned by any individual Bounded Context.

### 5.3 Responsibilities

The Internal Event Bus SHALL:

- receive Domain Events published by the Application Runtime;
- route Domain Events to all registered consumers within the Platform;
- preserve isolation between consumers.

The Internal Event Bus SHALL NOT:

- cross Platform boundaries;
- transform or enrich Domain Events;
- filter Domain Events on behalf of consumers;
- expose Domain Events to components outside the Platform.

### 5.4 Rules

- Each Platform SHALL own exactly one Internal Event Bus (D-004).
- The Internal Event Bus SHALL NEVER cross Platform boundaries (D-004).
- All Domain Events published within a Platform SHALL transit through the Internal Event Bus (D-004).
- Consumer failures SHALL NOT propagate to other consumers (D-010).

### 5.5 Relation to the Platform Integration Layer

The Platform Integration Layer is a consumer of the Internal Event Bus.

It subscribes to Domain Events and derives Integration Events from them.

It is the only consumer permitted to produce artifacts that cross the Platform boundary.

---

## 6. Platform Integration Layer

### 6.1 Definition

The Platform Integration Layer is the architectural component responsible for all cross-Platform event communication.

It is a Platform Building Block (SA-002 §3.3).

### 6.2 Ownership

The Platform Integration Layer is owned by the Platform.

It owns the public Platform Contract for Integration Events (SA-002 §3.5).

### 6.3 Responsibilities

The Platform Integration Layer SHALL:

- subscribe to the Internal Event Bus;
- identify Domain Events that have cross-Platform significance;
- translate those Domain Events into Integration Events;
- publish Integration Events via the Platform Contract with a durability guarantee (§7);
- apply the retry policy on publication failures (§8);
- isolate permanently failed Integration Events for operational recovery (§13).

The Platform Integration Layer SHALL NOT:

- contain business rules;
- modify Domain Events;
- access Aggregates directly;
- expose Domain Events externally.

### 6.4 Translation

Translation is the act of deriving an Integration Event from one or more Domain Events.

During translation, the Platform Integration Layer:

- selects only the data required by external consumers;
- expresses that data in the vocabulary of the Platform Contract;
- discards internal domain details not relevant to external consumers.

Not every Domain Event produces an Integration Event. The Platform Integration Layer decides which Domain Events warrant cross-Platform publication.

### 6.5 Platform Boundary

The Platform Integration Layer is the sole crossing point of the Platform boundary on the event path.

No other component within the Platform publishes events externally.

Domain Events SHALL NEVER be directly exposed beyond the Platform boundary.

---

## 7. Reliable Event Delivery

### 7.1 Architectural Guarantee

A Platform SHALL guarantee durable delivery of Integration Events despite temporary failures.

No committed Integration Event SHALL be permanently lost before successful publication.

This guarantee applies from the moment an Integration Event is derived from a Domain Event by the Platform Integration Layer.

### 7.2 Scope

The durability guarantee applies to Integration Events published via the Platform Contract.

Domain Events on the Internal Event Bus are covered by the transaction commit guarantee of SA-005 §13. The Internal Event Bus durability model is a runtime concern.

### 7.3 Durability Principle

The Platform Integration Layer SHALL ensure that a derived Integration Event is durably recorded before external publication is attempted.

If external publication fails temporarily, the Integration Event SHALL remain available for retry.

The concrete durability mechanism is a runtime implementation concern deferred to SA-007.

### 7.4 Temporary vs Permanent Failure

The architecture distinguishes two failure categories:

| Category | Definition | Response |
|---|---|---|
| Temporary | Transient condition — infrastructure, network, or messaging unavailability | Automatic retry (§8) |
| Permanent | Persistent condition — integration contract mismatch, consumer error, irrecoverable failure | Isolation in Dead Letter Store (§13) |

The classification of a failure as temporary or permanent is a runtime judgment owned by the Platform runtime.

### 7.5 Deferred Implementation Note

The concrete mechanism implementing durable delivery (such as a transactional approach linking commit to publication record, or an equivalent pattern) is an implementation choice.

This choice belongs to SA-007 and the runtime specification.

SA-006 defines the architectural guarantee only.

---

## 8. Retry Policy

### 8.1 Principle

Temporary publication failures SHALL be retried automatically.

The retry policy exists to implement the durable delivery guarantee (§7.1) under temporary failure conditions.

### 8.2 Ownership

The retry policy belongs to the Platform runtime.

Retry intervals, retry counts, and backoff strategies are runtime implementation decisions outside the scope of this specification.

### 8.3 Failure Classification

Upon publication failure, the Platform runtime SHALL determine whether the failure is temporary or permanent.

Temporary failures SHALL trigger automatic retry.

Permanent failures SHALL NOT be retried. They SHALL be isolated in the Dead Letter Store (§13) immediately.

### 8.4 Independence from Business Logic

The retry policy operates on the transport layer.

Business rules and domain logic are not involved in retry decisions.

No Aggregate, Handler, or Domain Event is modified or re-executed during retry.

---

## 9. Idempotency

### 9.1 Requirement

Every Integration Event Consumer SHALL be idempotent.

Every Projection consuming Domain Events SHALL be idempotent.

### 9.2 Definition

A consumer is idempotent when receiving and processing the same event multiple times produces exactly the same outcome as receiving it once.

Duplicate delivery SHALL NEVER produce multiple business effects.

### 9.3 Consumer Responsibility

Idempotency is the responsibility of the consumer.

The Internal Event Bus, the Platform Contract, and the Platform Integration Layer are not responsible for deduplication.

Each consumer SHALL implement idempotency controls appropriate to its own domain context.

### 9.4 Why Duplicate Delivery Occurs

Duplicate delivery is an operational consequence of:

- automatic retry under temporary failure (§8);
- replay of isolated failed events (§13.4);
- Projection rebuilding (§12.5).

Consumers are designed with the expectation of at-least-once delivery.

### 9.5 Replay Safety

Because consumers are idempotent, replay mechanisms (§13.4, §12.5) are safe to execute without business side effects.

Replay is a recovery operation. It does not require coordination with producers.

---

## 10. Event Ordering

### 10.1 No Global Ordering

The architecture SHALL NOT require global event ordering.

Global ordering requires serialisation of all events through a single ordered channel, eliminating parallelism and imposing infrastructure cost that serves no business requirement at the Platform level.

### 10.2 Business Ordering

Ordering guarantees SHALL exist only when required to preserve business consistency.

A business ordering requirement exists when the outcome of processing event B depends on event A having been processed first, within the same business entity or workflow.

### 10.3 Scope of Ordering

Ordering SHALL be limited to related business entities or workflows.

Events from independent business domains and independent Platforms MAY be processed in any order.

### 10.4 Parallel Execution

Independent business flows MAY execute in parallel.

Projections for different business scopes execute independently and do not require ordering relative to each other.

Cross-Platform Integration Events from independent business flows MAY be consumed in parallel by receiving Platforms.

---

## 11. Public Event Contract Evolution

### 11.1 Stability Principle

Stability of public Integration Event contracts is an architectural objective.

Stable contracts reduce consumer migration burden and protect Platform independence.

### 11.2 Backward Compatibility

Public Integration Events SHALL preserve backward compatibility whenever possible.

A change is backward compatible when existing consumers can process the updated event without modification.

Adding optional data to an existing Integration Event is backward compatible. It SHALL NOT require a new event version.

### 11.3 Breaking Changes

A new event version SHALL be introduced ONLY when backward compatibility cannot be preserved.

Breaking changes are changes that require existing consumers to modify their integration.

Before introducing a new version, the producing Platform SHALL verify that the change cannot be expressed as a backward-compatible addition.

### 11.4 Evolution Rules

| Change type | Backward compatible | New version required |
|---|---|---|
| Add optional field | Yes | No |
| Change field name | No | Yes |
| Remove field | No | Yes |
| Change field type | No | Yes |
| Change event semantics | No | Yes |

### 11.5 Avoiding Version Proliferation

Multiple simultaneous active event versions SHOULD NOT be introduced.

Each version in circulation is a maintenance obligation for all consumers.

When a new version is introduced, a migration path for consumers SHOULD be defined and the previous version SHOULD be deprecated with a communicated end-of-life.

---

## 12. Projection Architecture

### 12.1 Relation to SA-005

Projection responsibilities, rules, and Read Model definitions are specified in SA-005 §14.

SA-006 defines the Projection execution model: how Projections operate in relation to each other and how failures are contained.

### 12.2 Execution Model

Each Projection SHALL execute as an independent, isolated consumer of the Internal Event Bus.

Projections SHALL NOT share an execution context.

The execution of Projection A SHALL NOT depend on the execution of Projection B.

### 12.3 Failure Isolation

Failure of one Projection SHALL NEVER prevent execution of other Projections.

A failing Projection is isolated to its own execution scope.

Consumers of the affected Read Model experience degraded availability for that Read Model only. All other Read Models continue to update normally.

### 12.4 Independent Progress

Each Projection advances independently on the Internal Event Bus.

A Projection that falls behind, fails, or is restarted does not affect the progress of other Projections.

The mechanism by which each Projection tracks its progress independently is a runtime implementation concern deferred to OD-004.

### 12.5 Replay

Failed Projections MAY be replayed independently.

Replay reprocesses Domain Events from the Internal Event Bus (or an equivalent event log) starting from a known point.

Replay is safe because Projections are idempotent (§9).

Replay does not require coordination with Aggregates, other Projections, or the Platform Integration Layer.

### 12.6 Read Model Update

A Projection updates its owned Read Model in response to each subscribed Domain Event.

Read Models are updated after the Projection successfully processes the Domain Event.

A Read Model update is the only authorised write operation a Projection performs (SA-005 I-017).

---

## 13. Operational Recovery

### 13.1 Dead Letter Store

The Dead Letter Store is the architectural component that isolates Integration Events and Domain Events that have permanently failed processing.

It is an architectural capability, not a named technology.

Each Platform SHALL provide a Dead Letter Store for Integration Event publication failures.

Each Projection SHALL provide failure isolation for permanently failed Domain Events. Domain Events that cannot be processed successfully after exhausting the retry policy SHALL be isolated and SHALL NOT be silently discarded.

### 13.2 Isolation

Events that cannot be processed successfully after exhausting the retry policy SHALL be isolated in the Dead Letter Store.

Isolated events SHALL NOT be silently discarded.

Isolation is an explicit architectural action that makes failures visible and recoverable.

### 13.3 Operational Inspection

Operational teams SHALL be able to inspect isolated failed events.

An isolated failed event SHALL expose:

- the event payload;
- the time of failure;
- the failure reason;
- the number of delivery attempts.

### 13.4 Replay

Operational teams SHALL be able to replay isolated failed events.

Replay delivers the isolated event to its consumer again.

Replay is safe because all consumers are idempotent (§9).

Replay MAY target individual events or ranges of events.

### 13.5 Replay Scope

Replay targeting a Projection replays Domain Events to that Projection independently of all other Projections (§12.5).

Replay targeting an Integration Event Consumer replays Integration Events to that consumer independently of the producing Platform.

---

## 14. Dependency Rules

### 14.1 Domain Events

Domain Events SHALL be defined in the Domain layer of the originating Bounded Context.

Domain Events SHALL NOT be imported by another Platform.

Domain Events SHALL NOT be referenced by the Platform Integration Layer of another Platform.

### 14.2 Integration Events

Integration Events SHALL be defined in the Platform Integration Layer.

Integration Events SHALL NOT be defined in the Domain layer.

Integration Events SHALL NOT be defined in the Application layer.

Receiving Platforms consume Integration Events through Anti-Corruption Layers (SA-003 §7.3). They SHALL NOT import Integration Event types from the producing Platform.

### 14.3 Internal Event Bus

The Internal Event Bus is a Platform-level component.

Bounded Contexts within the Platform interact with the Internal Event Bus through messaging adapters in their Infrastructure layer (SA-003 §5 — Messaging building block).

The Internal Event Bus SHALL NOT be accessible to components in other Platforms.

### 14.4 Platform Integration Layer

The Platform Integration Layer depends on:

- the Internal Event Bus (subscriber);
- Domain Event types from Bounded Contexts within the same Platform (subscriber input);
- the Platform Contract (publisher output).

The Platform Integration Layer SHALL NOT depend on:

- Domain Models from other Platforms;
- Application Handlers;
- Aggregates.

### 14.5 Projections

Projections depend on:

- Domain Event types from Bounded Contexts within the same Platform;
- the Read Model store (via Port interface, SA-005 §15.3).

Projections SHALL NOT depend on:

- Aggregates;
- Application Handlers;
- Domain Services;
- other Projections.

### 14.6 Cross-Platform

No component within Platform A SHALL import a class from Platform B.

Cross-Platform communication occurs exclusively through Integration Events published via Platform Contracts (ADR-0014, SA-002 §5.3).

---

## 15. Interaction Diagrams

### 15.1 Domain Event Lifecycle

The full lifecycle from Aggregate to all consumers.

```
Domain (Aggregate)
        │ records Domain Event (pending)
        ▼
Application (Command Handler)
        │ commits transaction
        │ collects pending Domain Events
        │ delegates to Application Runtime
        ▼
Application Runtime
        │ publishes to Internal Event Bus (post-commit)
        ▼
Internal Event Bus
        │
        ├──▶ Projection A             (isolated consumer)
        │         │ updates Read Model A
        │
        ├──▶ Projection B             (isolated consumer)
        │         │ updates Read Model B
        │
        ├──▶ Domain Event Handler BC-B (isolated consumer)
        │         │ reacts within same Platform
        │
        └──▶ Platform Integration Layer (isolated consumer)
                  │ translates to Integration Event
                  ▼
              Platform Contract
                  │ durable publication
                  ▼
              External Platform
```

### 15.2 Cross-Platform Publication Flow

From Domain Event inside Platform A to consumption in Platform B.

```
Platform A — Internal Event Bus
        │
        │ Domain Event
        ▼
Platform A — Platform Integration Layer
        │ translates to Integration Event
        │ records Integration Event durably
        │
        │ publishes
        ▼
Platform A — Platform Contract
        │
        ▼
Platform B — Integration Event Consumer
        │ Anti-Corruption Layer
        │ translates to BC-B concepts
        ▼
Platform B — Application Layer
        │ executes Use Case or updates Read Model
```

Platform A Domain Events are never visible to Platform B.

### 15.3 Retry Flow

Publication failure handling with retry and Dead Letter isolation.

```
Platform Integration Layer
        │
        │ attempts publication
        ▼
Publication Failure
        │
        │ Is failure temporary?
        │
        ├── YES → Retry Policy
        │              │ wait and retry
        │              │
        │              ├── Success → Platform Contract published
        │              │
        │              └── Retry exhausted → Dead Letter Store
        │
        └── NO (permanent) → Dead Letter Store immediately
```

### 15.4 Projection Flow

Normal Projection execution and failure containment.

```
Internal Event Bus
        │
        ├──▶ Projection A
        │         │ applies idempotency check
        │         │ updates Read Model A
        │         ✓ success — independent of B
        │
        └──▶ Projection B
                  │ applies idempotency check
                  │ failure
                  │
                  ▼
              Projection B failure isolation
                  │ retry
                  │ isolate if permanent
                  │
                  Read Model A continues updating normally
```

Projection B failure has no effect on Projection A or any other consumer.

### 15.5 Operational Recovery Flow

Inspection and targeted replay of isolated failed events.

```
Dead Letter Store
        │
        │ [Operational team inspects]
        │   - event payload
        │   - failure reason
        │   - attempt count
        │
        │ [Root cause resolved]
        │
        │ [Operational team triggers replay]
        ▼
Target Consumer (Projection or Integration Event Consumer)
        │ idempotency check
        │ processes event
        ▼
Read Model or downstream state recovered
```

Replay targets a specific consumer. Other consumers are unaffected.

---

## 16. Architectural Invariants

The following invariants apply to every Platform and every Bounded Context without exception.

Violations require an Architecture Decision Record before implementation.

| # | Invariant | Decision Source |
|---|---|---|
| I-001 | Domain Events SHALL NEVER cross Platform boundaries. | ADR-SA-006 D-001, ADR-0014 |
| I-002 | Integration Events SHALL be produced exclusively by the Platform Integration Layer. | ADR-SA-006 D-001, D-003 |
| I-003 | Aggregates SHALL NEVER create Integration Events. | ADR-SA-006 D-003 |
| I-004 | Application Handlers SHALL NEVER create Integration Events. | ADR-SA-006 D-003 |
| I-005 | Each Platform SHALL own exactly one Internal Event Bus. | ADR-SA-006 D-004 |
| I-006 | The Internal Event Bus SHALL NEVER cross Platform boundaries. | ADR-SA-006 D-004 |
| I-007 | All Domain Events published within a Platform SHALL transit through the Internal Event Bus. | ADR-SA-006 D-004 |
| I-008 | Domain Events SHALL be published to the Internal Event Bus only after a successful transaction commit. | ADR-SA-006 D-001; SA-005 D-008 (post-commit publication guarantee) |
| I-009 | No committed Integration Event SHALL be permanently lost before successful publication. | ADR-SA-006 D-005 |
| I-010 | Temporary publication failures SHALL be retried automatically. | ADR-SA-006 D-006 |
| I-011 | Permanent publication failures SHALL be isolated in the Dead Letter Store and SHALL NOT be silently discarded. | ADR-SA-006 D-006, D-011 |
| I-012 | Every Integration Event Consumer SHALL be idempotent. | ADR-SA-006 D-007 |
| I-013 | Every Projection SHALL be idempotent. | ADR-SA-006 D-007, D-010 |
| I-014 | Receiving the same event multiple times SHALL NEVER produce multiple business effects. | ADR-SA-006 D-007 |
| I-015 | The architecture SHALL NOT require global event ordering. | ADR-SA-006 D-008 |
| I-016 | Ordering guarantees SHALL be scoped to related business entities or workflows only. | ADR-SA-006 D-008 |
| I-017 | Public Integration Events SHALL preserve backward compatibility whenever possible. | ADR-SA-006 D-009 |
| I-018 | A new Integration Event version SHALL be introduced ONLY when backward compatibility cannot be preserved. | ADR-SA-006 D-009 |
| I-019 | Each Projection SHALL execute independently. Failure of one Projection SHALL NEVER prevent execution of others. | ADR-SA-006 D-010 |
| I-020 | Isolated failed events SHALL be inspectable and replayable by operational teams. | ADR-SA-006 D-011 |
| I-021 | Synchronous cross-Platform collaboration SHALL be used only when the initiating business use case cannot complete without the requested response. All post-completion reactions SHALL be implemented asynchronously using Integration Events. | ADR-SA-006 D-002 |
| I-022 | Each Projection SHALL provide failure isolation for permanently failed Domain Events. Permanently failed Domain Events SHALL NOT be silently discarded. | ADR-SA-006 D-011 |

---

## 17. Reference Folder Structure

Every Platform SHALL follow the event-driven structure below, extending the SA-003 reference structure.

```
{Platform}/
│
├── {BoundedContext}/
│   │
│   ├── Domain/
│   │   └── DomainEvent/               ← Domain Events — owned by this BC
│   │       └── {BusinessFact}
│   │
│   ├── Application/
│   │   └── Handler/
│   │       ├── {UseCase}CommandHandler     ← Command Handlers — one per use case (SA-005 §6)
│   │       ├── Get{Resource}QueryHandler   ← Query Handlers — one per query (SA-005 §7)
│   │       └── On{DomainEvent}            ← Domain Event Handlers — reactions within Platform (§4.4)
│   │
│   └── Infrastructure/
│       ├── Messaging/                 ← Internal Event Bus adapter — publish / subscribe
│       │   ├── EventPublisher
│       │   └── EventSubscriber
│       └── Projection/                ← Projections — one per Read Model scope
│           └── {ReadModelScope}Projection
│
├── Integration/                       ← Platform Integration Layer
│   │
│   ├── IntegrationEvent/              ← Integration Event definitions — owned by PIL
│   │   └── {CrossPlatformFact}
│   │
│   ├── Translator/                    ← Domain Event → Integration Event translation
│   │   └── {BusinessFact}Translator
│   │
│   └── Publisher/                     ← Durable Integration Event publication
│       └── IntegrationEventPublisher
│
└── OperationalRecovery/               ← Dead Letter management and targeted replay
    ├── DeadLetterStore
    └── ReplayHandler
```

### Structural Rules

- `DomainEvent/` contains only Domain Events for this Bounded Context.
- `Application/Handler/` contains Command Handlers, Query Handlers, and Domain Event Handlers. Command and Query Handlers are distinguished from Domain Event Handlers by their trigger: a Command or Query versus a Domain Event. All three types follow the same Application Layer rules (SA-003 §5).
- `Integration/IntegrationEvent/` contains only Integration Events owned by this Platform.
- `Integration/Translator/` contains only translation logic from Domain Events to Integration Events.
- `Projection/` contains one file per Read Model scope. A Projection that maintains multiple scopes in a single file constitutes a structural violation.
- `OperationalRecovery/` is a Platform-level directory, not a BC-level directory.

### Naming Conventions

| Artifact | Convention | Example |
|---|---|---|
| Domain Event | `{BusinessFact}` | `ClinicalActivityStarted` |
| Integration Event | `{CrossPlatformFact}` | `ClinicalActivityOpened` |
| Command Handler | `{UseCase}CommandHandler` | `StartClinicalActivityCommandHandler` |
| Query Handler | `Get{Resource}QueryHandler` | `GetPatientTimelineQueryHandler` |
| Domain Event Handler | `On{DomainEvent}` | `OnClinicalActivityStarted` |
| Projection | `{ReadModelScope}Projection` | `PatientTimelineProjection` |
| Translator | `{BusinessFact}Translator` | `ClinicalActivityStartedTranslator` |

---

## 18. Cross-document Alignment

### 18.1 SA-005 OD-003 — Partial Closure

SA-005 OD-003 deferred to SA-006 the definition of the Domain Event publication mechanism.

SA-006 Section 4.3 establishes the architectural principle: the Application Runtime publishes Domain Events to the Internal Event Bus after a successful transaction commit.

The concrete collection pattern (pull from Aggregate, observer, or equivalent) remains a runtime implementation decision. It is not prescribed by this specification.

### 18.2 SA-005 §13 — Lifecycle Extension

SA-005 §13 defines the Domain Event lifecycle through publication by the Application Runtime.

SA-006 defines what occurs after that publication: Internal Event Bus routing, Projection consumption, Platform Integration Layer translation, Integration Event publication, and downstream consumption.

The two specifications are complementary. SA-005 owns the write-side lifecycle. SA-006 owns the post-publication flow.

### 18.3 SA-002 §3.3 — Platform Integration Layer

SA-002 §3.3 defines Integration as a Platform Building Block.

SA-006 §6 formalises the responsibilities, ownership, and boundaries of that building block.

### 18.4 SA-003 §7.4 — Outbound Integration Flow

SA-003 §7.4 defines the outbound integration pattern:

```
Domain (Aggregate) → Domain Event → Platform Integration Layer → Integration Event → Platform Contract
```

SA-006 §6 and §15.2 formalise this pattern with explicit rules, ownership, and durability guarantees.

### 18.5 ADR-0014 — Reinforcement

ADR-0014 establishes that Domain Events shall never cross Platform boundaries.

SA-006 §3.2.3, §5.3, §14.1, and I-001 reinforce this rule with explicit SHALL NOT statements, dependency rules, and an independently verifiable invariant.

### 18.6 SA-005 §12.3 — Collaboration Model Alignment

SA-005 §12.3 establishes the synchronous and asynchronous collaboration rules for cross-Bounded-Context communication within a Platform: synchronous through Application Facades when the use case cannot complete without the response, asynchronous through Domain Events for post-completion reactions.

SA-006 §4.5 and I-021 extend these rules to cross-Platform communication: all post-completion reactions crossing Platform boundaries SHALL be implemented asynchronously using Integration Events.

The two specifications are complementary. SA-005 §12.3 governs intra-Platform collaboration. SA-006 §4.5 governs cross-Platform collaboration. Together they implement ADR-SA-006 D-002 across all collaboration scopes.

---

## 19. Open Decisions

| ID | Decision | Status |
|---|---|---|
| OD-001 | Domain Event collection pattern — pull from Aggregate vs observer vs collector | Open — deferred to runtime specification |
| OD-002 | Internal Event Bus durability model for intra-Platform Domain Events | Open — deferred to SA-007 |
| OD-003 | Ordering constraint declaration mechanism — how business ordering requirements are expressed and enforced | Open |
| OD-004 | Projection independent progress tracking — how each Projection tracks its progress on the Internal Event Bus | Open — deferred to runtime specification |
| OD-005 | Dead Letter Store interface — query, filter, and replay API | Open — deferred to runtime specification |

---

## 20. References

- SA-001 — Reference Architecture (SA-P-0010, SA-P-0011)
- SA-002 — Platform Architecture (§3.3 Integration, §3.5 Platform Contract, §5 Platform Collaboration)
- SA-003 — Bounded Context Architecture (§2, §5 Building Blocks, §7.3 Inbound Integration, §7.4 Outbound Integration, §8 Invariants)
- SA-005 — Application & CQRS Architecture (§12.3 Cross-BC Collaboration, §13 Domain Event Lifecycle, §14 Projections and Read Models)
- ADR-SA-006 — Architectural Decision Register D-001 through D-011
- ADR-0003 — Hexagonal Architecture
- ADR-0005 — Business Events vs Domain Events
- ADR-0014 — Domain Events Shall Never Cross Platform Boundaries
