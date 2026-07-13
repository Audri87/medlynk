# ADR-0011 – Progressive Adoption Strategy

## Status

Accepted

---

## Context

During the design of MedLink, an important question emerged:

How should practitioners adopt the platform when no historical data is available?

Initial discussions focused on technical solutions:

* DMP integration
* Legacy software migration
* Laboratory connectors
* PDF imports

However, these discussions revealed that the problem had been incorrectly framed.

The issue was not architectural.

It was about product adoption.

---

## Decision

MedLink adopts a **Progressive Adoption Strategy**.

Practitioners must be able to begin using MedLink immediately, without migrating their historical data.

Historical information may progressively enrich the platform through future integrations, but these integrations are **not prerequisites** for obtaining value.

Clinical knowledge is built through everyday practice.

Every Clinical Activity contributes to the gradual construction of the patient's longitudinal clinical memory.

---

## Consequences

The MVP must provide value from the very first Clinical Activity.

Historical integrations become adoption accelerators rather than launch blockers.

Practitioners may continue using their previous software while progressively building new Clinical Knowledge inside MedLink.

Migration becomes incremental rather than disruptive.

---

## Rationale

Changing clinical software is a high-friction event.

Progressive adoption:

* reduces adoption risk;
* avoids mandatory historical migration;
* allows immediate clinical work;
* lets practitioners naturally build trust in MedLink over time.

This strategy is considered a core product decision.
