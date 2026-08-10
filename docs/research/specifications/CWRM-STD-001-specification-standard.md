# CWRM-STD-001 — Specification Standard

---

## 0. Metadata

| Field | Value |
|---|---|
| Document ID | CWRM-STD-001 |
| Title | Specification Standard |
| Version | 1.0.0-DRAFT |
| Status | Draft — Pending Review |
| Layer | 000 — Foundations |
| Date | 2026-07-31 |
| Depends on | CWRM-000 |
| Required by | All CWRM specifications |

---

## 1. Contract

### Inputs

| Input | Source |
|---|---|
| CWRM-000 scope and governance rules | CWRM-000 — Scope Guard |

### Outputs

| Output | Consumer |
|---|---|
| Specification structure model | All CWRM specifications |
| Meta-model (Specification, Contract, Requirement, Principle, Workflow, Risk, Definition, Conformance Rule) | All CWRM specifications |
| Normative language definitions | All CWRM specifications |
| Identifier policy | All CWRM specifications |
| Versioning rules | All CWRM specifications |
| Traceability model | All CWRM specifications |

### Guarantees

A specification that conforms to STD-001 guarantees:

- Every normative element is uniquely identifiable.
- Every requirement is verifiable.
- Dependencies are explicit and valid.
- The interface (inputs, outputs, guarantees) is exposed.
- The boundary (Out of Scope) is explicit.

### Non-Guarantees

| What | Owner |
|---|---|
| Research methodology correctness | CWRM-001 — Research Method |
| Interview quality | CWRM-020 — Interview Protocol |
| Evidence validity | CWRM-050 — Evidence Framework |

---

## 2. Abstract

This specification defines the normative standard governing the structure, semantics, and lifecycle of every specification belonging to the Clinical Work Research Method (CWRM).

Its objective is to ensure that every CWRM specification is: consistent, traceable, verifiable, versioned, and interoperable with the rest of the corpus.

This specification does not define the CWRM methodology itself. It defines how CWRM specifications SHALL be written.

Normative language:

- **SHALL** — mandatory. No exception unless explicitly documented.
- **SHALL NOT** — absolute prohibition.
- **SHOULD** — strong recommendation. Deviation must be justified.
- **SHOULD NOT** — generally discouraged.
- **MAY** — optional behaviour.
- *INFORMATIVE* — non-normative content. Examples, notes, annexes.

---

## 3. Purpose

Without a shared structural standard, specifications in a growing corpus become internally inconsistent. An author producing CWRM-050 today should not need to reverse-engineer the conventions used by the author of CWRM-020.

CWRM-STD-001 provides:

- a single meta-model that all authors apply uniformly,
- a section structure that all specs follow,
- an identifier policy that prevents collisions,
- a traceability model that makes the corpus auditable.

---

## 4. Scope

This specification applies to every normative CWRM document, including:

- Core Specifications
- Governance Specifications
- Future Extensions

---

## 5. Normative Definitions

**Specification** — A normative CWRM document following this standard. Contains objects defined in the meta-model (§8).

**Meta-model** — The set of object types (Specification, Contract, Requirement, Principle, Workflow, Risk, Definition, Conformance Rule) from which every specification is built.

**Normative** — Carrying binding methodological force. Non-compliance constitutes a conformance failure.

**Informative** — Non-binding. Examples, notes, appendices.

**Identifier** — A globally unique, immutable string assigned to every object. Once assigned, never reused.

**Traceability** — The property of being able to follow any normative element from principle to requirement to workflow to artifact to conformance rule.

---

## 6. Design Principles

**STD-P-001 — Single Responsibility**
> Each specification SHALL define one responsibility only.

*Motivation:* Specifications with multiple responsibilities accumulate scope creep over time, making their contracts impossible to evaluate.
*Consequences:* Cross-cutting concerns require a dedicated specification.
*Related Requirements:* STD-REQ-001

---

