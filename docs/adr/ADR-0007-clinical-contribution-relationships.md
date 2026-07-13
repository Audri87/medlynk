# ADR-0007 — Clinical Contribution Relationships

**Status:** Accepted

---

## Context

During the modelling of the Clinical Platform, the concept of Clinical Contribution raised a structural question.

Some contributions authorise a Clinical Activity to begin (a medical prescription enabling physiotherapy). Others inform the practitioner's reasoning (a laboratory result consulted). Others document what was done (a session note produced at the end of a consultation).

An initial approach proposed distinct subtypes: `EnablingContribution`, `InformativeContribution`, `DocumentingContribution`.

This approach was rejected. Multiplying subtypes inflates the domain model without improving its expressive power.

---

## Decision

Clinical Contribution remains a single domain concept.

The role of a contribution is not a property of the contribution itself. It is a property of the **relationship** between a Clinical Activity and a Clinical Contribution.

---

## Relationship Model

```
Clinical Activity
    │
    ├── consumes(role=Enabling)    → Medical Prescription
    ├── consumes(role=Informative) → Laboratory Result
    ├── consumes(role=Informative) → Previous Consultation Note
    │
    └── produces                   → Session Note
    └── produces                   → Prescription
    └── produces                   → Referral
```

Roles currently defined:

| Role | Meaning |
|---|---|
| `Enabling` | Authorises the Clinical Activity to begin |
| `Informative` | Informs reasoning without authorising |
| *(no role on produces)* | Documents what was done |

---

## Consequences

A Clinical Contribution does not know what role it plays. Its role depends entirely on the context in which it is consumed or produced.

The same contribution may play different roles in different activities:
- A prescription produced by a GP is a `produces` relationship for the GP's Clinical Activity.
- The same prescription is an `Enabling` relationship for the physiotherapist's Clinical Activity.

---

## Rules

1. Clinical Contribution is a single concept — no subtypes.
2. Roles are expressed on the relationship, not on the entity.
3. New roles may be added without modifying the Clinical Contribution concept.

---

## Rationale

> Roles belong to relationships, not entities.
