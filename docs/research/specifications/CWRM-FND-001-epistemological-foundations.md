# CWRM-FND-001 — Epistemological Foundations of Clinical Work Representation

---

## 0. Metadata

| Field | Value |
|---|---|
| Document ID | CWRM-FND-001 |
| Title | Epistemological Foundations of Clinical Work Representation |
| Version | 0.1-DRAFT |
| Status | Foundation Draft |
| Layer | 000 — Foundations |
| Normative | Informative — Foundational |
| Audience | Researchers, Methodologists, Designers |
| Date | 2026-07-31 |
| Depends on | CWRM-000 (scope), CWRM-000A (conceptual model) |
| Required by | All CWRM specifications — foundational rationale |

---

## Abstract

Clinical work is not directly observable as knowledge.

Researchers observe events, interactions, decisions and narratives. These observations must be transformed into stable representations before they can support design decisions.

The Clinical Work Research Method proposes that this transformation should proceed through explicit intermediate knowledge objects — Activities, Observations and Invariants — rather than directly from interviews to themes or design requirements.

This document establishes the epistemological assumptions underlying this claim.

---

## 1. The Scientific Problem

Healthcare software is often designed from qualitative studies.

However, the transformation from empirical observations to product decisions is frequently implicit.

```
Researchers identify themes.
Themes become personas.
Personas become user stories.
```

The reasoning linking empirical evidence to design decisions is rarely explicit or reproducible.

The consequence is that identical research material may legitimately produce different design outcomes.

CWRM addresses this problem.

---

## 2. Central Research Question

> How can clinical work be represented so that design decisions become more traceable, reproducible and scientifically justifiable?

Everything in the CWRM derives from this question.

---

## 3. Epistemological Position

The CWRM adopts a **critical pragmatist** position.

It assumes that:

- Clinical work exists independently of its representation.
- Researchers never access this work directly.
- Knowledge is constructed through explicit representations.
- The quality of representation influences the quality of subsequent design decisions.

This position rejects both **naïve realism** ("the interview reveals reality") and **radical constructivism** ("all representations are equally valid").

Instead, it argues that some representations are better justified, more transparent, and more reproducible than others — and that the differences are measurable.

---

## 4. Discovery and Construction

The CWRM distinguishes two fundamentally different activities.

### Discovery

Researchers discover regularities in clinical work.

Examples:
- recurring activities
- coordination patterns
- interruptions
- recurrent decision points

These discoveries are empirical. They are constrained by reality.

### Construction

Researchers invent conceptual tools that allow these discoveries to be represented.

Examples: ACT, Observation, Invariant, Evidence, Provenance.

These concepts are methodological constructs. They are evaluated by coherence, usefulness and explanatory power — not by whether they are "true."

*See also: CWRM-000A §3 — The meta-model is invented; the domain model is discovered.*

---

## 5. The Representation Hypothesis

The central hypothesis of the CWRM is:

> **H1 — Representation Hypothesis:** Representing clinical work through explicit intermediate knowledge objects produces representations that are more traceable, reproducible and justifiable than direct thematic abstraction.

This hypothesis is falsifiable. It must be tested empirically.

*Operationalization: see Section 9.*

---

## 6. Knowledge Objects

The CWRM distinguishes between:

| Level | Nature |
|---|---|
| Empirical events | What happened during clinical work |
| Representations of those events | Verbatim accounts, ACTs |
| Knowledge derived from those representations | Observations, Invariants |
| Design decisions derived from that knowledge | Requirements, Features |

These are different **epistemic levels**. They SHALL NOT be conflated.

The transformation between levels is the primary methodological concern of the CWRM. Each transformation is explicit, documented, and reviewable.

---

## 7. Evidence and Provenance

**Evidence** is not synonymous with **Provenance**.

| Concept | Question answered | Nature |
|---|---|---|
| Provenance | Where does this knowledge come from? | Contextual record |
| Evidence | Why should this knowledge be believed? | Epistemic justification |

These concepts are orthogonal.

A knowledge object may have well-documented provenance (we know exactly when, where, and by whom it was created) but weak evidence (the underlying empirical basis does not justify belief).

Conversely, a finding may be strongly supported by evidence across multiple independent sources while its provenance record is incomplete.

The CWRM requires explicit documentation of both.

---

