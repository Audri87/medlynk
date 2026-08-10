# MedLink Product Pipeline v1.1

| Field | Value |
|---|---|
| Version | 1.1 |
| Status | **Frozen** — détail opérationnel des couches Discovery/Product/Engineering de [GOV-000](../process/GOV-000-medlink-governance-v1.0.md) |
| Date | 2026-08-04 |
| Nature | Foundational framework — how reality becomes product |
| Governed by | [Product Constitution v1.0](PRODUCT-CONSTITUTION-v1.0.md) · [GOV-000 — MedLink Governance v1.0](../process/GOV-000-medlink-governance-v1.0.md) |

> Ce document reste la référence pour la chaîne fine d'artefacts (ACT→OBS→PAT→PP→DR→Q→WS). GOV-000 en
> est la couche macro : il ajoute Reality, Design et Validation comme couches explicites, fige les
> Gates de passage, et fige les 5 symboles (✓ ≈ ? → ⚠) au niveau projet. Les symboles ci-dessous
> (✓, ≈, ?) restent valides — ils sont un sous-ensemble de la convention GOV-000, pas une convention
> concurrente.

> **Règle d'or :** Les observations décrivent le monde. Les Product Rules décrivent MedLink.

---

## La chaîne de valeur complète

```
Reality
    │  (entretiens, observations terrain)
    ▼
ACT  — Reported Clinical Action
    │  (unité atomique de travail clinique observé)
    ▼
Observation ✓
    │  (directement issu du corpus verbatim)
    ▼
Pattern ≈
    │  (fortement suggéré — convergent mais non universel)
    │
    │  ══════════════════════════════════
    │        PRODUCT DECISION
    │  ══════════════════════════════════
    │  Au-dessus : ce que le terrain apprend.
    │  En dessous : ce que nous décidons de construire.
    │
    ▼
Product Principle
    │  (principe de conception ancré dans Observations ou Patterns)
    │  (peut avoir des exceptions — exceptions = Display Rules)
    ▼
Display Rule
    │  (adaptation spécialisée d'un Principle par profil clinique)
    ▼
Product Question
    │  (question du praticien à laquelle le Workspace répond)
    ▼
Workspace Blueprint
    │  (environnement spécifié pour répondre à la question)
    ▼
Prototype
    │
    ▼
User Test
    │
    ▼
Iteration
```

---

## Les trois niveaux

### Niveau 1 — Discovery (CWRM)

Ce que le terrain apprend. Empirique. Contraint par le corpus.

| Artefact | Description | Symbole | Produit par |
|---|---|---|---|
| ACT | Action clinique rapportée — unité atomique | — | CWRM |
| Observation | Directement issu du corpus verbatim | ✓ | CWRM |
| Pattern | Fortement suggéré — convergent mais non universel | ≈ | CWRM |
| Hypothèse produit | Décision à valider — non encore observée | ? | CWRM → Product |

Le CWRM s'arrête aux Patterns et aux Hypothèses.
Il ne produit pas de Product Principles, pas de Workspaces, pas de code.

---

### Niveau 2 — Product (QDD)

Ce que nous décidons de construire. Normatif. Contraint par les Observations et Patterns.

| Artefact | Description | Produit par |
|---|---|---|
| Product Principle | Principe de conception ancré dans Observations ou Patterns | Product Design |
| Display Rule | Adaptation spécialisée d'un Principle par profil clinique | Product Design |
| Product Question | Question du praticien à laquelle le Workspace répond | Product Design |
| Workspace Blueprint | Spécification complète du Workspace | Product Design |
| Prototype | Implémentation testable | Product Design |

Un Product Principle dérive d'un Pattern (≈) ou d'une Observation (✓) — jamais d'une opinion.
Un Product Principle peut avoir des exceptions — ces exceptions sont les Display Rules.
Un Product Principle invalidé par un test praticien est révisé — jamais contourné.

---

### Niveau 3 — Engineering

L'implémentation. Contraint par les Product Rules, les Display Rules et les Workspace Blueprints.

