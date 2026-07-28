# ADR-SA-015 — Ajout de `clinicalActivityId` au payload de `ContributionCliniqueCreée`

**Type :** Software Architecture Decision
**Statut :** Accepted
**Date :** 2026-07-28
**Affine :** ADR-SA-014 · DA-010 · DE-001
**Résout :** ADB-DE-001

---

## Bloc de traçabilité domaine

### Principes concernés

| Document | Pertinence |
|---|---|
| DA-010 — Clinical Activity | Invariant 1 : toute Contribution Clinique est produite dans le contexte d'une Clinical Activity |
| ADR-0007 — Clinical Contribution Relationships | La relation Clinical Activity / Clinical Contribution est une relation métier, non d'appartenance |
| ADR-SA-014 — BC-1 Aggregate Model | Clinical Activity et Clinical Contribution sont deux ARs indépendants — un événement ne transporte que ce que son AR possède |
| ADR-0014 — Domain Events Platform Boundary | Les Domain Events ne traversent pas les frontières de plateforme |

### Invariant métier fondateur

**DA-010 Invariant 1 :** *"Toute Contribution Clinique est produite dans le contexte d'une Clinical Activity."*

Cet invariant signifie que `clinicalActivityId` n'est jamais null dans le domaine. Toute Contribution a une Clinical Activity. L'événement `ContributionCliniqueCreée` doit refléter cet invariant dans son payload.

---

## Contexte

ADB-DE-001 a identifié que BC-3 (Continuité Clinique) ne peut pas corréler les Contributions produites lors d'une Clinical Activity de mode Transmission à la Transition ouverte correspondante.

La cause : `ContributionCliniqueCreée` (E-01) ne transporte pas `clinicalActivityId`. BC-3 reçoit chaque Contribution individuellement sans savoir à quelle Clinical Activity elle appartient.

L'option retenue dans ADB-DE-001 est la suivante : ajouter `clinicalActivityId` au payload de E-01. Chaque Contribution se déclare dans son propre événement comme produite dans un contexte donné, conformément à DA-010 Invariant 1.

L'option alternative — ajouter `contributionIds` à `ClinicalActivityClosed` (E-04) — a été explicitement écartée. Elle violerait l'AR Ownership : `ClinicalActivity` ne possède pas `ClinicalContribution` et ne peut pas rapporter l'état d'un AR qu'elle ne possède pas (voir justification complète dans ADB-DE-001).

---

## Décision

**`clinicalActivityId : ClinicalActivityId` est ajouté au payload de `ContributionCliniqueCreée`.**

Ce champ est obligatoire. Il n'est jamais null.

### Payload mis à jour de E-01

| Champ | Type | Statut | Justification |
|---|---|---|---|
| `contributionId` | ContributionId | Existant | Identité de l'Aggregate Root |
| `patientId` | PatientId | Existant | Patient concerné |
| `auteurId` | PractitionerId | Existant | Auteur de la Contribution |
| `produitLe` | Timestamp | Existant | Moment de production |
| `clinicalActivityId` | ClinicalActivityId | **Nouveau** | Contexte opérationnel de production — DA-010 Invariant 1 |

---

## Compatibilité additive du contrat

L'ajout de `clinicalActivityId` est un changement **additif** : un nouveau champ est introduit, aucun champ existant n'est supprimé ou modifié, aucun type n'est altéré.

Un changement additif ne constitue pas une rupture de contrat au sens des Event-Driven systems.

**Règle de compatibilité :** tout consommateur de E-01 qui ne lit pas `clinicalActivityId` continue de fonctionner sans modification. Les consommateurs existants sont protégés par le principe du Tolerant Reader (Enterprise Integration Patterns, Hohpe & Woolf) : un consommateur doit ignorer les champs qu'il ne connaît pas, sans lever d'erreur.

Cette règle doit être appliquée à l'implémentation de tous les handlers de E-01.

---

## Comportement attendu des consommateurs existants

### BC-2 — Parcours de Soins

BC-2 souscrit à E-01 via `IntégrateurDeContributions`. Sa mission est d'intégrer la Contribution dans le Parcours chronologique du Patient.

BC-2 n'a pas d'usage actuel de `clinicalActivityId`. Sa mission ne requiert pas de savoir dans quel contexte opérationnel une Contribution a été produite — seulement qui l'a produite, quand, et pour quel Patient.

**Comportement attendu :** BC-2 ignore `clinicalActivityId` jusqu'à ce qu'un besoin explicite soit identifié dans ses responsabilités. Aucune modification du handler existant n'est requise au moment de cette décision.

**Contrainte :** le handler de BC-2 ne doit pas lever d'erreur à la réception d'un champ inconnu. Ce comportement doit être validé avant déploiement.

### Workspace

Le Workspace consomme E-01 pour mettre à jour l'affichage. `clinicalActivityId` peut être utilisé à terme pour enrichir la navigation contextuelle (lien Contribution → Clinical Activity), mais n'est pas requis immédiatement.

**Comportement attendu :** identique à BC-2 — le champ est ignoré jusqu'à usage explicite.

---

## Obligation métier

DA-010 Invariant 1 impose que toute Contribution soit produite dans le contexte d'une Clinical Activity. Cet invariant est structurel, sans exception.

**Conséquences normatives :**

1. `clinicalActivityId` dans E-01 n'est jamais null — si `ClinicalActivity` n'existe pas au moment de la production, la Contribution ne peut pas être créée. La précondition est enforced par `AmendementService` et `ContributionProducerService` dans BC-1.

