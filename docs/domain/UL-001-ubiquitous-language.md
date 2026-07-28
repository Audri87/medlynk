# UL-001 — Ubiquitous Language

**Version :** 3.0
**Statut :** Accepted — Supersède la v2.0
**Fondé sur :** Domain Atlas V1
**Date :** 2026-07-28

---

## Préambule

### Ce que ce document est

Le Ubiquitous Language est le vocabulaire unique et partagé de MedLink.

Il s'applique à toutes les conversations, tous les documents, tout le code, et toutes les interfaces.

Un concept = un mot. Un mot = un concept.

Toute violation de cette règle est une source d'ambiguïté, d'erreur, et de divergence entre la théorie, le modèle, et l'implémentation.

### Politique de langue

Les termes canoniques sont en **français**. Le français est la langue du domaine clinique de MedLink.

Chaque terme canonical possède un **équivalent code** en anglais, utilisé dans les noms de classes, méthodes, et tables.

Le terme français est utilisé dans :
- les documents fondateurs (M-000 à M-003)
- les documents de recherche (P-001, CW-001)
- le Domain Atlas
- les discussions produit, design, et cliniques
- les ADRs (titre en anglais acceptable, corps en français)

Le terme anglais est utilisé dans :
- les noms de classes
- les noms de méthodes
- les noms de tables et colonnes
- les noms d'événements

### Règle de gouvernance

> **Aucun terme ne peut apparaître dans un ADR, un Event Storming, une Policy, un Aggregate, ou une Pull Request sans être défini dans ce document.**

Toute demande de nouveau terme passe par une justification dans le Domain Atlas avant d'entrer dans ce document.

### Relation avec la v2.0

La v2.0 (2026-07-13) utilisait des termes anglais comme termes canoniques. La v3.0 établit les termes français comme canoniques. Le mapping complet v2.0 → v3.0 figure en Partie IX.

---

## Partie I — Les acteurs

---

### Patient

**→ Code :** `Patient`

**Définition**

L'entité humaine continue dont la situation clinique est l'objet de la Compréhension Clinique. Le Patient est la seule entité **permanente** du domaine : son parcours clinique s'accumule sans interruption de la naissance à la mort.

**Pourquoi ce terme existe**

La continuité du Patient est le fondement du domaine. C'est parce que le Patient est continu et que les Professionnels de Santé sont transitoires qu'il existe un problème de transmission de la compréhension. Le terme "Patient" est retenu parce qu'il est universel à toutes les spécialités et neutre quant à la nature de la relation de soins.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Utilisateur | Confond l'acteur du domaine avec l'utilisateur d'une interface applicative |
| ❌ Client | Connotation commerciale incompatible avec la nature du domaine |
| ❌ Bénéficiaire | Terme administratif qui efface la dimension clinique |
| ❌ Cas | Réduit une personne à un épisode médical |
| ❌ Dossier | Confond la personne avec sa représentation numérique |
| ❌ Usager | Terme des services sociaux, non spécifique au domaine clinique |

**Exemples d'usage correct**

- "Le Patient traverse plusieurs Transitions au cours de son Parcours de Soins."
- "La Compréhension Clinique appartient au Patient — pas à un Professionnel ou à un établissement."

**Exemples d'usage incorrect**

- ~~"Créer un utilisateur pour ce patient."~~ → Créer un **Patient**.
- ~~"Le dossier du patient contient…"~~ → La **Compréhension Clinique** du Patient contient…

**Relations**

- A un Parcours de Soins
- A une Compréhension Clinique
- Est l'objet de Contributions Cliniques

**Référence Atlas :** Domain Atlas §1

---

### Professionnel de Santé

**→ Code :** `Practitioner`

**Définition**

L'acteur humain qui produit de la Compréhension Clinique. Il intervient de façon intermittente dans le Parcours de Soins d'un Patient. Il est l'**auteur** de toute Contribution Clinique.

**Pourquoi ce terme existe**

"Professionnel de Santé" est le terme le plus large et le plus neutre pour désigner tout acteur clinique, quelle que soit sa spécialité ou sa profession. Il affirme que le Core Domain traite tous les professionnels comme équivalents dans leur capacité à contribuer à la Compréhension Clinique d'un Patient.

**Forme courte acceptable**

"Praticien" est acceptable dans les conversations informelles et dans le code (`Practitioner`, `PractitionerId`). Il ne remplace pas "Professionnel de Santé" dans les documents formels.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Médecin | Désigne une seule profession parmi toutes les professions de santé |
| ❌ Utilisateur | Confond l'acteur du domaine avec l'utilisateur d'une interface |
| ❌ Docteur | Même problème que Médecin |
| ❌ Soignant | Exclut des professionnels non-soignants mais cliniquement pertinents |

**Exemples d'usage correct**

