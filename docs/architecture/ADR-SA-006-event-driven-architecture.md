# ADR-SA-006 — Event-Driven Architecture

**Document ID**: ADR-SA-006
**Title**: Architectural Decisions — Event-Driven Architecture
**Status**: Approved
**Date**: 2026-07-15

---

## Purpose

This document records the architectural decisions approved during the SA-006 Architecture Workshop.

It is the single source of truth for SA-006 — Event-Driven Architecture.

It is not an implementation guide.

It defines architectural responsibilities and guarantees only.

No implementation technology is prescribed.

---

## Context

The certified architecture establishes the following foundations that SA-006 extends:

- **SA-002 §5**: Platforms collaborate through published contracts. Domain Events remain internal to their Platform.
- **SA-003 Invariant 3**: Domain Events MAY be consumed by another Bounded Context through the internal event bus. They SHALL NOT cross Platform boundaries.
- **SA-005 D-008**: Aggregates record Domain Events. The Application Runtime publishes them after a successful transaction commit. Aggregates SHALL NEVER publish events directly.
- **ADR-0014**: Domain Events SHALL NEVER cross Platform boundaries. Integration Events are the sole cross-Platform event mechanism.

SA-006 formalizes the complete Event-Driven Architecture governing:

- the two-event taxonomy and their respective scopes;
- synchronous vs asynchronous collaboration principles;
- the Platform Integration Layer and its exclusive responsibilities;
- the Platform Internal Event Bus;
- reliable event delivery guarantees;
- retry policy;
- consumer idempotency;
- event ordering;
- public event contract evolution;
- Projection execution isolation;
- operational recovery.

---

## Scope

These decisions apply to:

- every Platform within the MedLink Architecture;
- every Bounded Context publishing or consuming events;
- every Platform Integration Layer;
- every Projection consuming Domain Events;
- every Integration Event Consumer.

---

## D-001 — Domain Events vs Integration Events

### Context

Two event types coexist in the certified architecture. Their scopes and ownership are referenced across SA-002, SA-003, SA-005, and ADR-0014 but have not been formally specified as a unified taxonomy.

### Problem

Without an explicit, unified ownership model, the boundary between internal domain facts and external communication contracts becomes ambiguous. Domain Events risk being published beyond their intended scope, exposing internal domain structure to external consumers and creating involuntary coupling across Platform evolution cycles.

### Decision

- Domain Events belong to the internal Domain Model of the Bounded Context that produced them.
- Domain Events MAY cross Bounded Context boundaries within the same Platform via the Internal Event Bus.
- Domain Events SHALL NEVER cross Platform boundaries.
- Cross-Platform communication SHALL occur exclusively through Integration Events.
- Integration Events are owned by the Platform Integration Layer.

### Rationale

Domain Events carry domain semantics governed by the Domain Model. Their vocabulary, structure, and lifecycle are dictated by business modelling decisions — not by external consumers. Exposing them beyond the Platform boundary couples external consumers to internal domain evolution, making independent Platform evolution impossible.

Integration Events are purpose-built contracts for cross-Platform communication. Their structure and lifecycle are governed by contract stability rules, not by domain modelling rules. This separation allows each Platform to evolve its Domain Model freely while maintaining stable external contracts.

### Consequences

- Each event type has exactly one owner: Domain Events owned by the originating Bounded Context; Integration Events owned by the Platform Integration Layer.
- Platforms may refactor their Domain Model without breaking external consumers, provided Integration Events remain stable.
- Domain Events are invisible to external Platforms.

### Alternatives Considered

- **Single event type**: One event type used for both internal and cross-Platform communication. Rejected: couples internal domain evolution to external contract stability. Any internal refactoring risks breaking external consumers.
- **Shared Domain Model Events**: External consumers subscribe directly to internal Domain Events. Rejected: violates Platform boundary isolation, creates implicit coupling between Platform teams.

### Architectural Risks Eliminated

- Domain model leakage across Platform boundaries.
- Involuntary coupling between Platform evolution cycles.
- Unstable cross-Platform contracts driven by internal domain refactoring.

### Cross-document Traceability

- ADR-0014: Domain Events SHALL NEVER cross Platform boundaries.
- SA-002 §5.4: Domain Event vs Integration Event comparison.
- SA-003 Invariant 3: Domain Events MAY be consumed by another BC through the internal event bus.
- SA-005 §13: Domain Event Lifecycle.

---

## D-002 — Synchronous vs Asynchronous Collaboration

