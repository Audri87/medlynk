# ADB-001 — Architecture Decision Backlog — Domain Events

**Version :** 1.2
**Statut :** Accepted
**Date :** 2026-07-28
**Gouvernance :** Les items ouverts sont des améliorations documentaires — ils ne bloquent pas Architecture Freeze v1.0. Ce document n'est rouvert que si une décision d'architecture change.

**État au gel — 2026-07-28 :**
Items Haute criticité : tous `Resolved` (ADB-DE-001 → ADR-SA-015 · ADB-DE-004 → ADR-SA-016).
Items Normale criticité restants : ADB-DE-002, ADB-DE-003, ADB-DE-007, ADB-DE-008 — non-bloquants, différés après Architecture Freeze v1.0.
**Périmètre :** Core Domain — Clinical Platform (BC-1, BC-2, BC-3)
**Source :** Extrait de DE-001 v1.1
**Référence :** DE-001 · ADR-SA-014 · SD-005 · CM-001

---

## Objet

Ce document recense les questions architecturales ouvertes relatives aux Domain Events du Core Domain.

Ces questions ont été identifiées lors de la rédaction de DE-001. Elles n'ont pas encore fait l'objet d'une décision formelle. Elles ne bloquent pas l'implémentation sauf mention explicite dans la colonne "Bloque".

Toute décision fermant un item de ce backlog doit être formalisée dans un ADR ou dans DE-001 directement, puis l'item doit être marqué **Résolu** avec référence au document décisionnel.

---

## Statuts possibles

| Statut | Signification |
|---|---|
| `Open` | Question identifiée, non encore analysée |
| `Under Review` | Discussion ouverte, options en cours d'évaluation |
| `Decided` | Décision prise, ADR ou mise à jour documentaire en cours |
| `Resolved` | ADR ou document mis à jour — item fermé |
| `Deferred` | Question reportée délibérément, hors périmètre actuel |

---

## Graphe de dépendances

Les flèches indiquent une relation de blocage : une décision aval ne peut pas être figée tant que la décision amont n'est pas résolue.

```
ADB-DE-008 (Nommage Aggregate Root)
       │
       ▼
ADB-DE-002 (Nommage E-03 / E-04)

ADB-DE-001 ✓ Resolved — ADR-SA-015 (clinicalActivityId dans E-01)

ADB-DE-004 (Payloads BC-3 formalisés) ← débloqué
       │
       ├──▶ DE-001 E-07 stabilité figée
       ├──▶ DE-001 E-08 stabilité figée
       └──▶ DE-001 E-09 stabilité figée

ADB-DE-003 (Nommage E-06) — indépendant
ADB-DE-005 ✓ Resolved — aucun événement
ADB-DE-006 ✓ Resolved — aucun événement
ADB-DE-007 (Séquencement E-05/E-06) — indépendant
```

**Lecture :** ADB-DE-001, ADB-DE-005, ADB-DE-006 sont résolus. ADB-DE-004 est le seul item `Haute` criticité encore ouvert — il n'est plus bloqué par aucune dépendance. ADB-DE-002 attend ADB-DE-008. ADB-DE-003 et ADB-DE-007 sont indépendants et non-bloquants.

---

## Format de chaque item

```
ID             : ADB-DE-XXX
Statut         : Open | Under Review | Decided | Resolved | Deferred
Titre          :
Événements     :
Documents      :
Criticité      : Bloquante | Haute | Normale
Bloque         : [IDs bloqués] | —
Owner          : Architecture | Domain | Product
Exit Criteria  :
---
Contexte       :
Question       :
Options        :
Pourquoi ouvert :
```

---

## Items ouverts

---

### ADB-DE-001 — Corrélation Contribution de Transmission dans BC-3

**Statut :** `Resolved`
**Résolution :** ADR-SA-015 — 2026-07-28
**Criticité : Haute**
**Événements :** E-01 `ContributionCliniqueCreée` · E-04 `ClinicalActivityClosed`
**Documents :** SD-005 §2 BC-3 · ADR-SA-014 §7.4 · CM-001
**Bloque :** ~~ADB-DE-004~~
**Owner :** Architecture