- "Le Professionnel de Santé produit une Contribution Clinique après chaque prise en charge significative."
- "La Reprise de Contexte est effectuée par le Professionnel de Santé entrant."

**Relations**

- Produit des Contributions Cliniques
- Effectue des Reprises de Contexte
- Porte une Perspective
- Intervient dans des Transitions

**Référence Atlas :** Domain Atlas §2

---

## Partie II — L'actif central et ses dimensions

---

### Compréhension Clinique

**→ Code :** `ClinicalUnderstanding`

**Définition**

La représentation synthétique de la situation d'un Patient, construite par un Professionnel de Santé à un moment donné, qui rend cette situation suffisamment cohérente et intelligible pour guider l'action clinique — et pour permettre à un successeur de reprendre la prise en charge sans reconstruire depuis zéro.

C'est le **concept central du domaine**. C'est l'actif que MedLink préserve et transmet.

Elle comprend quatre dimensions dans cet ordre logique :
1. Situation Clinique
2. Raisonnement Clinique
3. Incertitudes Cliniques
4. Intentions Cliniques

**Pourquoi ce terme existe**

Le terme "Compréhension" est délibéré : il distingue ce concept des données, de l'information, et de la connaissance générale. La Compréhension est spécifique à un patient, à un moment, et à un auteur. C'est le seul terme qui rende compte de la nature synthétique, interprétative, et situationnelle de ce que produit le travail cognitif clinique.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Contexte clinique | "Contexte" est utilisé dans "Reprise de Contexte" avec un sens différent — collision garantie |
| ❌ Savoir clinique | Le savoir est général ; la Compréhension est spécifique à un patient à un instant |
| ❌ Connaissance clinique | Même problème que Savoir clinique |
| ❌ Information clinique | L'information est un niveau inférieur de la hiérarchie épistémique (M-003 §6) |
| ❌ Dossier | Le dossier est un support, pas une compréhension |
| ❌ Vue clinique | Trop vague et trop visuel |
| ❌ Clinical Knowledge | Terme de l'UL v2.0 — remplacé par Compréhension Clinique |

**Exemples d'usage correct**

- "La Compréhension Clinique du Patient se dégrade à chaque Transition sans transmission explicite."
- "La Contribution Clinique enrichit la Compréhension Clinique du Patient."

**Exemples d'usage incorrect**

- ~~"Le contexte clinique du patient a été perdu lors du transfert."~~ → La **Compréhension Clinique** du Patient…
- ~~"Le dossier contient toutes les informations."~~ → Le **Parcours de Soins** contient toutes les **Contributions Cliniques**.

**Relations**

- Appartient à un Patient
- Est constituée de Contributions Cliniques
- Est l'objet d'une Reprise de Contexte lors de chaque Transition
- Comprend : Situation Clinique, Raisonnement Clinique, Incertitudes Cliniques, Intentions Cliniques

**Référence Atlas :** Domain Atlas §3

---

### Situation Clinique

**→ Code :** `ClinicalSituation`

**Définition**

La représentation de l'état actuel d'un Patient **tel que perçu** par un Professionnel de Santé à un moment donné. Elle organise les observations et les constats en une image cohérente. C'est la première dimension de la Compréhension Clinique.

**Pourquoi ce terme existe**

"Situation" est préféré à "état" parce qu'il capture la dimension perçue et organisée — pas seulement mesurée. La Situation Clinique est ce que le Professionnel *voit* comme tableau cohérent, pas un ensemble de valeurs brutes.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ État clinique | Trop objectif — efface la dimension perçue et organisée |
| ❌ Tableau clinique | Terme médical qui ne distingue pas la perception de la réalité |
| ❌ Présentation | Anglicisme médical |
| ❌ Status | Terme latin, confondu avec un statut technique |
| ❌ Bilan | Désigne un document ou une procédure, pas une dimension de la compréhension |

**Exemples d'usage correct**

- "La Situation Clinique perçue par le cardiologue diffère de celle perçue par le néphrologue — les deux sont valides depuis leur Perspective respective."

**Relations**

- Est la première dimension de la Compréhension Clinique
- Constitue le substrat du Raisonnement Clinique
- Est une composante de la Contribution Clinique

**Référence Atlas :** Domain Atlas §5

---

### Raisonnement Clinique

**→ Code :** `ClinicalReasoning`

**Définition**

L'**explication** que le Professionnel de Santé donne de la Situation Clinique perçue : pourquoi le Patient est dans cet état, selon quelle logique, à partir de quelles Hypothèses Cliniques. Deuxième dimension de la Compréhension Clinique.

**Pourquoi ce terme existe**

