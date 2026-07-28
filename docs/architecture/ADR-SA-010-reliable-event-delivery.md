# ADR-SA-010 — Reliable Event Delivery

**Document ID**: ADR-SA-010
**Title**: Reliable Event Delivery — Outbox Pattern, At-Least-Once, Replay
**Status**: Approved

---

## Purpose

This document resolves the architectural gap identified in the CTO review (2026-07-24):
Domain Events are ephemeral in the current architecture. They transit through the
`event.bus` post-commit and disappear. A crash between commit and publication loses
the event permanently.

For a clinical platform where a lost event means a desynchronised projection and
potentially missing clinical information, at-most-once delivery is not acceptable.

This document establishes the reliable event delivery policy for MedLink.

---

## 1. Context

### Why a Domain Event Is Critical

A Domain Event is the only record that a business state transition occurred.

In MedLink's CQRS architecture:
- The Aggregate holds current state (Write Side)
- The Projection holds the pre-computed read representation (Read Side)
- The Domain Event is the bridge — it carries the facts that allow the Read Side to
  remain consistent with the Write Side

A lost Domain Event means the Projection is permanently out of sync with the Aggregate.
The Write Side says one thing. The Read Side shows another. In a clinical context, this
is not a data inconsistency — it is a clinical information error.

### Why Event Driven Implies a Delivery Policy

"Event Driven" is not a description of technology. It is a contract: the system's
behaviour is governed by the sequence of events it produces and consumes.

That contract has a prerequisite: events must arrive. An event-driven system with
unreliable delivery is not event-driven — it is a system that pretends to be
event-driven until the first crash.

SA-006 §12.5 states that projections are disposable and rebuildable. This property
is only true if the events from which they are built are durable. Without durable
events, projections are not disposable — they are as irreplaceable as the Aggregate
state itself.

### Why Loss Is Inacceptable

The current publication flow:

```
1. Command Handler executes
2. doctrine_transaction commits (Aggregate persisted)
3. DomainEventPublisherMiddleware publishes events to event.bus
4. Projectors receive events
```

Steps 2 and 3 are not atomic. A crash at any point between them produces:
- Aggregate persisted ✓
- Events not published ✗
- Projection not updated ✗
- No way to recover ✗

This is a silent corruption: the system continues operating, returns success to the
caller, and silently shows stale data to practitioners.

---

## 2. Problem

### P-001 — Crash After Commit

The PostgreSQL transaction commits. The PHP process crashes before `event.bus->dispatch()`
executes. The Domain Events are gone. The Projection is permanently behind the Aggregate.

### P-002 — Partial Publication

Three Domain Events are collected. Publication of the second throws an exception. The
first event has been published. The second and third have not. The Projection has
processed one of three events. Its state is partially updated — neither the old state
nor the new state, but an invalid intermediate state.

### P-003 — Projection Desynchronised

The above scenarios both produce a Projection that is out of sync with the Aggregate.
Because the Aggregate and Projection use separate stores (ADR-SA-007 D-007), there is
no automatic reconciliation mechanism. The desynchronisation is invisible without
explicit monitoring.

### P-004 — Replay Impossible

Without stored events, replaying a Projection to rebuild it from scratch is impossible.
This prevents:
- Bug fixes in Projection logic (the fixed handler cannot reprocess past events)
- Schema migrations (the new schema cannot be populated from existing events)
- Adding a new Projection after the fact (it starts with no history)

---

## 3. Decision

### The Outbox Pattern

MedLink SHALL implement the Transactional Outbox Pattern for Domain Event publication.

Every Domain Event produced during a Command Handler execution SHALL be persisted to the
`domain_event_outbox` table **in the same database transaction** as the Aggregate state
change.

A dedicated asynchronous worker SHALL read from the outbox and publish events to the
`event.bus` after the transaction commits.

