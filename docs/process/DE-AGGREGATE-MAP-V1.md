# DE — Aggregate Map V1

**Statut** : Active
**Date** : 2026-07-13
**Sessions** : ES-001 — ES-008

---

## Accepted Aggregate Root

### Clinical Activity

**Status** : Accepted

**Responsibilities**

* Governs the bounded episode of clinical work
* Owns and manages the Clinical Draft
* Produces Clinical Contributions
* Defines and maintains Clinical Responsibility

**Invariants**

* Exactly one responsible Practitioner
* Zero or more Clinical Contributions
* Clinical Draft never exists outside a Clinical Activity
* Clinical Activity closure is an explicit Practitioner act — never automatic

**Relationships**

* Produces → Clinical Contribution (1 Activity : 0..n Contributions)
* Initiates → Clinical Handover (when responsibility must be transferred)
* Delegates → Clinical Referral (when a specific act is requested of another Practitioner)
* Reads → Clinical Contribution (from Care Record, during Context Reconstruction)

---

## Provisional Aggregate

### Clinical Handover

**Status** : Provisional — not yet accepted

**Responsibilities**

* Transfers Clinical Responsibility for a Patient from one Practitioner to another
* Maintains a defined holder of Clinical Responsibility throughout the transfer period

**Invariants**

* Each instance is initiated by exactly one request act
* Accepted at most once
* Clinical Responsibility remains with the requesting Practitioner until explicit acceptance
* A second Handover may be initiated for the same Patient if a prior request was refused or abandoned — "one request" is an invariant of the instance, not of the Clinical Activity

**Relationships**

* Initiated by → Clinical Activity (of the requesting Practitioner)
* Terminates → Clinical Responsibility of the requesting Practitioner upon acceptance
* Establishes → Clinical Responsibility of the accepting Practitioner

**Promotion blocked by**

* G1 — Visibility and authorization rules not yet resolved
* H-A-006 — Contribution consumption model not yet resolved
* Refused and Unanswered states not yet modelled

---

## Domain Record

### Clinical Contribution

**Status** : Behaviour Frozen — DDD classification intentionally open

**Responsibilities**

* Carries an immutable clinical record explicitly validated by a Practitioner
* Remains independently referenceable after its producing Clinical Activity is closed
* Contributes to Clinical Knowledge upon publication

**Invariants**

* Immutable after validation
* Produced by exactly one Clinical Activity
* Never deleted
* May be referenced indefinitely across contexts

**Characteristics**

* Independent identity — referenced by ID across Aggregates, Care Record, and Clinical Handover
* No active lifecycle after validation — receives no Commands, protects no mutable state post-creation
* Cannot be classified as an Entity inside Clinical Activity (externally referenceable after Activity closure)
* Does not satisfy Evans Aggregate Root criteria (no child objects, no Commands to reject after creation)

**Relationships**

* Produced by → Clinical Activity (1 Contribution : exactly 1 Activity)
* Consumed by → Clinical Activity (0..n Activities may read the same Contribution)
* Composes → Care Record
* Transfers with → Clinical Handover (as content available to the receiving Practitioner)

---

## Internal State

### Clinical Draft

**Status** : Accepted

**Classification** : Internal state of Clinical Activity — not an independent concept

**Characteristics**

* Mutable
* Private to the responsible Practitioner
* No clinical or medico-legal value before explicit validation
* Never part of the Care Record
* May be abandoned
* Archived upon validation — its content becomes a Clinical Contribution

---

## Read Model

### Care Record

**Status** : Accepted (ADR-0010)

**Classification** : Read Model — not an Aggregate

**Characteristics**

* Derived from published Clinical Contributions
* May include external clinical artifacts subject to defined provenance rules (Hotspot H-ES-002)
* Never a source of truth for write operations
* Reconstructable from Clinical Contributions at any point

---

## Not Aggregates

### Clinical Referral

**Status** : Boundary Frozen

**Reason** : No independent invariants identified. No lifecycle distinct from Clinical Activity.

**Accepted behaviour** : A Referral involves two independent Clinical Activities — one by the referring Practitioner, one by the receiving Practitioner. The referring Practitioner retains Clinical Responsibility throughout. The concept is defined in UL-001 and distinguishes referral from handover at the language level.

**Remaining Hotspot** : The behavioural link between the two Clinical Activities in a Referral scenario is not yet defined (ES-006).

---

## Hotspots

| ID | Question | Blocks |
|---|---|---|
| H-ES-001 | Draft granularity — Domain Event or internal state only | Clinical Activity implementation |
| H-ES-002 | Imported clinical documents — Clinical Contribution or distinct concept | Care Record definition |
| H-ES-003 | Clinical Observation vs Clinical Draft — same object or distinct | Clinical Activity internals |
| H-ES-004 | Minimum invariant for a Clinical Activity to exist | Clinical Activity |
| H-A-006 | Can one Contribution be consumed as input by multiple future Activities | Clinical Contribution model |
| G1 | Visibility and authorization — who can read which Contributions | Clinical Handover promotion, implementation |
| ES-006 | Behavioural link between referring and receiving Clinical Activities | Referral model |
| H-INT-001 | Interrupted Clinical Activity — pause vs. closure distinction | Clinical Activity lifecycle |
| H-ADD-001 | Addendum after Clinical Activity Closed | Clinical Activity lifecycle |
| H-VRB-001 | Verbal transmission as continuity mechanism — in or out of Domain | Clinical Continuity scope |
