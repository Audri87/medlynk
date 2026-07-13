# ADR-0006 — Capability as a First-Class Architectural Concept

**Status:** Accepted

---

## Context

During the design of the Workspace Engine and its Port contracts, a recurring structural pattern emerged naturally:

```
Business Platform
        ↓
Capability
        ↓
Port (technical interface)
        ↓
Adapter (Platform implementation)
        ↓
Workspace
```

This pattern requires a formal definition of Capability as an architectural concept, distinct from its technical implementation.

---

## Decision

Capability is a first-class architectural concept in MedLink.

---

## Definition

> A Capability is the business contract through which a Business Platform contributes information or actions to the rest of the platform, without exposing its internal domain model.

A Capability is a triplet:

| Element | Description |
|---|---|
| **Preconditions** | Who can exercise it, in which Context, under which conditions |
| **Interaction** | The action itself, in the Kernel sense |
| **Postconditions** | The Business Events produced, the state changes |

---

## Ownership

A Capability belongs to the Business Platform that defines the unit of work it represents.

- `PrescribesMedication` belongs to Clinical.
- `EnrollsInCourse` belongs to Learning.
- `JoinSession` belongs to Conference.

A Capability cannot exist without its Platform.

---

## Independence

A Capability may be versioned independently from its Platform implementation.

A Platform may add new Capabilities without modifying existing ones.

A Capability may be deprecated and replaced.

A Capability may not change Platform ownership without an explicit architectural decision.

---

## Capability vs Port

These are distinct concepts at different levels.

| Concept | Level | Nature |
|---|---|---|
| Capability | Business | What is possible |
| Port | Technical | How Workspace accesses it |
| Adapter | Infrastructure | Where it actually happens |

A Port is the technical expression of a Capability.
A Capability is not a Port.

---

## Implementation

Capabilities are exposed through interfaces in `Shared/Application/Port/Workspace/`.

These interfaces use business names — no technical vocabulary in the interface name.

```
WorkspaceContributor    ← not WorkspaceContributorPort
AttentionProvider       ← not AttentionProviderPort
WorkItemProvider        ← not WorkItemProviderPort
```

Infrastructure Adapters that implement these interfaces use the Adapter suffix:

```
ClinicalWorkspaceContributorAdapter
ClinicalAttentionProviderAdapter
```

---

## Discoverability

For the Workspace to assemble dynamically, Capabilities must be declared and discoverable.

Symfony service tags provide this mechanism without coupling Workspace to any Platform:

```yaml
_instanceof:
    WorkspaceContributor:
        tags: ['medlink.workspace.contributor']
```

The Workspace Engine discovers available Capabilities at runtime through tagged iterators.

---

## Structure

```
Shared/
    Application/
        Port/
            Workspace/
                WorkspaceContributor.php    ← Capability interface
                AttentionProvider.php       ← Capability interface
                WorkItemProvider.php        ← Capability interface
                WorkspaceSection.php        ← Port contract DTO
                AttentionItem.php           ← Port contract DTO
                WorkItem.php                ← Port contract DTO

Platforms/
    Clinical/
        Infrastructure/
            Port/
                ClinicalWorkspaceContributorAdapter.php   ← future
                ClinicalAttentionProviderAdapter.php       ← future
```

---

## Rules

1. A Capability interface is defined in `Shared/Application/Port/`.
2. A Capability interface uses business language — no "Port" in the interface name.
3. A Capability Adapter lives in the Platform's `Infrastructure/Port/` directory.
4. The Workspace only depends on Capability interfaces — never on Platform classes.
5. A Platform never imports from the Workspace.
