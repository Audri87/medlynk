# CC-000 — Clinical Cognitive Architecture

**Type :** Research Program — Product & Design Foundation
**Statut :** Active
**Date :** 2026-07-29
**Autorité :** Ce document est un programme de recherche design. Il informe les décisions UX et produit mais ne les gouverne pas. Il est subordonné à CLAUDE.md et parallèle à UX-000.

---

## Avertissement épistémologique

> Ce document n'est pas une théorie. C'est un programme de recherche.
>
> Une théorie est un cadre cohérent dont les prédictions sont vérifiables et dont le statut est stable. Ce document n'est pas à ce stade de maturité — et il l'assume.
>
> Un programme de recherche est un ensemble d'hypothèses de travail qui guident la conception, sont testées par l'usage, et peuvent être révisées, suspendues, ou abandonnées en fonction des observations.
>
> Chaque hypothèse de ce document peut être réfutée. Si elle l'est, le document est mis à jour. Si une hypothèse résiste à la réfutation sur une période suffisante d'observation, elle peut être proposée comme invariant d'expérience — et intégrée à UX-000.

---

## Intention fondatrice

Le logiciel clinique échoue souvent parce qu'il est conçu autour de la structure des données, pas autour du travail clinique réel.

Cette intuition n'est pas une théorie. C'est un point de départ pour la conception de MedLink.

La Clinical Cognitive Architecture (CCA) est la tentative de formuler explicitement les hypothèses de travail qui découlent de cette intuition — et de les soumettre à l'observation.

**Ce que la CCA n'est pas :**
- Un modèle universel de la cognition clinique
- Une garantie d'efficacité — elle doit être testée
- Une autorité de gouvernance — UX-000 est l'autorité ; la CCA l'informe

**Ce que la CCA est :**
- Un ensemble d'hypothèses sur la relation entre logiciel et travail clinique
- Un cadre pour orienter les décisions de design quand les données manquent
- Un mécanisme d'apprentissage sur ce qui fonctionne, et ce qui ne fonctionne pas

---

## Statut épistémologique

| Terme | Définition dans ce document |
|---|---|
| **Hypothèse** | Affirmation testable sur le comportement des praticiens avec le logiciel |
| **Confirme** | Signal observable qui renforce la plausibilité de l'hypothèse |
| **Réfute** | Signal observable qui fragilise ou invalide l'hypothèse |
| **Active** | Hypothèse en cours d'usage comme orientation de design |
| **Suspendue** | Évidence contradictoire — mise en attente, ne gouverne plus les décisions |
| **Abandonnée** | Réfutée par évidence suffisante — archivée, retirée du programme actif |

Une hypothèse non testée reste une hypothèse. Elle ne devient pas un invariant sans évidence.

---

## Hypothèses de travail

### H-01 — Pertinence contextuelle

**Hypothèse :** Le praticien est plus efficace quand le système lui présente les informations pertinentes à la situation courante, sans qu'il ait à les chercher.

**Confirme :**
- Réduction du temps de recherche d'information observée en contexte réel
- Moins d'interruptions du flux de travail
- Feedback praticien positif sur la pertinence des informations affichées

**Réfute :**
- Alert fatigue — les praticiens ignorent systématiquement les informations présentées
- Désactivation ou contournement des suggestions dans la pratique
- Erreurs causées par des informations non pertinentes présentées comme prioritaires

**Risque identifié :** Automation bias — le praticien peut déférer à la présentation système même quand elle est incorrecte. Ce risque ne réfute pas H-01 mais contraint fortement son implémentation.

**Relation :** Informe UX-P02 (contexte avant action) · UX-P06 (information progressive)

---

### H-02 — Coût de la discontinuité contextuelle

**Hypothèse :** Chaque interruption du flux de travail clinique impose un coût de reprise. Ce coût est réduit si le système préserve et restaure le contexte de travail.

**⚠️ Révision partielle — 2026-07-30 (après F-007 + F-009) :**

> H-02 est valide pour les praticiens à acte clinique direct (F-001 à F-008). Elle n'est pas applicable aux rôles de coordination (F-009) : pour ces profils, les interruptions constituent l'activité elle-même — les "protéger" serait inadapté. La formulation originale reste valide en précisant le domaine d'application.
>
> **Domaine d'application :** Actes cliniques directs (soin, consultation, rédaction). **Hors domaine :** Rôles de coordination inter-professionnelle.

