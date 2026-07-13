# DE-P-012 — Reference Scenario Coherence

**Statut** : Accepted
**Date** : 2026-07-13

---

## Principle

Every new Event Storming scenario must be evaluated against the frozen Domain Engineering Baseline before its conclusions are accepted.

---

## Three Possible Outcomes

### Validation

The scenario confirms an existing decision.

The baseline is not modified.

The evidence base for the confirmed decision is strengthened.

---

### Hotspot

The scenario reveals an open question that does not contradict the baseline.

The Hotspot is documented.

It is not resolved immediately.

It does not block the scenario from advancing.

---

### Falsification

The scenario demonstrates a behavioural contradiction in a frozen decision.

This triggers a formal review.

The baseline is not automatically updated.

A contradicted decision may be:

* corrected if the contradiction is genuine;
* maintained if the scenario is narrower than the frozen principle;
* qualified with an explicit exception.

---

## What a Scenario Cannot Do

A scenario cannot reopen a frozen baseline decision solely because:

* it reveals a more elegant model;
* it introduces a new use case;
* it represents a different profession's workflow.

These outcomes belong to Hotspots or Workspace Patterns.

---

## Baseline Reference

The current Domain Engineering Baseline is defined in:

`docs/DE-BASELINE-V1.md`

Any scenario that proposes to modify a frozen decision must reference this document explicitly.
