# MedLink — Clinical Domain Model
## Cross-Profession Field Test — Review Request

---

## Purpose

This document presents the results of testing the MedLink Clinical Domain Model against two professions: **psychologist** and **physiotherapist**.

The goal is to identify where the model holds, where it tensions, and where it fails.

We are not looking for validation. We are looking for falsification.

---

## Current Domain Model (summary)

### Clinical Activity

The fundamental unit of clinical work.

```
Clinical Activity
├── subject: PatientId
├── responsible: ActorId          ← exactly one responsible practitioner
├── contributors: ActorId[]       ← many contributors allowed
├── intent: string                ← initial reason, may be enriched
├── scope: string[]               ← additional reasons added during activity
├── related: ActivityId[]         ← activities opened from this one
├── workingNotes: (temporary)     ← never enters the Care Record
├── contributions: ContributionId[]  ← durable outputs
└── lifecycle: Preparation → Active → Wrap-up → Closed
```

### Key invariants

* Exactly one responsible practitioner at all times.
* Responsibility may be explicitly transferred. Every transfer is historized.
* Only the responsible practitioner may close the activity.
* Activities are never automatically closed.
* Working Notes are temporary and never become Clinical Contributions.
* Clinical Contributions are durable.

### Boundary rule (recently revised)

A Clinical Activity ends when the practitioner decides it ends.

When an unexpected clinical problem emerges during an activity, the practitioner explicitly chooses:

* **Option A** — extend the current activity (add to scope)
* **Option B** — open a new linked Clinical Activity

Both are explicit professional acts. The system does not decide automatically.

### Clinical Contribution

Durable clinical information produced or consumed during a Clinical Activity.

Examples: consultation note, prescription, referral, lab result, imaging report, session note, exercise programme.

### Care Record

Built from Clinical Contributions.

Represents longitudinal clinical knowledge about a patient.

---

## Test 1 — Psychologist

### Scenario

Weekly individual psychotherapy sessions. Patient treated for generalised anxiety disorder. Duration: 6 months.

### What holds

| Element | Holds? | Notes |
|---|---|---|
| Clinical Activity = one session | Yes | Natural unit for the psychologist |
| Initial intent | Yes | "Psychotherapy — generalised anxiety disorder" |
| Extend scope or open new activity | Yes | If a crisis emerges mid-session, practitioner chooses |
| Working Notes written after the session | Yes | Model supports this path |
| Session note as Clinical Contribution | Yes | Durable, produced after the session |
| Lifecycle: Preparation → Closed | Yes | Standard lifecycle holds |

### Tensions found

**T1 — Extreme confidentiality**

A psychologist's session notes must not be visible to other practitioners without explicit patient consent.

The Care Record model currently assumes Clinical Contributions are accessible to practitioners who have a clinical relationship with the patient.

For psychology, this assumption is wrong by default.

The model has no concept of **contribution visibility** or **access scope**.

---

**T2 — The therapeutic relationship is not a Clinical Contribution**

The core clinical work of a psychologist — the therapeutic relationship itself — produces no document and no durable artifact.

The relationship evolves over months. It is clinically central. It is not capturable as a Clinical Contribution.

The model captures clinical artifacts. It does not capture clinical relationships.

---

**T3 — No notes during the session**

Many psychologists deliberately avoid taking notes during sessions to maintain therapeutic presence and eye contact.

All notes are produced after the session ends.

The model permits this but does not anticipate it. The Working Notes concept implicitly assumes capture during the activity.

---

**T4 — Group therapy**

Group therapy sessions involve multiple patients simultaneously.

The model assumes one subject per Clinical Activity.

MedLink has deliberately excluded group patient scenarios from Clinical v1.

This exclusion may need to be revisited for psychology-specific features in the future.

---

## Test 2 — Physiotherapist

### Scenario

Post-operative knee rehabilitation following ACL reconstruction. 10 sessions. Patient referred by orthopaedic surgeon.

### What holds

