# CWRM-STD-002 — Identity & Identifier Standard

---

## 0. Metadata

| Field | Value |
|---|---|
| Document ID | CWRM-STD-002 |
| Title | Identity & Identifier Standard |
| Version | 1.0.0-DRAFT |
| Status | Draft — Pending Review |
| Layer | 000 — Foundations |
| Date | 2026-07-31 |
| Depends on | CWRM-000, CWRM-STD-001 |
| Required by | All CWRM specifications and artifacts |

### Changelog

| Version | Date | Nature |
|---|---|---|
| 0.1.0 | 2026-07-31 | Initial draft — sequential identifiers, DEF-ConceptName |
| 1.0.0-DRAFT | 2026-07-31 | Major revision — three-level identity model, knowledge object principle, DEF numeric, minting policy, future persistent resolution |

---

## 1. Contract

### Inputs

| Input | Source |
|---|---|
| Object type classification | CWRM-STD-001 §7 (meta-model) |
| Corpus governance rules | CWRM-000 |

### Outputs

| Output | Consumer |
|---|---|
| Identity model (three-level) | All CWRM specifications and artifacts |
| Identifier syntax rules | All corpus tooling and authoring |
| Prefix registry | All authors and systems |
| Minting policy | Corpus registry |
| Cross-reference policy | All specifications |

### Guarantees

For every object in the CWRM corpus that conforms to this standard:

- It has an internal identifier that is immutable from creation.
- Its identifier is unique within the CWRM corpus namespace.
- Its identifier syntax is compatible with future persistent identifier infrastructure.
- Its creation context (provenance) is documented separately from its identity.
- Retired identifiers are permanently reserved and never reused.

### Non-Guarantees

| What | Owner |
|---|---|
| Identifier resolution infrastructure | Future governance standard |
| FAIR compliance implementation | Future governance standard |
| Cross-organization uniqueness | Namespace extension — future |

---

## 2. Abstract

This specification defines the identity model governing every object in the CWRM corpus. It answers two distinct questions: *What is the identity of a CWRM object?* and *How is that identity expressed as an identifier?*

The specification introduces a three-level model separating internal identity, canonical address, and provenance. This separation is the architectural foundation for a corpus that is expected to grow across multiple studies, evolve across decades, and eventually participate in linked scientific data ecosystems.

Normative language follows CWRM-STD-001 §9.

---

## 3. Purpose

### The Identity Problem in Research Corpora

A naive identifier standard asks: *How do we name things?*

CWRM-STD-002 asks a deeper question first: *What is the identity of a CWRM scientific object?*

These are distinct questions with different answers.

### CWRM Objects as Knowledge Objects

A CWRM artifact — an ACT, an Observation, an Invariant — is not a data record belonging to a study. It is a **knowledge object** existing in a knowledge graph that grows across time, studies, and researchers.

This distinction has a concrete consequence:

> ACT-001245, representing the clinical action "prepares consultation," was first documented in Study S01 from Interview INT-034. In Study S03, a different team documents the same pattern. They do not create ACT-001246 — they reference ACT-001245. The ACT's identity does not change. What changes is its provenance record, which now includes Study S03 as an additional source.

The collection context (study, interview, coder, date) is provenance metadata. It is not identity. If an ACT is reassigned from one interview to another during correction, its identity is unchanged. Its provenance record is updated.

This principle drives every decision in this specification.

### The Separation of Identity, Address, and Provenance

Three concepts are systematically confused in research data systems:

| Concept | Question | Example |
|---|---|---|
| **Identity** | What is this object? | `ACT-001245` |
| **Address** | Where can it be found? | `cwrm:ACT-001245` |
| **Citation** | How does a publication reference it? | `CWRM Corpus, ACT-001245` or `ark:/...` |
| **Provenance** | How was it created? | Study S01, Interview INT-034, Coder R02 |

STD-002 governs Identity and Address. It prepares the ground for Citation and acknowledges Provenance as a metadata responsibility.

---

## 4. Scope

This specification applies to every CWRM object that requires a persistent identifier:

