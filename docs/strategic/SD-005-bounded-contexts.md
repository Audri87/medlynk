# SD-005 — Bounded Contexts

**Version :** 1.0
**Statut :** Accepted
**Source :** Domain Atlas V1
**Supersède partiellement :** SD-004 (v1.0 — remplacé sur le découpage métier ; les règles d'intégration technique restent valides)
**Date :** 2026-07-28

---

## Préambule

### Méthode

Ce document dérive les Bounded Contexts de MedLink **exclusivement** à partir du Domain Atlas V1.

Aucun découpage n'est motivé par une contrainte technique.

Aucun découpage n'est motivé par une organisation d'équipes.

Le seul critère est métier : un Bounded Context est justifié si et seulement si un sous-ensemble cohérent de concepts du Domain Atlas forme un **modèle unifié** autour d'une responsabilité distincte, avec ses propres invariants et ses propres règles de changement.

### Périmètre

Ce document couvre la **Clinical Platform** — le premier périmètre implémenté.

Les concepts du Domain Atlas V1 sont tous des concepts cliniques. Ils constituent le Core Domain.

Le Platform Kernel et l'Identity Platform sont des **contextes externes** référencés mais non détaillés ici.

### Règle de priorité

> Tout nouveau concept, service, ou événement doit être justifiable par le Domain Atlas avant d'être attribué à un Bounded Context.

---

## 1. Cartographie des concepts du Domain Atlas

Avant de délimiter les contextes, identifier où chaque concept "appartient naturellement" par sa responsabilité dominante.

| Concept (Domain Atlas) | Responsabilité dominante | Contexte pressenti |
|---|---|---|
| Patient | Entité continue, objet du soin | Parcours de Soins |
| Professionnel de Santé | Auteur, acteur transitoire | Contribution Clinique |
| Compréhension Clinique | Concept central — traverse tous les contextes | *Non attribuable à un seul contexte* |
| Contribution Clinique | Acte de production et d'externalisation | Contribution Clinique |
| Situation Clinique | Dimension interne d'une Contribution | Contribution Clinique |
| Raisonnement Clinique | Dimension interne d'une Contribution | Contribution Clinique |
| Hypothèse Clinique | Dimension interne d'une Contribution | Contribution Clinique |
| Incertitude Clinique | Dimension interne d'une Contribution | Contribution Clinique |
| Intention Clinique | Dimension interne d'une Contribution | Contribution Clinique |
| Parcours de Soins | Accumulation longitudinale | Parcours de Soins |
| Transition | Événement structurel de changement de Professionnel | Continuité Clinique |
| Reprise de Contexte | Acte de reconstruction de la compréhension | Continuité Clinique |
| Modèle de Situation | État cognitif produit par la Reprise | Continuité Clinique |
| Lacune | Vide identifié lors de la Reprise | Continuité Clinique |
| Perspective | Point de vue situé de l'auteur | Contribution Clinique |

**Résultat :** trois Bounded Contexts distincts, un concept transversal (Compréhension Clinique).

---

## 2. Bounded Context 1 — Contribution Clinique

### Mission

Gouverner la **production et l'externalisation** de la Compréhension Clinique.

Ce contexte est le seul endroit où une Contribution Clinique peut naître.

---

### Pourquoi ce contexte existe

Le Domain Atlas (§4) établit que toute Compréhension Clinique externalisée est **perspectivale et attribuée** : elle possède un auteur, une date, un contexte de production. Les règles qui gouvernent la *validité* d'une Contribution (présence d'un auteur, d'une dimension clinique, non-altération de l'existant lors d'un amendement) forment un modèle cohérent centré sur l'**acte de production**.

Ce modèle est distinct du modèle d'accumulation (Parcours de Soins) et du modèle de transmission (Continuité Clinique).

Dans le contexte de la Contribution, le Professionnel de Santé est un **acteur-auteur** : c'est sa Perspective qui donne son sens à chaque Contribution.

Dans le contexte du Parcours, ce même Professionnel n'est qu'une référence chronologique.

Ce changement de modèle justifie le découpage.

**Fondation théorique :**

- M-003 §3 — Les 4 dimensions de la Compréhension Clinique
- M-003 Invariant I — Toute Compréhension est située et attribuée
- M-003 Invariant V — Toute Compréhension est perspectivale
- Domain Atlas §4 — Contribution Clinique : auteur, produitLe, perspectivale
- Domain Atlas §2 — Professionnel de Santé : auteur, Perspective

---

### Responsabilités

| Responsabilité | Description |
|---|---|
| Produire | Créer une Contribution Clinique à partir d'une prise en charge |
| Valider | Vérifier qu'une Contribution respecte les invariants du domaine (authorship, contexte, au moins une dimension clinique) |
| Amender | Permettre la correction non-destructive d'une Contribution existante via une nouvelle Contribution |
| Refuser | Rejeter toute tentative de modification directe ou de suppression d'une Contribution existante |

---

### Agrégats

#### Contribution Clinique *(Aggregate Root)*

| Attribut | Type | Invariant |
|---|---|---|
| `id` | ContributionId | Immuable après création |
| `auteur` | PractitionerId | Obligatoire. Non modifiable. |
| `produitLe` | Timestamp | Immuable. Représente le moment de la prise en charge, pas de la saisie. |
| `contexte` | ContexteId | Référence le Work Context actif |
| `situationClinicique` | SituationClinique | Au moins un des 4 composants doit être présent |
| `raisonnementClinique` | RaisonnementClinique | *Facultatif — mais son absence est une Lacune potentielle* |
| `hypothèsesCliniques` | HypothèseClinique[] | *Facultatif* |
| `incertitudesCliniques` | IncertitudeClinique[] | *Facultatif* |
| `intentionsCliniques` | IntentionClinique[] | *Facultatif* |
| `perspective` | Perspective | Dérivée de l'auteur au moment de la contribution |
| `amendeDe` | ContributionId? | Référence à la Contribution amendée si applicable |

**Invariants de l'agrégat :**

1. Une Contribution ne peut pas être modifiée après création.
2. Une Contribution ne peut pas être supprimée.
3. L'auteur d'une Contribution ne peut pas être changé après création.
4. Un amendement produit une **nouvelle** Contribution — il ne modifie pas l'originale.
5. Un Professionnel de Santé ne peut pas approuver sa propre Contribution (ADR-0007).

---

### Services domaine

| Service | Rôle |
|---|---|
| `ContributionProducerService` | Orchestre la création d'une Contribution — valide les invariants, applique la Perspective de l'auteur, émet l'événement |
| `AmendementService` | Produit une nouvelle Contribution qui amende une Contribution existante. Maintient la chaîne d'amendement. |

---

### Événements publiés

| Événement | Déclencheur | Destinataires |
|---|---|---|
| `ContributionCliniqueCreée` | Production d'une nouvelle Contribution | Parcours de Soins, Continuité Clinique |
| `ContributionCliniqueAmendée` | Production d'un amendement | Parcours de Soins |

**Format des événements :** L'événement contient l'identifiant de la Contribution et le PatientId. Les consommateurs récupèrent les données nécessaires via lecture du Parcours. Les événements ne contiennent pas le contenu clinique complet (confidentialité et taille).

---

### API publiques

| Méthode | Chemin | Description |
|---|---|---|
| `POST` | `/patients/{patientId}/contributions` | Produire une Contribution Clinique |
| `GET` | `/patients/{patientId}/contributions/{id}` | Lire une Contribution spécifique |
| `POST` | `/patients/{patientId}/contributions/{id}/amendements` | Produire un amendement |

---

### Dépendances

| Contexte externe | Nature | Direction |
|---|---|---|
| Identity Platform | Valide que le `PractitionerId` est un acteur authentifié | → entrant |
| Identity Platform | Valide que le `PatientId` est un patient enregistré | → entrant |
| Platform Kernel | Valide le `ContexteId` (Work Context actif) | → entrant |

Ce contexte ne dépend d'aucun autre Bounded Context clinique.

C'est le contexte **le plus en amont** de la Clinical Platform.

---

## 3. Bounded Context 2 — Parcours de Soins

### Mission

Gouverner la **préservation longitudinale et non-destructive** de la Compréhension Clinique d'un Patient.

Ce contexte est le gardien de la mémoire clinique.

---

### Pourquoi ce contexte existe

Le Domain Atlas (§10) établit que le Parcours de Soins est l'accumulation **chronologique et non-destructive** de toutes les Contributions Cliniques d'un Patient. Les règles qui gouvernent cette accumulation (ordre chronologique immuable, absence de suppression, propriété du Patient) forment un modèle centré sur la **persistance dans le temps**.

Ce modèle est radicalement différent du modèle de production : dans ce contexte, une Contribution est une **entrée chronologique** dans un registre — pas un objet complexe avec un auteur-décideur.

Le Patient, dans ce contexte, est le **propriétaire** du Parcours — entité continue à laquelle appartient la mémoire clinique. C'est le seul contexte où le Patient est un agrégat (ou la racine d'un agrégat).

