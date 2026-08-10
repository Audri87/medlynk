# CCF-01 — Clinical Cognitive Architecture

**Type :** Research Foundation — Authoritative Document
**Statut :** Draft v1.1 — Corpus ambulatoire libéral (F-001 → F-009)
**Date :** 2026-07-30
**Framework :** Clinical Cognition Framework — CCF-000
**Autorité :** Ce document décrit la structure permanente de la cognition clinique.
Il précède toute décision de design. Il est gouverné par CCF-000.

---

## Position dans le CCF

```
REALITY
════════════════════════════════════════════════════════════════
  Clinical Work

                            │
                            ▼

SCIENTIFIC FRAMEWORK
════════════════════════════════════════════════════════════════

► Clinical Cognitive Architecture              ◄ CE DOCUMENT
  ─────────────────────────────────────────────────────────────
  La structure permanente de la cognition clinique.
  Invariants. Familles. Cycle. Modèle statique.

  Clinical Cognitive Episode                         CCF-02
  Cognitive Invariants                               CI-xxx

                            │
                            ▼

PRODUCT SPECIFICATION
════════════════════════════════════════════════════════════════
  Workspace Requirements (WR) · UX Principles (UX)

                            │
                            ▼

WORKSPACES
════════════════════════════════════════════════════════════════
  Patient · Practitioner · Collaboration · Care · Organisation
```

---

## Avertissement épistémologique

Ce document n'est pas une théorie psychologique. Ce n'est pas un modèle cognitif universel.

C'est une architecture — un ensemble de structures et de relations observées avec suffisamment de régularité dans un corpus de 9 professionnels de santé pour être traitées comme des fondements de conception.

Chaque invariant est traçable à des observations terrain. Aucun n'est une inférence créative.
Chaque invariant peut être réfuté. Si un test utilisateur ou une étude contrôlée en contredit un, ce document est mis à jour et les décisions de design qui en découlent sont revisitées.

**Corpus couvert :** Professionnels de santé libéraux en contexte ambulatoire — France — 2026.
**Extension prévue :** Contexte hospitalier, urgences, équipes pluridisciplinaires.

---

## Question fondatrice

> Comment un professionnel de santé construit-il mentalement une représentation exploitable d'un patient ?

Cette question est antérieure à toute question de design. Elle ne demande pas "comment afficher un dossier ?" Elle demande "que se passe-t-il cognitivement avant que le praticien puisse agir de façon cliniquement pertinente ?"

La réponse détermine ce que le système doit faire. Elle ne détermine pas comment le faire — c'est le travail du design.

---

## Chaîne épistémologique

Ce document traverse cinq niveaux d'abstraction. Chaque niveau est dérivé du précédent. Aucun ne peut être court-circuité.

```
CLINICAL WORK
─────────────────────────────────────────────────────
Ce que les praticiens font.
Observable. Activités, tâches, interactions, artefacts.

                          ↓

CLINICAL COGNITION
─────────────────────────────────────────────────────
Ce qui se passe mentalement pendant ce travail.
Processus cognitifs : reconstruction, raisonnement,
charge, mémoire, confiance.

                          ↓

COGNITIVE ARCHITECTURE
─────────────────────────────────────────────────────
Comment ces processus s'organisent.
Un cycle. Des contraintes. Un réseau.
La structure de la cognition clinique.

                          ↓

COGNITIVE INVARIANTS
─────────────────────────────────────────────────────
Ce qui est toujours vrai dans cette architecture.
Lois stables, observées à travers les spécialités,
les outils, les styles individuels.

                          ↓

SYSTEM REQUIREMENTS
─────────────────────────────────────────────────────
Ce que le système doit fournir pour servir ces invariants.
Traduction en contraintes d'ingénierie.
Réutilisables par tous les Workspaces.
```

---

## Architecture du document

```
I.    Fondements méthodologiques
II.   Architecture Cognitive du Travail Clinique — le cycle
III.  Les Invariants Cognitifs — groupés par famille
IV.   La Pyramide de Transformation
V.    System Requirements — dérivation formelle
VI.   Applications par Workspace
VII.  Scope et limites
VIII. Vers CA-002
```

---

---

# I. Fondements méthodologiques

## 1.1 Source

Ce document est fondé sur l'analyse de neuf entretiens cliniques conduits avec des professionnels de santé en exercice libéral (F-001 à F-009). Chaque entretien a été analysé selon le framework F-XXX Clinical Interview Report — 16 sections standardisées incluant une section de cross-référence avec CC-000.

| Fichier | Profil | Apport principal à l'architecture |
|---|---|---|
| F-001 | Masseur-kinésithérapeute libéral | Architecture mémoire-first · Raisonnement somatique incarné |
| F-002 | Infirmière + Sophrologue libérale | Architecture documentation-centrique · Externalisation de la mémoire |
| F-003 | Médecin libéral | Règle des 30 secondes · Anchor de sécurité · SLO clinique |
| F-004 | Psychologue libérale | Raisonnement longitudinal · 5 dimensions temporelles · Boucle cycle |
| F-005 | Échographiste | Raisonnement comparatif-temporel · Protocole urgence décision |
| F-006 | Sage-femme | Dimension prospective · Horizon terme · Contexte obstétrical |
| F-007 | Kinésithérapeute (2ème profil) | Limbo informationnel · Delta-Anchor · Style cognitif individuel |
| F-008 | Infirmière libérale | Confirmation intra-profession F-002 · Anchor prescriptive |
| F-009 | Infirmière libérale coordinatrice | Cognition distribuée maximale · Anchor minimum · Horizon hebdomadaire |

