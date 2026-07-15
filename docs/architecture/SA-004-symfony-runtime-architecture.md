# SA-004 — Symfony Runtime Architecture

**Document ID**: SA-004
**Title**: Symfony Runtime Architecture
**Status**: Release v1.0
**Version**: 1.0

**Depends on**:

- SA-001 — Reference Architecture (Release v1.0)
- SA-002 — Platform Architecture (Release v1.0)
- SA-003 — Bounded Context Architecture (Release v1.0)

**Closes**:

- SA-002 OD-001 — Platform Manifest format
- SA-002 OD-002 — Platform discovery mechanism

---

## 1. Purpose

### 1.1 Objective

This document defines how the Symfony framework implements the MedLink Software Architecture.

It answers one question:

> How does Symfony implement the MedLink architecture?

It defines:

- the Symfony runtime principles;
- the responsibilities of the Symfony Kernel;
- how Platforms are discovered and registered;
- how services are organized and wired;
- how the runtime module structure maps to SA-002 and SA-003;
- the configuration and routing strategies;
- the runtime dependency rules.

### 1.2 What this document does not define

- CQRS patterns and bus configuration → SA-005
- Domain Event and Integration Event infrastructure → SA-006
- Persistence and Doctrine configuration → SA-007
- Business Widget Framework → SA-008
- Workspace Composition → SA-009

### 1.3 Relationship to the certified architecture

Symfony is the **runtime** of the MedLink architecture.

It does not define the architecture.

Every architectural decision made in SA-001, SA-002, and SA-003 takes precedence over Symfony defaults, conventions, and recommendations.

---

## 2. Runtime Principles

### RT-P-001 — Framework as Tool

Symfony is a tool that executes the architecture.

Architectural decisions are never delegated to Symfony.

If a Symfony default conflicts with a certified architectural rule, the architectural rule prevails.

### RT-P-002 — Layered Symfony Exposure

Symfony dependencies are permitted only in Infrastructure and Presentation.

| Layer | Symfony dependency |
|---|---|
| Domain | Prohibited |
| Application | Prohibited |
| Infrastructure | Permitted |
| Presentation | Permitted |

### RT-P-003 — Platform ≠ Bundle

A MedLink Platform is not a Symfony Bundle.

Symfony Bundles are used exclusively for third-party library integration (API Platform, Doctrine, Mercure, etc.).

MedLink Platforms and Bounded Contexts are registered via the Platform Registration mechanism defined in Section 4.

### RT-P-004 — Symfony Kernel ≠ MedLink Platform Kernel

These are two distinct concepts.

| | Symfony Kernel | MedLink Platform Kernel |
|---|---|---|
| Nature | PHP class — boots the Symfony framework | Architectural concept — owns Actor, Organization, Context |
| Location | `src/Kernel.php` | `src/Kernel/` |
| Responsibility | DI container, Bundle loading, request handling | Platform Registry, domain-agnostic concepts |
| Knows about Platforms? | Only through service registration | Conceptually owns the Platform Registry |

The Symfony Kernel must never be confused with the MedLink Platform Kernel.

### RT-P-005 — Convention over Custom Infrastructure

Where Symfony conventions satisfy the architecture, use them.

Custom infrastructure is introduced only when Symfony conventions conflict with architectural rules.

### RT-P-006 — Deptrac as Architectural Guard

All dependency rules defined in SA-003 are enforced at the code level by Deptrac.

Static analysis tools are the automated enforcement mechanism for architectural compliance.

---

## 3. Symfony Kernel Responsibilities

The Symfony Kernel (`src/Kernel.php`) has the following responsibilities.

**It SHALL:**

- boot the Symfony DI container;
- load third-party Bundles (API Platform, Doctrine ORM, Mercure, Symfony UX, etc.);
- trigger Platform registration via the Platform Registration mechanism (Section 4);
- load environment-specific configuration;
- configure routing.

**It SHALL NOT:**

- contain business logic;
- directly reference MedLink Domain concepts (Patient, Practitioner, ClinicalActivity, etc.);
- own the MedLink Platform Registry (that belongs to the Platform Kernel service).

