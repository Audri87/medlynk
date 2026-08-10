# MedLink Product Architecture v1.0

| Field | Value |
|---|---|
| Version | 1.0 |
| Status | **Frozen** |
| Date | 2026-08-04 |
| Nature | Foundational — how MedLink is built |
| Governed by | [Product Constitution v1.0](PRODUCT-CONSTITUTION-v1.0.md) |

---

## Les quatre couches

### Layer 0 — Reality

Le travail réel. Notre seule source de vérité.

```
Praticiens
    │
Patients
    │
Organisation
    │
Contexte clinique
```

Rien dans le produit ne peut contredire ce que ce layer révèle.

---

### Layer 1 — Discovery Engine (CWRM)

Transformer la réalité en connaissances structurées.

```
ACT
    ↓
Observation
    ↓
Invariant
    ↓
Product Rule
```

**Le CWRM s'arrête aux Product Rules.**

Il ne produit pas de wireframes, pas de code, pas de spécifications techniques.
Il produit les règles qui contraignent tout le reste.

---

### Layer 2 — Product Engine (QDD)

Transformer les Patterns et Observations en produit.

```
Product Rule
    ↓
Display Rule          ← adaptation spécialisée par profil clinique
    ↓
Product Question
    ↓
Workspace Blueprint
    ↓
Prototype
```

**Le Product Design commence aux Product Questions.**

Chaque décision de design est traçable à une Product Rule.
Chaque Product Rule est traçable à un Pattern ou une Observation.
Chaque Pattern est traçable à des ACTs terrain.

> **Règle d'or :** Les observations décrivent le monde. Les Product Rules décrivent MedLink.

---

### Layer 3 — Engineering

Transformer le produit en logiciel.

```
DDD
    ↓
CQRS
    ↓
Symfony
    ↓
React / UI
    ↓
Infrastructure
```

**Règle de causalité :**

L'Engineering est contraint par les Workspaces et les Product Rules.
L'Engineering ne peut pas modifier une Product Rule.
Si l'implémentation révèle qu'un Invariant source était faux,
la règle est révisée avec justification empirique (CWRM-SCI-000, Rule 8) —
jamais contournée en silence.

---

## Les quatre artefacts de gouvernance

Ces quatre documents gouvernent tout le reste.

### 📘 1. Product Principles

Les principes dérivés du terrain. La "physique" de MedLink.

```
PP-001  Signal precedes Horizon
PP-002  Preparation follows Uncertainty
PP-003  One Morning Entry Point
PP-004  Obligations shall not dominate clinical preparation
PP-005  Surface the relevant recent interaction first
PP-006  Historical depth follows context gap
PP-008  Collapse historical detail by default
```

→ [`PRODUCT-PRINCIPLES.md`](PRODUCT-PRINCIPLES.md)

**Règle :** aucun Product Principle sans Observation ou Pattern source. Un énoncé sans ancre corpus est une opinion, pas un Principle.
Un Principle peut avoir des exceptions — ces exceptions sont les Display Rules.

---

### 📒 2. Display Rulebook

Les adaptations spécialisées par profil clinique. Même règle, présentations différentes.

```
DR-001  Suivi longitudinal   — dernière séance en premier
DR-002  Suivi grossesse      — terme + stade en premier
DR-003  Acte sur demande     — ordonnance en premier (exception PR-008)
DR-004  Coordination         — statut intervenants en premier
```

→ [`DISPLAY-RULEBOOK.md`](DISPLAY-RULEBOOK.md)

**Règle :** une Display Rule ne peut pas contredire sa Product Rule source. Elle peut uniquement la spécialiser.

---

### 📙 3. Product Questions

Le backlog du produit.

```
Q-001  Puis-je commencer sereinement ?  →  WS-001 Morning Brief
Q-002  Pourquoi ce patient ?            →  WS-002 Patient Context
Q-003  Que dois-je comprendre ?         →  WS-003 Clinical Summary
...
```

→ [`PRODUCT-QUESTIONS.md`](PRODUCT-QUESTIONS.md)

**Règle :** chaque Question produit un et un seul Workspace Blueprint.

---

### 📗 4. Workspace Blueprints

Chaque Workspace a exactement la même structure :

| Section | Contenu |
|---|---|
| Product Question | La question à laquelle ce Workspace répond |
| Evidence | ✓ Observations / ≈ Patterns / ? Hypothèses |
| Product Principles | Les principes universels qui contraignent ce Workspace |
| Display Rules | Les adaptations par profil clinique |
| Cognitive Transition | Quel état → quel état |
| User Outcome | Ce que le praticien doit pouvoir dire à la sortie |
| Information Architecture | Les blocs et leur contenu |
| Scope Limitations | Ce que ce Blueprint ne couvre pas |
| Non-Goals | Ce que ce Workspace n'est pas |
| Success Metrics | Comment mesurer l'amélioration |
| Open Questions | Ce qui reste à apprendre |
| Evidence Quality Summary | Tableau épistémique complet |

→ [`workspaces/`](workspaces/)

---

## La chaîne de traçabilité complète

```
ACT terrain
    ↓ extraction
Observation ✓ / Pattern ≈
    │
    │  ══════ PRODUCT DECISION ══════
    │
    ↓ décision
Product Principle  ←─── Point de gouvernance
    ↓ adaptation
Display Rule  ←─── Spécialisation par profil clinique
    ↓ design
Product Question
    ↓ specification
Workspace Blueprint
    ↓ implémentation
Read Model (CQRS)
    ↓
UI Component
```

Chaque composant UI est traçable jusqu'à un ACT terrain.
Si la traçabilité est interrompue, la décision est injustifiable.

La ligne Product Decision est infranchissable dans les deux sens :
une opinion de design ne peut pas remonter dans le corpus,
et une observation corpus ne devient pas un Principle sans décision explicite.

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
