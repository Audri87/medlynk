# ADR-SA-007 — Architectural Decision Register

**Document ID**: ADR-SA-007
**Title**: Architectural Decisions — Persistence Architecture
**Status**: Approved

---

## Purpose

This document records the architectural decisions approved during the SA-007 Architecture Workshop.

It is not an architecture specification.

It captures the reasoning behind the persistence responsibilities and guarantees that SA-007 SHALL formalise.

No implementation technology is prescribed in this document.

---

## Architectural Principles Applied

### Responsibility First

Each persistence responsibility has exactly one owner.

Repository ownership, transaction management, persistence mapping, concurrency guarantee, Read Model persistence, and schema evolution are distinct responsibilities.

No component accumulates more than one.

### Guarantee First

Every decision in this document describes an architectural guarantee.

No decision prescribes an implementation mechanism.

The mechanism that delivers a guarantee belongs to SA-007 and the runtime specification.

### SA-P-0010 — Single Architectural Responsibility

Every persistence building block owns exactly one architectural responsibility.

Overlapping responsibilities require an Architecture Decision Record before implementation.

### SA-P-0011 — Cognitive Simplicity

Persistence architecture introduces operational and developmental complexity.

These decisions minimise that complexity by:

- assigning one Repository per Aggregate Root;
- enforcing one transaction boundary per use case;
- eliminating persistence knowledge from the Domain Model;
- separating Aggregate state persistence from Read Model persistence.

No persistence abstraction is introduced beyond what domain ownership and CQRS separation require.

---

## D-001 — Repository Ownership

### Context

Aggregate Roots are the consistency boundary of the domain. They protect business invariants through controlled state transitions. Persisting an Aggregate Root requires access to its internal state in a way that guarantees those invariants on restoration.

The question of which component holds the persistence authority for an Aggregate Root determines whether that authority can be bypassed, duplicated, or diluted.

### Problem

Without a clear ownership rule, multiple components may persist the same Aggregate Root independently, producing competing state representations. A single component may also own persistence for multiple Aggregate Roots, coupling domain concepts that must evolve independently.

### Decision

Each Aggregate Root SHALL be persisted exclusively through its owning Repository.

Each Repository SHALL own exactly one Aggregate Root.

A Repository SHALL NOT own multiple Aggregate Roots.

### Rationale

Persistence authority is a direct expression of domain ownership. An Aggregate Root owns its business invariants. Its Repository owns the persistence authority for that Aggregate Root. The relationship between them is one-to-one.

A Repository that owns multiple Aggregate Roots creates hidden coupling between domain concepts that are, by design, meant to evolve independently. A Repository that can be bypassed eliminates the consistency guarantee that exclusive ownership provides.

SA-P-0010 requires that the persistence responsibility for each Aggregate Root belongs to exactly one component. D-001 gives that responsibility a precise owner.

### Consequences

- Each Aggregate Root has a single, authoritative persistence path.
- Repositories evolve independently because each owns an independent Aggregate Root.
- Each Aggregate Root certified in Domain Engineering warrants exactly one Repository. The count of Repositories is a domain signal, not an implementation convenience.
- No component outside the owning Repository writes to or restores the Aggregate Root it owns.

### Alternatives Considered

**Shared Repository** — One Repository contract serving multiple Aggregate Roots grouped by domain proximity. Rejected: proximity does not eliminate coupling; it conceals it. Aggregate Roots in a shared Repository cannot be replaced or evolved independently.

**Generic Repository parameterised by Aggregate type** — A single contract accommodating all Aggregate Root types. Rejected: a shared contract must accommodate the persistence requirements of all Aggregate Roots it serves, preventing independent evolution and obscuring business intent per domain concept.

**Direct persistence access** — Application Handlers access the persistence infrastructure without a Repository port. Rejected: this removes the port abstraction, couples the Application Layer to infrastructure technology, and eliminates the independent testability of business use cases.

### Architectural Risks Eliminated

- **Competing persistence authorities**: eliminated by enforcing a single persistence path per Aggregate Root.
- **Invariant corruption on restoration**: eliminated by guaranteeing that only the owning Repository restores Aggregate state.
- **Cross-Aggregate coupling through shared contracts**: eliminated by the one-to-one ownership rule.

### Cross-document Traceability

- SA-001 SA-P-003 — Single Source of Truth: each business concept has one owner; the Repository is the single owner of its Aggregate Root's persistence.
- SA-003 §5 — Repository building block defined as an Application-layer port with an Infrastructure-layer implementation.
- SA-005 §8 — Repository Port interface defined in the Application layer; implementation in the Infrastructure layer.

---

## D-002 — Aggregate Persistence

### Context

