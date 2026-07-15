# ADR-SA-005 — Architectural Decision Register

**Document ID**: ADR-SA-005
**Title**: Architectural Decisions — Application & CQRS Architecture
**Status**: Approved

---

## Purpose

This document records the architectural decisions approved during the SA-005 Architecture Workshop.

It is not an architecture specification.

It captures the reasoning behind the architectural model that SHALL be formalized in SA-005.

No implementation technology is defined in this document.

---

## D-001 — One Handler = One Use Case

### Decision

Each application Use Case SHALL be implemented by exactly one Command Handler or one Query Handler.

Handlers SHALL implement one and only one business capability.

### Rationale

A Handler represents an application use case.

Mapping one Handler to one Use Case guarantees:

- Single Responsibility
- clear ownership
- easy discoverability
- independent evolution
- isolated testing

### Problem solved

Prevents the creation of large "Application Services" containing unrelated business operations.

---

## D-002 — Aggregate Orchestration

### Decision

A Command Handler MAY orchestrate multiple Aggregates belonging to the same Bounded Context.

A Handler SHALL NEVER directly access Aggregates or Repositories belonging to another Bounded Context.

Cross-BC collaboration SHALL occur exclusively through:

- Application Facades (synchronous)
- Domain Events (asynchronous)

### Rationale

Aggregates protect business invariants.

Handlers orchestrate business scenarios.

Bounded Context autonomy must never be violated.

### Problem solved

Prevents cross-context coupling and protects bounded context independence.

---

## D-003 — Transaction Ownership

### Decision

Transaction boundaries belong to the Application Layer.

Command Handlers define:

- transaction start
- commit
- rollback

Aggregates SHALL remain transaction-agnostic.

### Rationale

A transaction represents a business use case, not an Aggregate.

Only the Handler knows when the complete business scenario has succeeded.

### Problem solved

Prevents persistence concerns from leaking into the Domain Model.

---

## D-004 — Application Facade

### Decision

Each Bounded Context exposes exactly one Application Facade.

The Facade:

- defines the synchronous public contract
- delegates execution to Handlers
- contains no business rules
- contains no orchestration logic
- contains no persistence logic

Handlers remain private implementation details.

### Rationale

Consumers depend on a stable contract rather than internal implementation.

### Problem solved

Allows internal evolution without breaking dependent Bounded Contexts.

---

## D-005 — Query Model

### Decision

Query Handlers SHALL access Read Models exclusively.

They SHALL NOT:

- load Aggregates
- invoke Domain Services
- execute business rules

### Rationale

Reads optimize information retrieval.

Writes optimize business consistency.

The two concerns evolve independently.

### Problem solved

Avoids loading complex Domain Models for read-only operations.

Improves performance and reduces cognitive complexity.

---

## D-006 — Projection Model

### Decision

Read Models SHALL be maintained by Projections.

A Projection subscribes to Domain Events and updates one or more Read Models.

Projections SHALL NOT:

- execute business rules
- modify Aggregates
- invoke Commands

### Rationale

Read Models are derived views of business facts.

The Domain remains responsible only for business decisions.

### Problem solved

Allows new dashboards, reports and widgets to be introduced without modifying business logic.

---

## D-007 — Application Contracts

### Decision

Commands, Queries and Results constitute the Application Contracts.

They belong to the Application Layer.

They SHALL contain data only.

They SHALL contain no business logic.

### Rationale

Application Contracts define interactions independently from Presentation technologies.

### Problem solved

Decouples REST, CLI, Batch, GraphQL or future entry points from the Application Model.

---

## D-008 — Domain Event Publication

### Decision

Aggregates record Domain Events.

Domain Events SHALL remain pending until the transaction commits successfully.

Publication SHALL occur only after a successful commit.

Publication is performed by the Application Runtime.

Aggregates SHALL NEVER publish events directly.

### Rationale

A Domain Event represents a completed business fact.

Publishing before commit could expose facts that never became true.

### Problem solved

Prevents inconsistent notifications, projections and integrations caused by transaction rollback.

---

## D-009 — Application Results

### Decision

Command Handlers SHALL return:

- an Application Result
- or void

They SHALL NEVER return:

- Aggregates
- Domain Models
- Read Models
- Infrastructure objects

Application Results SHALL contain only the information immediately required after successful completion of the Use Case.

### Rationale

Application Results acknowledge execution.

Read Models provide visualization.

The two responsibilities remain separated.

### Problem solved

Prevents Application Results from evolving into View Models while preserving CQRS separation.

---

## Foundational Principle

### Single Architectural Responsibility

Every architectural component SHALL own one and only one architectural responsibility.

Responsibilities SHALL NOT overlap.

If two components own the same responsibility, the architecture SHALL be reconsidered.

Technology SHALL NEVER determine architectural responsibility.

---

## Outcome

The decisions recorded in ADR-SA-005 constitute the normative architectural basis for SA-005 — Application & CQRS Architecture.

SA-005 SHALL formalize these decisions without introducing additional architectural concepts or altering the approved responsibilities.