## 8. Traceability

Scientific credibility depends on reconstructing the reasoning linking:

```
Empirical Material (Verbatim)
        ↓
Activity Unit (ACT)
        ↓
Observation (OBS)
        ↓
Invariant (INV)
        ↓
Requirement
        ↓
Design Decision
```

Every transformation SHALL be explicit.

Every transformation SHALL be reviewable.

Every transformation SHALL be traceable to the empirical material that motivates it.

---

## 9. Research Hypotheses

### H1 — Representation Hypothesis

> Representations based on explicit Activity Units, Observations and Invariants produce more reproducible design decisions than representations based solely on themes.

**Experimental operationalization:**

| Measure | Operationalization |
|---|---|
| Reproducibility | Inter-rater reliability (IRR) of design requirements produced by two independent teams from the same interview corpus |
| Traceability | Percentage of requirements with complete provenance chain to verbatim passage |
| Justifiability | Expert panel evaluation of evidence quality for each requirement |

**Control condition:** Same interview corpus analyzed using thematic analysis + personas + user stories.

**Falsification criterion:** If CWRM does not produce statistically higher IRR than the control condition across three or more independent replications, H1 is rejected.

### H2 — Evidence Distinction Hypothesis

> Explicitly separating Evidence from Provenance reduces the frequency of design decisions that are well-documented but poorly justified.

**Operationalization:** Comparison of requirements documentation quality between teams using CWRM (with explicit Evidence Framework, CWRM-050) and teams using standard qualitative methods. Measure: proportion of requirements citing evidence quality versus only citation of source.

### H3 — Coding Manual Hypothesis

> A structured Coding Manual (CWRM-030) with explicit ACT classification criteria produces higher inter-rater reliability in clinical work coding than open thematic analysis.

**Operationalization:** Standard IRR metrics (Cohen's κ, Krippendorff's α) comparing two coders using CWRM-030 versus two coders using open coding on the same transcripts.

---

## 10. Evaluation Criteria

The CWRM distinguishes two forms of evaluation.

### Evaluation of the Meta-Model

Questions:
- Is it internally coherent?
- Is it logically consistent?
- Does it support the method?

These are **architectural questions**. The criterion is logical consistency and practical adequacy.

### Evaluation of the Domain Model

Questions:
- Does it faithfully describe clinical work?
- Is it reproducible?
- Is it supported by evidence?
- Can independent researchers confirm it?

These are **empirical questions**. The criterion is evidence quality and inter-rater reliability.

**Confusing these two evaluations is a methodological error.**

A critic who argues that "the ACT concept is not how practitioners think about their own work" is making a domain model critique — and may be correct. A critic who argues that "the distinction between ACT and OBS is arbitrary" is making a meta-model critique — the response requires showing the distinction is useful and consistent, not that it corresponds to a natural joint.

---

## 11. Consequences for the Method

From these foundations follow the existence of:

| Specification | Transformation governed |
|---|---|
| CWRM-020 — Interview Protocol | Empirical material → Verbatim |
| CWRM-030 — Coding Manual | Verbatim → ACT |
| CWRM-040 — ACT Taxonomy | ACT classification and quality |
| CWRM-050 — Evidence Framework | ACT/OBS → Evidence level |
| CWRM-060 — Design Reasoning | INV → Requirement |
| CWRM-070 — Validation Protocol | Validation of the complete chain |

Each specification addresses one transformation in the chain from empirical material to justified design knowledge.

---

## 12. Open Questions

**OQ-FND-001 — Literature positioning:** Where exactly does CWRM sit relative to Grounded Theory, Cognitive Task Analysis, Activity Theory, Contextual Inquiry, and formal knowledge representation? A structured positioning review is required before any external publication claim.

**OQ-FND-002 — Saturation criterion:** At what point has a corpus accumulated sufficient evidence to support an Invariant? CWRM-001 defines quality gates but does not yet define a formal saturation criterion. This is a known gap with significant implications for H1.

**OQ-FND-003 — Scientific contribution claim:** What does CWRM add to existing methodology that is not already present in CTA, Contextual Design, or requirements engineering? A formal "scientific contribution" section is required before any submission to a peer-reviewed venue.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-31 | 0.1-DRAFT | Initial — epistemological position, H1, meta-model vs. domain model distinction |