| Element | Holds? | Notes |
|---|---|---|
| Clinical Activity = one session | Yes | Natural unit |
| Initial intent | Yes | "Knee rehabilitation — post-operative ACL" — stable across all sessions |
| Extend scope (hip compensation) | Yes | Practitioner chooses to extend or open new activity |
| Session note as Clinical Contribution | Yes | |
| Lifecycle: Preparation → Closed | Yes | |

### Tensions found

**T5 — Structured measurements exceed free text**

Physiotherapists systematically record: pain level (EVA scale), joint range of motion (goniometry), muscle strength, functional scores.

These are structured clinical measurements, not narrative text.

The Working Notes concept currently assumes free text. Physiotherapy may require a richer, more structured capture format.

---

**T6 — Exercise programmes evolve**

An exercise programme issued at session 3 is modified at session 6 and again at session 9.

If Clinical Contributions are durable, each modification creates a new version.

The model does not define how contributions relate to or replace previous versions of the same document.

There is no versioning concept for Clinical Contributions.

---

**T7 — The prescription is an enabling precondition, not a produced contribution**

A physiotherapist cannot begin work without a valid medical prescription.

This prescription is a Clinical Contribution — but it differs fundamentally from contributions produced by the activity.

It does not document what was done.

It **authorises** the activity to begin.

The model currently treats all Clinical Contributions as equivalent. It does not distinguish between:

* **Enabling contributions** — preconditions that authorise work
* **Documenting contributions** — outputs that record what was done

---

**T8 — Patient-generated data between sessions**

Between sessions, patients perform exercises at home.

They return with clinically relevant information: pain experienced, exercises completed, difficulties encountered.

This information feeds the next session's Clinical Activity.

It is produced by the patient, not by a practitioner.

The model has no concept for **patient-generated data** and its relationship to Clinical Activities.

---

## Transversal Findings

Two gaps appear across both professions and are not profession-specific.

### G1 — Contribution visibility is not modelled

The model defines what a Clinical Contribution is.

It does not define who can read it, under what conditions, or with whose consent.

For psychology, access control is a primary clinical concern, not a secondary technical one.

For physiotherapy, the medical prescription is visible to the physiotherapist but may not be visible to other specialists.

**Contribution visibility** appears to be a domain concept, not an implementation detail.

### G2 — Enabling contributions vs documenting contributions

The model currently treats all Clinical Contributions as equivalent outputs.

Two distinct natures have emerged:

| Type | Examples | Purpose |
|---|---|---|
| **Enabling** | Medical prescription, imaging request | Authorises a Clinical Activity to begin |
| **Documenting** | Session note, report, test result | Records what was done or found |

These two types have different lifecycles, different visibility rules, and different relationships to Clinical Activities.

The model does not distinguish them.

---

## Review Questions

### 1. Contribution visibility

Is access scope a domain concept that belongs inside the Clinical Contribution model?

Or is it an infrastructure concern that should remain outside the domain?

---

### 2. Enabling vs documenting contributions

Is this a real conceptual distinction, or can both types be unified under one concept with a `type` attribute?

---

### 3. Patient-generated data

Does patient-generated data (home exercises, reported symptoms, self-measurements) belong inside the Clinical Domain Model?

If yes, what concept captures it?

If no, where does it live?

---

### 4. Structured measurements

Is free-text sufficient for Working Notes across all healthcare professions?

Or does the model need to accommodate structured clinical measurements?

---

### 5. Therapeutic relationship

Is the therapeutic relationship (central to psychology) a domain concept?

Or is it simply outside the scope of a clinical information model?

---

### 6. Contribution versioning

How should the model handle Clinical Contributions that replace or evolve from previous versions?

Is versioning a domain concern or an infrastructure concern?

---

## Goal

We are building a domain model capable of representing clinical work across multiple healthcare professions.

We are testing whether the current model is truly cross-profession, or implicitly assumes general practice as its default.

Do not optimise for elegance.

Identify where the model needs new concepts, where it needs revision, and where it is simply wrong.