### Context

SA-003 Rule 6 and SA-005 §12.3 permit two cross-BC collaboration mechanisms: synchronous via Application Facade, and asynchronous via Domain Events. The principle governing which mechanism to apply has not been formally specified.

### Problem

Without a governing principle, synchronous coupling may proliferate beyond its justified use — creating temporal dependencies between Bounded Contexts and Platforms, reducing system resilience, and coupling availability domains.

### Decision

- Synchronous collaboration SHALL be used only when the current Use Case cannot complete without the requested response.
- All post-completion reactions SHALL be implemented asynchronously using Domain Events (intra-Platform) or Integration Events (cross-Platform).

### Rationale

Synchronous coupling creates a temporal dependency: if the called component is unavailable, the caller cannot complete its Use Case. This dependency is architecturally justified only when the result is essential to the current business transaction. Post-completion reactions — projections, notifications, downstream business processes — never require synchronous coupling and SHALL use asynchronous mechanisms.

This principle limits synchronous coupling to its minimum justified scope and ensures that asynchronous mechanisms are the default for all non-essential reactions.

### Consequences

- Synchronous Facade calls are architecturally justified only for essential intra-transaction dependencies.
- Business reactions are decoupled from the originating transaction.
- A failing consumer does not block a producing Platform.
- Platform resilience and availability become independent.

### Alternatives Considered

- **Synchronous-first approach**: Use synchronous calls unless performance prevents it. Rejected: leads to temporal coupling, cascading failures, and availability domain merging.
- **Asynchronous-only approach**: Prohibit synchronous cross-BC calls entirely. Rejected: some Use Cases genuinely require a synchronous response to preserve business consistency within a single transaction boundary.

### Architectural Risks Eliminated

- Cascade failure propagation through synchronous dependency chains.
- Temporal coupling between Bounded Contexts and Platforms.
- Blocking business transactions on non-essential downstream reactions.

### Cross-document Traceability

- SA-003 Rule 6: Cross-BC collaboration through Application Facades (sync) and Domain Events (async).
- SA-005 §12.3: Cross-BC Collaboration patterns.

---

## D-003 — Platform Integration Layer

### Context

SA-002 §3.3 defines Integration as a Platform Building Block. SA-003 §7.4 defines the Outbound Integration flow. SA-005 D-008 establishes that Integration Events are produced by the Platform Integration Layer — not by Aggregates or Handlers. The responsibilities of this layer have not been formally specified.

### Problem

Without explicit responsibility assignment, the creation of Integration Events may migrate into Aggregates or Application Handlers — contaminating the Domain Model with cross-Platform concerns and creating fragile, multi-responsibility components.

### Decision

- The Platform Integration Layer SHALL be the sole component responsible for translating Domain Events into Integration Events.
- Aggregates SHALL NEVER create Integration Events.
- Application Handlers SHALL NEVER create Integration Events.
- The public Platform Contract is owned exclusively by the Platform Integration Layer.

### Rationale

The Platform Integration Layer is the translation boundary between internal domain facts and external communication contracts. By concentrating this responsibility, the Domain Model remains isolated from cross-Platform knowledge. The Integration Layer absorbs the cost of contract evolution without that cost propagating into the Domain.

SA-P-0010 (Single Architectural Responsibility): the Platform Integration Layer owns exactly one responsibility — the translation between internal Domain Events and external Integration Events.

### Consequences

- Aggregates and Application Handlers have no dependency on Integration Events.
- The Platform Integration Layer is the single point of change for cross-Platform contract evolution.
- The Domain Model is testable independently of cross-Platform concerns.

### Alternatives Considered

- **Handler-produced Integration Events**: Application Handlers create Integration Events directly after publishing Domain Events. Rejected: introduces cross-Platform contract awareness into the Application Layer, violates SA-P-0010, and couples Handler evolution to external contract stability.
- **Aggregate-produced Integration Events**: Aggregates record both Domain Events and Integration Events. Rejected: exposes cross-Platform concerns to the Domain Model, violates Domain purity.

### Architectural Risks Eliminated

- Cross-Platform knowledge contaminating the Domain Model.
- Aggregates depending on external Platform contracts.
- Application Handlers accumulating integration responsibilities.

### Cross-document Traceability

- SA-002 §3.3: Integration as a Platform Building Block.
- SA-002 §3.5: Platform Contract.
- SA-003 §7.4: Outbound Integration flow.
- SA-005 D-008: Integration Events produced by the Platform Integration Layer, not the Domain.

