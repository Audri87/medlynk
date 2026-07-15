# MedLink AI Engineering Constitution
Version: 2.0

> This document is the architectural contract for every AI working on MedLink.
> It defines how MedLink must be designed, not only how it must be coded.

## Reference Documents

| Document | Subject | Status |
|---|---|---|
| [Foundations](docs/FOUNDATIONS.md) | MedLink Founding Principles | Active |
| [Kernel Spec v0.3](docs/kernel/KERNEL-SPEC-v0.2.md) | Platform Kernel Foundation | Active |
| [ADR-0001](docs/adr/ADR-0001-platform-kernel.md) | Platform Kernel v0.1 — Organization → Context | Accepted |
| [ADR-0002](docs/adr/ADR-0002-business-platforms.md) | Business Platforms | Accepted |
| [ADR-0003](docs/adr/ADR-0003-hexagonal-architecture.md) | Hexagonal Architecture — Ports & Adapters | Accepted |
| [ADR-0004](docs/adr/ADR-0004-cqrs.md) | CQRS | Accepted |
| [ADR-0005](docs/adr/ADR-0005-business-events.md) | Business Events vs Domain Events | Accepted |
| [ADR-0006](docs/adr/ADR-0006-capability.md) | Capability as First-Class Architectural Concept | Accepted |
| [ADR-0007](docs/adr/ADR-0007-clinical-contribution-relationships.md) | Clinical Contribution Relationships — Roles on Relations | Accepted |
| [ADR-0008](docs/adr/ADR-0008-clinical-work-and-clinical-knowledge.md) | Clinical Work and Clinical Knowledge — Feedback Loop | Accepted |
| [ADR-0009](docs/adr/ADR-0009-encounter-placement.md) | Encounter — Removed from Clinical Domain | Accepted |
| [ADR-0010](docs/adr/ADR-0010-care-record.md) | Care Record — Domain Definition | Accepted |
| [ADR-0011](docs/adr/ADR-0011-progressive-adoption-strategy.md) | Progressive Adoption Strategy | Accepted |
| [ADR-0012](docs/adr/ADR-0012-patient-engagement-separation.md) | Clinical Platform / Patient Engagement — Bounded Contexts | Accepted |
| [WSP-001](docs/workspace/WSP-001-workspace.md) | Workspace — Definition and Principles | Accepted |
| [CAL-001](docs/clinical/CAL-001-clinical-activity-lifecycle.md) | Clinical Activity Lifecycle — 7 Phases | Accepted |
| [UL-001](docs/domain/UL-001-ubiquitous-language.md) | Ubiquitous Language Charter v2.0 — Registre officiel des concepts | Accepted |
| [CPP-001](docs/domain/CPP-001-cross-practitioner-principle.md) | Cross-Practitioner Principle — CPT Test | Accepted |
| [ADR-0013](docs/adr/ADR-0013-mission-driven-product-design.md) | Mission-Driven Product Design | Accepted |
| [ADR-0014](docs/adr/ADR-0014-domain-events-platform-boundary.md) | Domain Events Shall Never Cross Platform Boundaries | Accepted |
| [Discovery V1 Baseline](docs/DISCOVERY-V1-BASELINE.md) | Discovery V1 Baseline — Core Domain Accepted | Accepted |
| [DE-000](docs/process/DE-000-domain-engineering-charter.md) | Domain Engineering Charter | Active |
| [DE-P-001](docs/process/DE-P-001-human-reasoning-boundary.md) | Human Reasoning Is Outside the Domain | Accepted |
| [DE-P-002](docs/process/DE-P-002-clinical-reasoning-ownership.md) | Clinical Reasoning Belongs to the Practitioner | Accepted |
| [DE-P-011](docs/process/DE-P-011-aggregate-promotion-rule.md) | Aggregate Promotion Rule | Accepted |
| [DE-P-012](docs/process/DE-P-012-reference-scenario-coherence.md) | Reference Scenario Coherence | Accepted |
| [DE-P-013](docs/process/DE-P-013-scenario-falsification.md) | Scenario Falsification | Accepted |
| [DE-P-020](docs/process/DE-P-020-modelling-defaults.md) | Modelling Defaults — Six Session Rules | Accepted |
| [DE Baseline V1](docs/DE-BASELINE-V1.md) | Domain Engineering Baseline V1 — ES-001→ES-004 Frozen | Accepted |
| [DE Aggregate Map V1](docs/process/DE-AGGREGATE-MAP-V1.md) | Aggregate Discovery — Current State | Active |
| [DR-001](docs/DR-001-decision-register-v1.md) | Decision Register V1 — All Frozen Domain Decisions | Active |
| [HR-001](docs/HR-001-hotspot-register-v1.md) | Hotspot Register V1 — All Unresolved Domain Questions | Active |
| [ADR-SA-005](docs/architecture/ADR-SA-005-application-cqrs-decisions.md) | **Architectural Decision Register** — Application & CQRS Architecture — Approved decisions (D-001→D-009) · Normative basis for SA-005 · ADR = approved rationale / SA = normative rules | Approved |

