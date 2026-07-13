# CPP-001 — Cross-Practitioner Principle

**Statut** : Accepted
**Date** : 2026-07-11
**Remplace** : UPP-001 — Universal Practitioner Principle (archivé)

---

## Principe

Le Core Domain MedLink modélise les concepts dont l'**existence** est partagée entre plusieurs professions de Practitioners.

Il n'exige pas que ces concepts se comportent de manière identique selon les professions.

Les différences professionnelles qualifient le comportement d'un concept avant de justifier la création d'un nouveau concept Domain.

---

## Motivation

Chaque profession de santé apporte :

* son vocabulaire ;
* son cadre légal ;
* ses pratiques cliniques ;
* ses workflows.

Si chaque différence professionnelle devient un concept Domain, le Core Domain s'étend continuellement et finit par devenir un catalogue de professions plutôt qu'un modèle du travail clinique.

À l'inverse, forcer chaque profession dans un modèle identique produirait une abstraction déconnectée de la réalité.

Le Core Domain capture donc les concepts cliniques partagés tout en permettant aux comportements profession-spécifiques de les spécialiser.

---

## Cross-Practitioner Test (CPT)

Avant d'introduire un nouveau concept dans le Core Domain, les questions suivantes doivent recevoir une réponse.

### CPT-001

Ce concept existe-t-il dans plusieurs professions de Practitioners ?

Le comportement peut différer.

Son existence doit rester significative.

---

### CPT-002

Les différences observées sont-elles comportementales plutôt que conceptuelles ?

Si oui :

le concept existant doit être qualifié.

Un nouveau concept Domain n'est pas justifié.

---

### CPT-003

Les différences observées introduisent-elles des invariants indépendants qui ne peuvent pas s'exprimer via une spécialisation ?

Si oui :

un nouveau concept Domain peut être justifié.

Sinon :

le comportement appartient à la spécialisation.

---

### CPT-004

Supprimer ce concept affaiblirait-il le Domain Model pour plusieurs professions de Practitioners ?

Si non,

il est probablement profession-spécifique plutôt que Core Domain.

---

## Exemples

### Clinical Activity

Existe chez les médecins, infirmiers, kinésithérapeutes, psychologues...

Le comportement diffère.

Concept Core Domain. ✅

---

### Clinical Contribution

Existe dans toutes les professions.

Le contenu diffère.

Concept Core Domain. ✅

---

### Prescription

Le concept existe.

Seules certaines professions sont légalement autorisées à en produire une.

L'autorisation qualifie le comportement.

Elle n'invalide pas le concept.

Concept Core Domain. ✅

---

### Clinical Handover

Possède des invariants indépendants non réductibles à une qualification de Clinical Activity :
émetteur identifié, contenu suffisant, état de transmission, accusé réception, non supprimable une fois clos.

Ces invariants ne peuvent pas être exprimés comme variation de comportement d'un concept existant.

CPT-003 → nouveau concept justifié. ✅ (conditionnel à H-CC-001)

---

### Changement d'aiguille de Huber

Procédure infirmière spécifique.

Pas un concept Core Domain.

Appartient aux protocoles cliniques. ❌

---

## Conséquences

Chaque nouvelle interview doit d'abord tenter d'expliquer les observations avec les concepts Core Domain existants.

Un nouveau concept n'est créé que lorsque :

* aucun concept existant n'explique l'observation ;
* et le Cross-Practitioner Test est satisfait.

L'objectif de la Discovery n'est pas de modéliser les professions.

Il est de distiller la structure clinique partagée sous-jacente à la diversité professionnelle.

---

## Références

* UL-001 — Ubiquitous Language Charter (vocabulaire officiel, définition de "Practitioner")
* FOUNDATIONS.md — Principe 5 (The Domain Describes Practice)
* ADR-0013 — Mission-Driven Product Design (toute Mission doit satisfaire le CPT)
* CCF-001 — le CCF a été construit en cherchant des invariants transverses aux professions