"Raisonnement" capture le caractère dynamique et argumenté de la couche interprétative — distinct d'un diagnostic (conclusion statique) et d'une analyse (procédure générique). Le Raisonnement Clinique est le chemin parcouru, pas la destination.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Diagnostic | Le diagnostic est une conclusion ; le Raisonnement est le chemin — les confondre efface la valeur du Raisonnement |
| ❌ Analyse | Trop générique, ne capture pas le caractère clinique et situé |
| ❌ Interprétation | Confus avec l'interprétation d'un résultat d'examen particulier |
| ❌ Conclusion | Désigne le résultat du Raisonnement, pas le Raisonnement lui-même |

**Exemples d'usage correct**

- "Le Raisonnement Clinique documenté par le médecin du soir a permis à l'équipe de nuit de comprendre immédiatement pourquoi le traitement avait été modifié."

**Relations**

- S'appuie sur la Situation Clinique
- Génère des Hypothèses Cliniques
- Oriente les Intentions Cliniques
- Est une composante de la Contribution Clinique

**Référence Atlas :** Domain Atlas §6

---

### Hypothèse Clinique

**→ Code :** `ClinicalHypothesis`

**Définition**

Une explication candidate de la Situation Clinique, formulée par un Professionnel de Santé et **non encore confirmée ou écartée**. Elle représente les possibles maintenus actifs dans le Raisonnement Clinique.

**Pourquoi ce terme existe**

"Hypothèse" est le terme épistémique correct pour désigner une explication provisoire et testable. Il affirme que la Compréhension Clinique inclut structurellement des possibilités ouvertes — pas seulement des certitudes.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Diagnostic différentiel | Terme médical formel qui désigne une liste finalisée ; l'Hypothèse Clinique est plus dynamique et inclut les hypothèses en cours d'évaluation |
| ❌ Piste | Trop informel |
| ❌ Supposition | Implique un manque de rigueur ; l'Hypothèse Clinique est un raisonnement structuré |
| ❌ Option | Trop vague et technique |

**Exemples d'usage correct**

- "Deux Hypothèses Cliniques coexistent : décompensation cardiaque (principale) et embolie pulmonaire (à ne pas écarter)."

**Relations**

- Découle du Raisonnement Clinique
- Alimente les Incertitudes Cliniques lorsqu'elle n'est pas encore tranchée
- Est une composante de la Contribution Clinique

**Référence Atlas :** Domain Atlas §7

---

### Incertitude Clinique

**→ Code :** `ClinicalUncertainty`

**Définition**

La représentation **explicite** de ce que le Professionnel de Santé ne sait pas encore à un moment donné, et qui est cliniquement significatif. Troisième dimension de la Compréhension Clinique.

**Pourquoi ce terme existe**

"Incertitude" est neutre et structurel — il ne désigne pas un manque de compétence mais une propriété fondamentale de toute Compréhension Clinique honnête. Toute compréhension qui ne comporte pas d'Incertitudes déclarées est épistémiquement suspecte.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Doute | Connotation de manque de confiance ou de compétence ; l'Incertitude est neutre et structurelle |
| ❌ Manque d'information | L'Incertitude peut exister même quand toutes les informations disponibles ont été consultées |
| ❌ Question ouverte | Moins précis, ne capture pas le caractère cliniquement significatif |
| ❌ Inconnue | Trop général — une Incertitude Clinique est délimitée et identifiée |

**Exemples d'usage correct**

- "L'Incertitude Clinique principale est la composante ischémique : le résultat de la troponine permettra de la lever."
- "L'Incertitude Clinique transmise lors de la Transition a évité une prescription redondante."

**Relations**

- Découle des Hypothèses Cliniques non encore tranchées
- Oriente les Intentions Cliniques
- Est une composante de la Contribution Clinique
- Génère des Lacunes lors d'une Reprise de Contexte si non documentée

**Référence Atlas :** Domain Atlas §8

---

### Intention Clinique

**→ Code :** `ClinicalIntention`

**Définition**

La représentation de ce qui a été **décidé et doit encore être réalisé** : les actions planifiées, les suivis prévus, les transmissions attendues. Quatrième et dernière dimension de la Compréhension Clinique.

**Pourquoi ce terme existe**

"Intention" capture le caractère décidé-mais-non-encore-exécuté, et la responsabilité de l'auteur vis-à-vis de l'action future. Il se distingue d'une tâche (sans auteur clinique) et d'une prescription (acte formel sans raisonnement).

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Plan de soins | Document formel et standardisé ; l'Intention Clinique est dynamique et contextuelle |
| ❌ Objectif thérapeutique | Trop abstrait ; l'Intention est concrète et actionnelle |
| ❌ Prescription | La prescription est l'acte formel exécutable ; l'Intention inclut la décision et son pourquoi |
| ❌ Tâche | Terme technique sans auteur clinique ni raisonnement |
| ❌ TODO | Terme informatique inadapté au domaine |

**Exemples d'usage correct**

- "Les Intentions Cliniques documentées ont permis à l'équipe de nuit de continuer la prise en charge sans interruption."

**Relations**