### Symfony Bundles loaded by the Kernel

Only third-party Bundles are registered as Symfony Bundles.

| Bundle | Purpose |
|---|---|
| FrameworkBundle | Core Symfony HTTP, Router, DI |
| DoctrineBundle | ORM integration |
| ApiPlatformBundle | API exposure |
| MercureBundle | Real-time |
| TwigBundle | Templating |
| SecurityBundle | Authentication and authorisation |
| MessengerBundle | Message bus (Command, Query, Event buses) |
| UxBundle | Symfony UX / Live Components |

MedLink Platforms are not listed here. They are registered separately (Section 4).

---

## 4. Platform Discovery and Registration

### 4.1 Closing SA-002 OD-001 — Platform Manifest Format

The Platform Manifest format is **YAML**.

Every Platform provides a `platform.manifest.yaml` file at its root.

```yaml
# platform.manifest.yaml — illustrative
platform:
  id: clinical
  version: 1.0
  label: Clinical Platform

bounded_contexts:
  - id: work
    label: Clinical Work
  - id: knowledge
    label: Clinical Knowledge

dependencies:
  - identity
```

The Manifest is descriptive metadata only.

It is loaded by the Platform Registry at boot. It never contains business logic or service definitions.

### 4.2 Closing SA-002 OD-002 — Platform Discovery Mechanism

Each Platform provides a **Platform Registrar** — a PHP class implementing `PlatformRegistrarInterface`.

```
src/
└── Kernel/
    └── Platform/
        └── PlatformRegistrarInterface.php
```

The interface defines two responsibilities:

- `manifest()` — returns the path to `platform.manifest.yaml`;
- `register(ContainerBuilder $container)` — registers the Platform's services into the DI container.

> **Note** — `PlatformRegistrarInterface` is a Symfony runtime integration contract. Although located under `src/Kernel/Platform/`, it is intentionally coupled to the Symfony `ContainerBuilder` and is not part of the business architecture. It belongs to the runtime integration layer of the MedLink Platform Kernel — not to the domain-agnostic Kernel concepts (Actor, Organization, Context). Symfony coupling at this interface is expected and deliberate.

The Symfony Kernel iterates over all registered Platform Registrars at compile time and delegates service registration to each one.

```
config/
└── platforms.php    ← lists all active PlatformRegistrar classes
```

**Illustrative example — `config/platforms.php`**:

```php
// config/platforms.php
return [
    \MedLink\Platforms\Clinical\ClinicalPlatformRegistrar::class,
    \MedLink\Platforms\Identity\IdentityPlatformRegistrar::class,
];
```

Each entry is a fully-qualified class name implementing `PlatformRegistrarInterface`.

Platforms are activated by adding their Registrar to this list and deactivated by removing it.

**Registrar location per Platform**:

```
src/Platforms/Clinical/ClinicalPlatformRegistrar.php
src/Platforms/Identity/IdentityPlatformRegistrar.php
```

### 4.3 Platform Registry Service

The Platform Registry (SA-002 Section 10) is implemented as a Symfony service in the MedLink Platform Kernel.

```
src/Kernel/Platform/PlatformRegistry.php
```

It is populated during container compilation from the loaded Manifests.

It exposes the list of registered Platforms and their Contracts as a runtime service.

### 4.4 Runtime Integration Point — Kernel::build()

Platform registration is initiated from `Kernel::build(ContainerBuilder $container)`.

The `build()` method is the Symfony extension point for DI container customisation at compile time. It runs before the container is compiled and before any services are resolved.

A dedicated `PlatformCompilerPass` is registered inside `Kernel::build()`.

**Registration flow**:

```
Kernel::build()
    │
    │  registers
    ▼
PlatformCompilerPass
    │
    │  loads
    ▼
config/platforms.php        ← returns list of PlatformRegistrarInterface classes
    │
    │  iterates
    ▼
PlatformRegistrar::manifest()       → loads platform.manifest.yaml → PlatformRegistry
PlatformRegistrar::register($container) → registers BC services into DI container
    │
    ▼
Container compiled with all Platform services
PlatformRegistry populated and available as runtime service
```

