# SA-002 — Platform Architecture

**Status**: Release v1.0
**Version**: 1.0

**Depends on**:

- SA-001 — Reference Architecture
- SD-005 — Strategic Design Baseline

---

## 1. Purpose

### 1.1 Objective

Define the Platform as the primary software building block of the MedLink Architecture.

This document specifies:

- what a Platform is;
- what a Platform owns;
- how Platforms collaborate;
- how Platforms evolve.

It does not define Symfony implementation details.

---

## 2. Platform Definition

### SA-PL-001 — Platform as a First-Class Architectural Building Block

A Platform is the highest architectural building block of MedLink.

A Platform encapsulates one coherent business ecosystem.

It owns:

- one or more Bounded Contexts;
- one user experience;
- one integration boundary;
- one published contract.

A Platform is not:

- a Symfony Bundle;
- a Composer package;
- a deployment unit;
- a namespace.

### SA-PL-002 — Business Ownership

Business ownership belongs to Bounded Contexts.

A Platform groups related Bounded Contexts into a coherent business ecosystem.

---

## 3. Platform Building Blocks

Every Platform is composed of the following architectural building blocks.

```
Platform
│
├── Bounded Contexts
├── UI
├── Integration
├── Manifest
└── Contract
```

### 3.1 Bounded Contexts

Own business responsibilities.

**Example**

```
Clinical
    └── Work
    └── Knowledge
```

### 3.2 UI

Owns the platform user experience.

```
UI
    └── Workspace
    └── Widgets
```

The UI never owns business rules.

Each Platform owns its Workspace and Widgets.

The Design System is not owned by any Platform. It is a shared architectural component providing visual consistency across all Platforms. It supplies reusable UI primitives only. See Section 4.

### 3.3 Integration

Owns all communication outside the Platform.

**Examples**

- FHIR
- HL7
- External REST APIs
- External messaging
- Anti-Corruption Layers

Integration does not own business rules.

### 3.4 Platform Manifest

Every Platform exposes metadata describing itself.

**Illustrative example** *(concrete format is an Open Decision — see OD-001)*

```
platform:
  id: clinical
  version: 1.0

bounded_contexts:
  - work
  - knowledge

dependencies:
  - identity
```

The Manifest is descriptive only.

### 3.5 Platform Contract

Every Platform publishes an explicit contract.

The Contract defines:

- published Application Facades;
- published Command/Query DTO contracts;
- published Integration Events;
- supported integrations.

**Application Facades** are stable public interfaces that wrap internal Application Services. Internal Application Services remain private to the Platform and are never exported.

**Command/Query DTO contracts** define the data structures accepted and returned by the Platform. They are stable across Platform versions.

**Integration Events** are purpose-built for cross-Platform communication. They carry only the information required by external consumers. They are derived from Domain Events but are not Domain Events.

Only stable public contracts are exposed. Internal implementation details — Domain Models, Application Services, Domain Events, Aggregates — remain private.

Other Platforms depend only on this contract.

They never depend on internal implementation.

---

## 4. Internal Organization

**Reference structure** *(file names are technology-neutral — concrete format is an Open Decision, see OD-001)*

```
Platform/
    Clinical/
        platform.manifest
        platform.contract
        Work/
        Knowledge/
        UI/
            Workspace/
            Widgets/
        Integration/

Shared/
    DesignSystem/        ← shared across all Platforms, not owned by any single Platform
```

The Design System is a shared architectural component. It provides reusable UI primitives (tokens, base components, layout rules) that ensure visual consistency across all Platforms.

Platforms consume the Design System. They do not own it.

---

## 5. Platform Collaboration

### 5.1 Collaboration Principle

Platforms collaborate only through published contracts.

### 5.2 Intra-Platform Communication

Within a Platform, Bounded Contexts communicate through Domain Events.

Domain Events never leave their Platform boundary.

| Mechanism | Scope |
|---|---|
| Domain Events | Internal — between Bounded Contexts within the same Platform |
| Application Contracts | Internal — between Application layers within the same Platform |

### 5.3 Cross-Platform Communication

Platforms communicate exclusively through Integration Events published via the Platform Contract.

Integration Events are derived from Domain Events but are not Domain Events.

| Mechanism | Scope |
|---|---|
| Integration Events | External — published via Platform Contract, consumed by other Platforms |
| Anti-Corruption Layers | External — translation boundary for incoming Integration Events |

