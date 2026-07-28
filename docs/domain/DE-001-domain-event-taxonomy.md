# DE-001 — Domain Event Taxonomy

**Version :** 1.4 — Released
**Statut :** Released — Architecture Freeze v1.0
**Date gel :** 2026-07-28
**Périmètre :** Core Domain — Clinical Platform (BC-1, BC-2, BC-3)
**Sources :** SD-005 · CM-001 · ADR-0007 · ADR-0008 · ADR-SA-014 · ADR-SA-015 · ADR-SA-016 · DA-010 · CAL-001
**Backlog associé :** ADB-001 — Architecture Decision Backlog (Accepted — non-bloquant)

> Ce document est gelé. Les dix Domain Events du Core Domain sont définis, classifiés, et leurs contrats de payload sont formalisés par ADR-SA-015 et ADR-SA-016. Toute modification nécessite une ADR qui supersède les décisions concernées.

---

## Objet

Ce document est la taxonomie de référence de tous les Domain Events du Core Domain de MedLink.

Il ne crée aucun nouveau concept. Il ne modifie aucun Aggregate Root. Il ne redessine aucun Bounded Context.

Il formalise, classe et documente les dix Domain Events existants avec leurs contrats de payload définitifs.

Ce document ne contient que des décisions figées. Les questions architecturales ouvertes sont consignées dans ADB-001.

---

## Principe de publication — Amendements

Lorsqu'un amendement produit une nouvelle Clinical Contribution, **deux événements sont publiés simultanément** par BC-1 :

- `ContributionCliniqueCreée` (E-01)
- `ContributionCliniqueAmendée` (E-02)

Ces deux événements ne sont pas redondants. Ils certifient deux faits distincts :

| Événement | Fait certifié |
|---|---|
| E-01 | Une nouvelle Contribution Clinique existe dans le domaine — fait universel, valable pour tout type de Contribution |
| E-02 | Cette Contribution entretient une relation d'amendement avec une Contribution antérieure (`amendeDe`) |

**Fondements :**

- DA-010 : "Il n'y a pas deux types de Contributions." Un amendement est une Contribution. E-01 se déclenche pour toutes les Contributions sans exception.
- SD-005 Invariant 4 : "Un amendement produit une **nouvelle** Contribution." Une nouvelle Contribution déclenche E-01.
- SD-005 §2 Destinataires : BC-3 ne souscrit qu'à E-01 — si les amendements ne publiaient pas E-01, BC-3 serait aveugle à toute Contribution produite en mode Révision ou Transmission.
- ADR-0007 : "Clinical Contribution is a single concept — no subtypes." Publier E-02 à la place de E-01 introduirait une distinction comportementale entre Contributions — ce qu'ADR-0007 interdit.

**Conséquence pour les consommateurs :**

BC-2 reçoit les deux événements pour le même `contributionId`. Ce n'est pas une anomalie — ce sont deux opérations distinctes sur deux handlers distincts, chacun idempotent sur `contributionId` :

- E-01 → `IntégrateurDeContributions` : ajoute la Contribution à la liste chronologique du Parcours
- E-02 → handler dédié : enregistre la relation `amendeDe` dans la représentation du Parcours

BC-3 ne souscrit pas à E-02. Il reçoit le signal via E-01 et traite l'amendement comme toute autre Contribution.

---

## Classification retenue

Les événements ne sont pas classés sur une opposition binaire cycle-de-vie / fait-métier. Cette opposition est insuffisante : elle ne distingue pas les événements dont la valeur est intrinsèque au domaine de ceux dont la valeur est purement opérationnelle.

Trois types sont définis :

| Type | Nom | Définition |
|---|---|---|
| **A** | Événement de certification clinique | Certifie qu'un fait clinique irréversible s'est produit. Sa valeur est propre au domaine — elle existe indépendamment du modèle logiciel. Il doit être conservé durablement. |
| **B** | Événement de transition d'état | Marque l'entrée d'un agrégat dans un nouvel état de son cycle de vie. Sa valeur est opérationnelle. Sa rétention est liée à celle de l'agrégat. |
| **C** | Événement de propagation | Existe principalement pour informer un Bounded Context consommateur d'un changement d'état pertinent pour lui. Il n'a pas de valeur clinique propre en dehors de cette propagation. |

