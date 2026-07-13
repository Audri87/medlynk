# ADR-0001 — Platform Kernel v0.1

**Status:** Accepted (Foundation)

## Purpose

This document defines the current architectural decisions regarding the MedLink Platform Kernel.

The objective is **not** to design the Clinical Platform.

The objective is to define the smallest possible Platform Kernel that will remain stable for the next twenty years.

---

# Mission

MedLink is not a medical software.

MedLink is a platform that organizes the work of healthcare actors.

Clinical is only the first business platform.

Future platforms include:

* Learning
* Conference
* Community
* Research
* Marketplace
* AI

The Platform Kernel must remain independent from all business domains.

---

# Architectural Decision #1

## The Kernel knows nothing about Healthcare.

The following concepts DO NOT belong to the Platform Kernel.

* Patient
* Practitioner
* Care Record
* Encounter
* Observation
* Prescription
* Treatment
* Laboratory Result
* Care Team

Those belong to the Clinical Platform.

---

# Architectural Decision #2

The Platform Kernel contains only universal concepts.

Current candidates are:

* Actor
* Context
* Interaction
* Business Event

Everything else must justify its presence.

---

# Actor

Definition

> An Actor is any entity capable of performing an interaction inside a Context.

Examples

Human

AI Agent

External System

Connected Device

The Kernel does not distinguish between them.

Identity management belongs to a dedicated Identity Platform.

---

# Context

Definition

> A Context is the bounded environment in which interactions occur.

The Platform Kernel does not define business contexts.

Examples such as:

* Encounter
* Course
* Quiz
* Conference Session

belong to their respective business platforms.

The Kernel only knows that a Context exists.

---

# Interaction

Definition

> An Interaction is an action performed by an Actor inside a Context.

Examples

Clinical

* Create Observation
* Sign Prescription

Learning

* Watch Video
* Complete Quiz

Conference

* Submit Talk
* Join Session

Community

* Publish Post
* Reply

Interaction belongs to the Platform Kernel because every platform contains interactions.

Interaction may generate one or more Business Events.

---

# Business Event

Definition

> A Business Event is an immutable fact resulting from one or more Interactions.

Examples

Clinical

ObservationRecorded

PrescriptionSigned

Learning

VideoCompleted

QuizPassed

Conference

TalkSubmitted

SessionStarted

Business Events are immutable.

Business Events are the source of truth.

---

# Projection Principle

Everything visible to users is considered a Projection.

Examples

Workspace

Dashboard

Timeline

Notifications

Journey

Next Actions

Progress Indicators

Projections are disposable.

Business logic must never be implemented inside projections.

---

# Care Record

Care Record belongs to the Clinical Platform.

It is NOT part of the Platform Kernel.

Responsibilities

* Clinical memory
* Observations
* Results
* Prescriptions
* Attachments
* History

Care Record never orchestrates workflows.

---

# Journey

Decision

Journey is NOT a Platform Kernel concept.

Reasons

* It fails in Emergency scenarios.
* It fails in Intensive Care scenarios.
* It mixes template, execution and business intention.
* It is domain-specific.

Journey survives as:

* Projection
* Workspace Pattern
* UX concept

Never model Journey as a Platform Kernel concept.

---

# Workspace

Workspace is not business data.

Workspace is a Projection generated from:

Actor × Context

Workspace must always be computed.

Never manually synchronize Workspace state.

---

# Long-Term Principle

Every new business platform must be implementable without modifying the Platform Kernel.

If a new feature requires changing the Kernel,

the default assumption is:

"The feature probably belongs to a Business Platform."

The burden of proof belongs to the feature,

not to the Kernel.

---

# Kernel Philosophy

The Platform Kernel models only universal concepts.

Business Platforms model business concepts.

Clinical Platform models healthcare.

Learning Platform models education.

Conference Platform models conferences.

Community Platform models communities.

The Kernel must remain stable while platforms evolve independently.

---

# Open Questions

The following subjects remain intentionally unresolved.

## Identity

Should Identity belong to the Platform Kernel or to a dedicated Identity Platform?

Current tendency: Identity Platform.

---

## Organization

**Decision: Closed.**

Organization is NOT a root concept of the Platform Kernel.

Organization is part of Context.

Context encapsulates the organizational boundary.

```
Context
├── organizational scope  (Hospital, Clinic, University...)
├── domain scope          (Clinical, Learning, Conference...)
└── work scope            (Encounter, Course, Session...)
```

Consequences:

- No standalone Organization aggregate in the Kernel.
- An Actor operating in different organizations has different Contexts.
- Permissions are scoped to Context, not to Organization directly.
- Business Platforms define their own organization concepts if needed.

---

## Context

Do we need only one generic Context?

Or should Context be decomposed into Domain Context and Work Context?

Decision postponed until additional discovery workshops.

---

# Guiding Principle

Whenever a new concept is proposed:

1. Can it exist outside Clinical?
2. Can it exist in Learning?
3. Can it exist in Conference?
4. Can it exist in Community?
5. Can it still exist in twenty years?

If the answer is "no" to one of these questions,

it does not belong to the Platform Kernel.