### 5.4 Domain Event vs Integration Event

| | Domain Event | Integration Event |
|---|---|---|
| Scope | Internal to the Platform | Published via Platform Contract |
| Model | Reflects internal Domain Model | Stable public representation |
| Coupling | Strong — exposes Domain internals | Weak — decoupled from Domain |
| Owner | Bounded Context | Platform Contract |
| Consumer | Other BCs within the same Platform | Other Platforms |

A Domain Event shall never be published outside the Platform boundary.

An Integration Event is produced by the Integration layer from a Domain Event. It carries only the information required by external consumers.

### 5.5 Forbidden

- direct Domain access;
- shared repositories;
- shared aggregates;
- shared persistence;
- exposing Domain Events outside the Platform boundary.

---

## 6. Dependency Rules

**Rule 1**

A Platform owns its implementation.

**Rule 2**

Business ownership remains inside Bounded Contexts.

**Rule 3**

UI depends on Bounded Context Application Services.

**Rule 4**

Integration communicates only through explicit contracts.

**Rule 5**

A Platform never accesses another Platform's internal implementation.

**Rule 6**

A Platform may evolve internally provided its published contract remains stable.

---

## 7. Platform Boundary

```
+----------------------------------------------------+
|                  Clinical Platform                  |
+----------------------------------------------------+
|  Clinical Work   --[Domain Events]-->               |
|  Clinical Knowledge                                 |
|  UI                                                 |
|  Integration     --[produces Integration Events]--> |
+----------------------------------------------------+
|         Published Contract                          |
|  - Application Facades                              |
|  - Command/Query DTO contracts                      |
|  - Integration Events                               |
+----------------------------------------------------+
              ↑                        ↑
     Other Platforms         Anti-Corruption Layers
     consume only            translate incoming
     this layer              Integration Events

Domain Events never cross the Platform boundary.
Internal Application Services remain private to the Platform.
Only stable public contracts are exposed.
```

---

## 8. Ownership Matrix

| Artifact | Owner | Visibility |
|---|---|---|
| Platform | Architecture | Internal |
| Business Capability | Bounded Context | Internal |
| Aggregate | Bounded Context | Internal |
| Domain Model | Bounded Context | Internal |
| Application Service | Bounded Context | Internal |
| Domain Event | Bounded Context | Internal — never crosses Platform boundary |
| UI | Platform | Internal |
| Workspace | Platform UI | Internal |
| Widget | Platform UI | Internal |
| Design System | Shared | Shared — consumed by all Platforms, not owned by any |
| Integration | Platform | Internal |
| Manifest | Platform | Public — descriptive metadata |
| Contract | Platform | Public — sole external surface |
| Application Facade | Platform Contract | Public — wraps internal Application Services |
| Command/Query DTO | Platform Contract | Public — stable data structures |
| Integration Event | Platform Contract | Public — cross-Platform events only |

---

## 9. Platform Lifecycle

```
Create
  ↓
Register
  ↓
Configure
  ↓
Activate
  ↓
Run
  ↓
Evolve
  ↓
Suspend
  ↓
Retire
```

---

## 10. Platform Registry

The Kernel maintains the Platform Registry.

**Responsibilities**:

- discover Platforms;
- load Manifests;
- expose Contracts;
- register Platform metadata.

Platforms never discover each other directly.

---

## 11. Architectural Rules

- A Platform owns one business ecosystem.
- A Platform owns one user experience.
- Business ownership belongs to Bounded Contexts.
- UI belongs to the Platform.
- Integration belongs to the Platform.
- Platforms collaborate only through Contracts.
- Internal implementation is private.
- Platforms evolve independently.
- Domain Events remain internal to their Platform.
- Integration Events are the only permitted cross-Platform event mechanism.
- Integration Events are published through the Platform Contract.
- A Domain Event shall never cross a Platform boundary.

---

## 12. Open Decisions

| ID | Decision | Status |
|---|---|---|
| OD-001 | Manifest format (YAML vs PHP) | Open |
| OD-002 | Platform discovery mechanism | Open |
| OD-003 | CLI generation (`medlink:make:platform`) | Deferred |
| OD-004 | Platform versioning strategy | Deferred |

---

## 13. References

- SA-001 — Reference Architecture
- SD-003 — Bounded Context Definition
- SD-004 — Context Map
- SD-005 — Strategic Design Baseline
