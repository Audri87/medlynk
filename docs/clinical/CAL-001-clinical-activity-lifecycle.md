# CAL-001 — Clinical Activity Lifecycle

**Statut** : Accepted
**Date** : 2026-07-13
**Version** : 1.1 — synchronized with Domain Engineering Baseline V1

---

## Contexte

Les observations terrain menées auprès de médecins, psychologues, sages-femmes, infirmières, kinésithérapeutes, coordinatrices cliniques et échographistes montrent que leur travail ne consiste pas à manipuler un dossier médical mais à conduire une activité clinique.

Cette activité suit un cycle relativement stable, indépendamment de la profession.

Les tâches diffèrent.

Le mécanisme reste le même.

Le Clinical Activity Lifecycle formalise ce mécanisme afin de servir de référence commune au Domain Model, aux Workspaces et aux scénarios Domain Engineering.

---

## Principe

> **Une Clinical Activity est un épisode borné de travail clinique professionnel permettant à un Practitioner de comprendre une situation, d'agir sous sa Clinical Responsibility et de produire une Clinical Contribution.**

Le logiciel accompagne ce cycle.

Il ne le remplace jamais.

---

## Les phases du cycle

### Phase 1 — Orientation

Le Practitioner s'oriente dans sa journée.

Exemples :

* consulter son planning ;
* identifier ses patients ;
* prendre connaissance des nouvelles informations ;
* préparer son environnement de travail.

Objectif :

> Identifier la prochaine Clinical Activity.

---

### Phase 2 — Context Reconstruction

Le Practitioner reconstruit rapidement la situation clinique.

Il cherche notamment :

* où en était la prise en charge ;
* ce qui a changé ;
* les éléments importants ;
* les points d'attention.

Cette reconstruction s'appuie sur les Clinical Contributions disponibles dans le Care Record.

Elle peut être très courte ou très approfondie selon le contexte.

Objectif :

> Construire une représentation mentale suffisante de la situation.

---

### Phase 3 — Clinical Interaction

Le Practitioner interagit avec le patient.

Selon la profession :

* entretien ;
* interrogatoire ;
* examen clinique ;
* séance thérapeutique ;
* visite à domicile ;
* réalisation d'un acte.

Objectif :

> Collecter les informations nécessaires et agir.

---

### Phase 4 — Clinical Reasoning

Le Practitioner construit ou ajuste son raisonnement.

Il :

* interprète ;
* compare ;
* formule des hypothèses ;
* vérifie ses hypothèses ;
* décide.

Cette phase appartient exclusivement au Practitioner.

Le logiciel ne prend jamais de décision clinique (DE-P-001, DE-P-002).

---

### Phase 5 — Formalization

Le Practitioner formalise le résultat de son travail dans un Clinical Draft.

Le Clinical Draft est :

* mutable ;
* privé au Practitioner responsable ;
* sans valeur clinique ou médico-légale avant validation ;
* susceptible d'être abandonné.

Exemples de contenu :

* note clinique ;
* ordonnance ;
* compte rendu ;
* courrier ;
* recommandations.

Objectif :

> Produire une trace fidèle de l'activité réalisée.

---

### Phase 6 — Contribution

Le Practitioner valide explicitement le Clinical Draft.

Cet acte de validation est une décision du Practitioner — il n'est jamais automatique.

Le Clinical Draft est archivé.

Une Clinical Contribution immutable est créée.

La Clinical Contribution enrichit la Clinical Knowledge.

Elle devient disponible selon les règles de visibilité et d'autorisation (G1).

---

### Phase 7 — Closure

Le Practitioner décide de clôturer la Clinical Activity.

La fermeture est toujours un acte explicite du Practitioner.

Elle n'est jamais automatique (Human Judgment First).

Avant de clôturer, le Practitioner s'assure que :

* les Clinical Contributions nécessaires ont été produites et publiées ;
* la Clinical Continuity est assurée si la prise en charge doit se poursuivre.

La Clinical Continuity peut nécessiter :

* la publication des Clinical Contributions pertinentes ;
* l'initiation d'un Clinical Handover si la Clinical Responsibility doit être transférée.

