# SA-001 — MedLink Reference Architecture

**Document ID**: SA-001
**Title**: MedLink Reference Architecture
**Status**: Release v1.1
**Version**: 1.1

**Depends on**:

- Discovery v1.0
- Domain Engineering v1.0
- Strategic Design v1.0

---

## 1. Purpose

### 1.1 Objective

The purpose of this document is to define the Reference Software Architecture of the MedLink Platform.

It establishes the architectural principles governing all software implementations.

This document translates the certified Domain Engineering and Strategic Design into software architecture.

It does not redefine business concepts, ownership or bounded contexts.

### 1.2 Scope

This document applies to every MedLink Platform and every software component developed within the MedLink ecosystem.

Future platforms shall conform to these architectural principles.

---

## 2. Architectural Vision

MedLink adopts a Platform-Driven Modular Monolith architecture.

Business architecture drives software architecture.

Software architecture drives implementation.

Frameworks and technologies exist only to execute the architecture.

---

## 3. Architectural Principles

### SA-P-001 — Business Drives Software

Software structure shall reflect certified business ownership.

Business decisions always precede technical decisions.

---

### SA-P-002 — One Bounded Context = One Software Module

Each Core Bounded Context shall be implemented as an autonomous software module.

A module owns:

- Domain
- Application
- Infrastructure
- Presentation

Business ownership shall never be duplicated.

---

### SA-P-003 — Single Source of Truth

Every business concept has one and only one owner.

No duplicate ownership is permitted.

---

### SA-P-004 — Explicit Collaboration

Modules collaborate only through explicit contracts.

Permitted mechanisms include:

- Domain Events
- Application Ports
- Anti-Corruption Layers

Direct access to another module's internal implementation is prohibited.

---

### SA-P-005 — Dependency Direction

Software dependencies always point toward business ownership.

- Infrastructure depends on Domain abstractions.
- Presentation depends on Application.
- Application depends on Domain.

The Domain layer shall never depend on infrastructure or frameworks.

---

### SA-P-006 — Framework Independence

Business rules remain independent from frameworks and infrastructure technologies.

Symfony, Doctrine, Messenger and other technologies are implementation details.

---

### SA-P-007 — Composable User Experience

The user experience is composed from reusable Business Widgets.

Widgets compose presentation.

Widgets never own business rules.

---

### SA-P-008 — Technology Pragmatism

Technology choices prioritise:

- maintainability;
- architectural consistency;
- delivery speed;
- team expertise;
- long-term evolvability.

Technologies remain replaceable.

---

### SA-P-009 — Convention over Configuration

Architectural consistency relies primarily on shared conventions rather than custom configuration.

---

### SA-P-0010 — Single Architectural Responsibility

Every architectural component SHALL own one and only one architectural responsibility.

Responsibilities SHALL NOT overlap.

Architectural boundaries exist to protect responsibilities rather than technologies.

---

## 4. Reference Architecture

```
                    Business Architecture
                            │
                            ▼
                 MedLink Reference Architecture
                            │
                            ▼
                        Platform
                            │
                            ▼
                    Bounded Context
                            │
        ┌───────────────────┼───────────────────┐
        ▼                   ▼                   ▲
 Presentation        Application           Infrastructure
                            │                   │
                            ▼                   │
                          Domain ◄──────────────┘
```

Dependency direction always points toward the Domain.

Infrastructure implements Domain contracts.

---

## 5. Read and Write Model

The architecture distinguishes write responsibilities from read responsibilities.

### Write Flow

```
Clinical Work
        │
        ▼
Clinical Knowledge
```

### Read Flow

```
Clinical Knowledge
        │
Published Domain Events
        │
        ▼
Read Models
        │
        ▼
Workspace
        │
        ▼
Business Widgets
```

Read Models exist to optimise information access.

They never own business rules.

---

## 6. Architectural Building Blocks

The MedLink Reference Architecture is composed of the following building blocks.

| Building Block | Responsibility |
|---|---|
| Platform | Encapsulates a complete business ecosystem |
| Bounded Context | Owns business responsibilities |
| Domain | Owns business rules |
| Application | Implements use cases |
| Infrastructure | Implements technical adapters |
| Presentation | Exposes user interactions |
| Workspace | Composes the user experience |
| Business Widget | Reusable presentation component |
| Shared Kernel | Explicitly shared concepts |
| Integration Component | External communication |

---

## 7. Dependency Rules

Dependencies shall follow certified ownership boundaries.

The following rules apply:

- Presentation depends on Application.
- Application depends on Domain.
- Infrastructure implements Domain contracts.
- Direct Domain-to-Domain dependencies are prohibited.
- Modules collaborate only through explicit contracts.
- Read Models are read-only projections.
- Business ownership remains isolated.

---

## 8. Quality Attributes

The architecture prioritises:

- Maintainability
- Modularity
- Evolvability
- Testability
- Traceability
- Framework Independence
- Business Alignment

---

## 9. Evolution Principles

Architecture evolves through extension rather than modification.

New software capabilities should extend existing architectural building blocks whenever possible.

New Bounded Contexts or Platforms are introduced only after Domain Discovery and Strategic Design.

---

## 10. References

- Discovery v1.0
- Domain Engineering v1.0
- Strategic Design v1.0
- ADR-0003 — Hexagonal Architecture
- ADR-0004 — CQRS

---

## 11. Open Decisions

None.

All architectural decisions defined by this document are certified for Release v1.0.

---

## 12. Change Log

| Version | Status | Description |
|---|---|---|
| 1.0 | Release | First certified reference architecture |
| 1.1 | Release | Added SA-P-0010 — Single Architectural Responsibility |