**STD-P-002 — Explicit Contracts**
> Each specification SHALL expose its inputs and outputs.

*Motivation:* A specification without a contract cannot be composed with other specifications.
*Consequences:* The Contract section is mandatory and must be written before content sections.
*Related Requirements:* STD-REQ-002

---

**STD-P-003 — Traceability**
> Every normative element SHALL be uniquely identifiable.

*Motivation:* Traceability is the primary audit mechanism for the CWRM corpus.
*Consequences:* Every Principle, Requirement, Workflow, Risk, and Conformance Rule carries a unique identifier.
*Related Requirements:* STD-REQ-003, STD-REQ-012

---

**STD-P-004 — No Duplication**
> A concept SHALL be defined exactly once.

*Motivation:* Duplicated definitions diverge over time, creating corpus inconsistencies.
*Consequences:* Definitions are centralized in CWRM-100 — Glossary. Specifications reference, not redefine.
*Related Requirements:* STD-REQ-004

---

**STD-P-005 — Layer Independence**
> Specifications SHALL depend only on lower layers. Circular dependencies are prohibited.

*Motivation:* Circular dependencies make the corpus impossible to evolve without breaking other specs.
*Consequences:* The layer architecture (CWRM-002) governs which dependencies are permitted.
*Related Requirements:* STD-REQ-005

---

**STD-P-006 — Testability**
> Every normative requirement SHALL be verifiable.

*Motivation:* An unverifiable requirement is a belief, not a standard.
*Consequences:* Every requirement includes a Verification field describing exactly how compliance is assessed.
*Related Requirements:* STD-REQ-009

---

**STD-P-007 — Explicit Boundaries**
> Each specification SHALL explicitly define what is outside its responsibility.

*Motivation:* Boundary ambiguity is the leading cause of scope creep in evolving specifications.
*Consequences:* The Out of Scope section is mandatory in every specification.
*Related Requirements:* STD-REQ-002

---

## 7. Meta-Model

Every specification is composed of objects. The following objects are normative.

### 7.1 Specification

Root object.

| Attribute | Type | Required |
|---|---|---|
| Identifier | String (`CWRM-NNN`) | SHALL |
| Name | String | SHALL |
| Version | String (`X.Y.Z`) | SHALL |
| Status | Enum (Draft / Review / Accepted / Deprecated) | SHALL |
| Purpose | String | SHALL |
| Scope | String | SHALL |
| Dependencies | List of Specification Identifiers | SHALL |
| References | List of URIs or document identifiers | SHOULD |

### 7.2 Contract

Defines the interface of the specification within the CWRM pipeline.

| Field | Required |
|---|---|
| Inputs | SHALL |
| Outputs | SHALL |
| Guarantees | SHALL |
| Non-Guarantees | SHALL |

A specification that does not expose a complete Contract is non-conformant.

### 7.3 Requirement

A normative obligation.

| Field | Required |
|---|---|
| Identifier (`[PREFIX]-REQ-[NNN]`) | SHALL |
| Title | SHALL |
| Normative Level (`SHALL / SHOULD / MAY`) | SHALL |
| Statement | SHALL |
| Verification | SHALL |
| Rationale | SHALL |
| Dependencies | SHALL (or `—`) |
| Related Risks | SHALL (or `—`) |
| Revision History | SHALL |

### 7.4 Principle

A methodological rule motivating requirements.

| Field | Required |
|---|---|
| Identifier (`[PREFIX]-P-[NNN]`) | SHALL |
| Statement | SHALL |
| Motivation | SHALL |
| Consequences | SHALL |
| Related Requirements | SHALL (or `—`) |

### 7.5 Workflow

An ordered sequence of activities.

| Field | Required |
|---|---|
| Identifier (`WF-[PREFIX]-[NNN]`) | SHALL |
| Inputs | SHALL |
| Outputs | SHALL |
| Steps | SHALL |
| Success Criteria | SHALL |
| Failure Conditions | SHALL |

