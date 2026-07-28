# ADR-SA-016 — Contrats d'événements BC-3 : E-07, E-08, E-09

**Type :** Software Architecture Decision
**Statut :** Accepted
**Date :** 2026-07-28
**Affine :** SD-005 §4 BC-3 · ADR-SA-015 · DE-001
**Résout :** ADB-DE-004

---

## Principe de gouvernance documentaire

Ce document établit la séparation de responsabilité suivante, applicable à tous les événements de la Clinical Platform :

| Document | Rôle | Question |
|---|---|---|
| **SD-005** | Comportement métier — séquence des événements, invariants, responsabilités des contextes | *Pourquoi cet événement existe-t-il ?* |
| **ADR-SA** | Contrat technique — payload, version, compatibilité, consommateurs, ordering | *Comment cet événement est-il défini et transporté ?* |
| **DE-001** | Documentation de référence consolidée | *Quelle est la règle aujourd'hui ?* |

SD-005 ne doit pas devenir une spécification de payload. Une ADR ne doit pas contenir de règles métier. DE-001 n'est pas une source normative — il reflète les décisions prises dans les ADR.

---

## Principe de payload minimal

**Tout champ publié dans un Domain Event doit satisfaire au moins un des critères suivants :**

1. **Un consommateur identifié** en a besoin pour accomplir sa mission, et ne peut pas le reconstituer sans query synchrone vers un autre contexte.
2. **Un invariant métier** impose sa présence dans l'événement pour garantir l'autonomie du consommateur ou la traçabilité médico-légale.

**Un champ est exclu si :**
- Aucun consommateur actuel ne l'utilise.
- Il appartient à un Aggregate Root différent de celui qui publie l'événement.
- Il peut être reconstitué par le consommateur depuis son propre état ou depuis un événement antérieur déjà reçu.

Ce principe s'applique à tous les événements de la Clinical Platform. Toute demande d'ajout d'un champ doit produire une justification explicite `Owner × Consumer × Justification`.

---

## Bloc de traçabilité domaine

### Invariants métier concernés

| Invariant | Source | Pertinence |
|---|---|---|
| Une Transition ne peut pas être annulée une fois ouverte | SD-005 Invariant 1 BC-3 | Fonde la valeur médico-légale de E-07 |
| Une Transition ne peut être clôturée que depuis l'état EnCours | SD-005 Invariant 2 BC-3 | Fonde le cycle de vie et E-08 |
| Une Reprise de Contexte ne peut exister sans Transition associée | SD-005 Invariant 1 Reprise | Fonde `transitionId` obligatoire dans E-09 |
| Un Modèle de Situation n'est jamais stocké | SD-005 Invariant 2 Reprise | Exclut tout état cognitif du payload |

---

## Contrats d'événements

---

### E-07 — `TransitionOuverte`

**Publisher :** `Transition` (Aggregate Root, BC-3)
**Version :** 1.0

#### Payload

| Champ | Type | Owner | Consumer | Justification |
|---|---|---|---|---|
| `transitionId` | TransitionId | Transition | BC-3 · Workspace | Identité de l'AR — clé d'idempotence pour tous les consommateurs |
| `patientId` | PatientId | Transition | BC-3 · Workspace | Routage vers le bon Patient ; BC-3 corrèle avec le Parcours de Soins du Patient |
| `professionnelSortantId` | PractitionerId? | Transition | Workspace · Integration Layer | Affichage et notification du Professionnel sortant ; nullable pour premier contact (SD-005) |
| `professionnelEntrantId` | PractitionerId | Transition | Workspace · Integration Layer | Notification du Professionnel entrant — il doit être identifié à l'ouverture (invariant Transition) |
| `ouverteLe` | Timestamp | Transition | Audit · Workspace | Moment irréversible du transfert de responsabilité — traçabilité médico-légale |

**Champs exclus et raisons :**