---

## D-004 — Platform Internal Event Bus

### Context

SA-002 §5.2 establishes Domain Events as the intra-Platform communication mechanism. SA-003 §2 states that Bounded Contexts communicate through Domain Events on the internal event bus. The Internal Event Bus has been referenced in previous documents but not formally defined as an architectural building block with explicit boundaries.

### Problem

Without explicit bus boundaries, events may flow beyond their intended scope. A shared global bus would make Platform boundary enforcement dependent on consumer discipline rather than transport architecture.

### Decision

- Each Platform SHALL own exactly one Internal Event Bus.
- All Domain Events published inside a Platform SHALL transit through this Internal Event Bus.
- The Internal Event Bus SHALL NEVER cross Platform boundaries.

### Rationale

One Internal Event Bus per Platform enforces Platform boundaries at the transport level — not only through architectural rules and static analysis. Domain Events remain internal because the transport itself cannot be accessed from outside the Platform. The Platform Integration Layer subscribes to this bus to produce Integration Events; external Platforms cannot.

SA-P-0010 (Single Architectural Responsibility): the Internal Event Bus owns one responsibility — intra-Platform Domain Event routing.

### Consequences

- Platform boundaries are enforced at two levels: architectural rules (ADR-0014, SA-003 Invariant 3) and transport scope (Internal Event Bus per Platform).
- The Platform Integration Layer is the sole subscriber that may translate events crossing the Platform boundary.
- External Platforms cannot access the Internal Event Bus.

### Alternatives Considered

- **Global event bus shared across Platforms**: All events on a single shared bus. Rejected: eliminates boundary enforcement at the transport level; creates implicit cross-Platform coupling.
- **One bus per Bounded Context**: Each BC has its own bus. Rejected: excessive fragmentation; adds operational complexity without additional architectural benefit beyond one bus per Platform.

### Architectural Risks Eliminated

- External Platforms subscribing directly to internal Domain Events.
- Domain Events leaking across Platform boundaries through shared transport infrastructure.

### Cross-document Traceability

- SA-002 §5.2: Intra-Platform communication through Domain Events.
- SA-003 §2: Bounded Context communication via Domain Events on the internal event bus.
- ADR-0014: Domain Events SHALL NEVER cross Platform boundaries.

---

## D-005 — Reliable Event Delivery

### Context

SA-005 D-008 establishes that Domain Events remain pending until the transaction commits and are published after a successful commit. The architectural guarantee against event loss between commit and successful publication has not been formally specified.

### Problem

Without a durability guarantee, a process, infrastructure, or network failure occurring between transaction commit and event publication causes committed business facts to be permanently lost. Downstream Projections and Platform Integration Layers would never observe those facts, producing silent inconsistency.

### Decision

- A Platform SHALL guarantee durable delivery of Integration Events despite temporary failures.
- Temporary failures include process failures, infrastructure failures, messaging failures, and network interruptions.
- No committed Integration Event SHALL be lost before successful publication.
- The concrete durability mechanism is an implementation choice deferred to SA-006.

### Rationale

A committed business fact is an architectural guarantee. Publishing an Integration Event is the mechanism by which that fact becomes visible to external consumers. The architecture must guarantee that committed facts are eventually published — not merely that publication is attempted. The responsibility is architectural; the mechanism is an implementation concern.

### Consequences

- Every Platform bears responsibility for guaranteeing durable Integration Event publication.
- Temporary failures do not result in permanent data loss.
- External Platforms can rely on receiving every Integration Event that corresponds to a committed business fact.

### Alternatives Considered

- **Best-effort delivery**: Publish events without a durability guarantee. Rejected: a process failure between commit and publication permanently and silently loses the event.
- **Synchronous coupling as reliability mechanism**: Include downstream consumers in the originating transaction. Rejected: couples Platform transaction lifecycles; violates Platform boundary isolation.

### Architectural Risks Eliminated

- Silent permanent data loss for committed business facts.
- Inconsistent state between Platforms caused by undelivered Integration Events.

### Cross-document Traceability

- SA-005 D-008: Domain Events remain pending until commit; publication occurs only after a successful commit.
- SA-005 §13.5: Failure Guarantee — events are not published if the transaction rolls back.

---

## D-006 — Retry Policy

### Context

D-005 establishes durable delivery as an architectural guarantee. Temporary failures are an operational reality. The mechanism for recovering from temporary publication failures must be specified at the architectural level.