`PlatformCompilerPass` implements `Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface`.

It is the sole entry point for Platform service registration. No Platform service is registered outside this mechanism.

---

## 5. Dependency Injection and Service Organisation

### 5.1 Autowiring Strategy

Symfony autowiring is enabled globally.

Services are auto-registered from the `src/` directory.

Exceptions to autowiring (explicit wiring) are required for:

- interfaces with multiple implementations (Repository contracts);
- Message bus routing (Command bus, Query bus, Event bus);
- tagged services (Platform-specific listeners, projections).

### 5.2 Service Scoping by Namespace

Services are implicitly scoped by their PHP namespace.

The namespace tree mirrors the directory tree (Section 6).

Cross-namespace injection is restricted by Deptrac and Architecture Review.

A service in `Platforms\Clinical\Work\Application\` SHALL NOT be injected into `Platforms\Clinical\Knowledge\Application\` directly.

> **Note** — Deptrac verifies structural PHP dependencies (class imports and `use` statements) only. Service configuration files (`services.php`) are not analysed by Deptrac and remain subject to Architecture Review and Code Review. Wiring a cross-BC service in a configuration file without a PHP class import would bypass Deptrac but still constitutes an architectural violation.

Cross-BC collaboration occurs through the event bus (SA-006) or Facade injection (SA-003 Rule 6).

### 5.3 Service Organisation by Layer

The following table uses **architectural visibility**, not Symfony DI `public: true`.

- **Internal** — the service is wired internally within the Bounded Context. It is not reachable from other BCs.
- **Exposed** — the service is reachable from outside the Bounded Context. Symfony autowiring resolves it by type for authorised consumers.

| Layer | Architectural visibility | Notes |
|---|---|---|
| Domain | Internal | Never injected across BC boundaries |
| Application | Internal (except Facade) | Facade is Exposed — sole external entry point of the BC |
| Infrastructure | Internal | Wired into Application via Port interfaces |
| Presentation | Exposed | Controllers and Live Components resolved by the Symfony HTTP layer |

### 5.4 Interface Binding

Every Domain Repository contract is explicitly bound to its Infrastructure implementation.

```
Domain/Repository/ClinicalActivityRepositoryInterface
    → Infrastructure/Persistence/ClinicalActivityRepository
