# CWRM-[NNN] — [Title]

---

## 1. Metadata

| Field | Value |
|---|---|
| Document ID | CWRM-[NNN] |
| Title | [Full title] |
| Version | 0.1 |
| Status | Draft |
| Layer | [000 Foundations / 100 Method / 200 Research / 300 Translation / 900 Publication] |
| Date | [YYYY-MM-DD] |
| Depends on | [CWRM-XXX, CWRM-YYY] |
| Required by | [CWRM-ZZZ — downstream specification] |
| Supersedes | — |

---

## 2. Abstract

[One paragraph. What this specification defines. What normative language it uses.]

This document uses the following normative language:

- **SHALL** — mandatory. Non-compliance disqualifies the output.
- **SHOULD** — recommended. Deviation must be documented.
- **MAY** — optional, permissible.

---

## 3. Contract

This section defines the formal interface of this specification within the CWRM pipeline.

### Inputs

| Input | Source |
|---|---|
| [Input name] | [CWRM-XXX or internal] |

### Outputs

| Output | Consumer |
|---|---|
| [Output name] | [CWRM-ZZZ or study records] |

### Guarantees

[This specification guarantees that, for every compliant output delivered:]

- [Guarantee 1]
- [Guarantee 2]

### Does NOT Guarantee

| What | Responsible specification |
|---|---|
| [Capability outside this spec's scope] | [CWRM-ZZZ] |

---

## 4. Purpose

[Why this specification exists. What problem it solves. What quality it ensures in the pipeline.]

---

## 5. Scope

[What this document covers.]

---

## 6. Out of Scope

This section is distinct from Section 5. It protects the boundary of this specification.

This document does not define, govern, or evaluate:

- **[Topic]** → [CWRM-ZZZ]
- **[Topic]** → [Responsible party]

Any reviewer or researcher finding content related to the above should flag it as a scope violation.

---

## 7. Normative Definitions

[Define terms used normatively in this specification. Do not repeat definitions from CWRM-000.]

**[Term]** — [Definition]

---

## 8. Research Principles

[Optional. Include only if this specification introduces principles not covered in CWRM-000.]

**RP-[N] — [Principle name]**

> [One-sentence normative statement.]

[Explanation if needed.]

---

## [9–N]. Domain Sections

[Specification-specific content. Each section describes the procedure in prose. Requirements are defined in the Normative Requirements section (below).]

*Prose description of what happens in this phase. References normative requirements where applicable.*

---

## [N]. Normative Requirements

All normative requirements for this specification are defined in this section. Domain sections (above) describe the procedure; this section defines what is mandatory, verifiable, and traceable.

---

**[PREFIX]-REQ-[NNN]**
**Title:** [Short title — 3–5 words]
**Statement:** [Requirement text using SHALL / SHOULD / MAY.]
**Verification:** [How compliance is verified — what an auditor checks.]
**Rationale:** [Why this requirement exists — non-obvious justification only.]
**Dependencies:** [RP-NNN / PREFIX-REQ-NNN / Section N — or —]

---

[Prefix convention: IP = Interview Protocol, CM = Coding Manual, AT = ACT Taxonomy, EV = Evidence, DR = Design Reasoning, VP = Validation Protocol]

---

## [N+1]. Quality Assurance

[Checklist of criteria that must be satisfied for the output to be considered valid.]

### [Phase or category]

| Criterion | Requirement |
|---|---|
| [Criterion] | [REQ-NNN] |

[Output is valid only if all criteria are met.]

---

## [N+2]. Ethics

[Include if this specification involves human participants, personal data, or regulated activities.]

---

## [N+3]. Outputs

| Output | Format | Mandatory |
|---|---|---|
| [Output] | [Format] | Yes / No / Conditional |

---

## [N+4]. Rationale

[Justification for non-obvious requirements only.]

| Requirement | Justification |
|---|---|
| [PREFIX]-REQ-[NNN] | [Why this requirement exists — justification that is not self-evident.] |

---

## [N+5]. Conformance

[A specification or study complies with this document if and only if:]

- [ ] All [PREFIX]-REQ-001 through [PREFIX]-REQ-[NNN] are satisfied, or deviations are documented.
- [ ] [Specific condition]
- [ ] [Specific condition]

---

## Historique

| Date | Version | Nature |
|---|---|---|
| [YYYY-MM-DD] | 0.1 | Draft initial |

---

## Template Usage Notes

> Remove this section before publishing.

**Requirement prefixes:**

| Specification | Prefix |
|---|---|
| CWRM-020 Interview Protocol | IP-REQ |
| CWRM-030 Coding Manual | CM-REQ |
| CWRM-040 ACT Taxonomy | AT-REQ |
| CWRM-050 Evidence Framework | EV-REQ |
| CWRM-060 Design Reasoning | DR-REQ |
| CWRM-070 Validation Protocol | VP-REQ |

**Dependency rule:** Every specification must declare both `Depends on` (upstream) and `Required by` (downstream) in Metadata. A specification with no `Required by` is either a terminal node or incomplete.

**Contract rule:** The Contract must be filled before any content sections are written. Writing the Contract first forces the author to clarify what the specification produces before describing how.

**Version rule:**
- v0.x — Draft under development
- v1.0 — First stable release (requires Conformance checklist complete and peer review)
- vX.0 — Major revision (Contract, Scope, or fundamental requirements changed)
- vX.Y — Minor revision (editorial, clarifications, examples)
