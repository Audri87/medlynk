# DR-001 — Domain Decision Register

**Status**: Accepted
**Version**: 1.0
**Date**: 2026-07-13

---

# Purpose

The Domain Decision Register records every accepted Domain Engineering decision that defines the current behaviour of the MedLink Core Domain.

Unlike ADRs, this document does not explain why a decision was made.

It records the decisions that are currently in force.

The Decision Register is the normative reference for the Core Domain.

---

# Governance

A decision may have one of the following states:

- Accepted
- Provisional
- Superseded
- Deprecated

Only Accepted and Provisional decisions define the current Domain.

Historical decisions remain traceable through ADRs and Event Storming reviews.

---

# Accepted Decisions

## DR-001

### Clinical Activity is the Aggregate Root of clinical work.

Status

Accepted

Reference

ES-004

DE-BASELINE-V1

---

## DR-002

### A Clinical Activity owns its Clinical Draft.

Status

Accepted

Reference

ES-004

---

## DR-003

### A Clinical Draft is mutable and private until explicit validation.

Status

Accepted

Reference

ES-004

CAL-001

---

## DR-004

### A Clinical Contribution is created only through explicit Practitioner validation.

Status

Accepted

Reference

ES-004

ES-001

---

## DR-005

### A Clinical Contribution is immutable after validation.

Status

Accepted

Reference

ES-008

---

## DR-006

### Every Clinical Contribution is produced by exactly one Clinical Activity.

Status

Accepted

Reference

ES-008

---

## DR-007

### Clinical Knowledge evolves by accumulation of immutable Clinical Contributions.

Status

Accepted

Reference

ES-008

ADR-0008

---

## DR-008

### Clinical Responsibility belongs to exactly one Practitioner at any time.

Status

Accepted

Reference

ES-005

ES-006

UL-001

---

## DR-009

### Clinical Referral never transfers Clinical Responsibility.

Status

Accepted

Reference

ES-006

---

## DR-010

### Clinical Handover transfers Clinical Responsibility only after explicit acceptance.

Status

Provisional

Reference

ES-005

ES-007

---

## DR-011

### Clinical Reasoning always belongs to the Practitioner.

Status

Accepted

Reference

DE-P-001

DE-P-002

CAL-001

---

## DR-012

### Validation is always an explicit Practitioner decision.

Status

Accepted

Reference

ES-004

CAL-001

---

## DR-013

### Clinical Activity Closure is always an explicit Practitioner decision.

Status

Accepted

Reference

ES-004

ES-003

CAL-001

---

## DR-014

### No automatic Domain Policy may replace Practitioner clinical judgment.

Status

Accepted

Reference

DE-P-001

ES-003

---

## DR-015

### The Care Record derives from Clinical Contributions.

Status

Accepted

Reference

ADR-0010

H-ES-002

---

## DR-016

### External Clinical Artifacts remain outside the accepted Core Domain until H-ES-002 is resolved.

Status

Provisional

Reference

H-ES-002

---

## DR-017

### Clinical Continuity is primarily achieved through Clinical Contributions and, when responsibility changes, through Clinical Handovers.

Status

Provisional

Reference

H-CC-001

CAL-001

---

## DR-018

### The Domain describes clinical work independently of healthcare professions.

Status

Accepted

Reference

DISCOVERY-V1-BASELINE

UL-001

CPP-001

---

## DR-019

### A Clinical Activity may produce zero or more Clinical Contributions.

Status

Accepted

Reference

ES-004

DE-BASELINE-V1

---

## DR-020

### A Clinical Contribution may never be deleted.

Status

Accepted

Reference

ES-008

DE-BASELINE-V1

---

# Relationship with ADRs

ADRs explain why a decision exists.

The Decision Register records which decisions are currently valid.

If an ADR conflicts with this document, the conflict shall be resolved by updating the ADR or superseding the decision through the Domain Engineering governance process.

---

# References

- UL-001
- DE-BASELINE-V1
- DE-AGGREGATE-MAP-V1
- CAL-001
- HR-001
- ADR Series
- Event Storming Reviews ES-001 → ES-008
