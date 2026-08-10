# MKA-000 — MedLink Knowledge Architecture

**Type :** Architecture Document — Carte du corpus de connaissance
**Statut :** v1.0
**Date :** 2026-07-30
**Autorité :** Ce document décrit comment tous les documents du Knowledge System s'articulent.
Il répond à : quel document dépend de quel autre, lequel est normatif, lequel peut évoluer indépendamment.

---

## Positionnement

MKA-000 n'est ni l'ontologie (MKO-000), ni la gouvernance (MKG-000), ni la philosophie (MMP-000).

Il est la carte du corpus.

Là où MKO-000 définit *ce que sont* les objets de connaissance, MKA-000 définit *comment les documents qui les contiennent sont reliés entre eux*.

---

---

# I. Carte complète du corpus

```
═══════════════════════════════════════════════════════════════════════
LAYER 0 — GOVERNANCE
═══════════════════════════════════════════════════════════════════════

  MKG-000  Knowledge Governance Charter        [à créer]
  ─────────────────────────────────────────────────────────────────────
  Lifecycle · Décisions scientifiques · Versioning · Review process

                               │ GOVERNS
                               ▼

═══════════════════════════════════════════════════════════════════════
LAYER 1 — ONTOLOGY & ARCHITECTURE
═══════════════════════════════════════════════════════════════════════

  MKO-000  Knowledge Ontology                  [Draft v0.1]
  ─────────────────────────────────────────────────────────────────────
  Object Types · Relation Types · Constraints · Inference Rules

  MKA-000  Knowledge Architecture              [ce document — v1.0]
  ─────────────────────────────────────────────────────────────────────
  Carte du corpus · Dépendances · Règles normatives · Publication

  MKO-ISS-001  Design Review                   [In Review]
  ─────────────────────────────────────────────────────────────────────
  15 issues identifiées · 4 bloquantes · produit MKO-000 v0.2

                               │ DEFINES
                               ▼

═══════════════════════════════════════════════════════════════════════
LAYER 2 — SCIENTIFIC FRAMEWORK
═══════════════════════════════════════════════════════════════════════

  MMP-000  Manifesto & Philosophy              [v1.0]
  ─────────────────────────────────────────────────────────────────────
  Document fondateur · Vision · 10 principes · Ambition

  CCF-000  Clinical Cognition Framework        [Accepted v1.0]
  ─────────────────────────────────────────────────────────────────────
  Framework charter · Schéma canonique · Règles d'utilisation CCF

  CCF-01   Clinical Cognitive Architecture     [Draft v1.1]
  ─────────────────────────────────────────────────────────────────────
  Structure permanente · Cycle cognitif · Invariants · Familles

  CCF-02   Clinical Cognitive Episode          [Draft v1.0]
  ─────────────────────────────────────────────────────────────────────
  7 phases · Ruptures cognitives · Frontière humain/assistable

  CI-registry  Cognitive Invariants            [Draft v0.1]
  ─────────────────────────────────────────────────────────────────────
  Registre normatif · CI-01 à CI-05 · Justification scientifique

  CCP-registry  Clinical Profiles              [Draft v0.1]
  ─────────────────────────────────────────────────────────────────────
  Registre normatif · CCP-001 à CCP-003 · Configurations d'invariants

  ── Corpus de recherche (non normatif) ──────────────────────────────
  F-001 à F-009   Entretiens cliniques         [Accepted]
  CC-000          Hypothèses et corpus         [Active]

                               │ DERIVES / IMPLIES
                               ▼

═══════════════════════════════════════════════════════════════════════
LAYER 3 — TRANSLATION FRAMEWORK
═══════════════════════════════════════════════════════════════════════

  CN-registry  Cognitive Needs                 [Draft v0.1]
  ─────────────────────────────────────────────────────────────────────
  Registre normatif · CN-01 à CN-05 · Dérivés des CI

  WR-xxx   Workspace Requirements              [in CCF-01 v1.1]
  ─────────────────────────────────────────────────────────────────────
  WR-01 à WR-09 · À migrer vers registre autonome

  UX-xxx   UX Principles                       [à créer]
  ─────────────────────────────────────────────────────────────────────
  Anchor · Progressive Disclosure · Delta View · Source Badge

  IP-xxx   Interaction Patterns                [à créer]
  ─────────────────────────────────────────────────────────────────────
  Patterns réutilisables · Validés par tests utilisateurs

                               │ IMPLEMENTED_BY
                               ▼

═══════════════════════════════════════════════════════════════════════
LAYER 4 — PRODUCT ARCHITECTURE
═══════════════════════════════════════════════════════════════════════

  ADR-SA-005 à ADR-SA-013   Architecture Decisions
  ─────────────────────────────────────────────────────────────────────
  CQRS · Persistence · Event Delivery · Read Model · Integration

  Domain Documents (UL-001, CPP-001, ADR-0001 à ADR-0014)
  ─────────────────────────────────────────────────────────────────────
  Ubiquitous Language · Bounded Contexts · Platform decisions

  Product Capabilities · Workspaces · Features · UI Components
  ─────────────────────────────────────────────────────────────────────
  Patient Workspace · Practitioner Workspace · Collaboration WS

═══════════════════════════════════════════════════════════════════════
```