- Découle du Raisonnement Clinique et des décisions arrêtées
- Peut être conditionnelle à la levée d'une Incertitude Clinique
- Est une composante de la Contribution Clinique

**Référence Atlas :** Domain Atlas §9

---

## Partie III — L'unité fondamentale

---

### Contribution Clinique

**→ Code :** `ClinicalContribution`

**Définition**

L'**unité fondamentale** de la Compréhension Clinique externalisée. Ce qu'un Professionnel de Santé produit lors d'une prise en charge : une représentation datée, attribuée, contextualisée, de sa compréhension de la situation du Patient à ce moment.

Toute Compréhension Clinique est constituée de l'ensemble de ses Contributions Cliniques.

**Pourquoi ce terme existe**

"Contribution" affirme que chaque acte clinique documenté est une **contribution à quelque chose de plus grand** — la Compréhension Clinique cumulative du Patient. Le terme exclut les connotations purement administratives (note, rapport) et affirme le caractère perspectival et attribué de chaque entrée.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Note | Trop générique ; une note peut être purement factuelle sans couche interprétative |
| ❌ Document | Un document est un support ; la Contribution est un acte cognitif externalisé |
| ❌ Observation | L'observation est un input ; la Contribution est la synthèse interprétative |
| ❌ Compte rendu | Un compte rendu peut contenir une Contribution, mais n'en est pas une — sauf s'il inclut raisonnement et incertitudes |
| ❌ Entrée | Terme technique sans sens clinique |
| ❌ Événement | Terme surchargé (événement technique, événement métier) |
| ❌ Enregistrement | Désigne l'acte technique de stockage, pas l'acte clinique de compréhension |

**Attributs fondamentaux** (dans le code)

| Attribut français | Attribut code | Source théorique |
|---|---|---|
| Auteur | `author` / `practitionerId` | M-003 Invariant I |
| Produit le | `occurredAt` | M-003 Propriété dynamique 4 |
| Contexte | `context` | M-003 §3.7 |
| Situation perçue | `clinicalSituation` | M-003 §3.1 |
| Raisonnement | `reasoning` | M-003 §3.2 |
| Hypothèses | `hypotheses` | M-003 §3.3 |
| Incertitudes | `uncertainties` | M-003 §3.4 |
| Décisions | `decisions` | M-003 §3.5 |
| Intentions | `intentions` | M-003 §3.6 |

**Exemples d'usage correct**

- "Le cardiologue a produit une Contribution Clinique après la consultation — elle est désormais disponible pour tout Professionnel de Santé reprenant ce Patient."
- "La Contribution Clinique de l'infirmière de nuit a transmis l'Intention Clinique critique qui a évité une erreur le lendemain matin."

**Relations**

- Est produite par un Professionnel de Santé
- Porte sur un Patient
- S'inscrit dans le Parcours de Soins
- Enrichit la Compréhension Clinique
- Contient : Situation Clinique, Raisonnement Clinique, Hypothèses Cliniques, Incertitudes Cliniques, Intentions Cliniques

**Référence Atlas :** Domain Atlas §4

---

## Partie IV — Continuité et transitions

---

### Parcours de Soins

**→ Code :** `ClinicalJourney`

**Définition**

La **trajectoire clinique longitudinale** d'un Patient, constituée de l'ensemble de ses Contributions Cliniques ordonnées chronologiquement. C'est la mémoire cumulative de la Compréhension Clinique du Patient.

**Pourquoi ce terme existe**

"Parcours" affirme la nature dynamique et continue de la trajectoire — distinct d'un dossier (statique) ou d'un historique (orienté passé). "De Soins" ancre le concept dans la dimension clinique, pas administrative.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Dossier patient | Le dossier est un support administratif ; le Parcours de Soins est une trajectoire de compréhensions cliniques |
| ❌ Historique | Orienté uniquement vers le passé ; le Parcours inclut les Intentions (orientées vers le futur) |
| ❌ Antécédents | Désigne une partie du Parcours (les éléments passés stables), pas le Parcours entier |
| ❌ Care Record | Terme de l'UL v2.0 — partiellement remplacé (voir Partie IX) |
| ❌ Dossier médical | Même problème que Dossier patient |

**Exemples d'usage correct**

- "Le Parcours de Soins est non-destructif : aucune Contribution ne peut être effacée."

**Relations**

- Appartient à un Patient (1:1)
- Est constitué de Contributions Cliniques
- Est traversé par des Transitions
- Est consulté lors d'une Reprise de Contexte

**Référence Atlas :** Domain Atlas §10

---

### Transition

**→ Code :** `ClinicalTransition`

**Définition**

L'**événement structurel** où un Professionnel de Santé cesse d'être le référent d'un Patient et un autre prend le relais. Elle crée mécaniquement un vide de Compréhension Clinique.

**Pourquoi ce terme existe**