```

The implementation class lives in Infrastructure and is invisible outside its Bounded Context.

Bindings are declared in the BC service configuration (Section 7.2).

The concrete persistence technology used by the implementation is defined in SA-007.

---

## 6. Runtime Module Organisation

The `src/` directory mirrors the certified architecture.

```
src/
│
├── Kernel/                          ← MedLink Platform Kernel
│   ├── Domain/                      ← Kernel domain concepts (Actor, Organization, etc.)
│   ├── Application/
│   ├── Infrastructure/
│   └── Platform/
│       ├── PlatformRegistrarInterface.php
│       └── PlatformRegistry.php
│
├── Platforms/                       ← Business Platforms (SA-002)
│   │
│   ├── Clinical/                    ← Clinical Platform
│   │   ├── platform.manifest.yaml
│   │   ├── platform.contract.yaml
│   │   ├── ClinicalPlatformRegistrar.php
│   │   │
│   │   ├── Work/                    ← Clinical Work BC (SA-003)
│   │   │   ├── Domain/
│   │   │   ├── Application/
│   │   │   ├── Infrastructure/
│   │   │   └── Presentation/
│   │   │
│   │   ├── Knowledge/               ← Clinical Knowledge BC (SA-003)
│   │   │   ├── Domain/
│   │   │   ├── Application/
│   │   │   ├── Infrastructure/
│   │   │   └── Presentation/
│   │   │
│   │   ├── UI/                      ← Clinical Platform UI
│   │   │   ├── Workspace/
│   │   │   └── Widgets/
│   │   │
│   │   └── Integration/             ← Clinical Platform Integration layer
│   │
│   └── Identity/                    ← Identity Platform
│       ├── platform.manifest.yaml
│       └── ...
│
├── Shared/                          ← Shared architectural components (SA-002 Section 4)
│   └── DesignSystem/
│
└── Kernel.php                       ← Symfony AppKernel
```

> **Note — Workspace**: The `src/Workspace/` module and its runtime composition are intentionally omitted from SA-004. Workspace runtime organisation is specified in SA-009 — Workspace Composition.

### Mapping rules

| Architecture concept | `src/` location |
|---|---|
| MedLink Platform Kernel | `src/Kernel/` |
| Business Platform | `src/Platforms/{PlatformName}/` |
| Platform Manifest | `src/Platforms/{PlatformName}/platform.manifest.yaml` |
| Platform Contract | `src/Platforms/{PlatformName}/platform.contract.yaml` |
| Bounded Context | `src/Platforms/{PlatformName}/{BcName}/` |
| Domain layer | `src/Platforms/{PlatformName}/{BcName}/Domain/` |
| Application layer | `src/Platforms/{PlatformName}/{BcName}/Application/` |
| Infrastructure layer | `src/Platforms/{PlatformName}/{BcName}/Infrastructure/` |
| Presentation layer | `src/Platforms/{PlatformName}/{BcName}/Presentation/` |
| Platform UI | `src/Platforms/{PlatformName}/UI/` |
| Platform Integration | `src/Platforms/{PlatformName}/Integration/` |
| Shared Design System | `src/Shared/DesignSystem/` |

---

## 7. Configuration Strategy

### 7.1 Configuration Structure

```
config/
│
├── packages/                        ← Third-party bundle configuration
│   ├── doctrine.yaml
│   ├── messenger.yaml
│   ├── api_platform.yaml
│   ├── mercure.yaml
│   ├── security.yaml
│   └── twig.yaml
│
├── platforms.php                    ← Platform Registrar list
│
├── platforms/                       ← Per-Platform configuration
│   ├── clinical/
│   │   ├── services.php             ← Clinical Platform services
│   │   ├── work/
│   │   │   └── services.php         ← Clinical Work BC services
│   │   └── knowledge/
│   │       └── services.php         ← Clinical Knowledge BC services
│   └── identity/
│       └── services.php
│
├── routes/                          ← Routing (Section 8)
│   ├── api.php
│   └── web.php
│
└── services.php                     ← Global service defaults
```

### 7.2 BC Service Configuration

Each Bounded Context owns its service configuration file.

Service configuration for a BC includes:

- autowiring scope (the BC namespace);
- explicit interface-to-implementation bindings (Repository contracts);
- Messenger handler registration;
- tagged service declarations (Projections, Listeners).

Service configuration files are PHP (type-safe, IDE-friendly).

### 7.3 Environment Configuration

Environment-specific overrides follow Symfony convention:

- `.env` — local defaults
- `.env.dev`, `.env.test`, `.env.prod` — environment overrides
- `config/packages/{env}/` — package overrides per environment

Sensitive values (database credentials, JWT secrets, API keys) are managed via Symfony Secrets and never committed.

---

## 8. Routing Strategy

### 8.1 Routing Principles

Routes are organised by Platform.

API routes always carry the `/api/v1/` prefix.

Web routes carry the Platform name as prefix where applicable.

### 8.2 API Routing

API Platform is the default implementation for REST API routes.

State Providers handle read operations. State Processors handle write operations.

Custom Symfony controllers MAY be used for API routes that do not map naturally to API Platform resources (webhooks, health checks, one-off endpoints).

No route annotations in Domain or Application classes.

Route definitions belong to Presentation.

```
/api/v1/{platform}/{resource}
```

**Examples**:

```
POST   /api/v1/clinical/activities
GET    /api/v1/clinical/activities/{id}/timeline
POST   /api/v1/clinical/activities/{id}/contributions
```

Versioning prefix `/api/v1/` is mandatory from the first release.

### 8.3 Web Routing

Web routes for internal interfaces follow the Platform prefix convention.

```
/clinical/{...}
/identity/{...}
```

### 8.4 Route File Organisation

```
config/routes/
├── api.php      ← imports all Platform API route definitions
└── web.php      ← imports all Platform web route definitions
```

Each Platform contributes its own routes file, imported by the central route files.

### 8.5 Route Naming Convention

```
{platform}.{bounded_context}.{resource}.{action}
```

**Examples**:

```
clinical.work.activity.create
clinical.work.activity.timeline
clinical.knowledge.contribution.publish
```

---

## 9. Runtime Dependency Rules

The following rules complement SA-003 dependency rules at the Symfony runtime level.

**Rule 1 — Zero Symfony in Domain**

No Symfony class, interface, or attribute may appear in any Domain layer class.

Verified by: Deptrac.

**Rule 2 — Zero Symfony in Application**

No Symfony class, interface, or attribute may appear in any Application layer class, including Handlers and Facades.

Exception: `#[AsMessageHandler]` attribute on Handlers — this attribute is the minimal coupling to Messenger. Evaluate against SA-005.

