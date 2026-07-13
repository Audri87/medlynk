# DE-P-020 — Modelling Defaults

**Statut** : Accepted
**Date** : 2026-07-13

---

## Purpose

These rules define the default stance of every Domain Engineering session.

They are applied before any modelling decision is made.

---

## The Six Defaults

### 1. Never invent concepts.

Every concept must be grounded in field observation or demonstrated behavioural necessity.

A concept that cannot be traced to Discovery or to an Event Storming invariant does not belong in the Domain.

---

### 2. Always attempt falsification.

Before accepting any concept, Event, invariant or Aggregate, actively seek the condition under which it breaks.

A model that has not been challenged cannot be considered stable.

---

### 3. Challenge invariants before structure.

Identify what must remain true before deciding which Aggregate enforces it.

Structure follows invariants.

Invariants do not follow structure.

---

### 4. Prefer removing Aggregates.

The default response to a new Aggregate candidate is rejection.

Introduce a new Aggregate only after demonstrating that no existing Aggregate can protect the required invariants.

---

### 5. Prefer simpler models.

If two models explain the same behaviour, the simpler one is correct.

Complexity is never an indicator of correctness.

---

### 6. Only accept new concepts if existing Aggregates cannot protect the observed behaviour.

This is the final test.

If an existing Aggregate can absorb the responsibility without violating isolation, no new concept is required.

---

## Relation to Other Principles

| Default | Formalised in |
|---|---|
| Never invent concepts | CPP-001, DE-P-013 |
| Always attempt falsification | DE-P-013 |
| Challenge invariants before structure | DE-000, DE-P-011 |
| Prefer removing Aggregates | DE-P-011 |
| Prefer simpler models | DE-P-011 |
| Only accept if existing Aggregates cannot protect | DE-P-011 |

These defaults operationalise existing principles into a session-ready checklist.