```
Command Handler
    │
    ├── Aggregate.execute()          → records Domain Events
    │
    └── PostgreSQL transaction
            ├── Aggregate state → clinical_contributions
            └── Domain Events  → domain_event_outbox    ← atomic
                                                           same transaction

After commit:

Outbox Worker (async)
    │
    ├── SELECT unprocessed from domain_event_outbox
    ├── Publish to event.bus
    └── Mark as published in domain_event_outbox
```

### Delivery Guarantee: At-Least-Once

The Outbox Pattern guarantees **at-least-once** delivery. An event may be published more
than once (e.g., if the worker crashes after publishing but before marking the event as
published).

**Idempotence is mandatory.** Every Projector SHALL be idempotent. An event processed
twice must produce the same Projection state as an event processed once. This is enforced
by ADR-SA-009 D-004 (UPSERT with `ON CONFLICT DO UPDATE`).

Exactly-once delivery is not a goal. It requires distributed transactions. The
operational cost of distributed transactions exceeds the cost of designing idempotent
handlers, which is already required by this architecture.

### Events Are Durable and Rebuildable

Domain Events stored in the outbox are never deleted after publication. They are retained
permanently as the event log.

This makes Projections genuinely disposable: any Projection can be rebuilt at any time
by replaying the events in the outbox.

---

## 4. Outbox Table

```sql
CREATE TABLE domain_event_outbox (
    id            UUID         PRIMARY KEY DEFAULT gen_random_uuid(),
    aggregate_id  UUID         NOT NULL,
    aggregate_type VARCHAR(255) NOT NULL,
    event_type    VARCHAR(255) NOT NULL,
    platform      VARCHAR(100) NOT NULL,
    payload       JSONB        NOT NULL,
    occurred_at   TIMESTAMPTZ  NOT NULL,
    published_at  TIMESTAMPTZ,
    retry_count   SMALLINT     NOT NULL DEFAULT 0,
    status        VARCHAR(20)  NOT NULL DEFAULT 'pending',
    created_at    TIMESTAMPTZ  NOT NULL DEFAULT NOW()
);

CREATE INDEX idx_outbox_status_occurred
    ON domain_event_outbox (status, occurred_at)
    WHERE status IN ('pending', 'failed');

CREATE INDEX idx_outbox_aggregate
    ON domain_event_outbox (aggregate_id, aggregate_type);
```

**Status values:**

| Value | Meaning |
|---|---|
| `pending` | Persisted, not yet published |
| `published` | Successfully published to event.bus |
| `failed` | Last publication attempt failed; retry pending |
| `dead` | Max retries exceeded; moved to Dead Letter state |

---

## 5. Rules

### R-001 — Outbox Is Written in the Same Transaction as the Aggregate

The `DomainEventPublisherMiddleware` SHALL be updated to persist Domain Events to
`domain_event_outbox` within the active `doctrine_transaction`, before it commits.

The event is safe in the database before the transaction commits.
The transaction commits atomically: either both the Aggregate state and the outbox
entries are persisted, or neither is.

```
doctrine_transaction wraps:
    ├── CommandHandler → Repository → INSERT INTO clinical_contributions
    └── DomainEventOutboxWriter → INSERT INTO domain_event_outbox
```

No Domain Event SHALL be published directly to the `event.bus` by the
`DomainEventPublisherMiddleware`. Publication is exclusively the responsibility of the
Outbox Worker.

### R-002 — Every Projector Is Idempotent

Every Projector (formerly called ProjectionHandler) SHALL implement idempotent writes
using PostgreSQL UPSERT.

A Projector that is not idempotent is architecturally incorrect regardless of any other
quality. It SHALL NOT be merged.

Receiving the same Domain Event twice must produce identical Projection state.

### R-003 — No Projector Depends on Implicit Delivery Order

A Projector SHALL NOT assume that events arrive in a specific order relative to other
event types.

If a Projector requires event A to have been processed before event B, it SHALL implement
this dependency explicitly — for example, by checking Projection state at processing time
and deferring if the prerequisite has not arrived.

Relying on temporal ordering of the outbox worker is not a valid dependency mechanism.

### R-004 — Events Are Never Deleted

