# ADR-0015 — Pipeline Canonique de Product Discovery

**Statut** : Accepted
**Date** : 2026-08-06
**Sprint** : M1.1 — Consolidation (priorité 1)
**Répond à** : Critique 1 de la revue d'architecture M1 (Principal Product Architect, 2026-08-06)

---

## Contexte

Cinq documents du corpus décrivent une "chaîne" de transformation de la preuve en décision produit,
sans qu'aucun ne cite ni ne supersède les autres :

| Source | Statut du document | Chaîne décrite |
|---|---|---|
| CWRM-001 §"Le pipeline" | Accepted | `Interviews → ACT → SEQ → OBS → RQ → INV → UX Principles → Features → Architecture` |
| CWRM-002 §3 | Accepted — Architecture Freeze v1.0 | `Entretien → ACT → OBS → RQ → INV → Requirement → {ADR, UX Principle} → Feature → Implémentation` |
| CWRM-AF-001 §"La chaîne méthodologique" | **Accepted — Binding** | `Interview → ACT → Observation → Invariant → Requirement → Design Decision` |
| GOV-000 §1 / §1bis | Accepted | `ACT → OBS → PAT → Tensions → Gaps` (Niveau 1), puis `WE → {WBD} → PDR → Blueprint` ou `WE → PDX → …` (Niveau 2) |
| Message de freeze M1 (2026-08-06) | Proposition | `RH → ACT → OBS → PAT → WE → PDR → Blueprint` |

Ces cinq chaînes ne partagent pas le même jeu de nœuds : SEQ disparaît dès CWRM-002 ; RQ et INV
disparaissent de GOV-000 et du message M1 ; PAT n'apparaît dans aucune des trois versions CWRM ;
Tensions et Gaps disparaissent du message M1. Deux de ces documents sont individuellement "gelés"
(CWRM-002, CWRM-AF-001) et contradictoires entre eux.

---

## Problème

En l'absence d'une chaîne unique déclarée, aucun artefact Product ne peut être audité pour
conformité : "suit-il le pipeline ?" n'a pas de réponse vérifiable tant qu'il existe plusieurs
pipelines candidats. En pratique, les quatre seuls artefacts Product réels du corpus (WE-004,
WE-005, PDR-004, PDX-001) suivent tous la chaîne GOV-000 (ACT→OBS→PAT→WE→PDR/PDX→Blueprint) et
aucun ne produit de SEQ, RQ, INV, Requirement ou Design Reasoning — la chaîne CWRM-001/002/AF-001
n'a, à ce jour, jamais été exercée par un artefact réel.

---

## Décision

### Règle 1 — La chaîne GOV-000 est canonique pour tout artefact Product Discovery

À partir de cet ADR, la chaîne suivante est la seule chaîne officielle pour produire un artefact
Product Discovery (WE, WBD, PDR, PDX, Blueprint) :

```
Reality
    │
    ▼
ACT — Reported Clinical Action
    │
    ▼
OBS — Observation empirique (ancrée à un ACT, jamais orpheline)
    │
    ▼
PAT — Pattern (statut : Experimental — voir ADR-0016) ── Tension (⚠) ── Corpus Gap (?)
    │
    ▼
Workspace Evidence (WE)
    │
    ├── Workspace Boundary Decision (WBD), si le périmètre est contesté
    │
    ├──────────────────────────────┐
    ▼                               ▼
Product Decision Record (PDR)   Product Discovery (PDX) — §1bis GOV-000
    │                               │
    ▼                               ▼
Blueprint                    Prototype exploratoire → Tests → Validation/Rejet
```

### Règle 2 — La chaîne CWRM-001/002/AF-001 (SEQ, RQ, INV, Requirement, Design Reasoning) est
### déclarée Historical

Elle n'est pas invalidée en tant que spécification de recherche : elle reste la description
officielle de ce que la couche Layer 2 — Knowledge (CWRM-002) *devrait* produire si elle était
exercée. Mais elle n'est **pas** la chaîne à suivre pour produire un artefact Product aujourd'hui.
Son statut de concept est traité par ADR-0016.

### Règle 3 — Cet ADR constitue la justification d'évolution exigée par CWRM-AF-001

CWRM-AF-001 §"Critères d'acceptation pour toute évolution future" exige une réponse aux cinq
questions suivantes avant toute modification de la chaîne qu'il gèle :

| # | Question | Réponse |
|---|---|---|
| 1 | Quel problème empirique résout-elle ? | L'existence de cinq chaînes contradictoires rendait impossible tout audit de conformité (Critique 1, revue M1). |
| 2 | Quel Claim renforce-t-elle ? | Aucun Claim scientifique (H1/H2/H3, CWRM-FND-001) n'est modifié — seule la représentation pratique de la chaîne l'est. La traçabilité, nécessaire à H1, est renforcée par la levée de l'ambiguïté. |
| 3 | Quelle hypothèse est concernée ? | Aucune hypothèse scientifique du CWRM. Décision de gouvernance, pas de méthode de recherche. |
| 4 | Comment sera-t-elle validée ? | Tout nouveau WE/PDR/PDX doit citer explicitement à quelle étape de la Règle 1 il correspond (revue de conformité). |
| 5 | Quelle métrique permettra de conclure ? | Zéro nouvelle chaîne divergente introduite dans les 90 jours suivant l'adoption. |

### Règle 4 — Toute nouvelle chaîne proposée doit d'abord amender cet ADR

Aucun futur document (spec, changelog, message de freeze) ne peut introduire une variante de la
chaîne Product Discovery sans amender explicitement cet ADR (nouvelle version, historique conservé).

---

## Conséquences

**Pour CWRM-001/CWRM-002** — Restent Accepted en tant que spécifications de méthode de recherche.
Leur chaîne SEQ→RQ→INV→Requirement→Design Reasoning n'est plus présentée comme la chaîne en cours
d'exécution ; elle est disponible pour réactivation si un besoin empirique le justifie (ADR-0016).

**Pour CWRM-AF-001** — Reste Accepted — Binding sur les points qu'il gèle par ailleurs (méta-modèle,
Claims). Sa description de "la chaîne méthodologique" est amendée par le présent ADR selon son
propre protocole d'évolution (Règle 3 ci-dessus).

**Pour les artefacts existants (WE-004, WE-005, PDR-004, PDX-001)** — Rétroactivement conformes à la
Règle 1 sans modification requise.

**Pour tout futur Workspace (WS-006 et suivants)** — Doit suivre la Règle 1 sans exception.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| CWRM-001 — Research Method | Sa chaîne pipeline est déclarée Historical (non exercée) par cet ADR |
| CWRM-002 — Layer Architecture | Sa chaîne de transformation (§3) est déclarée Historical par cet ADR ; les 5 couches (§2) restent valides comme cadre conceptuel |
| CWRM-AF-001 — Architectural Freeze | Amendé selon son propre protocole d'évolution (Règle 3) |
| GOV-000 — Governance | §1/§1bis constituent désormais la chaîne canonique, formalisée ici comme telle |
| ADR-0016 — Status of Experimental Concepts | Définit le statut de chaque nœud de la chaîne canonique |
| ADR-0017 — Freeze Semantics | Clarifie ce que signifie "canonique" par rapport à "gelé" |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — Sprint M1.1, réponse à la Critique 1 de la revue d'architecture M1 |