**Exit Criteria :**
- [x] Option 1 (contributionIds dans E-04) écartée — décision d'architecture 2026-07-28
- [x] Option 2 retenue (clinicalActivityId dans E-01) — formalisée dans ADR-SA-015
- [x] Le payload de E-01 est mis à jour dans DE-001 v1.3
- [ ] SD-005 §2 BC-1 "Format des événements" est mis à jour — synchronisation documentaire non-bloquante

---

**Contexte :**

ADR-SA-014 §7.4 déclare que `ClinicalActivityClosed` (E-04) avec `mode = Transmission` est le signal que BC-3 attend pour associer les Contributions produites à une Transition ouverte.

E-01 `ContributionCliniqueCreée` ne transporte pas `clinicalActivityId`. BC-3 reçoit chaque Contribution individuellement sans savoir à quelle Clinical Activity elle appartient, et ne peut pas constituer de manière fiable la liste des Contributions productrices d'une Transmission.

**Décision partielle — 2026-07-28 :**

**L'option 1 (ajouter `contributionIds` à E-04) est écartée définitivement.**

Fondements DDD :

- **Aggregate Root Ownership** : `ClinicalActivity` ne possède pas `ClinicalContribution`. Un événement d'un AR ne peut transporter que l'information que cet AR possède. La liste des `contributionIds` est l'état d'un autre AR.
- **Transactional Boundary** : chaque Contribution est produite dans une transaction indépendante. Pour que `ClinicalActivity` connaisse ses `contributionIds` à la clôture, elle devrait être modifiée dans chaque transaction de création de Contribution — violation des frontières transactionnelles — ou maintenir une cohérence éventuelle interne injustifiée.
- **Information Ownership** : l'information "cette Contribution a été produite dans le contexte de cette ClinicalActivity" appartient à `ClinicalContribution`, pas à `ClinicalActivity`. DA-010 Invariant 1 est formulé du point de vue de la Contribution. La relation inverse est une requête dérivée, pas un invariant de `ClinicalActivity`.
- **Event Autonomy** : les consommateurs directs de E-04 (Workspace, BC-3) ont besoin du `mode` et du `patientId` — tous deux possédés par `ClinicalActivity`. Ils n'ont pas besoin des `contributionIds` pour agir sur le signal de clôture.

**Option retenue : option 2** — ajouter `clinicalActivityId` au payload de E-01. Chaque Contribution se déclare dans son propre événement comme produite dans un contexte donné. BC-3 reconstitue la liste par agrégation de E-01 reçus entre E-03 et E-04 pour la même `clinicalActivityId`.

Cette option respecte l'ownership : c'est `ClinicalContribution` qui porte l'information de son contexte de production, conformément à DA-010 Invariant 1.

**Question résiduelle (à formaliser en ADR-SA) :**

Ajouter `clinicalActivityId` au payload de E-01 est une modification additive du contrat de E-01. BC-2 reçoit E-01 : doit-il utiliser cette information ? L'impact sur BC-2 doit être évalué dans l'ADR.

**Options écartées et raisons :**

1. ~~`contributionIds` dans E-04~~ — écartée : violation de l'AR ownership (voir décision ci-dessus)
3. Événement dédié `ContributionDeTransmissionDéclarée` — non retenu : crée un nouveau concept sans justification dans le Domain Atlas
4. Requête synchrone BC-3 → BC-1 — non retenu : viole ADR-0014 (Domain Events shall never cross platform boundaries) et l'autonomie des BCs

---

### ADB-DE-002 — Nommage anglais de E-03 et E-04

**Statut :** `Open`
**Criticité : Normale**
**Caractère bloquant : Non**
**Nature : Dette documentaire** — absence de politique de langue dans UL-001. Pas une dette d'architecture (aucun impact sur les contrats, le routing, ou les invariants). Pas une simple convention (touche le Langage Ubiquitaire).
**Événements :** E-03 `ClinicalActivityOpened` · E-04 `ClinicalActivityClosed`
**Documents :** DE-001 · UL-001 · SD-005
**Bloque :** —
**Owner :** Architecture

