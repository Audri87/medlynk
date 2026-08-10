# CWRM-020 — Interview Protocol Specification

---

## 0. Metadata

| Field | Value |
|---|---|
| Document ID | CWRM-020 |
| Title | Interview Protocol Specification |
| Version | 1.0-RC |
| Status | Draft — Pending Peer Review |
| Layer | 100 — Method |
| Date | 2026-07-31 |
| Authors | CWRM Research Team |
| Reviewers | [To be assigned before v1.0 promotion] |
| Depends on | CWRM-000, CWRM-001, CWRM-002 |
| Required by | CWRM-030 (Coding Manual) |

### Changelog

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-07-31 | Draft initial |
| 0.2 | 2026-07-31 | Lifecycle, MD Records, éthique, critères qualité |
| 0.3 | 2026-07-31 | Refonte normative — IP-REQ, SHALL/SHOULD/MAY, QA checklist |
| 0.4 | 2026-07-31 | Contract (Design by Contract), Out of Scope |
| 1.0-RC | 2026-07-31 | Structure finale — Data Management, Transcript Validation, requirements formalisés avec Verification + Dependencies |

---

## 1. Contract

### Purpose

Standardize the collection of qualitative interview data within the CWRM pipeline to produce validated, traceable, and auditable transcripts suitable for coding.

### Inputs

| Input | Source |
|---|---|
| Research population definition | CWRM-020 Section 7.1 (internal) |
| Interview Guide | CWRM-020 Section 7.4 + Appendix A |
| Participant satisfying eligibility criteria | CWRM-020 Section 7.1 |
| Ethical approval or regulatory opinion | CWRM-020 Section 11 |

### Outputs

| Output | Consumer |
|---|---|
| Validated Transcript (v2.0+, anonymized) | CWRM-030 — Coding Manual |
| Interview Metadata | CWRM-030, study records |
| Deviation Log | Study records, external audit |
| Quality Assessment Report | Study records, conformance review |

### Guarantees

This specification guarantees that, for every Accepted transcript delivered to CWRM-030:

- The interview is traceable to its source, participant, researcher, and date.
- Data collection followed a documented and standardized process.
- All protocol deviations are documented and justified.
- Metadata is complete per Section 7.4.
- The transcript has passed Transcript Validation (Section 9).

### Non-Guarantees

| What | Responsible specification |
|---|---|
| Coding quality or ACT extraction accuracy | CWRM-030 — Coding Manual |
| Observation quality | CWRM-001 — Research Method |
| Invariant validity | CWRM-001 — Research Method |
| Product design decisions | CWRM-060 — Design Reasoning |
| Scientific conclusions | CWRM-070 — Validation Protocol |
| Interpretability of participant responses | Participant-dependent |

---

## 2. Abstract

This specification defines the normative requirements for conducting qualitative interviews within the Clinical Work Research Method (CWRM). It covers the complete interview lifecycle — from study preparation through validated transcript delivery — and establishes the conditions under which collected data may enter the CWRM analytical pipeline via CWRM-030.

This document does not govern how transcripts are coded or analyzed. Its sole responsibility is to guarantee that the transcripts it delivers are traceable, standardized, and documented.

**Normative language:**

- **SHALL** — mandatory. Non-compliance disqualifies the output.
- **SHOULD** — recommended. Deviation must be documented.
- **MAY** — optional, permissible.

---

## 3. Purpose

CWRM-020 exists to answer one question:

> How must interviews be conducted so that their outputs constitute reliable, auditable, and reproducible inputs for the CWRM analytical pipeline?

Without a standardized protocol, the validity of every downstream step — ACT extraction, observation formulation, invariant promotion, design reasoning — becomes dependent on how a single researcher chose to conduct a single interview. This specification eliminates that dependence.

---

## 4. Scope

### Included

- Study preparation and participant selection
- Pilot interviews and interviewer calibration
- Production interview conduct
- Protocol deviation handling
- Failed interview management
- Recording, anonymization, and data management
- Transcript validation
- Quality assurance
- Ethical requirements

### Excluded

- ACT extraction and coding → CWRM-030
- Evidence classification → CWRM-050
- Observation formulation → CWRM-001
- Design Reasoning → CWRM-060
- Validation of research findings → CWRM-070