Cette continuité du Patient (P-001 §3 — "le patient est continu ; les professionnels sont transitoires") est l'invariant fondateur de ce contexte.

**Fondation théorique :**

- P-001 §3 — Asymétrie structurelle : Patient continu, Professionnels transitoires
- M-003 Propriété dynamique 4 — La Compréhension se dégrade dans le temps sans entretien
- M-003 §8.5 — Valeur économique de la préservation
- Domain Atlas §1 — Patient : entité continue
- Domain Atlas §10 — Parcours de Soins : non-destructif, chronologique, propriété du Patient

---

### Responsabilités

| Responsabilité | Description |
|---|---|
| Intégrer | Recevoir et intégrer une Contribution produite par le contexte Contribution Clinique |
| Ordonner | Maintenir l'ordre chronologique immuable des Contributions |
| Préserver | Garantir qu'aucune Contribution ne peut être supprimée ou modifiée rétrospectivement |
| Exposer | Rendre le Parcours consultable pour la Reprise de Contexte |
| Appartenir | Garantir qu'un Parcours de Soins appartient à exactement un Patient |

---

### Agrégats

#### Parcours de Soins *(Aggregate Root)*

| Attribut | Type | Invariant |
|---|---|---|
| `id` | ParcoursId | Immuable |
| `patientId` | PatientId | Immuable. 1:1 avec un Patient. |
| `initiéLe` | Timestamp | Date de la première Contribution intégrée |
| `contributions` | ContributionEntry[] | Ordonné chronologiquement. Jamais réduit. |

