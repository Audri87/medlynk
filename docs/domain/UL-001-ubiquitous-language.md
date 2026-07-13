# UL-001 — Ubiquitous Language Charter

**Statut** : Accepted
**Date** : 2026-07-13
**Version** : 2.0

---

## Contexte

MedLink est une plateforme clinique.

Le Domain Model décrit des mécanismes cliniques communs à plusieurs professions de santé.

Le langage utilisé dans l'architecture ne doit jamais être influencé par la profession ayant servi de point d'entrée au MVP.

---

## Principe fondamental

> **Le Domain décrit la pratique clinique, jamais une profession particulière.**

Les professions sont des spécialisations.

Le Domain reste générique.

---

## Règle de gouvernance

**Aucun terme ne peut apparaître dans un ADR, un Event Storming, une Policy ou un Aggregate sans être défini dans ce document.**

Effective à compter du 2026-07-13.

Les documents antérieurs à cette date sont exemptés et seront alignés lors de leur prochaine révision.

---

## Vocabulaire officiel

| ❌ À éviter | ✅ Terme du Domain | Justification |
| --- | --- | --- |
| Médecin | Practitioner | Valide pour médecin, infirmière, sage-femme, psychologue, kiné… |
| Consultation | Clinical Activity | Valide pour consultation, séance, visite, acte |
| Compte-rendu médical | Clinical Contribution | Valide pour note, ordonnance, compte-rendu, courrier |
| Brouillon / Notes en cours | Clinical Draft | État mutable privé pendant la production |
| Dossier médical | Care Record | Mémoire clinique longitudinale, indépendante de la profession |
| Logiciel médecin | Clinical Platform | La plateforme sert toutes les professions cliniques |
| Interface médecin | Professional Workspace | Workspace calculé pour un Practitioner dans un contexte donné |
| Patient / Client / Usager | Patient | Le Domain utilise "Patient" comme terme stable |
| Passage de relais / Garde / Remplacement | Clinical Handover | Transfert de Clinical Responsibility vers un autre Practitioner |
| Courrier de référé / Ordonnance de référence | Clinical Referral | Mandat d'acte spécifique sans transfert de Clinical Responsibility |
| Responsabilité clinique | Clinical Responsibility | Responsabilité professionnelle du Practitioner pour un Patient |
| Suivi / Continuité des soins | Clinical Continuity | Capacité à préserver la cohérence des soins dans le temps |
| Savoir clinique / Informations cliniques validées | Clinical Knowledge | Contributions validées disponibles pour les activités futures |

---

## Registre des concepts officiels

Les définitions ci-dessous constituent la référence sémantique du Domain MedLink.

---

### Practitioner

**Statut** : ✅ Frozen

Tout professionnel de santé réalisant une Clinical Activity sous sa propre responsabilité clinique.

Le terme Practitioner est indépendant de toute profession.

---

### Patient

**Statut** : ✅ Frozen

La personne pour laquelle une Clinical Activity est réalisée.

Le Patient est un Actor dans le Platform Kernel. Il devient sujet de soins dans la Clinical Platform.

---

### Clinical Activity

**Statut** : ✅ Frozen

Un épisode borné de travail clinique professionnel réalisé par un Practitioner pour un but clinique défini.

Une Clinical Activity gouverne la production de Clinical Contributions et définit la Clinical Responsibility du Practitioner pendant cet épisode.

---

### Clinical Draft

**Statut** : ✅ Frozen

Une représentation de travail mutable créée et détenue par une Clinical Activity pendant qu'un Practitioner produit une contribution clinique.

Un Clinical Draft n'existe que pendant l'exécution d'une Clinical Activity. Il est privé au Practitioner responsable et n'a aucune valeur clinique ou médico-légale avant sa validation explicite.

* Mutable.
* Jamais partie du Care Record.
* Peut être abandonné.
* La validation transforme son contenu en Clinical Contribution.

---

### Clinical Contribution

**Statut** : ✅ Behaviour Frozen

Un enregistrement clinique immuable explicitement validé par un Practitioner en tant que résultat d'une Clinical Activity.

Une Clinical Contribution représente une connaissance clinique acceptée par son auteur et peut être référencée par de futures Clinical Activities.

* Immuable après validation.
* Produite exactement une fois.
* Produite par exactement une Clinical Activity.
* Peut être référencée indéfiniment.
* Ne peut pas être supprimée.