## 1.2 Définition d'un invariant cognitif

Un invariant cognitif est une structure ou un processus du travail mental clinique qui :

1. A été observé dans **tous les profils** du corpus, ou dans un nombre suffisant pour être traité comme structurel
2. Reste stable malgré la **diversité** des spécialités, des outils, et des styles individuels
3. **Précède** toute décision de design — il ne dépend d'aucun outil
4. Peut être **réfuté** par une observation contraire documentée et datée

Un invariant cognitif n'est **pas** :
- Un design pattern (l'Anchor est un design pattern — Niveau 4)
- Un principe UX (la Progressive Disclosure est un principe UX — Niveau 4)
- Un besoin utilisateur formulé (les besoins sont dérivés des invariants — Niveau 2)
- Un System Requirement (les requirements sont traduits des besoins — Niveau 3)

## 1.3 Ce que ce document ne fait pas

Ce document ne prescrit pas d'interface. Il ne prescrit pas de composant. Il ne prescrit pas de workflow applicatif.

Il décrit la structure cognitive du travail clinique. Le design est la traduction de cette structure en interface. Cette traduction est le travail du designer, informé par ce document — pas dicté par lui.

---

---

# II. Architecture Cognitive du Travail Clinique

## 2.1 Le cycle cognitif clinique

Le travail clinique n'est pas une liste de tâches. C'est un cycle fermé. Chaque rencontre avec un patient est une itération de ce cycle. La documentation d'une rencontre est l'input de la suivante.

```
                    ┌─────────────────────────┐
                    │                         │
                    ▼                         │
            ┌───────────────┐                 │
            │  PERCEPTION   │                 │
            │               │                 │
            │ Le praticien  │                 │
            │ arrive. Perçoit│                │
            │ le patient,   │                 │
            │ l'environnement│                │
            │ les signaux.  │                 │
            └───────┬───────┘                 │
                    │                         │
                    ▼                         │
    ┌───────────────────────────────┐         │
    │    CONTEXT RECONSTRUCTION     │         │
    │                               │         │
    │ Lecture notes / dossier /     │         │
    │ contributions équipe.         │         │
    │ Construction représentation   │         │
    │ minimale suffisante.          │         │
    │                               │         │
    │ ← CI-01 · CI-02 · CI-03       │         │
    │ ← CI-04 · CI-05               │         │
    └───────────────┬───────────────┘         │
                    │                         │
                    ▼                         │
            ┌───────────────┐                 │
            │ MENTAL MODEL  │                 │
            │               │                 │
            │ Représentation │                │
            │ cognitive      │                │
            │ exploitable.   │                │
            │ Compressée.    │                │
            │ Rôle-spécifique│                │
            └───────┬───────┘                 │
                    │                         │
                    ▼                         │
        ┌───────────────────────┐             │
        │   CLINICAL REASONING  │             │
        │                       │             │
        │ System 1 : pattern    │             │
        │ recognition (experts) │             │
        │                       │             │
        │ System 2 : analyse    │             │
        │ délibérative          │             │
        │ (complexe / nouveau)  │             │
        └───────────┬───────────┘             │
                    │                         │
                    ▼                         │
            ┌───────────────┐                 │
            │   DECISION    │                 │
            │               │                 │
            │ Action /      │                 │
            │ Orientation / │                 │
            │ Report /      │                 │
            │ Délégation.   │                 │
            │               │                 │
            │ Appartient    │                 │
            │ toujours au   │                 │
            │ praticien.    │                 │
            └───────┬───────┘                 │
                    │                         │
                    ▼                         │
            ┌───────────────┐                 │
            │    ACTION     │                 │
            │               │                 │
            │ Acte clinique,│                 │
            │ prescription, │                 │
            │ transmission, │                 │
            │ coordination. │                 │
            └───────┬───────┘                 │
                    │                         │
                    ▼                         │
        ┌───────────────────────┐             │
        │    DOCUMENTATION      │             │
        │                       │             │
        │ La note, le compte    │             │
        │ rendu, la transmission│             │
        │ produit l'input de    │             │
        │ la prochaine          │             │
        │ reconstruction.       │             │
        │                       │             │
        │ ← CI-03 · CI-04       │             │
        └───────────┬───────────┘             │
                    │                         │
                    ▼                         │
        ┌───────────────────────┐             │
        │      NEW CONTEXT      │─────────────┘
        │                       │
        │ La documentation      │
        │ devient contexte      │
        │ disponible pour la    │
        │ prochaine rencontre — │
        │ et pour les autres    │
        │ praticiens du réseau. │
        └───────────────────────┘
```

## 2.2 Description des huit phases

**Phase 1 — Perception**

Le praticien arrive à la rencontre clinique. Il perçoit : l'état apparent du patient, les signaux de l'environnement, les alertes du système, les informations entrantes (appels, résultats, demandes). La perception n'est pas passive — elle est filtrée par le contexte cognitif disponible. Un praticien qui a reconstruit le contexte d'un patient perçoit ses signaux différemment qu'un praticien qui l'ouvre à froid.

**Phase 2 — Context Reconstruction**

C'est la phase centrale du cycle. Le praticien construit une représentation exploitable de la situation du patient. Il mobilise : sa mémoire (si le patient est connu), les artefacts disponibles (notes, dossier, ordonnances), les contributions d'autres praticiens (transmissions, comptes rendus). Cette reconstruction est toujours compressée (CI-03), temporellement orientée (CI-02 — delta pour les patients connus), et calibrée par l'attribution des sources (CI-05).

Deux architectures coexistent dans le corpus :
- *Mémoire-first (F-001, F-003, F-007 partiel)* — la reconstruction s'appuie principalement sur la mémoire à long terme. Les artefacts sont des vérifications, pas des sources primaires.
- *Documentation-centrique (F-002, F-004, F-008, F-009)* — la reconstruction s'appuie principalement sur la relecture des notes. La mémoire est temporaire entre les séances.

**Phase 3 — Mental Model**

Le résultat de la reconstruction : une représentation cognitive exploitable, suffisante pour raisonner. Elle est rôle-spécifique dans son contenu — le modèle d'un médecin et celui d'une infirmière sur le même patient diffèrent structurellement. Elle est compressée — ce qui n'est pas pertinent maintenant n'est pas chargé.

> *"Je cherche la dernière séance. En quelques lignes, je sais où j'en suis."* — F-002

**Phase 4 — Clinical Reasoning**

Le praticien raisonne depuis le modèle mental. Deux modes coexistent (Kahneman, Croskerry) :

- *System 1 — Reconnaissance de pattern* : pour les patients connus, les situations fréquentes, les experts. La décision émerge avant la réflexion analytique. Rapide, économe en ressources cognitives. Observé dans F-001 (somatique), F-003 (30 secondes), F-007 (expérimenté).
- *System 2 — Analyse délibérative* : pour les situations inhabituelles, les patients complexes, les praticiens moins expérimentés. Raisonnement explicite, étape par étape. Observé dans F-004 (5 dimensions longitudinales), F-005 (comparaison temporelle d'images).

Pour les patients en suivi, le raisonnement est majoritairement delta-centré (CI-02) : "qu'est-ce qui a changé depuis la dernière fois ?" est la question organisatrice, pas "qui est ce patient ?".

**Phase 5 — Decision**

Le raisonnement produit une décision. Elle appartient toujours au praticien — sans exception dans le corpus. Quatre types observés :
- *Action directe* — acte clinique, prescription, réalisation
- *Orientation* — transmission à un autre praticien
- *Report délibéré* — traiter plus tard (avec rappel ou note)
- *Délégation* — passer à un collègue avec contexte transmis

La décision est calibrée par la confiance dans les informations qui l'ont alimentée (CI-05).

**Phase 6 — Action**

La décision est exécutée. L'action peut être un acte corporel (kinésithérapie, injection), informationnelle (rédaction, transmission), ou coordinatrice (appel, relais). Dans les profils de coordination (F-009), la phase Action est souvent informelle — "je passe à une collègue" — mais elle doit être tracée pour alimenter correctement la documentation.

**Phase 7 — Documentation**

C'est la phase la plus sous-estimée. La documentation n'est pas une tâche administrative — elle est la production de l'input du prochain cycle. Tout ce qui n'est pas documenté disparaît du cycle.

> *"La note post-consultation, c'est la production du prochain Anchor."* — F-004
> *"Tant que je n'ai pas eu le temps de l'inscrire, elle n'en fait pas vraiment partie."* — F-007

Le **limbo informationnel** (F-007, F-009) est un phénomène de cette phase : information reçue ou produite mais non encore documentée. Elle est dans un état intermédiaire — `REÇUE → [LIMBO] → INTÉGRÉE → UTILISÉE`. Si la documentation n'a pas lieu, l'information disparaît sans avoir rejoint le cycle.

**Phase 8 — New Context**

La documentation devient un contexte disponible. Pour le même praticien lors de la prochaine rencontre — et pour les autres praticiens du réseau de soin (CI-04). C'est le mécanisme par lequel la cognition distribuée fonctionne : chaque praticien contribue à un contexte partagé que les autres utilisent dans leur propre cycle.

## 2.3 Propriétés structurelles du cycle

**Le cycle est fermé.** La documentation d'une rencontre est l'input de la suivante. Il n'y a pas de "fin" — seulement des itérations. Cette fermeture a une conséquence de design critique : une mauvaise documentation dégrade toutes les reconstructions futures.

**CI-04 traverse tout le cycle.** Les autres praticiens du réseau contribuent à la reconstruction (leurs notes), au raisonnement (leurs observations), à l'action (la coordination), et leurs propres documentations alimentent le cycle du praticien concerné.

**CI-03 contraint chaque phase.** La charge cognitive est une ressource limitée à chaque étape : perception filtrée, reconstruction compressée, modèle minimal, raisonnement raccourci par l'expertise, décision rapide, documentation différée. Un système qui ajoute de la charge à n'importe quelle phase dégrade l'ensemble du cycle.

**Le cycle peut être interrompu.** Entre toute phase, une interruption externe (appel, urgence, demande collègue) peut survenir. Pour les cliniciens directs (F-001 à F-008), c'est un coût. Pour les coordinateurs (F-009), les interruptions *sont* les cycles — ils gèrent N cycles en parallèle pour N patients.

---

---

# III. Les Invariants Cognitifs

Les invariants sont groupés en quatre familles. Chaque famille correspond à un enjeu cognitif structurant identifié dans le cycle.

---

## Famille 1 — Construction du Contexte

*Ces invariants gouvernent les phases Perception, Context Reconstruction et Mental Model du cycle.*

---

### CI-01 — Reconstruction de contexte avant action

**Énoncé :** Tout professionnel de santé reconstruit mentalement une représentation minimale de la situation d'un patient avant d'agir ou de raisonner. Cette reconstruction est systématique, qu'elle soit consciente ou automatisée.

**Observation terrain :**

> *"Avant d'entrer dans la chambre, je relis rapidement mes notes."* — F-002
> *"En 30 secondes je dois savoir où j'en suis avec ce patient."* — F-003
> *"Je cherche la dernière séance."* — F-002, F-008
> *"Je regarde son identité, sa pathologie principale, son traitement."* — F-009
> *"Je me souviens de tout. Je n'ai pas besoin de relire."* — F-001

**Profils confirmant :** 9/9

**Structure minimale de la reconstruction :**

La reconstruction construit toujours une représentation sur trois axes :
1. **Identification** — qui est ce patient, quel est son contexte
2. **Situation courante** — où en est-on à ce moment
3. **Intention de rencontre** — ce qui est prévu ou attendu

La reconstruction peut être quasi-instantanée (expert + patient connu + mémoire-first) ou longue (patient nouveau + documentation-centrique). Elle n'est jamais absente.

**Anchor de sécurité minimum (observé dans F-009, cohérent avec F-003) :**

Quand contraint à l'essentiel, tout praticien identifie spontanément le même triptyque :
- Identité et contact du patient
- Pathologie principale active
- Traitement en cours

Ces trois éléments sont le plancher informationnel en deçà duquel une prise en charge sécurisée est impossible.

**Corollaire :** Le raisonnement clinique ne commence qu'après la reconstruction. Si le système oblige le praticien à chercher de l'information pendant qu'il essaie de raisonner, les deux processus se dégradent mutuellement.

---

### CI-02 — Raisonnement delta pour les patients en suivi

**Énoncé :** Pour un patient déjà connu, la question cognitive primaire est "qu'est-ce qui a changé depuis la dernière interaction ?" — jamais "qui est ce patient ?". Le praticien raisonne sur l'évolution, pas sur l'état.

**Observation terrain :**

> *"Ce qui s'est passé : hospitalisation, nouveaux traitements, amélioration, aggravation."* — F-009
> *"Comment ça s'est passé, ce qui s'est amélioré, ce qui s'est aggravé."* — F-009
> *"Depuis quand une anomalie existe — c'est toujours la question."* — F-005
> *"Où en est ce patient ? Qu'est-ce qui a changé ?"* — F-004
> *"L'évolution depuis la dernière séance."* — F-007

**Profils confirmant :** 9/9 pour les patients en suivi

**Deux modes de reconstruction selon le contexte :**

| Mode | Contexte | Question primaire | Observé dans |
|---|---|---|---|
| **Mode delta** | Patient connu, suivi régulier | "Qu'est-ce qui a changé ?" | F-002 à F-009 |
| **Mode état** | Patient nouveau / reprise après interruption longue | "Qui est ce patient ?" | F-001, F-009 (nouveaux patients) |

Le mode delta est dominant en contexte ambulatoire libéral. Le mode état est requis pour les urgences, les premières consultations, et les reprises après hospitalisation ou longue interruption.

**Delta formalisé — quatre questions observées chez F-009 :**
1. Comment ça s'est passé (état général)
2. Ce qui s'est amélioré (évolution positive)
3. Ce qui s'est aggravé (évolution négative)
4. Modification de traitement (événement clinique)

**Corollaire :** L'affichage par défaut d'un patient en suivi doit exposer l'évolution (delta), pas le dossier statique. Un dossier qui s'ouvre sur "toute l'histoire" répond à la mauvaise question.

---

## Famille 2 — Gestion de la Charge Cognitive

*Ces invariants gouvernent l'ensemble du cycle — ils le contraignent à chaque phase.*

---

### CI-03 — Limitation active de la charge cognitive

**Énoncé :** La mémoire de travail clinique est limitée. Tout praticien développe des stratégies actives pour maintenir sa charge cognitive dans des limites opérationnelles : filtrage, externalisation, délégation, partitionnement temporel.

**Observation terrain :**

> *"Si je ne note pas, j'oublie."* — F-009
> *"Je ne dis presque jamais 'je me souviens'. Je relis rapidement mes notes."* — F-002, F-008
> *"La charge mentale est énorme. Tout le monde m'appelle."* — F-009
> *"Je note après la séance, pas devant le patient."* — F-004, F-006, F-009
> *"Je me mets un rappel. Je la traiterai plus tard."* — F-009

**Profils confirmant :** 9/9

**Trois stratégies de limitation observées :**

*Externalisation* — transférer la charge mémorielle vers un artefact (notes, template, logiciel). L'artefact devient la mémoire de travail externe. Le praticien ne retient que les pointeurs. Observé dans F-002, F-004, F-008, F-009.

*Filtrage* — réduire volontairement l'information consultée au minimum pertinent pour l'action du moment. Ne pas lire le dossier complet — chercher ce qui compte maintenant. Observé dans F-003 (30 secondes), F-005 (une question précise), F-009 (3 éléments).

*Partitionnement temporel* — reporter les informations non urgentes à un créneau cognitif dédié. Pendant le soin / après le soin / fin de journée / fin de semaine. Observé dans F-007 (clôture en 3 conditions), F-009 (horizon hebdomadaire), F-002, F-004.

**Trois types de charge cognitive (Sweller, 1988) :**

| Type | Nature | Rôle du système |
|---|---|---|
| **Intrinsèque** | Complexité de la situation clinique | Aucun — irréductible |
| **Extrinsèque** | Charge ajoutée par l'interface et la navigation | **Minimiser** — c'est le rôle premier |
| **Germane** | Charge productive : apprentissage, schémas | Préserver — ne pas éliminer |

**Le limbo informationnel :**

Phénomène documenté entre les phases Documentation et New Context du cycle :

```
Information  →  [LIMBO]  →  INTÉGRÉE  →  UTILISÉE
reçue/produite
```

Le limbo est l'état d'une information produite ou reçue mais non encore intégrée au cycle. Elle existe dans le monde mais pas dans le raisonnement clinique actif. Si la documentation ou l'intégration n'a pas lieu, l'information peut disparaître — risque clinique documenté (F-007, F-009).

**Corollaire :** La mesure d'une interface n'est pas sa richesse — c'est sa pertinence. Chaque élément affiché qui n'est pas nécessaire à l'action du moment est une charge extrinsèque.

---

## Famille 3 — Cognition Distribuée

*Ces invariants gouvernent les phases Action, Documentation et New Context — et traversent tout le cycle via les contributions des autres praticiens.*

---

### CI-04 — Cognition distribuée dans le réseau de soin

**Énoncé :** Le raisonnement clinique n'est pas localisé dans l'esprit d'un seul praticien. Il est distribué entre les acteurs du soin (équipe, prescripteurs, patient), les artefacts (dossier, ordonnances, transmissions) et les outils (logiciel). Optimiser pour un individu sans modéliser le réseau peut dégrader le système clinique global.

**Observation terrain :**

> *"Je fais le lien entre les médecins, les infirmières, les pharmaciens et les patients."* — F-009
> *"Tant que je n'ai pas inscrit le résultat, il n'existe pas vraiment pour l'équipe."* — F-007
> *"Le compte rendu est envoyé au médecin prescripteur."* — F-006, F-007, F-008
> *"J'appelle le médecin si je détecte quelque chose d'anormal."* — F-005, F-009

**Profils confirmant :** 9/9 — degré variable (minimal F-001, maximal F-009)

**Deux formes de distribution observées :**

*Distribution séquentielle* — chaque praticien produit une documentation que le suivant utilisera pour sa reconstruction. La connaissance clinique se construit par accumulation inter-professionnelle dans le temps. Observé dans 8/9 profils.

*Distribution synchrone* — plusieurs praticiens coordonnent activement, en temps réel, autour d'un même patient. F-009 (coordinatrice) en est le cas maximal : elle est le nœud d'un réseau actif de médecins, pharmaciens, infirmières, prescripteurs.

**Le praticien coordinateur — profil émergent :**

F-009 révèle un profil cognitif structurellement différent : la coordinatrice *est* la cognition distribuée. Son travail n'est pas de soigner directement — c'est de faire circuler la bonne information entre les bons acteurs au bon moment. Les interruptions ne perturbent pas son cycle — elles *sont* ses cycles, en parallèle, pour N patients.

**Corollaire :** L'unité d'analyse du design n'est pas le praticien — c'est le réseau de soin autour d'un patient. Une interface qui optimise pour un individu sans modéliser ses connexions produit des angles morts cliniques.

---

## Famille 4 — Confiance et Attribution

*Ces invariants gouvernent la phase Context Reconstruction — la qualité du modèle mental dépend de la confiance dans les sources.*

---

### CI-05 — Calibration de la confiance par attribution

**Énoncé :** Un praticien ne traite pas toute information avec le même poids. Il calibre sa confiance en fonction de trois paramètres : qui a produit l'information, dans quel contexte, et quand. Une information sans attribution crée une confiance non calibrée — risque clinique documenté.

**Observation terrain :**

> *"Je regarde toujours qui a prescrit, et quand."* — F-008
> *"Son traitement en cours — et donc par qui il a été prescrit."* — F-009
> *"Je relisais la séance précédente — ma propre note."* — F-002, F-004

**Profils confirmant :** 7/9 explicite — 2/9 implicite

**Trois paramètres d'attribution observés :**

| Paramètre | Exemple terrain | Impact sur la confiance |
|---|---|---|
| **Auteur** | Qui a écrit cette note ? Qui a prescrit ? | Un médecin spécialiste vs un étudiant : poids différent |
| **Temporalité** | Quand cette information a-t-elle été produite ? | Une note d'il y a 3 ans vs de la semaine dernière |
| **Contexte de production** | Urgence ? Consultation de routine ? Première rencontre ? | Même information, fiabilité différente selon le contexte |

**Corollaire :** Toute information affichée dans le système doit être attribuée. Source + date + contexte de production ne sont pas des métadonnées optionnelles — ce sont des conditions de la confiance clinique. Une information sans attribution n'est pas affichée comme information de confiance.

---

---

# IV. La Pyramide de Transformation

Cette pyramide trace le chemin de ce qui est observé à ce qui est produit. Chaque niveau est dérivé du précédent — jamais inventé.

```
┌──────────────────────────────────────────────────────────────────┐
│  NIVEAU 1 — INVARIANTS COGNITIFS                                 │
│                                                                  │
│  FAMILLE 1 — Context Construction                                │
│    CI-01  Reconstruction de contexte avant action                │
│    CI-02  Raisonnement delta pour les patients en suivi          │
│                                                                  │
│  FAMILLE 2 — Cognitive Load                                      │
│    CI-03  Limitation active de la charge cognitive               │
│                                                                  │
│  FAMILLE 3 — Distributed Cognition                               │
│    CI-04  Cognition distribuée dans le réseau de soin            │
│                                                                  │
│  FAMILLE 4 — Trust & Attribution                                 │
│    CI-05  Calibration de la confiance par attribution            │
│                                                                  │
│  → Ce que le cerveau fait. Observé. Non négociable.              │
└─────────────────────────┬────────────────────────────────────────┘
                          ↓
┌──────────────────────────────────────────────────────────────────┐
│  NIVEAU 2 — BESOINS COGNITIFS                                    │
│                                                                  │
│  Comprendre la situation courante rapidement        ← CI-01      │
│  Identifier ce qui a changé depuis la dernière fois ← CI-02      │
│  Ne pas saturer la mémoire de travail               ← CI-03      │
│  Voir les contributions des autres acteurs          ← CI-04      │
│  Connaître la source et l'âge de chaque information ← CI-05      │
│                                                                  │
│  → Ce que le praticien a besoin de faire cognitivement.          │
│    Toujours formulé du point de vue du praticien.                │
└─────────────────────────┬────────────────────────────────────────┘
                          ↓
┌──────────────────────────────────────────────────────────────────┐
│  NIVEAU 3 — SYSTEM REQUIREMENTS                                  │
│                                                                  │
│  Le système doit permettre la reconstruction en < 30s            │
│  Le système doit exposer le delta en vue par défaut              │
│  Le système doit limiter l'information visible par défaut        │
│  Le système doit rendre visible les contributions inter-prof.    │
│  Le système doit attribuer chaque information (source + date)    │
│                                                                  │
│  → Ce que le système doit fournir.                               │
│    Dérivé des besoins. Neutre sur le comment.                    │
│    Réutilisable par tous les Workspaces.                         │
└─────────────────────────┬────────────────────────────────────────┘
                          ↓
┌──────────────────────────────────────────────────────────────────┐
│  NIVEAU 4 — UX PRINCIPLES                                        │
│                                                                  │
│  Anchor           → implémente reconstruction minimale + delta   │
│  Progressive Disclosure → implémente limitation cognitive        │
│  Delta View       → implémente "ce qui a changé"                 │
│  Source Visibility → implémente attribution                      │
│  Team Panel       → implémente cognition distribuée              │
│                                                                  │
│  → Comment les requirements sont implémentés.                    │
│    Décisions de design. Modifiables si meilleure solution.       │
└─────────────────────────┬────────────────────────────────────────┘
                          ↓
┌──────────────────────────────────────────────────────────────────┐
│  NIVEAU 5 — UI                                                   │
│                                                                  │
│  Anchor Card · Delta Section · Expandable Detail                 │
│  Source Badge · Team Contributions Panel · Alert Triage          │
│                                                                  │
│  → Composants et widgets.                                        │
│    Dérivés des principes. Validés par tests utilisateurs.        │
└──────────────────────────────────────────────────────────────────┘
```

**Règle de la pyramide :** Un élément de niveau N ne peut pas remonter au niveau N-1. L'Anchor est Niveau 4 — elle ne peut pas devenir un invariant cognitif. Si une décision de design semble être un invariant, c'est qu'on n'a pas encore identifié l'invariant qui la justifie.

**Conséquence pratique :** Tout débat de design sur "doit-on utiliser l'Anchor ou autre chose ?" se règle au Niveau 3 — en vérifiant que la solution proposée satisfait les System Requirements. Ce n'est pas un débat de goût. C'est une vérification de conformité.

---

---

# V. System Requirements — dérivation formelle

Les System Requirements sont formulés de façon système-agnostique. Ils ne prescrivent pas un Workspace particulier. Ils contraignent tout système qui prétend servir le travail cognitif clinique.

Chaque Workspace implémente ces requirements différemment selon son contexte.

---

### SR-01 — Reconstruction de contexte en moins de 30 secondes

**Source :** CI-01 + F-003 (*"En 30 secondes je dois savoir."*)

**Énoncé :** Le système doit permettre à un praticien expert de reconstruire un contexte clinique suffisant pour initier son acte en 30 secondes ou moins, pour tout patient déjà pris en charge.

**Paramètre de mesure :** Temps entre l'ouverture du contexte patient et la première action clinique pertinente (p95).

**Non-négociable :** Au-delà de 30 secondes, le praticien reconstitue le contexte de mémoire — pas depuis le système. Le système est alors ignoré et devient un obstacle.

---

### SR-02 — Delta comme état par défaut pour les patients en suivi

**Source :** CI-02

**Énoncé :** Le système doit exposer en premier plan l'évolution depuis la dernière interaction pour tout patient vu au moins une fois. L'accès au dossier complet est possible mais ne doit jamais être l'état par défaut.

**Delta minimum requis :**
- Ce qui s'est passé depuis la dernière séance
- Ce qui a changé dans les traitements ou la situation clinique
- Ce qui est prévu ou attendu pour la rencontre actuelle

---

### SR-03 — Information minimale par défaut, complète sur demande

**Source :** CI-03 + CI-01

**Énoncé :** Le système doit afficher par défaut uniquement ce qui est nécessaire à l'action du moment. L'information supplémentaire est rendue accessible progressivement, sur action explicite du praticien.

**Interdit :** Le système ne doit jamais afficher toutes les informations disponibles à l'ouverture d'un contexte patient.

---

### SR-04 — Anchor de sécurité minimum accessible en permanence

**Source :** CI-01 + CI-03 + F-009, F-003

**Énoncé :** Le système doit rendre accessibles en un coup d'œil, sans navigation, pour tout patient :
- Identité et coordonnées
- Pathologie principale active
- Traitement en cours

Ces trois éléments constituent le plancher informationnel de sécurité clinique. Ils ne peuvent être placés dans un onglet secondaire ou une page de détail.

---

### SR-05 — Contributions inter-professionnelles visibles et attribuées

**Source :** CI-04 + CI-05

**Énoncé :** Le système doit rendre visibles les contributions des autres professionnels de santé au suivi d'un patient, avec pour chaque contribution : auteur, rôle dans le soin, date.

---

### SR-06 — Attribution obligatoire de toute information

**Source :** CI-05

**Énoncé :** Le système doit attribuer toute information affichée : qui l'a produite, quand, dans quel contexte clinique. Une information sans attribution complète ne doit pas être présentée avec le même niveau de confiance qu'une information attribuée.

---

### SR-07 — Gestion explicite du limbo informationnel

**Source :** CI-03 + observations F-007, F-009

**Énoncé :** Le système doit permettre au praticien de distinguer les informations intégrées au raisonnement actif des informations reçues ou produites mais non encore traitées. Il doit offrir un mécanisme de gestion de cette file d'attente (tri par priorité, report, délégation).

---

### SR-08 — Support de deux modes de reconstruction selon le contexte

**Source :** CI-02 + CI-01

**Énoncé :** Le système doit supporter deux configurations de présentation du contexte patient :
- **Mode suivi** (patient connu) : présentation delta, contexte condensé, ouverture rapide
- **Mode découverte** (patient nouveau ou reprise après longue interruption) : présentation état, recueil structuré, sans présupposition

---

### SR-09 — Support du profil de coordination inter-professionnelle

**Source :** CI-04 + F-009

**Énoncé :** Le système doit permettre à un praticien dont le rôle principal est la coordination inter-professionnelle de gérer une file d'informations entrantes prioritisées (urgence / à traiter / en attente / délégué), indépendamment d'un agenda de visites.

---

---

# VI. Applications par Workspace

Les System Requirements ne sont pas spécifiques au Patient Workspace. Chaque Workspace les implémente selon sa question centrale.

## Patient Workspace

**Question :** Comment un praticien reconstruit-il le contexte d'un patient avant son acte clinique ?

| Requirement | Implémentation dans le Patient Workspace |
|---|---|
| SR-01 | Anchor — résumé clinique en < 30s à l'ouverture |
| SR-02 | Delta View — ce qui a changé depuis la dernière séance |
| SR-03 | Progressive Disclosure — dossier complet sur demande |
| SR-04 | Anchor de sécurité — identité + pathologie + traitement toujours visibles |
| SR-05 | Team Panel — contributions des autres praticiens |
| SR-06 | Source Badge — auteur + date sur chaque information |
| SR-07 | Triage des informations reçues non encore intégrées |
| SR-08 | Mode suivi / Mode découverte selon le contexte de rencontre |

## Practitioner Workspace

**Question :** Comment un praticien reconstruit-il le contexte de sa journée / semaine de travail ?

| Requirement | Implémentation dans le Practitioner Workspace |
|---|---|
| SR-01 | Vue du jour — qui sont mes patients, ce qui a changé dans mon planning |
| SR-02 | Delta journalier — ce qui a changé depuis hier (nouveaux résultats, urgences) |
| SR-03 | Affichage condensé par défaut — patients de la journée, pas toutes les semaines |
| SR-07 | File de triage — informations reçues depuis la veille |
| SR-09 | Mode coordinateur — file prioritisée si le profil est coordinateur |

## Collaboration Workspace

**Question :** Comment un praticien s'inscrit-il dans le réseau de soin autour d'un patient ?

| Requirement | Implémentation dans le Collaboration Workspace |
|---|---|
| SR-05 | Vue centrale : qui est impliqué, quelle contribution |
| SR-06 | Attribution complète de chaque message, note, acte |
| SR-07 | Informations transmises / reçues / en attente de traitement |

## Care Relationship Workspace *(extension future)*

**Question :** Comment le patient et le praticien partagent-ils une représentation commune de la situation clinique ?

CI-01 et CI-02 appliqués au point de vue du patient — une recherche distincte est nécessaire. Le cycle cognitif du patient n'est pas symétrique à celui du praticien.

## Organisation Workspace *(extension future)*

**Question :** Comment une organisation de soin pilote-t-elle son activité clinique collective ?

CI-04 à l'échelle de l'organisation — agrégation des contributions individuelles. SR-05 et SR-06 à l'échelle d'un service ou d'un établissement.

---

---

# VII. Scope et limites

## Ce que ce corpus couvre

Neuf profils libéraux ambulatoires en France, 2026. Deux spécialités dupliquées (kinésithérapeute × 2, infirmière libérale × 3) permettant une validation intra-profession.

Le corpus est représentatif du contexte libéral ambulatoire : suivi de patients chroniques, pratique solitaire ou en cabinet de groupe, coordination légère à modérée.

## Ce que ce corpus ne couvre pas encore

| Contexte manquant | Risque pour les invariants |
|---|---|
| **Médecin hospitalier / urgentiste** | SR-01 en mode état exclusif (patient inconnu) — CI-02 peut ne pas s'appliquer |
| **Équipe de relève hospitalière** | CI-04 en distribution synchrone intensive — non observé en direct |
| **Spécialiste consultant** | Voit le patient une fois sur référence — mode delta absent, CI-05 central |
| **Pédiatrie** | Troisième acteur (parent) dans le cycle — non modélisé |
| **Staff pluridisciplinaire** | CI-04 en action collective simultanée — jamais observé dans ce corpus |

## Ce qui reste valide malgré ces limites

Les cinq invariants cognitifs sont des propriétés de la cognition humaine, pas des artefacts du contexte libéral. Ils sont cohérents avec la littérature cognitive (Kahneman, Hutchins, Endsley, Croskerry, Sweller).

Les System Requirements (SR-01 à SR-09) sont des contraintes minimales — ils ne seront pas invalidés par les extensions de corpus. Ils seront complétés.

---

---

# VIII. Vers CA-002

## Ce que CA-001 ne dit pas

CA-001 décrit le *quoi* et le *pourquoi* de la cognition clinique. Il décrit la structure, les invariants, les requirements.

Il ne décrit pas le *comment* — minute par minute, pas à pas — d'une rencontre clinique concrète.

## CA-002 — Cognitive Flow of Clinical Work

**Objet :** Décrire le flux cognitif réel d'un praticien depuis l'ouverture d'un dossier jusqu'à la fermeture de la séance.

**Question :** Que se passe-t-il, dans quel ordre, en combien de temps, avec quelles décisions intermédiaires, lorsqu'un praticien ouvre le contexte d'un patient et conduit sa rencontre clinique ?

**Ce que ce document permettra :**

CA-002 est le pont entre CA-001 (l'architecture) et le design concret des Workspaces. Il rend les invariants opérationnels en les ancrant dans une séquence réelle.

Exemple de flux pour un patient en suivi (ambulatoire libéral) :

```
OUVERTURE DU CONTEXTE
      ↓
Reconnaissance du patient (mémoire ou lecture rapide)
      ↓
Lecture du delta : qu'est-ce qui s'est passé ?
      ↓
Construction du modèle mental exploitable
      ↓
Prise de contact avec le patient
      ↓
Observation / Échange / Acte clinique
      ↓
Décision en cours de séance (si nécessaire)
      ↓
[Fin de séance]
      ↓
Documentation post-séance (note / compte rendu)
      ↓
Transmission si nécessaire (coordination inter-pro)
      ↓
Fermeture — le contexte devient disponible
         pour la prochaine reconstruction
```

**Format attendu :** Pas un document théorique. Chaque étape est documentée avec : durée observée, charge cognitive estimée, décisions possibles, risques d'erreur, impact sur les invariants. Des flux différenciés par profil (médecin, infirmière, coordinatrice, psychologue) seront dérivés depuis le corpus F-001 → F-009.

**Prérequis :** CA-001 validé + au moins une session d'observation en situation réelle (pas seulement des entretiens).

---

---

# Synthèse

> **Un professionnel de santé reconstruit toujours un contexte avant d'agir.**
>
> Cette reconstruction est active, rapide, coûteuse cognitivement — et universelle.
>
> Elle cherche le minimum pertinent. Jamais la complétude.
>
> Elle raisonne sur ce qui a changé. Jamais sur l'état statique.
>
> Elle s'appuie sur un réseau d'acteurs et d'artefacts. Jamais sur la mémoire individuelle seule.
>
> Elle calibre la confiance par l'attribution. Jamais par la simple présence de l'information.
>
> Ce cycle — Perception → Reconstruction → Modèle → Raisonnement → Décision → Action → Documentation → Nouveau Contexte — est la structure de tout travail clinique.
>
> Tout Workspace MedLink est une traduction de ce cycle en interface.
> Il ne crée pas la cognition clinique. Il la sert.

---

## Références

| Auteur | Œuvre | Lien avec CA-001 |
|---|---|---|
| Kahneman, D. (2011) | *Thinking, Fast and Slow* | Cycle phase 4 : System 1/2 · Raisonnement dual process |
| Hutchins, E. (1995) | *Cognition in the Wild* | CI-04 : le raisonnement est dans le réseau, pas dans la tête |
| Endsley, M. (1995) | *Toward a Theory of Situation Awareness* | CI-01, CI-02 : conscience de situation = reconstruction + delta |
| Croskerry, P. (2002, 2009) | *Achieving Quality in Clinical Decision Making* | Raisonnement dual process en médecine · Biais cognitifs |
| Sweller, J. (1988) | *Cognitive Load Theory* | CI-03 : charge intrinsèque / extrinsèque / germane |
| Klein, G. (1993) | *Naturalistic Decision Making* | CI-01 : reconnaissance de pattern · Décision en conditions réelles |
| Suchman, L. (1987) | *Plans and Situated Actions* | CI-05 : le contexte de production comme condition de sens |
| Berg, M. (1999) | *Sociology of Health & Illness* | CI-04 : le dossier médical comme artefact cognitif distribué |
| Norman, D. (1988) | *The Design of Everyday Things* | Pyramide N3→N5 : affordances et modèles mentaux en design |

---

*Ce document est vivant. Il est mis à jour à chaque extension du corpus ou invalidation d'un invariant.*
*Version 1.1 — Corpus F-001 → F-009 — Contexte libéral ambulatoire — 2026-07-30*