**Exit Criteria :**
- [ ] ADB-DE-008 résolu en priorité (la politique de langue des ARs détermine mécaniquement celle des événements)
- [ ] La convention de langue pour les événements est une conséquence d'ADB-DE-008 — pas une décision indépendante

---

**Contexte :**

Tous les Domain Events du Core Domain sont nommés en français sauf E-03 et E-04, qui utilisent l'anglais. Cette incohérence est cohérente en elle-même : les événements E-03 et E-04 suivent la langue de leur Aggregate Root (`Clinical Activity`, nommé en anglais dans DA-010 et ADR-SA-014). L'incohérence réelle est donc entre les langues des Aggregate Roots au sein de BC-1, non entre les événements pris isolément.

**Question :**

La politique de langue des Aggregate Roots (ADB-DE-008) détermine la réponse. Ce sous-item ne peut pas être résolu indépendamment.

**Options :** toutes découlent d'ADB-DE-008 — voir cet item.

**Risque de propagation :**

Sans résolution d'ADB-DE-008, chaque nouvel AR introduit dans le modèle génère un choix de langue implicite. L'incohérence se propagera avec l'extension du modèle aux futures plateformes (Learning, Conference, Collaboration).

---

### ADB-DE-003 — Nommage ambigu de E-06 `ContributionCliniqueIntégrée`

**Statut :** `Open`
**Criticité : Normale**
**Événements :** E-06 `ContributionCliniqueIntégrée`
**Documents :** DE-001 · SD-005 §2 BC-2 · UL-001
**Bloque :** —
**Owner :** Architecture

**Exit Criteria :**
- [ ] La décision de renommer ou de conserver est formalisée dans UL-001 ou DE-001
- [ ] Si renommé : DE-001, SD-005, et CM-001 sont mis à jour

---

**Contexte :**

E-06 est publié par l'Aggregate Root **Parcours de Soins** de BC-2, mais son nom commence par `ContributionClinique` — préfixe de l'Aggregate Root de BC-1. Un lecteur peut confondre la responsabilité.

**Question :**

Faut-il renommer E-06 pour indiquer clairement que la responsabilité est dans BC-2 ?

**Options :**

1. Conserver le nom actuel. L'ambiguïté est acceptable si les namespaces d'événements sont documentés.
2. Renommer : `ParcoursDeSoinsEnrichiParContribution` ou `ContributionAjoutéeAuParcours`.

**Pourquoi ouvert :**

Décision de nommage structurante si la politique de namespace des événements n'est pas encore arrêtée.

---

### ADB-DE-004 — Payloads de E-07, E-08, E-09 non formellement spécifiés dans les sources

**Statut :** `Resolved`
**Résolution :** ADR-SA-016 — 2026-07-28
**Criticité : Haute**
**Événements :** E-07 `TransitionOuverte` · E-08 `TransitionClôturée` · E-09 `RepriseContexteInitiée`
**Documents :** SD-005 §2 BC-3 · CM-001
**Bloque :** ~~DE-001 E-07 stabilité~~ · ~~DE-001 E-08 stabilité~~ · ~~DE-001 E-09 stabilité~~
**Owner :** Architecture

**Exit Criteria :**
- [x] ADB-DE-001 résolu — ADR-SA-015
- [x] ADB-DE-005 résolu — aucun événement supplémentaire
- [x] ADB-DE-006 résolu — aucun événement supplémentaire
- [x] Gouvernance arrêtée : SD-005 (comportement métier) + ADR-SA-016 (contrats techniques) — pas SD-005 OU ADR, SD-005 ET ADR dans leurs rôles respectifs
- [x] Payloads de E-07, E-08, E-09 formalisés dans ADR-SA-016
- [x] DE-001 E-07, E-08, E-09 marqués "Stable"

---

**Décision de gouvernance :**

