# ADR-SA-014 — BC-1 Aggregate Model : Clinical Activity & Clinical Contribution

**Type :** Software Architecture Decision
**Statut :** Accepted
**Date :** 2026-07-28
**Affine :** ADR-0007 · ADR-0008
**Synchronisation requise :** SD-005

---

## Bloc de traçabilité domaine

### Principes concernés

| Document | Pertinence |
|---|---|
| ADR-0007 — Clinical Contribution Relationships | La même Contribution est référencée par plusieurs Clinical Activities avec des rôles distincts |
| ADR-0008 — Clinical Work and Clinical Knowledge | Identification des deux sous-domaines — non de deux Bounded Contexts |
| DA-010 — Clinical Activity | Définition formelle : modes, invariants, cardinalité 0..n |
| CAL-001 — Clinical Activity Lifecycle | 7 phases, invariants CAL-I-001 à CAL-I-007 |

### Concepts métier concernés

- Clinical Activity (DA-010, ADR-0008, CAL-001)
- Clinical Contribution (Domain Atlas V1 §4)
- Clinical Draft (CAL-001 Phase 5)

### Invariants concernés

- **CAL-I-003 :** une Clinical Contribution ne peut exister qu'à l'issue d'une Clinical Activity et d'un acte de validation explicite du Practitioner
- **CAL-I-007 :** la fermeture d'une Clinical Activity est toujours une décision explicite — jamais automatique
- **DA-010 Invariant 1 :** toute Clinical Contribution est produite dans le contexte d'une Clinical Activity
- **DA-010 Invariant 2 :** une Clinical Activity peut produire 0..n Clinical Contributions
- **DA-010 Invariant 3 :** un amendement est produit dans le contexte d'une nouvelle Clinical Activity
- **SD-005 Invariant 1 :** une Clinical Contribution est immuable après création
- **SD-005 Invariant 2 :** une Clinical Contribution ne peut pas être supprimée
- **SD-005 Invariant 3 :** l'auteur d'une Clinical Contribution est immuable après création

---

## Contexte

ADR-0008 identifie *Clinical Work* et *Clinical Knowledge* comme deux sous-domaines distincts du domaine clinique.

Cette identification a été interprétée dans SD-005 comme pouvant requérir deux Bounded Contexts séparés, un par sous-domaine. Cette interprétation est incorrecte.

Un sous-domaine est une décomposition de l'espace du problème. Un Bounded Context est une frontière de cohérence du modèle dans l'espace de la solution. Ces deux notions opèrent à des niveaux d'abstraction différents et ne se correspondent pas terme à terme.

Par ailleurs, DA-010 a formalisé Clinical Activity comme concept de domaine. L'analyse du modèle de relation d'ADR-0007 et des invariants de Clinical Contribution a établi des contraintes non ambiguës sur le positionnement de Clinical Contribution dans le modèle.

Cette ADR formalise le modèle d'agrégats de BC-1 comme décision définitive.

---

## Décision

### 1. BC-1 implémente le sous-domaine Clinical Work

BC-1 est le Bounded Context de la production clinique.

Sa frontière linguistique englobe les concepts dont la cohérence est gouvernée par l'acte de production clinique : la conduite du travail clinique (Clinical Activity), la formalisation transitoire de son résultat (Clinical Draft), et le résultat validé, immuable (Clinical Contribution).

BC-1 implémente le sous-domaine *Clinical Work* tel que défini par ADR-0008.

Il n'est pas découpé en Bounded Contexts séparés pour *Clinical Work* et *Clinical Knowledge*. La décomposition en sous-domaines n'impose pas de décomposition correspondante en Bounded Contexts.

**Le critère de découpage d'un Bounded Context est la cohérence du modèle et du langage — non la taxonomie des sous-domaines.**

---

### 2. BC-1 contient deux Aggregate Roots indépendants

BC-1 contient exactement deux Aggregate Roots :

- **Clinical Activity**
- **Clinical Contribution**

Ces deux Aggregate Roots sont indépendants. Ils ne sont pas hiérarchisés. Ils ne sont pas imbriqués.