---

### Clinical Responsibility

**Statut** : ✅ Frozen

La responsabilité professionnelle d'un Practitioner pour la gestion clinique d'un Patient.

À tout instant, un Patient en cours de prise en charge a exactement un Practitioner responsable.

La Clinical Responsibility ne peut être transférée que via un Clinical Handover.

---

### Clinical Handover

**Statut** : 🟢 Provisional

Le transfert de Clinical Responsibility pour un Patient d'un Practitioner à un autre.

Un Clinical Handover change qui est responsable de la continuation des soins. La Clinical Responsibility reste avec le Practitioner émetteur jusqu'à acceptation explicite par le Practitioner destinataire.

---

### Clinical Referral

**Statut** : ✅ Frozen

Une demande d'un Practitioner à un autre de réaliser un acte clinique spécifique ou de fournir un avis professionnel.

Un Clinical Referral ne transfère pas la Clinical Responsibility. Le Practitioner demandeur reste responsable du Patient.

---

### Clinical Continuity

**Statut** : 🟡 Validation terrain en cours (H-CC-001)

La capacité des Clinical Activities successives à préserver et prolonger la cohérence des soins d'un Patient dans le temps.

La Clinical Continuity est assurée par l'usage approprié des Clinical Contributions et, lorsque la Clinical Responsibility change, des Clinical Handovers.

---

### Care Record

**Statut** : 🟡 Frozen with Hotspots

L'enregistrement clinique longitudinal qui préserve la connaissance clinique pertinente pour les soins d'un Patient.

Le Care Record est composé de Clinical Contributions. Il peut inclure des artefacts cliniques d'origine externe selon des règles de provenance définies.

* Jamais une source de vérité pour le raisonnement clinique.
* Dérivé des Clinical Contributions — jamais leur substitut.
* Hotspot ouvert : artefacts cliniques importés (H-ES-002).

---

### Clinical Knowledge

**Statut** : ✅ Frozen

La connaissance clinique validée disponible pour soutenir les Clinical Activities présentes et futures.

La Clinical Knowledge croît par l'ajout de Clinical Contributions immutables. Elle reste indépendante du raisonnement qui les a produites.

---

### Open Hotspot — Clinical Artifact

Un objet d'information clinique dont l'origine est extérieure à la Clinical Activity courante.

Exemples : résultats importés, documents historiques, pièces jointes fournies par le patient.

**Non promu au glossaire officiel.** Définition et règles de provenance en attente de résolution par Event Storming (H-ES-002).

---

## Relation avec le Platform Kernel

Le Platform Kernel utilise "Actor" comme concept générique.

Dans la Clinical Platform :

* "Practitioner" est la spécialisation d'Actor pour les professionnels de santé.
* "Patient" est la spécialisation d'Actor pour la personne soignée.

Ces spécialisations appartiennent à la Clinical Platform, jamais au Kernel.

---

## Les professions

Les professions appartiennent au niveau métier, pas au Domain.

Toutes réalisent des Clinical Activities.

Toutes produisent des Clinical Contributions.

Aucune ne définit le Domain.

---

## Test du langage ubiquitaire

Avant d'introduire un nouveau terme dans le Domain, appliquer le Cross-Practitioner Test (CPP-001) :

**Le concept existe-t-il dans plusieurs professions de Practitioners ?**

Si oui : le concept peut appartenir au Domain.

Si non : il s'agit probablement d'une spécialisation métier, d'un protocole ou d'un Workspace Pattern.

---

## Conséquences

Ce document protège MedLink contre un biais de conception centré sur une profession.

Il garantit que :

* le Domain reste stable face à l'ajout de nouvelles professions ;
* les Workspaces peuvent être spécialisés sans modifier le cœur du modèle ;
* tout document d'architecture partage un vocabulaire commun.

---

## Principe de conception

> **Les professions adaptent le Domain. Le Domain ne s'adapte jamais aux professions.**

---

## Références

* ADR-0001 — Platform Kernel (Actor)
* ADR-0007 — Clinical Contribution Relationships
* ADR-0010 — Care Record Domain Definition
* CAL-001 — Clinical Activity Lifecycle
* CCF-001 — Clinical Cognition Framework
* CPP-001 — Cross-Practitioner Principle
* DE-BASELINE-V1 — Domain Engineering Baseline
* DE-AGGREGATE-MAP-V1 — Aggregate Map