---

## 5. Normative Definitions

Definitions in this section are normative within CWRM-020.

The authoritative source for all CWRM terminology is CWRM-100 — Glossary *(specification forthcoming)*. In the interim, the following definitions apply.

**Interview** — A semi-structured qualitative session in which a healthcare professional describes their clinical work in response to open-ended questions and probing techniques.

**Participant** — A healthcare professional who has given written informed consent to participate in an interview session.

**Pilot Interview** — An interview conducted with a volunteer outside the production corpus for the purpose of validating the interview guide.

**Protocol Deviation** — Any deliberate or accidental departure from the procedures specified in this document during a production interview.

**Failed Interview** — A production interview that does not meet the quality criteria defined in Section 10 and cannot be used for ACT extraction.

**Validated Transcript** — A transcript that has completed the Transcript Validation process (Section 9) and carries Accepted status. Only Validated Transcripts may be passed to CWRM-030.

**MD Record (Methodological Decision)** — A structured record documenting any deliberate modification to or deviation from the protocol during a study campaign.

**Research Episode** — A single coherent work narrative reported by a participant, corresponding to one workday or one patient encounter.

---

## 6. Research Principles

These principles are the scientific foundation of the specification. Every normative requirement derives from one or more of these principles.

**RP-001 — Actual work over declared work**

> The protocol SHALL prioritize descriptions of concrete work situations over general declarations about professional practice.

*A practitioner's account of what they did yesterday is methodologically superior to their account of what they generally do. The former is a report; the latter is a self-model, subject to idealization.*

**RP-002 — Concrete situations over abstract principles**

> Questions SHALL encourage the description of specific, situated actions rather than abstract professional norms.

*The CWRM extracts ACT from verbatim reports of concrete actions. Abstract descriptions do not produce extractable ACTs.*

**RP-003 — Context before interpretation**

> Context SHALL be fully captured before any interpretive activity begins.

*Interpretation belongs to CWRM-030. The interview protocol captures; it does not interpret.*

**RP-004 — Standardization of collection, not of responses**

> The protocol does not seek to standardize participant responses. It seeks to standardize the conditions under which data is collected.

*Reproducibility in the CWRM comes from consistent collection practice, not from identical participant answers. Two independent teams applying this protocol to the same participant pool should produce comparable data — not identical transcripts.*

**RP-005 — Integrity before completeness**

> A failed interview that is correctly classified and documented is more valuable to the methodology than a compromised interview treated as exploitable.

---

## 7. Interview Lifecycle

Every interview campaign SHALL follow the lifecycle below. Each stage is a precondition for the next.

```
Study Preparation
        │
        ▼
Pilot Interviews
        │
        ▼
Interviewer Calibration
        │
        ▼
Production Interviews
        │
        ▼
Protocol Deviation Handling
        │
        ▼
Failed Interview Management
        │
        ▼
Transcript Validation  ────▶  CWRM-030
```

### 7.1 Study Preparation

Before any recruitment begins, the research team defines the target population, eligibility criteria, and sampling strategy.

Each participant is verified against criteria before scheduling. No interview is conducted with a participant who has not passed eligibility verification.

**Inclusion criteria (CWRM v1.0):** active healthcare professional, ≥ 2 years clinical experience, direct patient contact, ambulatory or outpatient practice setting.

**Exclusion criteria (CWRM v1.0):** exclusive emergency practice, operating room, ICU/intensive care, administrative role without direct patient contact.

**Sampling:** purposive, covering multiple professions and practice settings. Maximum one participant per organization. Minimum two participants per profession required before any observation from that profession may be promoted to an Invariant.

### 7.2 Pilot Interviews

Each interviewer conducts at least one pilot interview before production. Pilot interviews use volunteers outside the production corpus and are conducted under identical conditions.

The research team reviews the pilot within 48 hours. Any modification to the interview guide resulting from the pilot is documented as an MD Record before production begins. If the modification is judged major, a second pilot is required.

### 7.3 Interviewer Calibration

If more than one interviewer collects production data, all interviewers participate in a calibration session before production begins.

Calibration includes: joint reading of this specification, a simulated interview, cross-review of each interviewer's pilot. The session produces documented consensus on probing technique interpretation and deviation classification. Outcomes are recorded as an MD Record.