**Clinical Contribution n'est pas une Entity de Clinical Activity.**

**Clinical Activity n'est pas propriétaire de Clinical Contribution.**

---

### 3. Justification du statut d'Aggregate Root de Clinical Contribution

Les propriétés suivantes de Clinical Contribution sont incompatibles avec le statut d'Entity et établissent son statut d'Aggregate Root :

**a) Référencement inter-agrégat**

ADR-0007 établit que la même Clinical Contribution est référencée depuis plusieurs Clinical Activities avec des rôles distincts : une Prescription produite par un médecin généraliste est l'objet de la branche `produces` dans sa Clinical Activity, et l'objet d'une relation `consumes(role=Enabling)` dans la Clinical Activity du kinésithérapeute.

En DDD, une Entity appartient à exactement un Aggregate Root. Le référencement d'une même Entity depuis plusieurs agrégats est structurellement impossible. Ce seul fait interdit le statut d'Entity.

**b) Référencement externe depuis les Bounded Contexts adjacents**

BC-2 (Parcours de Soins) référence la Clinical Contribution directement par `ContributionId`, sans navigation via Clinical Activity. BC-3 (Continuité Clinique) fait de même via `contributionDeTransmission: ContributionId?`. La chaîne d'amendement maintient `amendeDe: ContributionId?` — une relation entre deux Clinical Contributions produites dans deux Clinical Activities différentes.

Ces références confirment que Clinical Contribution doit être adressable comme agrégat autonome depuis l'extérieur de BC-1.

**c) Autonomie temporelle**

Clinical Contribution survit à la fermeture de la Clinical Activity qui l'a produite (CAL-001 Phase 7). Une Entity ne peut pas survivre à son Aggregate Root. La durée de vie d'une Clinical Contribution n'est pas bornée par celle de la Clinical Activity.

**d) Invariants auto-portés**

Chaque invariant de Clinical Contribution — immutabilité, non-suppression, intégrité de l'auteur, intégrité de la chaîne d'amendements — est intrinsèque à la Clinical Contribution et s'applique indépendamment de l'état de la Clinical Activity. Aucun de ces invariants n'est enforceable par Clinical Activity après la transaction de production.

**e) Chaîne d'amendements inter-activités**

La référence `amendeDe` lie deux Clinical Contributions produites dans deux Clinical Activities distinctes (DA-010 Invariant 3). Aucune Clinical Activity ne possède les deux extrémités de cette relation. Seule Clinical Contribution comme Aggregate Root peut posséder et enforcer sa propre chaîne d'amendements.

---

### 4. Statut de Clinical Draft

Clinical Draft (CAL-001 Phase 5) est une Entity appartenant à Clinical Activity.

Il existe uniquement dans le lifecycle de la Clinical Activity qui l'a créé. Il est mutable, privé au Practitioner responsable, sans valeur clinique ou médico-légale avant validation. Il n'est jamais référencé depuis l'extérieur de Clinical Activity.

Clinical Draft n'a pas d'identité indépendante. Son lifecycle est coterminous avec celui de la Clinical Activity.

---

### 5. Répartition des responsabilités

#### Clinical Activity est responsable de

- La conduite du travail clinique à travers les 7 phases de CAL-001
- L'enforcement des invariants de lifecycle : CAL-I-001, CAL-I-007
- La possession et la gestion du Clinical Draft (Phase 5) jusqu'à la validation
- L'enforcement de la précondition de production : acte de validation explicite du Practitioner (CAL-I-003)
- La déclaration de son mode : Construction, Révision, Transmission (DA-010)
- L'enforcement de la cardinalité : une Clinical Activity peut produire 0..n Clinical Contributions (DA-010 Invariant 2)

#### Clinical Contribution est responsable de

- Son identité (ContributionId)
- Son immutabilité après création
- L'intégrité de son auteur
- L'intégrité de sa chaîne d'amendements (référence `amendeDe`)
- Sa non-suppression
- Ses contraintes de dimensionnalité (au moins une dimension clinique — SD-005)
- L'ensemble des invariants applicables après la transaction de production

