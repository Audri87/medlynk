# Platforms

## Purpose

`Platforms/` is a logical source-code container.

It groups the MedLink business platforms under a single organisational root.

---

## What Platforms is NOT

- **Not a deployment unit.** All Platforms are deployed as part of the same Modular Monolith.
- **Not a bounded context.** A Platform contains multiple bounded contexts.
- **Not a runtime component.** The `Platforms/` directory has no runtime significance. It is a source-code organisation convention only.

---

## What a Platform is

A Platform is an organisational container that owns one or more business capabilities.

Each Platform owns its own four layers:

| Layer | Responsibility |
|---|---|
| **Presentation** | HTTP interface, API resources, state processors, state providers |
| **Application** | Use cases, commands, queries, handlers, facades, ports |
| **Domain** | Aggregates, entities, value objects, domain events, business rules |
| **Infrastructure** | Persistence, projections, read models, external adapters |

No layer may depend on a layer below it in this table. See SA-001 and SA-003.

---

## Current Platforms

| Platform | Status | Purpose |
|---|---|---|
| `Clinical/` | Active — MVP | Organises the work of clinical actors |
| `Collaboration/` | Future | |
| `Trust/` | Future | Consent, compliance, traceability |
| `Identity/` | Future | Authentication and actor identity |
| `Learning/` | Future | |
| `Conference/` | Future | |

---

## Source-code organisation only

`Platforms/` exists solely for source-code organisation.

It has no equivalent in the deployment topology, the runtime architecture, or the domain model.

Adding or removing a Platform directory has no effect on deployment, runtime routing, or database schema.