2. Aucune Contribution "orpheline" ne peut exister dans le domaine. Une Contribution sans `clinicalActivityId` constitue une violation de DA-010 Invariant 1 et doit être rejetée au niveau de l'AR `ClinicalContribution`.

3. La chaîne d'amendements est elle-même bornée : chaque amendement est produit dans une nouvelle Clinical Activity (DA-010 Invariant 3), et son E-01 porte le `clinicalActivityId` de cette nouvelle activité. La chaîne `amendeDe` relie des Contributions ; chacune porte son propre `clinicalActivityId`.

---

## Stratégie d'identification et d'idempotence pour BC-3

### Mécanisme de corrélation

BC-3 corrèle les Contributions produites lors d'une Clinical Activity de mode Transmission en maintenant une projection interne de la relation `clinicalActivityId → List<contributionId>`.

Le flux d'événements que BC-3 reçoit pour une activité de Transmission :

```
E-03 ClinicalActivityOpened  (clinicalActivityId=X, mode=Transmission, patientId=P)
     → BC-3 ouvre une fenêtre de corrélation pour clinicalActivityId=X

E-01 ContributionCliniqueCreée (contributionId=A, clinicalActivityId=X, patientId=P)
     → BC-3 ajoute A à la liste pour clinicalActivityId=X

E-01 ContributionCliniqueCreée (contributionId=B, clinicalActivityId=X, patientId=P)
     → BC-3 ajoute B à la liste pour clinicalActivityId=X

E-04 ClinicalActivityClosed (clinicalActivityId=X, mode=Transmission, patientId=P)
     → BC-3 ferme la fenêtre — la liste [A, B] est la liste de Transmission
     → BC-3 associe [A, B] à la Transition ouverte pour patientId=P
```

### Idempotence

L'idempotence est garantie par `contributionId` comme clé de déduplication.

**Règle R-IDEM-01 :** BC-3 ne doit jamais traiter deux fois le même `contributionId` pour la même fenêtre de corrélation. Si E-01 est reçu deux fois avec le même `contributionId` (at-least-once delivery — ADR-SA-010), la deuxième réception est ignorée silencieusement.

**Règle R-IDEM-02 :** BC-3 ne doit jamais traiter deux fois E-04 pour le même `clinicalActivityId`. Si E-04 est reçu deux fois, la deuxième réception est ignorée si la fenêtre de corrélation est déjà fermée.

**Règle R-IDEM-03 :** l'ordre de réception de E-01 et E-03 n'est pas garanti (at-least-once, Outbox — ADR-SA-010). BC-3 doit gérer le cas où E-01 arrive avant E-03 pour le même `clinicalActivityId`. Dans ce cas, BC-3 ouvre la fenêtre rétroactivement ou bufferise E-01 jusqu'à réception de E-03.

**Règle R-IDEM-04 :** si E-04 arrive avant certains E-01 pour le même `clinicalActivityId` (ordonnancement non garanti), BC-3 maintient une période de grâce configurable avant de fermer définitivement la fenêtre de corrélation.

### Limite de responsabilité

BC-3 est responsable de la corrélation `clinicalActivityId → Contributions`. Il n'est pas responsable de vérifier que la Clinical Activity existe dans BC-1. Le fait que `clinicalActivityId` soit présent dans E-01 est suffisant — BC-1 est le garant de sa validité (ADR-SA-014 R-01).

---

## Règles normatives

| # | Règle |
|---|---|
| R-01 | `clinicalActivityId` est obligatoire dans le payload de E-01. Il n'est jamais null. |
| R-02 | `clinicalActivityId` n'est jamais exposé dans le contenu clinique — c'est une référence d'infrastructure de corrélation. |
| R-03 | Les consommateurs existants de E-01 doivent implémenter le Tolerant Reader et ignorer les champs non utilisés sans lever d'erreur. |
| R-04 | BC-2 ignore `clinicalActivityId` jusqu'à usage explicite. Aucune modification de `IntégrateurDeContributions` n'est requise par cette décision. |
| R-05 | BC-3 utilise `contributionId` comme clé d'idempotence pour la corrélation — jamais `clinicalActivityId` seul. |
| R-06 | BC-3 gère le désordre d'arrivée des événements E-01 / E-03 / E-04 (période de grâce, buffering). |
| R-07 | Toute Contribution sans `clinicalActivityId` valide doit être rejetée par `ClinicalContribution` avant publication de E-01. |
| R-08 | Cette décision ne modifie pas le payload de E-02 (`ContributionCliniqueAmendée`). E-02 transporte également `clinicalActivityId` implicitement via le fait que l'amendement est produit dans une nouvelle ClinicalActivity — ce `clinicalActivityId` est celui de la nouvelle activité, pas de l'activité d'origine. |

---

## Impact documentaire

| Document | Modification requise |
|---|---|
| DE-001 — E-01 | Ajouter `clinicalActivityId` au tableau payload §8 · Maintenir stabilité "Stable" |
| SD-005 §2 BC-1 | Mettre à jour "Format des événements" : le payload inclut désormais `clinicalActivityId` |
| ADB-001 — ADB-DE-001 | Marquer `Resolved` avec référence à cette ADR |

---

## Références

| Document | Pertinence |
|---|---|
| DA-010 | Invariant 1 — fondement métier de cette décision |
| ADR-SA-014 | Modèle d'agrégats BC-1 — justification du rejet de l'option contributionIds dans E-04 |
| ADR-SA-010 | Outbox Pattern — at-least-once delivery, idempotence |
| ADB-001 ADB-DE-001 | Backlog d'origine — options analysées, option 1 écartée |
| DE-001 E-01 | Contrat de payload mis à jour par cette décision |
