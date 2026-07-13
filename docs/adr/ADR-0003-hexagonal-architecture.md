# ADR-0003 — Hexagonal Architecture (Ports & Adapters)

**Status:** Accepted

## Context

An earlier hypothesis proposed a runtime Platform Engine (capability registry) to decouple Platforms from Workspaces.

After review, this was identified as the Service Locator anti-pattern: coupling hidden at runtime rather than eliminated.

## Decision

MedLink uses Hexagonal Architecture (Ports & Adapters).

```
Kernel defines Ports (interfaces)
Platforms implement Ports (Adapters)
Workspace depends on Ports, never on Platform implementations
DI container wires Adapters to Ports at startup
```

## Consequences

- No runtime capability registry.
- No Platform Engine as a runtime component.
- Coupling is explicit at compile time, not hidden at runtime.
- Adding a Platform = implementing an interface.
- Testing = mock the Port, not the Platform.

## Layer Dependencies

```
Kernel     → depends on nothing
Shared     → depends on Kernel
Platforms  → depends on Kernel + Shared
Workspace  → depends on Kernel + Shared (through Ports only)
```

Enforced by Deptrac.