- Specifications (`CWRM-NNN`)
- Governance standards (`CWRM-STD-NNN`)
- Requirements (`[PREFIX]-REQ-NNN`)
- Principles (`[PREFIX]-P-NNN`)
- Workflows (`WF-[PREFIX]-NNN`)
- Risks (`RISK-[PREFIX]-NNN`)
- Conformance Rules (`CONF-[PREFIX]-NNN`)
- Definitions (`DEF-NNN`)
- Research artifacts: ACT, OBS, INV
- Decision Records (`ADR-NNN`)
- Templates (`TMP-NNN`)
- Informative Appendices (`ANN-[PREFIX]-NNN`)

---

## 5. Normative Definitions

**Identity** — The permanent, context-independent essence of an object. Expressed as an Internal Identifier. Does not change with the object's content, status, location, or collection context.

**Internal Identifier** — The immutable string assigned to a CWRM object at creation. Forms Level 1 of the identity model.

**Canonical URI** — The stable, namespace-qualified form of an Internal Identifier. Forms Level 2 of the identity model. Future-resolvable.

**Provenance** — The record of how, when, by whom, and in which context an object was created. Not part of identity. Documented in the object's metadata record.

**Corpus Registry** — The authoritative index of all Internal Identifiers assigned in the CWRM corpus. The single source of truth for identifier uniqueness.

**Minting** — The act of assigning an Internal Identifier to a newly created object and recording it in the Corpus Registry.

**Retirement** — The act of permanently marking an Internal Identifier as Deprecated in the Corpus Registry when the object it represents is no longer active.

---

## 6. Design Principles

**ID-P-001 — Identity Independence**
> The identity of a CWRM object SHALL be independent of its collection context.

*Motivation:* An ACT represents a pattern of clinical work. That pattern exists whether it was first documented in Study S01 or Study S10. Encoding the study or interview in the identifier couples identity to provenance — a coupling that breaks when the corpus evolves.
*Consequences:* No study identifier, interview identifier, or coder identifier appears in an Internal Identifier.
*Related Requirements:* ID-REQ-003, ID-REQ-004

---

**ID-P-002 — Immutability**
> An Internal Identifier SHALL NOT change after minting.

*Motivation:* A reference to `ACT-001245` in a 2026 publication must resolve to the same object in 2046. References stored in dependent objects (OBS, INV, REQ) must not break when an object is corrected, renamed, or reorganized.
*Consequences:* Title changes are permitted. Identifier changes are not. Object reclassification (status change, provenance correction) does not change the identifier.
*Related Requirements:* ID-REQ-005

---

**ID-P-003 — Permanent Reservation**
> An Internal Identifier SHALL NOT be reused after retirement.

*Motivation:* If `ACT-000247` is retired and its slot is reused, any historical reference to `ACT-000247` becomes ambiguous — it could refer to the original object or its replacement.
*Consequences:* Retired identifiers remain in the Corpus Registry permanently, marked Deprecated.
*Related Requirements:* ID-REQ-007

---

**ID-P-004 — Corpus Uniqueness**
> Every Internal Identifier SHALL be unique within the CWRM corpus namespace.

*Motivation:* Uniqueness is the minimum property required for an identifier to be an identifier. Without it, references are ambiguous.
*Consequences:* The Corpus Registry is the enforcement mechanism. No identifier is assigned without first verifying it is not already in use.
*Related Requirements:* ID-REQ-001, ID-REQ-008

---

**ID-P-005 — Human Readability**
> Internal Identifiers SHOULD remain legible by a human researcher without specialized tooling.

*Motivation:* A corpus maintained by researchers, not engineers, must be navigable in plain text. A researcher reading `ACT-001245` immediately knows this is an Activity Unit. A UUID conveys nothing.
*Consequences:* Type-prefixed, zero-padded numeric sequences are the required format. UUIDs are not used.
*Related Requirements:* ID-REQ-002

---

**ID-P-006 — Future Compatibility**
> The Internal Identifier syntax SHALL remain compatible with future persistent identifier infrastructure.