### Problem

Without a retry principle, a temporary messaging or infrastructure failure would prevent Integration Event publication after the durability guarantee has been established — violating D-005.

### Decision

- Temporary publication failures SHALL be retried automatically.
- Retry policy belongs to the Platform runtime.
- Permanent failures SHALL be isolated for operational recovery.
- Retry intervals and retry counts are implementation decisions deferred to SA-006.

### Rationale

Automatic retry is the operational mechanism that implements the durable delivery guarantee of D-005. The retry policy — intervals, counts, backoff strategy — is context-dependent and belongs to the implementation. The architectural principle is technology-neutral: retry temporary failures, isolate permanent failures. Distinguishing temporary from permanent failures requires operational judgment; the architecture mandates that permanent failures be isolated rather than lost.

### Consequences

- Temporary failures do not permanently block event publication.
- Permanent failures are isolated, observable, and recoverable (D-011).
- The Platform runtime owns the retry policy, not the Domain or Application Layer.

### Alternatives Considered

- **Manual retry only**: Operations team retries manually. Rejected: unacceptable operational overhead; violates D-005.
- **Infinite retry without isolation**: Retry permanently until success. Rejected: permanent failures would block the delivery pipeline indefinitely and remain undetectable.

### Architectural Risks Eliminated

- Temporary failures converting into permanent and silent event loss.
- Undetected permanent failures creating invisible data gaps.

### Cross-document Traceability

- D-005: Durable delivery guarantee that retry implements.
- D-011: Operational recovery for events that exhaust the retry policy.

---

## D-007 — Idempotent Consumers

### Context

D-005 establishes that Integration Events are delivered durably. D-006 establishes automatic retry. Both mechanisms may cause the same Integration Event to be delivered more than once to a consumer. If consumers are not idempotent, duplicate delivery produces duplicate business effects.

### Problem

Without consumer idempotency, reliable delivery and automatic retry — both architectural guarantees — become a source of data corruption. The mechanisms that ensure delivery also create the risk of duplicate effects.

### Decision

- Every Integration Event Consumer SHALL be idempotent.
- Receiving the same Integration Event multiple times SHALL NEVER produce multiple business effects.
- Idempotency is the responsibility of the consumer.

### Rationale

In a reliable delivery architecture, duplicate delivery is not an error — it is an operational consequence of the durability guarantee. Consumers must be designed to handle duplicates gracefully. The responsibility belongs to the consumer because the consumer holds the domain knowledge of what constitutes a duplicate effect within its own context.

SA-P-0010 (Single Architectural Responsibility): the event bus is responsible for delivery; the consumer is responsible for idempotency. These responsibilities do not overlap.

### Consequences

- Consumers implement idempotency controls independently of the producing Platform.
- Retry mechanisms (D-006) and replay mechanisms (D-011) operate safely without risk of duplicate effects.
- The producing Platform has no obligation to track delivery status per consumer.

### Alternatives Considered

- **Bus-level deduplication**: The event bus deduplicates before delivery. Rejected: shifts consumer-domain knowledge into infrastructure; does not account for application-level duplicates; increases bus responsibility beyond D-004.
- **Exactly-once delivery guarantee**: Guarantee each event is delivered exactly once. Rejected: exactly-once delivery is not achievable as an architectural absolute in distributed systems; it relocates rather than resolves the problem.

### Architectural Risks Eliminated

- Duplicate business effects from retry and replay mechanisms.
- Consumer corruption caused by reliable delivery mechanisms.

### Cross-document Traceability

- SA-005 §14.3: Projections SHALL NOT execute business rules — idempotency is a necessary condition.
- D-005: Reliable delivery may deliver the same event more than once.
- D-006: Automatic retry increases the probability of duplicate delivery.
- D-011: Replay increases the probability of duplicate delivery.

---

## D-008 — Event Ordering

### Context

In an event-driven architecture, global event ordering is achievable only through serialization of all events — eliminating parallelism and introducing significant infrastructure complexity. Most business flows are independent and do not require ordering relative to each other.

### Problem

Prescribing global event ordering would introduce architectural complexity not justified by business requirements, reduce throughput, and eliminate the parallelism that makes event-driven architecture operationally valuable.

### Decision

- The architecture SHALL NOT require global event ordering.
- Ordering guarantees SHALL exist only when required to preserve business consistency.
- Independent business flows MAY execute in parallel.
- Ordering SHALL be limited to related business entities or workflows.

### Rationale

