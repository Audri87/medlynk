# ADR-0010 – Care Record

## Status

Accepted

---

## Context

The Clinical Platform manages longitudinal clinical knowledge produced during patient care.

Several concepts coexist within the domain:

* Patient
* Clinical Activity
* Clinical Contribution
* Care Record

During the domain design, multiple interpretations of the Care Record were considered:

* Aggregate Root
* Entity
* Projection
* View

This ADR clarifies the domain meaning of the Care Record independently of any architectural implementation.

---

## Decision

A **Care Record** represents the **longitudinal clinical memory of a patient**.

It is the clinical knowledge that remains available over time to support future clinical reasoning and decision-making.

The Care Record is **derived from Clinical Contributions** produced or explicitly adopted under the responsibility of authorized healthcare professionals.

The Care Record is therefore a consequence of clinical work rather than a prerequisite for it.

A Care Record may initially contain no clinical knowledge. It progressively emerges as Clinical Contributions accumulate throughout the patient's clinical history.

---

## Domain Invariants

The Care Record:

* represents the longitudinal clinical memory of exactly one Patient;
* is derived exclusively from Clinical Contributions;
* never contains information outside the scope of clinical knowledge;
* does not own Clinical Contributions;
* exists only as the longitudinal memory associated with a Patient.

---

## Responsibilities

The Care Record is responsible for representing the trusted longitudinal clinical memory available for patient care.

It provides the clinical knowledge required for future Clinical Activities and Context Reconstruction.

---

## Non-Responsibilities

The Care Record is **not** responsible for:

* managing Clinical Activities;
* producing Clinical Contributions;
* managing document acquisition or import workflows;
* tracking document processing states (received, OCR, pending review, rejected, etc.);
* authorization or visibility rules;
* technical persistence or synchronization mechanisms.

---

## Consequences

Clinical knowledge enters the Care Record only through Clinical Contributions produced or explicitly adopted under clinical responsibility.

Documents, imports, laboratory results, patient uploads and external information may exist within the platform without immediately becoming part of the Care Record.

Their acquisition and processing belong to other architectural responsibilities.

This ADR intentionally does not define how the Care Record is materialized or persisted. Those decisions belong to architecture, not to the domain model.