---

# Mission

MedLink is not a medical software.

MedLink is a platform that organizes the work of healthcare actors.

**Core mission:** Réduire l'effort cognitif nécessaire pour comprendre une situation clinique, afin que les praticiens puissent consacrer leur énergie au raisonnement, à la décision et à la relation avec leurs patients.

The first platform implemented is Clinical.

Future platforms include:
- Learning
- Conference
- Community
- Research
- AI
- Marketplace

The Platform Kernel must remain independent of every business domain.

---

# Core Principle

Think Platform First.

Build Clinical First.

Never confuse both.

---

# Product Governance

MedLink follows **Mission-Driven Product Design**.

Features are never planned directly.

Each feature must implement a Mission.

Each Mission must be traceable to:

- a field observation,
- or a validated domain invariant.

The MVP is defined by Missions, not by features.

---

# Platform Layers

```
Platform Kernel
    ↓
Business Platforms
    ↓
Domain Contexts
    ↓
Capabilities
    ↓
Workspaces
```

---

# Platform Kernel

The Kernel must remain domain agnostic.

Current Kernel concepts:
- Actor
- Organization
- Domain Context
- Work Context
- Interaction
- Business Event

The Kernel must NOT know:
- Patient
- Practitioner
- Care Record
- Prescription
- Conference
- Video
- Learning

Those belong to business platforms.

---

# Identity

Identity is managed by the Identity Platform.

The Kernel only references actors.

An Identity may represent:
- Human
- AI
- External System
- Connected Device

Every Identity may become an Actor.

---

# Actor

Definition:

An Actor is any entity capable of interacting inside a Context.

Never create: MedicalActor, PatientActor, DoctorActor, NurseActor.

Instead: Actor inside Clinical Context.

---

# Organization

Organizations represent execution environments.

Examples: Hospital, Clinic, Private Practice, University, Scientific Society, Laboratory.

Organizations define: permissions, governance, membership.

They never contain business logic.

---

# Domain Context

Examples: Clinical, Learning, Conference, Community, Research, Marketplace.

New Domain Contexts must be addable without modifying the Kernel.

---

# Work Context

Work Context represents the current work scope.

Examples:

```
Clinical        → Encounter, Discussion, Mission
Learning        → Course, Quiz
Conference      → Session, Speaker Room
Community       → Group, Discussion, Topic
```

Work Context belongs to a Domain Context.

---

# Business Events

Business Events are immutable.

They represent facts.

Examples:
- EncounterCreated
- LabResultReceived
- DiscussionStarted
- VideoPublished
- QuizCompleted

Never persist business projections as source of truth.

Business Events are the source of truth.

---

# Projections

Everything displayed to the user is considered a Projection.

Examples: Workspace, Dashboard, Timeline, Journey, Notifications, Next Actions, Progress.

Projections are disposable.

Never embed business logic inside projections.

---

# Clinical Platform