*Motivation:* CWRM artifacts will eventually need to be citable in scientific publications. The identifier format chosen today must be expressible as a URI without structural change.
*Consequences:* Internal Identifiers are designed to be prefixable as `cwrm:[identifier]` and expandable to `https://[resolver]/[identifier]` without modification.
*Related Requirements:* ID-REQ-009

---

## 7. Identity Model

Every CWRM object has three identity-related records. These records serve different purposes and have different properties.

### Level 1 — Internal Identifier

```
ACT-001245
OBS-000028
INV-000009
IP-REQ-004
CWRM-020
DEF-017
```

**Properties:**
- Immutable from minting
- Corpus-unique
- Human-readable type prefix
- Zero-padded numeric sequence
- No encoding of study, interview, coder, date, or location

**Scope:** CWRM corpus. Globally unique within the CWRM namespace.

---

### Level 2 — Canonical URI

```
cwrm:ACT-001245
cwrm:OBS-000028
cwrm:INV-000009
```

**Properties:**
- Derived from Level 1 by prepending the `cwrm:` namespace prefix
- Stable from the moment Level 1 exists
- Compatible with CURIE syntax
- Expandable to `https://[resolver]/ACT-001245` when resolver infrastructure exists
- Compatible with RDF, linked data, and FAIR principles

**Scope:** Global, pending resolver infrastructure.

**Current status:** The `cwrm:` namespace is declared but not yet resolvable. See Section 12.

---

### Level 3 — Provenance Record

```yaml
id: ACT-001245
study_id: S01
interview_id: INT-034
transcript_id: TR-003
coder_id: R02
created_date: 2026-07-31
last_modified: 2026-08-15
studies_referencing: [S01, S03]
```

**Properties:**
- Mutable — can be corrected without affecting Levels 1 or 2
- Documented as part of the object's metadata record
- NOT part of the Internal Identifier
- Can be extended without changing the identifier

**Scope:** Internal research record. Managed alongside the artifact.

---

### The Separation in Practice

```
OBJECT:           ACT-001245

Identity (L1):    ACT-001245          ← never changes
Address (L2):     cwrm:ACT-001245     ← never changes
Provenance (L3):  study: S01          ← can change
                  interview: INT-034  ← can change (error correction)
                  coder: R02          ← can change
```

If a coder discovers that `ACT-001245` was extracted from Interview INT-035, not INT-034, the correction updates Level 3 only. The object's identity and all references to it remain valid.

---

## 8. Identifier Syntax

### Formal Grammar (ABNF — RFC 5234)

```abnf
identifier    = type-prefix "-" sequence
              / type-prefix "-" domain "-" sequence

type-prefix   = 1*8UPALPHA
domain        = 1*8UPALPHA
sequence      = 6DIGIT / 7DIGIT

UPALPHA       = %x41-5A    ; A-Z only — case-sensitive
DIGIT         = %x30-39    ; 0-9
```

**Rules:**
- All characters are uppercase. `act-001245` is not a valid identifier.
- The hyphen (`-`) is the only permitted separator.
- No spaces, underscores, slashes, or dots in identifiers.
- Zero-padding is mandatory: `ACT-001245` not `ACT-1245`.
- Sequence width is 6 digits for most families. 7 digits for families expected to exceed 999,999 objects (e.g., ACT).

**Examples:**

| Valid | Invalid | Reason |
|---|---|---|
| `ACT-001245` | `ACT-1245` | Missing zero-padding |
| `IP-REQ-004` | `IP_REQ_004` | Underscore not permitted |
| `CWRM-020` | `cwrm-020` | Lowercase not permitted |
| `DEF-017` | `DEF-Participant` | Semantic name not permitted |

---

## 9. Reserved Prefixes

New prefixes require corpus governance approval before use.