**Confirme :**
- Temps de reprise réduit après interruption quand le contexte est préservé
- Moins d'erreurs liées à la perte de contexte (oubli d'une donnée consultée juste avant)
- Satisfaction praticien supérieure sur les flux sans changement d'écran

**Réfute :**
- Aucune différence mesurable dans les erreurs entre flux interrompus avec et sans restauration de contexte
- Praticiens préférant reconstruire le contexte eux-mêmes plutôt qu'utiliser la restauration système

**Observations terrain :**
- F-007 : *"Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."* — le coût est documenté
- F-009 : les interruptions sont l'activité principale — H-02 ne s'applique pas à ce profil

**Relation :** Informe UX-P03 (travail sans navigation)

---

### H-03 — Cognition distribuée de l'équipe soignante

**Hypothèse :** Le raisonnement clinique n'est pas individuel. Il est distribué entre les membres de l'équipe, les artefacts (dossier, ordonnances, transmissions) et le logiciel. Optimiser uniquement pour le praticien individuel peut dégrader le système distribué.

**Confirme :**
- Des décisions individuelles optimales produisent des incohérences d'équipe (doublons, contradictions, lacunes de coordination)
- Les praticiens utilisent activement les contributions des autres membres pour construire leur propre raisonnement
- Les erreurs de coordination disparaissent quand les contributions inter-professionnelles sont rendues visibles

**Réfute :**
- Les erreurs de coordination sont principalement causées par des facteurs non-logiciels (communication verbale, organisation)
- Les contributions entre praticiens ne sont pas lues ou utilisées dans la pratique réelle

**Implication de conception :** L'unité d'analyse est l'équipe, pas le praticien. Une décision d'interface qui optimise pour l'individu doit être évaluée à l'échelle de l'équipe soignante.

**Relation :** Informe UX-P08 (collaboration visible) · Tension avec UX-P04 (une intention par Workspace)

---

### H-04 — Expertise et fluidité

**Hypothèse :** Les praticiens experts utilisent principalement la reconnaissance de pattern, non le raisonnement analytique explicite. Un logiciel qui force une démarche analytique peut perturber leur performance sans améliorer la qualité clinique.

**Confirme :**
- Les experts signalent que certains flux logiciels "ralentissent" leur raisonnement
- Les erreurs d'experts ne sont pas réduites par la démarche analytique forcée par rapport au mode libre
- Les novices bénéficient davantage des guides analytiques que les experts

**Réfute :**
- Les experts ne montrent pas de différence de performance mesurable selon le mode de présentation
- Les erreurs d'experts sont réduites par la démarche analytique structurée

**Implication de conception :** Les flux pour experts ne doivent pas nécessiter la complétion de champs qui externalisent un raisonnement qu'ils n'ont pas rendu explicite. Un mode plus guidé peut être proposé optionnellement.

**Relation :** Tension avec les principes de traçabilité du raisonnement

---

### H-05 — Ancrage par transmission de raisonnement

**Hypothèse :** Le raisonnement explicité dans une Contribution Clinique crée un ancrage cognitif pour le praticien suivant. Cet ancrage peut réduire la charge de reconstruction mais peut aussi réduire la capacité à remettre en question un diagnostic établi.

**Confirme :**
- Des praticiens lisant une Contribution avant leur évaluation convergent davantage vers le diagnostic initial que des praticiens évaluant sans Contribution préalable
- Les praticiens signalent eux-mêmes l'influence des Contributions précédentes sur leur raisonnement

**Réfute :**
- Aucune différence de convergence diagnostique observée selon la présentation préalable d'une Contribution
- La Contribution est traitée comme information parmi d'autres, pas comme ancre de raisonnement

**Implication de conception :** La présentation des Contributions précédentes avant l'évaluation doit être une décision délibérée, pas un affichage automatique. La possibilité de consulter sans voir le raisonnement précédent est une feature de sécurité clinique.

**Relation :** Tension avec UX-P02 (contexte avant action) · UX-P05 (Timeline unique)

---

### H-06 — Attribution et calibration de confiance

**Hypothèse :** Le praticien calibre sa confiance dans une information en fonction de son auteur, de son contexte de production, et de son ancienneté. Une information sans attribution crée une confiance non calibrée — trop haute ou trop basse.