SD-005 décrit le comportement métier et la séquence des événements (Pourquoi).
ADR-SA-016 définit les contrats techniques — payload, version, compatibilité, consommateurs, ordering (Comment).
DE-001 reste la documentation de référence, non la source normative.

**Principe de payload minimal établi par ADR-SA-016 :**
Tout champ doit être justifié par un consommateur identifié ou un invariant métier. Un champ non consommé n'est pas publié.

---

### ADB-DE-005 — Transition Ouverte → EnCours sans Domain Event

**Statut :** `Resolved`
**Résolution :** Principe général — 2026-07-28
**Criticité : Normale**
**Événements :** E-07 `TransitionOuverte` · E-09 `RepriseContexteInitiée`
**Documents :** SD-005 §2 BC-3 · CAL-001
**Bloque :** ~~ADB-DE-004 (partiel)~~
**Owner :** Domain

---

**Décision :**

**Aucun Domain Event supplémentaire pour la transition `Ouverte → EnCours`.**

Principe appliqué : un changement d'état interne ne devient Domain Event que si (A) un consommateur externe doit y réagir sans pouvoir le déduire, ou (B) il représente un fait clinique médico-légalement traçable.

Condition A : `RepriseContexteInitiée` (E-09) capture déjà le signal que la Reprise a commencé. Aucun consommateur n'a besoin de savoir que la Transition est "EnCours" sans savoir simultanément que la Reprise est initiée. Le signal est redondant avec E-09.

Condition B : la transition d'état "EnCours" est un artefact du modèle logiciel — pas un fait clinique observable indépendamment du système. Un clinicien ne reconnaîtrait pas ce moment comme un acte médico-légal distinct.

La transition `Ouverte → EnCours` reste une transition interne à l'agrégat Transition, déclenchée en réaction à E-09, persistée comme état, lisible via requête.

---

### ADB-DE-006 — Absence d'événement de fin pour `RepriseContexteInitiée`

**Statut :** `Resolved`
**Résolution :** Principe général — 2026-07-28
**Criticité : Normale**
**Événements :** E-09 `RepriseContexteInitiée`
**Documents :** SD-005 §2 BC-3 · CAL-001 · ADR-0008
**Bloque :** ~~ADB-DE-004 (partiel)~~
**Owner :** Domain

---

**Décision :**

**Aucun Domain Event supplémentaire pour le terminal state de la Reprise de Contexte.**

Principe appliqué : identique à ADB-DE-005.

Condition A : la conséquence de la déclaration de suffisance — la Transition est résolue — est déjà capturée par `TransitionClôturée` (E-08). Aucun consommateur actuellement identifié ne doit réagir à "la Reprise est Suffisante" sans être déjà informé par "la Transition est Clôturée".

Condition B : la déclaration de suffisance est un jugement clinique de premier ordre (M-003 §12), mais sa trace médico-légale durable est la clôture de la Transition. `TransitionClôturée` en est l'événement certificateur. Le statut terminal de la Reprise est une information d'état interne, exposable via requête.

**Note prospective :** si dans le futur la distinction `Suffisante` / `Incomplète` déclenche une réaction dans BC-2, dans un système d'audit, ou dans un mécanisme d'alerte, le principe autorisera la publication de cet événement à ce moment-là. La décision est réversible — elle ne ferme pas la possibilité, elle refuse de la préempter.

---

### ADB-DE-007 — Ambiguïté de séquencement E-05 / E-06 lors de la première intégration

**Statut :** `Open`
**Criticité : Normale**
**Événements :** E-05 `ParcoursDeSoinsInitié` · E-06 `ContributionCliniqueIntégrée`
**Documents :** SD-005 §2 BC-2 · CM-001
**Bloque :** —
**Owner :** Architecture

**Exit Criteria :**
- [ ] Le comportement de BC-2 lors de la première intégration est formalisé (un événement ou deux)
- [ ] CM-001 est mis à jour avec le séquencement explicite
- [ ] La politique d'idempotence de BC-3 pour ce cas est documentée

---

**Contexte :**

