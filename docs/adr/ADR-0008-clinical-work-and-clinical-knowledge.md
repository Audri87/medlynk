# ADR-0008 — Clinical Work and Clinical Knowledge

**Status:** Accepted

---

## Context

During subdomain analysis of the Clinical Platform, two distinct subdomains emerged naturally:

- **Clinical Work** — the performance of professional clinical work (Clinical Activity, lifecycle, responsibility)
- **Clinical Knowledge** — the durable clinical information produced and consumed (Clinical Contributions, Care Record)

An initial concern was whether the dependency between these two subdomains was unidirectional or circular.

---

## Decision

Clinical Work and Clinical Knowledge form a **feedback loop**.

Neither subdomain is purely upstream of the other.

---

## The Loop

```
Clinical Knowledge
        ↓
Context Reconstruction       ← Application Service (not a domain concept)
        ↓
Clinical Activity            ← Clinical Work subdomain
        ↓
Clinical Contributions       ← produced by the activity
        ↓
Care Record                  ← built from contributions
        ↓
Clinical Knowledge           ← enriched and ready for the next activity
```

---

## Subdomain Responsibilities

### Clinical Work

Responsible for:
- Clinical Activity (aggregate root)
- Lifecycle management
- Responsibility model (one responsible practitioner, many contributors)
- Responsibility transfers and history
- Working Notes (temporary, never enter Clinical Knowledge)

Not responsible for:
- Storing Clinical Contributions
- Building the Care Record
- Reconstructing context

---

### Clinical Knowledge

Responsible for:
- Clinical Contributions (durable)
- Care Record (built from contributions)
- Contribution versioning
- Contribution visibility rules

Not responsible for:
- Executing clinical work
- Managing the lifecycle of Clinical Activities

---

## Context Reconstruction

Context Reconstruction is an **Application Service**, not a domain concept.

It reads from Clinical Knowledge and prepares context for the practitioner before a Clinical Activity begins.

It does not own data. It does not persist state. It is the bridge between the two subdomains at the application layer.

---

## Dependency Rule

Clinical Work references Clinical Knowledge by identifier only.

Clinical Knowledge does not reference Clinical Work.

The feedback direction is one-way at the domain level:
- Clinical Work **produces** contributions that enter Clinical Knowledge.
- Clinical Knowledge **is read** by the Application Service layer, never directly by Clinical Work.

---

## Rationale

> Clinical work continuously consumes and enriches clinical knowledge.
