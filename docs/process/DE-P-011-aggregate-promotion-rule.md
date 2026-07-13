# DE-P-011 — Aggregate Promotion Rule

**Statut** : Accepted
**Date** : 2026-07-13

---

## Principle

A Domain concept is promoted to Candidate Aggregate Root only when no existing Aggregate can protect its invariants without violating Aggregate isolation.

---

## Promotion Conditions

All four conditions must be evaluated before promotion.

### Condition 1 — Independent Invariants

The concept enforces at least one invariant that cannot be protected by any existing Aggregate without either:

* directly modifying another Aggregate's state; or
* requiring knowledge of another Aggregate's internal structure.

If an existing Aggregate can protect the invariant by extending its scope modestly, promotion is not justified.

---

### Condition 2 — Independent Lifecycle

The concept has its own lifecycle:

* distinct states;
* transitions triggered by Domain Events;
* transitions that enforce business rules.

A concept whose lifecycle is entirely governed by an existing Aggregate does not require promotion.

---

### Condition 3 — Cross-Boundary Identity

The concept is referenced across Aggregate boundaries by identity only.

If the concept is only accessible through an existing Aggregate Root, it remains an internal Entity.

If the concept is referenced directly by other Aggregates or by external systems, it cannot remain internal.

---

### Condition 4 — Multi-Party Transactional Consistency

The concept coordinates state across multiple actors or multiple Aggregates that cannot be combined in a single transaction.

If only one actor is involved, an existing Aggregate can usually absorb the responsibility.

---

## Default Position

Do not promote.

A new Aggregate Root adds consistency boundaries, coordination complexity and cross-Aggregate coupling.

The default is to find a simpler model before considering promotion.

---

## Application

This rule was applied during:

* ES-005 — Clinical Handover promoted to Candidate (multi-party invariants, responsibility gap)
* ES-008 — Clinical Contribution not promoted (no active invariants post-creation, degenerate case)
* ES-006 — Clinical Referral rejected (invariants absorbed by existing Clinical Activities)
