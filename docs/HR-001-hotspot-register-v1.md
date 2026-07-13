# HR-001 — Domain Hotspot Register

**Status**: Accepted

**Version**: 1.0

**Date**: 2026-07-13

---

# Purpose

The Domain Hotspot Register records every intentionally unresolved Domain question.

A Hotspot is not a defect.

A Hotspot represents an acknowledged uncertainty that remains outside the accepted Core Domain until sufficient behavioural evidence is available.

The purpose of this register is to distinguish:

- accepted Domain decisions;
- unresolved behavioural questions;
- future engineering work.

---

# Governance

Every Hotspot shall have:

- a unique identifier;
- a behavioural description;
- an explicit status;
- an expected resolution process.

Hotspots never invalidate accepted Domain behaviour.

They simply delimit the current boundaries of Domain knowledge.

---

# Status

A Hotspot may have one of the following states:

Open

Behaviour under investigation.

Validation

Behaviour is being validated through Discovery.

Planned

Future Event Storming or Domain Engineering work planned.

Resolved

Integrated into the Core Domain.

Cancelled

Rejected after investigation.

---

# Hotspots

---

## H-G1 — Publication & Visibility Rules

Status

Open

Category

Domain Behaviour

Source

ES-001

Problem

Clinical Contributions become available according to publication and visibility rules.

The publication mechanism is accepted.

The visibility policy remains intentionally unspecified.

Current Impact

Publication behaviour is partially open.

No implementation should freeze visibility rules.

Affected Documents

UL-001

CAL-001

ADR-0010

DR-001

Planned Resolution

Strategic Design.

---

## H-A-006 — Clinical Contribution Consumed by Multiple Activities

Status

Open

Category

Domain Behaviour

Source

ES-008

Problem

A Clinical Contribution is produced by exactly one Clinical Activity.

The question is whether a single Clinical Contribution can serve as a direct input to multiple future Clinical Activities.

This question also affects the Clinical Handover model: does a Handover transfer a specific set of Contributions, or does it simply extend visibility?

Current Impact

Clinical Handover promotion blocked.

Contribution consumption model undefined.

Resolution of H-G1 is a prerequisite.

Affected Documents

DE-AGGREGATE-MAP-V1

DE-BASELINE-V1

DR-001

Planned Resolution

Future Event Storming. Requires H-G1 resolution as prerequisite.

---

## H-CC-001 — Clinical Continuity Validation

Status

Validation

Category

Discovery Validation

Source

Discovery

Problem

Clinical Continuity has been validated on three professions.

The validation threshold has not yet been reached.

Current Impact

Clinical Continuity remains provisional.

Affected Documents

UL-001

DR-001

CAL-001

Planned Resolution

Additional practitioner interviews.

---

## H-ES-001 — Draft Granularity

Status

Open

Category

Implementation Boundary

Source

ES-001

Problem

The Domain Events timeline includes "Clinical Draft Updated (0..n)".

The question is whether updates to a Clinical Draft should produce Domain Events, or whether the Draft is purely internal state of the Clinical Activity Aggregate — managed without producing observable events.

Current Impact

Clinical Activity implementation boundary undefined.

Affected Documents

DE-BASELINE-V1

DE-AGGREGATE-MAP-V1

CAL-001

Planned Resolution

Implementation session — not a full Event Storming. Constrained by audit and projection requirements.

---

## H-ES-002 — External Clinical Artifacts

Status

Open

Category

Core Domain

Source

ES-008

Problem

Imported clinical documents do not originate from a Clinical Activity.

Their relationship with:

Clinical Contribution

Clinical Knowledge

Care Record

remains intentionally open.

Current Impact

Care Record definition is partially open.

Affected Documents

ADR-0010

DE-AGGREGATE-MAP-V1

DR-001

UL-001

Planned Resolution

Future Event Storming.

---

## H-ES-003 — Clinical Observation vs Clinical Draft

Status

Open

Category

Domain Behaviour

Source

ES-001

Problem

The Domain Events timeline includes both "Clinical Observation Recorded" and "Clinical Draft Updated".

