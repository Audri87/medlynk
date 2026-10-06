# ARCH-000 — Architecture Index

Ce n'est pas une Constitution. Ce n'est pas une nouvelle spécification. Ce document ne contient
aucune règle — il répond uniquement à la question **"où se trouve la règle ?"**

Statut : Accepted. Date : 2026-08-06. Sprint M1.1 — Consolidation.

---

## Où trouver quoi

| Question | Réponse se trouve dans |
|---|---|
| Quelle est la chaîne canonique de Product Discovery ? | [ADR-0015](adr/ADR-0015-canonical-discovery-pipeline.md) |
| Quel est le statut de chaque concept (Stable / Experimental / Historical) ? | [ADR-0016](adr/ADR-0016-status-of-experimental-concepts.md) |
| Qu'est-ce que "gelé" veut dire, et qui a le droit de l'être ? | [ADR-0017](adr/ADR-0017-freeze-semantics.md) |
| Comment une preuve doit-elle être tracée (confiance, ancrage ACT/OBS) ? | [ADR-0018](adr/ADR-0018-evidence-traceability.md) |
| Qui décide quoi, avec quelle preuve, dans quel ordre ? (niveaux, Gates, marqueurs ✓/≈/?/→/⚠) | [GOV-000](process/GOV-000-medlink-governance-v1.0.md) |
| Comment la recherche terrain est-elle conduite et codée ? | [CWRM-000](research/specifications/CWRM-000-scope-guard.md) → [CWRM-020](research/specifications/CWRM-020-interview-protocol.md) (voir [INDEX](research/specifications/INDEX.md)) |
| Quelle est la Clinical Loop, Workspace par Workspace ? | [WS-001](product/workspaces/WS-001-morning-brief.md) · [WS-002](product/workspaces/WS-002-patient-context.md) · [WS-003](product/workspaces/WS-003-consultation.md) · [WBD-004](product/workspaces/WBD-004-consultation-vs-documentation.md) (frontières WS-004/005/006) |
| Quelles décisions Domain/Kernel sont déjà prises ? | [docs/adr/](adr/) (ADR-0001 → ADR-0014) |
| Quelles décisions d'architecture logicielle (Symfony, persistence, events) ? | [docs/architecture/](architecture/) (ADR-SA-000 → ADR-SA-027) |
| Quelle est la Constitution produit/Domain (non technique) ? | [CLAUDE.md](../CLAUDE.md) |
| Peut-on construire une fonctionnalité non observée ? Quel code est autorisé avant validation ? | [ADR-0025](adr/ADR-0025-innovations-produit-non-observees.md) (applique GOV-000 §1bis — fiche HYP, critère d'abandon, code produit après Gate 3) |
| Pourquoi existe-t-il plusieurs générations de documents (Vision, Théorie, M1, M2) ? | [MEDLINK-000](MEDLINK-000-from-intuition-to-reality.md) — non normatif, purement explicatif |

---

## Statut du jalon M1

Archive complète : [M1_FINAL_ARCHIVE](M1_FINAL_ARCHIVE.md). Audit empirique figé :
[AR-001B](AR-001B-empirical-audit-ws005.md) (corrobore Finding-004 par clustering aveugle ;
protocole généralisé dans [CWRM-EXP-001](research/specifications/CWRM-EXP-001-state-transition-analysis.md),
**Accepted (Experimental)** — protocole accepté, hypothèse testée toujours non validée, hors core CWRM). M1 est clos — [ADR-0019](adr/ADR-0019-close-milestone-m1.md) (*"Architecture Foundation accepted"*,
2026-08-06), enregistrement narratif équivalent dans
[M1-ARCHITECTURE-FOUNDATION](M1-ARCHITECTURE-FOUNDATION.md). La clôture exclut explicitement deux
items de dette (`Deferred`), formalisés dans le registre ci-dessous. L'ouverture de WS-006 devait être
précédée par [AR-001](AR-001-architecture-review.md), **`Closed`** depuis le 2026-10-05 — *"Findings
formally classified and dispositioned"* : Finding-002, Finding-004, Finding-005 `Resolved`
([ADR-0020](adr/ADR-0020-perimetre-mandat-ws005-coordination.md) tranche la conséquence d'architecture
de Finding-005, Accepted, mandat WS-005 réduit à Transmission) ; Finding-001
(`Open — Methodology Debt Confirmed`, Gate PAT/CWRM-030 manquants) et Finding-003
(`Open — Empirical Resolution Required`, frontière WS-006 → WS-001) restent `Open` mais qualifiés,
non-bloquants, avec condition de résolution documentée — condition de clôture d'AR-001 explicitement
amendée le 2026-10-05 pour reconnaître cet état. **Note de séquence (non corrigée rétroactivement)** :
WS-006 a été intégré au proof set M2 ([ADR-0024](adr/ADR-0024-ws004-nature-et-proof-set-m2.md),
2026-09-08) et un écran construit dans le prototype un mois **avant** cette clôture — la précondition
d'ADR-0019 n'a pas été respectée dans l'ordre prévu. Tracée dans AR-001 lui-même, pas corrigée
rétroactivement.

## Écarts connus (documentés, pas masqués)

| Écart | Où il est tracé | Statut |
|---|---|---|
| WE-005 ne respecte pas les règles de confiance/ancrage | [ADR-0018](adr/ADR-0018-evidence-traceability.md), [WE-005](product/workspaces/WE-005-information-flow.md) | Ouvert — attend un recodage réel |
| Sens du flux de WS-005 : nature à deux temps évidencée (AR-001 Finding-004), store de sortie encore non précisé | [WBD-004](product/workspaces/WBD-004-consultation-vs-documentation.md) §Verdict | Ouvert — ⚠ (réduit) |
| Nom candidat *Clinical Coordination* contesté par sa propre première preuve | [WE-005](product/workspaces/WE-005-information-flow.md) §9 | Ouvert |
| WS-006 sans Blueprint | [WS-003](product/workspaces/WS-003-consultation.md) §11 | Ouvert — statut `Research Workspace` |
| **ARCH-DEBT-001** — Frontière WE ↔ PDR déjà franchie une fois en pratique | [ARCH-DEBT-REGISTER](ARCH-DEBT-REGISTER.md) | `Deferred` — exclu de M1 |
| **ARCH-DEBT-002** — Module `Workspace` historiquement présent en `Domain` | [ARCH-DEBT-REGISTER](ARCH-DEBT-REGISTER.md) | `Deferred` — exclu de M1 |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — Sprint M1.1, table des matières de l'architecture consolidée |
| 2026-08-06 | 1.1 | Ajout du statut de signature M1 ([M1-ARCHITECTURE-FOUNDATION](M1-ARCHITECTURE-FOUNDATION.md)) ; ARCH-DEBT-001/002 formalisés dans [ARCH-DEBT-REGISTER](ARCH-DEBT-REGISTER.md) plutôt que décrits en prose |
| 2026-08-06 | 1.2 | Clôture M1 formalisée par [ADR-0019](adr/ADR-0019-close-milestone-m1.md) ; mention de `AR-001` (identifiant réservé, revue précédant WS-006) |
| 2026-08-06 | 1.3 | [AR-001](AR-001-architecture-review.md) rédigé — Finding-004 résolu (frontière WS-004/WS-005 corrigée dans WBD-004 v2.1) |
| 2026-08-06 | 1.4 | [AR-001B](AR-001B-empirical-audit-ws005.md) figé — audit aveugle par transformations d'état, corrobore Finding-004. Protocole général [CWRM-EXP-001](research/specifications/CWRM-EXP-001-state-transition-analysis.md) référencé (hors core CWRM, ne remplace pas le slot réservé CWRM-040) |
| 2026-08-06 | 1.5 | [CWRM-EXP-001](research/specifications/CWRM-EXP-001-state-transition-analysis.md) passe **Accepted (Experimental)** v1.0 — le protocole est accepté comme méthode, l'hypothèse qu'il teste reste Experimental |
| 2026-08-06 | 1.7 | [ADR-0022](adr/ADR-0022-m2-freeze-protocol.md) — gel de M2 pendant WS-002/004/005 ; [M2-JOURNAL-observations](../product/M2-JOURNAL-observations.md) ouvert |
| 2026-08-06 | 1.8 | [ADR-0023](adr/ADR-0023-patient-context-consultation-care-record.md) — structure Dashboard/WS-002/WS-003/Care Record figée ; OQ-W-012 (WS-003) résolue |
| 2026-08-06 | 1.6 | [AR-001](AR-001-architecture-review.md) Finding-005 ajouté — constat pur d'écart de corroboration sur le mandat WS-005, aucune décision. `ADR-0020` réservé, non rédigé |
| 2026-10-05 | 1.9 | [ADR-0020](adr/ADR-0020-perimetre-mandat-ws005-coordination.md) rédigé et Accepted (mandat WS-005 réduit à Transmission, Avis/Délégation en hypothèses avec garde-fou de révision) ; [AR-001](AR-001-architecture-review.md) Finding-002 formalisé et résolu (Mission `CLAUDE.md` confirmée plus générale que le périmètre `CWRM-001`, Mission laissée inchangée, distinction Mission/Research Evidence Scope introduite) ; note de séquence ajoutée sur l'ouverture anticipée de WS-006 avant clôture d'AR-001 |
| 2026-10-05 | 2.0 | [AR-001](AR-001-architecture-review.md) Finding-003 formalisé — `Open — Empirical Resolution Required`, pas `Resolved` : frontière WS-006 → WS-001 confirmée non définie des deux côtés (Blueprint WS-001 muet, prototype WS-006 muet), aucune position provisoire actée, résolution conditionnée à un round praticien posant les 4 questions déjà écrites (CWRM-020-APX-M2-workspace-questionnaires §6). Finding-001 reste seul non formalisé |
| 2026-10-05 | 2.1 | [AR-001](AR-001-architecture-review.md) Finding-001 formalisé (`Open — Methodology Debt Confirmed`, Gate PAT/CWRM-030 manquants, impact réel démontré sur WE-005) puis **AR-001 clos** : condition de clôture amendée (reconnaît désormais Resolved et Open-qualifié-avec-condition, pas seulement Resolved/Deferred), statut passé `Closed — Findings formally classified and dispositioned` |
| 2026-10-05 | 2.2 | [ADR-0025](adr/ADR-0025-innovations-produit-non-observees.md) Accepted — innovations non observées encadrées par application de GOV-000 §1bis (pas de nouvelle méthode) : fiche HYP légère, critère d'abandon obligatoire, quatre types de code, code produit conditionné à Gate 3. GOV-000 annoté (v1.9) |
