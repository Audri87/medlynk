# ADR-SA-008 — Model Existence Principle

**Document ID**: ADR-SA-008
**Title**: Model Existence Principle — When a Class Is Justified
**Status**: Approved

---

## Purpose

This document establishes the foundational rule governing the creation of new classes —
DTO, View, Row, Entity, Mapper, Resource, or any intermediate representation — across
all MedLink platforms.

It is not a list of patterns to apply mechanically.

It is a **decision criterion** that must be applied consciously before any new model class
is introduced in a Pull Request.

---

## Context

MedLink is built on DDD, Hexagonal Architecture, and CQRS. These patterns, applied
naïvely, produce layered architectures where each layer mirrors the one below it —
identical structure, different class name, no distinct responsibility.

This is **model proliferation**: the accumulation of classes whose sole justification is
"convention says so."

Model proliferation has a concrete cost:
- Adding a single field requires modifying 4 to 6 files.
- Each additional class is a maintenance surface with no architectural return.
- Teams stop questioning whether a class should exist and start cargo-culting the structure.

This document exists to prevent that outcome.

---

## Problem

In a CQRS + Hexagonal stack, the following intermediate representations appear naturally:

| Name | Role | Layer |
|---|---|---|
| Domain Event | Immutable fact emitted by an Aggregate | Domain |
| Projection Row | ORM Entity or intermediate for read persistence | Infrastructure |
| View DTO | Immutable data shape returned by a Query Handler | Application |
| API Resource | HTTP presentation contract | Infrastructure / Presentation |

The question is not whether these names exist in textbooks.
The question is: **does each class earn its existence in this specific codebase?**

A class that is structurally identical to another, carries no distinct behaviour, and
creates no boundary enforcement is a liability, not an asset.

---

## Core Principle

> **A class justifies its existence if and only if removing it would force one of its
> consumers to depend on something it should not know.**

This is the **Need-to-Know criterion**.

It is derived from the Dependency Inversion Principle and the Hexagonal Architecture
contract. It is more operational than "single responsibility" because it ties the
justification directly to a concrete dependency violation — not to an abstract notion
of responsibility.

**Corollary:** when a merge does not create a forbidden dependency and does not erase a
distinct behaviour, the merge is mandatory.

Leaving duplicated structure in place is not "being safe". It is introducing unjustified
complexity.

---

## Decision D-001 — The Existence Test

Before introducing any new model class, the author must answer the following question:

> *If I removed this class and inlined its content into its consumer, would a layer
> boundary defined in deptrac be violated?*

If **yes** — the class is justified. Create it.

If **no** — the class is not justified. Do not create it.

This test applies to every model class without exception: DTO, Row, Mapper, Resource,
Assembler, View, Adapter, Wrapper.

---

## Decision D-002 — Domain Events Are Always Justified

A Domain Event is always a distinct class.

It carries an immutable fact from the Domain to the Application/Infrastructure boundary.
Removing it would collapse the Write Side and the Read Side into a single execution path —
eliminating CQRS.

Domain Events are never merged with DTOs, Projections, or API Resources.

---

## Decision D-003 — View DTOs Are Always Justified

A View DTO is the Application contract returned by a Query Handler.

Removing it would force the Query Handler to return either:
- a raw `array` (loss of type safety, no Application contract), or
- an Infrastructure type (violation of Hexagonal Architecture — Application importing Infrastructure).

View DTOs are always distinct classes, living in `Application/ReadModel/`.

They are **immutable**. They carry no behaviour. They are not Doctrine entities.

---

## Decision D-004 — Projection Rows Do Not Exist

A Projection Row is an intermediate class that maps a database row to an in-memory object,
used as input to the View DTO mapping.

**MedLink does not use Projection Row classes.**

Rationale: Projection Rows only exist as a consequence of using Doctrine ORM for reads.
MedLink uses DBAL for all Projection writes and reads.

The mapping is: `array (DBAL result) → View DTO (Application contract)`.

This mapping is performed directly inside the ReadModel adapter (Infrastructure).
No intermediate class is needed. The `array` carries no Application dependency.

```php
// Justified — no Projection Row class
$row = $this->connection->fetchAssociative($sql, $params);

return new PatientTimelineEntry(
    clinicalContributionId: $row['clinical_contribution_id'],
    clinicalText: $row['clinical_text'],
    status: ContributionStatus::from($row['status']),
    occurredAt: new \DateTimeImmutable($row['occurred_at']),
);
```

The ReadModel adapter owns the mapping. The mapping is local, explicit, and testable.

---

## Decision D-005 — API Resources Are Conditionally Justified

An API Resource is a distinct class only if it carries HTTP-specific concerns that must
not exist in the Application layer:

- `#[ApiResource]` annotation (API Platform Infrastructure dependency)
- Pagination envelope structure
- HTTP-level security filters
- Fields computed from HTTP context (e.g., `_links`, `_embedded`)

If the API Resource has exactly the same structure as the View DTO and adds no
HTTP-specific concern, it must not exist as a separate class.

**Rule:** merge the API Resource into the View DTO, or promote the View DTO to carry
the `#[ApiResource]` annotation, only if the annotation does not introduce an
Application → Infrastructure dependency violation.