For campaigns exceeding 10 production interviews, a cross-review is conducted every 5 interviews.

### 7.4 Production Interviews

Production interviews follow the guide in Appendix A. Each interview has six phases:

**Phase 1 — Welcome (5–10 min):** present the research purpose (without revealing hypotheses), obtain written informed consent, explain data usage and right of withdrawal.

**Phase 2 — Professional context (10–15 min):** understand the participant's practice, setting, patient volume, and principal tools.

**Phase 3 — Workday description (25–35 min):** core elicitation phase. Anchor question:

> *"Pouvez-vous me décrire votre journée d'hier — ou votre dernière journée de travail — depuis le moment où vous avez commencé jusqu'au moment où vous avez terminé ?"*

If the participant describes abstractly: redirect to the specific day. If the participant objects (atypical day): offer the day before. Document the type of day in metadata.

Systematic probes for each action mentioned: *"Qu'est-ce que vous faites ensuite ?" / "Comment savez-vous que c'est terminé ?" / "Qu'est-ce que vous consultez à ce moment ?" / "Que se passe-t-il si cette information n'est pas disponible ?"*

**Phase 4 — Tools and artifacts (10–15 min):** what the participant opens, consults, writes, and transmits.

**Phase 5 — Frictions and exceptions (10 min):** what makes a workday go well or poorly.

**Phase 6 — Closing (5 min):** open question, thanks, reminder of right of withdrawal.

**Authorized probing:** recent examples, action precision, rupture scenarios. **Reformulations** must use the participant's exact terms.

**Prohibited:** leading questions, hypothesis-confirming questions, questions about patient clinical content, questions evaluating professional competence.

### 7.5 Protocol Deviations

Every protocol deviation is documented. The reason is recorded. Deviations SHALL NOT compromise participant safety, confidentiality, or research integrity.

**Minor deviation:** note in post-interview notes. No impact on exploitability.

**Major deviation:** MD Record required. Exploitability assessed against Section 10.

### 7.6 Failed Interviews

A failed interview is explicitly classified, its reason documented, and it is archived. Failed interviews are never deleted. Re-contacting a participant requires Research Lead approval and a new consent procedure.

**Failure causes:** audio insufficient for transcription, duration below minimum, exclusively abstract descriptions, > 30% theoretical content, consent not obtained, unrecovered recording interruption.

---

## 8. Data Management

This section governs all data from recording through storage. No specific technology is mandated.

### 8.1 Recording

Audio recording is mandatory. Format: WAV or MP4. File naming: `F-[NNN]-[profession]-[YYYYMMDD]-[RESEARCHER]`. Recording is active from the start of Phase 1 (post-consent) through end of Phase 6.

### 8.2 Anonymization and Pseudonymization

Patient-identifiable information SHALL NOT be collected. If accidentally captured, it is removed during transcription and noted in metadata. Participant names are replaced with anonymized identifiers before any sharing.

### 8.3 Storage

Research data is stored encrypted, with access restricted to the research team. Retention: 5 years from study completion.

### 8.4 Versioning

| Version | Status |
|---|---|
| v1.0 | Raw transcript |
| v1.1 | Anonymized transcript |
| v2.0 | Reviewed and corrected transcript |

Only v1.1 or higher may be shared outside the research team. Only v2.0 transcripts may enter CWRM-030.

### 8.5 Deletion

Participant data is deleted or anonymized beyond re-identification upon withdrawal request. Failed interview data is archived, not deleted.

---

## 9. Transcript Validation

Every transcript completes Transcript Validation before delivery to CWRM-030.

### Validation Checklist

| Criterion | Verified |
|---|---|
| Transcription is verbatim (no summarization) | ☐ |
| Speaker identification present throughout | ☐ |
| Time codes present at minimum every 5 minutes | ☐ |
| Non-verbal markers noted | ☐ |
| Chronological order preserved | ☐ |
| Metadata form completed | ☐ |
| Anonymization applied | ☐ |
| Audio quality verified transcribable | ☐ |
| Minimum duration satisfied (≥ 45 min substantive) | ☐ |
| At least 3 workday phases covered | ☐ |

### Output

A transcript that passes all criteria is assigned **Accepted** status and may be delivered to CWRM-030.