Un événement peut remplir plusieurs rôles. La classification retient le rôle dominant.

---

## BC-1 — Contribution Clinique

---

### E-01 — `ContributionCliniqueCreée`

#### 1. Nom
`ContributionCliniqueCreée`

#### 2. Aggregate Root propriétaire
**Clinical Contribution** (BC-1)

#### 3. Bounded Context propriétaire
**BC-1 — Contribution Clinique**

#### 4. Nature
**Type A — Événement de certification clinique**

La création d'une Clinical Contribution est un acte professionnel daté et attribué. Elle certifie qu'un Professionnel de Santé a externalisé sa Compréhension Clinique dans un document qui acquiert une valeur médico-légale au moment de sa validation. Ce fait existe indépendamment du logiciel — un clinicien le reconnaîtrait sans connaître le modèle.

#### 5. Signification métier
Un Professionnel de Santé a produit et validé explicitement une Contribution Clinique lors d'une Clinical Activity. Cette Contribution est désormais immuable, attribuée, et intègre le domaine de connaissance clinique disponible pour ce Patient.

#### 6. Invariants matérialisés
- **CAL-I-003** : une Clinical Contribution ne peut exister qu'à l'issue d'une Clinical Activity et d'un acte de validation explicite
- **DA-010 Invariant 1** : toute Contribution Clinique est produite dans le contexte d'une Clinical Activity
- **SD-005 Invariant 1** : une Clinical Contribution est immuable après création
- **SD-005 Invariant 3** : l'auteur est immuable après création

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| BC-2 — Parcours de Soins | Intègre la Contribution dans le Parcours du Patient |
| BC-3 — Continuité Clinique | Réceptionne les Contributions produites pour corrélation avec les Transitions ouvertes |

#### 8. Payload minimal

| Champ | Type | Statut | Justification |
|---|---|---|---|
| `contributionId` | ContributionId | Existant | Identité de l'Aggregate Root |
| `patientId` | PatientId | Existant | Référence du Patient concerné — appartient à Clinical Contribution |
| `auteurId` | PractitionerId | Existant | Attribut immuable de l'agrégat — nécessaire à BC-2 pour `ContributionEntry.auteurId` |
| `produitLe` | Timestamp | Existant | Moment de production — appartient à Clinical Contribution |
| `clinicalActivityId` | ClinicalActivityId | **Ajouté — ADR-SA-015** | Contexte opérationnel de production — DA-010 Invariant 1. Jamais null. Permet à BC-3 de corréler les Contributions à leur Clinical Activity. |

**Ne doit jamais être transporté :** le contenu clinique des dimensions (Situation, Raisonnement, Hypothèse, Incertitude, Intention).

**Compatibilité :** l'ajout de `clinicalActivityId` est additif. Les consommateurs qui ne l'utilisent pas (BC-2) doivent implémenter le Tolerant Reader et l'ignorer sans erreur — ADR-SA-015 R-03.

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Oui** | La création d'une Clinical Contribution est un acte professionnel traçable |
| Conservation durable | **Oui** | L'événement certifie un fait irréversible — il constitue une trace d'audit |
| Reconstructible | **Non** | Il est la source de vérité. Aucun autre événement ne peut le reconstituer |
| Événement de synchronisation | **Non** | Il a une valeur propre indépendante de ses consommateurs |

#### 10. Stabilité du contrat
**Stable**

Consommé par deux Bounded Contexts. Toute modification du payload nécessite une ADR. Contrat mis à jour par ADR-SA-015.

---

### E-02 — `ContributionCliniqueAmendée`

#### 1. Nom
`ContributionCliniqueAmendée`