A Repository mediates between the Domain Model and the persistence infrastructure. Its position at the boundary between Application and Infrastructure makes it a candidate for accumulated responsibility: a component that persists Aggregate state might also be asked to publish Domain Events or Integration Events as a consequence of that persistence.

### Problem

Persistence and event publication are independent responsibilities with independent failure modes, independent retry requirements, and independent recovery needs. If both responsibilities accumulate in the Repository, a persistence failure and a publication failure become indistinguishable. The possibility of partial execution — state persisted, event not published — becomes structurally available.

### Decision

Repositories SHALL persist only the business state of their Aggregate Roots.

Repositories SHALL NOT publish Domain Events.

Repositories SHALL NOT publish Integration Events.

Repositories SHALL NOT perform messaging responsibilities.

### Rationale

SA-P-0010 requires that the Repository's single responsibility be persistence of Aggregate state. Every responsibility beyond that violates the principle.

The Domain Event publication lifecycle is fully specified in SA-005 §13: events are collected by the Application Runtime after a successful transaction commit and published to the Internal Event Bus. Publishing inside the Repository would make pre-commit publication structurally possible, violating SA-005 D-008.

Integration Event publication is the exclusive responsibility of the Platform Integration Layer (SA-006 §6.3, I-004). No other component — including the Repository — holds this responsibility.

### Consequences

- Repository implementations focus exclusively on translating Aggregate state to and from storage.
- Domain Event publication and Integration Event publication remain at their correct architectural owners.
- Persistence failures and publication failures are independently classifiable and independently recoverable.
- The retry and failure handling models for persistence and messaging cannot contaminate each other.

### Alternatives Considered

**Repository publishes Domain Events as a side effect of persist** — The persist operation triggers event publication before returning. Rejected: this makes pre-commit publication structurally possible, violates SA-005 D-008, and creates an inseparable coupling between persistence outcome and publication outcome.

**Repository exposes lifecycle hooks** — Callers attach publication callbacks to Repository lifecycle events. Rejected: this is the same coupling expressed indirectly. Publication still executes within or immediately following the persist call, inside the persistence boundary.

### Architectural Risks Eliminated

- **Pre-commit event publication**: eliminated by removing publication authority from the Repository.
- **Persistence-messaging coupling**: eliminated by assigning each responsibility to its correct architectural owner.
- **Partial execution** — state persisted, event not published, or event published before commit: eliminated because publication is coordinated by the Application Runtime after commit, not within the Repository.

### Cross-document Traceability

- SA-005 D-008 — Domain Events SHALL remain pending until the transaction commits; publication is performed by the Application Runtime.
- SA-005 §13 — Domain Event lifecycle: recording in Aggregate, collection by Application Runtime, publication after commit.
- SA-006 §6.3 — Platform Integration Layer is the sole publisher of Integration Events.
- SA-006 I-003 — Aggregates SHALL NEVER create Integration Events.
- SA-006 I-004 — Application Handlers SHALL NEVER create Integration Events.

---

## D-003 — Transaction Boundary

### Context

An Application Use Case may require coordinating multiple Aggregates, multiple Repositories, and multiple persistence operations within a single business intent. All of these operations must either succeed together or fail together to preserve business consistency.

The component that owns the transaction boundary determines which component has the authority to declare that a business use case has fully succeeded or failed.

### Problem

If transaction boundaries are owned by individual Repositories, no single component has visibility into the complete set of operations constituting the use case, making atomic coordination of multiple Repositories impossible. If transaction ownership belongs to the Domain Model, persistence concerns enter the domain layer, violating SA-001 SA-P-005.

### Decision

Each Application Use Case SHALL execute within exactly one transaction boundary.

Transaction ownership SHALL belong to the Application Layer.

Repositories SHALL participate in the active transaction but SHALL NOT manage transactions.

### Rationale

A transaction represents the scope of a business use case, not the scope of a single persistence operation. Only the Application Layer has visibility into the complete set of operations that constitute a use case, and therefore only the Application Layer can declare when that use case has fully succeeded.

This decision extends SA-005 D-003, which assigned transaction ownership to Command Handlers. ADR-SA-007 D-003 expresses the persistence-layer consequence: the transaction the Command Handler opens and closes is the transaction in which all Repository operations execute.

Repositories that manage their own transactions fragment the use case into independent sub-transactions, making atomic coordination across multiple Repositories impossible.

### Consequences

- Transaction scope is visible at the Application Layer and aligned with business use case scope.
- No partial commit of a use case is architecturally possible.
- Repository implementations receive the active transaction as a runtime context; they do not open, commit, or roll back independently.
- Domain Event publication occurs after the transaction commits, consistent with SA-005 §13.4.

### Alternatives Considered

**Repository-managed transactions** — Each Repository manages a transaction per persist or retrieve call. Rejected: this makes it impossible to atomically coordinate multiple Repository operations within a single use case, producing partial commits when multiple Aggregates must be updated together.