A transcript that fails one or more criteria is assigned **Failed** status and follows the Failed Interview Management procedure (Section 7.6).

---

## 10. Quality Assurance

Each interview progresses through the following status flow.

```
Draft
  │  (recording complete, notes written)
  ▼
Reviewed
  │  (audio quality confirmed, transcript initiated)
  ▼
Validated
  │  (Transcript Validation checklist passed)
  ▼
Accepted
     (eligible for CWRM-030)
```

**Draft:** interview conducted. Audio exists. Post-interview notes written.

**Reviewed:** audio quality confirmed. Transcript in progress. Deviations documented if applicable.

**Validated:** Transcript Validation checklist (Section 9) complete. All criteria satisfied.

**Accepted:** Research Lead approval. Transcript at v2.0. Passed to CWRM-030.

---

## 11. Ethics

### 11.1 Informed Consent

Written informed consent is obtained before any recording begins. Consent covers: research purpose (without revealing hypotheses), data usage, anonymization process, storage duration, right to withdraw.

### 11.2 Right of Withdrawal

Participants may withdraw at any time, including up to 30 days after receiving their transcript, without penalty or justification. Upon withdrawal, all participant data is destroyed or anonymized beyond re-identification per participant preference.

### 11.3 Confidentiality

Patient-identifiable information is not collected. Participant-identifiable information is anonymized before analysis or sharing.

### 11.4 Data Protection

Processing of participant personal data complies with GDPR (EU) or equivalent applicable regulation. Legal basis: explicit consent (Art. 6.1.a) or legitimate research interest (Art. 6.1.f) depending on institutional context.

### 11.5 Regulatory Classification

Before any data collection, the research team obtains a formal regulatory opinion on whether this research constitutes research involving human subjects under applicable national law.

*Note for France:* Research on professional work practices that collects no patient data may fall outside the scope of loi Jardé. Classification SHALL be confirmed by the institutional DPO or legal advisor. If participant personal data is processed, a CNIL declaration (MR-003 or equivalent) may be required.

---

## 12. Normative Requirements

All normative requirements are defined in this section. Sections 7 through 11 reference these requirements but do not define them.

---

**IP-REQ-001**
**Title:** Population Definition
**Statement:** The research population SHALL be defined and documented before recruitment begins.
**Verification:** Review of study preparation documentation.
**Rationale:** Undocumented population definitions cannot be reproduced by independent teams.
**Dependencies:** —

---

**IP-REQ-002**
**Title:** Inclusion Criteria
**Statement:** Inclusion criteria SHALL be explicit, verifiable, and documented.
**Verification:** Review of eligibility criteria document.
**Rationale:** Verifiable criteria enable independent application of the same sampling logic.
**Dependencies:** IP-REQ-001

---

**IP-REQ-003**
**Title:** Exclusion Criteria
**Statement:** Exclusion criteria SHALL be explicit, verifiable, and documented.
**Verification:** Review of eligibility criteria document.
**Rationale:** Exclusion criteria define the CWRM v1.0 scope boundary for the corpus.
**Dependencies:** IP-REQ-001

---

**IP-REQ-004**
**Title:** Eligibility Verification
**Statement:** Each participant SHALL be verified against inclusion and exclusion criteria before the interview is scheduled.
**Verification:** Review of participant eligibility records.
**Rationale:** Post-hoc disqualification of a participant wastes research resources and weakens corpus consistency.
**Dependencies:** IP-REQ-002, IP-REQ-003

---

**IP-REQ-005**
**Title:** Purposive Sampling
**Statement:** Sampling SHALL follow a purposive strategy to cover multiple professions and practice contexts.
**Verification:** Review of sampling rationale in study documentation.
**Rationale:** Purposive sampling maximizes the diversity of reported work patterns, which is required for cross-profession observation.
**Dependencies:** IP-REQ-001

---

**IP-REQ-006**
**Title:** Organizational Diversity
**Statement:** A maximum of one participant per organization SHALL be enrolled.
**Verification:** Review of participant organization records.
**Rationale:** Multiple participants from the same organization confound profession-level observations with organization-level practices.
**Dependencies:** IP-REQ-005

---