"Transition" est le terme le plus général et le plus neutre pour désigner tout changement de Professionnel référent. Il couvre tous les types de passages (garde, remplacement, transfert, spécialisation) sans se limiter à l'un d'eux.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Relève | Type spécifique de Transition (contexte hospitalier, fin de garde) ; ne couvre pas tous les cas |
| ❌ Passage de relais | Même limitation que Relève |
| ❌ Handover | Terme anglais de l'UL v2.0 — voir Clinical Handover dans la Partie IX |
| ❌ Transfert | Désigne une Transition impliquant un changement d'établissement — sous-ensemble seulement |
| ❌ Remplacement | Désigne la raison de la Transition, pas la Transition elle-même |

**Exemples d'usage correct**

- "Chaque Transition crée un vide de Compréhension Clinique que la Reprise de Contexte doit combler."

**Relations**

- Intervient dans le Parcours de Soins
- Déclenche une Reprise de Contexte
- Crée le besoin d'une Contribution Clinique transmissible

**Référence Atlas :** Domain Atlas §11

---

### Reprise de Contexte

**→ Code :** `ContextResumption`

**Définition**

L'**acte cognitif** par lequel un Professionnel de Santé reconstruit sa Compréhension de la situation d'un Patient au moment d'une prise en charge, en s'appuyant sur les Contributions Cliniques disponibles dans le Parcours de Soins.

Ce n'est pas une lecture. C'est une **reconstruction**.

**Pourquoi ce terme existe**

"Reprise" affirme qu'il s'agit d'un acte actif — pas d'une lecture passive. "De Contexte" précise l'objet : c'est la Compréhension Clinique du Patient (son "contexte") qui est reprise. Le terme distingue cet acte cognitif de la simple consultation de documents.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Lecture du dossier | Désigne un acte passif ; la Reprise est un acte cognitif actif de reconstruction |
| ❌ Prise de connaissance | Trop passif et trop générique |
| ❌ Briefing | Anglicisme ; implique une transmission externe alors que la Reprise peut être autonome |
| ❌ Mise à jour | Confond avec une mise à jour informatique ; et la Reprise ne met pas à jour — elle reconstruit |
| ❌ Onboarding patient | Jargon applicatif inadapté au domaine clinique |

**Exemples d'usage correct**

- "La qualité de la Reprise de Contexte dépend directement de la qualité des Contributions Cliniques disponibles."
- "La Reprise de Contexte est effectuée par le Professionnel de Santé — elle ne peut pas être déléguée à un système."

**Relations**

- Est déclenchée par une Transition
- S'appuie sur le Parcours de Soins et ses Contributions Cliniques
- Produit un Modèle de Situation
- Révèle des Lacunes

**Référence Atlas :** Domain Atlas §12

---

### Modèle de Situation

**→ Code :** `SituationModel`

**Définition**

La **représentation mentale dynamique** que le Professionnel de Santé construit lors d'une Reprise de Contexte. C'est l'état cognitif intermédiaire atteint pendant la reprise : une image organisée et suffisamment cohérente pour guider l'action immédiate.

Le Modèle de Situation n'est pas stocké. Il vit dans l'esprit du Professionnel.

**Pourquoi ce terme existe**

"Modèle de Situation" est le terme issu de la psychologie cognitive (Situation Model) pour désigner la représentation mentale dynamique d'un état du monde. Son usage ici ancre le concept dans la littérature sur le raisonnement clinique et l'ergonomie cognitive.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Résumé | Le résumé est un document externalisé ; le Modèle de Situation est un état cognitif interne |
| ❌ Vue d'ensemble | Trop vague et statique |
| ❌ Snapshot | Terme anglais technique |
| ❌ Image de la situation | Périphrase correcte mais trop longue pour un usage régulier |

**Exemples d'usage correct**

- "Le Modèle de Situation construit lors de la Reprise de Contexte est d'autant plus fiable que les Contributions Cliniques disponibles sont riches en Raisonnement."

**Relations**

- Est produit lors d'une Reprise de Contexte
- S'appuie sur les Contributions Cliniques du Parcours de Soins
- Révèle des Lacunes

**Référence Atlas :** Domain Atlas §13

---

### Lacune

**→ Code :** `ClinicalGap`

**Définition**

Une **information manquante identifiée** lors d'une Reprise de Contexte, dont l'absence crée une Incertitude Clinique non résolue dans le Modèle de Situation du Professionnel.

**Pourquoi ce terme existe**

"Lacune" est précis : il désigne un vide identifié, délimité, dont on sait qu'il manque. Il se distingue d'une simple ignorance par le fait que la Lacune est *consciente* — le Professionnel sait ce qu'il ne sait pas.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Manque | Trop informel |
| ❌ Trou | Trop informel, connotation négative sans précision |
| ❌ Donnée manquante | Trop restrictif — une Lacune peut concerner une compréhension, pas seulement une donnée brute |
| ❌ Gap | Terme anglais |