---

## Représentation

```text
Orientation
      │
      ▼
Context Reconstruction
      │
      ▼
Clinical Interaction
      │
      ▼
Clinical Reasoning          ← appartient exclusivement au Practitioner
      │
      ▼
Formalization               ← Clinical Draft (mutable, privé)
      │
      ▼  ← acte explicite du Practitioner
Contribution                ← Clinical Contribution (immuable)
      │
      ▼  ← décision du Practitioner
Closure                     ← Clinical Continuity assurée si nécessaire
```

---

## Invariants

### CAL-I-001

Toute Clinical Activity possède un Practitioner responsable identifié.

### CAL-I-002

Le jugement clinique appartient toujours au Practitioner.

Le logiciel n'intervient jamais dans le raisonnement clinique.

### CAL-I-003

Une Clinical Contribution ne peut exister qu'à l'issue d'une Clinical Activity et d'un acte de validation explicite du Practitioner.

### CAL-I-004

Le logiciel peut assister chaque phase.

Il ne peut remplacer aucune décision clinique.

### CAL-I-005

Chaque phase peut être interrompue puis reprise.

Le Workspace doit permettre cette reprise.

La représentation Domain d'une interruption reste un Hotspot ouvert (H-INT-001).

### CAL-I-006

Toutes les professions ne réalisent pas exactement les mêmes actions.

Elles traversent néanmoins les mêmes grandes phases du cycle.

### CAL-I-007

La fermeture d'une Clinical Activity est toujours une décision explicite du Practitioner.

Aucune Policy système ne peut fermer une Clinical Activity automatiquement.

---

## Relation avec le Workspace

Le Workspace accompagne le Lifecycle.

Il fournit, pour chaque phase :

* les informations pertinentes ;
* les actions disponibles ;
* les signaux d'attention.

Il ne modifie jamais le Lifecycle.

---

## Relation avec le Domain

Le Lifecycle décrit la dynamique d'utilisation des concepts suivants :

* Clinical Activity ;
* Clinical Draft ;
* Clinical Contribution ;
* Clinical Knowledge ;
* Care Record ;
* Clinical Handover (si transfert de Clinical Responsibility requis à la Closure).

---

## Relation avec le Clinical Cognition Framework

Le Clinical Cognition Framework explique les mécanismes cognitifs.

Le Clinical Activity Lifecycle décrit comment ces mécanismes s'inscrivent dans une activité clinique complète.

Le CCF explique **comment pense** le Practitioner.

Le CAL décrit **comment se déroule** son travail.

Les deux sont complémentaires.

| Phase CAL | Étape CCF |
|---|---|
| Orientation | Préparer |
| Context Reconstruction | Reconstruire rapidement le contexte |
| Clinical Interaction | Comprendre la situation actuelle |
| Clinical Reasoning | Prendre une décision |
| Formalization | Produire une nouvelle connaissance clinique |
| Contribution | Maintenir la continuité (O-007) |
| Closure | Clôturer la charge mentale |

La Phase 6 (Contribution) correspond à O-007 : la validation et la publication d'une Clinical Contribution est le mécanisme primaire par lequel le Practitioner assure la continuité de la prise en charge.

---

## Conséquences architecturales

Le Clinical Activity Lifecycle est la référence pour :

* les Workspaces ;
* les Application Services ;
* les scénarios Domain Engineering ;
* les scénarios du MVP.

Toute nouvelle fonctionnalité doit pouvoir être rattachée à une phase du Lifecycle.

Dans le cas contraire, sa pertinence devra être remise en question.

---

## Références

* CCF-001 — Clinical Cognition Framework
* UL-001 — Ubiquitous Language Charter
* ADR-0007 — Clinical Contribution Relationships
* ADR-0008 — Clinical Work and Clinical Knowledge
* WSP-001 — Workspace
* DE-BASELINE-V1 — Domain Engineering Baseline (ES-001 : Domain Events)
* DE-P-001 — Human Reasoning Is Outside the Domain
* DE-P-002 — Clinical Reasoning Belongs to the Practitioner