Verified by: Deptrac.

**Rule 3 — Infrastructure is Symfony-aware**

Infrastructure implements Ports using Symfony components (Doctrine, Messenger, HttpClient, Cache, etc.).

Infrastructure classes are never injected into Domain or Application except through Port interfaces.

**Rule 4 — Presentation is Symfony-aware**

Presentation uses Symfony HTTP Foundation, Router, Forms, Security, and UX components.

Presentation classes never import from Domain directly.

**Rule 5 — No cross-BC service injection**

A service in Bounded Context A may not be directly autowired into a service in Bounded Context B.

Cross-BC synchronous interaction occurs through explicit Facade injection only.

Cross-BC asynchronous interaction occurs through the event bus (SA-006).

Verified by: Deptrac.

**Rule 6 — No cross-Platform service injection**

A service in Platform A may not be directly autowired into a service in Platform B.

Cross-Platform interaction occurs through Platform Contracts and Integration Events (SA-002, SA-006).

Verified by: Deptrac.

### Deptrac Layer Configuration Reference

Deptrac is configured to enforce the following layer boundaries:

| From | May depend on | May not depend on |
|---|---|---|
| Domain | Domain (own BC) | Application, Infrastructure, Presentation, Symfony, Domain (other BCs), Application (other BCs) |
| Application | Domain (own BC), Application (own BC) | Infrastructure (directly), Presentation, Symfony, Domain (other BCs), Application (other BCs) |
| Infrastructure | Domain (own BC), Application (own BC), Symfony packages | Presentation, Domain (other BCs), Application (other BCs) |
| Presentation | Application (own BC), Symfony packages | Domain (own BC), Infrastructure, Domain (other BCs), Application (other BCs) |

Cross-BC and cross-Platform violations are caught by Deptrac namespace rules.

The "own BC" constraint means Deptrac enforces namespace boundaries matching `Platforms\{Platform}\{BC}\*`. Any import outside this namespace boundary from another BC (`Platforms\{Platform}\{OtherBC}\*`) is a violation.

---

## 10. Closed Decisions

This document closes the following Open Decisions from SA-002.

| SA-002 ID | Decision | Resolution |
|---|---|---|
| OD-001 | Platform Manifest format | **YAML** — `platform.manifest.yaml` |
| OD-002 | Platform discovery mechanism | **PlatformRegistrarInterface** — PHP class, registered in `config/platforms.php` |

---

## 11. References

- SA-001 — Reference Architecture
- SA-002 — Platform Architecture
- SA-003 — Bounded Context Architecture
- ADR-0003 — Hexagonal Architecture
- ADR-0004 — CQRS
- ADR-0014 — Domain Events Shall Never Cross Platform Boundaries

---

## 12. Open Decisions

| ID | Decision | Status |
|---|---|---|
| OD-001 | `#[AsMessageHandler]` attribute in Application Handlers — permitted coupling or Infrastructure concern | Open — deferred to SA-005 |
| OD-002 | Platform Contract format (`platform.contract.yaml` structure) | Open — deferred to SA-005 or SA-006 |
| OD-003 | Deptrac ruleset organisation — one global config vs per-Platform configs | Open |