**IP-REQ-007**
**Title:** Profession Minimum
**Statement:** A minimum of two participants per profession SHALL be enrolled before any observation from that profession may be promoted to an Invariant.
**Verification:** Review of participant roster and INV promotion records.
**Rationale:** A single practitioner cannot represent profession-level patterns.
**Dependencies:** IP-REQ-005

---

**IP-REQ-008**
**Title:** Pilot Interview Obligation
**Statement:** At least one pilot interview SHALL be conducted by each interviewer before production interviews begin.
**Verification:** Pilot interview record and debrief documentation.
**Rationale:** Catches protocol design problems before they affect the production corpus. A badly designed question multiplied across 10 interviews is not recoverable.
**Dependencies:** —

---

**IP-REQ-009**
**Title:** Pilot Participant Eligibility
**Statement:** Pilot participants SHALL be volunteers outside the production corpus.
**Verification:** Confirmation that pilot participant is not in production sample.
**Rationale:** Prevents contamination of the production corpus with pre-production protocol versions.
**Dependencies:** IP-REQ-008

---

**IP-REQ-010**
**Title:** Pilot Conditions
**Statement:** Pilot interviews SHALL be conducted under the same conditions as production interviews (recording, duration, setting).
**Verification:** Review of pilot recording and debrief.
**Rationale:** A pilot conducted under different conditions does not test the actual protocol.
**Dependencies:** IP-REQ-008

---

**IP-REQ-011**
**Title:** Pilot Review
**Statement:** The research team SHALL review the pilot interview within 48 hours of completion.
**Verification:** Pilot debrief document with date.
**Rationale:** Delayed review risks losing contextual memory of protocol difficulties.
**Dependencies:** IP-REQ-008

---

**IP-REQ-012**
**Title:** Pilot Modification Documentation
**Statement:** Any modification to the interview guide resulting from the pilot SHALL be documented as an MD Record before production begins.
**Verification:** MD Record associated with the modification.
**Rationale:** RP-002 — Traceability over convenience.
**Dependencies:** IP-REQ-011

---

**IP-REQ-013**
**Title:** Second Pilot on Major Modification
**Statement:** If a pilot modification is judged major, a second pilot SHALL be conducted.
**Verification:** Second pilot record if applicable.
**Rationale:** A major modification invalidates the first pilot's validation.
**Dependencies:** IP-REQ-012

---

**IP-REQ-014**
**Title:** Calibration Obligation
**Statement:** If more than one interviewer collects production data, all interviewers SHALL participate in a calibration session before production begins.
**Verification:** Calibration session record signed by all interviewers.
**Rationale:** Inter-interviewer variability is the primary reproducibility threat in multi-researcher qualitative studies.
**Dependencies:** —

---

**IP-REQ-015**
**Title:** Calibration Content
**Statement:** Calibration SHALL include joint reading of this specification, a simulated interview, and cross-review of pilot interviews.
**Verification:** Calibration session record and MD Record.
**Rationale:** Shared reading without practice produces theoretical but not behavioral alignment.
**Dependencies:** IP-REQ-014

---

**IP-REQ-016**
**Title:** Calibration Consensus Documentation
**Statement:** Calibration SHALL produce a documented consensus on probing technique interpretation, deviation classification, and failed interview classification.
**Verification:** MD Record containing consensus points.
**Rationale:** Undocumented consensus is individual memory, not a methodological record.
**Dependencies:** IP-REQ-014

---

**IP-REQ-017**
**Title:** Ongoing Calibration
**Statement:** For campaigns exceeding 10 production interviews, a cross-review SHALL be conducted every 5 interviews.
**Verification:** Cross-review records at appropriate intervals.
**Rationale:** Interviewer drift occurs gradually. Periodic calibration detects and corrects it.
**Dependencies:** IP-REQ-014

---

**IP-REQ-018**
**Title:** Open Questions
**Statement:** The interviewer SHALL use open-ended questions.
**Verification:** Review of interview recording or transcript.
**Rationale:** Open-ended questions elicit richer and less constrained descriptions of work. Closed questions bias toward expected answers.
**Dependencies:** RP-002

---

**IP-REQ-019**
**Title:** Anchored Elicitation
**Statement:** The interview SHALL be anchored to a specific recent workday, not to a description of typical practice.
**Verification:** Review of Phase 3 in transcript.
**Rationale:** RP-001 — Specific day accounts are less subject to idealization than typical day accounts.
**Dependencies:** RP-001

