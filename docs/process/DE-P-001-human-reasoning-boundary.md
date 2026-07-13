# DE-P-001 — Human Reasoning Is Outside the Domain

**Statut** : Accepted
**Date** : 2026-07-11

---

## Purpose

This principle defines the modelling boundary between the Practitioner and the MedLink Domain.

Its objective is to preserve the **Human Judgment First** principle throughout Domain Engineering.

---

## Principle

Clinical reasoning belongs exclusively to the Practitioner.

The Domain does not attempt to model the internal reasoning process.

It models only the observable consequences of that reasoning.

---

## Inside the Practitioner

The following activities remain outside the Domain:

* understanding;
* interpretation;
* hypothesis generation;
* differential diagnosis;
* mental comparison;
* weighing alternatives;
* deciding internally.

These activities are cognitive.

They are neither observable nor owned by the Domain.

---

## Inside the Domain

The Domain begins when reasoning produces observable clinical facts.

Examples include:

* Clinical Observation Recorded
* Clinical Draft Updated
* Clinical Contribution Validated
* Clinical Contribution Created
* Clinical Contribution Published
* Clinical Activity Closed

These events describe facts that exist independently of the Practitioner's internal thought process.

---

## Professional Workspace

The Professional Workspace prepares clinical reasoning.

It never replaces it.

Workspace capabilities may:

* reconstruct context;
* highlight relevant information;
* compare previous Contributions;
* surface pending actions;
* provide AI-assisted summaries.

They do not become part of the Domain.

---

## Artificial Intelligence

Artificial Intelligence follows the same rule.

AI may support the Practitioner.

AI never performs Clinical Judgment on behalf of the Domain.

The Domain recognises only the Practitioner's explicit validation.

---

## Event Storming Consequence

During Event Storming:

Events describing internal reasoning must not be modelled.

Examples of rejected Domain Events include:

* Clinical Assessment Established
* Diagnosis Considered
* Clinical Situation Understood
* Clinical Hypothesis Generated

These represent cognitive states rather than observable business facts.

---

## Modelling Test

Before accepting a Domain Event, ask:

> Is this an observable fact within the Domain?

If the answer is:

> "It happened only in the Practitioner's mind."

then it is not a Domain Event.

---

> **MedLink does not model clinical reasoning.**
>
> **It models the observable consequences of clinical reasoning.**