**Aucune responsabilité ne traverse cette frontière.** Clinical Activity n'enforce pas les invariants post-production sur Clinical Contribution. Clinical Contribution ne gère pas les préconditions de sa production.

---

### 6. Relation entre les deux Aggregate Roots

Clinical Activity produit Clinical Contribution.

Cette relation est une relation métier, non une relation d'appartenance d'agrégat.

La transaction de production — initiée à la Phase 6 (Contribution) de CAL-001 — implique les deux Aggregate Roots. À l'issue de cette transaction, les deux Aggregate Roots sont indépendants. Clinical Activity ne conserve aucune autorité sur la Clinical Contribution produite.

Le modèle de relation d'ADR-0007 (consumes : Enabling, Informative ; produces) est exprimé au niveau de l'association entre Clinical Activity et Clinical Contribution. Cette association est possédée par BC-1 en tant que Bounded Context qui contient les deux Aggregate Roots.

---

### 7. Synchronisation documentaire requise dans SD-005

Les modifications suivantes de SD-005 sont requises pour aligner avec cette décision :

**7.1** La section §2 "Aggregate Root" de BC-1 doit lister Clinical Activity comme Aggregate Root principal et Clinical Contribution comme Aggregate Root secondaire. Clinical Draft doit être listé comme Entity de Clinical Activity.

**7.2** La section §2 "Invariants" de BC-1 doit incorporer les invariants CAL-I-001, CAL-I-003, CAL-I-007 et les invariants DA-010 1, 2, et 3.

**7.3** La section §8 "Ce que ce découpage ne couvre pas" doit supprimer la ligne indiquant que Clinical Activity n'est pas encore intégrée au Domain Atlas V1. DA-010 résout ce point.

**7.4** La section §2 "Événements publiés" doit être étendue pour inclure les événements du lifecycle de Clinical Activity, au minimum : `ClinicalActivityOpened`, `ClinicalActivityClosed`. Ces événements transportent l'attribut `mode` (Construction, Révision, Transmission) issu de DA-010. Cet attribut résout le mécanisme par lequel BC-3 identifie une Contribution de Transmission dans `ContributionCliniqueCreée`.

---

## Règles normatives

Les règles suivantes sont normatives et n'admettent aucune exception.

| # | Règle |
|---|---|
| R-01 | BC-1 contient exactement deux Aggregate Roots : Clinical Activity et Clinical Contribution. |
| R-02 | Clinical Contribution n'est jamais modélisée comme Entity de Clinical Activity. |
| R-03 | Clinical Draft est toujours modélisé comme Entity de Clinical Activity. |
| R-04 | Les références externes à Clinical Contribution utilisent toujours `ContributionId` directement, sans navigation via Clinical Activity. |
| R-05 | La relation de production (Clinical Activity produit Clinical Contribution) est exprimée au niveau de l'association, non comme relation d'appartenance d'agrégat. |
| R-06 | Le mode d'une Clinical Activity (Construction, Révision, Transmission) est un attribut de Clinical Activity, non de Clinical Contribution. |
| R-07 | La chaîne d'amendements est possédée par Clinical Contribution comme Aggregate Root — non par une Clinical Activity. |
| R-08 | Toute modification du modèle d'agrégats de BC-1 requiert une ADR supersédant la présente décision. |

---

## Références

| Document | Pertinence |
|---|---|
| ADR-0007 | Modèle de rôle : référencement inter-activités de Clinical Contribution |
| ADR-0008 | Identification des sous-domaines : Clinical Work et Clinical Knowledge |
| DA-010 | Définition formelle de Clinical Activity : modes, invariants, cardinalité 0..n |
| CAL-001 | Lifecycle de Clinical Activity : 7 phases, invariants CAL-I-001 à CAL-I-007 |
| SD-005 | Définition actuelle de BC-1 — requiert synchronisation |
| ADR-000 | Standards ADR et exigences de traçabilité |
