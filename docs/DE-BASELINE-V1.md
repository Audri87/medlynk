# Domain Engineering Baseline V1

**Statut** : Accepted with documented Hotspots
**Date** : 2026-07-13
**Sessions** : ES-001 — ES-008

---

## Validation

The Domain Engineering Baseline has successfully passed:

* Event Storming — ES-001 through ES-008
* Internal review
* Red Team review (behavioural challenge)
* Core Domain Behaviour Review (cross-concept consistency)

No behavioural contradiction requiring a redesign of the Core Domain has been identified.

---

## Frozen Decisions

### ES-001 — Domain Events

**Status** : Frozen

```
Clinical Activity Started
    ↓
Clinical Observation Recorded
    ↓
Clinical Draft Updated (0..n)
    ↓
Clinical Contribution Validated
    ↓
Clinical Contribution Published
    ↓
Clinical Activity Closed
```

All events describe observable business facts.

Clinical reasoning is excluded by design (DE-P-001, DE-P-002).

---

### ES-002 — Commands

**Status** : Frozen

```
Start Clinical Activity
Record Clinical Observation
Update Clinical Draft
Validate Clinical Contribution
Publish Clinical Contribution
Close Clinical Activity
```

Commands represent explicit Practitioner intentions.

No command models internal clinical reasoning.

---

### ES-003 — Policies

**Status** : Frozen

**Active policies:**

* P-002 — When visibility rules allow → Publish Clinical Contribution
* P-004 — When Clinical Contribution Published → Update Care Record
* P-005 — When Clinical Contribution Published → Trigger Clinical Continuity if required
* P-006 — When Clinical Contribution Validated → Archive Clinical Draft

**Removed:**

* P-001 — Removed. "Create immutable Contribution" is the semantic definition of Validated, not a separate Policy.
* P-003 — Removed. Automatic Activity closure violates Human Judgment First. Activity closure remains an explicit Practitioner Command.

---

### ES-004 — Clinical Activity

**Status** : Accepted Aggregate Root

**Responsibilities**

* Governs the episode of clinical work
* Owns the Clinical Draft
* Produces Clinical Contributions
* Defines Clinical Responsibility during the episode

**Invariants**

* Exactly one responsible Practitioner
* Zero or more Clinical Contributions
* Clinical Draft never exists outside a Clinical Activity
* Clinical Activity closure is an explicit Practitioner act

---

### ES-005 — Clinical Handover

**Status** : Provisional Aggregate

**Responsibilities**

* Transfers Clinical Responsibility from one Practitioner to another

**Invariants**

* Each Handover instance is initiated by exactly one request act
* Accepted at most once
* Clinical Responsibility remains with the requesting Practitioner until acceptance

**Promotion conditions not yet satisfied:**

* G1 — Visibility and authorization rules unresolved
* H-A-006 — Contribution consumption model unresolved
* Refused and Unanswered states not yet modelled

Clinical Handover becomes a confirmed Aggregate Root when these conditions are resolved.

---

### ES-006 — Clinical Referral

**Status** : Boundary Frozen — Not an Aggregate

A Clinical Referral involves two independent Clinical Activities:

* Activity A — the referring Practitioner retains Clinical Responsibility
* Activity B — the receiving Practitioner performs the requested act

No independent invariants were identified that cannot be protected by the two existing Clinical Activities.

The concept is defined in UL-001 and distinguishes referral from handover at the Domain language level.

The behavioural link between Activity A and Activity B remains an open Hotspot (ES-006).

---

### ES-007 — Hospital Care Transition

**Status** : Epic — Validated baseline, Hotspots identified

Behavioural validations:

* Clinical Handover covers hospital shift changes
* Clinical Referral boundary holds for inter-service orders
* Clinical Continuity applies across inpatient episodes

Hospital-specific Hotspots identified:

* Interrupted Clinical Activity — no Domain representation for pause vs. closure
* Addendum after Clinical Activity Closed — not modelled
* Verbal transmission as continuity mechanism — outside Domain by design or by unresolved scope decision

---

### ES-008 — Clinical Contribution

**Status** : Completed

**Classification** : Domain Record

Clinical Contribution is not an Aggregate Root in the Evans sense:

* No mutable state after validation
* No Commands to receive after creation
* No child objects requiring coordination

Clinical Contribution is not an Entity inside Clinical Activity:

* Referenced directly by Care Record, future Clinical Activities, and Clinical Handover
* Must survive beyond the lifecycle of its producing Clinical Activity

**Accepted classification**: independently persisted Domain Record with its own identity.

**Invariants confirmed:**

* Immutable after validation
* Produced by exactly one Clinical Activity
* Never deleted
* May be referenced indefinitely

---

## Aggregate Map

| Concept | Classification | Status |
|---|---|---|
| Clinical Activity | Aggregate Root | Accepted |
| Clinical Handover | Provisional Aggregate Root | Pending |
| Clinical Referral | Not an Aggregate | Frozen |
| Clinical Contribution | Domain Record | Accepted |
| Clinical Draft | Internal state of Clinical Activity | Accepted |
| Care Record | Read Model | Accepted (ADR-0010) |

---

## Behavioural Validations

The following properties were verified across all scenarios and the Core Domain Behaviour Review.

* No circular lifecycle dependencies between concepts
* All Aggregate interactions flow through Events and Policies — no direct cross-Aggregate mutation
* Clinical Knowledge grows by addition of immutable Contributions — immutability preserved
* Clinical Responsibility always has exactly one holder
* Clinical Contribution and Clinical Handover cannot be removed without losing protected behaviour
* Clinical Referral is behaviourally expressible through two Clinical Activities without a dedicated Aggregate

---

## Open Hotspots

| ID | Question | Blocking |
|---|---|---|
| H-ES-001 | Draft granularity — Domain Event or internal state | Implementation |
| H-ES-002 | Imported clinical documents — Clinical Contribution or distinct concept | Care Record definition |
| H-ES-003 | Clinical Observation vs Clinical Draft — same object or distinct | Clinical Activity internals |
| H-ES-004 | Minimum invariant for Clinical Activity existence | Clinical Activity |
| H-A-006 | Can one Contribution be input to multiple future Activities | Clinical Contribution model |
| G1 | Visibility and authorization rules — who can read what | Clinical Handover promotion, implementation |
| H-CC-001 | Clinical Continuity terrain validation — 3 professions, 5 required | Clinical Continuity Domain status |
| ES-006 | Behavioural link between referring and receiving Clinical Activities | Referral model |
| H-INT-001 | Interrupted Clinical Activity — pause vs. closure distinction | ES-008 extension |
| H-ADD-001 | Addendum after Clinical Activity Closed | Activity lifecycle |
| H-VRB-001 | Verbal transmission as continuity mechanism — in or out of Domain | Clinical Continuity scope |

---

## Governance

The following decisions are frozen.

They may be reopened only if:

* a future Event Storming reveals a behavioural contradiction;
* repeated field observations invalidate an accepted invariant;
* an internal inconsistency is demonstrated.

New features, implementation preferences, or UI requirements are not sufficient reasons to reopen frozen decisions.

Every new term must be defined in UL-001 before appearing in any ADR, Event Storming, Policy, or Aggregate definition.

---

## Principles

The following Domain Engineering Principles govern this baseline.

| Principle | Reference |
|---|---|
| Events describe observable business facts | DE-P-001 |
| Clinical reasoning belongs to the Practitioner | DE-P-002 |
| Aggregate Promotion Rule | DE-P-011 |
| Reference Scenario Coherence | DE-P-012 |
| Scenario Falsification | DE-P-013 |
| Modelling Defaults | DE-P-020 |