| Prefix | Object Type | Sequence width |
|---|---|---|
| `CWRM` | Specification | 3 digits |
| `CWRM-STD` | Governance Standard | 3 digits |
| `ACT` | Activity Unit (research artifact) | 7 digits |
| `OBS` | Observation (research artifact) | 6 digits |
| `INV` | Invariant (research artifact) | 6 digits |
| `DEF` | Definition (in CWRM-100 Glossary) | 4 digits |
| `REQ` | Generic Requirement | 4 digits |
| `IP-REQ` | Interview Protocol Requirement | 3 digits |
| `CM-REQ` | Coding Manual Requirement | 3 digits |
| `AT-REQ` | ACT Taxonomy Requirement | 3 digits |
| `EV-REQ` | Evidence Framework Requirement | 3 digits |
| `DR-REQ` | Design Reasoning Requirement | 3 digits |
| `VP-REQ` | Validation Protocol Requirement | 3 digits |
| `STD-REQ` | Standard Requirement | 3 digits |
| `ID-REQ` | Identity Standard Requirement | 3 digits |
| `RP` | Research Principle | 3 digits |
| `ID-P` | Identity Principle | 3 digits |
| `STD-P` | Standard Principle | 3 digits |
| `WF` | Workflow | 3 digits (+ domain) |
| `RISK` | Risk | 3 digits (+ domain) |
| `CONF` | Conformance Rule | 3 digits (+ domain) |
| `ADR` | Architectural / Design Decision Record | 4 digits |
| `AR` | Architecture Review (revue précédant l'ouverture d'un Workspace — ADR-0019) | 3 digits |
| `TMP` | Template | 3 digits |
| `ANN` | Informative Appendix | 3 digits (+ domain) |
| `REF` | Bibliographic Reference | 4 digits |

---

## 10. Minting Policy

**When is an identifier assigned?**

An Internal Identifier is assigned at **first creation** — when an object is written to the corpus, regardless of its status (Draft, Review, Accepted).

The identifier is recorded in the Corpus Registry at that moment.

**Rationale:** Minting at Draft ensures that even unstable, in-progress objects have stable references from birth. A reviewer commenting on a Draft ACT needs to cite it unambiguously.

**Registry record (minimum fields):**

```yaml
id: ACT-001245
type: ACT
title: Prepares consultation
status: Draft
minted_at: 2026-07-31
minted_by: R02
deprecated_at: null
successor_id: null
```

**Retirement record:**

```yaml
id: ACT-000247
type: ACT
title: Reviews patient folder [DEPRECATED]
status: Deprecated
minted_at: 2026-06-15
minted_by: R01
deprecated_at: 2026-08-02
successor_id: ACT-000312
```

**Registry location:** `corpus/registry.yaml` in the corpus root. Version-controlled alongside the corpus.

**Uniqueness check:** Before minting any identifier, the author SHALL verify that the identifier does not exist in `corpus/registry.yaml`. Tooling SHOULD automate this check.

---

## 11. Cross-Reference Policy

All references between CWRM objects SHALL use Internal Identifiers, not titles.

**Prohibited:**
> "See the workflow for transcript validation."

**Required:**
> "See `WF-INT-001`."

**Rationale:** Titles change. Internal Identifiers do not. References using titles break silently when objects are renamed. References using identifiers break visibly (the identifier no longer resolves) and are detected by tooling.

This applies in all contexts: specification text, research artifact metadata, decision records, publications.

---

## 12. Future Persistent Resolution

*This section is intentionally forward-looking. It defines intentions, not current capabilities.*

### Current State

CWRM identifiers are **corpus-internal** identifiers. They are unique within the CWRM corpus but are not globally unique in the broader scientific ecosystem. `ACT-001245` from CWRM is distinct from any other `ACT-001245` that may exist in another corpus — but this distinction is enforced by convention, not by technical mechanism.

### Design Constraint

The identifier syntax chosen in Section 8 SHALL remain compatible with a future persistent identifier infrastructure. No structural change to existing identifiers will be required when that infrastructure is implemented.

Specifically:

```
Internal Identifier:   ACT-001245
Canonical URI (now):   cwrm:ACT-001245
Canonical URI (future):  https://identifiers.cwrm.org/ACT-001245
```

The expansion from `cwrm:` to `https://identifiers.cwrm.org/` is a declaration update, not a corpus rename.

### Future Path

When CWRM artifacts are published to the scientific community or cited in peer-reviewed publications, the following infrastructure will be required:

1. A registered namespace (`cwrm:`) in a recognized CURIE registry
2. A resolver service mapping `cwrm:ACT-001245` to a canonical URL
3. Optionally: an ARK or Handle registration for long-term archiving