| Artefact | Description | Produit par |
|---|---|---|
| Read Model | Requête CQRS qui alimente le Workspace | Engineering |
| API Endpoint | Interface exposant les données du Workspace | Engineering |
| UI Component | Élément d'interface conforme aux Display Rules | Engineering |
| Domain Event | Événement déclenché par une action | Engineering |

---

## La frontière Product Decision

La ligne de séparation CWRM / Product Design est la décision la plus importante du pipeline.

**Au-dessus :** le CWRM décrit ce que les praticiens font. C'est la réalité.
**En dessous :** le Product Design décide ce que MedLink fera. C'est une hypothèse.

La confusion entre les deux a un coût : une opinion devient une règle, une règle devient du code,
et le terrain ne peut plus la corriger.

**Règle de franchise :** aucune Product Rule sans ancre Observation ou Pattern.
Un énoncé sans ancre empirique est un principe de design, pas une Product Rule.

---

## Les neuf artefacts officiels

```
Discovery (CWRM)
├── ACT Catalog         → docs/research/act/
├─��� Observation Catalog → (extrait des Blueprints)
└── Pattern Catalog     → (extrait des Blueprints)

Product (QDD)
├── Product Rulebook    → PRODUCT-RULEBOOK.md
├── Display Rulebook    → DISPLAY-RULEBOOK.md
├── Product Questions   → PRODUCT-QUESTIONS.md
└── Workspace Blueprints → workspaces/

Delivery
├── Prototype           → workspaces/WS-XXX-prototype-vX.X.html
└── Validation Report   → (post-test praticien)
```

Ces neuf artefacts sont suffisants. Tout autre document sert ces artefacts ou est superflu.

---

## Nomenclature

| Préfixe | Type | Exemple |
|---|---|---|
| `ACT-FXXX-NNN` | Reported Clinical Action | ACT-F009-001 |
| `OBS-X-NNN` | Observation | OBS-M-001 |
| `PAT-X-NNN` | Pattern | PAT-M-001 |
| `HYP-X-NNN` | Product Hypothesis | HYP-P-001 |
| `PP-NNN` | Product Principle | PP-001 |
| `DR-NNN` | Display Rule | DR-001 |
| `Q-NNN` | Product Question | Q-001 |
| `WS-NNN` | Workspace Blueprint | WS-001 |

---

## Backlog

| Sprint | Workspace | Product Question | Product Principles |
|---|---|---|---|
| Sprint 0 | WS-001 — Morning Brief | Puis-je commencer sereinement ma journée ? | PP-001 à PP-004 |
| Sprint 1 | WS-002 — Patient Context | Pourquoi ce patient est-il devant moi ? | PP-005, PP-006, PP-008 |
| Sprint 2 | WS-003 — Consultation | Puis-je consacrer toute mon attention au patient — et clore proprement quand c'est terminé ? | PP-009 à PP-015 |

> Table corrigée le 2026-08-04 — l'ancienne version assignait PP-009/010/011 à trois Workspaces
> distincts (WS-003, WS-006, WS-007) qui ne correspondaient plus à l'usage réel. Le registre des
> identifiants gelés vit désormais dans [PRODUCT-PRINCIPLES.md](PRODUCT-PRINCIPLES.md). Prochain
> identifiant libre : PP-016.

Les Product Questions expriment le besoin utilisateur.
Les Product Rules expriment la philosophie de conception.

---

## Format d'une Product Rule

```
PR-NNN
Source:     [Invariant INV-NNN référencé]
Rule:       [sujet] SHALL / SHALL NOT [comportement]
Scope:      [UX layout · Read Model · API · Notification · autre]
Compliance: [comment vérifier la conformité]
```

Chaque règle est testable à au moins un niveau. Un designer ou un développeur peut être conforme ou non-conforme — sans ambiguïté.

---

## L'actif stratégique

Le Product Rulebook est l'actif le plus durable de MedLink.

- Un designer peut créer une nouvelle interface en respectant les règles.
- Un développeur peut réécrire le frontend sans casser les principes.
- Une IA peut proposer des variantes d'écrans conformes.
- Un nouveau membre de l'équipe comprend la philosophie du produit sans relire l'historique.

Les règles sont la propriété intellectuelle du produit — pas le code, pas les maquettes.