**Exemples d'usage correct**

- "La Lacune principale identifiée lors de la Reprise : la raison de l'arrêt de l'anticoagulant n'est pas documentée."

**Relations**

- Émerge lors d'une Reprise de Contexte
- Correspond à une Incertitude Clinique non documentée ou à une information attendue et non disponible
- Peut être récupérable (immédiatement, avec effort) ou irréductible

**Référence Atlas :** Domain Atlas §14

---

### Perspective

**→ Code :** `ClinicalPerspective`

**Définition**

Le **point de vue situé** depuis lequel un Professionnel de Santé forme sa Compréhension Clinique. Elle est déterminée par son expertise, sa spécialité, sa position dans la chaîne de soins, et le contexte de la prise en charge.

La Perspective est structurellement inévitable : toute Contribution Clinique est perspectivale.

**Pourquoi ce terme existe**

"Perspective" est le terme le plus précis pour désigner un point de vue situé et légitime. Il affirme que des Compréhensions différentes d'un même Patient par des Professionnels différents sont **complémentaires**, pas contradictoires.

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Point de vue | Acceptable en conversation mais trop informel pour la documentation formelle |
| ❌ Angle | Trop informel et géométrique |
| ❌ Biais | Connotation négative — la Perspective est une propriété neutre et structurelle, pas un défaut |
| ❌ Subjectivité | Implique une potentielle erreur ; la Perspective est légitime par nature |

**Exemples d'usage correct**

- "La Perspective du cardiologue et la Perspective du néphrologue sur ce Patient sont toutes deux valides."

**Relations**

- Appartient à un Professionnel de Santé
- Colore chaque Contribution Clinique produite par ce Professionnel
- Justifie la coexistence de plusieurs Contributions divergentes sur un même Patient

**Référence Atlas :** Domain Atlas §15

---

## Partie V — Les verbes du domaine

Les verbes sont aussi importants que les noms. Un verbe ambigu dans le code ou dans une conversation produit une confusion sur ce qui se passe dans le domaine.

---

### Contribuer

**→ Code :** `contribute()`

**Définition**

Acte par lequel un Professionnel de Santé produit une Contribution Clinique lors d'une prise en charge.

**Usage correct**

- "Le Professionnel de Santé **contribue** à la Compréhension Clinique du Patient après chaque prise en charge significative."

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Documenter | Documenter est un acte de transcription ; contribuer est un acte d'externalisation de compréhension |
| ❌ Rédiger | Désigne l'acte physique d'écriture, pas l'acte sémantique de contribution |
| ❌ Ajouter | Trop technique — évoque une opération de liste |
| ❌ Enregistrer | Désigne l'acte technique de stockage |
| ❌ Saisir | Même problème — désigne la saisie technique |

---

### Amender

**→ Code :** `amend()`

**Définition**

Acte de produire une nouvelle Contribution Clinique qui corrige, complète, ou met à jour une Contribution précédente, **sans effacer celle-ci**.

L'amendement est **non-destructif** par définition.

**Usage correct**

- "Le Professionnel de Santé **amende** la Contribution précédente en produisant une nouvelle Contribution qui précise le diagnostic."

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Modifier | Modifier implique une altération de l'original ; amender est non-destructif |
| ❌ Corriger | Implique que l'original était erroné ; l'amendement peut simplement enrichir ou préciser |
| ❌ Mettre à jour | Même ambiguïté — peut suggérer une modification de l'original |
| ❌ Supprimer et recréer | Totalement interdit — la Compréhension Clinique est non-destructive |

---

### Reprendre

**→ Code :** `resume()` (dans le contexte de la reprise de contexte)

**Définition**

Initier une Reprise de Contexte — l'acte cognitif de reconstruction de la Compréhension Clinique d'un Patient.

**Usage correct**

- "Le Professionnel de Santé **reprend** le Patient : il initie une Reprise de Contexte à partir du Parcours de Soins."

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Prendre en charge | Désigne l'acte clinique complet ; reprendre désigne spécifiquement la phase cognitive de reconstruction |
| ❌ Voir | Trop générique — "voir un patient" peut désigner n'importe quel contact |
| ❌ Consulter le dossier | Acte passif de lecture, pas acte actif de reconstruction |

---

### Transmettre

**→ Code :** `transmit()` / `handover()`

**Définition**

Rendre disponible une Contribution Clinique pour le Professionnel de Santé entrant lors d'une Transition. L'acte de transmission réduit le coût de la Reprise de Contexte pour le successeur.

**Usage correct**

- "Avant de partir, le Professionnel de Santé **transmet** sa Compréhension Clinique en produisant une Contribution explicite."

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Partager | Connotation de réseaux sociaux ; et "partager" n'implique pas la structuration nécessaire |
| ❌ Envoyer | Trop technique — désigne un transport, pas un acte sémantique |
| ❌ Passer | Trop informel |

