# M2-AR-001 — Product Governance Reconciliation Audit

**Nature :** Audit de gouvernance — pas un document de décision.
**Date :** 2026-08-06
**Périmètre :** `docs/product/` (19 documents, hors `discovery/` et `workspaces/`, déjà couverts par
la revue d'architecture M1), croisé avec les artefacts M1.
**Règle appliquée :** constat uniquement — aucune modification, fusion, suppression, ADR, ou nouvelle
Constitution n'est proposée dans ce document.

> **Suite.** [ADR-0021](adr/ADR-0021-document-lifecycle-legacy-governance.md) définit, en réponse à
> cet audit, la politique générale de cycle de vie documentaire (états possibles, qui peut changer un
> statut, traitement de `Legacy`, politique face à plusieurs Constitutions coexistantes). ADR-0021 ne
> reclasse aucun document nommé ci-dessous — les statuts `Unknown` de la section 6 restent inchangés
> jusqu'à un futur ADR de réconciliation qui les citerait explicitement.

> **Note méthodologique.** `PRODUCT-CONSTITUTION-v1.0.md`, `PRODUCT-ARCHITECTURE-v1.0.md`,
> `PRODUCT-OPERATING-MODEL-v1.0.md`, `PRODUCT-PIPELINE-v1.0.md`, `PRODUCT-PRINCIPLES.md`,
> `PRODUCT-RULEBOOK.md`, `DISPLAY-RULEBOOK.md`, `MISSION.md`, `M-001`, `PD-001`, `PP-001`, `H-P01`,
> `MP-001` ont été lus intégralement. `M-000`, `M-002`, `M-003`, `CC-000` ont été lus en intégralité
> pour `M-000` et par échantillonnage étendu (introduction, sections structurantes, listes de
> principes/invariants) pour `M-002`/`M-003`/`CC-000`, dont le volume (213, 552, 378 lignes) dépasse
> ce qui est reproduit ici. Ceci est signalé plutôt que de prétendre à une lecture exhaustive ligne
> par ligne de ces trois documents.

---

## 1. Hiérarchie documentaire — déclarations littérales, non interprétées

| Auto-déclaration | Documents concernés (citation) |
|---|---|
| **"Constitution"** | `PRODUCT-CONSTITUTION-v1.0.md` (titre) · `M-000-manifesto.md` (*"Statut : Constitution du projet"*) · `M-001-product-boundaries.md` (*"Référence : M-000 — Constitution of MedLink"*, *"Statut : Constitution du périmètre produit"*) · hors périmètre direct : `CLAUDE.md` (*"AI Engineering Constitution"*), `CONSTITUTION.md` (*"The MedLink Constitution"*) |
| **"Frozen"** | `PRODUCT-CONSTITUTION-v1.0.md` · `PRODUCT-ARCHITECTURE-v1.0.md` · `PRODUCT-OPERATING-MODEL-v1.0.md` · `PRODUCT-PIPELINE-v1.0.md` |
| **"Immutable"** | `PRODUCT-CONSTITUTION-v1.0.md` (*"Nature : Immutable — Level 1 governance document"*) |
| **"Permanent(e)"** | `M-000-manifesto.md` (*"Portée : Permanente"*) |
| **"Living document"** | `PRODUCT-PRINCIPLES.md` · `DISPLAY-RULEBOOK.md` |
| **"Active"** | `CC-000-clinical-cognitive-architecture.md` · `H-P01-progressive-clinical-trust.md` |
| **"Document fondateur" / "fondatrice" (sans statut plus fort)** | `M-000` · `M-002-domain-philosophy.md` · `M-003-theory-of-clinical-understanding.md` (*"Document théorique fondateur"*) · `MP-001-medlink-design-principle.md` (*"Principe fondateur"*) |
| **"Canonical"** | Aucune occurrence littérale trouvée dans `docs/product/` |
| **Renommé / remplacé** | `PRODUCT-RULEBOOK.md` (*"remplacé par Product Principles"*) |
| **"Draft"** | `PRODUCT-001-the-perfect-clinical-day.md` (*"Draft — Vision"*) |
| **Sans statut déclaré** | `MISSION.md` · `PRODUCT-QUESTIONS.md` · `PP-001-progressive-adoption.md` · `PD-001-first-day-experience.md` |

**Hiérarchie réellement déclarée** (relations explicites trouvées dans le texte, sans ajout) :

```
PRODUCT-CONSTITUTION-v1.0.md ("Level 1 — Immutable", auto-déclaré)
    │  "Governed by" cité explicitement par :
    ├── PRODUCT-ARCHITECTURE-v1.0.md
    ├── PRODUCT-OPERATING-MODEL-v1.0.md
    ├── PRODUCT-PIPELINE-v1.0.md (+ GOV-000 également cité)
    └── PRODUCT-PRINCIPLES.md (+ GOV-000 également cité)
            │  "Governed by" cité par :
            └── DISPLAY-RULEBOOK.md

M-000-manifesto.md ("Constitution du projet", auto-déclaré, isolé)
    │  "Référence" cité explicitement par :
    ├── M-001-product-boundaries.md
    ├── M-002-domain-philosophy.md
    └── M-003-theory-of-clinical-understanding.md (+ P-001, CW-001, hors docs/product/)

CC-000 : auto-déclaré "subordonné à CLAUDE.md, parallèle à UX-000" (hors docs/product/) — chaîne
propre, non reliée aux deux précédentes.

MISSION.md, PRODUCT-QUESTIONS.md, PP-001, PD-001, MP-001, H-P01, PRODUCT-001 : aucune relation de
gouvernance explicite déclarée vers un document tiers de docs/product/.
```

Deux chaînes de gouvernance parallèles coexistent (`PRODUCT-CONSTITUTION-v1.0` / `M-000`), chacune
avec ses propres documents subordonnés déclarés, sans lien explicite entre les deux chaînes.

---

## 2. Gouvernance — par document

| Document | Statut déclaré | Portée | Autorité revendiquée | Dépendances explicites | Dépendances implicites (thématiques, non citées) | Documents gouvernés (déclarés) |
|---|---|---|---|---|---|---|
| PRODUCT-CONSTITUTION-v1.0.md | Frozen | *"Level 1 governance"* | *"Immutable"*, révisable seulement par contradiction empirique démontrée | Aucune | — | ARCHITECTURE, OPERATING-MODEL, PIPELINE, PRINCIPLES (cité par ces 4) |
| PRODUCT-ARCHITECTURE-v1.0.md | Frozen | *"Foundational — how MedLink is built"* | Implicite via Constitution | PRODUCT-CONSTITUTION-v1.0 | GOV-000 (thème commun, non cité) | Aucun document ne le cite comme gouvernant |
| PRODUCT-OPERATING-MODEL-v1.0.md | Frozen | *"Operational — how the product team works"* | Implicite via Constitution | PRODUCT-CONSTITUTION-v1.0 | GOV-000 (boucle similaire, non citée) | Aucun |
| PRODUCT-PIPELINE-v1.0.md | Frozen | *"Foundational framework"* | Se déclare *"détail opérationnel"* de GOV-000 | PRODUCT-CONSTITUTION-v1.0, GOV-000 | ADR-0015 (sujet identique, non cité — postérieur) | PRODUCT-QUESTIONS.md, workspaces/ (via nomenclature) |
| PRODUCT-PRINCIPLES.md | Living document | Registre des Product Principles | Implicite via Constitution + GOV-000 | PRODUCT-CONSTITUTION-v1.0, GOV-000, WBD-004 (v2.0), WE-004, PDR-004 | ADR-0016/0017/0018 (postérieurs, non cités) | DISPLAY-RULEBOOK.md (cité comme gouverné) |
| PRODUCT-RULEBOOK.md | Remplacé | — | Aucune (redirection) | PRODUCT-PRINCIPLES.md | — | — |
| PRODUCT-QUESTIONS.md | Non déclaré | *"Backlog du produit"* | Implicite | Aucune | WBD-004, PRODUCT-PIPELINE-v1.0 (numérotation partagée, non citée) | — |
| DISPLAY-RULEBOOK.md | Living document | Adaptations spécialisées | *"Governed by"* PRODUCT-PRINCIPLES.md | PRODUCT-PRINCIPLES.md | WBD-004 (numérotation Workspace, non citée) | — |
| MISSION.md | Non déclaré | Filtre de décision produit | Implicite | Aucune | CLAUDE.md (texte quasi identique, non cité) | — |
| M-000-manifesto.md | Constitution / Permanente | *"Document fondateur"* | Auto-déclarée "Constitution" | Aucune | — | M-001, M-002, M-003 (via "Référence") |
| M-001-product-boundaries.md | Constitution du périmètre produit | Frontières du Core Domain | *"En cas de conflit, ce document prévaut sur les décisions locales"* | M-000 | CLAUDE.md (Core Domain défini différemment, non cité) | — |
| M-002-domain-philosophy.md | Document fondateur | Justification du choix de Core Domain | Implicite via M-000 | M-000, M-001 | — | — |
| M-003-theory-of-clinical-understanding.md | Document théorique fondateur | Théorie de la Compréhension Clinique | Se déclare *"indépendante de toute implémentation"* | M-000, P-001, CW-001 (hors `docs/product/`) | — | — |
| CC-000-clinical-cognitive-architecture.md | Active | Programme de recherche design | Explicitement **non-gouvernante** — *"subordonné à CLAUDE.md, parallèle à UX-000"* | UX-000 (hors `docs/product/`) | — | — |
| PD-001-first-day-experience.md | Non déclaré | Vision — première expérience | Implicite | Aucune | — | — |
| PP-001-progressive-adoption.md | Non déclaré | Principe — adoption progressive | Implicite | Aucune | H-P01 (thème partagé, non cité) | — |
| H-P01-progressive-clinical-trust.md | Active | Hypothèse produit testable | Implicite | Suppose le *"Domain Model… sufficiently stable"* | PP-001 (thème partagé, non cité) | — |
| MP-001-medlink-design-principle.md | Principe fondateur | Principe de reprise de raisonnement | Implicite | Aucune | MP-001 recoupe M-002/M-003 thématiquement, non cité dans un sens ni l'autre | — |
| PRODUCT-001-the-perfect-clinical-day.md | Draft — Vision, non réconcilié (auto-déclaré) | Vision — journée idéale | Aucune | Auto-référence son propre statut non réconcilié | WBD-004, AR-001 Finding-004/005 (citées en annotation séparable) | — |

---

## 3. Chaînes méthodologiques — comparaison brute

Huit chaînes distinctes trouvées au total (cinq déjà identifiées dans la revue M1, trois supplémentaires dans `docs/product/`) :

| # | Source | Chaîne |
|---|---|---|
| A | CWRM-001 | `Interviews → ACT → SEQ → OBS → RQ → INV → UX Principles → Features → Architecture` |
| B | CWRM-002 §3 | `Entretien → ACT → OBS → RQ → INV → Requirement → {ADR, UX Principle} → Feature → Implémentation` |
| C | CWRM-AF-001 | `Interview → ACT → Observation → Invariant → Requirement → Design Decision` |
| D | GOV-000 §1/§1bis | `ACT → OBS → PAT → Tensions → Gaps` puis `WE → {WBD} → PDR/PDX → Blueprint` |
| E | ADR-0015 (canonique M1) | `ACT → OBS → PAT → WE → {WBD} → PDR/PDX → Blueprint` |
| F | PRODUCT-PIPELINE-v1.0.md | `Reality → ACT → Observation(✓) → Pattern(≈) → [PRODUCT DECISION] → Product Principle → Display Rule → Product Question → Workspace Blueprint → Prototype → User Test → Iteration` |
| G | PRODUCT-ARCHITECTURE-v1.0.md | Layer 1 : `ACT → Observation → Invariant → Product Rule` — Layer 2 : `Product Rule → Display Rule → Product Question → Workspace Blueprint → Prototype` |
| H | PRODUCT-OPERATING-MODEL-v1.0.md | `Observer → Comprendre le problème → Identifier la transition cognitive → Formuler la question utilisateur → Concevoir un Workspace → Prototyper → Tester avec les praticiens → Apprendre` |

**Présence/absence par nœud, à travers les 8 chaînes :**

| Nœud | Présent dans |
|---|---|
| SEQ | A uniquement |
| RQ / Research Question | A, B uniquement |
| INV / Invariant | A, B, C, G |
| PAT / Pattern | D, E, F uniquement |
| WE (Workspace Evidence) | D, E uniquement |
| Requirement | B, C uniquement |
| Product Rule / Product Principle | F (implicite, "PRODUCT DECISION"), G — `PRODUCT-RULEBOOK.md` déclare ce terme renommé en "Product Principle", non répercuté dans F ni G |
| Design Reasoning | Nommé dans le texte de CWRM-002 hors diagramme, absent de toutes les chaînes elles-mêmes |

**Nature de H, distincte des sept autres.** H n'est pas une chaîne d'artefacts identifiés par ID —
c'est une séquence de verbes d'activité, sans production d'objet nommé à chaque étape.

**Constat, sans arbitrage.** F et G proviennent de documents "Frozen" datés du même jour
(2026-08-04), gouvernés par le même document Constitution, et ne présentent pas la même chaîne l'un
que l'autre.

---

## 4. Terminologie — inventaire des usages concurrents

| Terme | Usages trouvés |
|---|---|
| **Product Rule / Product Principle** | "Product Rule" utilisé sans réserve dans F et G. "Product Principle" utilisé dans `PRODUCT-PRINCIPLES.md`. `PRODUCT-RULEBOOK.md` déclare le premier terme renommé en second. |
| **Workspace (numérotation)** | WS-001→006 Clinical Loop (WBD-004, ADR-0015) · WS-001→010 (`PRODUCT-QUESTIONS.md`, WS-005="Signals & Alerts") · "WS-003 Clinical Summary" (`PRODUCT-ARCHITECTURE-v1.0.md`) · "WS-006 Consultation", "WS-007 Documentation" (`DISPLAY-RULEBOOK.md`, table "Sprints suivants") · Workspaces nommés non numérotés "Timeline", "Collaboration Workspace" (`PRODUCT-OPERATING-MODEL-v1.0.md`) |
| **Blueprint** | "Workspace Blueprint" (F, G) · "Blueprint" (GOV-000, ADR-0015, workspaces/) |
| **Product Question** | Format `Q-NNN` cohérent partout où le terme apparaît |
| **Display Rule** | Format `DR-NNN` cohérent partout où le terme apparaît |
| **Invariant** | Sens 1 — artefact CWRM intermédiaire (chaînes A, B, C, G : une proposition corroborée par le corpus). Sens 2 — règle de gouvernance permanente (`M-000` §10, sept invariants numérotés I à VII, ex. *"la compréhension… n'est jamais réécrite"*). Les deux sens coexistent sous le même mot sans renvoi de l'un à l'autre. |
| **Pattern** | GOV-000/ADR-0015/CWRM-EXP-001 : statut `Experimental` (ADR-0016), non gaté. `PRODUCT-PIPELINE-v1.0.md` : *"Pattern ≈ — fortement suggéré"*, présenté sans mention de ce statut (antérieur à ADR-0016). |
| **Compréhension Clinique** | Concept central de `M-000/001/002/003`. Absent de CLAUDE.md, GOV-000, CWRM, et des noms de classes Domain effectivement implémentées (`ClinicalContribution`, `ClinicalActivity`, `CareRecord`). |
| **Core Domain** | `M-001` désigne "Compréhension Clinique" comme Core Domain. CLAUDE.md ne nomme pas de "Core Domain" unique — décrit une Clinical Platform avec plusieurs concepts (Care Record, Encounter, Prescription…). |

---

## 5. Missions — comparaison

| Source | Formulation |
|---|---|
| CLAUDE.md / `MISSION.md` (docs/product) | *"Réduire l'effort cognitif nécessaire pour comprendre une situation clinique, afin que les praticiens puissent consacrer leur énergie au raisonnement, à la décision et à la relation avec leurs patients."* |
| `MANIFESTO.md` (racine) | *"Permettre aux professionnels de santé de consacrer leur attention au patient plutôt qu'à la recherche d'information."* |
| `FOUNDATIONS.md` | Pas de phrase-mission unique dédiée ; conviction équivalente : *"Le logiciel doit s'adapter à la pratique clinique. La pratique clinique ne doit jamais s'adapter au logiciel."* |
| `CONSTITUTION.md` (Préambule) | *"Réduire [la charge]… pour que l'énergie qu'elle libère retourne au patient."* |
| `PRODUCT-CONSTITUTION-v1.0.md` (Préambule + Article I) | *"Redonner du temps, de l'attention et de la sérénité"* / *"Réduire la charge cognitive… afin qu'ils puissent consacrer davantage d'attention à leurs patients."* |
| `PRODUCT-OPERATING-MODEL-v1.0.md` | *"Concevoir le meilleur environnement de travail numérique… Le logiciel qui réduit le plus la charge cognitive."* |
| `M-000` / `M-001` / `M-002` | *"Préserver et transmettre la compréhension clinique pour qu'aucun professionnel n'ait à reconstruire ce qu'un autre savait déjà."* |

**Convergence.** Sept formulations sur huit centrent la mission sur la réduction de la charge/du
temps/de l'attention du praticien, avec le patient comme bénéficiaire final.

**Divergence.** `M-000/M-001/M-002` centrent la mission sur la **transmission entre plusieurs
professionnels** comme mécanisme causal explicite de l'énoncé lui-même — les sept autres formulations
n'excluent pas la transmission mais ne la nomment pas dans l'énoncé de mission.

**Changement de focalisation.** Le groupe `M-000/001/002` positionne la Compréhension Clinique comme
un actif collectif, transmis dans le temps entre plusieurs acteurs. Les sept autres formulations
positionnent la charge cognitive comme individuelle, portée par un praticien à un instant donné, la
transmission étant une conséquence possible plutôt que l'objet direct de la mission.

---

## 6. États documentaires

| Document | Catégorie | Justification |
|---|---|---|
| PRODUCT-CONSTITUTION-v1.0.md | **Unknown** | Se déclare Frozen (donc en vigueur) mais n'est cité par aucun artefact M1 ; statut réel vis-à-vis de M1 indéterminable à partir des documents disponibles |
| PRODUCT-ARCHITECTURE-v1.0.md | **Unknown** | Idem — Frozen, jamais cité, contenu (chaîne G) divergent d'ADR-0015 sans que l'un ne mentionne l'autre |
| PRODUCT-OPERATING-MODEL-v1.0.md | **Unknown** | Idem — Frozen, jamais cité par M1 |
| PRODUCT-PIPELINE-v1.0.md | **Unknown** | Idem — Frozen, se déclare pourtant lié à GOV-000, mais absent d'ADR-0015 |
| PRODUCT-PRINCIPLES.md | **Active** | Living document, dernière mise à jour proche de M1 (2026-08-04), cite WBD-004 v2.0 (non v2.1) — actualisé jusqu'à une date antérieure à Finding-004, sans marque de péremption |
| PRODUCT-RULEBOOK.md | **Historical** | Auto-déclaré remplacé — catégorie non ambiguë |
| PRODUCT-QUESTIONS.md | **Legacy** | Pas de déclaration de retrait ; contenu (numérotation WS-001→010) non aligné sur WBD-004/GOV-000 depuis plusieurs versions de ces derniers, jamais mis à jour depuis |
| DISPLAY-RULEBOOK.md | **Unknown** | Living document déclaré, mais sa table "Sprints suivants" porte une numérotation Workspace (WS-006="Consultation", WS-007="Documentation") non alignée sur WBD-004 |
| MISSION.md | **Active** | Pas de statut déclaré, mais contenu identique à CLAUDE.md actuel — aucune contradiction relevée |
| M-000-manifesto.md | **Unknown** | Se déclare Permanente/Constitution, jamais cité par PRODUCT-CONSTITUTION-v1.0 (l'autre document "Constitution") ni par aucun artefact M1 |
| M-001-product-boundaries.md | **Unknown** | Dépend de M-000 ; même statut d'incertitude |
| M-002-domain-philosophy.md | **Unknown** | Idem |
| M-003-theory-of-clinical-understanding.md | **Unknown** | Idem, dépend en plus de documents hors périmètre (P-001, CW-001) non audités ici |
| CC-000-clinical-cognitive-architecture.md | **Active** | Se déclare Active ; format auto-révisable (Confirme/Réfute/Suspendue/Abandonnée) prévu dans le document lui-même |
| PD-001-first-day-experience.md | **Active** | Pas de statut déclaré ; vocabulaire (Care Record, Clinical Contribution) cohérent avec le Domain actuellement implémenté |
| PP-001-progressive-adoption.md | **Unknown** | Contenu non contredit par aucun artefact M1, mais jamais cité non plus — impossible à confirmer actif par recoupement |
| H-P01-progressive-clinical-trust.md | **Unknown** | Se déclare Active ; aucun artefact M1 ne confirme si l'hypothèse a été testée, validée ou réfutée depuis sa rédaction |
| MP-001-medlink-design-principle.md | **Unknown** | Se déclare "fondateur", jamais cité par un artefact M1 |
| PRODUCT-001-the-perfect-clinical-day.md | **Active** | Document le plus récent (2026-08-06), statut Draft explicitement non réconcilié — cohérence interne entre son statut affiché et son état réel |

---

## 7. Matrice de conflits

| Document A | Document B | Nature du conflit |
|---|---|---|
| PRODUCT-CONSTITUTION-v1.0.md | CONSTITUTION.md | Niveau hiérarchique |
| PRODUCT-CONSTITUTION-v1.0.md | M-000-manifesto.md | Niveau hiérarchique |
| PRODUCT-CONSTITUTION-v1.0.md | GOV-000 | Gouvernance (5 niveaux vs 6 niveaux, contenus différents) |
| PRODUCT-CONSTITUTION-v1.0.md | PRODUCT-ARCHITECTURE-v1.0.md | Gouvernance (5 niveaux vs 4 couches) |
| PRODUCT-CONSTITUTION-v1.0.md | CWRM-002 | Gouvernance (5 niveaux vs 5 Layers, contenus différents) |
| PRODUCT-PIPELINE-v1.0.md | ADR-0015 | Pipeline |
| PRODUCT-ARCHITECTURE-v1.0.md | ADR-0015 | Pipeline |
| PRODUCT-ARCHITECTURE-v1.0.md | PRODUCT-PIPELINE-v1.0.md | Pipeline |
| PRODUCT-PIPELINE-v1.0.md / PRODUCT-ARCHITECTURE-v1.0.md | PRODUCT-RULEBOOK.md | Terminologie |
| PRODUCT-QUESTIONS.md | WBD-004 / ADR-0015 | Portée (numérotation Workspace) |
| DISPLAY-RULEBOOK.md | WBD-004 | Portée (numérotation Workspace) |
| PRODUCT-OPERATING-MODEL-v1.0.md | WBD-004 / ADR-0015 | Terminologie (Workspaces nommés vs numérotés) |
| M-000/M-001/M-002 | CLAUDE.md / MISSION.md / MANIFESTO.md / CONSTITUTION.md | Mission |
| M-001-product-boundaries.md | CLAUDE.md | Terminologie / Portée (définition du Core Domain) |
| M-000 §10 (Invariants I-VII) | ADR-0001→0014 (Domain) | Gouvernance (autorité non reliée — aucun ADR Domain ne cite M-000) |
| CC-000 | UX-000 (hors périmètre) | Non audité dans ce document |
| M-003 | P-001, CW-001 (hors périmètre) | Non audité dans ce document |
| PRODUCT-PRINCIPLES.md | WBD-004 v2.1 (Finding-004) | Portée (référence à une version antérieure, v2.0) |
| ADR-0016 (statut Experimental de PAT) | PRODUCT-PIPELINE-v1.0.md | Gouvernance (Pattern présenté sans réserve de statut) |
| PRODUCT-001-the-perfect-clinical-day.md | PD-001-first-day-experience.md | Terminologie (postures de vocabulaire opposées — l'un explicitement sans DDD, l'autre l'assume) |
| MISSION.md | CLAUDE.md | Aucun (formulation identique) |
| PP-001-progressive-adoption.md | H-P01-progressive-clinical-trust.md | Aucun (thème partagé, cohérent, sans citation croisée) |

---

## 8. Conclusions

**Quels documents restent manifestement normatifs ?**
Ceux classés `Active` en §6 sans conflit relevé en §7 comme touchant leur contenu propre :
`PRODUCT-PRINCIPLES.md`, `MISSION.md`, `PD-001`, `CC-000` (dans le rôle explicitement non-gouvernant
qu'il se donne lui-même), `PP-001`.

**Quels documents semblent historiques ?**
`PRODUCT-RULEBOOK.md` (auto-déclaré remplacé) et `PRODUCT-QUESTIONS.md` (classé `Legacy` — contenu
structurellement non aligné depuis plusieurs versions de WBD-004/GOV-000, sans marque de retrait
explicite).

**Quels documents nécessitent une décision architecturale ?**
Les quatre documents "Frozen" du 2026-08-04 (`PRODUCT-CONSTITUTION-v1.0.md`,
`PRODUCT-ARCHITECTURE-v1.0.md`, `PRODUCT-OPERATING-MODEL-v1.0.md`, `PRODUCT-PIPELINE-v1.0.md`), les
quatre documents de la famille `M-000/001/002/003`, et `DISPLAY-RULEBOOK.md` — chacun apparaît dans au
moins une ligne de la matrice §7 sous une catégorie de conflit autre que "Aucun".

**Quels documents peuvent être laissés inchangés ?**
Ceux listés dans la première réponse de cette section : `PRODUCT-PRINCIPLES.md`, `MISSION.md`,
`PD-001`, `CC-000`, `PP-001`, ainsi que `PRODUCT-001-the-perfect-clinical-day.md` dont le statut
`Draft — non réconcilié` correspond déjà à ce que cet audit constate.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Audit initial — cartographie et matrice de conflits, aucune décision |
