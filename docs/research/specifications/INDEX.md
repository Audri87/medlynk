# Specifications — Index

Les spécifications définissent les règles du framework CWRM.

Conventions normatives : toute spec est normative, comporte un Contract (Design by Contract), une section Out of Scope, des exigences identifiables ([PREFIX]-REQ-NNN) et une Conformance checklist.

Template : [SPEC-TEMPLATE.md](SPEC-TEMPLATE.md)

---

## Dependency Graph

```
CWRM-STD-001 (Specification Standard)
CWRM-STD-002 (Identity Model)
        │
        ▼ governed by
CWRM-000 (Constitution)
CWRM-000A (Conceptual Model)     ← foundational vocabulary — all objects and relationships
        │
        ▼ defines objects for
        │
        ├──▶ CWRM-001 (Research Method)
        ├──▶ CWRM-002 (Layer Architecture)
        ├──▶ CWRM-020 (Interview Protocol)
        │               │
        │               ▼
        │         CWRM-030 (Coding Manual) [à venir]
        │               │
        │               ▼
        │         CWRM-040 (ACT Taxonomy) [à venir]
        │               │
        │               ▼
        │         CWRM-050 (Evidence Framework) [à venir]
        │               │
        │               ▼
        │         CWRM-060 (Design Reasoning) [à venir]
        │               │
        │               ▼
        │         CWRM-070 (Validation Protocol) [à venir]
        │
        └──▶ CWRM-100 (Glossary) [à venir — source unique des définitions]
```

---

## Specifications

