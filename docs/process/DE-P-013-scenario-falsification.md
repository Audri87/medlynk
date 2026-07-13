# DE-P-013 — Scenario Falsification

**Statut** : Accepted
**Date** : 2026-07-13

---

## Principle

Every scenario review must actively attempt to falsify the current behavioural model before any conclusion can be drawn.

A review that only confirms is insufficient.

---

## Why Falsification

Confirmation without falsification attempt is weak evidence.

A model that has not been challenged cannot be considered stable.

The objective is not to defend existing decisions.

The objective is to find the conditions under which they break.

If the model resists falsification, its stability is genuine.

If it does not, the defect has been found before implementation.

---

## Falsification Targets

### Domain Events

Are they truly observable business facts?

Or do they describe reasoning, states, commands or projections?

---

### Invariants

Can the proposed Aggregate actually enforce them?

Or do they require cross-Aggregate knowledge?

---

### Policies

Are they triggered by Domain Events?

Or are they state conditions, preconditions or projections?

---

### Aggregate Boundaries

Does the Aggregate protect what no other Aggregate can?

Or could an existing Aggregate absorb the responsibility?

---

### Cross-Profession Validity

Does the model hold for all professions already validated during Discovery?

Or does it silently assume a specific professional context?

---

## Outcome Classification

Every falsification attempt must be classified.

| Classification | Action |
|---|---|
| Confirmed modelling defect | Must be resolved before the scenario advances |
| Hotspot | Documented, deferred, does not block |
| Workspace concern | Moved to Professional Workspace design |
| Implementation concern | Moved to technical architecture |
| Rejected objection | Documented and closed with justification |

---

## Application

This principle governs all ES-00X challenge sessions.

It is the operational counterpart of the Discovery falsification approach applied to Domain Engineering.
