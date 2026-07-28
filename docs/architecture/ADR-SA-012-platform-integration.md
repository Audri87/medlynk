# ADR-SA-012 — Platform Integration

**Document ID**: ADR-SA-012
**Title**: Platform Integration — Integration Events, Ownership, Versioning, Contracts
**Status**: Approved

---

## Purpose

MedLink is a multi-platform architecture. Today it has one platform: Clinical.

The platforms planned or anticipated are:

| Platform | Responsibility |
|---|---|
| Clinical | Care records, contributions, care teams |
| Identity | Practitioners, patients, organisations |
| Scheduling | Appointments, slots, availability |
| Billing | Invoices, payments, reimbursements |
| Messaging | Notifications, alerts, secure messaging |
| Learning | Courses, certifications, CME |
| AI | Summaries, recommendations, drafts |
| Analytics | Reporting, dashboards, aggregated metrics |

ADR-0014 established that Domain Events shall never cross platform boundaries. It did not
define what crosses instead.

This document establishes the inter-platform communication contract: what Integration
Events are, who produces and consumes them, how they are versioned, and the rules that
may never be violated.

---

## 1. Domain Events Are Internal

A Domain Event is a fact recorded by an Aggregate inside its own platform. It is the
internal signal that something changed.

**Domain Events are strictly internal to their originating platform.**

A Domain Event from the Clinical Platform carries Clinical domain concepts —
`ClinicalContributionId`, `CareRecordId`, `ContributionStatus`. These types are unknown
and meaningless outside the Clinical Platform.

Exposing a Domain Event across a platform boundary would couple the consuming platform
to the internal domain model of the producing platform. When the producing platform
refactors its domain model, every consuming platform breaks.

This is why ADR-0014 exists. It is not a bureaucratic rule. It is the architectural
protection of platform independence.

**Implementation:** deptrac enforces that no class from `Platforms\Clinical\Domain`
can be imported by any class outside `Platforms\Clinical`.

---

## 2. Integration Events Are Public

An Integration Event is the public contract through which platforms communicate.

| Property | Domain Event | Integration Event |
|---|---|---|
| Audience | Internal (same platform) | External (other platforms) |
| Language | Domain vocabulary | Shared vocabulary |
| Types | Domain types | Primitive types or shared value objects |
| Versioned | No | Yes — explicitly |
| Stable | No — evolves with domain | Yes — backward compatible |
| Location | `Platforms\X\Domain\` | `Platforms\X\Application\IntegrationEvent\` |

An Integration Event is produced by a platform from its Domain Events. It contains only:
- Primitive types (`string`, `int`, `bool`, `float`)
- `DateTimeImmutable` serialised to ISO 8601
- Shared Value Objects from `Shared\Domain\` (e.g., `Uuid`)

An Integration Event never contains domain-specific types from the producing platform.

---

## 3. Translation Layer

The translation from Domain Event to Integration Event is performed by an
**Integration Event Publisher** in the Infrastructure layer of the producing platform.

```
Domain Event (Clinical.Domain)
    ↓
Projector receives via event.bus
    ↓
IntegrationEventPublisher (Clinical.Infrastructure.IntegrationEvent)
    ↓
Translates to Integration Event (Clinical.Application.IntegrationEvent)
    ↓
