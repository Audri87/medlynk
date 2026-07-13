# ADR-0012 — Separation of Clinical Platform and Patient Engagement Platform

**Statut** : Accepted
**Date** : 2026-07-09
**Précédent** : ADR-0002 — Business Platforms

---

## Contexte

Les travaux du Clinical Cognition Framework, les interviews terrain et l'analyse des invariants métier montrent que les praticiens et les patients n'interagissent pas avec la connaissance clinique selon les mêmes règles.

Ils manipulent les mêmes faits, mais pas le même modèle.

Les invariants qui gouvernent l'accès du praticien à la connaissance clinique (responsabilité clinique, autorisation, continuité des soins) sont orthogonaux aux invariants qui gouvernent l'accès du patient à ses propres données (droits légaux, consentement, délégation d'accès).

Placer ces deux ensembles d'invariants dans le même Bounded Context produirait un modèle incohérent et couplé.

---

## Décision

MedLink est organisé autour de plusieurs plateformes métier (ADR-0002).

Deux plateformes sont identifiées et formalisées à ce stade :

* **Clinical Platform**
* **Patient Engagement Platform**

Chaque plateforme constitue un Bounded Context indépendant.

---

## Clinical Platform

**Mission :**

> Soutenir le travail clinique des professionnels de santé.

**Responsabilités :**

* Clinical Activities
* Clinical Contributions
* Context Reconstruction
* Professional Workspaces
* Raisonnement clinique
* Clinical Authorization

---

## Patient Engagement Platform

**Mission :**

> Permettre au patient d'exercer ses droits, comprendre son parcours de soins et participer à sa prise en charge.

**Responsabilités :**

* Patient Workspace
* Consent Management
* Personne de confiance
* Documents déclaratifs du patient
* Données déclaratives
* Droits d'accès du patient

---

## Invariants

Les deux plateformes possèdent des invariants différents.

**Clinical Platform protège :**

* la responsabilité clinique
* l'intégrité de la connaissance clinique
* la continuité des soins

**Patient Engagement Platform protège :**

* I-PE-001 — Un patient peut toujours accéder à l'intégralité de ses propres données, y compris les contributions restreintes pour les praticiens
* I-PE-002 — Un patient peut restreindre la visibilité d'une Clinical Contribution. Il ne peut jamais la supprimer
* I-PE-003 — Les données soumises par un patient ne peuvent pas entrer dans le Care Record sans adoption explicite d'un praticien
* I-PE-004 — Une restriction posée par un patient prend effet immédiatement et prospectivement. Elle ne peut pas être rétroactive sur les accès passés
* I-PE-005 — Un patient peut désigner une personne de confiance avec des droits d'accès dérivés, révocables à tout moment

---

## Collaboration

Les plateformes collaborent sans partager leur modèle interne.

Le Clinical Platform publie une connaissance clinique stable via le `event.bus` (Symfony Messenger), sous forme de Domain Events versionnés :

```
ContributionAdded
LabResultReceived
PrescriptionSigned
DocumentAttached
```

Le Patient Engagement Platform consomme ces events à travers une **Anti-Corruption Layer** qui :
1. Traduit les concepts cliniques en concepts patient (`Clinical Contribution` → `Mon résultat`, `Ma prescription`)
2. Applique les droits légaux du patient (I-PE-001)
3. Applique les restrictions posées par le patient (I-PE-002)
4. Construit ses propres read models indépendants (`patient_timeline`, distinct de la `practitioner_timeline`)

Ce pattern est **Published Language + ACL**. Ce n'est pas un Shared Kernel.

---

## Ownership

Chaque plateforme est propriétaire de ses invariants.

Aucune plateforme ne peut imposer son modèle interne à une autre.

Le Care Record reste une source de vérité unique dans le Clinical Platform. Le Patient Engagement Platform en possède une vue autorisée, jamais une copie.

---

## Principes

### P-001

La connaissance clinique appartient au Clinical Platform.

### P-002

Les droits du patient appartiennent au Patient Engagement Platform.

### P-003

Les plateformes collaborent uniquement via des contrats publiés et stables (Published Language sur event.bus).

### P-004

Les Workspaces appartiennent à leur plateforme respective.

---

## Conséquences

Le MVP est limité au Clinical Platform.

Le Patient Engagement Platform est reconnu comme une évolution prévue de l'architecture, sans impact sur le périmètre fonctionnel du MVP.

Cette séparation garantit l'évolutivité de MedLink et permet l'ajout futur d'autres plateformes (Learning, Conference, Community, Research, AI, Marketplace) sans remettre en cause le modèle clinique central.

---

## Références

* ADR-0002 — Business Platforms
* ADR-0008 — Clinical Work and Clinical Knowledge
* ADR-0010 — Care Record
* WSP-001 — Workspace
* CCF-001 — Clinical Cognition Framework
