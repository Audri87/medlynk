# ARCH-001 — MedLink Architecture Principles

**Status**: Release v1.0
**Version**: 1.0

---

## Purpose

Define the immutable architectural principles governing every architectural decision within MedLink.

These principles supersede technical preferences, implementation details and framework choices.

---

## AP-001 — Reality First

Clinical reality is the only source of truth.

The software adapts to clinical practice.

Clinical practice never adapts to software limitations.

---

## AP-002 — Human Judgment First

Clinical reasoning always belongs to the Practitioner.

The platform assists.

It never decides.

---

## AP-003 — Structure Follows Capability

Business Capabilities determine architecture.

Architecture never determines Business Capabilities.

---

## AP-004 — Boundaries Before Technology

Bounded Contexts are defined by business responsibilities.

Never by frameworks, databases or deployment decisions.

---

## AP-005 — Clinical Platform First

The Clinical Platform is the strategic core of the MedLink ecosystem.

All other platforms evolve around it.

---

## AP-006 — Preserve Continuity of Care

Every architectural decision shall strengthen the continuity of care.

If a decision does not contribute to this objective, its justification must be explicit.

---

## AP-007 — Autonomous Contexts

Each Bounded Context owns:

- its language;
- its business model;
- its invariants;
- its lifecycle.

---

## AP-008 — Events Before Integration

Bounded Contexts collaborate primarily through Domain Events.

Direct synchronous dependencies remain exceptional.

---

## AP-009 — Evolution Over Perfection

Architecture is expected to evolve.

Governance ensures consistency over time.

---

## AP-010 — Domain Before Code

Code implements architecture.

Architecture implements the Domain.

The Domain never follows implementation constraints.

---

## Consequences

Every ADR, Strategic Design decision and implementation shall comply with these principles.

---

## References

- Domain Engineering V1.0
- ADR Collection
- UL-001