---

---

# II. Classification normative

Un document est **normatif** s'il gouverne les décisions d'autres documents.
Un document est **dérivé** s'il est produit à partir d'un document normatif.
Un document est **indépendant** s'il peut évoluer sans affecter d'autres documents.

| Document | Classification | Gouverné par | Gouverne |
|---|---|---|---|
| MKG-000 | Normatif — Governance | — | Tous |
| MKO-000 | Normatif — Ontologie | MKG-000 | Tous les MK*, CCF*, CI, CN, CCP |
| MKA-000 | Normatif — Architecture | MKO-000 | (documentation) |
| MMP-000 | Fondateur — Philosophie | MKO-000 | (pas de dérivés techniques) |
| CCF-000 | Normatif — Framework | MKO-000 | CCF-01, CCF-02, CI-xxx, CN-xxx, WR-xxx, UX-xxx |
| CCF-01 | Normatif — Architecture cognitive | CCF-000 | CI-registry, CCP-registry |
| CCF-02 | Normatif — Episode | CCF-000, CCF-01 | CN-registry (ruptures), WR-xxx |
| CI-registry | Normatif — Invariants | CCF-01 | CN-registry, WR-xxx |
| CCP-registry | Normatif — Profils | CCF-01, CI-registry | (documentation, design profil-spécifique) |
| CN-registry | Normatif — Besoins | CI-registry | WR-xxx |
| WR-xxx | Normatif — Requirements | CN-registry | UX-xxx |
| UX-xxx | Décisionnel — Design | WR-xxx | IP-xxx |
| IP-xxx | Décisionnel — Patterns | UX-xxx | Product Capabilities |
| ADR-SA-xxx | Décisionnel — Technique | IP-xxx, UX-xxx | Implémentation |
| F-001 à F-009 | Source — Corpus | — | CI-registry (évidence) |

---

---

# III. Matrice de dépendances

La matrice répond à : si le document en *ligne* change, quels documents en *colonne* doivent être révisés ?

```
                  MKO  CCF  CCF  CI   CCP  CN   WR   UX   IP   ADR
                  000  000  01   reg  reg  reg  xxx  xxx  xxx  -SA
────────────────┼─────────────────────────────────────────────────
MKG-000         │  ●    ●    ●    ●    ●    ●    ●    ●    ●    ·
MKO-000         │  ·    ●    ●    ●    ●    ●    ●    ●    ●    ·
CCF-000         │  ·    ·    ●    ●    ●    ●    ●    ●    ●    ·
CCF-01          │  ·    ·    ·    ●    ●    ●    ●    ●    ●    ·
CCF-02          │  ·    ·    ·    ·    ·    ●    ●    ·    ·    ·
CI-registry     │  ·    ·    ·    ·    ●    ●    ●    ●    ●    ·
CCP-registry    │  ·    ·    ·    ·    ·    ·    ·    ●    ●    ·
CN-registry     │  ·    ·    ·    ·    ·    ·    ●    ●    ●    ·
WR-xxx          │  ·    ·    ·    ·    ·    ·    ·    ●    ●    ·
UX-xxx          │  ·    ·    ·    ·    ·    ·    ·    ·    ●    ·
IP-xxx          │  ·    ·    ·    ·    ·    ·    ·    ·    ·    ●
ADR-SA-xxx      │  ·    ·    ·    ·    ·    ·    ·    ·    ·    ·

● = révision requise    · = indépendant
```

**Lecture :** Si CI-registry est modifié (une ligne), CCP-registry, CN-registry, WR-xxx, UX-xxx et IP-xxx doivent être révisés. Les ADR techniques sont indépendants — une réfutation d'invariant ne requiert pas de révision des décisions d'architecture technique.

---

