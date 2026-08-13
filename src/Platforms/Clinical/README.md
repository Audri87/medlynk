# Clinical Platform — ClinicalContribution Bounded Context

**PR**: PR-001 — Project Skeleton (RVS-001)
**Status**: Skeleton — no business logic implemented

---

## Purpose

This directory contains the implementation skeleton for the `ClinicalContribution`
Bounded Context of the Clinical Platform, as specified in RVS-001.

It validates that SA-001 through SA-007 naturally translate into a PHP project structure.

---

## Structure

```
Clinical/
│
├── Domain/
│   └── ClinicalContribution/         ← Aggregate Root, Entities, Value Objects, Events
│       ├── ClinicalContribution      ← Aggregate Root (lifecycle enforcer)
│       ├── ClinicalContent           ← Entity (clinical payload)
│       ├── ContributorRole           ← Entity (role on relation — ADR-0007)
│       ├── ValueObject/              ← 8 immutable value types
│       └── Event/                    ← 4 domain facts
│
├── Application/
│   ├── Command/                      ← 3 write intents
│   ├── CommandHandler/               ← 3 transaction owners
│   ├── Query/                        ← 2 read intents
│   ├── QueryHandler/                 ← 2 read-model accessors
│   ├── Port/                         ← 3 contracts (1 repository + 2 read models)
│   ├── ReadModel/                    ← 3 query result shapes + Workspace view
│   ├── WorkspaceAssembler            ← Workspace assembly service
│   └── ClinicalContributionFacade   ← Single entry point
│
└── Infrastructure/
    ├── Api/
    │   ├── Resource/                 ← HTTP wire format
    │   ├── StateProcessor/           ← Command dispatcher (write)
    │   └── StateProvider/            ← Query dispatcher (read)
    └── Persistence/
        ├── Repository/               ← Aggregate persistence implementation
        ├── ReadModel/                ← Read model store accessors
        └── Projection/               ← Read model maintainers (incl. WorkspaceProjection)
```

---

## Dependency Rules

The following rules are non-negotiable and must be verifiable by static analysis.

### Allowed

| From | To |
|---|---|
| Domain | Domain (within this Bounded Context) |
| Application | Domain |
| Application | Shared |
| Infrastructure | Application Ports |
| Infrastructure | Domain |
| Presentation (Api/) | Application Facade |

### Forbidden

| From | To | Violation |
|---|---|---|
| Domain | Application | SA-001 SA-P-005 |
| Domain | Infrastructure | SA-001 SA-P-005 |
| Domain | Persistence annotations | SA-007 I-015, I-016 |
| Application | Repository implementation | SA-003 §5 |
| Application | Storage technology | SA-007 I-015 |
| Query Handler | ClinicalContributionRepositoryPort | SA-007 I-012 |
| Repository | Domain Event bus | SA-007 I-003, I-004 |
| Projection | ClinicalContributionRepositoryPort | SA-007 I-011 |
| Projection | Another Projection | SA-006 §12.2 |
| Presentation | Domain | SA-007 §15.2 |
| Presentation | Infrastructure | SA-007 §15.2 |

---

## Implementation Status

| Component | Status |
|---|---|
| Value Objects (8) | Skeleton — no validation logic |
| Domain Events (4) | Skeleton — shapes declared |
| Aggregate Root | Skeleton — operations stubbed |
| Entities (2) | Skeleton — fields declared |
| Ports (3) | Complete — method signatures are the contract |
| Commands (3) | Complete — data shapes are the contract |
| Queries (2) | Complete — data shapes are the contract |
| Read Model DTOs (3) | Complete — shapes declared |
| Command Handlers (3) | Skeleton — dependencies declared, logic pending |
| Query Handlers (2) | Skeleton — dependencies declared, logic pending |
| Facade | Complete — dispatch logic only |
| Repository Implementation | Skeleton — interface fulfilled, logic pending |
| Read Model Implementations (2) | Skeleton — interface fulfilled, logic pending |
| Projections (2) | Skeleton — event handlers stubbed |

---

## Next PR

**PR-002** will implement:

1. Value Object validation (all 8).
2. Aggregate Root business operations (`create`, `validate`, `approve`).
3. Domain unit tests.

Business logic is intentionally absent from PR-001.