---

### Enrichir

**→ Code :** `enrich()` (conceptuel)

**Définition**

Augmenter la Compréhension Clinique d'un Patient par l'ajout d'une nouvelle Contribution Clinique. L'enrichissement est toujours cumulatif — il ne remplace pas ce qui précède.

**Usage correct**

- "Chaque contact clinique **enrichit** la Compréhension Clinique du Patient."

**Synonymes interdits**

| Terme interdit | Raison |
|---|---|
| ❌ Mettre à jour | Implique une modification de l'existant ; l'enrichissement est additif |
| ❌ Compléter | Suggère qu'il manquait quelque chose — la Compréhension est toujours partielle par définition |

---

## Partie VI — Les qualificatifs du domaine

---

### Externalisé(e)

**→ Code :** `externalized`

**Définition**

Se dit d'une Compréhension Clinique ou d'une de ses dimensions qui a été rendue explicite dans une Contribution Clinique, par opposition à rester tacite dans l'esprit du Professionnel.

**Usage correct**

- "La partie externalisée de la Compréhension Clinique est ce que la Contribution Clinique contient."

**Synonymes interdits :** ❌ Documenté — documenter peut être purement factuel ; externaliser implique la couche interprétative.

---

### Perspectival(e)

**→ Code :** `perspectival`

**Définition**

Se dit de toute Compréhension Clinique ou Contribution Clinique : produite depuis un point de vue situé, attribuée à un auteur, colorée par son expertise et son contexte.

**Usage correct**

- "La nature perspectivale des Contributions Cliniques explique pourquoi deux Professionnels peuvent légitimement comprendre différemment la même Situation Clinique."

**Synonymes interdits :** ❌ Subjectif — connotation de possible erreur ; perspectival est une propriété neutre et structurelle.

---

### Non-destructif/ve

**→ Code :** `nonDestructive`

**Définition**

Propriété du Parcours de Soins et de l'amendement : rien n'est jamais effacé. Les Contributions Cliniques passées demeurent accessibles même après révision ou amendement.

**Usage correct**

- "Le modèle de données est non-destructif : un `UPDATE` ou `DELETE` sur une Contribution Clinique est interdit."

---

### Signal

**→ Code :** `signal` (dans le contexte de la Reprise de Contexte)

**Définition**

Information présente dans le Parcours de Soins qui est **réellement utile** lors d'une Reprise de Contexte : elle accélère et fiabilise la construction du Modèle de Situation.

Constitue un signal : le Raisonnement Clinique documenté, les Incertitudes Cliniques explicites, les Intentions Cliniques actives.

**Antonymne :** Bruit

**Référence :** CW-001 §9

---

### Bruit

**→ Code :** `noise` (dans le contexte de la Reprise de Contexte)

**Définition**

Information présente dans le Parcours de Soins qui n'est **pas utile** lors d'une Reprise de Contexte : elle n'accélère pas la construction du Modèle de Situation et peut en augmenter le coût cognitif.

Constitue du bruit : les antécédents stables et anciens non pertinents pour le problème actuel, les doublons, les résultats bruts sans interprétation.

**Antonymne :** Signal

**Référence :** CW-001 §9

---

### Seuil de suffisance

**→ Code :** (concept cognitif, pas de représentation directe en code)

**Définition**

Le niveau subjectif de compréhension à partir duquel un Professionnel de Santé estime avoir suffisamment compris la situation du Patient pour agir. C'est le critère implicite de clôture de la Reprise de Contexte.

Il varie selon le contexte (urgence vs. consultation programmée), la pression temporelle, et les enjeux cliniques.

**Usage correct**

- "Un Seuil de suffisance trop bas produit une clôture prématurée de la Reprise de Contexte."

**Synonymes interdits :** ❌ Validation (connotation d'un acte technique explicite) ; ❌ Fin de lecture (désigne l'acte physique, pas le critère cognitif).

**Référence :** CW-001 §8

---

## Partie VII — Termes exclusivement interdits

Ces termes ne doivent jamais apparaître dans un document de domaine, un ADR, un nom de classe, ou une conversation sur le Core Domain.

| Terme interdit | Terme correct | Raison |
|---|---|---|
| Médecin | Professionnel de Santé | Spécialité particulière, non universel |
| Utilisateur | Patient / Professionnel de Santé | Terme applicatif, non clinique |
| Dossier patient | Parcours de Soins | Le dossier est un support administratif |
| Contexte clinique | Compréhension Clinique | Collision avec "Reprise de Contexte" |
| Connaissance clinique | Compréhension Clinique | Niveau inférieur dans la hiérarchie épistémique |
| Note | Contribution Clinique | Trop générique, pas de couche interprétative |
| Document | Contribution Clinique | Un document est un support, pas une compréhension |
| Diagnostic | Raisonnement Clinique | Le diagnostic est une conclusion ; le Raisonnement est le chemin |
| Doute | Incertitude Clinique | Connotation négative injustifiée |
| Relève | Transition | Sous-ensemble seulement |
| Biais | Perspective | Connotation négative — la Perspective est neutre |
| Objectif | Intention Clinique | Trop abstrait, sans auteur clinique |