#### 2. Aggregate Root propriétaire
**Clinical Contribution** (BC-1)

#### 3. Bounded Context propriétaire
**BC-1 — Contribution Clinique**

#### 4. Nature
**Type A — Événement de certification clinique**

Un amendement est une nouvelle Contribution Clinique produite dans le contexte d'une nouvelle Clinical Activity (DA-010 Invariant 3). Il certifie que la compréhension clinique a été révisée et que cette révision est formellement tracée. La référence `amendeDe` constitue une chaîne d'amendements appartenant au domaine, pas au modèle logiciel.

#### 5. Signification métier
Un Professionnel de Santé a produit une nouvelle Contribution Clinique qui corrige ou révise une Contribution antérieure. La Contribution originale reste intacte. La nouvelle Contribution est immuable et référence explicitement celle qu'elle amende.

#### 6. Invariants matérialisés
- **SD-005 Invariant 4** : un amendement produit une nouvelle Contribution — il ne modifie pas l'originale
- **DA-010 Invariant 3** : un amendement est produit dans le contexte d'une nouvelle Clinical Activity
- **SD-005 Invariant 1** : la Contribution produite est immuable dès création
- **SD-005 Invariant 3** : l'auteur de l'amendement est immuable après création

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| BC-2 — Parcours de Soins | Intègre l'amendement dans le Parcours ; l'original reste intact |

BC-3 ne souscrit pas à cet événement (CM-001 §R-INT-02). Un amendement n'est pas traité comme une Contribution de Transmission.

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `contributionId` | ContributionId | Identité de la nouvelle Contribution créée par l'amendement |
| `amendeDe` | ContributionId | Référence à la Contribution amendée — appartient à l'agrégat (chaîne d'amendements) |
| `patientId` | PatientId | Référence du Patient concerné |
| `auteurId` | PractitionerId | Auteur de l'amendement — attribut immuable de l'agrégat, nécessaire à BC-2 pour `ContributionEntry.auteurId` |
| `produitLe` | Timestamp | Moment de production de l'amendement |

**Ne doit jamais être transporté :** contenu clinique des dimensions.

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Oui** | Un amendement est un acte professionnel traçable avec auteur et date |
| Conservation durable | **Oui** | Il certifie une révision de l'état de la connaissance clinique |
| Reconstructible | **Non** | Source de vérité de la chaîne d'amendements |
| Événement de synchronisation | **Non** | Il a une valeur propre indépendante de ses consommateurs |

#### 10. Stabilité du contrat
**Stable**

Consommé par BC-2. Toute modification du payload nécessite une ADR.

---

### E-03 — `ClinicalActivityOpened`

#### 1. Nom
`ClinicalActivityOpened`

#### 2. Aggregate Root propriétaire
**Clinical Activity** (BC-1) — introduit par ADR-SA-014

#### 3. Bounded Context propriétaire
**BC-1 — Contribution Clinique**

#### 4. Nature
**Type B — Événement de transition d'état**

L'ouverture d'une Clinical Activity marque l'entrée dans la phase active du cycle de vie de l'agrégat (Phase 1 → phase active, CAL-001). Ce n'est pas un fait clinique observable indépendamment du logiciel : un clinicien dirait "je commence à voir ce patient", non "j'ouvre une Clinical Activity." L'événement existe pour que le système puisse suivre le cycle de vie et délivrer le Workspace approprié.

#### 5. Signification métier
Un Professionnel de Santé a initié une Clinical Activity pour un Patient. L'agrégat est désormais dans son état actif. Le mode déclaré (Construction, Révision, Transmission) définit l'intention primaire de cette activité.

#### 6. Invariants matérialisés
- **CAL-I-001** : toute Clinical Activity possède un Practitioner responsable identifié dès l'ouverture

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| Workspace | Met à jour l'affichage pour accompagner le cycle de travail du Professionnel |

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `clinicalActivityId` | ClinicalActivityId | Identité de l'Aggregate Root |
| `patientId` | PatientId | Patient concerné par l'activité |
| `practitionerId` | PractitionerId | Professionnel responsable — CAL-I-001 |
| `mode` | Enum (Construction, Révision, Transmission) | Intention primaire déclarée — DA-010 |
| `ouverteLe` | Timestamp | Moment d'ouverture |