Business flows are independent at the Platform level. There is no business requirement that events from unrelated domains be ordered relative to each other. Ordering constraints are relevant only within specific business workflows where sequence determines consistency.

SA-P-0011 (Cognitive Simplicity): mandating global ordering introduces infrastructure complexity that serves no corresponding business guarantee. Ordering constraints are declared explicitly where business requirements justify them.

### Consequences

- Consumers must be designed to handle unordered delivery of logically unrelated events.
- Ordering guarantees are explicit, scoped, and justified by business requirements.
- Platform throughput and parallelism are preserved.

### Alternatives Considered

- **Global event ordering**: All events ordered through a single ordered log. Rejected: eliminates parallelism, adds infrastructure complexity, serves no business requirement at the Platform level.
- **No ordering guarantees at all**: Events may arrive in any order, including within related business workflows. Rejected: some business workflows require ordering to maintain consistency (a Handover cannot be accepted before it is requested).

### Architectural Risks Eliminated

- Accidental business inconsistency from unordered delivery of dependent events.
- Unnecessary infrastructure complexity imposed by a global ordering requirement.

### Cross-document Traceability

- SA-001 SA-P-0011: Cognitive Simplicity.
- SA-003 §2: Bounded Context communication through Domain Events.

---

## D-009 — Public Event Contract Evolution

### Context

Published Integration Events are stable contracts consumed by external Platforms. Their evolution must balance the need to reflect business change against the cost imposed on consuming Platforms.

### Problem

Without evolution rules, every business change produces a new event version. Proliferating V1, V2, V3 artifacts increases consumer migration burden, creates parallel maintenance obligations, and violates SA-P-0011 (Cognitive Simplicity).

### Decision

- Public Integration Events SHALL preserve backward compatibility whenever possible.
- Adding optional data SHALL NOT require a new event version.
- A new version SHALL be introduced ONLY when backward compatibility cannot be preserved.
- Stable public contracts SHALL be preferred over proliferating event versions.

### Rationale

Backward-compatible evolution — adding optional fields — is the lowest-cost evolutionary path. It allows producers to enrich events without breaking existing consumers. Versioning is reserved for genuinely breaking changes, which are the exception rather than the rule in a well-designed event contract.

SA-P-0011 (Cognitive Simplicity): proliferating event versions increases cognitive load for all consuming teams and creates maintenance obligations that persist indefinitely.

### Consequences

- Consumers are not forced to migrate for non-breaking additions.
- Event version proliferation is minimized.
- Breaking changes require explicit architectural justification, not a default response to any schema evolution.

### Alternatives Considered

- **Version every change**: A new event version for any modification. Rejected: creates excessive migration burden; violates SA-P-0011.
- **No versioning**: Evolve events freely without version control. Rejected: breaking changes would silently corrupt consumers.

### Architectural Risks Eliminated

- Consumer migration burden from unnecessary versioning.
- Proliferation of parallel event versions maintained indefinitely.
- Implicit breaking changes propagated silently to consumers.

### Cross-document Traceability

- SA-002 §6 Rule 6: A Platform may evolve internally provided its published contract remains stable.
- SA-002 §3.5: Platform Contract stability.

---

## D-010 — Projection Execution Model

### Context

SA-005 D-006 establishes that Projections subscribe to Domain Events and maintain Read Models. SA-005 §14.3 establishes Projection rules. The operational execution model — how Projections relate to each other — has not been specified.

### Problem

Without execution isolation, a failure in one Projection can cascade to other Projections, blocking Read Model updates across the system for an unrelated failure. The entire read layer becomes dependent on the least resilient Projection.

### Decision

- Each Projection SHALL execute independently.
- Failure of one Projection SHALL NEVER prevent execution of other Projections.
- Failed Projections MAY be replayed independently.
- Projections SHALL remain isolated consumers of Domain Events.

### Rationale

Projections build Read Models that serve distinct consumers. A failure in the patient timeline Projection must not prevent the practitioner workflow Projection from updating. Operational resilience requires that Projection failures be contained to their own scope.

SA-P-0010 (Single Architectural Responsibility): each Projection owns exactly one Read Model scope. Failure isolation is a natural consequence of responsibility isolation.

### Consequences

- Projection failure is contained: consumers of unaffected Read Models continue without interruption.
- Failed Projections can be identified, inspected, and replayed independently (D-011).
- Operational recovery is targeted, not system-wide.

### Alternatives Considered