| Champ envisagé | Raison d'exclusion |
|---|---|
| `contributionDeTransmission` | Null à l'ouverture (SD-005) — n'existe pas encore |
| `statut` | Redondant — toujours "Ouverte" à la publication |
| `clôturéLe` | Null à l'ouverture |

#### Compatibilité
Première version — pas de contrainte de rétrocompatibilité.

#### Ordering
Aucune contrainte d'ordre strict avec E-09 (`RepriseContexteInitiée`). BC-3 doit gérer la réception de E-09 avant E-07 pour le même `transitionId` (see ADR-SA-015 §Idempotence).

#### Consommateurs

| Consommateur | Usage | Réaction |
|---|---|---|
| **Workspace** | Notification au Professionnel entrant qu'une Reprise est disponible | Mise à jour de l'affichage |
| **Integration Layer** | Production des Integration Events vers Trust (audit), Messaging (notification), Collaboration | Propagation inter-plateforme |

---

### E-08 — `TransitionClôturée`

**Publisher :** `Transition` (Aggregate Root, BC-3)
**Version :** 1.0

#### Payload

| Champ | Type | Owner | Consumer | Justification |
|---|---|---|---|---|
| `transitionId` | TransitionId | Transition | BC-3 · Workspace | Corrélation avec la Transition ouverte par E-07 ; clé d'idempotence |
| `patientId` | PatientId | Transition | Workspace | Routage — le Workspace filtre par Patient |
| `clôturéLe` | Timestamp | Transition | Audit · Workspace | Moment de résolution du transfert — symétrique à `ouverteLe` dans E-07 ; médico-légal |

**Champs exclus et raisons :**

| Champ envisagé | Raison d'exclusion |
|---|---|
| `professionnelEntrantId` | Reconstructible : le consommateur l'a reçu dans E-07 pour le même `transitionId` |
| `professionnelSortantId` | Identique — reconstructible depuis E-07 |
| `statut` | Redondant — toujours "Clôturée" à la publication |

**Note sur la reconstructibilité :** le principe de payload minimal autorise l'exclusion de `professionnelEntrantId` parce que tout consommateur de E-08 a nécessairement reçu E-07 pour le même `transitionId` (une Transition ne peut pas être clôturée sans avoir été ouverte). Le consommateur possède déjà cette information dans sa projection locale.

#### Compatibilité
Première version. Contrat symétrique à E-07 — toute évolution de E-07 doit être évaluée simultanément sur E-08.

#### Ordering
E-08 est toujours postérieur à E-07 pour le même `transitionId` dans le domaine. L'at-least-once delivery (ADR-SA-010) peut cependant livrer E-08 avant E-07 en cas de rejeu. Les consommateurs doivent gérer ce cas via idempotence sur `transitionId`.

#### Consommateurs

| Consommateur | Usage | Réaction |
|---|---|---|
| **Workspace** | Marquer la Transition comme résolue dans l'interface | Mise à jour de l'affichage |

---

### E-09 — `RepriseContexteInitiée`

**Publisher :** `Reprise de Contexte` (Aggregate Root, BC-3)
**Version :** 1.0

#### Payload

| Champ | Type | Owner | Consumer | Justification |
|---|---|---|---|---|
| `repriseId` | RepriseId | Reprise de Contexte | Workspace | Identité de l'AR ; clé d'idempotence |
| `transitionId` | TransitionId | Reprise de Contexte | BC-3 · Workspace | Lien à la Transition déclenchante — précondition d'existence de la Reprise (SD-005 Invariant 1 Reprise) |
| `patientId` | PatientId | Reprise de Contexte | Workspace | Routage — le Workspace filtre par Patient |
| `initiéePar` | PractitionerId | Reprise de Contexte | Workspace | Le Professionnel effectuant la Reprise — le Workspace lui adresse l'interface de Reprise |
| `initiéeLe` | Timestamp | Reprise de Contexte | Workspace · Audit | Moment d'initiation |

**Champs exclus et raisons :**

