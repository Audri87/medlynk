# DE-000 — Domain Engineering Charter

**Statut** : Active
**Date** : 2026-07-11

---

## Purpose

Domain Engineering transforms the Discovery V1 Baseline into an executable Domain Model.

Unlike Discovery, Domain Engineering does not seek new concepts.

Its purpose is to reveal the behavioural structure of the Domain through Event Storming.

---

## Discovery Baseline

Domain Engineering starts from the accepted Discovery V1 Baseline.

The following elements are considered stable:

* Ubiquitous Language
* Core Domain concepts
* Clinical Cognitive Framework
* Clinical Activity Lifecycle
* Architectural Principles
* Product Missions

These elements constitute the reference model.

---

## Primary Objective

The objective is to discover:

* Domain Events
* Commands
* Policies
* Aggregate boundaries
* Invariants
* Read Models
* Published Language

The objective is **not** to redesign Discovery.

---

## Behaviour First

Domain Engineering models behaviour before structure.

The recommended sequence is:

1. Domain Events
2. Hotspots
3. Commands
4. Actors
5. Policies
6. Aggregate discovery
7. Read Models

Aggregates must emerge from behaviour.

They must never be assumed beforehand.

---

## Event Storming Principles

Every Event Storming session follows these rules.

### Events first

Events are expressed as completed facts.

Example:

* Clinical Activity Started
* Clinical Contribution Created

Not:

* Start Activity
* Create Contribution

---

### Reality over theory

When Discovery and Event Storming disagree:

the disagreement becomes a modelling hotspot.

Neither side automatically wins.

The contradiction must be investigated.

---

### Hotspots are valuable

Open questions are expected.

Hotspots are documented.

They are not prematurely resolved.

---

### Aggregates are discoveries

Candidate Aggregates identified during Discovery are hypotheses.

Only Event Storming may validate or reject them.

---

## Discovery Governance

Core Domain concepts evolve only when:

* repeated field observations contradict Discovery; or
* Event Storming reveals structural inconsistency.

Ideas, implementation convenience or UI requirements are insufficient reasons.

---

## Workspace Separation

Professional Workspace remains independent from the Core Domain.

Profession-specific behaviour should first be evaluated as:

* Workspace Pattern
* Widget
* Read Model
* Configuration

before introducing new Domain concepts.

---

## Challenge Process

Challenge sessions continue throughout Domain Engineering.

Their objective changes.

Before:

"Discover missing concepts."

Now:

"Attempt to falsify the behavioural model."

Every challenge is classified as:

* confirmed modelling issue;
* Event Storming hotspot;
* Workspace concern;
* implementation concern;
* rejected objection.

---

## Success Criteria

Domain Engineering is considered complete when:

* Aggregate boundaries are stable;
* Domain Events are coherent;
* invariants are identified;
* Published Language is defined;
* Context boundaries are validated;
* implementation architecture can begin without conceptual ambiguity.

---

> **Discovery explained the Domain.**
>
> **Domain Engineering reveals how the Domain behaves.**
