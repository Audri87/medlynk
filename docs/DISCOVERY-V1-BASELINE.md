# Discovery V1 Baseline

**Statut** : Accepted
**Date** : 2026-07-13
**Version** : 1.1 — terminology aligned with Domain Engineering

---

## Purpose

Discovery V1 establishes the first stable understanding of MedLink's Core Domain.

It does not claim that the Domain is complete.

It states that Discovery has reached sufficient maturity to begin Domain Engineering.

This document marks the transition between **understanding reality** and **designing the Domain Model**.

---

## What Discovery V1 Achieved

Discovery was conducted using a Reality First approach.

The objective was never to invent concepts.

The objective was to observe clinical work until stable Domain concepts emerged naturally across professions.

Discovery produced:

* a shared Ubiquitous Language;
* stable Core Domain concepts;
* Clinical Cognitive Framework;
* Clinical Activity Lifecycle;
* Product Missions;
* Workspace Principles;
* Architectural Principles;
* Discovery Governance.

The resulting corpus forms the Discovery V1 Baseline.

---

## Discovery Principles

The following principles are now considered stable.

* Reality First
* Human Judgment First
* Clinical Knowledge is the Product
* Cross-Practitioner Principle
* Mission Driven Design
* Professional Workspace
* Progressive Adoption

Future work builds upon these principles.

---

## Core Domain Baseline

Discovery identifies the following concepts as the current Core Domain baseline.

All definitions are aligned with UL-001.

---

**Clinical Activity**

A bounded episode of professional clinical work performed by a Practitioner for a specific clinical purpose.

---

**Clinical Draft**

A mutable working representation created and owned by a Clinical Activity while a Practitioner is producing a clinical contribution. Private to the responsible Practitioner. Without clinical or medico-legal value before explicit validation.

---

**Clinical Contribution**

An immutable clinical record explicitly validated by a Practitioner as the outcome of a Clinical Activity.

---

**Clinical Handover**

The transfer of Clinical Responsibility for a Patient from one Practitioner to another.

Identified from field observations of continuity patterns across professions (H-CC-001, H-CC-002).

---

**Clinical Referral**

A request from one Practitioner to another for a specific clinical act or professional opinion, without transferring Clinical Responsibility.

Identified as behaviourally distinct from Clinical Handover.

---

**Clinical Continuity**

The ability of successive Clinical Activities to preserve and extend the coherent care of a Patient over time.

---

**Clinical Knowledge**

Validated clinical knowledge available to support present and future Clinical Activities. Grows through Clinical Contributions and remains independent of the reasoning that produced them.

---

**Practitioner Interaction** (Collaboration Platform — future)

Cross-practitioner interaction initiated outside pre-established care relationships. Identified during Discovery. Belongs to a future Collaboration Platform, not the Clinical Platform.

---

These concepts may evolve only through explicit governance.

---

## What Discovery Intentionally Leaves Open

Discovery does not define:

* Aggregates
* Domain Events
* Commands
* Policies
* Read Models
* Process orchestration
* Technical implementation

These belong to Domain Engineering.

---

## Transition

Discovery has reached saturation.

Recent Practitioner interviews primarily produce:

* confirmation of existing concepts;
* Professional Workspace patterns;
* Domain Engineering questions.

They no longer produce significant new Core Domain concepts.

This is considered the signal to begin Event Storming.

---

## Governance

From this baseline onward:

A Core Domain concept may evolve only if:

* repeated field observations contradict the current model; or
* Event Storming reveals a structural inconsistency.

Ideas, features, UI improvements and profession-specific workflows are **not** sufficient reasons to modify the Core Domain.

They should first be evaluated as:

* Professional Workspace Patterns;
* Product Missions;
* Configuration;
* Platform specialization.

All terms used in architectural documents must be defined in UL-001 before use.

---

## Discovery Challenge

Future challenge sessions are expected to falsify the model rather than extend it.

Every challenge should be classified as one of the following:

* confirmed defect;
* Domain Engineering hotspot;
* Workspace Pattern;
* Mission evolution;
* field observation;
* rejected objection.

The objective is to protect the stability of the Core Domain while allowing continuous product evolution.

---

## Beginning of Domain Engineering

Discovery V1 is now considered complete.

The next phase begins with Event Storming.

Its objective is not to discover new concepts.

Its objective is to reveal:

* Domain Events;
* Commands;
* Aggregates;
* Policies;
* Read Models;
* Aggregate boundaries;
* Domain responsibilities.

The Domain will now emerge from behaviour rather than discussion.

---

> **Discovery V1 Baseline accepted.**
>
> **Domain Engineering begins.**