**Ne doit jamais être transporté :** contenu du Clinical Draft (entité interne à BC-1).

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Non** | L'ouverture d'une activité de travail n'est pas un acte médico-légal |
| Conservation durable | **Opérationnelle** | Conservé le temps du cycle de vie de l'agrégat Clinical Activity |
| Reconstructible | **Partiellement** | Déductible depuis l'état persisté de l'agrégat |
| Événement de synchronisation | **Partiellement** | Sert principalement à informer le Workspace |

#### 10. Stabilité du contrat
**Interne au BC**

Consommé uniquement par le Workspace. Évolution possible avec le raffinement du modèle Clinical Activity.

---

### E-04 — `ClinicalActivityClosed`

#### 1. Nom
`ClinicalActivityClosed`

#### 2. Aggregate Root propriétaire
**Clinical Activity** (BC-1) — introduit par ADR-SA-014

#### 3. Bounded Context propriétaire
**BC-1 — Contribution Clinique**

#### 4. Nature
**Type B — Événement de transition d'état**

La fermeture d'une Clinical Activity marque l'entrée dans l'état terminal du cycle de vie de l'agrégat (Phase 7 — Closure, CAL-001). La fermeture est toujours une décision explicite du Professionnel (CAL-I-007). En mode Transmission, cet événement est le signal que BC-3 attend pour associer les Contributions produites à une Transition ouverte (ADR-SA-014 §7.4).

#### 5. Signification métier
Un Professionnel de Santé a explicitement décidé de clôturer sa Clinical Activity. Si le mode est Transmission, la Clinical Continuity doit être assurée avant ou au moment de cette clôture (CAL-001 Phase 7).

#### 6. Invariants matérialisés
- **CAL-I-007** : la fermeture est toujours une décision explicite du Practitioner — jamais automatique
- **DA-010 Invariant 2** : une Clinical Activity peut avoir produit 0..n Contributions à la clôture

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| Workspace | Met à jour l'affichage — l'activité est terminée |
| BC-3 — Continuité Clinique | Lorsque `mode = Transmission` : signal pour associer les Contributions produites à la Transition ouverte |

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `clinicalActivityId` | ClinicalActivityId | Identité de l'Aggregate Root |
| `patientId` | PatientId | Patient concerné |
| `practitionerId` | PractitionerId | Professionnel qui a clôturé |
| `mode` | Enum (Construction, Révision, Transmission) | Mode final de l'activité — valeur normative (ADR-SA-014 R-06) |
| `clôturéLe` | Timestamp | Moment de clôture |

**Ne doit jamais être transporté :** contenu du Clinical Draft.

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Partielle** | En mode Transmission, la clôture marque la fin de responsabilité du Professionnel sortant |
| Conservation durable | **Opérationnelle** | Conservé le temps du cycle de vie de l'agrégat Clinical Activity |
| Reconstructible | **Partiellement** | Déductible depuis l'état final de l'agrégat |
| Événement de synchronisation | **Partiellement** | Rôle de coordination pour BC-3 en mode Transmission |

#### 10. Stabilité du contrat
**Évolutif**

Le payload de cet événement fait l'objet d'une décision ouverte consignée dans ADB-001 (ADB-DE-001).

---

## BC-2 — Parcours de Soins

---

### E-05 — `ParcoursDeSoinsInitié`

#### 1. Nom
`ParcoursDeSoinsInitié`

#### 2. Aggregate Root propriétaire
**Parcours de Soins** (BC-2)

#### 3. Bounded Context propriétaire
**BC-2 — Parcours de Soins**

#### 4. Nature
**Type C — Événement de propagation**