The Clinical Platform is the first MedLink implementation.

It contains concepts such as:
- Care Record
- Encounter
- Observation
- Prescription
- Treatment
- Consent
- Care Team

These concepts DO NOT belong to the Platform Kernel.

---

# Care Record

Care Record is Clinical Memory.

Responsibilities:
- Store clinical information
- Store history
- Store observations
- Store prescriptions
- Store attachments
- Store results

Care Record never orchestrates workflows.

---

# Workspace Engine

Workspace = Projection

Generated from: Actor + Organization + Domain Context + Work Context.

Never manually build workspaces.

Always compute them.

---

# Context Engine

The Context Engine determines:
- Visible information
- Capabilities
- Recommendations
- Notifications
- Priorities

The Context Engine never stores business data.

---

# AI Principles

AI assists. AI prepares. AI summarizes. AI recommends. AI highlights.

AI never owns clinical decisions.

The practitioner remains responsible.

---

# Extension Principle

Never modify the Platform Kernel for a business feature.

Instead: Create a new Platform or Create an Extension.

---

# Development Principles

- Prefer composition.
- Prefer explicit domain models.
- Prefer CQRS.
- Prefer Event-driven architecture.
- Keep Aggregates small.
- Avoid God Objects.
- Avoid Framework-driven design.
- Business before technology.

---

# Before Implementing Anything

Always answer:

1. Which Platform?
2. Which Domain Context?
3. Which Work Context?
4. Which Actor?
5. Which Interaction?
6. Which Business Event?
7. Could this be a Projection?
8. Does this belong to the Kernel?

If uncertain — DO NOT modify the Kernel.

---

# MedLink Vision

The goal of MedLink is not to digitize healthcare.

The goal of MedLink is to organize the work of healthcare actors.

The software should prepare work.

Humans make decisions.

The patient always remains the final beneficiary.

---

# Long-Term Rule

The Platform Kernel should still be valid in twenty years.

Every architectural decision must protect that objective.

---

---

# Technical Implementation

> The following section defines how the Constitution is implemented with the chosen stack.
> The Constitution always takes precedence over technical decisions.

---

## Stack

| Layer | Choice |
|---|---|
| Language | PHP 8.4+ |
| Framework | Symfony 7.4 |
| ORM | Doctrine ORM |
| Database | PostgreSQL 17 |
| Command/Query/Event Bus | Symfony Messenger |
| Real-time | Mercure |
| API | API Platform 4 |
| Frontend | Symfony UX + Turbo + Live Components |
| Containerisation | Docker |
| Hosting | HDS certified (OVH Health, Scaleway, Outscale) |

---

## Architecture Pattern

- **Modular Monolith** — one deployable unit, independent modules
- **DDD** — domain model drives all technical decisions
- **CQRS** — strict separation of writes (Commands) and reads (Queries)
- **Domain Events** — every state change produces an event that feeds projections
- **No full Event Sourcing** — aggregates persisted in DB; events feed projections

---

## Project Structure

```
src/
├── Kernel/                      # Platform Kernel — Actor, Context, Interaction, BusinessEvent
│   ├── Domain/
│   │   └── BusinessEvent.php    # Kernel concept — immutable business fact
│   ├── Application/
│   └── Infrastructure/
│
├── Platforms/                   # Business Platforms
│   ├── Clinical/                # Clinical Platform (MVP — 6 months)
│   │   ├── Domain/
│   │   ├── Application/
│   │   ├── Infrastructure/
│   │   └── UI/
│   ├── Collaboration/           # Collaboration Platform
│   ├── Trust/                   # Trust Platform — consent, compliance, traceability
│   ├── Identity/                # Identity Platform
│   ├── Learning/                # Future
│   └── Conference/              # Future
│
├── Shared/                      # Cross-platform infrastructure
│   ├── Domain/
│   │   ├── Event/
│   │   ├── ValueObject/
│   │   └── Exception/
│   ├── Application/
│   │   └── Event/
│   │       └── DomainEvent.php  # Technical event — NOT a Kernel concept
│   └── Infrastructure/
│       └── Messenger/
│           └── EventBus.php
│
└── Workspace/                   # Workspace Engine — projection generator
    ├── Domain/
    ├── Application/
    └── Infrastructure/
```