**ContributionEntry** (value object dans le Parcours) :

| Attribut | Type |
|---|---|
| `contributionId` | ContributionId |
| `auteurId` | PractitionerId |
| `produitLe` | Timestamp |
| `résumé` | Résumé non-interprétatif des dimensions présentes |

*Note : le Parcours ne duplique pas le contenu des Contributions. Il maintient une référence ordonnée et un résumé minimal suffisant pour la navigation.*

**Invariants de l'agrégat :**

1. Un Parcours de Soins existe si et seulement si au moins une Contribution a été intégrée.
2. La liste des Contributions ne peut jamais être réduite.
3. L'ordre chronologique ne peut jamais être modifié.
4. Un Parcours appartient à exactement un Patient.
5. Un Patient possède exactement un Parcours de Soins.

---

### Services domaine

| Service | Rôle |
|---|---|
| `IntégrateurDeContributions` | Reçoit un événement `ContributionCliniqueCreée`, récupère la Contribution, l'intègre dans le Parcours du Patient concerné (crée le Parcours si premier contact). |
| `ConsulteurDeParcours` | Sert les requêtes de lecture du Parcours — filtrées par période, par auteur, par type de dimension. (Application Service / Query Handler) |

---

### Événements publiés

| Événement | Déclencheur | Destinataires |
|---|---|---|
| `ParcoursDeSoinsInitié` | Première intégration pour un Patient | Continuité Clinique, Workspace |
| `ContributionCliniqueIntégrée` | Intégration d'une nouvelle Contribution dans le Parcours | Continuité Clinique, Workspace |

---

### API publiques

| Méthode | Chemin | Description |
|---|---|---|
| `GET` | `/patients/{patientId}/parcours` | Lire le Parcours de Soins (navigation, chronologie) |
| `GET` | `/patients/{patientId}/parcours/contributions` | Lister les Contributions dans l'ordre chronologique |
| `GET` | `/patients/{patientId}/parcours/contributions?depuis={date}&jusqu'à={date}` | Lister les Contributions sur une période |

---

### Dépendances

| Contexte | Nature | Direction |
|---|---|---|
| **Contribution Clinique** | Souscrit aux événements `ContributionCliniqueCreée` et `ContributionCliniqueAmendée` | ← entrant (événements) |
| Identity Platform | Valide que le `PatientId` est un Patient enregistré | → entrant |

Ce contexte est **en aval** de Contribution Clinique et **en amont** de Continuité Clinique.

---

## 4. Bounded Context 3 — Continuité Clinique

### Mission

Gouverner la **transmission et la reconstruction** de la Compréhension Clinique lors des Transitions entre Professionnels de Santé.

Ce contexte résout le problème fondateur de MedLink.

---

### Pourquoi ce contexte existe

