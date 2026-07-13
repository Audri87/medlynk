# UPP-001 — Universal Practitioner Principle

**Statut** : Superseded
**Date** : 2026-07-09
**Remplacé par** : CPP-001 — Cross-Practitioner Principle (2026-07-11)

---

## Principe

Le Domain MedLink ne modélise jamais les spécificités d'une profession.

Il modélise exclusivement les concepts qui restent valides pour l'ensemble des Practitioners ciblés par la plateforme.

Les différences entre professions appartiennent :

* aux protocoles ;
* aux spécialisations ;
* aux implémentations ;
* aux futures plateformes spécialisées.

Elles ne doivent jamais enrichir artificiellement le cœur du Domain.

---

## Motivation

Chaque nouvelle profession apporte :

* son vocabulaire ;
* ses outils ;
* ses habitudes ;
* ses contraintes.

Si chaque différence devient un concept du Domain, celui-ci devient rapidement incohérent et impossible à maintenir.

Le rôle de la Discovery n'est donc pas de modéliser les différences.

Il est d'identifier les invariants qui traversent les professions.

---

## Universal Practitioner Test (UPT)

Avant d'introduire un nouveau concept dans le Domain, les questions suivantes doivent être posées.

### UPT-001

Peut-on remplacer le nom de la profession par le terme « Practitioner » sans changer le sens du concept ?

### UPT-002

Le concept reste-t-il compréhensible pour les autres professions ciblées ?

### UPT-003

Décrit-il une responsabilité clinique fondamentale plutôt qu'une organisation locale ou un protocole métier ?

### UPT-004

Si ce concept disparaissait, plusieurs professions verraient-elles leur modèle devenir incomplet ?

---

## Décision

Si une réponse est négative, le concept n'entre pas dans le Domain.

Il peut être :

* une spécialisation métier ;
* un protocole ;
* une règle locale ;
* une fonctionnalité spécifique.

Mais il ne devient pas un concept fondamental de MedLink.

---

## Conséquence

Les interviews servent avant tout à rechercher des invariants.

La création d'un nouveau concept du Domain est un événement exceptionnel.

Par défaut, toute nouvelle observation doit d'abord être interprétée comme une variation d'un concept existant.

Un nouveau concept n'est créé que lorsqu'aucun concept existant ne permet d'expliquer l'observation **et** qu'il satisfait le Universal Practitioner Test.

---

## Exemples

| Concept observé | Résultat UPT | Décision |
|---|---|---|
| « Changement d'aiguille de Huber » | ❌ Spécifique soins infirmiers | Protocole métier — hors Domain |
| « Assurer la continuité d'une prise en charge » | ✅ Valide pour médecins, infirmiers, kinés, sages-femmes, psychologues | Candidat Domain → H-CC-001 |
| « Consultation » | ❌ Médecin-centrique | Spécialisation → Clinical Activity |
| « Transmissions de fin de tournée » | 🔶 Valide si reformulé | Variation de Clinical Handover (H-CC-002) |

---

## Références

* UL-001 — Ubiquitous Language Charter (vocabulaire officiel)
* FOUNDATIONS.md — Principe 5 (The Domain Describes Practice)
* ADR-0013 — Mission-Driven Product Design (toute Mission doit satisfaire l'UPT)
* CCF-001 — le CCF a été construit en cherchant des invariants transverses aux professions