| Champ envisagé | Raison d'exclusion |
|---|---|
| `professionnelSortantId` | Appartient à `Transition`, non à `Reprise de Contexte` — violation de l'AR ownership |
| `professionnelEntrantId` | Identique — appartient à `Transition`. Le consommateur le récupère depuis E-07 via `transitionId` |
| Modèle de Situation | Jamais stocké (SD-005 Invariant 2 Reprise — état cognitif interne) |

**Note sur `patientId` :** ce champ appartient à la Transition déclenchante, pas directement à la Reprise. Il est inclus par exception au principe d'ownership car il est nécessaire au routage du Workspace et son absence forcerait une query synchrone vers BC-3 ou BC-2 — violant l'autonomie. C'est le seul cas de "référence héritée" justifiée par l'autonomie du consommateur.

#### Compatibilité
Première version.

#### Ordering
E-09 est toujours postérieur à E-07 (`TransitionOuverte`) pour le même `transitionId` dans le domaine. Identique à E-08 : les consommateurs gèrent les inversions de livraison via idempotence sur `repriseId`.

#### Consommateurs

| Consommateur | Usage | Réaction |
|---|---|---|
| **Workspace** | Afficher l'interface de Reprise de Contexte pour le Professionnel entrant | Mise à jour de l'affichage |

---

## Séquence nominale BC-3

Pour un transfert de responsabilité complet, les événements sont publiés dans cet ordre logique :

```
TransitionOuverte (E-07)
        │
        ▼
RepriseContexteInitiée (E-09)
        │
  [LacuneIdentifiée (E-10) × 0..n]
        │
        ▼
TransitionClôturée (E-08)
```

Cette séquence est un ordre logique dans le domaine — non un ordre garanti de livraison (at-least-once, ADR-SA-010).

---

## Règles normatives

| # | Règle |
|---|---|
| R-01 | Tout champ d'un payload doit être justifié par `Owner × Consumer × Justification`. Un champ sans consommateur identifié est exclu. |
| R-02 | Un champ appartenant à un Aggregate Root différent du Publisher est exclu, sauf si son absence force une query synchrone inter-BC (exception documentée explicitement). |
| R-03 | Un champ reconstructible par le consommateur depuis son propre état ou depuis un événement antérieur est exclu. |
| R-04 | `professionnelEntrantId` et `professionnelSortantId` n'apparaissent que dans E-07 — ils ne sont pas répétés dans E-08 ou E-09. |
| R-05 | `patientId` est inclus dans E-07, E-08, E-09 par exception documentée (R-02) : le Workspace en a besoin pour le routage et son absence forcerait une query inter-BC. |
| R-06 | Aucun état cognitif (Modèle de Situation, notes de Reprise) n'est jamais transporté dans un événement. |
| R-07 | Tout nouveau champ ajouté à un payload existant doit être additif et justifié par une mise à jour de cette ADR. |
| R-08 | Les consommateurs de E-07, E-08, E-09 doivent implémenter le Tolerant Reader et ignorer les champs non utilisés sans lever d'erreur (ADR-SA-015 R-03). |

---

## Impact documentaire

| Document | Modification requise |
|---|---|
| DE-001 — E-07, E-08, E-09 | Marquer "Stable" · Ajouter référence à cette ADR dans §10 |
| ADB-001 — ADB-DE-004 | Marquer `Resolved` avec référence à cette ADR |
| SD-005 §4 BC-3 | Aucune modification du comportement métier — la séquence d'événements est déjà correcte. Optionnellement : ajouter une référence à ADR-SA-016 pour les contrats de payload |

---

## Références

| Document | Pertinence |
|---|---|
| SD-005 §4 BC-3 | Comportement métier, séquence, invariants |
| ADR-SA-015 | Principe du Tolerant Reader · Pattern d'idempotence — s'applique à BC-3 |
| ADR-SA-010 | Outbox Pattern — at-least-once, désordre de livraison |
| DE-001 E-07, E-08, E-09 | Documentation de référence mise à jour par cette ADR |
| ADB-001 ADB-DE-004 | Backlog d'origine |