If it does — keep them separate. If it does not — merge.

---

## Decision D-006 — Mappers Are Conditionally Justified

A Mapper class (e.g., `ClinicalContributionMapper`) is justified when:

- The mapping logic is complex enough to warrant isolation for testability.
- Multiple components need the same mapping logic.
- The mapping performs type coercion or invariant enforcement that must be tested
  independently.

A Mapper is **not** justified when:

- The mapping is three or fewer field assignments.
- The mapping is used in exactly one place and is trivial.
- The Mapper is introduced by convention ("we always have Mappers") rather than necessity.

In those cases, inline the mapping where it is used.

---

## Concrete Examples

### Models That Are Justified

| Class | Reason |
|---|---|
| `ClinicalContributionCreated` | Domain Event — removing it collapses Write/Read separation |
| `PatientTimelineEntry` | View DTO — removing it forces QueryHandler to return `array` or Infrastructure type |
| `ClinicalContributionDetailView` | View DTO — same reasoning |
| `ClinicalContributionMapper` | Justified if Aggregate hydration from DBAL requires complex type coercion and tests |
| `DomainEventCollector` | Implements two Ports with distinct responsibilities — cannot be inlined |

### Models That Are Not Justified

| Class | Reason | Resolution |
|---|---|---|
| `PatientTimelineRow` | Mirrors `PatientTimelineEntry` exactly — exists only because "ORM needs a class" | Remove. Map DBAL `array` → DTO directly |
| `ClinicalContributionDetailRow` | Same — structurally identical to `ClinicalContributionDetailView` | Remove |
| `PatientTimelineMapper` | Three field assignments used in one location | Inline in ReadModel adapter |
| `WorkspaceViewAssembler` | Wraps `WorkspaceAssembler` with no additional logic | Remove — use `WorkspaceAssembler` directly |

---

## Quick Reference — Decision Tree

```
Should I create a new class?
│
├── Does removing it force a consumer to import a forbidden layer?
│   ├── YES → Create the class. Document why in the PR description.
│   └── NO  → Continue.
│
├── Does it carry behaviour distinct from every existing class?
│   ├── YES → Create the class. Document the distinct behaviour.
│   └── NO  → Continue.
│
├── Is it required by an external framework contract (API Platform, Doctrine)?
│   ├── YES → Create the class in Infrastructure only.
│   └── NO  → Do not create the class.
│
└── Is it introduced by convention, habit, or "best practice"?
    └── ALWAYS → Reject. Apply the Existence Test instead.
```

---

## Consequences

### Positive

- The number of classes in the codebase reflects actual architectural need.
- Adding a field costs fewer modifications — no Projection Row to update.
- Every class has a documented, testable reason to exist.
- Code review conversations shift from "is this the right pattern?" to "does this
  class pass the Existence Test?"
- New contributors can understand the model inventory without deciphering layers of
  identical structures.

### Negative

- The discipline must be applied continuously. Without enforcement, drift occurs.
- Some engineers will feel that "fewer classes = less architecture". This document
  must be referenced explicitly when that objection arises.
- When a class is merged prematurely and must later be split, the refactoring cost
  is real. The Existence Test reduces this risk but does not eliminate it.

---

## Impact on Future Pull Requests

Every PR that introduces a new model class must include in its description:

> **Model Existence Justification:** *[class name]* is introduced because removing it
> would cause *[consumer]* to depend on *[forbidden layer]*.

If the justification cannot be stated in one sentence, the class should not be created.

Reviewers are expected to challenge any new class that lacks this justification.

This rule applies retroactively: if an existing class fails the Existence Test during
a review, it must be removed in that PR or a dedicated cleanup PR must be created.

---

## Enforcement

### deptrac

Layer boundaries defined in `deptrac.yaml` are the mechanical enforcement of the
Existence Test. A class that passes the Existence Test will always be placeable in a
layer without creating a deptrac violation.

If a proposed class cannot be placed in any layer without creating a violation — this
is a signal that the class design is wrong, not that deptrac is wrong.

### Code Review Checklist

For every new model class in a PR:

- [ ] Does it pass the Existence Test?
- [ ] Is the justification stated in the PR description?
- [ ] Is it placed in the correct layer (deptrac compliant)?
- [ ] If it is a View DTO — is it immutable? Does it carry zero behaviour?
- [ ] If it is an Infrastructure type — does it stay within Infrastructure?
- [ ] Is there an existing class it could be merged into without creating a violation?

---

## Relation to Other ADRs

| ADR | Relation |
|---|---|
| ADR-0003 — Hexagonal Architecture | Defines the layer boundaries that the Existence Test enforces |
| ADR-0004 — CQRS | Establishes Write/Read separation — root cause of model proliferation risk |
| ADR-SA-005 — Application & CQRS Architecture | Prescribes Command/Query/Event structure |
| ADR-SA-007 — Persistence Architecture | Establishes DBAL for writes, DBAL for reads — eliminates Projection Rows |

---

## Decision History

| Date | Decision |
|---|---|
| 2026-07-24 | ADR approved — replaces all prior informal conventions on model creation |