**Domain-managed transactions** — The Domain Model declares transactional scope as part of business invariants. Rejected: this introduces a dependency from the Domain layer to an infrastructure concept, violating SA-001 SA-P-005 (Dependency Direction) and SA-005 D-003.

**Infrastructure-autonomous transactions** — The Infrastructure layer opens and closes transactions without direction from the Application Layer. Rejected: this removes transaction visibility from the Application Layer and makes it impossible to guarantee atomic use case execution.

### Architectural Risks Eliminated

- **Partial use case commits**: eliminated by anchoring the transaction boundary at the Application Layer, which sees the complete use case scope.
- **Transaction leakage across use cases**: eliminated by requiring exactly one transaction boundary per use case.
- **Domain-infrastructure coupling**: eliminated by keeping the Domain Model transaction-agnostic.

### Cross-document Traceability

- SA-005 D-003 — Transaction ownership in the Application Layer; Aggregates remain transaction-agnostic.
- SA-001 SA-P-005 — Dependency direction: the Domain layer never depends on Infrastructure or frameworks.
- SA-003 §4 — Infrastructure layer implements persistence adapters under Application Layer direction.

---

## D-004 — Atomic Persistence Coordination

### Context

When a use case involves multiple persistence operations, those operations must commit atomically. If any individual operation fails, all operations within the same use case transaction must be reversed.

The mechanism by which multiple persistence operations are coordinated into a single atomic commit is an infrastructure concern. Multiple coordination strategies exist with different performance, scalability, and storage compatibility trade-offs.

### Problem

If the architecture mandates a specific coordination mechanism, it constrains the infrastructure choices available to Platform teams and prevents adoption of persistence technologies whose coordination model differs from the mandated one.

### Decision

The runtime SHALL coordinate all persistence operations participating in the same Application transaction.

The runtime SHALL commit them atomically.

The architecture SHALL NOT mandate a specific coordination mechanism.

### Rationale

The architectural guarantee is atomicity of all persistence within a use case boundary. The mechanism that delivers this guarantee is a runtime implementation choice that belongs to SA-007 and the runtime specification.

Mandating a coordination mechanism would restrict which persistence technologies can participate in the architecture. D-010 requires that the architecture support multiple persistence technologies. A mandated coordination mechanism and a multi-storage requirement are structurally incompatible constraints.

### Consequences

- Platform teams select the persistence coordination mechanism appropriate to their infrastructure stack.
- The Application Layer and Domain Model are unaware of the coordination mechanism in use.
- SA-007 SHALL specify the coordination mechanism normalised for the MedLink runtime.
- Alternative coordination strategies remain available for future Platforms with different persistence requirements.

### Alternatives Considered

**Shared change-tracking registry** — All Repository implementations register pending changes with a shared tracking component that flushes them atomically. Rejected as a normative requirement: this is a valid runtime strategy, but mandating it in the architecture precludes persistence technologies that deliver atomic coordination through other means.

**Distributed two-phase commit** — A coordination protocol spanning multiple storage systems. Rejected as a normative requirement: two-phase commit introduces availability trade-offs and requires infrastructure support that may not be present across all future MedLink Platforms.

**Long-running compensating sequence** — Each operation is reversible; failure triggers compensating actions. Rejected as the default coordination mechanism: compensating sequences address distributed failure recovery, not atomic coordination of operations within a single Application boundary. Appropriate in future cross-Platform scenarios; not the default for single-Platform use cases.

### Architectural Risks Eliminated

- **Partial persistence within a use case**: eliminated by requiring the runtime to commit all participating operations atomically.
- **Coordination mechanism lock-in**: eliminated by not mandating a specific mechanism.
- **Inconsistent Aggregate state after partial commit**: eliminated by the atomicity guarantee.

### Cross-document Traceability

- SA-005 D-003 — Transaction ownership in the Application Layer; D-004 extends this to coordination across multiple persistence operations within that transaction.
- D-003 (this ADR) — Atomic coordination executes within the transaction boundary owned by the Application Layer.
- D-010 (this ADR) — Multi-storage requirement is the motivation for not mandating a specific coordination mechanism.

---

## D-005 — Aggregate State Consistency

### Context

Multiple actors or processes may attempt to update the same Aggregate Root concurrently. The domain invariants protected by the Aggregate depend on the assumption that each state transition is applied to a consistent starting state. If two concurrent writers both read the same initial state and both write a new state, one write silently overwrites the other, producing a state that neither writer intended and that may violate domain invariants.

### Problem

Concurrent updates to the same Aggregate Root produce a race condition. Without a consistency guarantee, the architecture cannot claim that Aggregate invariants are protected across concurrent execution.

### Decision

The runtime SHALL preserve Aggregate consistency whenever concurrent updates occur.