Le Domain Atlas (§11, §12, §13, §14) établit que les Transitions créent mécaniquement un vide de Compréhension Clinique. Ce vide ne peut être comblé que par la Reprise de Contexte — un acte cognitif actif de reconstruction.

Les règles qui gouvernent cette transmission (quand une Transition se produit, comment la Reprise est initiée, comment les Lacunes sont identifiées) forment un modèle centré sur la **continuité entre acteurs**.

Ce modèle est distinct du modèle de production et du modèle de préservation. Dans ce contexte, les Contributions ne sont pas des objets produits (Contribution Clinique) ni des entrées chronologiques (Parcours de Soins) — elles sont des **sources d'information** mobilisées pour reconstruire une compréhension.

La Lacune — concept qui n'existe que dans ce contexte — est la preuve que la continuité a échoué localement. Elle n'existe ni dans la production ni dans la préservation : elle émerge uniquement lors de la Reprise.

Ce contexte est l'implémentation directe du Théorème Central (M-003 §12) :

> *"Toute organisation dans laquelle plusieurs professionnels interviennent successivement sur un même patient nécessite un mécanisme explicite de préservation et de transmission de la Compréhension Clinique."*

**Fondation théorique :**

- P-001 §3 — L'asymétrie structurelle crée des Transitions nécessaires
- P-001 §4 — Le coût de reconstruction est réel, mesurable, et évitable
- CW-001 §3 à §8 — Les 6 phases de la Reprise de Contexte
- M-003 §8.5 — Coût de reconstruction, perte irréductible
- M-003 §12 — Théorème Central : preuve formelle du besoin
- Domain Atlas §11 — Transition : événement structurel
- Domain Atlas §12 — Reprise de Contexte : acte cognitif actif
- Domain Atlas §13 — Modèle de Situation : représentation mentale produite
- Domain Atlas §14 — Lacune : vide identifié et délimité

---

### Responsabilités

| Responsabilité | Description |
|---|---|
| Enregistrer | Documenter qu'une Transition est en cours entre deux Professionnels de Santé |
| Déclencher | Initier la Reprise de Contexte pour le Professionnel entrant |
| Assembler | Identifier et ordonner les Contributions les plus pertinentes pour la Reprise |
| Identifier les Lacunes | Détecter les informations attendues et absentes dans le Parcours |
| Clôturer | Enregistrer qu'une Transition est résolue (la Reprise a produit un Modèle de Situation suffisant) |

---

### Agrégats

#### Transition *(Aggregate Root)*

| Attribut | Type | Invariant |
|---|---|---|
| `id` | TransitionId | Immuable |
| `patientId` | PatientId | Immuable |
| `professionnelSortantId` | PractitionerId | Immuable. Null si premier contact. |
| `professionnelEntrantId` | PractitionerId | Immuable après enregistrement |
| `ouverteLe` | Timestamp | Immuable |
| `statut` | Enum(Ouverte, EnCours, Clôturée) | Transitions de statut unidirectionnelles |
| `contributionDeTransmission` | ContributionId? | Contribution produite explicitement pour la Transition |
| `clôturéLe` | Timestamp? | Null tant que non clôturée |

**Invariants de l'agrégat :**

1. Une Transition ne peut pas être annulée une fois ouverte.
2. Une Transition ne peut être clôturée que depuis l'état `EnCours`.
3. La `contributionDeTransmission` est produite dans le contexte Contribution Clinique — ce contexte en reçoit seulement la référence.

#### Reprise de Contexte *(Agrégat secondaire, dans le même contexte)*

| Attribut | Type | Invariant |
|---|---|---|
| `id` | RepriseId | Immuable |
| `transitionId` | TransitionId | Lien avec la Transition déclenchante |
| `initiéePar` | PractitionerId | Le Professionnel effectuant la Reprise |
| `initiéeLe` | Timestamp | Immuable |
| `lacunesIdentifiées` | Lacune[] | Ensemble croissant — jamais réduit |
| `statut` | Enum(EnCours, Suffisante, Incomplète) | Suffisante = Seuil de suffisance atteint |

**Lacune** (Value Object dans Reprise de Contexte) :

| Attribut | Type |
|---|---|
| `id` | LacuneId |
| `description` | Texte libre — ce qui manque, identifié par le Professionnel |
| `criticité` | Enum(Bloquante, Importante, Mineure) |
| `récupérable` | Boolean — peut-elle être comblée immédiatement ? |

**Invariants :**