### 7.6 Risk

A methodological threat.

| Field | Required |
|---|---|
| Identifier (`RISK-[NNN]`) | SHALL |
| Description | SHALL |
| Likelihood | SHALL (High / Medium / Low) |
| Impact | SHALL (High / Medium / Low) |
| Mitigation | SHALL |
| Related Requirements | SHALL (or `—`) |

### 7.7 Definition

A normative concept.

| Field | Required |
|---|---|
| Identifier (`DEF-[ConceptName]`) | SHALL |
| Term | SHALL |
| Statement | SHALL |
| Source specification | SHALL |

Definitions SHALL be centralized in CWRM-100 — Glossary. No definition SHALL appear in two specifications.

### 7.8 Conformance Rule

Defines how compliance is evaluated.

| Field | Required |
|---|---|
| Identifier (`CONF-[NNN]`) | SHALL |
| Verification Method | SHALL |
| Acceptance Criteria | SHALL |
| Evidence Required | SHALL |

---

## 8. Specification Structure

Every specification SHALL follow sections in the order below. No mandatory section may be omitted without documented justification.

| # | Section | Mandatory |
|---|---|---|
| 0 | Metadata | SHALL |
| 1 | Contract | SHALL |
| 2 | Abstract | SHALL |
| 3 | Purpose | SHALL |
| 4 | Scope | SHALL |
| 5 | Normative Definitions | SHALL |
| 6 | Principles | SHALL |
| 7 | Requirements | SHALL |
| 8 | Workflow | SHALL (or justified absence) |
| 9 | Quality Assurance | SHALL |
| 10 | Conformance | SHALL |
| 11 | Out of Scope | SHALL |
| 12 | Dependencies | SHALL |
| 13 | References | SHOULD |
| 14 | Appendices (Informative) | MAY |

Domain-specific sections (e.g., Ethics, Data Management) MAY be inserted after the Workflow section where methodologically justified.

---

## 9. Normative Language

The following keywords SHALL be interpreted exactly as defined here. No other interpretation is permitted.

| Keyword | Meaning |
|---|---|
| SHALL | Mandatory requirement. No exception unless explicitly documented. |
| SHALL NOT | Absolute prohibition. |
| SHOULD | Strong recommendation. Deviation must be justified in an MD Record or documented exception. |
| SHOULD NOT | Generally discouraged. Deviation requires justification. |
| MAY | Optional behaviour, permissible without justification. |
| *INFORMATIVE* | Non-normative content. Examples, notes, appendices. No binding force. |

---

## 10. Relationship Model

Normative objects SHALL be linked explicitly using the following allowed relationships.

```
Principle
    motivates
    ──────▶ Requirement

Requirement
    mitigates
    ──────▶ Risk

Requirement
    verified_by
    ──────▶ Conformance Rule

Workflow
    produces
    ──────▶ Artifact

Workflow
    consumes
    ──────▶ Artifact

Specification
    depends_on
    ──────▶ Specification
```

No undefined relationship SHALL be introduced without extending this standard.

---

## 11. Normative Requirements

---