**Confirme :**
- Les praticiens demandent systématiquement "qui a écrit ça ?" avant d'agir sur une information non attribuée
- Les décisions basées sur des informations attribuées sont plus rapides et plus confiantes
- Les erreurs de sur-confiance sur des informations non attribuées sont observées

**Réfute :**
- L'attribution n'est pas consultée dans la pratique réelle
- Les praticiens traitent les informations de façon identique avec ou sans attribution visible

**Relation :** Informe UX-P07 (propriétaire visible) · ADR-0007 (rôles sur relations)

---

### H-07 — Charge cognitive et progressivité

**Hypothèse :** La charge cognitive est une ressource limitée. Un premier affichage présentant toutes les informations disponibles consomme de la capacité attentionnelle avant que le travail clinique commence. La progressivité réduit cette consommation initiale.

**Confirme :**
- Temps de première action réduit sur les interfaces progressives
- Moins d'erreurs d'omission (information critique ratée parce que noyée dans le volume)
- Satisfaction praticien supérieure sur les interfaces avec hiérarchie visuelle claire

**Réfute :**
- Les praticiens cherchent activement à voir toutes les informations disponibles dès l'ouverture
- L'interface progressive crée de la frustration et des allers-retours supplémentaires

**Relation :** Informe UX-P06 (information progressive)

---

### H-08 — Limbo informationnel : trois états de l'information clinique

**Hypothèse :** L'information clinique ne passe pas directement de "reçue" à "utilisée". Il existe un état intermédiaire — INTÉGRÉE — correspondant à la prise en charge cognitive de l'information. Une information REÇUE mais non INTÉGRÉE est dans un limbo : elle existe dans le système mais pas dans le raisonnement du praticien.

**Trois états :**
```
REÇUE → INTÉGRÉE → UTILISÉE
```

- **REÇUE :** L'information est disponible dans le système mais le praticien n'a pas encore eu le temps de la traiter cognitivement.
- **INTÉGRÉE :** Le praticien a lu, compris et relié l'information à son modèle mental du patient.
- **UTILISÉE :** L'information a influencé une décision clinique ou une action.

**Confirme :**
- Les praticiens utilisent des rappels et notes pour "ne pas oublier" une information reçue mais non encore traitée
- Des informations importantes sont identifiées par les praticiens eux-mêmes comme "pas encore traitées"
- La charge de travail élevée multiplie le volume d'informations dans le limbo

**Réfute :**
- Les praticiens signalent que toutes les informations reçues sont traitées au moment de leur réception
- Aucune information "oubliée" n'est identifiée en pratique réelle

**Risque clinique :** Une information dans le limbo peut disparaître sans avoir été intégrée — si le rappel est raté, si la note est perdue, si la charge de travail augmente. C'est un point de risque clinique documenté.

**Observations terrain :**
- F-007 : *"Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."* — 1ère identification explicite
- F-009 : *"Je me mets un rappel. Ou je prends une note. Je la traiterai plus tard."* — confirmation, volume plus élevé

**Implication de conception :** MedLink peut modéliser explicitement les trois états dans l'entité `InformationEntrante`. Un tableau de bord "à traiter" permet au praticien de gérer le limbo, pas seulement de le subir.

**Relation :** Informe potentiellement la file de triage (DP-F009-01) · Lié à H-07 (charge cognitive)

---

### H-09 — Anchor de sécurité minimum

**Hypothèse :** Pour tout patient, il existe un ensemble minimal de trois informations en deçà duquel la prise en charge clinique sécurisée est impossible. Cet ensemble constitue le "plancher informationnel de sécurité" : identité + pathologie principale + traitement en cours.

**Les trois éléments :**
1. **Identité et coordonnées** — qui est ce patient, comment le joindre ou le localiser
2. **Pathologie principale** — pourquoi ce patient est suivi
3. **Traitement en cours** — ce qui lui a été prescrit et doit être respecté ou articulé avec toute nouvelle décision

**Confirme :**
- Un praticien expérimenté, contraint à nommer ses trois informations indispensables, cite ces trois éléments spontanément
- Ces éléments correspondent aux données minimales d'une prescription, d'un relais, ou d'une prise en charge d'urgence
- La cohérence avec d'autres profils (F-003 : traitements + allergies + événements récents) est forte

**Réfute :**
- D'autres praticiens, sous la même contrainte, citent des informations fondamentalement différentes
- Ces trois éléments s'avèrent insuffisants pour une prise en charge sécurisée dans un contexte spécifique