1. Une Reprise de Contexte ne peut exister sans Transition associée.
2. Un Modèle de Situation n'est jamais stocké (état cognitif interne — M-003 §13).
3. Une Lacune identifiée ne peut pas être supprimée — seulement résolue (si l'information est retrouvée).

---

### Services domaine

| Service | Rôle |
|---|---|
| `AssembleurDeReprise` | À partir d'un `TransitionId` et d'un `PatientId`, consulte le Parcours de Soins et retourne les Contributions ordonnées selon leur pertinence pour la Reprise (Signal vs. Bruit). |
| `DetecteurDeLacunes` | Analyse les Contributions disponibles et identifie les informations structurellement attendues mais absentes (Incertitudes non documentées, Intentions ouvertes sans résolution, transitions de soins sans Contribution). |

*Note : le `AssembleurDeReprise` est un Application Service qui lit depuis le Parcours de Soins — il ne modifie pas le Parcours.*

---

### Événements publiés

| Événement | Déclencheur | Destinataires |
|---|---|---|
| `TransitionOuverte` | Enregistrement d'une nouvelle Transition | Workspace, Professionnel entrant (notification) |
| `TransitionClôturée` | Clôture d'une Transition | Workspace, historique |
| `RepriseContexteInitiée` | Début d'une Reprise de Contexte | Workspace |
| `LacuneIdentifiée` | Identification d'une Lacune lors de la Reprise | Workspace, Professionnel sortant (notification si récupérable) |

---

### API publiques

| Méthode | Chemin | Description |
|---|---|---|
| `POST` | `/patients/{patientId}/transitions` | Ouvrir une Transition |
| `PATCH` | `/patients/{patientId}/transitions/{id}/cloture` | Clôturer une Transition |
| `POST` | `/patients/{patientId}/transitions/{id}/reprises` | Initier une Reprise de Contexte |
| `GET` | `/patients/{patientId}/transitions/{id}/reprises/{repriseId}/lacunes` | Lister les Lacunes identifiées |
| `POST` | `/patients/{patientId}/transitions/{id}/reprises/{repriseId}/lacunes` | Identifier une Lacune |

---

### Dépendances

| Contexte | Nature | Direction |
|---|---|---|
| **Contribution Clinique** | Souscrit aux événements pour détecter les Contributions de Transmission | ← entrant (événements) |
| **Parcours de Soins** | Lit les Contributions disponibles lors d'une Reprise de Contexte | → lecture (Application Service) |
| Identity Platform | Valide les identités du Professionnel sortant, entrant, et du Patient | → entrant |

Ce contexte est **le plus en aval** de la Clinical Platform. Il dépend des deux autres contextes cliniques.

---

## 5. Contextes externes

Ces contextes ne sont pas définis par le Domain Atlas mais sont des dépendances nécessaires.

### Identity Platform

| Attribut | Valeur |
|---|---|
| **Rôle** | Fournir les identités des acteurs (PatientId, PractitionerId) |
| **Relation** | Fournisseur / Client — les trois contextes cliniques consomment les identités |
| **Intégration** | Anti-Corruption Layer — les contextes cliniques maintiennent leur propre vue locale des acteurs |

### Platform Kernel

| Attribut | Valeur |
|---|---|
| **Rôle** | Fournir le Work Context actif pour chaque prise en charge |
| **Relation** | Noyau / Extensions — les contextes cliniques s'inscrivent dans le Kernel sans le modifier |
| **Intégration** | ContexteId transmis avec chaque Contribution |

---

## 6. Context Map

### Diagramme

```
     Identity Platform              Platform Kernel
           |                              |
           | PatientId, PractitionerId    | ContexteId
           ↓                              ↓
+--------------------------------+
|    Contribution Clinique       |
|                                |
|  Professionnel de Santé        |
|  Contribution Clinique         |
|  Situation Clinique            |
|  Raisonnement Clinique         |
|  Hypothèse Clinique            |
|  Incertitude Clinique          |
|  Intention Clinique            |
|  Perspective                   |
+--------------------------------+
           |
           | ContributionCliniqueCreée
           | ContributionCliniqueAmendée
           ↓
+--------------------------------+         External Systems
|     Parcours de Soins          |←------------ (ACL)
|                                |
|  Patient                       |
|  Parcours de Soins             |
+--------------------------------+
           |
           | ParcoursDeSoinsInitié
           | ContributionCliniqueIntégrée
           |
           ↓  (lecture directe via Application Service)
+--------------------------------+
|     Continuité Clinique        |
|                                |
|  Transition                    |
|  Reprise de Contexte           |
|  Lacune                        |
+--------------------------------+
           |
           | TransitionOuverte
           | RepriseContexteInitiée
           | LacuneIdentifiée
           ↓
       [Workspace / Projections]
```

### Relations entre contextes

| Source | Cible | Pattern | Nature |
|---|---|---|---|
| Contribution Clinique | Parcours de Soins | Customer / Supplier | Événement : `ContributionCliniqueCreée` |
| Contribution Clinique | Continuité Clinique | Customer / Supplier | Événement : `ContributionCliniqueCreée` |
| Parcours de Soins | Continuité Clinique | Conformiste | Lecture directe (Application Service) |
| Identity Platform | Tous contextes cliniques | Fournisseur / Client + ACL | Identités des acteurs |

---

## 7. Règles de dépendance

Ces règles découlent du découpage — elles ne sont pas des choix arbitraires.

**Règle 1 — Direction des dépendances**

`Contribution Clinique` ne dépend d'aucun contexte clinique.
`Parcours de Soins` dépend de `Contribution Clinique` (événements entrants).
`Continuité Clinique` dépend de `Parcours de Soins` et `Contribution Clinique`.

Aucune dépendance inverse n'est autorisée.

**Règle 2 — Non-duplication de modèles**

Une Contribution dans le contexte `Parcours de Soins` est une *entrée chronologique*.
La même Contribution dans le contexte `Contribution Clinique` est un *objet complexe avec auteur et dimensions*.
Les deux modèles coexistent sans jamais partager de classes.

**Règle 3 — Événements comme seul canal inter-contextes**

La communication entre `Contribution Clinique` et `Parcours de Soins` passe uniquement par des événements.
Aucune importation de classe entre ces deux contextes.

**Règle 4 — Lecture par Application Service**

`Continuité Clinique` lit le `Parcours de Soins` via un Application Service — jamais en requêtant directement les tables du Parcours.

**Règle 5 — Non-stockage du Modèle de Situation**

Le Modèle de Situation (Domain Atlas §13) est un état cognitif. Il ne fait l'objet d'aucune persistance.

---

## 8. Ce que ce découpage ne couvre pas

Les éléments suivants ne sont pas dérivables du Domain Atlas V1 et sont donc hors périmètre de ce document.

| Élément | Raison d'exclusion |
|---|---|
| Workspace / Présentation | Projection — pas un Bounded Context (CLAUDE.md : "Projections are disposable") |
| Search / Discovery | Composant architectural — pas un modèle métier |
| Governance / Audit | Cross-cutting concern — pas dérivable du Domain Atlas |
| External Clinical Exchange (ACL) | Composant technique — couche d'isolation, pas un contexte métier |
| Notification / Alerting | Dépend d'une décision produit non encore fondée dans le Domain Atlas |
| Clinical Activity (UL v2.0) | Concept de l'UL v2.0 non encore intégré au Domain Atlas V1 |
| Care Record (UL v2.0) | Remplacé par Parcours de Soins dans le Domain Atlas V1 |

---

## 9. Relation avec SD-004

SD-004 (v1.0) identifiait deux Bounded Contexts :

| SD-004 | SD-005 | Évolution |
|---|---|---|
| Clinical Work | Contribution Clinique | Renommé et fondé dans le Domain Atlas |
| Clinical Knowledge | Parcours de Soins | Renommé et fondé dans le Domain Atlas |
| *(absent)* | Continuité Clinique | **Nouveau** — émergent des concepts Transition, Reprise, Lacune du Domain Atlas |

Les règles d'intégration de SD-004 (§6) restent valides et sont reprises et étendues dans ce document.

---

## 10. Décisions ouvertes

Ces décisions appartiennent à la Software Architecture, pas au découpage métier.

| Décision | Statut |
|---|---|
| Implémentation des bus de commandes et d'événements | Ouvert — voir ADR-SA-013 pour les bases |
| Stratégie de persistence par contexte | Ouvert — voir ADR-SA-009 |
| Exposition API (versioning, format) | Ouvert |
| Limites des modules Symfony pour chaque contexte | Ouvert |
| ACL pour les systèmes cliniques externes | Ouvert |

---

*Ce document est la référence métier pour le découpage de la Clinical Platform. Toute décision d'architecture qui modifie la frontière d'un Bounded Context doit d'abord être justifiée ici par une modification du Domain Atlas.*