- **Sequential Projection execution**: Projections run in sequence, sharing a single consumer context. Rejected: one failure blocks all subsequent Projections.
- **Shared Projection consumer group**: All Projections consume from a single shared subscription. Rejected: failure isolation is impossible when consumers share an execution context.

### Architectural Risks Eliminated

- Cascading Projection failures blocking the entire Read Model layer.
- Inability to replay a single failed Projection without affecting others.

### Cross-document Traceability

- SA-005 D-006: Projection Model.
- SA-005 §14.3: Projection Rules.
- SA-005 §14.4: Projection Rebuilding — any Read Model MAY be rebuilt from Domain Event history.

---

## D-011 — Operational Recovery

### Context

D-005 establishes durable delivery. D-006 establishes automatic retry for temporary failures. When retry is exhausted, a permanent failure must be handled. Without an explicit architectural capability, permanently failed events are silently discarded.

### Problem

Silent discard of permanently failed events creates invisible data gaps in Projections and downstream Platforms — gaps that are undetectable until a consumer reports missing data.

### Decision

- Events that cannot be processed successfully after exhausting the retry policy SHALL be isolated.
- Operational teams SHALL be able to inspect isolated failed events.
- Operational teams SHALL be able to replay isolated failed events.
- Operational recovery is an architectural capability, independent of implementation technology.

### Rationale

Permanent failure is an operational reality. The architecture must guarantee that permanently failed events are never silently discarded. Isolation makes failures visible and recoverable. Independent replay capability (D-010) ensures recovery can be targeted to the affected Projection or consumer without system-wide disruption.

### Consequences

- No committed event is silently lost after retry exhaustion.
- Operational teams have full observability over failed events.
- Recovery is a targeted, operational action — not a system-wide rollback.

### Alternatives Considered

- **Silent discard after retry exhaustion**: Failed events are discarded after maximum retries. Rejected: creates invisible data gaps; violates D-005.
- **Blocking failure**: Processing halts until the failure is resolved. Rejected: one permanent failure blocks the entire event pipeline.

### Architectural Risks Eliminated

- Silent permanent data loss after retry exhaustion.
- Undetected Projection inconsistencies caused by permanently lost events.
- Inability to recover from partial failures without full system restart.

### Cross-document Traceability

- D-005: Durable delivery guarantee.
- D-006: Retry policy — permanent failures are isolated after retry exhaustion.
- D-010: Projection isolation — replay targets individual Projections independently.
- SA-005 §14.4: Projection rebuilding capability.

---

## Foundational Principles

### SA-P-0010 — Single Architectural Responsibility

Every architectural building block defined in this ADR owns exactly one responsibility.

| Building Block | Single Responsibility |
|---|---|
| Domain Event | Carries an internal business fact within its Platform |
| Integration Event | Carries a cross-Platform communication contract |
| Platform Internal Event Bus | Routes Domain Events within a Platform boundary |
| Platform Integration Layer | Translates Domain Events into Integration Events |
| Projection | Maintains exactly one Read Model scope |
| Integration Event Consumer | Consumes and applies Integration Events idempotently |

Responsibilities SHALL NOT overlap. If two building blocks share a responsibility, the architecture SHALL be reconsidered.

### SA-P-0011 — Cognitive Simplicity

Every architectural decision in this ADR eliminates complexity rather than adding it.

- D-001 eliminates ambiguity in event taxonomy.
- D-002 eliminates unjustified synchronous coupling.
- D-003 eliminates distributed responsibility for Integration Event creation.
- D-004 eliminates boundary ambiguity at the transport level.
- D-008 eliminates unjustified global ordering requirements.
- D-009 eliminates event version proliferation.
- D-010 eliminates cascading failure complexity.

Every architectural concept in this ADR is justified by a corresponding reduction in system complexity or risk.

---

## Outcome

The decisions recorded in ADR-SA-006 constitute the normative architectural basis for SA-006 — Event-Driven Architecture.

SA-006 SHALL formalize these decisions without introducing additional architectural concepts or altering the approved responsibilities.

The following decisions remain open for SA-006 to specify:

| Decision | What SA-006 SHALL define |
|---|---|
| D-005 | Concrete durability mechanism (Outbox Pattern or equivalent) |
| D-006 | Retry intervals, retry counts, backoff strategy |
| D-008 | Ordering constraint declaration mechanism for related business workflows |
| D-010 | Projection subscription and execution isolation mechanism |
| D-011 | Failed event isolation store and replay interface |