Publishes to integration.bus (Shared.Infrastructure)
```

The `IntegrationEventPublisher` is a Projector. It subscribes to Domain Events and
produces Integration Events. It is the only component with the authority to translate
internal facts into public signals.

**The producing platform defines what is published. It never exposes its raw Domain Events.**

### Translation Example

```php
// Clinical.Infrastructure.IntegrationEvent
#[AsMessageHandler(bus: 'event.bus')]
final class ClinicalContributionValidatedPublisher
{
    public function __invoke(ClinicalContributionValidated $event): void
    {
        $this->integrationBus->dispatch(new ClinicalContributionValidatedIntegration(
            contributionId: $event->clinicalContributionId->value(),
            careRecordId: $event->careRecordId->value(),
            validatedAt: $event->occurredAt->value()->format(\DateTimeInterface::ATOM),
        ));
    }
}
```

```php
// Clinical.Application.IntegrationEvent.v1
final readonly class ClinicalContributionValidatedIntegration
{
    public function __construct(
        public string $contributionId, // primitive — not ClinicalContributionId
        public string $careRecordId,
        public string $validatedAt,    // ISO 8601 string — not ContributionTimestamp
        public string $version = 'v1',
    ) {}
}
```

---

## 4. Concept Ownership

Every business concept has exactly one authoritative platform — its **Owner**. All other
platforms are **consumers**.

The Owner:
- Persists the authoritative state of the concept
- Publishes Integration Events when that state changes
- Is the only platform that can modify the concept

A Consumer:
- Reads Integration Events published by the Owner
- Maintains its own local Projection of the concept (denormalised for its needs)
- Never reads directly from the Owner's database tables
- Never modifies the Owner's state — it requests changes via Commands through the API

### Ownership Table

| Concept | Owner Platform | Consumers |
|---|---|---|
| Practitioner | Identity | Clinical, Scheduling, Billing, Messaging, AI |
| Patient | Identity | Clinical, Scheduling, Billing, Messaging |
| Organisation | Identity | Clinical, Scheduling, Billing |
| CareRecord | Clinical | AI, Analytics |
| ClinicalContribution | Clinical | AI, Analytics |
| CarePlan | Clinical | Scheduling, AI |
| Appointment | Scheduling | Clinical, Billing, Messaging |
| TimeSlot | Scheduling | Clinical |
| Invoice | Billing | Clinical, Messaging |
| Payment | Billing | Clinical |
| Course | Learning | AI, Analytics |
| Notification | Messaging | — |

**Rule:** This table is the authoritative ownership register. Adding a new concept
requires updating this table in a new ADR or a revision of this document.

### Local Projections of Owned Concepts

When a platform consumes a concept it does not own, it maintains a **local Projection**
of that concept, populated from Integration Events.

Example: The Clinical Platform needs practitioner names to display in the timeline. It
does not query the Identity Platform's database. It maintains a local
`practitioner_local_projection` table, populated by an Integration Event Projector
that listens to `PractitionerRegisteredIntegration` and `PractitionerNameUpdatedIntegration`.

```
Identity Platform
    PractitionerRegistered (Domain Event)
        ↓
    PractitionerRegisteredIntegration (Integration Event)
        ↓ integration.bus ↓
Clinical Platform
    PractitionerLocalProjector
        ↓
    practitioner_local_projection table
        ↓
    PatientTimelineViewRepository uses JOIN to practitioner_local_projection
```

The local Projection is:
- Always disposable (rebuilt from Integration Events)
- Owned by the consuming platform (not the Identity Platform)
- Shaped for the consuming platform's needs (may contain fewer fields than the owner's full model)

---

## 5. Versioning

Integration Events are versioned independently of Domain Events.

### Version Format

Integration Events follow semantic versioning at the major level only:

```
ClinicalContributionValidatedIntegration v1
ClinicalContributionValidatedIntegration v2
```

Minor and patch versions do not exist for Integration Events. A change to the event
structure is either backward compatible (no version increment needed) or a breaking
change (major version increment required).

### Backward Compatible Changes (No Version Increment)

- Adding a new optional field (consumers that ignore unknown fields are unaffected)
- Adding a new Integration Event type (existing events are unchanged)
- Changing an internal field to a more precise type if the serialisation format is unchanged

### Breaking Changes (Require New Version)

- Removing a field
- Renaming a field
- Changing a field's serialisation format (e.g., date format change)
- Changing the semantic meaning of an existing field

### Version Coexistence

When a new version is published, **both versions are published simultaneously** for a
deprecation window.

```
ClinicalContributionValidated (Domain Event)
    ↓
IntegrationEventPublisher publishes:
    ├── ClinicalContributionValidatedIntegration v1 (deprecated)
    └── ClinicalContributionValidatedIntegration v2 (current)
```

Consumers that have migrated to v2 ignore v1. Consumers that have not yet migrated
continue processing v1.

The deprecation window is **90 days** from the publication of v2. After 90 days, v1 is
removed. All consumers must have migrated.

### Version Namespace

Integration Events are namespaced by version in their PHP class location:

```
src/Platforms/Clinical/Application/IntegrationEvent/
    v1/
        ClinicalContributionValidatedIntegration.php
    v2/
        ClinicalContributionValidatedIntegration.php
