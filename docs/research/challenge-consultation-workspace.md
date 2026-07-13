# MedLink — Consultation Workspace Model C
## Document for External Review

---

## Context

MedLink is not an Electronic Medical Record.

MedLink is a platform that organizes the work of healthcare practitioners.

Its first product promise:

> **Enable practitioners to resume a patient's care in a few seconds, with confidence.**

The platform is structured around three levels of workspace:

1. **Practitioner Workspace** — answers: "What is my work today?"
2. **Patient Workspace** — answers: "What do I need to know before acting?"
3. **Consultation Workspace** — answers: "What do I need during and after this consultation?"

This document concerns level 3 only.

---

## What a Consultation Workspace Must Solve

A consultation has two phases:

### Phase 1 — During (patient present)

The practitioner is talking to the patient.

Screen interaction must be minimal. The practitioner should not be forced to type.

However, some practitioners do capture notes during the consultation. Others wait until after. Both are valid. The interface must support both without imposing either.

### Phase 2 — Wrap-up (patient gone)

The practitioner closes the consultation.

They review their notes, structure them if needed, and perform actions:
- Write a prescription
- Schedule next appointment
- Refer to a specialist
- Order a lab test

A consultation is considered **open** until explicitly closed.

---

## Model C — Design Decisions (all confirmed)

### 1. Free text note — no imposed structure

The consultation note is free text.

No SOAP. No mandatory fields. No templates.

The practitioner writes what they need, in their own words.

### 2. Capture during or after — both paths are valid

During consultation: an optional free text area is available.

After consultation: the practitioner writes or completes the note in the wrap-up screen.

The wrap-up screen is pre-filled with whatever was captured during.

If nothing was captured during, the wrap-up screen starts empty.

### 3. Explicit transition — with two reminder mechanisms

A consultation is explicitly opened when the practitioner enters consultation mode.

A consultation is explicitly closed when the practitioner saves and closes.

**If the consultation is not closed:**

**Reminder 1 — Contextual**
When the practitioner opens the next patient, a non-blocking notification appears:

> "Consultation de [Patient Name] not yet closed — Close now / Later"

The practitioner can dismiss and continue. Nothing is blocked.

**Reminder 2 — End of day**
The Practitioner Workspace (dashboard) shows a list of all open consultations for the day:

```
Consultations to close:
  ○ Sophie Martin      09:00   Hypothyroid follow-up
  ○ Thomas Garnier     10:30   Chest pain
  ○ Lucie Fontaine     11:00   First contact
```

Each line opens directly to the wrap-up screen for that patient.

### 4. Quick close — "nothing to report"

A consultation can be closed in one click with no note content.

The practitioner selects "No particular finding" and saves.

This prevents the end-of-day list from becoming a burden after a full day.

---

## What a Consultation Produces

Every closed consultation generates:

| Output | Nature |
|---|---|
| Consultation note | Immutable clinical record |
| Prescription (optional) | Immutable, signed |
| Referral (optional) | Immutable |
| Lab order (optional) | Immutable |
| Next appointment (optional) | Schedulable |

These outputs feed the patient's history and become the **delta** visible at the next consultation.

---

## Open Questions We Are Not Resolving Yet

1. Does the consultation note need a minimum format for legal compliance?
2. How does the system handle a consultation that spans multiple sessions (e.g., patient returns mid-consultation)?
3. Should the end-of-day list trigger a push notification, or is dashboard presence sufficient?
4. Is "opening a consultation" always explicit, or can it be inferred from the practitioner opening a patient file during scheduled appointment time?

---

## Challenge Request

Please challenge this model from the following angles:

1. **Assumptions** — what does this model assume that may not be true in real clinical practice?

2. **Missing edge cases** — what practitioner situations does this model fail to handle?

3. **UX risks** — where might practitioners abandon the interface or develop workarounds?

4. **Conceptual flaws** — is the "consultation" the right unit of work, or should MedLink model something else?

5. **Competing models** — is there a better alternative to Model C that achieves the same objectives with fewer assumptions?

Do not optimise for elegance.

Optimise for what actually happens in clinical practice.