The architecture SHALL NOT mandate a specific concurrency-control mechanism.

### Rationale

The architectural guarantee is consistency of Aggregate state under concurrent access. The mechanism that delivers this guarantee — whether through detection and rejection of stale writes, exclusive reservation before returning an Aggregate to a caller, or an equivalent strategy — is a runtime implementation choice that belongs to SA-007.

Different Aggregates have different contention profiles. A high-contention Aggregate may warrant a different strategy than a low-contention one. Mandating a single concurrency mechanism at the architecture level prevents runtime teams from optimising for the characteristics of each Aggregate.

The Domain Model is not the correct location for concurrency decisions. Concurrency control is an infrastructure concern coordinated through the owning Repository.

### Consequences

- No concurrent update to the same Aggregate Root can produce a silent state corruption.
- Runtime teams select the concurrency control strategy appropriate to each Aggregate's contention characteristics.
- SA-007 SHALL specify the concurrency control mechanism normalised for the MedLink runtime.
- The Domain Model carries no concurrency control logic.

### Alternatives Considered

**Attaching a generation counter to each Aggregate Root and verifying it at write time** — The Runtime checks a version indicator before committing; a mismatching indicator causes the write to be rejected. Rejected as a normative requirement: this is a valid and common runtime strategy, but mandating it prevents adoption of strategies appropriate for high-contention Aggregates where rejection and retry carry unacceptable cost.

**Exclusive reservation before returning an Aggregate to a caller** — The Repository acquires an exclusive hold on the Aggregate Root before returning it to the Application Layer, preventing concurrent retrieval. Rejected as a normative requirement: exclusive reservation introduces serialisation costs that are unnecessary for low-contention Aggregates.

**No concurrency control** — Accept last-write-wins semantics. Rejected unconditionally: an Aggregate whose state can be silently overwritten does not protect its invariants. This violates the foundational guarantee of Aggregate design.

### Architectural Risks Eliminated

- **Silent state corruption under concurrency**: eliminated by requiring the runtime to detect and resolve concurrent update conflicts.
- **Invariant violation from stale writes**: eliminated by guaranteeing that conflicting concurrent writes cannot both succeed silently.
- **Concurrency mechanism lock-in at architecture level**: eliminated by not mandating a specific mechanism.

### Cross-document Traceability

- SA-003 §2 — Aggregates are the consistency boundary; their internal invariants must be protected across all operations.
- SA-005 D-003 — Transaction ownership in the Application Layer; concurrency control executes within that transaction boundary.
- D-001 (this ADR) — The owning Repository is the sole persistence path; it is therefore the correct location through which concurrency control operates on writes.

---

## D-006 — Persistence Mapping

### Context

Aggregate Roots are domain objects whose structure reflects business concepts, relationships, and invariants expressed in domain vocabulary. Storage representations reflect the requirements of the chosen storage technology: structure, serialisation format, and indexing characteristics. These two representations have different purposes, different lifecycles, and different evolution drivers.

The translation between them is a technical responsibility that must be assigned to a specific architectural location.

### Problem

If mapping responsibility is unassigned, it migrates into the Domain layer — creating persistence coupling — or into the Application layer — creating infrastructure coupling above its correct boundary. If a dedicated mapping component is mandated for every Repository, structural overhead accumulates without architectural benefit.

### Decision

Repository implementations SHALL translate Aggregate state to and from persistence representations.

The architecture SHALL NOT require a dedicated persistence mapping component.

### Rationale

The Repository already occupies the boundary between the Domain Model and the persistence infrastructure. It holds the persistence authority for its Aggregate Root. Placing translation responsibility inside the Repository implementation is the most cohesive assignment: the component that knows both the Aggregate interface and the storage representation performs the translation between them.

Not mandating a dedicated translation component allows Repository implementations to select the most appropriate translation approach for their storage technology. A relational store and a document store require different translation strategies; the architecture does not benefit from prescribing a single form.

### Consequences

- Repository implementations are responsible for both storage access and translation.
- The Domain Model contains no storage annotations, schema hints, or technology-specific constructs.
- Repository implementations MAY delegate translation to internal components within the Infrastructure layer without violating this decision.
- SA-007 MAY recommend a normalised translation approach for the MedLink runtime without elevating it to an architectural requirement.

### Alternatives Considered

**Dedicated translation component separate from the Repository** — A distinct Infrastructure component holds translation logic, decoupled from storage access. Rejected as a normative requirement: this introduces an additional component whose responsibilities are entirely internal to the Infrastructure layer. The architecture gains no benefit from mandating this structure; it is a valid internal design pattern that teams may adopt within the Infrastructure boundary.

**Domain Model carries persistence metadata** — The Aggregate Root carries annotations or attributes describing its storage representation. Rejected: this violates D-009 (Persistence Ignorance) and SA-001 SA-P-005 (Dependency Direction). The Domain layer must not depend on infrastructure or technology-specific constructs.