```

The version is also embedded in the event payload as a field (`'version' => 'v1'`) for
consumers that need to handle multiple versions in the same handler.

---

## 6. The Integration Bus

Integration Events travel on a dedicated bus: `integration.bus`.

This bus is separate from:
- `command.bus` — internal use cases
- `query.bus` — internal reads
- `event.bus` — internal Domain Events

The `integration.bus` is the only bus that may carry messages between platforms.

```yaml
# messenger.yaml
framework:
    messenger:
        buses:
            command.bus: ~
            query.bus: ~
            event.bus:
                default_middleware: allow_no_handlers
            integration.bus:
                default_middleware: allow_no_handlers
```

**A Domain Event SHALL NOT be dispatched on the `integration.bus`.**
**An Integration Event SHALL NOT be dispatched on the `event.bus`.**

This separation is enforced by type: Integration Events implement
`Shared\Application\IntegrationEvent\IntegrationEventInterface`. Domain Events do not.
The `integration.bus` routing is configured to accept only `IntegrationEventInterface`.

---

## 7. Rules That May Never Be Violated

### R-001 — No Platform Reads Another Platform's Database Tables

A platform SHALL NOT execute SQL queries against another platform's tables.

This includes:
- Direct DBAL queries against foreign tables
- Doctrine ORM relations across platform schemas
- Raw SQL JOINs between tables owned by different platforms
- Reading from a shared schema with tables belonging to multiple platforms

**Violation consequence:** Immediate architectural rejection. This rule has no exceptions.
It is the structural guarantee of platform independence.

### R-002 — No Domain Event Crosses a Platform Boundary

A Domain Event class from `Platforms\X\Domain` SHALL NOT be dispatched on the
`integration.bus` or consumed by a handler in `Platforms\Y`.

Enforced by deptrac and by the `integration.bus` type contract.

### R-003 — No API Call Between Platforms at Runtime

Platform-to-platform communication at runtime SHALL use the `integration.bus` only.

One platform SHALL NOT make synchronous HTTP calls to another platform's API to retrieve
data during a user request. All cross-platform data needed for read operations is
available in local Projections populated from Integration Events.

HTTP API calls between platforms are permitted for **Command propagation** (one platform
requesting a state change in another) but not for **Query propagation** (one platform
asking another for its current state).

### R-004 — Integration Events Are Immutable Once Published

A published Integration Event is a fact. Its `id`, `version`, `occurred_at`, and payload
are fixed at publication time. They may not be corrected, amended, or deleted after
publication.

If an incorrect event was published (e.g., wrong data), a corrective event must be
published. The original event remains in the outbox.

### R-005 — The Ownership Table Is Enforced

No platform writes to a concept it does not own.

If Platform A needs to modify a concept owned by Platform B, it sends a Command to
Platform B's API. Platform B decides whether to accept and executes the change.
Platform A waits for an Integration Event confirming the change.

### R-006 — Integration Events Must Be Versioned Before Their First Production Release

An Integration Event that has reached production cannot be modified without creating a
new version. The first production deployment of an Integration Event freezes its contract.

During development (before production), the event may be modified freely.

---

## 8. Monitoring

| Signal | Alert |
|---|---|
| `integration_bus_pending_count` | > 50 for > 5 minutes |
| `integration_bus_consumer_lag` | > 120 seconds |
| `integration_event_dead_count` | > 0 for > 30 minutes |
| Unknown Integration Event version | Immediate alert — consuming platform is behind |

---

## Relation to Other ADRs

| ADR | Relation |
|---|---|
| ADR-0014 — Domain Events Platform Boundary | This document defines what replaces Domain Events at platform boundaries |
| ADR-SA-010 — Reliable Event Delivery | Outbox applies to Integration Events too; Integration Events follow the same durability rules |
| ADR-SA-007 D-007 — Read Model Persistence | Local Projections of external concepts follow Read Model persistence rules |
| ADR-SA-009 D-005 — ViewRepository | Local Projections use DBAL + direct mapping like all Projections |

---

## Decision History

| Date | Decision |
|---|---|
| 2026-07-24 | ADR approved — Integration Event contract defined; ownership table established; integration.bus created; no cross-platform DB access enforced |