---

## Partie VIII — Test du langage ubiquitaire

Avant d'introduire un nouveau terme, appliquer les deux tests suivants.

### Test 1 — Cross-Practitioner (CPP-001)

**Le concept existe-t-il dans plusieurs professions de santé ?**

- Si oui : le concept peut appartenir au Core Domain.
- Si non : il s'agit probablement d'une spécialisation métier.

### Test 2 — Fondement théorique (R-000)

**Le concept est-il fondé dans un document de Niveau 1 (Recherche) ou Niveau 2 (Théorie) ?**

- Si oui : le concept peut être ajouté au Domain Atlas, puis au présent document.
- Si non : produire d'abord le document fondateur qui établit le concept.

---

## Partie IX — Mapping v2.0 → v3.0

Correspondance entre les termes de l'UL v2.0 (anglais) et les termes de l'UL v3.0 (français).

| Terme v2.0 | Terme v3.0 | Statut |
|---|---|---|
| Patient | Patient | Stable — même concept |
| Practitioner | Professionnel de Santé | Stable — `Practitioner` reste le code équivalent |
| Clinical Contribution | Contribution Clinique | Stable — définition enrichie par M-003 |
| Clinical Activity | *(non intégré au Domain Atlas V1)* | En révision — le concept n'a pas de fondement direct dans les documents fondateurs actuels |
| Clinical Draft | *(non intégré au Domain Atlas V1)* | En révision — idem |
| Clinical Responsibility | *(non intégré au Domain Atlas V1)* | En révision — idem |
| Clinical Handover | Transition | Remplacé — Transition est plus général |
| Clinical Referral | *(non intégré au Domain Atlas V1)* | En révision |
| Clinical Continuity | Compréhension Clinique + Parcours de Soins | Remplacé — concept distribué entre deux termes plus précis |
| Care Record | Parcours de Soins | Remplacé — Parcours de Soins est plus précis et fondé dans la théorie |
| Clinical Knowledge | Compréhension Clinique | Remplacé — Compréhension Clinique est le terme correct au niveau du Core Domain |
| Professional Workspace | *(non intégré au Domain Atlas V1)* | En révision — appartient au Niveau 4 (Modèle), pas encore défini |

**Note sur les termes "En révision"**

Les concepts Clinical Activity, Clinical Draft, Clinical Responsibility, et Clinical Referral sont des concepts valides dans le domaine mais n'ont pas de fondement direct dans les documents fondateurs M-000 à M-003, P-001, CW-001. Leur intégration au Domain Atlas V2 requiert une justification documentée dans ces sources ou dans de nouveaux documents de recherche.

Jusqu'à cette intégration, ces termes restent dans la v2.0 mais ne sont pas canoniques dans la v3.0.

---

## Partie X — Index alphabétique

| Terme | Partie | Code équivalent |
|---|---|---|
| Amender | V | `amend()` |
| Bruit | VI | `noise` |
| Compréhension Clinique | II | `ClinicalUnderstanding` |
| Contribuer | V | `contribute()` |
| Contribution Clinique | III | `ClinicalContribution` |
| Enrichir | V | `enrich()` |
| Externalisé(e) | VI | `externalized` |
| Hypothèse Clinique | II | `ClinicalHypothesis` |
| Incertitude Clinique | II | `ClinicalUncertainty` |
| Intention Clinique | II | `ClinicalIntention` |
| Lacune | IV | `ClinicalGap` |
| Modèle de Situation | IV | `SituationModel` |
| Non-destructif/ve | VI | `nonDestructive` |
| Parcours de Soins | IV | `ClinicalJourney` |
| Patient | I | `Patient` |
| Perspective | IV | `ClinicalPerspective` |
| Perspectival(e) | VI | `perspectival` |
| Professionnel de Santé | I | `Practitioner` |
| Raisonnement Clinique | II | `ClinicalReasoning` |
| Reprendre | V | `resume()` |
| Reprise de Contexte | IV | `ContextResumption` |
| Seuil de suffisance | VI | *(concept cognitif)* |
| Signal | VI | `signal` |
| Situation Clinique | II | `ClinicalSituation` |
| Transmettre | V | `transmit()` |
| Transition | IV | `ClinicalTransition` |

---

*Ce document est la référence de vocabulaire de MedLink. Tout terme non listé ici doit faire l'objet d'une demande d'intégration justifiée par une référence au Domain Atlas avant d'être utilisé dans tout document ou code de production.*