**Application Layer performs translation** — Application Handlers translate between Aggregate state and storage representation before passing data to the Repository. Rejected: this moves an infrastructure concern above its correct boundary and couples the Application Layer to storage-specific structures.

### Architectural Risks Eliminated

- **Persistence coupling in the Domain Model**: eliminated by assigning translation exclusively to the Repository implementation in the Infrastructure layer.
- **Abstraction layer proliferation**: eliminated by not mandating dedicated translation components.
- **Technology-specific structures in the Application Layer**: eliminated by keeping translation within the Infrastructure boundary.

### Cross-document Traceability

- SA-001 SA-P-005 — Dependency direction: Infrastructure implements Domain contracts; the Domain never depends on Infrastructure.
- SA-003 §7 — Infrastructure layer is the location for persistence adapters.
- D-009 (this ADR) — Persistence ignorance requires that no mapping knowledge appear in the Domain layer; D-006 assigns it to the Infrastructure layer.

---

## D-007 — Read Model Persistence

### Context

CQRS separates the write path — Command, Aggregate, Repository — from the read path — Query, Read Model. The write path serves business consistency. The read path serves information retrieval. Each path has independent performance, scalability, and evolution requirements.

Read Models are maintained by Projections that subscribe to Domain Events (SA-005 §14, SA-006 §12). They carry pre-computed, retrieval-optimised representations of business state.

### Problem

Without a rule separating Aggregate persistence from Read Model persistence, Query Handlers may access Aggregate Repositories to retrieve data. This collapses the CQRS separation and forces the write model to accommodate read requirements — associations, retrieval-oriented data structures — degrading both write performance and domain model clarity.

### Decision

Aggregate Repositories SHALL persist Aggregate state exclusively.

Read Models SHALL be persisted independently.

Query operations SHALL NOT access Aggregate Repositories.

### Rationale

The write model and the read model serve different consumers with different requirements. Aggregate state is structured for business consistency. Read Model state is structured for retrieval efficiency. Persisting both through the same Repository forces a compromise that serves neither well.

Independently persisted Read Models may use persistence technologies optimised for querying, without constraint from Aggregate structure or Aggregate persistence technology.

This decision extends SA-005 D-005 (Query Handlers access Read Models exclusively) and SA-005 D-006 (Projections maintain Read Models) to the persistence layer: independent persistence is the structural expression of independent read and write paths.

### Consequences

- Aggregate Repositories contain no retrieval-oriented operations.
- Read Models may be stored using technologies chosen for retrieval performance, independent of Aggregate persistence technology.
- Projections are the only components that write to Read Model stores (SA-005 I-017, SA-006 §12.6).
- Read Models are disposable: they can be rebuilt by replaying Domain Events at any time (SA-006 §12.5).
- Read Model schemas evolve independently of Aggregate persistence schemas.

### Alternatives Considered

**Aggregate Repository exposes retrieval operations alongside persist** — The Repository provides both Aggregate persistence and structured retrieval results for the read path. Rejected: this collapses the CQRS separation, forces the write model to accommodate read requirements, and violates SA-005 D-005.

**Shared persistence store, separate access paths** — Aggregates and Read Models share a persistence store but are accessed through different mechanisms. Rejected: Aggregate schema changes create implicit risk for Read Model query correctness. Separate persistence stores make this coupling structurally impossible.

**Read Models derived at query time from Aggregate state** — No Read Models are persisted; Queries reconstruct views from Aggregate data on demand. Rejected: this forces the Query path to load and traverse Aggregate structures, negates the performance purpose of CQRS, and violates SA-005 D-005.

### Architectural Risks Eliminated

- **Write model contamination by retrieval requirements**: eliminated by prohibiting Query access to Aggregate Repositories.
- **Read-write path coupling**: eliminated by requiring independent persistence stores.
- **Write path performance degradation from read-optimisation**: eliminated by keeping write and read persistence independent.

### Cross-document Traceability

- SA-005 D-005 — Query Handlers access Read Models exclusively; they do not load Aggregates.
- SA-005 D-006 — Projections maintain Read Models by subscribing to Domain Events.
- SA-005 I-017 — Read Models are read-only; only their owning Projection writes to them.
- SA-005 I-018 — The write path and the read path remain independently evolvable.
- SA-006 §12 — Projection Architecture: independent execution, Read Model rebuilt from Domain Events.
- SA-006 §12.6 — A Read Model update is the only authorised write a Projection performs.

---

## D-008 — Repository Contracts

### Context

A Repository contract is a port (SA-003 §5). Its scope defines the coupling surface between the Application layer and the persistence infrastructure. The operations exposed on that contract determine what consumers may ask of the persistence layer.

