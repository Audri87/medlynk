# CWRM-000A — Conceptual Model

---

## 0. Metadata

| Field | Value |
|---|---|
| Document ID | CWRM-000A |
| Title | Conceptual Model — Objects and Relationships in the CWRM Corpus |
| Version | 1.0.0 |
| Status | Accepted — Foundational Reference |
| Layer | 000 — Foundations |
| Date | 2026-07-31 |
| Depends on | CWRM-000 |
| Required by | CWRM-STD-001, CWRM-STD-002, CWRM-STD-003, CWRM-STD-004, CWRM-STD-005 |
| Nature | Conceptual — no normative requirements |

---

## 1. Purpose and Status of this Document

CWRM-000 defines the scope and mission of the Clinical Work Research Method.

CWRM-000A defines the conceptual model of the objects that inhabit the CWRM corpus.

This document is entirely conceptual. It contains no normative requirements, no SHALL or SHOULD, no identifiers, no syntax rules. It answers one question only:

> What are the fundamental objects of the CWRM, and what are their relationships?

Once this model is stable, every governance standard (STD-001 through STD-005) and every technical specification (CWRM-020 through CWRM-070) derives from it. Without this model, standards are written with implicit and potentially inconsistent assumptions about the objects they govern.

---

## 2. Why This Document Exists

During the development of CWRM-STD-002 (Identity & Identifier Standard), a peer review identified that the draft mixed several distinct concepts: identity, identifier, canonical address, and provenance. The confusion was architectural, not editorial.

The root cause: we were writing standards for objects we had not formally defined.

This document closes that gap. It is the vocabulary of the CWRM corpus.

> We are not simply documenting a method. We are defining a language for describing scientific objects related to clinical work. The governance standards give that language its rules; this document gives it its concepts.

---

## 3. The Scientific Object

Every entity in the CWRM corpus is a **Scientific Object**.

A Scientific Object is anything that:
- can be created, referenced, and versioned,
- has an identity that persists across time and context,
- and participates in relationships with other Scientific Objects.

Scientific Objects are the nodes of the CWRM knowledge graph.

### The Four Concerns

Every Scientific Object has exactly four distinct concerns. These concerns are **orthogonal**: a change to one never requires a change to the others.

```
Scientific Object
        │
        ├── Identity       "what is this object?" — permanent, never changes
        │
        ├── Metadata       "what are its properties?" — descriptive, mutable
        │
        ├── Provenance     "how was it created?" — contextual, correctable
        │
        └── Relationships  "how does it connect to others?" — grows over time
```

**Identity** is the permanent, context-independent essence of the object. It is expressed as an Internal Identifier. It is assigned at creation and cannot change.

**Metadata** is the set of descriptive properties that an object carries. Title, description, status, version, author. These can change without affecting identity.

**Provenance** is the record of how, when, by whom, and in which context the object was created or observed. For Knowledge Objects (ACTs, Observations), provenance records the study, interview, and coder. Provenance is mutable — corrections do not change identity.

**Relationships** are typed, directed links between Scientific Objects. They grow as the corpus develops. An ACT created in 2026 may acquire new relationships in 2030 when additional evidence confirms or contradicts it.

---

## 4. Scientific Object Taxonomy

The CWRM corpus contains four families of Scientific Objects. Each family has different properties and different governance needs.

```
Scientific Object
├── Governance Object
├── Knowledge Object
├── Process Object
└── Translation Object
```

---

### 4.1 Governance Object

A **Governance Object** defines rules, decisions, or templates for the CWRM process itself.

It is not produced by research. It is authored by humans to govern the corpus.

**Subtypes:**

| Subtype | Description | Examples |
|---|---|---|
| Specification | Normative rules for a part of the CWRM process | CWRM-020, CWRM-030 |
| Governance Standard | Meta-rules governing how Specifications are written | STD-001, STD-002 |
| Decision Record | Documented rationale for a methodological choice | DR-001, DR-002 |
| Template | Reusable structure for producing Specifications or Artifacts | TMP-001 |

**Key property:** Governance Objects are versioned explicitly. A new major version can supersede the previous.

**Key relationship:** Governance Objects govern Process Objects and Knowledge Objects. They depend on each other via declared dependencies.

---

### 4.2 Knowledge Object

A **Knowledge Object** represents a pattern, fact, or claim about clinical work.

This is the most important category in the CWRM corpus.

**The essential property of Knowledge Objects:**

> A Knowledge Object is context-independent. Its identity does not depend on the study, interview, or coder that first documented it. It belongs to the knowledge graph, not to a collection.

