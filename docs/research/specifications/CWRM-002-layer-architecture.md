# CWRM-002 — Layer Architecture and Transformation Model

**Status :** Accepted — Architecture Freeze v1.0
**Date :** 2026-07-31
**Type :** Foundational Specification
**Depends on :** CWRM-000 (Scope Guard), CWRM-001 (Research Method)
**Supersedes :** —

---

## 1. Purpose

Ce document définit l'architecture complète de transformation du CWRM.

Il spécifie :

- les cinq couches du framework et leur responsabilité respective ;
- la chaîne de transformation complète de la preuve à la fonctionnalité ;
- la frontière entre le CWRM et MedLink ;
- le modèle de traçabilité des exigences.

---

## 2. Les cinq couches

Le CWRM organise ses concepts en cinq couches. Chaque couche répond à une seule question.

---

### Layer 1 — Evidence

**Question : Qu'avons-nous observé ?**

Cette couche contient les données brutes et les premières extractions.

Elle ne contient aucune interprétation.

**Concepts :**
- Corpus (entretiens bruts)
- Verbatims
- ACT — Reported Clinical Actions
- Métadonnées (profil, date, contexte)
- Niveaux de preuve (E1, E2, E3)

**Entrée :** Entretiens avec des professionnels de santé

**Sortie :** Observations (OBS) — premières régularités empiriques

---

### Layer 2 — Knowledge

**Question : Qu'avons-nous compris ?**

Cette couche transforme les observations en connaissances stables.

Elle contient les résultats de l'analyse, pas les données brutes.

**Concepts :**
- OBS — Observations empiriques
- RQ — Research Questions
- INV — Invariants de conception

**Entrée :** ACT et observations de Layer 1

**Sortie :** Invariants — connaissances suffisamment corroborées pour gouverner une décision

---

### Layer 3 — Reasoning

**Question : Que devons-nous en déduire pour la conception ?**

Cette couche transforme les invariants en principes de conception.

Elle documente le raisonnement, pas les données ni les décisions.

**Concepts :**
- Design Reasoning (raisonnement explicite INV → Requirement)
- Design Principles

**Entrée :** Invariants de Layer 2

**Sortie :** Exigences de conception (Requirements)

---

### Layer 4 — Product

**Question : Que doit faire le produit ?**

Cette couche traduit les exigences en décisions et fonctionnalités concrètes.

Elle appartient à la fois au CWRM (Requirements, UX Principles) et à MedLink (ADR, Features).

**Concepts :**
- Requirements — Exigences de conception stables
- UX Principles — Principes d'interaction dérivés
- ADR — Architecture Decision Records
- Features — Fonctionnalités implémentées

**Entrée :** Exigences de Layer 3

**Sortie :** Backlog produit MedLink

---

### Layer 5 — System

**Question : Comment est-il construit ?**

Cette couche n'appartient pas au CWRM.

Elle relève entièrement de MedLink.

**Concepts :**
- Architecture technique
- Modules
- APIs
- Base de données
- Interfaces

**Frontière :** Le CWRM s'arrête à la Feature. L'implémentation commence ici.

---

## 3. La chaîne de transformation complète

```
Entretien (verbatim brut)
        │
        ▼  [Extraction — Méthode d'acquisition]
ACT — Reported Clinical Action
        │
        ▼  [Analyse — Méthode d'analyse]
OBS — Observation empirique
        │
        ▼
RQ — Research Question
        │
        ▼
INV — Invariant de conception
        │
        ▼  [Design Reasoning — Méthode de traduction]
Requirement
        │
        ├──────────────────────────────┐
        ▼                              ▼
ADR — Architecture Decision     UX Principle
        │                              │
        └──────────────┬───────────────┘
                       ▼
                   Feature
                       │
                       ▼  [Hors CWRM]
              Implémentation MedLink
```

---

## 4. Modèle de traçabilité

Chaque concept du CWRM peut être relié à ses origines et à ses descendants.

**Règle de traçabilité :** Une Feature ne peut pas exister sans un Requirement. Un Requirement ne peut pas exister sans un Design Reasoning. Un Design Reasoning ne peut pas exister sans un Invariant.

**Exemple complet :**

```
OBS-014  Les praticiens consultent systématiquement la dernière
         séance avant de voir un patient en suivi.
         [E3 — F-001, F-004, F-007, F-008]
         │
         ▼
INV-003  Les praticiens reconstruisent systématiquement le contexte
         clinique avant d'agir. [Level B — 6 professions convergentes]
         │
         ▼  [Design Reasoning DR-007]
REQ-001  Le système doit fournir un accès immédiat au contexte
         clinique pertinent sans navigation entre écrans.
         │
         ├── Feature A — Résumé patient
         ├── Feature B — Timeline
         └── Feature C — Ancrages de séance
```

**La même exigence peut justifier plusieurs fonctionnalités.**

**La même fonctionnalité ne peut justifier qu'une seule exigence primaire.**

---

## 5. Questions directrices par couche

| Couche | Question | Sortie |
|---|---|---|
| Evidence | Qu'avons-nous observé ? | Observations |
| Knowledge | Qu'avons-nous compris ? | Invariants |
| Reasoning | Que devons-nous concevoir ? | Requirements |
| Product | Que doit faire MedLink ? | Features |
| System | Comment allons-nous le construire ? | Implémentation |

---

## 6. Frontière CWRM / MedLink

Le CWRM s'arrête à la définition des Requirements et des Features.

Il ne prescrit pas :

- comment les fonctionnalités sont architecturées techniquement ;
- quel framework est utilisé ;
- comment la base de données est structurée.

Ces décisions appartiennent à MedLink et sont documentées dans les ADRs de MedLink, pas dans les DR du CWRM.

---

## 7. Architecture Freeze v1.0

L'architecture conceptuelle du CWRM est gelée à cette version.

Les concepts fondamentaux sont :

**Layer 1 — Evidence :** Verbatim, ACT, niveaux E1/E2/E3, niveaux A/B/C/D

**Layer 2 — Knowledge :** OBS, RQ, INV

**Layer 3 — Reasoning :** Design Reasoning, Design Principles

**Layer 4 — Product :** Requirements, UX Principles, ADR, Features

Toute nouvelle idée doit répondre positivement à au moins l'une des quatre questions de gouvernance définies dans CWRM-000 (Section 15 — Decision Criteria).

Si la réponse est non, elle est documentée dans Future Work et n'intègre pas le cœur du CWRM v1.0.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-31 | v1.0 | Création — Architecture Freeze CWRM v1.0 |
