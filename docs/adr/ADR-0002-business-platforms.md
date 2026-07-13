# ADR-0002 — Business Platforms

**Status:** Accepted

## Decision

Business Platforms encapsulate domain-specific logic.

Each Platform is independent.

Platforms never depend on each other directly.

Cross-platform communication happens exclusively through Business Events dispatched on the event.bus.

## Current Platforms

| Platform | Status | Purpose |
|---|---|---|
| Clinical | Active (MVP) | Healthcare work organization |
| Collaboration | Planned | Cross-platform missions and discussions |
| Trust | Planned | Consent, compliance, traceability |
| Identity | Planned | Actor identity and IAM |
| Learning | Future | Education |
| Conference | Future | Events and conferences |

## Rules

1. A Platform never imports a class from another Platform.
2. A Platform may import from Kernel and Shared only.
3. Each Platform owns its own database tables.
4. No cross-Platform joins at the database level.

## Adding a New Platform

Adding a new Platform requires zero changes to:
- The Platform Kernel
- Existing Platforms
- Deptrac configuration (Platforms is a pattern-based layer)
- Messenger configuration

Only required: create `src/Platforms/{NewPlatform}/`.