An Activity Unit `ACT-001245` representing "prepares consultation" was first documented in Study S01, Interview INT-034. In Study S03, a different research team documents the same action pattern. They do not create a new ACT. They reference `ACT-001245` and record Study S03 in its provenance. The ACT's identity is unchanged.

This is the property that distinguishes a CWRM corpus from a collection of study-specific datasets.

**Subtypes:**

| Subtype | Description | CWRM Layer |
|---|---|---|
| Activity Unit (ACT) | A single discrete clinical action observed in a verbatim account | Layer 1 — Evidence |
| Observation (OBS) | A pattern identified across multiple Activity Units | Layer 2 — Knowledge |
| Invariant (INV) | A validated cross-practitioner pattern, stable across contexts | Layer 2 — Knowledge |
| Research Question (RQ) | A design question motivated by an Invariant | Layer 2 — Knowledge |

**Epistemic hierarchy:**

Knowledge Objects form an ascending hierarchy of confidence:

```
ACT             "observed action" — single occurrence, single practitioner
        ↑ abstracted into
OBS             "pattern" — multiple occurrences, possibly multiple practitioners
        ↑ validated as
INV             "invariant" — cross-practitioner, context-stable
        ↑ motivates
RQ              "design question" — what should the software address?
```

Each level requires more evidence and passes a quality gate before promotion. The quality gates are defined in CWRM-001 (Research Method).

**Key property:** Knowledge Objects are the primary output of CWRM research and the primary input to MedLink product design.

---

### 4.3 Process Object

A **Process Object** represents an event or record that is part of the research process itself.

Unlike Knowledge Objects, Process Objects **are** context-dependent. A Transcript belongs to Interview INT-034. Interview INT-034 belongs to Study S01. This hierarchy is inherent to what these objects are.

**Subtypes:**

| Subtype | Description |
|---|---|
| Study | A bounded research campaign with defined scope and participants |
| Interview | A single research session with one participant |
| Transcript | The verbatim record of an Interview |

**Key property:** Process Objects are records of events. They do not version in the same way as Governance Objects — they are captured at a point in time and may be corrected (anonymization error, transcription error) but not fundamentally revised.

**Key relationship:** Process Objects produce Knowledge Objects. The relationship is `produces`: Interview INT-034 produces ACT-001245, ACT-001246, ACT-001247.

---

### 4.4 Translation Object

A **Translation Object** represents the output of translating CWRM research into MedLink product decisions.

These objects exist at the boundary between the CWRM research corpus and the MedLink software project.

**Subtypes:**

| Subtype | Description | CWRM Layer |
|---|---|---|
| Requirement | A need expressed in terms of what the software shall support | Layer 4 — Product |
| Feature | A specific product capability implementing one or more Requirements | Layer 4 — Product |

**Key property:** Translation Objects are motivated by Knowledge Objects but owned by the product domain. A Requirement is motivated by an Invariant; the Requirement itself is a product concern. When the software implementation changes, the Requirement (and its evidence chain) persists.

**Key relationship:** Knowledge Objects motivate Translation Objects. The relationship is `motivates`: INV-000009 motivates REQ-001.

---

## 5. Relationship Taxonomy

Relationships are typed, directed links between Scientific Objects. They are the edges of the CWRM knowledge graph.

Four families cover all relationships in the corpus.

---

### 5.1 Epistemic Relationships

Between Knowledge Objects. These relationships describe the structure of evidence and confidence.

| Relationship | Direction | Example |
|---|---|---|
| `based_on` | OBS → ACTs | OBS-000028 is based_on ACT-001245, ACT-001246, ACT-001247 |
| `supports` | OBS → INV | OBS-000028 supports INV-000009 |
| `confirms` | OBS → INV | Additional OBS independently confirms INV-000009 |
| `contradicts` | OBS → INV | OBS-000041 contradicts INV-000009 |
| `extends` | INV → INV | INV-000015 extends INV-000009 with a new qualifier |
| `motivates` | INV → RQ | INV-000009 motivates RQ-0003 |

**Critical note on `contradicts`:** A contradiction does not delete an Invariant. It reduces its confidence and triggers a deliberation event. The corpus preserves both the Invariant and the contradicting evidence, with a documented resolution.

---

### 5.2 Structural Relationships

Between Governance Objects. These relationships describe the dependency structure of the specification corpus.

| Relationship | Direction | Example |
|---|---|---|
| `depends_on` | Spec → Spec | CWRM-020 depends_on CWRM-000 |
| `required_by` | Spec → Spec | CWRM-000 is required_by CWRM-020 |
| `supersedes` | Spec v2 → Spec v1 | CWRM-020 v2.0.0 supersedes CWRM-020 v1.0.0 |
| `governs` | Governance → Knowledge/Process | CWRM-020 governs Interview |