*Compatibility with FAIR principles is an explicit objective of future governance standards. STD-002 prepares the ground; it does not implement FAIR compliance.*

---

## 13. Normative Requirements

---

**ID-REQ-001**
**Title:** Corpus Uniqueness
**Normative Level:** SHALL
**Statement:** Every Internal Identifier SHALL be unique within the CWRM corpus. No two objects SHALL share an Internal Identifier.
**Verification:** Search `corpus/registry.yaml` for duplicate `id` values. Automated tooling check on every commit.
**Rationale:** Uniqueness is the minimum property required for an identifier to function as an identifier.
**Dependencies:** ID-P-004
**Related Risks:** RISK-ID-001
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-002**
**Title:** Identifier Syntax
**Normative Level:** SHALL
**Statement:** Every Internal Identifier SHALL conform to the ABNF grammar defined in Section 8. Lowercase, underscores, spaces, and dots are prohibited.
**Verification:** Regex validation: `^[A-Z]{1,8}(-[A-Z]{1,8})?-\d{3,7}$`. Automated on every object creation.
**Rationale:** Consistent syntax enables automated processing without special cases.
**Dependencies:** —
**Related Risks:** RISK-ID-002
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-003**
**Title:** No Contextual Encoding
**Normative Level:** SHALL
**Statement:** Internal Identifiers SHALL NOT encode study, interview, coder, date, or any other collection context.
**Verification:** Review of minted identifiers: no component beyond type-prefix and numeric sequence.
**Rationale:** ID-P-001 — CWRM objects are knowledge objects. Their identity is independent of their collection context. Context belongs in the provenance record (Level 3).
**Dependencies:** ID-P-001
**Related Risks:** RISK-ID-003
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-004**
**Title:** Type Prefix from Reserved Table
**Normative Level:** SHALL
**Statement:** Every Internal Identifier SHALL use a prefix from the Reserved Prefix table (Section 9). New prefixes SHALL be approved by corpus governance before use.
**Verification:** Check that `id` prefix in `corpus/registry.yaml` matches an entry in the reserved prefix table.
**Rationale:** Unauthorized prefixes create uncontrolled identifier families that cannot be queried or tooled consistently.
**Dependencies:** —
**Related Risks:** RISK-ID-004
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-005**
**Title:** Identifier Immutability
**Normative Level:** SHALL NOT
**Statement:** An Internal Identifier SHALL NOT be modified after minting, regardless of changes to the object's title, content, status, or provenance.
**Verification:** Registry audit: compare `id` field across all versions of an object's history. No `id` value change permitted.
**Rationale:** ID-P-002 — A reference made today must resolve to the same object in ten years.
**Dependencies:** ID-P-002
**Related Risks:** RISK-ID-005
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-006**
**Title:** Minting at Creation
**Normative Level:** SHALL
**Statement:** An Internal Identifier SHALL be assigned and recorded in the Corpus Registry when an object is first created, regardless of its status (Draft, Review, or other).
**Verification:** No object exists in the corpus without a corresponding entry in `corpus/registry.yaml`.
**Rationale:** Early minting ensures stable references from birth. A reviewer commenting on a Draft ACT needs to cite it unambiguously before it reaches Accepted status.
**Dependencies:** —
**Related Risks:** RISK-ID-001
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-007**
**Title:** Permanent Reservation
**Normative Level:** SHALL NOT
**Statement:** A retired Internal Identifier SHALL NOT be reused. The registry entry for a retired object SHALL be preserved permanently with `status: Deprecated`.
**Verification:** Registry audit: no `id` value appears both as Deprecated and as an active object.
**Rationale:** ID-P-003 — Reusing a retired identifier makes any historical reference to that identifier ambiguous between the original and replacement objects.
**Dependencies:** ID-P-003
**Related Risks:** RISK-ID-005
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-008**
**Title:** Registry Record Completeness
**Normative Level:** SHALL
**Statement:** Every Corpus Registry entry SHALL include: `id`, `type`, `title`, `status`, `minted_at`, `minted_by`. Deprecated entries SHALL additionally include `deprecated_at` and `successor_id` (if replaced).
**Verification:** Registry schema validation on every commit.
**Rationale:** An incomplete registry entry cannot support audit or traceability.
**Dependencies:** ID-P-004
**Related Risks:** RISK-ID-006
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-009**
**Title:** URI Compatibility
**Normative Level:** SHALL
**Statement:** The identifier syntax SHALL be compatible with `cwrm:[identifier]` CURIE form without modification.
**Verification:** All identifiers pass CURIE expansion: `cwrm:` + identifier string produces a valid URI fragment.
**Rationale:** ID-P-006 — Identifiers committed to today will need to be globally resolvable in the future. The migration cost must be zero.
**Dependencies:** ID-P-006
**Related Risks:** RISK-ID-007
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-010**
**Title:** Cross-Reference by Identifier
**Normative Level:** SHALL
**Statement:** All references between CWRM objects SHALL use Internal Identifiers. Title-based references are prohibited in normative content.
**Verification:** Review of specification text and artifact metadata: no references by title alone.
**Rationale:** Titles change. References using titles break silently. References using identifiers break visibly and are detected by tooling.
**Dependencies:** —
**Related Risks:** RISK-ID-008
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-011**
**Title:** Provenance Separation
**Normative Level:** SHALL
**Statement:** Provenance information (study, interview, coder, date, position in corpus) SHALL NOT appear in the Internal Identifier. It SHALL be documented in the object's provenance metadata record.
**Verification:** No provenance term (study ID, interview ID, researcher ID) present in identifier string.
**Rationale:** ID-P-001 — Provenance may be corrected, extended, or augmented without changing the object's identity.
**Dependencies:** ID-P-001
**Related Risks:** RISK-ID-003
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

