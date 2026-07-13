# MedLink Platform Kernel

## Foundation Specification v0.3

**Status:** Foundation
**Audience:** Architects, AI assistants, Developers

---

# Purpose

This document defines the current state of the MedLink Platform Kernel.

The objective is NOT to design Clinical.

The objective is to discover the smallest possible Platform Kernel capable of supporting multiple business platforms over the next twenty years.

The Kernel is intentionally incomplete.

Only validated concepts enter the Kernel.

Everything else remains a hypothesis until validated through Discovery Workshops and Event Storming.

---

# Mission

MedLink is not a medical application.

MedLink is a platform that organizes the work of actors.

Healthcare is the first platform implemented.

Future platforms may include:

* Clinical
* Learning
* Conference
* Community
* Research
* AI
* Marketplace

The Platform Kernel must remain independent from all business domains.

---

# Architectural Philosophy

Business first.

Domain second.

Architecture third.

Technology last.

Never allow technical decisions to influence the Platform Kernel.

---

# Current Kernel

The Kernel currently contains only four validated concepts.

## Actor

Definition

> An Actor is any entity capable of performing an Interaction inside a Context.

Examples

* Human
* AI Agent
* External System
* Connected Device

The Kernel does not distinguish actor types.

---

## Context

Definition

> A Context is the bounded environment in which Interactions occur.

The Kernel deliberately ignores business-specific contexts.

The following are NOT Kernel concepts:

* Encounter
* Course
* Quiz
* Conference Session
* Discussion
* Mission

Those belong to Business Platforms.

The internal structure of Context is intentionally left open.

---

## Interaction

Definition

> An Interaction is a business action initiated by an Actor inside a Context.

Interaction is a Business concept.

Interaction is NOT a Command.

Commands belong to the implementation architecture (CQRS).

Relationship

Actor

↓

Interaction

↓

Business Event

---

## Business Event

Definition

> A Business Event is an immutable business fact resulting from one or more Interactions.

Business Events are the source of truth.

Business Events never belong to projections.

---

# Explicit Non-Kernel Concepts

The following concepts do NOT belong to the Platform Kernel.

Clinical

* Patient
* Practitioner
* Care Record
* Encounter
* Observation
* Prescription
* Treatment
* Care Team
* Consent

Learning

* Course
* Quiz
* Certification

Conference

* Talk
* Session
* Replay

Community

* Discussion
* Group
* Topic

Every Business Platform owns its own domain model.

---

# Language Principle

> Software does not create collaboration.
>
> Shared language creates collaboration.
>
> Software merely operationalizes that language.

This principle explains why MedLink is designed around stable concepts rather than around features.

A Platform is a vocabulary that allows a community of Actors to describe their work.

Its value resides in the stability and precision of that vocabulary — not in its implementation technology.

---

# Workspace Principle

> A Workspace is the medium-independent organization of information, capabilities and priorities made available to an Actor within a Context.

A Workspace is not a classical CQRS Projection.

A Projection answers: *what is the current state?*

A Workspace answers: *what can be done, and what deserves attention now?*

A Workspace survives:

* Web UI
* Mobile
* Voice interfaces
* AI agents
* AR / VR
* Ambient computing

A Workspace is computed on demand. It is never stored as source of truth.

---

# Projection Principle

Everything presented to an Actor is considered a Projection.

Examples

* Workspace
* Timeline
* Dashboard
* Notifications
* Journey
* Next Actions
* Progress Indicators

Projections are disposable.

Business logic must never depend on projections.

---

# Journey

Architectural decision

Journey is NOT a Platform Kernel concept.

Journey is considered:

* a Projection
* a Workspace Pattern
* a UX concept

Journey must never become the center of the domain model.

---

# Care Record

Care Record belongs exclusively to the Clinical Platform.

Responsibilities

* Clinical memory
* Observations
* Results
* Prescriptions
* Attachments
* Clinical history

Care Record never orchestrates workflows.

---

# Kernel Principle

> The Platform Kernel does not model reality.
>
> It models the smallest stable set of concepts that MedLink chooses to consider universal across all Business Platforms.

Kernel concepts are not absolute primitives.

They are stable concepts intentionally chosen by the platform.

The burden of proof belongs to the concept — not to the Kernel.

---

# Kernel Admission Rule

A concept enters the Platform Kernel only if it satisfies all seven conditions:

**For admission:**

1. It appears, necessarily and under the same essential definition, in every Business Platform that can exist on MedLink.
2. It survives multiple real-world scenarios.
3. It survives Event Storming across at least three distinct Platforms.
4. It can be defined in one universal sentence without referencing any business concept.
5. It remains independent from implementation technology.
6. It cannot be derived from other Kernel concepts already present.
7. Its removal would force at least two distinct Business Platforms to independently invent equivalent replacements.

**For retention:**

A concept is retained in the Kernel only if its removal would require at least two distinct Business Platforms to independently invent equivalent replacements.

Otherwise it remains outside the Kernel.

---

# Architectural Layers

Platform Kernel

↓

Business Platforms

↓

DDD Tactical Model

↓

Application Layer

↓

Infrastructure

The Platform Kernel must never depend on lower layers.

---

# CQRS Separation

The Platform Kernel does not know:

* Command
* Query
* Handler
* Aggregate
* Repository
* Projection Store

Those belong to implementation architecture.

Interaction is a Business concept.

Command is a Technical concept.

Business Event bridges both worlds.

---

# Current Hypotheses

The following concepts are intentionally unresolved.

They remain under discovery.

## KH-001

Identity

Question

Should Identity belong to the Platform Kernel?

Or should it belong to a dedicated Identity Platform?

Status

UNDER DISCOVERY

Decision postponed until Event Storming.

---

## KH-002

Context

Question

Should the Kernel expose only one generic Context?

Or should Context later evolve into Domain Context and Work Context?

Status

UNDER DISCOVERY

Decision postponed until additional discovery workshops.

---

# Architectural Rule

Never add a concept to the Platform Kernel because it is useful.

Only add it because it is universal.

The burden of proof belongs to the concept.

Not to the Kernel.

---

# Long-Term Vision

The Platform Kernel should remain stable while Business Platforms evolve independently.

If a new feature requires changing the Platform Kernel, assume first that the feature belongs to a Business Platform.

Protect the Kernel.

Everything else may evolve.