Published events in `domain_event_outbox` are never deleted. `published_at` is set.
`status` is set to `published`. The row remains.

Retention policy (archival to cold storage after N months) may be defined in a future
operational ADR. Deletion before archival is prohibited.

---

## 6. Retry Policy

| Attempt | Delay | Action |
|---|---|---|
| 1st failure | 30 seconds | Retry |
| 2nd failure | 5 minutes | Retry |
| 3rd failure | 30 minutes | Retry |
| 4th failure | — | Mark `dead`; alert |

`retry_count` is incremented on each failure. `status` becomes `dead` when `retry_count`
reaches 3.

### Dead Letter State

An event in `dead` status means the Outbox Worker has exhausted its retry attempts.
The event has NOT been published. The Projection is behind.

**Dead events SHALL NOT be silently ignored.**

Required response:
1. An alert is triggered within 30 minutes of the event reaching `dead` status.
2. An operator investigates and resolves the root cause.
3. The operator manually resets `status` to `pending` to trigger re-delivery.
4. Alternatively, the operator triggers a targeted replay (see §7).

### Monitoring

The following metrics SHALL be instrumented:

| Metric | Alert threshold |
|---|---|
| `outbox_pending_count` | > 100 pending for > 5 minutes |
| `outbox_dead_count` | > 0 for > 30 minutes |
| `outbox_worker_lag` | > 60 seconds between oldest pending and NOW() |
| `projector_failure_count` | Any failure |

---

## 7. Replay

The Outbox table is the event log. Replay is a first-class operation.

### Replay Scopes

| Scope | SQL filter | Use case |
|---|---|---|
| Full replay | No filter | Rebuild all Projections from scratch |
| Time range | `WHERE occurred_at BETWEEN :from AND :to` | Rebuild after a data incident |
| Aggregate | `WHERE aggregate_id = :id` | Debug a specific entity |
| Event type | `WHERE event_type = :type` | Rebuild after a Projector bug fix |
| Platform | `WHERE platform = :platform` | Rebuild all Clinical Projections |

### Replay Procedure

1. Truncate the target Projection table(s).
2. Set `status = 'pending'` on the selected outbox rows.
3. The Outbox Worker reprocesses them in `occurred_at` order.
4. Because Projectors are idempotent, reprocessing is safe at any time.

No special rebuild command is required. The Outbox Worker is the replay mechanism.

### New Projections Added After Deployment

When a new Projector is added to the codebase:
1. The new Projection table is created via migration.
2. A targeted replay by event type populates the new table from existing outbox entries.
3. The new Projector is live.

This is only possible because events are durable. Without the outbox, new Projections
start with no historical data.

---

## Impact on the Current Architecture

### DomainEventPublisherMiddleware

The middleware is updated. Instead of calling `$this->publisher->publish()` after commit,
it calls a new `DomainEventOutboxWriterPort` that persists events to the outbox table
within the transaction.

The `DomainEventPublisherPort` / `DomainEventBusPublisher` are used exclusively by the
Outbox Worker, not by the middleware.

### DomainEventCollector

Unchanged. The collector still accumulates events during the Command Handler execution.
The middleware flushes them to the outbox instead of to the bus.

### Projectors

Unchanged. They still receive Domain Events via `event.bus`. The delivery mechanism
changed; their interface did not.

---

## Relation to Other ADRs

| ADR | Relation |
|---|---|
| ADR-SA-007 D-007 — Read Model Persistence | Outbox makes Projections genuinely disposable |
| ADR-SA-009 D-004 — DBAL + UPSERT | Outbox at-least-once requires idempotent Projectors |
| ADR-SA-009 D-003 — Projection Writes | Outbox Worker uses DBAL to read and update outbox status |
| ADR-0014 — Domain Events Platform Boundary | Outbox stores platform field; prevents cross-platform leakage |

---

## Decision History

| Date | Decision |
|---|---|
| 2026-07-24 | ADR approved — Outbox Pattern mandatory; at-most-once delivery prohibited; replay capability required |