## BusinessEvent vs DomainEvent

Critical distinction:

| Concept | Location | Nature |
|---|---|---|
| `BusinessEvent` | `Kernel/Domain/` | Business concept — what happened in the domain |
| `DomainEvent` | `Shared/Application/Event/` | Technical concept — carries the event through the bus |

Never introduce `DomainEvent` as a Kernel concept.
Never use `BusinessEvent` as a technical transport mechanism.

---

## Messenger — Bus Configuration

```yaml
framework:
    messenger:
        buses:
            command.bus:
                middleware:
                    - doctrine_transaction
            query.bus: ~
            event.bus:
                default_middleware: allow_no_handlers
```

Routing:
- `Command` → `command.bus` → synchronous
- `Query` → `query.bus` → synchronous
- `DomainEvent` → `event.bus` → projection handlers

---

## API Platform

HTTP layer only. Resources are DTOs, not Doctrine entities.

```
GET  /api/v1/patients/{id}/timeline  → Query → Read Model
POST /api/v1/encounters              → Command → Aggregate
```

- **State Provider** → dispatches a Query
- **State Processor** → dispatches a Command

Versioning prefix: `/api/v1/` from day one.

---

## PostgreSQL Conventions

- UUID v4 for all primary identifiers (`gen_random_uuid()`)
- `TIMESTAMPTZ` for all dates (never `TIMESTAMP`)
- `JSONB` for flexible data (payload, metadata, context)
- Soft delete: `deleted_at TIMESTAMPTZ` (never `DELETE`)
- All tables have `created_at` and `updated_at`

### Key tables

| Table | Fed by |
|---|---|
| `domain_events` | All aggregates |
| `patient_timeline` | All patient events |
| `workflow_items` | Agenda + missions + results |
| `ai_briefings` | Pre-computed AI summaries |

### Local dev connection

```
DATABASE_URL=postgresql://gayino@127.0.0.1:5432/medlink?serverVersion=17&charset=utf8
```

---

## Domain Events — Naming Convention

Pattern: `{Aggregate}{PastTense}`

```
EncounterStarted
EncounterCompleted
PrescriptionSigned
LabResultReceived
MissionAccepted
MissionCompleted
AppointmentBooked
```

Each event is immutable and contains only data needed for projections.

---

## Mercure — Real-time Topics

```
/clinical/patients/{patientId}/timeline
/clinical/practitioners/{practitionerId}/workflow
/clinical/missions/{missionId}
```

---

## Security

- JWT for the API (stateless)
- Sessions for internal web interfaces
- An actor only sees resources from their organization (or explicitly shared)
- Each resource checked via a Symfony Voter
- **HDS hosting is mandatory in production**

---

## Module Rules (Modular Monolith)

1. A module never imports a class from another module directly
2. Communication goes through the `event.bus` only
3. Each module owns its own tables — no cross-module joins
4. `Shared/` is the only exception: shared Value Objects and interfaces

---

## Tests

### Strategy

- **Unit** — pure domain: aggregates, value objects, events
- **Integration** — handlers, projections, real database
- **Functional** — API Platform endpoints

### Rules

- Domain tests never touch the database
- Integration tests use a dedicated test database (never mock the database)
- No aggregate mocks

### Commands

```bash
php bin/phpunit                      # all tests
php bin/phpunit tests/Domain/        # domain only
php bin/phpunit tests/Integration/   # integration
```

---

## Deployment

- HDS certified hosting mandatory
- PostgreSQL 17 — PHP 8.4 FPM + Nginx — Mercure Hub (caddy)
- Sensitive variables via Symfony secrets (never in committed `.env`)
- Migrations run before each deployment (`doctrine:migrations:migrate --no-interaction`)