---

### 5.3 Production Relationships

From Process Objects to Knowledge Objects. These relationships record how research artifacts are created.

| Relationship | Direction | Example |
|---|---|---|
| `contains` | Study → Interview | Study S01 contains Interview INT-034 |
| `produces` | Interview → Transcript | Interview INT-034 produces Transcript TR-034 |
| `extracted_from` | ACT → Verbatim passage | ACT-001245 extracted_from passage at [INT-034, 00:23:41] |
| `promoted_from` | OBS → ACTs | OBS-000028 promoted_from [ACT-001245, ACT-001246] |
| `validated_as` | INV → OBS | INV-000009 validated_as stable from OBS-000028, OBS-000041 |

---

### 5.4 Translation Relationships

From Knowledge Objects to Product Objects. These relationships form the evidence chain that justifies product decisions.

| Relationship | Direction | Example |
|---|---|---|
| `motivates` | INV → RQ | INV-000009 motivates RQ-0003 |
| `addressed_by` | RQ → Requirement | RQ-0003 addressed_by REQ-001 |
| `implements` | Feature → Requirement | Feature-WorkspaceView implements REQ-001 |
| `validates` | Test → Requirement | UserTest-007 validates REQ-001 |

**This chain is the complete evidence path:**

```
verbatim → ACT → OBS → INV → RQ → Requirement → Feature
```

Every Feature in MedLink is reachable from at least one Invariant. Every Invariant is reachable from at least one verbatim account by a healthcare professional.

---

## 6. Identity, Identifier, Address, and Provenance

This section formalizes the four concepts that govern how a Scientific Object is referenced.

These four concepts are frequently confused. They are distinct.

---

### 6.1 Identity

**Identity** is the permanent, context-independent essence of a Scientific Object.

Identity answers: *What is this object?*

Identity is not a string. Identity is the property of *being the same object across time and context*. The Internal Identifier is the formal expression of Identity.

Once assigned, Identity does not change. An object can be renamed, corrected, enriched, deprecated — its Identity is unchanged.

---

### 6.2 Identifier (Internal ID)

The **Internal Identifier** is the formal expression of Identity as a corpus-local string.

```
ACT-001245
OBS-000028
INV-000009
CWRM-020
DEF-0017
```

Properties:
- Immutable from the moment of creation
- Unique within the CWRM corpus
- Type-prefixed, numeric
- Governed by CWRM-STD-002

The Internal Identifier is the reference used in all cross-object links within the corpus.

---

### 6.3 Canonical Address (URI)

The **Canonical Address** is the stable, globally-qualified form of the Internal Identifier.

```
cwrm:ACT-001245
cwrm:OBS-000028
```

Properties:
- Derived from the Internal Identifier by namespace qualification
- Stable from creation
- Future-resolvable (when resolver infrastructure exists)
- Compatible with RDF, FAIR, linked data ecosystems

The Canonical Address is the reference used in publications, citations, and cross-corpus links.

---

### 6.4 Provenance

**Provenance** is the record of how and where a Scientific Object was created.

```
ACT-001245
  study:      S01
  interview:  INT-034
  coder:      R02
  date:       2026-07-31
  verbatim:   [passage reference]
```

Properties:
- Mutable — can be corrected without affecting Identity
- Documented as metadata, not encoded in the Identifier
- Can grow as the object is referenced by additional studies or coders

Provenance is not Identity. If ACT-001245 was initially attributed to Interview INT-034 but later corrected to INT-035, the correction is a provenance update. The ACT's identity — and all references to it — remain unchanged.

---

### 6.5 The Separation in Practice

```
Object:          ACT-001245

Identity:        "this is the clinical action pattern 001245"
Identifier:      ACT-001245             ← corpus reference, never changes
Canonical URI:   cwrm:ACT-001245        ← global reference, never changes
Provenance:      study: S01             ← can be corrected
                 interview: INT-034     ← can be corrected
                 coder: R02             ← can be updated
Metadata:        title: "Prepares consultation"   ← can be refined
                 status: Accepted                  ← changes through lifecycle
```

---

## 7. Versioning as a Cross-Cutting Concern

Versioning applies to all Scientific Objects, but differently depending on the family.

**The core principle:** Versioning is about the *state* of an object, not its *identity*. Two versions of an object are the same object in different states — not two different objects.

---

### Governance Objects

Versioned explicitly, following Major.Minor.Revision (governed by CWRM-STD-003).

```
CWRM-020 v1.0.0 → CWRM-020 v1.1.0 → CWRM-020 v2.0.0
```

