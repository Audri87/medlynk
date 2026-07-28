# M-001 — Product Boundaries

**Version :** 1.0
**Statut :** Constitution du périmètre produit
**Référence :** M-000 — Constitution of MedLink

---

# 1. Objectif

Ce document définit les frontières de MedLink.

Son objectif est de protéger le Core Domain contre toute dérive fonctionnelle, technique ou commerciale.

Tout nouveau besoin, toute fonctionnalité ou toute décision d'architecture doit être évalué au regard de ces frontières.

En cas de conflit, ce document prévaut sur les décisions locales.

---

# 2. Le principe fondamental

MedLink n'est pas défini par les fonctionnalités qu'il possède.

MedLink est défini par le problème qu'il résout.

> **Préserver et transmettre la compréhension clinique pour qu'aucun professionnel n'ait à reconstruire ce qu'un autre savait déjà.**

Le périmètre produit est entièrement déduit de cette mission.

---

# 3. Le Core Domain

Le Core Domain de MedLink est la **Compréhension Clinique**.

Il comprend exclusivement les capacités nécessaires pour :

* construire la compréhension clinique ;
* préserver cette compréhension dans le temps ;
* enrichir cette compréhension ;
* transmettre cette compréhension ;
* permettre sa reprise immédiate par un autre professionnel.

Tout ce qui ne contribue pas directement à cette mission n'appartient pas au Core Domain.

---

# 4. Les catégories de domaines

Tous les domaines de MedLink appartiennent obligatoirement à l'une des quatre catégories suivantes.

## 4.1 Core Domain

Le cœur de MedLink.

Sa mission est de produire et transmettre la compréhension clinique.

Exemples :

* Clinical Understanding
* Clinical Situation
* Clinical Contribution
* Clinical Timeline
* Knowledge Continuity
* Clinical Reasoning
* Decision Context

Le Core Domain est prioritaire sur tout le reste.

---

## 4.2 Supporting Domains

Ils améliorent l'utilisation du Core Domain.

Ils ne possèdent jamais leur propre raison d'être.

Exemples :

* Recherche
* Notifications
* Documents
* Intelligence Artificielle
* Collaboration
* Gestion des pièces jointes
* Tableaux de bord
* Agenda contextuel

Ces domaines existent uniquement parce qu'ils renforcent le Core Domain.

---

## 4.3 External Platforms

Ces plateformes possèdent leur propre logique métier.

MedLink ne cherche pas à la remplacer.

Elles produisent ou consomment de la compréhension clinique.

Exemples :

* Laboratoires
* Imagerie
* Pharmacies
* Téléconsultation
* Logiciels hospitaliers
* Dossiers Patients Informatisés (DPI)
* Logiciels de cabinets
* Objets connectés

Ces plateformes enrichissent le Core Domain sans en faire partie.

---

## 4.4 Generic Domains

Ils sont nécessaires au fonctionnement du produit mais n'apportent aucun avantage compétitif.

Exemples :

* Authentification
* Paiement
* Facturation
* Gestion des utilisateurs
* Stockage
* Notifications techniques
* Audit
* Sécurité
* Infrastructure

Ils doivent rester simples.

Ils ne définissent jamais MedLink.

---

# 5. Les règles de frontière

Toute fonctionnalité doit satisfaire les règles suivantes.

## R-1

Le Core Domain ne dépend d'aucun domaine périphérique.

---

## R-2

Les Supporting Domains dépendent du Core.

Jamais l'inverse.

---

## R-3

Les plateformes externes ne modifient jamais le Core Domain.

Elles produisent des contributions qui viennent enrichir la compréhension clinique.

---

## R-4

Les Generic Domains sont interchangeables.

Ils ne doivent jamais influencer les décisions métier.

---

## R-5

Aucun domaine ne peut contourner le Core Domain.

Toute compréhension clinique transite par lui.

---

# 6. Les tests de frontière

Avant d'intégrer une nouvelle fonctionnalité, les questions suivantes doivent être posées.

### Test 1 — Mission

Cette fonctionnalité aide-t-elle directement à préserver ou transmettre la compréhension clinique ?

Si non, elle n'appartient probablement pas au Core Domain.

---

### Test 2 — Dépendance

Le Core Domain pourrait-il continuer d'exister si cette fonctionnalité disparaissait ?

Si la réponse est non, cette fonctionnalité appartient probablement au Core.

---

### Test 3 — Autonomie

Cette fonctionnalité possède-t-elle une logique métier indépendante ?

Si oui, elle est probablement une plateforme externe.

---

### Test 4 — Valeur

La suppression de cette fonctionnalité réduit-elle l'avantage compétitif de MedLink ?

Si non, elle est probablement générique.

---

### Test 5 — Universalité

Cette fonctionnalité est-elle valable pour la majorité des professions de santé ?

Si elle ne concerne qu'un métier particulier, elle relève probablement d'une plateforme spécialisée.

---

# 7. Les refus explicites

MedLink ne cherche pas à devenir :

* un DPI complet ;
* un logiciel de facturation ;
* un agenda universel ;
* un logiciel de laboratoire ;
* un logiciel d'imagerie ;
* un logiciel de pharmacie ;
* un logiciel de gestion d'établissement ;
* un ERP hospitalier.

Ces domaines pourront être intégrés, mais ne feront jamais partie du Core Domain.

---

# 8. Les extensions

Toute nouvelle plateforme devra respecter le modèle suivant :

1. Elle possède son propre domaine.
2. Elle reste autonome.
3. Elle enrichit le Core Domain par des contributions.
4. Elle peut consommer la compréhension clinique.
5. Elle ne modifie jamais la mission du Core.

---

# 9. Le critère ultime

Avant toute décision produit, une seule question doit être posée :

> **Cette décision renforce-t-elle la capacité de MedLink à préserver et transmettre la compréhension clinique ?**

Si la réponse est non, cette décision ne doit pas modifier le Core Domain.

---

# 10. Conséquence architecturale

Le Core Domain est l'actif stratégique de MedLink.

Toutes les autres parties du système sont conçues pour :

* le servir ;
* l'alimenter ;
* l'exploiter ;
* le protéger.

Aucune architecture, aucune intégration, aucun besoin commercial ne peut justifier un affaiblissement du Core Domain.

Le Core Domain constitue la vérité fonctionnelle de MedLink.

Tout le reste est construit autour de lui.