If the contract grows to include operations unrelated to Aggregate retrieval and persistence, it ceases to function as a focused port and becomes a general-purpose data access surface.

### Problem

Without a strict scope rule, the Repository contract accumulates retrieval-oriented operations — filtering, searching, aggregating — alongside Aggregate persistence operations. This collapses the CQRS boundary at the contract level, regardless of how it is enforced elsewhere in the architecture.

### Decision

Repository contracts SHALL expose only operations required to retrieve and persist Aggregate Roots.

Read-oriented operations SHALL belong exclusively to the Query Model.

### Rationale

The Repository contract must reflect the single responsibility of the Repository: persisting and retrieving the Aggregate Root it owns. Every operation on the contract must serve that responsibility directly.

Retrieval-oriented operations — those that return filtered collections, search results, or aggregated views — are the responsibility of the Query Model (SA-005 D-005). Adding them to a Repository contract violates SA-P-0010 and weakens the CQRS boundary established by SA-005 and reinforced by D-007.

A focused Repository contract with a small number of operations is a stable, independently evolvable port. Fewer operations mean fewer reasons to change the contract and fewer constraints on the Repository implementation.

### Consequences

- Repository contracts carry a small, focused set of operations: retrieve by identity, retrieve by business key where a business operation requires it, and persist.
- No filtering, searching, counting, projection, or retrieval-oriented operations appear on Repository contracts.
- Application Handlers that require retrieval-oriented data invoke Query Handlers accessing Read Models — not Repositories.
- The query surface of the system is located exclusively in the Query Model, where it can be independently optimised.

### Alternatives Considered

**Repository contract includes retrieval-oriented query operations** — The Repository exposes a full suite of retrieval methods alongside Aggregate persistence operations, providing a single access point for all data needs. Rejected: this collapses the CQRS boundary and transforms the Repository into a general-purpose data access surface, violating SA-P-0010 and D-007.

**Specification-passed retrieval interface on the write Repository** — The Repository exposes a single find operation accepting arbitrary retrieval specifications from callers. Rejected: a specification-accepting interface on the write Repository opens the write persistence store to retrieval-oriented access, violating D-007. Specification-based retrieval is valid as an internal implementation strategy within the Repository for domain-specific Aggregate lookup; it is not valid as a public query interface.

### Architectural Risks Eliminated

- **CQRS boundary collapse at contract level**: eliminated by prohibiting retrieval-oriented operations on Repository contracts.
- **Repository growth into general-purpose data access**: eliminated by restricting the contract scope to Aggregate retrieval and persistence.
- **Application Layer coupling to retrieval infrastructure**: eliminated by routing all retrieval concerns to the Query Model.

### Cross-document Traceability

- SA-003 §5 — Repository as a Port: Application-layer contract, Infrastructure-layer implementation.
- SA-005 §8 — Repository Port exposes only the operations required by its Bounded Context.
- SA-005 D-005 — Query Handlers access Read Models exclusively; they do not access Repository contracts.
- D-007 (this ADR) — Read Models are persisted independently; retrieval operations do not belong to Aggregate Repositories.

---

## D-009 — Persistence Ignorance

### Context

The Domain Model — Aggregates, Value Objects, Domain Services, and Domain Events — contains the business rules of the system. These rules must be expressible, testable, and verifiable independently of any persistence technology.

If the Domain Model carries knowledge of how it is stored, it becomes coupled to the persistence infrastructure. Changing the persistence technology then requires modifying the domain layer.

### Problem

Persistence technologies frequently encourage or require domain objects to carry storage metadata, extend technology-specific base types, or implement technology-defined interfaces. Accepting these requirements embeds infrastructure assumptions into the most stable and most valuable layer of the architecture.

### Decision

The Domain Model SHALL remain persistence ignorant.

Domain Models SHALL NOT depend on persistence technologies, storage representations or persistence mechanisms.

### Rationale

The Domain Model is the most stable layer of the MedLink architecture. It embodies certified domain knowledge. Its lifetime must exceed the lifetime of any persistence technology choice.

Persistence ignorance protects the Domain Model from infrastructure evolution. When a persistence technology is replaced or upgraded, no Domain Model modification is required.

Persistence ignorance also enables complete unit testing of all domain logic without any persistence infrastructure. Domain business rules are verifiable in isolation, reducing test complexity and decoupling test execution from storage availability.

This decision is the direct application of SA-001 SA-P-005 (Dependency Direction) and SA-001 SA-P-006 (Framework Independence) to the persistence layer.

### Consequences

- Domain Aggregates contain only business state, business behaviour, and Domain Event recording.
- No persistence metadata, storage-specific types, or technology-specific base types appear in the Domain layer.
- Repository implementations absorb all persistence-specific knowledge.
- Domain layer tests require no persistence infrastructure.
- Replacing the persistence technology requires changes only in the Infrastructure layer.

