# ADR-0014 — Domain Events Shall Never Cross Platform Boundaries

**Status:** Accepted
**Date:** 2026-07-15

---

## Context

SA-002 establishes the Platform as the highest architectural building block of MedLink.

Platforms communicate exclusively through published contracts.

ADR-0005 distinguishes two event types:

| Concept | Location | Nature |
|---|---|---|
| `BusinessEvent` | `Kernel/Domain/Event/` | Cross-platform fact — Kernel concept |
| Platform Domain Event | `Platforms/{Name}/Domain/Event/` | Platform-internal fact |

ADR-0005 permits a Platform Domain Event to implement `BusinessEvent` as a cross-platform mechanism.

SA-002 introduced a third event type — the Integration Event — as the explicit publication artifact of the Platform Contract.

This ADR formalises the boundary rule governing all three event types and resolves the ambiguity left open by ADR-0005 regarding what may cross a Platform boundary.

---

## Problem

Without an explicit boundary rule, two risks arise:

1. **Domain model leakage** — a Platform Domain Event published beyond its Platform boundary couples external consumers to the internal Domain model. Any refactoring of the Domain model breaks external consumers.

2. **Ambiguity in ADR-0005** — "implements BusinessEvent" was the only defined cross-platform mechanism. It did not distinguish between Kernel-level facts and Platform-to-Platform communication contracts.

---

## Decision

### Rule 1 — Domain Events are Platform-internal

A Platform Domain Event is an internal fact.

It never crosses the Platform boundary.

It is dispatched on the internal event bus for projection updates and reactions within the same Platform.

### Rule 2 — Integration Events are the only cross-Platform event mechanism

When a Platform needs to notify another Platform of a fact, it publishes an Integration Event.

An Integration Event is produced by the Platform Integration layer.

It is derived from one or more Domain Events but is a distinct artifact.

It carries only the information required by external consumers.

It is owned by the Platform Contract.

### Rule 3 — Integration Events and BusinessEvent

An Integration Event MAY implement `BusinessEvent` (ADR-0005) when the fact it represents has cross-platform significance at the Kernel level.

This is opt-in. Not every Integration Event implements `BusinessEvent`.

### Rule 4 — The receiving Platform uses an Anti-Corruption Layer

A Platform consuming Integration Events from another Platform shall translate them through an Anti-Corruption Layer before they enter its own Domain.

The receiving Platform Domain never depends on another Platform's event types.

---

## Event Type Summary

| Event Type | Scope | Owner | Crosses Platform Boundary |
|---|---|---|---|
| Platform Domain Event | Internal to Platform | Bounded Context | Never |
| Integration Event | Cross-Platform | Platform Contract | Yes — via Contract |
| `BusinessEvent` (Kernel) | Cross-Platform | Platform Kernel | Yes — Kernel-level |

---

## Production Flow

```
Bounded Context
    │
    │ Domain Event (internal)
    ▼
Integration Layer
    │
    │ produces Integration Event
    ▼
Platform Contract
    │
    │ published
    ▼
Other Platform → Anti-Corruption Layer → Internal Domain
```

---

## Rules

1. A Platform Domain Event shall never be published outside the Platform boundary.
2. Cross-Platform communication uses Integration Events published via the Platform Contract.
3. Integration Events are produced by the Integration layer, not by the Domain.
4. Integration Events carry only the information required by external consumers.
5. Integration Events are owned by the Platform Contract.
6. The receiving Platform translates incoming Integration Events through an Anti-Corruption Layer.
7. An Integration Event MAY implement `BusinessEvent` — this is opt-in.
8. The Kernel never imports from any Platform (inherited from ADR-0005).

---

## Consequences

**For Platform evolution** — Platforms may refactor their Domain model, rename Domain Events, or restructure internal aggregates without breaking external consumers, provided Integration Events remain stable.

**For Integration Events** — Integration Events are stable public artifacts and must be versioned. Breaking changes to Integration Events require a Platform Contract version increment.

**For ADR-0005** — ADR-0005 remains valid. The `implements BusinessEvent` pattern applies to Integration Events, not to Platform Domain Events directly. ADR-0014 refines and does not replace ADR-0005.

---

## Relation with existing ADRs

| ADR | Relation |
|---|---|
| ADR-0002 — Business Platforms | Platforms are defined here; this ADR governs their event communication |
| ADR-0003 — Hexagonal Architecture | Integration Events are produced at the Port/Adapter boundary |
| ADR-0005 — Business Events | Refined by this ADR — Integration Events may implement `BusinessEvent`; Platform Domain Events do not cross boundaries |
| SA-001 — Reference Architecture | SA-P-004 (Explicit Collaboration) is the architectural principle behind this rule |
| SA-002 — Platform Architecture | Section 5 (Platform Collaboration) implements this decision |

---

## References

- SA-001 — Reference Architecture (SA-P-004)
- SA-002 — Platform Architecture (Section 5, Section 7)
- ADR-0002 — Business Platforms
- ADR-0003 — Hexagonal Architecture
- ADR-0005 — Business Events vs Platform Domain Events