**Note :** Le médecin (F-003) ajoute les allergies au triptyque. Ce quatrième élément peut être intégré dans l'Anchor de sécurité étendue, en laissant le minimum viable à trois.

**Observations terrain :**
- F-009 (coordinatrice) : *"Son identité et ses coordonnées. Sa pathologie principale. Son traitement en cours."* — réponse spontanée à la question "Trois informations indispensables"
- F-003 (médecin) : *"Traitements + allergies + événements récents"* — 4 éléments, avec les allergies en priorité haute

**Implication de conception :** Dans le Domain Model de MedLink, tout objet `Patient` doit avoir ces trois champs renseignés pour être considéré comme "utilisable" dans un contexte clinique. Un patient incomplet doit être signalé comme tel dans le Workspace.

**Relation :** Informe le Domain Model (entité Patient) · Informe le Workspace Coordinatrice (DP-F009-02) · Fondement de la règle de complétude des données patient

---

## Mécanisme d'évolution

### Révision

Une hypothèse est révisée quand :
- Une observation terrain la contredit de façon répétée et documentée
- Un test utilisateur montre un comportement incompatible avec l'hypothèse
- Une publication scientifique apporte une évidence contraire

La révision est documentée dans ce fichier avec la date et la source de l'évidence.

### Suspension

Une hypothèse est suspendue quand les évidences sont contradictoires. Elle reste dans le document avec le statut `Suspendue` et ne gouverne plus les décisions de design jusqu'à résolution.

### Abandon

Une hypothèse est abandonnée quand elle est réfutée par évidence suffisante. Elle est archivée dans `CC-000-archive.md` avec la date et la cause.

### Promotion en invariant UX

Si une hypothèse résiste à la réfutation avec des données concrètes sur une période suffisante, elle peut être proposée pour intégration dans UX-000 comme invariant d'expérience. Cette promotion requiert une validation explicite et une mise à jour de UX-000.

---

## État courant des hypothèses

| ID | Titre | Statut | Confiance terrain | Informe |
|---|---|---|---|---|
| H-01 | Pertinence contextuelle | **Active — candidat invariant** | ★★★★★ (9/9) | UX-P02, UX-P06 |
| H-02 | Coût de la discontinuité contextuelle | **Active — révisée** | ★★★★ (domaine limité) | UX-P03 |
| H-03 | Cognition distribuée de l'équipe | **Active — candidat invariant** | ★★★★★ (9/9) | UX-P08 |
| H-04 | Expertise et fluidité | Active | ★★★★ | (design de flux) |
| H-05 | Ancrage par transmission | **Active — candidat invariant** | ★★★★★ (9/9) | UX-P02, UX-P05 |
| H-06 | Attribution et calibration de confiance | Active | ★★★ | UX-P07 |
| H-07 | Charge cognitive et progressivité | **Active — candidat invariant** | ★★★★★ (9/9) | UX-P06 |
| H-08 | Limbo informationnel | Active — nouvelle | ★★★★ (2/9) | InformationEntrante, Workspace |
| H-09 | Anchor de sécurité minimum | Active — nouvelle | ★★★★ (2/9 direct) | Domain Model Patient |

### Hypothèses corpus (observations inter-profils)

| ID | Énoncé | Confiance | Prêt pour UX-000 ? |
|---|---|---|---|
| H-CORPUS-001 | Le praticien cherche le contexte utile à la décision du moment — pas le dossier complet | ★★★★★ (9/9) | ✅ OUI |
| H-CORPUS-002 | Le dossier complet n'est jamais la vue par défaut | ★★★★★ (9/9) | ✅ OUI |
| H-CORPUS-003 | Le limbo entre réception et intégration de l'information est actif et fréquent | ★★★★ (2/9 explicite) | → CC-000 H-08 |

---

---

## Corpus terrain — État au 2026-07-30

**9 interviews réalisées.** Chaque ligne résume le profil et son apport principal à CC-000.