---

**IP-REQ-020**
**Title:** Probing Technique Compliance
**Statement:** The interviewer SHALL only use authorized probing techniques as defined in Section 7.4.
**Verification:** Review of interview recording or transcript.
**Rationale:** Unauthorized probing, particularly leading questions, biases participant responses and compromises data quality.
**Dependencies:** RP-002, RP-003

---

**IP-REQ-021**
**Title:** Production Protocol Adherence
**Statement:** Production interviews SHALL follow the guide in Appendix A.
**Verification:** QA checklist (Section 10).
**Rationale:** Protocol adherence is a precondition for reproducibility.
**Dependencies:** IP-REQ-018, IP-REQ-019

---

**IP-REQ-022**
**Title:** Written Consent
**Statement:** Participants SHALL provide written informed consent before recording begins.
**Verification:** Signed consent form in records.
**Rationale:** Written consent protects participants and the research team and is required for external review.
**Dependencies:** Section 11

---

**IP-REQ-023**
**Title:** Deviation Documentation
**Statement:** Every protocol deviation SHALL be documented.
**Verification:** MD Record or post-interview notes.
**Rationale:** RP-002 — Undocumented deviations are invisible to external reviewers and cannot be defended.
**Dependencies:** RP-002

---

**IP-REQ-024**
**Title:** Deviation Justification
**Statement:** The reason for every protocol deviation SHALL be recorded.
**Verification:** MD Record or post-interview notes.
**Rationale:** A documented reason allows reviewers to assess the impact of the deviation.
**Dependencies:** IP-REQ-023

---

**IP-REQ-025**
**Title:** Deviation Integrity
**Statement:** Protocol deviations SHALL NOT compromise participant safety, confidentiality, or research integrity.
**Verification:** MD Record review by Research Lead.
**Rationale:** Some deviations are acceptable adjustments; others invalidate the interview.
**Dependencies:** IP-REQ-023

---

**IP-REQ-026**
**Title:** Failed Interview Classification
**Statement:** Failed interviews SHALL be explicitly classified using the criteria in Section 7.6.
**Verification:** Failed interview register.
**Rationale:** RP-005 — Integrity before completeness. Correct classification is more valuable than a compromised exploitable interview.
**Dependencies:** RP-005

---

**IP-REQ-027**
**Title:** Failure Reason Documentation
**Statement:** The reason for rejection SHALL be documented in the study record.
**Verification:** Failed interview register entry.
**Rationale:** Failure reasons are data about the protocol's practical limits.
**Dependencies:** IP-REQ-026

---

**IP-REQ-028**
**Title:** Failed Interview Retention
**Statement:** Failed interviews SHALL remain traceable and archived. They SHALL NOT be deleted.
**Verification:** Archived records check.
**Rationale:** Failed interviews are methodological evidence. Their existence and frequency are data about the protocol.
**Dependencies:** IP-REQ-027

---

**IP-REQ-029**
**Title:** Re-contact Authorization
**Statement:** Re-contacting a participant whose interview has failed SHALL require Research Lead approval and a new consent procedure.
**Verification:** MD Record with Research Lead approval.
**Rationale:** Re-contact without new consent violates participant autonomy.
**Dependencies:** IP-REQ-022, IP-REQ-026

---

**IP-REQ-030**
**Title:** Recording Obligation
**Statement:** Audio recording SHALL be active from the start of Phase 1 through the end of Phase 6.
**Verification:** Recording coverage check.
**Rationale:** Incomplete recordings produce incomplete transcripts. Gaps in the transcript break the evidence chain.
**Dependencies:** RP-003

---

**IP-REQ-031**
**Title:** Recording Quality
**Statement:** Audio quality SHALL be sufficient for verbatim transcription.
**Verification:** Audio review prior to transcription.
**Rationale:** Inaudible sections cannot be transcribed and constitute data loss.
**Dependencies:** IP-REQ-030

---

**IP-REQ-032**
**Title:** File Naming
**Statement:** Recording files SHALL follow naming convention: `F-[NNN]-[profession]-[YYYYMMDD]-[RESEARCHER]`.
**Verification:** File system check.
**Rationale:** Consistent naming enables corpus management, tracking, and audit.
**Dependencies:** —