| ID | Document | Status | Depends on | Required by | Description |
|---|---|---|---|---|---|
| CWRM-STD-001 | [Specification Standard](CWRM-STD-001-specification-standard.md) | Draft 1.0.0 | CWRM-000 | All | Meta-standard — structure, meta-model, identifier policy, traceability |
| CWRM-STD-002 | [Identity & Identifier Standard](CWRM-STD-002-identity-identifier-standard.md) | Draft 1.0.0 *(frozen pending 000A)* | CWRM-000, STD-001, **000A** | All | Three-level identity model — Internal ID / Canonical URI / Provenance · Minting policy · Registry · ABNF grammar |
| CWRM-000 | [Scope Guard](CWRM-000-scope-guard.md) | Draft v1.2 | — | All | Constitution du framework |
| CWRM-000A | [Conceptual Model](CWRM-000A-conceptual-model.md) | Accepted 1.0.0 | CWRM-000 | STD-001, STD-002, STD-003, STD-004, STD-005 | Object taxonomy (Governance / Knowledge / Process / Translation) · 4 concerns · Relationship taxonomy · Knowledge graph model |
| CWRM-FND-001 | [Epistemological Foundations](CWRM-FND-001-epistemological-foundations.md) | Draft 0.1 | CWRM-000, CWRM-000A | All specifications | Critical pragmatism · H1 (Representation Hypothesis) · Evidence ≠ Provenance · Meta-model vs domain model evaluation |
| CWRM-SCI-000 | [Scientific Constitution](CWRM-SCI-000-scientific-constitution.md) | **Accepted 1.0.0** | CWRM-000, CWRM-FND-001 | All research activity | 10 rules · falsifiability · evidence-driven evolution · IRR as primary validity measure |
| CWRM-AF-001 | [Architectural Freeze v1.0](CWRM-AF-001-architectural-freeze.md) | **Accepted — Binding** | All | — | Freeze declaration 2026-08-04 · 5 acceptance criteria · scientific roadmap Phase A/B/C |
| CWRM-000-CR | [Conception Record](CWRM-000-conception-record.md) | Draft | — | — | Pourquoi le Scope Guard existe |
| CWRM-001 | [Research Method](CWRM-001-research-method.md) | Accepted v2.1 | CWRM-000 | CWRM-020+ | Pipeline — ACT, OBS, RQ, INV. v2.1 : OBS-REQ-001/002/003 (formalisation de §4/Règle 5, pas de nouveau concept — conforme CWRM-AF-001) |
| CWRM-002 | [Layer Architecture](CWRM-002-layer-architecture.md) | Accepted — Freeze v1.0 | CWRM-000, CWRM-001 | All | 5 couches, chaîne Evidence → Feature |
| CWRM-020 | [Interview Protocol](CWRM-020-interview-protocol.md) | Draft 1.0.0-RC | CWRM-000, CWRM-001, CWRM-002 | CWRM-030 | 44 IP-REQ, Contract, Data Management, Transcript Validation — **delta STD-001 documenté** |
| CWRM-020-APX-WS005 | [Guide Coordination clinique (WS-005)](CWRM-020-APX-WS005-coordination-guide.md) | Draft 0.3 | CWRM-020, CWRM-001 v2.1 | WE-005 *(à venir)*, GOV-000 §1ter-b | Supplément non normatif — grille ACT/OBS/PAT ciblée confiance/continuité/transmission/responsabilité/coordination ; RP-WS005-001→005 ; PAT-REQ-001 scopé localement (non intégré au pipeline core, cf. CWRM-AF-001), pour le test de l'hypothèse Cognitive Responsibility sur WS-005 |
| CWRM-020-APX-M2 | [Questionnaires M2 par Workspace](CWRM-020-APX-M2-workspace-questionnaires.md) | Draft 0.1 | CWRM-020, PP-NNN, WBD-004, AR-001 Finding-005 | Sprint 1 M2 (WS-002) | Six questionnaires (WS-001→006), chacun ancré dans l'existant plutôt que construit à partir de zéro — complète CWRM-020-APX-WS005 sans le remplacer |
| CWRM-020-APX-M2-USA | [Script de test utilisateur WS-002/WS-003](CWRM-020-APX-M2-usability-script-ws002-ws003.md) | Draft 0.2 | CWRM-020 §7.4, CWRM-020-APX-M2, ADR-0023 | Sessions de test sur `WS-002-WS-003-parcours-v2.html` | Test d'utilisabilité modéré (exploration libre + 3 scénarios), pas un entretien narratif ; ancre explicitement la question de densité des tags (§2) et la Lecture A de la sidebar Care Record dans le Scénario 2 ; route les observations vers CWRM-020-APX-M2 ou M2-JOURNAL-observations |
| CWRM-020-APX-M2-QST | [Questionnaire praticiens WS-002/WS-003](CWRM-020-APX-M2-questionnaire-praticiens-ws002-ws003.md) | Draft 0.1 | CWRM-020-APX-M2-USA | Envoi asynchrone aux praticiens (lien hébergé + identifiants) | Version auto-administrée du script modéré CWRM-020-APX-M2-USA, prête à copier dans un email/Google Form, sans jargon interne ; §7 (non envoyé) route les réponses vers CWRM-020-APX-M2 / M2-JOURNAL-observations |
| CWRM-020-APX-M2-R8 | [Guide du Round v8](CWRM-020-APX-M2-round-v8-guide.md) | Prêt pour exécution 1.1 | CWRM-020-APX-M2, CWRM-020-APX-WS005, ADR-0025 | Round praticien sur `WS-002-WS-003-parcours-v8.html` | Matrice opérationnelle des 30 hypothèses (29 à tester, 1 résolue par décision) en 9 séquences ; porte les 4 questions §6 de Finding-003 mot pour mot, le round 1/3 du garde-fou ADR-0020 (Transmission/Avis/Délégation) et la sortie vers le Journal M2 (ADR-0022 §4) |
| CWRM-020-APX-M2-R8-SCRIPT | [Script animateur du Round v8](CWRM-020-APX-M2-round-v8-script.md) | 1.0 | CWRM-020-APX-M2-R8 | Sessions de 45 min, conduisibles par un animateur tiers | Tronc commun + Module A (travail restant, dossier, transmission — ADR-0020) ou Module B (fin de journée, lendemain — Finding-003) en alternance ; 10 sessions pour 5 praticiens par hypothèse ; questions [MOT POUR MOT] ; le guide fait foi en cas d'écart |
| CWRM-030 | — | Prévu | CWRM-020 | CWRM-040 | Coding Manual |
| CWRM-040 | — | Prévu (réservé — "ACT Taxonomy", non occupé) | CWRM-030 | CWRM-050 | ACT Taxonomy |
| CWRM-EXP-001 | [State Transition Analysis](CWRM-EXP-001-state-transition-analysis.md) | **Accepted (Experimental) 1.0** — protocole accepté, hors core, non intégré au pipeline | CWRM-000, CWRM-001 | — | Protocole expérimental — teste l'hypothèse "transformation d'état" vs "action" comme primitive (hypothèse elle-même toujours Experimental) ; ne modifie ni ne remplace CWRM-040 |
| CWRM-050 | — | Prévu | CWRM-040 | CWRM-060 | Evidence Framework |
| CWRM-060 | — | Prévu | CWRM-050 | CWRM-070 | Design Reasoning |
| CWRM-070 | — | Prévu | CWRM-060 | — | Validation Protocol |
| CWRM-100 | — | **Prévu (priorité)** | CWRM-000, STD-001 | All | Glossary — source unique des définitions normatives (DEF-NNN identifiers) |

---

## CWRM-020 Gap Analysis vs CWRM-STD-001

CWRM-020 v1.0-RC satisfait la majorité de STD-001. Delta à combler avant promotion en v1.0.0 :

| Gap | Nature | STD-001 Requirement |
|---|---|---|
| `Related Risks` absent de chaque IP-REQ | Champ manquant | STD-REQ-006 |
| `Revision History` absent de chaque IP-REQ | Champ manquant | STD-REQ-006 |
| `Normative Level` absent (implicite SHALL) | Champ manquant | STD-REQ-006 |
| Principes RP-001–005 sans `Motivation`, `Consequences`, `Related Requirements` | Objet incomplet | STD-REQ-007 |
| Interview Lifecycle non formalisé comme objet WF-INT-001 (sans Success Criteria / Failure Conditions) | Objet manquant | STD-REQ-008 |
| Version en `1.0-RC` au lieu de `1.0.0-RC` | Format | STD-REQ-011 |
| Conformance Rules sans identifiants CONF-INT-NNN | Objet manquant | STD-REQ-003 |
| Section ordre : Requirements (§12) après Workflow (§7) — intentionnel, à documenter | Décision architecturale | À justifier |