### Alternatives Considered

**Domain object persists itself** — Domain objects carry the authority and the logic to persist their own state. Rejected: this directly violates persistence ignorance, SA-001 SA-P-005, and D-001. The domain object becomes coupled to the persistence infrastructure and cannot be tested in isolation.

**Domain objects carry storage metadata** — Aggregates carry technology-specific annotations or attributes describing storage mapping. Rejected: metadata creates a dependency from the Domain layer to the persistence technology. If the technology changes, the Domain layer must change. This is the most common form of persistence coupling in practice.

**Domain objects extend technology-specific base types** — Aggregate Roots extend a persistence technology base class. Rejected: this creates an inheritance dependency on infrastructure, preventing independent testing, independent evolution, and replacement of the persistence technology without domain layer changes.

### Architectural Risks Eliminated

- **Domain-infrastructure coupling**: eliminated by prohibiting persistence knowledge in the Domain layer.
- **Persistence technology lock-in at the domain level**: eliminated; replacing the persistence technology requires no Domain Model changes.
- **Untestable domain logic**: eliminated; domain business rules are verifiable without any persistence infrastructure.

### Cross-document Traceability

- SA-001 SA-P-005 — Dependency direction: the Domain layer never depends on Infrastructure or frameworks.
- SA-001 SA-P-006 — Framework independence: business rules remain independent from frameworks and infrastructure technologies.
- SA-003 §5 — Repository as an Application-layer port with an Infrastructure-layer implementation separates domain contracts from persistence concerns.
- SA-005 D-003 — Aggregates remain transaction-agnostic; D-009 extends this agnosticism to all persistence concerns.

---

## D-010 — Multi-Storage Strategy

### Context

MedLink is a multi-Platform architecture (SA-002). Different Platforms and different Bounded Contexts within a Platform have persistence requirements that differ significantly: strong consistency for Aggregate state, high-throughput for event logs, retrieval efficiency for Read Models, full-text capability for search surfaces.

### Problem

If the Domain Model or the Application layer depends on a specific persistence technology, the architecture prevents adoption of alternative technologies where they better serve business requirements. Every Bounded Context and every future Platform is constrained to the same persistence model regardless of its actual access characteristics.

### Decision

The architecture SHALL support multiple persistence technologies.

Domain and Application SHALL remain independent of persistence technology choices.

### Rationale

Different access patterns warrant different persistence technologies. Aggregate state requires strong consistency and transactional coordination. Read Models require retrieval speed and may tolerate eventual consistency. Full-text surfaces require inverted index structures. Forcing all persistence through a single technology either selects the wrong technology for most access patterns or forces a single technology to serve all of them at unacceptable operational cost.

D-009 (Persistence Ignorance) and D-007 (Read Model Persistence) already create the structural independence that makes multi-storage possible. D-010 declares this independence as an explicit architectural objective.

### Consequences

- Each Bounded Context selects the persistence technology appropriate to its Aggregate and Read Model characteristics.
- The Domain Model and Application layer are never modified when a persistence technology changes within a Bounded Context.
- SA-007 SHALL specify the normalised persistence technologies for the MedLink runtime, preserving the architectural openness established by this decision.
- Future Platforms may adopt persistence technologies not available in the current runtime without requiring architectural changes.

### Alternatives Considered

**Single persistence technology mandated at architecture level** — All Aggregate state and all Read Models use the same technology. Rejected: this imposes the characteristics of one technology on all access patterns, creating performance mismatches and preventing access pattern optimisation.

**Persistence technology declared in the Application layer** — Application Ports declare which storage technology they require. Rejected: storage technology selection is an infrastructure concern. Declaring it above the Infrastructure boundary violates D-009 and SA-001 SA-P-005.

### Architectural Risks Eliminated

- **Single-technology lock-in**: eliminated; each Bounded Context selects the technology appropriate to its access characteristics.
- **Performance mismatches from uniform persistence**: eliminated; read and write stores are selected independently.
- **Domain evolution constrained by persistence technology**: eliminated by maintaining full independence between Domain and Application layers and storage technology.

### Cross-document Traceability

- SA-001 SA-P-006 — Framework independence: technologies remain replaceable.
- SA-001 SA-P-008 — Technology pragmatism: maintainability, architectural consistency, and long-term evolvability.
- SA-003 §4 — Infrastructure layer owns storage implementation; Domain and Application own abstractions.
- D-009 (this ADR) — Persistence ignorance is the prerequisite for multi-storage: a Domain Model independent of storage can be persisted through any storage technology.

---

## D-011 — Schema Evolution

### Context