L'initiation du Parcours de Soins est la création de l'agrégat en réponse à la première Contribution Clinique intégrée. Le fait clinique est porté par `ContributionCliniqueCreée` (BC-1). `ParcoursDeSoinsInitié` est le signal que BC-2 émet pour informer BC-3 qu'un Parcours existe désormais pour ce Patient et que des Transitions peuvent être ouvertes. Sa valeur est entièrement positionnée dans la coordination inter-BC.

#### 5. Signification métier
Un Parcours de Soins vient d'être créé pour un Patient. BC-3 peut désormais ouvrir des Transitions pour ce Patient.

#### 6. Invariants matérialisés
- **SD-005 Invariant 1 de Parcours** : un Parcours n'existe que si au moins une Contribution a été intégrée — cet événement certifie que cette condition est désormais satisfaite

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| BC-3 — Continuité Clinique | Débloque la possibilité d'ouvrir des Transitions pour ce Patient |
| Workspace | Signal que le Patient possède désormais un Parcours navigable |

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `patientId` | PatientId | Identifiant du Patient pour lequel le Parcours est créé |
| `initiéLe` | Timestamp | Moment de création du Parcours |

**Ne doit jamais être transporté :** contenu clinique de la Contribution qui a déclenché la création.

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Non** | La création d'un agrégat logiciel n'est pas un fait médico-légal |
| Conservation durable | **Non** | Événement de coordination — valeur épuisée après réception par BC-3 |
| Reconstructible | **Oui** | Déductible de la première occurrence de `ContributionCliniqueCreée` pour un Patient |
| Événement de synchronisation | **Oui** | Son unique rôle est de signaler à BC-3 qu'un Parcours existe |

#### 10. Stabilité du contrat
**Stable**

Payload minimal. Pas de raison d'évolution prévisible.

---

### E-06 — `ContributionCliniqueIntégrée`

#### 1. Nom
`ContributionCliniqueIntégrée`

#### 2. Aggregate Root propriétaire
**Parcours de Soins** (BC-2)

#### 3. Bounded Context propriétaire
**BC-2 — Parcours de Soins**

#### 4. Nature
**Type C — Événement de propagation**

Cet événement marque que le Parcours de Soins a traité une Contribution et mis à jour son état. Le fait clinique est `ContributionCliniqueCreée` (BC-1). `ContributionCliniqueIntégrée` est le signal que BC-2 émet pour indiquer que son état a changé — afin que BC-3 sache qu'une Reprise de Contexte active peut bénéficier de nouvelles données dans le Parcours.

#### 5. Signification métier
Le Parcours de Soins d'un Patient a intégré une nouvelle Contribution. Toute Reprise de Contexte active pour ce Patient peut désormais accéder à cette Contribution via `AssembleurDeReprise`.

#### 6. Invariants matérialisés
- **SD-005 Invariant 2 de Parcours** : la liste des Contributions ne peut jamais être réduite — chaque publication confirme un ajout permanent et irréversible

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| BC-3 — Continuité Clinique | Signal que le Parcours est enrichi — une Reprise en cours peut être actualisée via `AssembleurDeReprise` |

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `contributionId` | ContributionId | Référence à la Contribution intégrée |
| `patientId` | PatientId | Patient concerné |
| `produitLe` | Timestamp | Moment de production de la Contribution |

**Ne doit jamais être transporté :** contenu clinique, `résumé` interne au Parcours.

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Non** | L'intégration est un traitement interne à BC-2, pas un fait clinique |
| Conservation durable | **Non** | Événement de coordination — reconstructible |
| Reconstructible | **Oui** | Déductible depuis `ContributionCliniqueCreée` et l'état du Parcours |
| Événement de synchronisation | **Oui** | Existe principalement pour signaler à BC-3 l'état du Parcours |

#### 10. Stabilité du contrat
**Interne au BC**

Consommé uniquement au sein de la Clinical Platform.

---

## BC-3 — Continuité Clinique

---

### E-07 — `TransitionOuverte`

#### 1. Nom
`TransitionOuverte`

