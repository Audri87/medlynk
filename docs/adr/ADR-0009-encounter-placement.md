# ADR-0009 — Encounter Placement

**Status:** Accepted

---

## Context

During domain modelling of the Clinical Platform, the concept of Encounter was introduced as a container for one or more Clinical Activities.

The initial proposal: an Encounter groups Clinical Activities that occur at the same time and place (office visit, teleconsultation, home visit).

During review, the following observation emerged:

> An Encounter models how work is **organised**.
> A Clinical Activity models **who is responsible** for professional work.

These are different concerns.

---

## Decision

**Encounter is removed from the Clinical Domain.**

It belongs to operational bounded contexts such as:

- Scheduling
- Coordination
- Workflow Management

Clinical Activity remains the primary and only unit of professional clinical work in the Clinical Domain.

---

## Consequences

### What Encounter was doing

Encounter was providing:
1. A grouping mechanism for multiple Clinical Activities
2. A modality context (in-person, teleconsultation, phone)
3. A temporal anchor (date and time of the meeting)

### How this is now addressed

| Former responsibility | New location |
|---|---|
| Grouping activities | Projection / Workspace layer |
| Modality (in-person, remote) | Field on Clinical Activity |
| Temporal anchor | Field on Clinical Activity (startedAt) |

### What does not change

A practitioner may still open multiple Clinical Activities during the same office visit. These activities are independent. They may reference the same appointment from the Scheduling bounded context — but this reference is operational, not clinical.

---

## Boundary Rule

The Clinical Domain does not model appointments, schedules or organisational logistics.

If a concept primarily answers the question *"how is work organised?"* — it does not belong to the Clinical Domain.

If a concept primarily answers the question *"who is responsible for professional work?"* — it belongs to Clinical Work.

---

## Rationale

> Encounter models organisation.
> Clinical Activity models responsibility.