---

**IP-REQ-033**
**Title:** Patient Data Exclusion
**Statement:** Patient-identifiable information SHALL NOT be present in recordings. If accidentally captured, it SHALL be removed during transcription and noted in metadata.
**Verification:** Transcript review.
**Rationale:** Patient data is out of scope for CWRM. Its presence creates regulatory and ethical risks.
**Dependencies:** Section 11

---

**IP-REQ-034**
**Title:** Verbatim Transcription
**Statement:** Transcription SHALL be verbatim. Summarizing is prohibited.
**Verification:** Transcript review against recording.
**Rationale:** The CWRM E1/E2/E3 evidence framework depends on direct verbatim quotations (E3). Summarized transcription destroys the highest-quality evidence in the corpus.
**Dependencies:** RP-003

---

**IP-REQ-035**
**Title:** Speaker Identification
**Statement:** Speaker identity SHALL be indicated for every utterance: `[INTERVIEWER]` / `[PARTICIPANT]`.
**Verification:** Transcript review.
**Rationale:** ACT extraction depends on distinguishing participant speech from interviewer prompts.
**Dependencies:** IP-REQ-034

---

**IP-REQ-036**
**Title:** Time Codes
**Statement:** Time codes SHALL appear at minimum every 5 minutes.
**Verification:** Transcript review.
**Rationale:** Time codes enable verification of transcript accuracy against the recording.
**Dependencies:** IP-REQ-034

---

**IP-REQ-037**
**Title:** Non-verbal Markers
**Statement:** Relevant non-verbal markers SHALL be noted: `[pause]`, `[laughs]`, `[hesitation]`.
**Verification:** Transcript review.
**Rationale:** Non-verbal markers provide context for ambiguous passages during coding.
**Dependencies:** IP-REQ-034

---

**IP-REQ-038**
**Title:** Anonymization
**Statement:** Anonymization SHALL be applied before any transcript is shared outside the research team.
**Verification:** Transcript version check (≥ v1.1).
**Rationale:** Participant protection and regulatory compliance.
**Dependencies:** Section 11

---

**IP-REQ-039**
**Title:** Transcript Versioning
**Statement:** Transcripts SHALL be versioned: v1.0 (raw), v1.1 (anonymized), v2.0 (reviewed and corrected). Only v2.0 transcripts may be passed to CWRM-030.
**Verification:** Version check in file metadata.
**Rationale:** Version control enables audit and prevents premature delivery of unreviewed transcripts to the coding phase.
**Dependencies:** IP-REQ-034, IP-REQ-038

---

**IP-REQ-040**
**Title:** Informed Consent
**Statement:** Written informed consent SHALL be obtained before any recording begins.
**Verification:** Signed consent form in records, dated before recording.
**Rationale:** Written consent is required for research subject to external review and protects both participant and research team.
**Dependencies:** Section 11.1

---

**IP-REQ-041**
**Title:** Right of Withdrawal
**Statement:** Participants SHALL be informed of their right to withdraw at any time, including up to 30 days after receiving their transcript.
**Verification:** Consent form content review.
**Rationale:** Withdrawal rights are a legal and ethical requirement in human subjects research.
**Dependencies:** Section 11.2

---

**IP-REQ-042**
**Title:** Encrypted Storage
**Statement:** Research data SHALL be stored encrypted, with access restricted to the research team.
**Verification:** Infrastructure review.
**Rationale:** Participant and institutional data protection obligations.
**Dependencies:** Section 11.4

---

**IP-REQ-043**
**Title:** Retention Period
**Statement:** Research data SHALL be retained for a minimum of 5 years from study completion.
**Verification:** Data management policy review.
**Rationale:** Standard scientific practice enabling post-publication audit and replication.
**Dependencies:** —

---

**IP-REQ-044**
**Title:** Regulatory Classification
**Statement:** Before any data collection, the research team SHALL obtain a formal regulatory opinion on whether this research requires ethical approval under applicable national law.
**Verification:** Written regulatory opinion on file.
**Rationale:** CWRM cannot self-classify its regulatory status. Collecting data without regulatory clarity creates legal risk and may invalidate the corpus for publication.
**Dependencies:** Section 11.5