The identity of the specification (CWRM-020) does not change between versions. A new major version may be accompanied by a new specification when the change is sufficiently fundamental to warrant a new identity — but this is a deliberate decision, not automatic.

---

### Knowledge Objects

Versioned implicitly through the corpus registry. Each modification creates a new history entry. The Internal Identifier remains constant.

```
ACT-001245
  history:
    - date: 2026-07-31, change: "Initial extraction", coder: R02
    - date: 2026-08-15, change: "Title refined", coder: R01
    - date: 2026-09-02, change: "Confirmed by Study S03", coder: R04
```

Knowledge Objects do not have explicit version numbers because they are not "published" in the same way as Governance Objects. Their history is a continuous record of evidence accumulation.

---

### Process Objects

Not versioned in the traditional sense. A Transcript is a record of an event. Corrections (anonymization errors, transcription errors) are noted in the object's history, but there is no "Transcript v1.0 vs. v2.0." The event happened once.

---

## 8. The CWRM Knowledge Graph

The CWRM corpus is a knowledge graph.

- **Nodes** are Scientific Objects with their Internal Identifiers.
- **Edges** are typed, directed Relationships.
- **Node properties** are Metadata and Provenance.
- **Node permanence** is guaranteed by Identity.

```
[Verbatim passage]
      │ extracted_from
      ▼
[ACT-001245]  [ACT-001246]  [ACT-001247]
      │              │              │
      └──────────────┴──────────────┘
                     │ based_on
                     ▼
               [OBS-000028]
                     │ supports
                     ▼
               [INV-000009]
                     │ motivates
                     ▼
                 [RQ-0003]
                     │ addressed_by
                     ▼
                [REQ-001]
                     │ implements
                     ▼
           [Feature-WorkspaceView]
```

The graph grows monotonically. Objects are added but never removed (only Deprecated). Relationships are added as the corpus develops. A Knowledge Object may exist for years before acquiring a `supports` relationship to an Invariant.

---

## 9. Implications for Governance Standards

This conceptual model determines the responsibility of each governance standard. The mapping is exact and non-overlapping.

| Standard | Responsibility | Governed objects |
|---|---|---|
| STD-001 — Specification Standard | Structure and meta-model of Governance Objects | Specifications, Standards, Decision Records |
| STD-002 — Identity Model | Identity, Identifier, and Provenance separation | All Scientific Objects |
| STD-003 — Versioning Policy | State evolution rules | Governance Objects primarily; Knowledge Objects secondarily |
| STD-004 — Traceability Model | Relationship taxonomy and chain verification | All Scientific Objects and their Relationships |
| STD-005 — Resolution & URI Policy | Canonical Address, resolver infrastructure, FAIR compatibility | All Scientific Objects — future infrastructure |

Each standard governs a distinct concern. None of these concerns overlaps.

---

## 10. Open Questions

This section documents conceptual questions that are not resolved in this version of the model.

**OQ-001 — Definition objects**

Are Definitions (from CWRM-100 Glossary) Knowledge Objects or Governance Objects?

The argument for Knowledge Object: a definition represents a concept that exists independently of any specification.

The argument for Governance Object: a definition is authored (not discovered through research) and governs the language of the corpus.

Current working assumption: Definitions are a distinct subtype of Governance Object. Reconsidering this classification requires a deliberation event before CWRM-100 is written.

**OQ-002 — Evidence Relationships**

The `confirms` and `contradicts` relationships (Section 5.1) imply a confidence model for Invariants. This model is not fully defined here. The behavior of the knowledge graph when a contradiction is recorded — which object "wins", how the resolution is documented — is deferred to CWRM-001 (Research Method) and CWRM-050 (Evidence Framework).

**OQ-003 — AI-produced Knowledge Objects**

The CWRM currently assumes all Knowledge Objects are produced by human coders from human interviews. If CWRM is later extended with AI-assisted coding or AI-generated observations, the provenance model will need to distinguish human-produced from machine-assisted objects. This distinction may have epistemic significance.

---

## 11. Relationship to CWRM-000

CWRM-000 (Scope Guard) answers: *What is the CWRM for?*

CWRM-000A answers: *What are the objects in the CWRM?*

These two documents are the conceptual foundation of the entire corpus. Every governance standard and every technical specification must be consistent with both.

If a new object type is proposed for the CWRM corpus, it must:
1. Be classifiable within the taxonomy of Section 4 (or require an update to this document)
2. Be consistent with the scope defined in CWRM-000
3. Have defined Relationships to existing object types (Section 5)

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-31 | 1.0.0 | Initial — Object taxonomy, four concerns, relationship taxonomy, knowledge graph model |
