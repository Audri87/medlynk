# Concept Review Request — Template

## Usage

Ce template est utilisé pour évaluer tout nouveau concept avant son intégration dans l'architecture MedLink.

Il s'utilise en deux temps :
1. Remplir les champs **Nom du concept**, **Description** et **Origine** avec le concept à évaluer.
2. Soumettre le document à Claude avec la consigne : **"Tu joues le rôle de Memory & Consistency Reviewer."**

---

## Contexte

Nous faisons évoluer l'architecture de MedLink selon une démarche de **Reality Driven Engineering**.

Chaque concept provient d'observations de terrain (interviews de professionnels de santé), est challengé conceptuellement, puis intégré uniquement s'il est cohérent avec l'ensemble de l'architecture existante.

Avant toute validation définitive, nous effectuons une **revue de cohérence historique**.

---

## Nouveau concept

**Nom du concept :**

> *(À compléter)*

---

## Description

> *(Description du concept et de son objectif.)*

---

## Origine

Ce concept provient de :

* Observation terrain : *(référencer O-00X si applicable)*
* Verbatims des praticiens : *(citer les professions concernées)*
* CCF — Clinical Cognition Framework : *(référencer CCF-001 ou observation spécifique si applicable)*
* Discussions d'architecture : *(référencer RFC ou ADR si applicable)*

---

## Mission de la revue

Merci de challenger ce concept en tenant compte de l'ensemble de la documentation existante (ADR, RFC, Domain Model, CCF et langage ubiquitaire).

L'objectif n'est pas de confirmer automatiquement le concept.

L'objectif est de rechercher les raisons pour lesquelles il pourrait être incomplet, redondant ou contradictoire.

---

## Questions à analyser

### 1. Existence

* Ce concept existe-t-il déjà sous un autre nom ?
* Introduit-il un doublon ?

---

### 2. Niveau d'abstraction

Le concept appartient-il réellement à :

* Domain
* Application Service
* Workspace
* UX
* Recherche (CCF)

ou mélange-t-il plusieurs niveaux ?

---

### 3. Cohérence avec le Domain

Le concept respecte-t-il :

* le Domain Model ?
* les Aggregates ?
* les Bounded Contexts ?
* les règles métier ?

---

### 4. Cohérence avec les ADR

Existe-t-il une ADR qui :

* confirme ce concept ?
* le contredit ?
* nécessiterait une mise à jour ?

Citer les ADR concernées.

---

### 5. Cohérence avec le langage ubiquitaire

Le terme choisi est-il cohérent avec les concepts déjà utilisés ?

Un terme existant serait-il plus approprié ?

---

### 6. Conséquences architecturales

Si ce concept est accepté :

* quelles parties de l'architecture sont impactées ?
* quelles documentations devront évoluer ?
* existe-t-il un risque d'effet domino ?

---

### 7. Falsification

Quels seraient les meilleurs contre-exemples capables d'invalider ce concept ?

Dans quels contextes cliniques risque-t-il de ne plus être valide ?

---

### 8. Décision

Terminer la revue par une des décisions suivantes :

* ✅ VALIDÉ
* 🟡 À REFORMULER
* 🟠 À APPROFONDIR
* ❌ REJETÉ

En expliquant précisément pourquoi.

---

## Règle de revue

L'objectif n'est jamais de défendre le concept.

L'objectif est de protéger la cohérence globale de MedLink.

Un concept refusé est considéré comme une amélioration de l'architecture si son rejet permet de préserver la qualité du modèle.

La rigueur de la méthode est plus importante que la rapidité d'évolution du projet.