| Fichier | Profil | Apport principal à CC-000 |
|---|---|---|
| F-001 | Masseur-kinésithérapeute libéral | Architecture mémoire-first — challenge H-01 pour info clinique · Confirme H-04 |
| F-002 | Infirmière + Sophrologue libérale | Origine du concept Anchor · Architecture documentation-centrique · DP-F002 |
| F-003 | Médecin | Règle des 30 secondes · Anchor safety (traitements + allergies + événements) · SLO implication |
| F-004 | Psychologue libérale | Cinq dimensions longitudinales · Post-consultation = production du prochain Anchor · Cas IA |
| F-005 | Échographiste | Anchor comparative (temporelle) · Protocole urgence · H-CORPUS-001 formalisée sur 5 profils |
| F-006 | Sage-femme | Dimension prospective de l'Anchor · "Inquiétudes patient" comme champ structuré · Terme obstétrical |
| F-007 | Kinésithérapeute (2ème) | **H-08 — Limbo informationnel** · Delta-Anchor · Trois conditions de clôture · H-F007-04 (style cognitif individuel) |
| F-008 | Infirmière libérale | Confirmation intra-profession de F-002 · Dimension prescriptive de l'Anchor ("ce qui reste à faire") |
| F-009 | Infirmière libérale coordinatrice | **Profil de coordination** · Révision H-02 · Confirmation maximale H-03 · **H-09 Anchor minimum** · H-F009-04 (horizon hebdomadaire) |

### Invariants confirmés sur tout le corpus (9/9 ou quasi-universels)

| Invariant | Confiance | Recommandation |
|---|---|---|
| H-CORPUS-001 — Contexte utile, pas dossier complet | ★★★★★ | Promouvoir en UX-000 |
| H-CORPUS-002 — Dossier complet jamais vue par défaut | ★★★★★ | Promouvoir en UX-000 |
| H-01 — Pertinence contextuelle | ★★★★★ | Promouvoir en invariant UX-000 |
| H-05 — Anchor comme point d'entrée du suivi | ★★★★★ | Promouvoir en invariant UX-000 |
| H-07 — Charge cognitive élevée | ★★★★★ | Promouvoir en invariant UX-000 |
| Présence > documentation en séance | ★★★★★ | 8/9 profils — promouvoir en UX-000 |
| H-03 — Cognition distribuée | ★★★★★ | Renforcée — F-009 confirmation maximale |

### Découvertes majeures du corpus non initiales dans CC-000

| Découverte | Source | Statut dans CC-000 |
|---|---|---|
| Deux architectures cognitives coexistent (mémoire-first vs documentation-centrique) | F-001 vs F-002 | Non modélisé — à intégrer |
| L'Anchor est universel dans son existence, mais spécifique dans son contenu par rôle | F-003 (H-F003-04) | Non modélisé explicitement |
| Le limbo informationnel : REÇUE → INTÉGRÉE → UTILISÉE | F-007 | **H-08 ajoutée** |
| Les rôles de coordination inversent H-02 | F-009 | **H-02 révisée** |
| L'horizon cognitif peut être la semaine, pas le jour | F-009 | Non modélisé — à intégrer |
| L'Anchor de sécurité minimum = identité + pathologie + traitement | F-009 | **H-09 ajoutée** |

---

## Relation avec les autres documents

| Document | Relation |
|---|---|
| CLAUDE.md | Mission — autorité supérieure |
| UX-000 | La CCA informe UX-000. UX-000 gouverne. Une hypothèse promue devient un invariant UX-000 |
| UXP-001 | Source empirique CW-001 — certaines hypothèses CCA sont cohérentes avec les 26 principes UXP-001 |
| CW-001 | Source des observations terrain — confirmations et réfutations puisées ici |
| ADR-SA-000 | Les hypothèses CCA ne modifient pas les décisions d'architecture logicielle |
| ADR-0007 | Rôles sur relations — fondement empirique de H-06 |

---

## Références scientifiques

Les hypothèses de ce document s'appuient sur la littérature suivante, sans en faire une théorie directement applicable :

- Kahneman, D. (2011). *Thinking, Fast and Slow*
- Klein, G. (1993). *Naturalistic Decision Making*
- Hutchins, E. (1995). *Cognition in the Wild*
- Endsley, M. (1995). Toward a Theory of Situation Awareness
- Croskerry, P. (2002, 2009). Achieving Quality in Clinical Decision Making
- Suchman, L. (1987). *Plans and Situated Actions*
- Schmidt, H., Norman, G., Boshuizen, H. (1990). A cognitive perspective on medical expertise
- Parasuraman, R. & Manzey, D. (2010). Complacency and Bias in Human Use of Automation

Ces références informent les hypothèses. Elles ne les valident pas. La validation vient de l'observation du travail clinique réel avec MedLink.