#### 2. Aggregate Root propriétaire
**Transition** (BC-3)

#### 3. Bounded Context propriétaire
**BC-3 — Continuité Clinique**

#### 4. Nature
**Type A — Événement de certification clinique**

Une Transition qui s'ouvre représente le fait clinique du passage de responsabilité entre deux Professionnels de Santé. Ce passage est un moment structurel du domaine — un point de risque pour la continuité des soins, reconnu par tout clinicien indépendamment du logiciel (M-003 §12, P-001 §3). L'agrégat Transition est la représentation d'un fait clinique, non d'un artefact du modèle. Ses événements sont donc des faits cliniques.

#### 5. Signification métier
Un Professionnel de Santé cède la responsabilité d'un Patient à un autre Professionnel. La Transition est désormais ouverte et irréversible. Le Professionnel entrant doit effectuer une Reprise de Contexte.

#### 6. Invariants matérialisés
- **SD-005 Invariant 1 de Transition** : une Transition ne peut pas être annulée une fois ouverte — l'événement marque le point de non-retour

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| Workspace | Notifie le Professionnel entrant — une Reprise de Contexte est disponible |
| Integration Layer | Produit les Integration Events vers Trust (audit), Collaboration (coordination), Messaging (notification) |

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `transitionId` | TransitionId | Identité de l'Aggregate Root |
| `patientId` | PatientId | Patient concerné par le transfert |
| `professionnelSortantId` | PractitionerId | Professionnel qui cède la responsabilité |
| `professionnelEntrantId` | PractitionerId | Professionnel qui reçoit la responsabilité |
| `ouverteLe` | Timestamp | Moment du transfert |

