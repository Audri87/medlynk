# REL-001 — Domain Engineering V1.0 Release Notes

**Status**: Release Candidate
**Version**: 1.0
**Date**: 2026-07-13

---

## 1. Overview

Domain Engineering V1.0 delivers the first stable behavioural model of the MedLink Clinical Platform Core Domain.

This release closes Discovery and Event Storming and authorizes the transition to Strategic Design.

No implementation decisions are included in this release.

---

## 2. Included Discovery Artefacts

| Artefact | Description |
|---|---|
| DISCOVERY-V1-BASELINE | Field observations across five healthcare professions. Core Domain concepts identified. |
| UL-001 v2.0 | Ubiquitous Language Charter. Normative vocabulary for all Domain documents. |
| CAL-001 v1.1 | Clinical Activity Lifecycle. Seven-phase behavioural description of clinical work. |

---

## 3. Included Domain Artefacts

| Artefact | Description |
|---|---|
| DE-BASELINE-V1 | Event Storming baseline. ES-001 through ES-008 frozen decisions. |
| DE-AGGREGATE-MAP-V1 | Aggregate classification and invariants for all Core Domain concepts. |
| DR-001 v1.0 | Domain Decision Register. 20 accepted and provisional decisions. |
| HR-001 v1.0 | Domain Hotspot Register. 12 formally registered open questions. |

---

## 4. Behavioural Validation Summary

The Core Domain was validated through eight Event Storming sessions.

| Session | Subject | Status |
|---|---|---|
| ES-001 | Domain Events | Frozen |
| ES-002 | Commands | Frozen |
| ES-003 | Policies | Frozen |
| ES-004 | Clinical Activity Aggregate | Accepted |
| ES-005 | Clinical Handover | Provisional |
| ES-006 | Clinical Referral | Boundary Frozen |
| ES-007 | Hospital Care Transition | Validated |
| ES-008 | Clinical Contribution | Domain Record — Accepted |

Key behavioural properties confirmed:

- Clinical Responsibility always has exactly one holder
- Clinical Activity closure is always an explicit Practitioner decision
- Clinical Draft is archived upon validation — never deleted
- Clinical Contribution is immutable and may never be deleted
- A Clinical Activity may produce zero or more Clinical Contributions
- No Domain Policy may replace Practitioner clinical judgment

---

## 5. Known Hotspots

Twelve Hotspots remain open at release. Full descriptions are in HR-001.

| ID | Title | Impact |
|---|---|---|
| H-G1 | Publication & Visibility Rules | Blocks Clinical Handover promotion |
| H-A-006 | Clinical Contribution Consumed by Multiple Activities | Blocks Clinical Handover promotion |
| H-CC-001 | Clinical Continuity Validation | Clinical Continuity remains provisional |
| H-ES-001 | Draft Granularity | Clinical Activity implementation boundary |
| H-ES-002 | External Clinical Artifacts | Care Record definition partially open |
| H-ES-003 | Clinical Observation vs Clinical Draft | Clinical Activity internals undefined |
| H-ES-004 | Minimum Invariant for Clinical Activity Existence | Clinical Activity creation undefined |
| H-INT-001 | Interrupted Clinical Activity | Workspace recovery unspecified |
| H-ADD-001 | Post-Closure Addendum | Lifecycle boundary open |
| H-HO-001 | Clinical Handover Completion | Clinical Handover lifecycle incomplete |
| H-RF-001 | Referral Completion | Referral behaviour incomplete |
| H-VRB-001 | Verbal Transmission as Continuity Mechanism | Clinical Continuity scope open |

No Hotspot invalidates the accepted Core Domain.

No implementation shall resolve a Hotspot by assumption.

---

## 6. Ready for Strategic Design

The following Domain concepts are stable and ready for Strategic Design:

- Clinical Activity — Accepted Aggregate Root
- Clinical Contribution — Domain Record, invariants frozen
- Clinical Draft — Internal State, lifecycle frozen
- Clinical Responsibility — Frozen, transfer mechanism defined
- Clinical Referral — Boundary Frozen
- Care Record — Read Model, accepted

The following require Hotspot resolution before Strategic Design can proceed on their full behaviour:

- Clinical Handover — Provisional, blocked by H-G1, H-A-006, H-HO-001
- Clinical Continuity — Provisional, blocked by H-CC-001

---

## 7. Documents Included

| Document | Status |
|---|---|
| DISCOVERY-V1-BASELINE | Accepted |
| UL-001 v2.0 | Accepted |
| CAL-001 v1.1 | Accepted |
| DE-BASELINE-V1 | Accepted with documented Hotspots |
| DE-AGGREGATE-MAP-V1 | Active |
| DR-001 v1.0 | Accepted |
| HR-001 v1.0 | Accepted |
| SOC-001 v1.0 | Release Candidate |

---

## 8. Release Summary

Domain Engineering V1.0 is complete.

The Core Domain is behaviourally stable.

Eight Event Storming sessions are closed.

Twenty Domain decisions are registered in DR-001.

Twelve open Hotspots are registered in HR-001.

Strategic Design is authorized per SOC-001.