**ID-REQ-012**
**Title:** Numeric Definitions
**Normative Level:** SHALL
**Statement:** Definition objects SHALL use the numeric form `DEF-NNNN`. Semantic-name identifiers such as `DEF-Participant` are prohibited.
**Verification:** All `DEF-` entries in registry follow `DEF-\d{4}` pattern.
**Rationale:** Concept names evolve. `DEF-Participant` becomes `DEF-ResearchParticipant` — requiring an identifier change, which violates ID-P-002. The concept name is the title, not the identifier.
**Dependencies:** ID-P-002
**Related Risks:** RISK-ID-009
**Revision History:** v1.0.0-DRAFT (2026-07-31) — Initial

---

## 14. Quality Assurance

Before a corpus release or specification promotion, verify:

| Criterion | Check | Requirement |
|---|---|---|
| No duplicate identifiers | `sort registry.yaml \| uniq -d` returns empty | ID-REQ-001 |
| All identifiers match ABNF | Regex validation on all `id` fields | ID-REQ-002 |
| No contextual encoding | Manual review of new identifiers | ID-REQ-003 |
| All prefixes reserved | Cross-check against Section 9 table | ID-REQ-004 |
| No identifier modified | Git diff on registry `id` fields | ID-REQ-005 |
| All objects in registry | Count objects vs registry entries | ID-REQ-006 |
| No retired ID reused | Registry audit: no Deprecated ID appears active | ID-REQ-007 |
| Registry entries complete | Schema validation | ID-REQ-008 |
| No title-based references | Grep for non-identifier cross-references | ID-REQ-010 |
| No DEF-ConceptName entries | `grep DEF-[A-Z] registry.yaml` returns empty | ID-REQ-012 |

---

## 15. Conformance

A CWRM corpus conforms to STD-002 if and only if:

- [ ] Every object in the corpus has an entry in `corpus/registry.yaml` (ID-REQ-006)
- [ ] No two objects share an Internal Identifier (ID-REQ-001)
- [ ] All identifiers conform to the ABNF grammar in Section 8 (ID-REQ-002)
- [ ] No identifier encodes study, interview, or coder information (ID-REQ-003, ID-REQ-011)
- [ ] All prefixes are from the reserved table or have been approved (ID-REQ-004)
- [ ] No identifier has been modified after minting (ID-REQ-005)
- [ ] No retired identifier has been reused (ID-REQ-007)
- [ ] All registry entries contain mandatory fields (ID-REQ-008)
- [ ] All cross-references use Internal Identifiers (ID-REQ-010)
- [ ] No Definition uses a semantic-name identifier (ID-REQ-012)