As the Domain Model evolves, the business state that Aggregates represent changes. New business concepts are added, existing ones are refined, and obsolete ones are removed. These domain changes imply corresponding changes to the persistence representation. Managing those changes without interrupting deployed systems is an operational concern.

### Problem

If schema evolution is treated as a cross-layer concern, it creates coupling between the Domain layer, which defines what changed, and the Infrastructure layer, which must express that change in storage terms. Mandating a specific migration mechanism at the architecture level restricts the infrastructure choices available to Platform teams and creates an architectural dependency on a specific operational toolset.

### Decision

Schema evolution SHALL remain an Infrastructure responsibility.

The architecture SHALL NOT mandate migration mechanisms.

### Rationale

A schema change is the Infrastructure layer's expression of a Domain Model change. The Domain layer defines the change in business terms. The Repository implementation defines the storage consequence. The migration mechanism applies that consequence to the deployed schema.

Each layer knows its responsibility. The Domain layer does not know the storage impact of its changes. The Infrastructure layer does not know the business reason for schema changes. Keeping schema evolution in the Infrastructure layer preserves this separation.

Not mandating a migration mechanism allows Platform teams to select the approach appropriate to their storage technology and operational context.

### Consequences

- Domain Aggregates carry no schema version information and no migration logic.
- Repository implementations absorb all consequences of schema changes for their Aggregate Root.
- Infrastructure teams own the schema evolution lifecycle: design, execution, and verification.
- SA-007 MAY specify normalised schema evolution practices for the MedLink runtime without elevating them to architectural requirements.

### Alternatives Considered

**Domain-carried schema version** — The Aggregate Root carries a schema version that drives migration logic in the Repository implementation. Rejected: this introduces persistence-layer concerns into the Domain layer, coupling business model evolution to storage schema management and violating D-009.

**Architecture-mandated migration toolset** — The architecture requires all Repository implementations to manage schema changes through a specific migration toolset. Rejected: this embeds a tool dependency into an architectural rule, violating SA-001 SA-P-006 (Framework Independence) and preventing adoption of storage technologies whose schema evolution model differs from the mandated toolset.

**Immutable schema with generic extensibility structures** — The storage schema never changes; new fields are accommodated through untyped extensibility columns or equivalent. Rejected: generic extensibility structures eliminate storage-level type safety and retrieval efficiency, and push type management back into application code.

### Architectural Risks Eliminated

- **Migration logic in the Domain layer**: eliminated by restricting schema evolution to the Infrastructure layer.
- **Migration toolset lock-in at architecture level**: eliminated by not mandating a specific mechanism.
- **Cross-layer coupling from schema version management**: eliminated by keeping all schema concerns within the Infrastructure boundary.

### Cross-document Traceability

- SA-001 SA-P-005 — Dependency direction: Infrastructure implements Domain contracts; schema evolution is an Infrastructure responsibility.
- SA-001 SA-P-006 — Framework independence: the architecture does not depend on migration toolsets.
- SA-003 §4 — Infrastructure layer: responsible for implementing and maintaining all persistence adapters.
- D-009 (this ADR) — Persistence ignorance: if the Domain Model carries no persistence knowledge, it carries no schema knowledge and no migration logic.

---

## Outcome

The decisions recorded in ADR-SA-007 constitute the normative architectural basis for SA-007 — Persistence Architecture.

SA-007 SHALL formalise these decisions as normative rules, invariants, and structural guidance without introducing additional architectural concepts or altering the approved responsibilities.

| Decision | SA-007 SHALL formalise |
|---|---|
| D-001 — Repository Ownership | One Repository per Aggregate Root; exclusive persistence authority; structural rules and naming conventions |
| D-002 — Aggregate Persistence | Repository scope limited to business state; prohibited messaging responsibilities; failure independence |
| D-003 — Transaction Boundary | Application Layer transaction ownership; Repository participation model; post-commit action sequencing |
| D-004 — Atomic Persistence Coordination | Atomicity guarantee; coordination mechanism deferred to runtime specification (OD-001) |
| D-005 — Aggregate State Consistency | Concurrency consistency guarantee; control mechanism deferred to runtime specification (OD-002) |
| D-006 — Persistence Mapping | Mapping responsibility assigned to Repository implementation; mapping approach deferred to runtime specification (OD-003) |
| D-007 — Read Model Persistence | Aggregate and Read Model stores are independent; Projection as sole Read Model writer; Query path isolation |
| D-008 — Repository Contracts | Contract scope limited to retrieve and persist; read-oriented operations prohibited; contract location |
| D-009 — Persistence Ignorance | Domain layer independence from persistence; prohibited dependencies; testability and evolution consequences |
| D-010 — Multi-Storage Strategy | Multiple technology support; Domain and Application independence; runtime normalisation |
| D-011 — Schema Evolution | Infrastructure ownership of schema changes; migration mechanism deferred to runtime specification (OD-004) |