Lors de la première intégration d'une Contribution, BC-2 peut émettre E-05 (`ParcoursDeSoinsInitié`) uniquement, ou E-05 puis E-06 (`ContributionCliniqueIntégrée`). Les deux comportements ont des conséquences différentes sur la réception dans BC-3.

**Question :**

Lors de la première intégration : BC-2 émet-il uniquement E-05, ou E-05 puis E-06 ?

**Options :**

1. Émettre uniquement E-05. BC-3 infère que la première Contribution est incluse.
2. Émettre E-05 puis E-06. Chaque Contribution reçoit un signal explicite, sans exception.
3. Fusionner E-05 et E-06 en un seul événement `ParcoursDeSoinsInitiéAvecPremièreContribution`.

**Pourquoi ouvert :**

Dépend de la politique d'idempotence et de la tolérance aux événements redondants dans BC-3. À traiter conjointement avec la politique de publication de BC-2.

---

### ADB-DE-008 — Nommage de l'Aggregate Root Clinical Activity en contexte francophone

**Statut :** `Open`
**Criticité : Normale**
**Événements :** E-03 `ClinicalActivityOpened` · E-04 `ClinicalActivityClosed`
**Documents :** DA-010 · ADR-SA-014 · UL-001
**Bloque :** ADB-DE-002
**Owner :** Architecture

**Exit Criteria :**
- [ ] UL-001 formalise la politique de langue pour les Aggregate Roots
- [ ] DA-010 et ADR-SA-014 sont mis à jour si le nom change
- [ ] ADB-DE-002 est traité en conséquence

---

**Contexte :**

L'Aggregate Root **Clinical Activity** est nommé en anglais. Tous les autres Aggregate Roots du Core Domain ont des noms en français : Contribution Clinique, Parcours de Soins, Transition, Reprise de Contexte.

**Question :**

Clinical Activity doit-elle être renommée `Activité Clinique` pour aligner sur la convention de nommage des autres Aggregate Roots ?

**Options :**

1. Renommer en `Activité Clinique`. Mettre à jour DA-010, ADR-SA-014, et les événements.
2. Conserver `Clinical Activity` et documenter l'exception dans UL-001.
3. Adopter explicitement l'anglais pour tous les Aggregate Roots et formaliser la politique dans UL-001.

**Pourquoi ouvert :**

La politique de langue du modèle n'est pas explicitement arrêtée dans UL-001. Décision structurante pour tous les futurs documents.

---

## Tableau de synthèse

| ID | Titre | Statut | Criticité | Bloque | Owner |
|---|---|---|---|---|---|
| ADB-DE-001 | Corrélation Contribution de Transmission BC-3 | `Resolved` | **Haute** | — | Architecture |
| ADB-DE-002 | Nommage anglais E-03 / E-04 | `Open` | Normale | — | Architecture |
| ADB-DE-003 | Nommage ambigu E-06 | `Open` | Normale | — | Architecture |
| ADB-DE-004 | Payloads BC-3 non formalisés dans les sources | `Resolved` | **Haute** | — | Architecture |
| ADB-DE-005 | Transition Ouverte → EnCours sans event | `Resolved` | Normale | — | Domain |
| ADB-DE-006 | Fin de Reprise de Contexte sans event | `Resolved` | Normale | — | Domain |
| ADB-DE-007 | Séquencement E-05 / E-06 première intégration | `Open` | Normale | — | Architecture |
| ADB-DE-008 | Nommage Aggregate Root Clinical Activity | `Open` | Normale | ADB-DE-002 | Architecture |

**Nœud critique :** ADB-DE-001 — sa résolution débloque ADB-DE-004, qui débloque la stabilisation finale de DE-001.

---

## Politique de résolution

Un item est considéré **Resolved** lorsqu'une décision formelle a été documentée dans :

- Un ADR (ADR-SA-xxx ou ADR-0xxx selon la nature)
- Ou une mise à jour de DE-001 si la décision porte uniquement sur un contrat de payload

L'item doit alors être mis à jour dans ce document avec : `Statut : Resolved` et la référence au document décisionnel.

Les items `Haute` criticité doivent être traités avant toute implémentation des Domain Events concernés.
