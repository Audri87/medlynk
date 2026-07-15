# SD-002 — Clinical Platform Strategic Model

**Status**: Release v1.0

---

## Purpose

Define the Business Capabilities of the Clinical Platform.

Business Capabilities organize the platform before technical architecture.

Future Bounded Contexts are expected to realize one or more Business Capabilities.

---

## Clinical Platform Mission

Enable healthcare practitioners to preserve continuity of care throughout the patient's clinical journey.

---

## Business Capability Map

---

### Core Capability — Clinical Work Coordination

**Mission**

Coordinate clinical work while preserving Clinical Responsibility and Clinical Continuity.

**Owns**

- Clinical Activity
- Clinical Draft *(internal state of Clinical Activity — DR-002, ES-004-D)*
- Clinical Responsibility
- Clinical Handover
- Clinical Referral
- Clinical Continuity

**Business Outcome**

Practitioners know:

- what they are responsible for;
- what must happen next;
- how responsibility evolves;
- how continuity is preserved.

---

### Core Capability — Clinical Knowledge Management

**Mission**

Capture, preserve and expose clinical knowledge generated during clinical work.

**Owns**

- Clinical Contribution
- Care Record
- Clinical Knowledge

**Business Outcome**

Clinical work produces durable and reusable clinical knowledge.

---

### Supporting Capability — Clinical Workspace

**Mission**

Provide Practitioners with the information, actions and context required to conduct Clinical Activities efficiently.

**Supports**

- Orientation
- Context Reconstruction
- Workspace composition
- Personal tasks
- Attention signals

The Workspace owns no clinical knowledge.

It orchestrates capabilities owned elsewhere.

---

### Supporting Capability — Clinical Discovery

**Mission**

Enable efficient discovery of relevant clinical information.

**Supports**

- Search
- Navigation
- Timeline exploration
- Filters
- Patient overview

---

### Supporting Capability — External Clinical Exchange

**Mission**

Exchange clinical information with external healthcare systems.

**Supports**

- FHIR
- HL7
- Import
- Export

> **Provisional** — External Clinical Artifacts are outside the accepted Core Domain until H-ES-002 is resolved (DR-016). No implementation shall freeze their classification by assumption.

---

### Supporting Capability — Clinical Decision Support

**Mission**

Assist Practitioners without replacing clinical judgment.

**Supports**

- Recommendations
- Alerts
- AI-assisted drafting
- Quality checks

Clinical reasoning always remains outside the platform.

*(DE-P-001 / DE-P-002)*

---

### Supporting Capability — Clinical Governance

**Mission**

Guarantee the trustworthiness of clinical information.

**Supports**

- Provenance
- Audit
- Traceability
- Signatures
- Compliance

---

## Strategic Structure

```
Clinical Platform

├── Core
│   ├── Clinical Work Coordination
│   └── Clinical Knowledge Management
│
└── Supporting
    ├── Clinical Workspace
    ├── Clinical Discovery
    ├── External Clinical Exchange
    ├── Clinical Decision Support
    └── Clinical Governance
```

---

## Strategic Consequences

- Only Core Capabilities own critical business rules.
- Supporting Capabilities facilitate clinical work without redefining the Core Domain.
- Business Capabilities are technology-independent.
- Future Bounded Contexts shall implement one or more Business Capabilities while preserving clear ownership.

---

## References

- ARCH-001
- SD-001
- Domain Engineering V1.0
- DR-001
- HR-001
- UL-001
- CAL-001