---

# IV. Zones d'indépendance

Certaines zones peuvent évoluer sans déclencher de cascade sur les autres.

## Zone A — Produit (Layer 4)

**ADR-SA-xxx, choix techniques, implémentations**

Peut changer librement tant que les UX Principles (Layer 3) sont respectés.
Un changement de base de données, de framework, ou d'API n'affecte pas CI-registry.

**Signal d'alerte :** Si une décision technique remonte jusqu'à modifier un WR-xxx, une révision du Layer 2 est requise — ce n'est plus une décision technique, c'est une décision de modèle.

## Zone B — Design (UX-xxx, IP-xxx)

Peut changer si une meilleure implémentation d'un Requirement existant est trouvée.
L'Anchor peut être remplacée par une autre Interaction Pattern si cette alternative satisfait WR-01, WR-02 et WR-04.

**Règle :** Un changement de design qui nécessite de modifier un WR pour être justifié n'est pas un changement de design — c'est une révision du modèle.

## Zone C — Traduction (CN-registry, WR-xxx)

Peut être étendu (nouveaux CN, nouveaux WR) sans modifier le Layer 2.
Ne peut pas être réduit sans vérifier qu'aucun Invariant n'est désormais non couvert.

## Zone D — Corpus de recherche (F-001 à F-009)

Peut être étendu librement. Chaque nouvel entretien produit des Observations qui alimentent CI-registry via le mécanisme SUPPORTS/CHALLENGES/REFUTES (défini dans MKO-000).

---

---

# V. Règles de publication

Certains documents peuvent être publiés en dehors de MedLink (articles scientifiques, conférences). D'autres sont internes au projet.

| Document | Publication externe | Conditions |
|---|---|---|
| MMP-000 | ✅ Libre | Tout public — document fondateur |
| CCF-01 | ✅ Scientifique | Corpus ≥ 15 profils, peer review |
| CCF-02 | ✅ Scientifique | Validé après CCF-01 accepté |
| CI-registry | ✅ Scientifique | En supplément de CCF-01 |
| MKO-000 | ✅ Scientifique | Communautés HCI, ingénierie des connaissances |
| MKG-000 | ✅ Scientifique | Communautés governance, KM |
| CCP-registry | ⚠️ Partiel | Sans données de corpus identifiables |
| CN-registry | ✅ Scientifique | En supplément de CCF-01 |
| WR-xxx | ✅ Technique | Conférences IHM, CHI |
| UX-xxx, IP-xxx | ⚠️ Interne | Contient décisions produit spécifiques |
| ADR-SA-xxx | ❌ Interne | Détails techniques propriétaires |
| F-001 à F-009 | ⚠️ Anonymisé | Données personnelles des praticiens |

---

---

# VI. Cycle de vie d'un document

```
IDÉE
  │
  ▼
Draft ──────────────────────────────────────────────► Rejected
  │
  │  [peer review interne · cohérence avec MKO-000]
  │
  ▼
In Review
  │
  │  [validation explicite]
  │
  ▼
Accepted ──────────► (évolutions mineures) ──────────► Accepted vN+1
  │
  │  [décision de dépréciation]
  │
  ▼
Deprecated ��─────────────────────────────────────────► Archived
```

**Règle de promotion Draft → Accepted :**

Un document ne peut être promu `Accepted` que si :
1. Il est cohérent avec MKO-000 (types, relations, contraintes)
2. Il ne contredit aucun document normatif de niveau supérieur
3. Il a fait l'objet d'une revue explicite documentée

**Règle de rétrogradation :**

Un document `Accepted` est rétrogradé `Under_Review` si un document normatif supérieur évolue de façon incompatible. Il ne peut pas rester `Accepted` dans un état incohérent.

---

---

# VII. Documents prioritaires à créer

| Document | Priorité | Dépend de | Bloque |
|---|---|---|---|
| MKO-000 v0.2 | **Bloquant** | MKO-ISS-001 résolu | Tout |
| MKG-000 | Haute | MKO-000 v0.2 | Governance Layer 0 |
| CN-registry v1.0 | Haute | CI-registry | WR-xxx autonome |
| WR-registry autonome | Haute | CN-registry | UX-xxx |
| UX-xxx registry | Moyenne | WR-registry | IP-xxx |
| IP-xxx registry | Moyenne | UX-xxx | Product Capabilities formelles |

---

*Version 1.0 — 2026-07-30*
*Ce document est mis à jour à chaque ajout ou retrait d'un document du corpus.*
