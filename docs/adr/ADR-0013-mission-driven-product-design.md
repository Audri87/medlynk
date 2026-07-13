# ADR-0013 — Mission-Driven Product Design

**Statut** : Accepted
**Date** : 2026-07-09

---

## Contexte

MedLink est construit selon le principe **Reality-Driven Domain Design** (FOUNDATIONS.md, Principe 9) :

* les observations terrain révèlent les invariants ;
* les invariants structurent le Domain Model ;
* le Domain Model guide l'architecture.

Cependant, une question restait ouverte :

> Comment décider ce qui entre dans le MVP sans retomber dans une logique de fonctionnalités ?

L'expérience montre que raisonner directement en fonctionnalités conduit progressivement à une "feature factory", où les décisions sont dictées par des écrans ou des demandes ponctuelles plutôt que par la valeur apportée aux Practitioners.

Il est nécessaire d'introduire un niveau stratégique entre le Domain Model et l'implémentation.

---

## Précision terminologique

Le terme "Mission" est utilisé dans deux sens distincts dans MedLink :

* **La mission de MedLink** (MISSION.md) : l'objectif fondateur du produit — "réduire l'effort cognitif nécessaire pour comprendre une situation clinique."

* **Une Mission** (ce document) : une unité de valeur durable que MedLink apporte à un Practitioner. Exemples : "Permettre au Practitioner de reconstruire rapidement son contexte clinique" ou "Permettre au Practitioner de solliciter un autre Practitioner."

Ces deux sens sont complémentaires : les Missions (unités de valeur) servent la mission de MedLink (objectif fondateur).

---

## Décision

MedLink adopte une approche **Mission-Driven Product Design**.

Une **Mission** représente une valeur durable que MedLink apporte à un Practitioner dans l'exercice de son travail.

Une Mission :

* est indépendante de toute technologie ;
* est indépendante de l'interface utilisateur ;
* est indépendante des fonctionnalités utilisées pour la réaliser ;
* est toujours justifiée par une observation terrain ou un invariant métier.

Une Mission ne remplace pas le Domain Model.

Une Mission n'appartient pas au modèle métier.

Elle constitue un niveau de gouvernance produit permettant de décider quelles capacités doivent être livrées au Practitioner, et dans quel ordre.

---

## Workflow

Le développement de MedLink suit désormais la chaîne suivante :

```
Observation terrain
        │
        ▼
Invariants métier
        │
        ▼
Domain Model  ←  l'architecture de domaine est dérivée ici
        │
        ▼
Missions  ←  décident quelles parties de l'architecture implémenter en priorité
        │
        ▼
Architecture (implémentation)
        │
        ▼
Fonctionnalités
        │
        ▼
Code
```

**Important :** les Missions ne déterminent pas l'architecture de domaine. L'architecture de domaine est entièrement dérivée du Domain Model. Les Missions déterminent uniquement l'ordre et la priorité d'implémentation — elles répondent à "que livrons-nous d'abord ?" et non à "comment le domaine est-il structuré ?"

---

## Principes

Une Mission :

* décrit **pourquoi** MedLink apporte de la valeur ;
* ne décrit jamais **comment** cette valeur est implémentée ;
* peut mobiliser plusieurs Platforms ;
* peut mobiliser plusieurs Bounded Contexts ;
* peut mobiliser plusieurs Capabilities techniques (ADR-0006).

Une fonctionnalité n'existe jamais pour elle-même.

Elle existe uniquement pour servir une Mission.

---

## Exemples

**Mission :**

> Permettre au Practitioner de reconstruire rapidement son contexte clinique.

Ancrage : CCF O-002, MP-001 ("Où en étais-je ?")

Implémentations possibles :

* Workspace
* Timeline
* Synthèse IA
* Recherche
* Vue chronologique

---

**Mission :**

> Permettre à un Practitioner de solliciter un autre Practitioner dans le cadre d'une prise en charge.

Ancrage : CCF (cas gynécologue — connaissance clinique distribuée), H-COL-001 v2

Implémentations possibles :

* Practitioner Interaction
* Advice Request
* Clinical Activity Request
* Notifications

---

## Conséquences

Le MVP est désormais défini par les Missions qu'il doit accomplir, et non par une liste de fonctionnalités.

Toute nouvelle fonctionnalité devra répondre aux deux questions suivantes :

1. Quelle Mission sert-elle ?
2. Quelle observation terrain ou quel invariant justifie cette Mission ?

Si aucune réponse satisfaisante n'existe, la fonctionnalité ne fait pas partie de MedLink.

---

## Relation avec les ADR existants

Ce principe complète :

* ADR-0002 — Business Platforms (les Missions peuvent mobiliser plusieurs Platforms)
* ADR-0006 — Platform Capabilities (les Capabilities techniques ADR-0006 implémentent les Missions)
* ADR-0008 — Clinical Work and Clinical Knowledge (les Missions servent les Practitioners dans leur travail clinique)
* ADR-0012 — Clinical Platform / Patient Engagement (les Missions sont définies par Platform)

Il ne modifie aucun modèle métier.

Il introduit uniquement une règle de gouvernance produit.

---

## Références

* FOUNDATIONS.md — Principe 9 (Reality-Driven Domain Design)
* MISSION.md — mission fondatrice de MedLink
* ADR-0006 — Capability as First-Class Architectural Concept
* CCF-001 — Clinical Cognition Framework
* MP-001 — MedLink Design Principle