It is not yet resolved whether a Clinical Observation is a distinct concept from the Clinical Draft, or whether recording an observation is simply one way of updating the Draft.

Current Impact

Clinical Activity internals undefined.

If they are distinct, Clinical Observation requires its own definition in UL-001 and its own place in the Aggregate model.

Affected Documents

DE-BASELINE-V1

DE-AGGREGATE-MAP-V1

UL-001

Planned Resolution

Future Event Storming on Clinical Activity internals.

---

## H-ES-004 — Minimum Invariant for Clinical Activity Existence

Status

Open

Category

Domain Behaviour

Source

ES-004

Problem

The current model defines a Clinical Activity as requiring exactly one responsible Practitioner and zero or more Clinical Contributions.

What must be true for a Clinical Activity to be considered valid at the moment of creation remains undefined.

Current Impact

Clinical Activity creation behaviour undefined.

Affected Documents

DE-BASELINE-V1

DE-AGGREGATE-MAP-V1

CAL-001

Planned Resolution

Future Event Storming focused on Clinical Activity creation edge cases.

---

## H-INT-001 — Interrupted Clinical Activity

Status

Planned

Category

Behaviour

Source

Behaviour Review

Problem

The current Domain distinguishes:

Open Activity

Closed Activity

but not:

Interrupted Activity.

Current Impact

Workspace recovery behaviour remains unspecified.

Affected Documents

CAL-001

DE-AGGREGATE-MAP-V1

Planned Resolution

Future Event Storming.

---

## H-ADD-001 — Post-Closure Addendum

Status

Open

Category

Behaviour

Source

Behaviour Review

Problem

Can a Practitioner produce an additional Clinical Contribution after a Clinical Activity has already been closed?

Current Impact

Lifecycle boundary remains intentionally open.

Affected Documents

CAL-001

DE-AGGREGATE-MAP-V1

DR-001

Planned Resolution

Future behavioural study.

---

## H-HO-001 — Clinical Handover Completion

Status

Planned

Category

Aggregate Behaviour

Source

ES-005

Problem

Clinical Handover currently models only:

Requested

Accepted

The complete lifecycle still requires:

Refused

Expired

Cancelled

Current Impact

Clinical Handover remains provisional.

Affected Documents

DE-AGGREGATE-MAP-V1

DE-BASELINE-V1

DR-001

UL-001

Planned Resolution

Future Event Storming focused on Clinical Handover edge cases.

---

## H-RF-001 — Referral Completion

Status

Planned

Category

Behaviour

Source

ES-006

Problem

The relationship between two Clinical Activities linked by a Clinical Referral remains partially specified.

Current Impact

Referral behaviour remains incomplete.

Affected Documents

DE-AGGREGATE-MAP-V1

ADR-0007

DR-001

Planned Resolution

Future Event Storming.

---

## H-VRB-001 — Verbal Transmission as Continuity Mechanism

Status

Open

Category

Domain Boundary

Source

ES-007

Problem

In clinical practice, verbal transmission is a primary continuity mechanism — phone calls between Practitioners, oral briefings at shift changes.

Verbal transmission leaves no Clinical Contribution and produces no Domain Event in the current model.

The question is whether verbal transmission is outside the Domain by design, or a Domain concept requiring representation.

Current Impact

Clinical Continuity scope undefined for verbal transmission contexts.

Affected Documents

DE-BASELINE-V1

DE-AGGREGATE-MAP-V1

CAL-001

UL-001

Planned Resolution

Future field validation. Outcome determines whether a new Domain concept is needed.

---

# Relationship with the Decision Register

Accepted decisions belong to DR-001.

Unresolved behaviour belongs to HR-001.

A Hotspot may become a Decision only after behavioural validation.

---

# Engineering Rule

No implementation shall resolve a Hotspot by assumption.

Every Hotspot requires either:

- additional Discovery;
- additional Event Storming;
- or an explicit Architecture Decision.

---

# References

- DR-001 — Domain Decision Register
- UL-001 — Ubiquitous Language
- DE-BASELINE-V1
- DE-AGGREGATE-MAP-V1
- CAL-001
- DISCOVERY-V1-BASELINE