**Ne doit jamais être transporté :** `contributionDeTransmission` (null à l'ouverture) · `statut` (redondant — toujours "Ouverte") · `clôturéLe` (null).

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Oui** | Un transfert de responsabilité clinique est un fait traçable pour la sécurité des patients |
| Conservation durable | **Oui** | La traçabilité des transferts de responsabilité est une exigence médico-légale et HDS |
| Reconstructible | **Non** | Source de vérité du fait de transfert |
| Événement de synchronisation | **Non** | Il a une valeur clinique propre indépendante de ses consommateurs |

#### 10. Stabilité du contrat
**Stable**

Déclenche des Integration Events vers plusieurs plateformes. Son payload est un contrat engageant. Contrat formalisé par ADR-SA-016.

---

### E-08 — `TransitionClôturée`

#### 1. Nom
`TransitionClôturée`

#### 2. Aggregate Root propriétaire
**Transition** (BC-3)

#### 3. Bounded Context propriétaire
**BC-3 — Continuité Clinique**

#### 4. Nature
**Type A — Événement de certification clinique**

La clôture d'une Transition représente le fait clinique que la continuité a été rétablie — le Professionnel entrant a atteint le seuil de suffisance (M-003) et peut agir en pleine connaissance de la situation. C'est un résultat cliniquement significatif : le risque lié à la rupture de continuité a été résolu.

#### 5. Signification métier
Le Professionnel entrant a achevé sa Reprise de Contexte et déclaré sa compréhension suffisante. La Transition est clôturée. La continuité clinique est rétablie pour ce Patient.

#### 6. Invariants matérialisés
- **SD-005 Invariant 2 de Transition** : une Transition ne peut être clôturée que depuis l'état `EnCours` — l'événement certifie que le cycle complet Ouverte → EnCours → Clôturée s'est accompli

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| Workspace | Met à jour l'affichage — la Transition est résolue |

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `transitionId` | TransitionId | Identité de l'Aggregate Root |
| `patientId` | PatientId | Patient concerné |
| `clôturéLe` | Timestamp | Moment de clôture |

**Ne doit jamais être transporté :** contenu clinique des Lacunes ou de la Reprise.

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Oui** | La confirmation de continuité est un fait traçable pour la sécurité des patients |
| Conservation durable | **Oui** | Symétrique à `TransitionOuverte` |
| Reconstructible | **Non** | Source de vérité de la résolution du transfert |
| Événement de synchronisation | **Non** | Il a une valeur clinique propre |

#### 10. Stabilité du contrat
**Stable**

Symétrique à `TransitionOuverte`. Toute modification doit être traitée conjointement. Contrat formalisé par ADR-SA-016.

---

### E-09 — `RepriseContexteInitiée`

#### 1. Nom
`RepriseContexteInitiée`

#### 2. Aggregate Root propriétaire
**Reprise de Contexte** (BC-3)

#### 3. Bounded Context propriétaire
**BC-3 — Continuité Clinique**

#### 4. Nature
**Type B — Événement de transition d'état**

L'initiation d'une Reprise de Contexte marque l'entrée dans l'état actif du cycle de vie de l'agrégat Reprise de Contexte. Bien que la Reprise soit un concept clinique (Domain Atlas §12), l'événement est avant tout le signal déclenchant `AssembleurDeReprise`. Ce que le clinicien vit — "je commence à lire le dossier" — est une réalité cognitive non observable par des tiers. L'événement sert à synchroniser le système, non à certifier un fait clinique observable.

#### 5. Signification métier
Le Professionnel entrant a initié sa Reprise de Contexte. `AssembleurDeReprise` est déclenché. Les Lacunes identifiées ultérieurement seront rattachées à cet agrégat.

#### 6. Invariants matérialisés
- **SD-005 Invariant 1 de Reprise** : une Reprise de Contexte ne peut exister sans Transition associée — l'événement certifie que cette précondition a été satisfaite

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| Workspace | Met à jour l'affichage pour accompagner la phase de Reprise |

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `repriseId` | RepriseId | Identité de l'Aggregate Root |
| `transitionId` | TransitionId | Transition déclenchante — précondition d'existence |
| `patientId` | PatientId | Patient concerné |
| `initiéePar` | PractitionerId | Professionnel initiant la Reprise |
| `initiéeLe` | Timestamp | Moment d'initiation |

**Ne doit jamais être transporté :** Modèle de Situation (état cognitif interne — jamais stocké, SD-005 Invariant 2 de Reprise).

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Non** | La Reprise est un processus cognitif — non un acte médico-légal observable |
| Conservation durable | **Opérationnelle** | Conservé le temps du cycle de vie de la Reprise de Contexte |
| Reconstructible | **Partiellement** | Déductible si l'agrégat est persisté |
| Événement de synchronisation | **Partiellement** | Sert principalement à informer le Workspace |

#### 10. Stabilité du contrat
**Stable**

Consommé uniquement par le Workspace au sein de la Clinical Platform. Contrat formalisé par ADR-SA-016.

---

### E-10 — `LacuneIdentifiée`

#### 1. Nom
`LacuneIdentifiée`

#### 2. Aggregate Root propriétaire
**Reprise de Contexte** (BC-3) — la Lacune est un Value Object de cet agrégat. L'événement est publié par l'Aggregate Root, non par le Value Object.

#### 3. Bounded Context propriétaire
**BC-3 — Continuité Clinique**

#### 4. Nature
**Type A — Événement de certification clinique**

L'identification d'une Lacune est un fait clinique pur. Un Professionnel de Santé a reconnu qu'une information clinique attendue est absente du Parcours de Soins. Ce fait a une signification directe pour la continuité des soins et pour l'audit de qualité (Domain Atlas §14).

#### 5. Signification métier
Lors de sa Reprise de Contexte, le Professionnel entrant a identifié qu'une information clinique attendue est absente du Parcours. Cette Lacune est enregistrée de façon permanente et ne peut pas être supprimée.

#### 6. Invariants matérialisés
- **SD-005 Invariant 3 de Reprise** : une Lacune identifiée ne peut pas être supprimée — seulement résolue. L'événement marque une entrée permanente dans l'ensemble des Lacunes.

#### 7. Consommateurs

| Consommateur | Raison |
|---|---|
| Workspace | Affiche la Lacune dans l'interface de la Reprise |
| Integration Layer | Produit les Integration Events vers Messaging (notification Professionnel Sortant si `récupérable = true`) · Trust (audit) · Collaboration (initiation de consultation possible) |

#### 8. Payload minimal

| Champ | Type | Justification |
|---|---|---|
| `repriseId` | RepriseId | Reprise dans laquelle la Lacune a été identifiée |
| `lacuneId` | LacuneId | Référence opaque à la Lacune — les consommateurs non-cliniques l'utilisent comme clé |
| `patientId` | PatientId | Patient concerné |
| `criticité` | Enum (Bloquante, Importante, Mineure) | Métadonnée de sévérité — non clinique, non nominative |
| `récupérable` | Boolean | Attribut domaine de la Lacune : peut-elle être comblée immédiatement ? |

**Ne doit jamais être transporté :** `description` — information clinique en texte libre nominative. Accessible uniquement via la Projection de BC-3 ou l'API clinique de BC-3. Elle ne traverse aucune frontière inter-BC et aucune frontière inter-plateforme.

#### 9. Sensibilité métier

| Dimension | Valeur | Justification |
|---|---|---|
| Valeur médico-légale | **Oui** | Une Lacune identifiée trace un défaut de continuité informationnelle — pertinent pour l'audit qualité |
| Conservation durable | **Oui** | La traçabilité des Lacunes fait partie de l'audit de continuité des soins |
| Reconstructible | **Non** | L'identification d'une Lacune est un jugement clinique subjectif — non reconstituable |
| Événement de synchronisation | **Non** | Il a une valeur clinique propre |

#### 10. Stabilité du contrat
**Stable**

---

## Tableau de synthèse

| ID | Événement | Aggregate Root | BC | Type | Médico-légal | Stabilité |
|---|---|---|---|---|---|---|
| E-01 | `ContributionCliniqueCreée` | Clinical Contribution | BC-1 | A | Oui | Stable |
| E-02 | `ContributionCliniqueAmendée` | Clinical Contribution | BC-1 | A | Oui | Stable |
| E-03 | `ClinicalActivityOpened` | Clinical Activity | BC-1 | B | Non | Interne |
| E-04 | `ClinicalActivityClosed` | Clinical Activity | BC-1 | B | Partiel | Évolutif |
| E-05 | `ParcoursDeSoinsInitié` | Parcours de Soins | BC-2 | C | Non | Stable |
| E-06 | `ContributionCliniqueIntégrée` | Parcours de Soins | BC-2 | C | Non | Interne |
| E-07 | `TransitionOuverte` | Transition | BC-3 | A | Oui | Stable |
| E-08 | `TransitionClôturée` | Transition | BC-3 | A | Oui | Stable |
| E-09 | `RepriseContexteInitiée` | Reprise de Contexte | BC-3 | B | Non | Stable |
| E-10 | `LacuneIdentifiée` | Reprise de Contexte | BC-3 | A | Oui | Stable |

*Type A — Certification clinique · Type B — Transition d'état · Type C — Propagation*

---

## Références

| Document | Pertinence |
|---|---|
| Domain Atlas V1 | Définitions des concepts cliniques (§4, §10, §11, §12, §13, §14) |
| DA-010 | Clinical Activity : modes, invariants, cardinalité 0..n |
| CAL-001 | Clinical Activity Lifecycle : 7 phases, CAL-I-001 à CAL-I-007 |
| SD-005 | Aggregate Roots, invariants des trois BCs, événements publiés |
| CM-001 | Payloads documentés des Domain Events, relations inter-BCs |
| ADR-0007 | Modèle de relation Clinical Activity / Clinical Contribution |
| ADR-0008 | Sous-domaines Clinical Work et Clinical Knowledge |
| ADR-SA-014 | ClinicalActivityOpened, ClinicalActivityClosed — Aggregate Model BC-1 |
| ADB-001 | Décisions architecturales ouvertes relatives aux Domain Events |