---

## 13. Conformance

A study campaign conforms to CWRM-020 if and only if:

- [ ] All IP-REQ-001 through IP-REQ-044 are satisfied, or non-compliance is documented as MD Records.
- [ ] At least one pilot interview was conducted and reviewed by each interviewer.
- [ ] All active interviewers participated in calibration before production.
- [ ] Every production interview has completed the Quality Assurance flow (Section 10) and reached Accepted status.
- [ ] All Accepted transcripts are at version v2.0 or higher.
- [ ] All failed interviews are classified, documented, and archived.
- [ ] A regulatory opinion was obtained before data collection.
- [ ] All MD Records are complete and approved by the Research Lead.

---

## 14. Out of Scope

This section protects the boundary of CWRM-020.

CWRM-020 does not define, govern, or evaluate:

- **ACT extraction or coding** → CWRM-030 — Coding Manual
- **Evidence classification** → CWRM-050 — Evidence Framework
- **Observation formulation** → CWRM-001 — Research Method
- **Invariant promotion** → CWRM-001 — Research Method
- **Design Reasoning** → CWRM-060
- **Validation of scientific conclusions** → CWRM-070 — Validation Protocol
- **Technical infrastructure** — organizational / IT responsibility
- **Interpretation of participant responses** — governed by CWRM-030

Any content found in this document relating to the above should be flagged as a scope violation.

---

## 15. Dependencies

### Incoming (this specification depends on)

| Specification | Dependency nature |
|---|---|
| CWRM-000 — Scope Guard | Principles, governance, definitions of SHALL/SHOULD/MAY |
| CWRM-001 — Research Method | Pipeline architecture, ACT/OBS/INV definitions |
| CWRM-002 — Layer Architecture | Position of Interview in Layer 1 (Evidence) |

### Outgoing (specifications that depend on this)

| Specification | Dependency nature |
|---|---|
| CWRM-030 — Coding Manual | Receives Validated Transcript v2.0 as input |

---

## 16. References

### Internal

| Reference | Description |
|---|---|
| CWRM-000 | Scope Guard — Constitution |
| CWRM-001 | Research Method v2.0 |
| CWRM-002 | Layer Architecture |
| CWRM-030 | Coding Manual *(forthcoming)* |
| CWRM-100 | Glossary *(forthcoming)* |

### External

*To be completed during bibliographic review. Candidate references:*

- Kvale, S. & Brinkmann, S. (2009). *InterViews: Learning the Craft of Qualitative Research Interviewing.*
- Patton, M. Q. (2002). *Qualitative Research and Evaluation Methods* (3rd ed.).
- Spencer, L. et al. (2003). *Quality in Qualitative Evaluation: A Framework for Assessing Research Evidence.*
- Loi Jardé (2012). *Loi relative aux recherches impliquant la personne humaine.* France.
- RGPD / GDPR (2016/679). *Règlement général sur la protection des données.*

---

## 17. Appendices *(informative)*

Appendices are informative. They do not carry normative force.

**Appendix A — Interview Guide**
Complete guide for the six phases, with exact wording of anchor questions and probing questions. Includes authorized and prohibited probing examples.

**Appendix B — Consent Form Template**
Model consent form covering all IP-REQ-040 requirements.

**Appendix C — Participant Information Sheet**
Plain-language participant information document.

**Appendix D — Metadata Form**
Structured form capturing all mandatory metadata fields.

**Appendix E — Deviation Log Template**
MD Record format and example entries.

**Appendix F — Quality Assurance Checklist**
Printable version of the Section 9 Transcript Validation checklist and Section 10 status flow checklist.

**Appendix G — Probing Technique Reference Card**
One-page reference for interviewers: authorized probes, probes to use with caution, prohibited probes, examples.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-31 | 0.1 | Draft initial |
| 2026-07-31 | 0.2 | Lifecycle, MD Records, éthique |
| 2026-07-31 | 0.3 | Refonte normative — IP-REQ, SHALL |
| 2026-07-31 | 0.4 | Contract, Out of Scope |
| 2026-07-31 | 1.0-RC | Structure finale — Section 0 Metadata, Data Management, Transcript Validation, requirements formalisés avec Verification + Dependencies + Rationale, Appendices informatifs, References |
