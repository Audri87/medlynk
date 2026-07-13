# ADR-0004 — CQRS

**Status:** Accepted

## Decision

MedLink applies strict CQRS separation.

## Write Side (Commands)

- Commands express intent: `CreateEncounterCommand`, `SignPrescriptionCommand`
- Command Handlers modify aggregates
- Aggregates emit Business Events
- Business Events update projections

## Read Side (Queries)

- Queries return read models (projections)
- Query Handlers query the database directly (Doctrine DBAL, not ORM)
- No aggregate loaded for reads

## Buses

| Bus | Middleware | Purpose |
|---|---|---|
| `command.bus` | `doctrine_transaction` | Dispatch Commands |
| `query.bus` | none | Dispatch Queries |
| `event.bus` | `allow_no_handlers` | Dispatch Domain Events |

## Rules

- Commands return nothing (or a scalar ID at most).
- Queries never modify state.
- Projections are rebuilt from events — never treated as source of truth.
- No full Event Sourcing. Aggregates are persisted in PostgreSQL.