**STD-REQ-001**
**Title:** Section Structure
**Normative Level:** SHALL
**Statement:** Every specification SHALL include all mandatory sections defined in §8, in the order specified.
**Verification:** Structural review of published specification.
**Rationale:** Inconsistent section ordering breaks cross-specification navigation and automated tooling.
**Dependencies:** STD-P-001
**Related Risks:** RISK-STD-001
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-002**
**Title:** Contract Completeness
**Normative Level:** SHALL
**Statement:** Every specification SHALL expose a complete Contract with Inputs, Outputs, Guarantees, and Non-Guarantees before any content section is written.
**Verification:** Contract section review: all four subsections present and non-empty.
**Rationale:** A contract written after the content tends to rationalize rather than define. Writing first forces the author to know what the spec produces.
**Dependencies:** STD-P-002, STD-P-007
**Related Risks:** RISK-STD-002
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-003**
**Title:** Unique Identifiers
**Normative Level:** SHALL
**Statement:** Every normative object SHALL possess a globally unique identifier following the Identifier Policy (§12).
**Verification:** Identifier registry check; no duplicate across corpus.
**Rationale:** Duplicate identifiers prevent reliable cross-referencing and traceability.
**Dependencies:** STD-P-003
**Related Risks:** RISK-STD-003
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-004**
**Title:** No Duplicate Definitions
**Normative Level:** SHALL
**Statement:** A concept SHALL be defined exactly once. All definitions SHALL be centralized in CWRM-100 — Glossary.
**Verification:** Search across corpus for duplicated term definitions.
**Rationale:** Definitions that appear in multiple specs diverge over time and produce silent inconsistencies.
**Dependencies:** STD-P-004
**Related Risks:** RISK-STD-004
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-005**
**Title:** No Circular Dependencies
**Normative Level:** SHALL
**Statement:** Specifications SHALL depend only on lower-layer specifications. Circular dependencies are prohibited.
**Verification:** Dependency graph check (no cycles).
**Rationale:** Circular dependencies prevent incremental update and independent review.
**Dependencies:** STD-P-005
**Related Risks:** RISK-STD-005
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-006**
**Title:** Requirement Object Completeness
**Normative Level:** SHALL
**Statement:** Every requirement SHALL include all fields defined in the Requirement meta-model (§7.3).
**Verification:** Per-requirement field audit.
**Rationale:** An incomplete requirement cannot be audited. Missing Verification makes the requirement unenforceable. Missing Related Risks breaks the traceability chain.
**Dependencies:** STD-P-003, STD-P-006
**Related Risks:** RISK-STD-006
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-007**
**Title:** Principle Object Completeness
**Normative Level:** SHALL
**Statement:** Every principle SHALL include Identifier, Statement, Motivation, Consequences, and Related Requirements.
**Verification:** Per-principle field audit.
**Rationale:** A principle without Motivation cannot be evaluated for applicability in edge cases. A principle without Related Requirements floats disconnected from the normative obligations it motivates.
**Dependencies:** STD-P-003
**Related Risks:** —
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-008**
**Title:** Workflow Object Completeness
**Normative Level:** SHALL
**Statement:** Every workflow SHALL include Identifier, Inputs, Outputs, Steps, Success Criteria, and Failure Conditions.
**Verification:** Per-workflow field audit.
**Rationale:** A workflow without Failure Conditions cannot handle the non-happy path. Success Criteria are the specification's testable claim about what a correct execution produces.
**Dependencies:** STD-P-006
**Related Risks:** RISK-STD-007
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-009**
**Title:** Requirement Verifiability
**Normative Level:** SHALL
**Statement:** Every requirement's Verification field SHALL describe a concrete method by which compliance can be assessed.
**Verification:** Verification field must reference an observable, checkable action (document review, recording check, log inspection, etc.). A Verification field that reads "As defined" or "Obvious" is non-conformant.
**Rationale:** STD-P-006 — an unverifiable requirement has no enforcement mechanism.
**Dependencies:** STD-P-006
**Related Risks:** RISK-STD-006
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-010**
**Title:** Out of Scope Section
**Normative Level:** SHALL
**Statement:** Every specification SHALL include an Out of Scope section that explicitly names what this specification does not govern and which specification is responsible.
**Verification:** Out of Scope section present; each item names a responsible specification or party.
**Rationale:** STD-P-007 — explicit boundaries prevent scope creep more effectively than implicit ones.
**Dependencies:** STD-P-007
**Related Risks:** RISK-STD-002
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-011**
**Title:** Versioning Format
**Normative Level:** SHALL
**Statement:** Every specification SHALL expose a version in Major.Minor.Revision format. Major versions indicate breaking changes. Minor versions indicate compatible extensions. Revisions indicate corrections.
**Verification:** Version field format check.
**Rationale:** Semantic versioning enables consumers of a specification to assess upgrade impact without reading the full diff.
**Dependencies:** —
**Related Risks:** RISK-STD-008
**Revision History:** v1.0.0 — Initial