---

## 16. Out of Scope

STD-002 does not define:

- **Object structure and content** → CWRM-STD-001 — Specification Standard
- **Resolver infrastructure** → Future governance standard
- **FAIR compliance implementation** → Future governance standard
- **Global uniqueness across organizations** → Future namespace extension
- **Publication citation formats** → Editorial conventions
- **Glossary content** → CWRM-100 — Glossary
- **Registry tooling implementation** → Engineering decision

---

## 17. Dependencies

### Incoming

| Specification | Dependency nature |
|---|---|
| CWRM-000 — Scope Guard | Overall governance and principles |
| CWRM-STD-001 — Specification Standard | Object meta-model, section structure, normative language |

### Outgoing

| Specification | Dependency nature |
|---|---|
| All CWRM specifications | Identifier syntax, prefix policy |
| All research artifacts | Internal ID, provenance model, registry |
| CWRM-100 — Glossary | DEF-NNNN numeric format mandated here |

---

## 18. References

### Internal

| Reference | Description |
|---|---|
| CWRM-000 | Scope Guard — Constitution |
| CWRM-STD-001 | Specification Standard |
| CWRM-100 | Glossary *(forthcoming)* |

### External

*To be completed during bibliographic review. Candidate references:*

- Wilkinson, M.D. et al. (2016). The FAIR Guiding Principles for scientific data management and stewardship. *Scientific Data.*
- RFC 5234 (2008). Augmented BNF for Syntax Specifications: ABNF. IETF.
- RFC 3986 (2005). Uniform Resource Identifier (URI): Generic Syntax. IETF.
- Kunze, J. & Rodgers, R. (2008). The ARK Identifier Scheme. CDL/EZID.
- W3C (2010). CURIE Syntax 1.0.

---

## 19. Appendices *(informative)*

**Appendix A — Registry Schema (YAML)**

```yaml
# corpus/registry.yaml
# CWRM Corpus Identifier Registry
# Maintained under version control. Never edit manually without tooling check.

objects:
  - id: ACT-0000001
    type: ACT
    title: Prepares consultation
    status: Accepted
    minted_at: 2026-07-31
    minted_by: R01
    deprecated_at: null
    successor_id: null

  - id: ACT-0000002
    type: ACT
    title: Reviews patient folder
    status: Deprecated
    minted_at: 2026-07-31
    minted_by: R01
    deprecated_at: 2026-08-15
    successor_id: ACT-0000047
```

**Appendix B — Three-Level Model: Quick Reference**

| Level | Name | Example | Property |
|---|---|---|---|
| 1 | Internal Identifier | `ACT-001245` | Immutable, corpus-unique |
| 2 | Canonical URI | `cwrm:ACT-001245` | Stable, future-resolvable |
| 3 | Provenance | `study: S01, interview: INT-034` | Mutable, metadata only |

**Appendix C — What Changed from Draft v0.1**

| Draft v0.1 | STD-002 v1.0 | Reason |
|---|---|---|
| Simple naming standard | Identity & Identifier Standard | Scope elevated to knowledge object identity |
| DEF-Participant | DEF-0017 | Semantic names violate immutability |
| ACT-S01-I03-00027 (proposed) | ACT-001245 | Contextual encoding violates ID-P-001 |
| No minting policy | Section 10 — Minting Policy | C3 from architectural review |
| No resolver mention | Section 12 — Future Persistent Resolution | C4 from architectural review |
| No formal grammar | ABNF in Section 8 | M1 from architectural review |
| No canonical URI | Level 2 of identity model | Compatibility with FAIR trajectory |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-31 | 0.1.0 | Draft initial |
| 2026-07-31 | 1.0.0-DRAFT | Major revision — three-level identity model, knowledge object principle, DEF numeric, minting policy, ABNF grammar, future persistent resolution |