---

**STD-REQ-012**
**Title:** Traceability Chain
**Normative Level:** SHALL
**Statement:** Every specification SHALL support the traceability chain: Principle → Requirement → Workflow → Artifact → Conformance Rule.
**Verification:** Traceability matrix review: every requirement linked to at least one principle; every workflow linked to at least one requirement; every output artifact linked to at least one conformance rule.
**Rationale:** STD-P-003 — the traceability chain is the primary audit mechanism for the corpus.
**Dependencies:** STD-P-003
**Related Risks:** RISK-STD-003
**Revision History:** v1.0.0 — Initial

---

## 12. Identifier Policy

Every object SHALL possess a globally unique identifier. Identifiers SHALL never be reused after retirement.

| Object Type | Pattern | Example |
|---|---|---|
| Specification | `CWRM-[NNN]` | `CWRM-020` |
| Specification (Standard) | `CWRM-STD-[NNN]` | `CWRM-STD-001` |
| Requirement | `[PREFIX]-REQ-[NNN]` | `IP-REQ-004` |
| Principle | `[PREFIX]-P-[NNN]` | `STD-P-001` |
| Workflow | `WF-[PREFIX]-[NNN]` | `WF-INT-001` |
| Risk | `RISK-[PREFIX]-[NNN]` | `RISK-STD-001` |
| Conformance Rule | `CONF-[PREFIX]-[NNN]` | `CONF-INT-001` |
| Definition | `DEF-[ConceptName]` | `DEF-Participant` |

Prefix convention:

| Specification | Prefix |
|---|---|
| STD-001 Standard | STD |
| CWRM-020 Interview Protocol | INT |
| CWRM-030 Coding Manual | CM |
| CWRM-040 ACT Taxonomy | AT |
| CWRM-050 Evidence Framework | EV |
| CWRM-060 Design Reasoning | DR |
| CWRM-070 Validation Protocol | VP |

---

## 13. Versioning

Every specification SHALL expose a version string in `Major.Minor.Revision` format.

| Change type | Version impact | Example |
|---|---|---|
| Breaking methodological change (Contract, Scope changed) | Major++ | 1.0.0 → 2.0.0 |
| Compatible extension (new sections, new requirements) | Minor++ | 1.0.0 → 1.1.0 |
| Correction without semantic impact | Revision++ | 1.0.0 → 1.0.1 |

---

## 14. Traceability

Every normative object SHALL support complete traceability.

Minimum chain:

```
Principle
    │
    motivates
    ▼
Requirement
    │
    implemented_by
    ▼
Workflow
    │
    produces
    ▼
Artifact
    │
    verified_by
    ▼
Conformance Rule
```

Additionally:

```
Requirement
    │
    mitigates
    ▼
Risk
```

Traceability SHALL remain valid across specification revisions.

---

## 9. Quality Assurance

Before a specification advances from Draft to Review:

| Criterion | Verified by |
|---|---|
| All mandatory sections present | STD-REQ-001 |
| Contract complete (4 subsections) | STD-REQ-002 |
| All identifiers unique | STD-REQ-003 |
| No duplicated definitions | STD-REQ-004 |
| No circular dependencies | STD-REQ-005 |
| All requirements have 8 fields | STD-REQ-006 |
| All principles have 5 fields | STD-REQ-007 |
| All workflows have 6 fields | STD-REQ-008 |
| All Verification fields concrete | STD-REQ-009 |
| Out of Scope section present | STD-REQ-010 |
| Version in X.Y.Z format | STD-REQ-011 |

---

## 10. Conformance

A specification conforms to CWRM-STD-001 if:

- [ ] All mandatory sections are present in the correct order (STD-REQ-001)
- [ ] The Contract section exposes Inputs, Outputs, Guarantees, Non-Guarantees (STD-REQ-002)
- [ ] All normative objects carry unique, non-reused identifiers (STD-REQ-003)
- [ ] No definition appears in more than one specification (STD-REQ-004)
- [ ] The dependency graph is acyclic (STD-REQ-005)
- [ ] All requirements include: Identifier, Title, Normative Level, Statement, Verification, Rationale, Dependencies, Related Risks, Revision History (STD-REQ-006)
- [ ] All principles include: Identifier, Statement, Motivation, Consequences, Related Requirements (STD-REQ-007)
- [ ] All workflows include: Identifier, Inputs, Outputs, Steps, Success Criteria, Failure Conditions (STD-REQ-008)
- [ ] All Verification fields describe a concrete, observable check (STD-REQ-009)
- [ ] An Out of Scope section is present (STD-REQ-010)
- [ ] Version follows X.Y.Z format (STD-REQ-011)
- [ ] Traceability chain is resolvable (STD-REQ-012)

---

## 11. Out of Scope

CWRM-STD-001 does not define:

- **Qualitative research methodology** → CWRM-001 — Research Method
- **Interview conduct** → CWRM-020 — Interview Protocol
- **Coding and ACT extraction** → CWRM-030 — Coding Manual
- **ACT taxonomy** → CWRM-040
- **Evidence classification** → CWRM-050 — Evidence Framework
- **Design reasoning** → CWRM-060
- **Validation methods** → CWRM-070 — Validation Protocol
- **Glossary content** → CWRM-100 — Glossary

---

## 12. Dependencies

### Incoming

| Specification | Dependency nature |
|---|---|
| CWRM-000 — Scope Guard | Overall governance, normative language baseline |

### Outgoing

| Specification | Dependency nature |
|---|---|
| All CWRM specifications | Structural model, identifier policy, versioning, traceability |

---

## 13. Future Extensions

CWRM-STD-001 is designed to support future object types without breaking compatibility.

Planned extensions (informative):

- Evidence Rule
- Decision Record (formalized)
- Research Metric
- Validation Dataset
- AI-Assisted Analysis Rule

New object types SHALL extend, not contradict, this specification.

---

## 14. References

### Internal

| Reference | Description |
|---|---|
| CWRM-000 | Scope Guard — Constitution |
| CWRM-002 | Layer Architecture (layer definitions) |
| CWRM-100 | Glossary *(forthcoming — mandated by STD-P-004)* |

### External

*To be completed.*

---

## 15. Appendices *(informative)*

**Appendix A — Worked Example: Requirement with All Fields**

```
IP-REQ-004
Title: Open Questions
Normative Level: SHALL
Statement: The interviewer SHALL use open-ended questions.
Verification: Review of interview recording or transcript — no closed question detected.
Rationale: Open-ended questions elicit richer and less constrained descriptions of work.
           Closed questions bias toward expected answers.
Dependencies: RP-002
Related Risks: RISK-INT-002 (Interviewer bias)
Revision History:
  - 1.0.0-RC (2026-07-31): Initial
```

**Appendix B — Compliance Checklist for New Specification Authors**

Before submitting a new specification for review:

- [ ] Did I write the Contract before the content sections?
- [ ] Is every normative requirement uniquely identified?
- [ ] Does every requirement have a Verification field describing a concrete check?
- [ ] Does every requirement have a Related Risks field?
- [ ] Does every requirement have a Revision History entry?
- [ ] Does every principle have Motivation, Consequences, and Related Requirements?
- [ ] Is the section order consistent with §8?
- [ ] Is the version in X.Y.Z format?
- [ ] Are all new terms delegated to CWRM-100 rather than defined locally?
- [ ] Does the Out of Scope section name responsible parties?

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-31 | 1.0.0-DRAFT | Initial draft |
