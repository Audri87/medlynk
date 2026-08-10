# CI-registry — Registre des Invariants Cognitifs

**Type :** Registre normatif
**Statut :** Draft v0.1
**Date :** 2026-07-30
**Gouverné par :** CCF-000 · CCF-01 · MKO-000
**Gouverne :** CN-registry · WR-xxx · CCP-registry

---

## Structure de chaque entrée

| Champ | Description |
|---|---|
| **Identifiant** | Préfixe canonique CI-xx |
| **Statut** | Draft · Active · Under_Review · Suspended · Refuted |
| **Définition** | Énoncé formel, testable, non ambigu |
| **Motivation** | Pourquoi cet invariant existe, quel vide il comble |
| **Relations** | Liens formels avec d'autres objets du graphe (notation MKO) |
| **Justification scientifique** | Corpus terrain + littérature |
| **Dépendances** | Objets qui dérivent de cet invariant |
| **Historique** | Dates et nature des révisions |

---

---

## CI-01 — Context Reconstruction

**Identifiant :** CI-01
**Famille :** Context Construction
**Statut :** Active
**Confiance terrain :** ★★★★★ — 9/9 profils

### Définition

Tout professionnel de santé reconstruit mentalement une représentation minimale de la situation d'un patient avant d'agir ou de raisonner. Cette reconstruction est systématique, qu'elle soit consciente ou automatisée.

### Motivation

Avant d'observer CI-01, on pourrait supposer que les praticiens agissent directement sur les données disponibles. Les entretiens montrent le contraire : chaque praticien, avant d'agir, traverse une phase de construction mentale — rapide ou lente, mnésique ou documentaire — sans laquelle le raisonnement clinique ne peut commencer.

Sans CI-01, aucun requirement sur la vitesse de reconstruction ni sur la structure de l'information présentée à l'ouverture d'un contexte patient ne peut être justifié.

### Relations

```
CCF-01    --[DEFINES]-->       CI-01
CI-01     --[IMPLIES]-->       CN-01
CI-01     --[APPLIES_TO]-->    CCF-01 (Clinical Cognitive Architecture)
F-001 à F-009  --[SUPPORTS]--> CI-01  (via Evidence EV-CI01)
Klein 1993     --[SUPPORTS]--> CI-01  (Recognition-Primed Decision)
Endsley 1995   --[SUPPORTS]--> CI-01  (SA Level 1 — Perception)
```

### Justification scientifique

**Corpus terrain :** 9/9 profils confirment explicitement une phase de reconstruction avant l'acte clinique. La forme varie — mnésique (F-001, F-003) ou documentaire (F-002, F-004, F-008, F-009) — mais le mécanisme est présent dans tous les profils.

Verbatims représentatifs :
- *"Avant d'entrer dans la chambre, je relis rapidement mes notes."* — F-002
- *"En 30 secondes je dois savoir où j'en suis avec ce patient."* — F-003
- *"Je me souviens de tout. Je n'ai pas besoin de relire."* — F-001
- *"Je regarde son identité, sa pathologie principale, son traitement."* — F-009

**Littérature :** Klein (1993) — Recognition-Primed Decision : les experts activent un schéma de situation avant d'agir. Endsley (1995) — Situation Awareness Level 1 (perception) comme condition préalable au raisonnement.

**Condition de réfutation :** Observation directe (non auto-rapportée) de praticiens agissant cliniquement de façon correcte et répétée sans aucune forme d'activation contextuelle préalable — ni mnésique, ni documentaire, ni perceptive.

### Structure minimale de la reconstruction

La reconstruction construit toujours une représentation sur trois axes :
1. **Identification** — qui est ce patient, quel est son contexte
2. **Situation courante** — où en est-on à ce moment
3. **Intention de rencontre** — ce qui est prévu ou attendu

### Dépendances

- **CN-01** — Cognitive Need : je dois comprendre rapidement la situation courante
- **WR-01** — Reconstruction de contexte en < 30 secondes
- **WR-04** — Anchor de sécurité minimum accessible
- **WR-08** — Deux modes (suivi / découverte)
- **CCP-001, CCP-002, CCP-003** — configurent l'expression de CI-01

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — corpus F-001 à F-009 |

---

---

## CI-02 — Delta Reasoning

**Identifiant :** CI-02
**Famille :** Context Construction
**Statut :** Active
**Confiance terrain :** ★★★★★ — 9/9 profils en suivi

### Définition

Pour un patient déjà connu, la question cognitive primaire est "qu'est-ce qui a changé depuis la dernière interaction ?" et non "qui est ce patient ?". Le praticien raisonne sur l'évolution, pas sur l'état statique.

### Motivation

CI-02 complète CI-01 en précisant le *contenu privilégié* de la reconstruction pour les patients en suivi. Sans CI-02, on pourrait concevoir une interface qui présente l'historique complet du patient à chaque ouverture — ce qui est précisément ce que tous les praticiens en suivi évitent. CI-02 justifie que le delta soit l'état par défaut.

Note : CI-02 est indépendant de CI-01. CI-01 dit *que* la reconstruction a lieu. CI-02 dit *ce que* cette reconstruction cherche en priorité pour les patients connus. Ce sont deux dimensions différentes.

### Relations

```
CCF-01         --[DEFINES]-->   CI-02
CI-02          --[IMPLIES]-->   CN-02
F-002 à F-009  --[SUPPORTS]-->  CI-02  (via Evidence EV-CI02)
Endsley 1995   --[SUPPORTS]-->  CI-02  (SA Level 2 — Comprehension of change)
```

### Justification scientifique

**Corpus terrain :** 9/9 profils en suivi. Le raisonnement delta est le mode dominant en contexte ambulatoire libéral. Mode état (patient nouveau / reprise longue) observé également dans F-001 et F-009 pour les nouveaux patients.

Verbatims représentatifs :
- *"Ce qui s'est passé : hospitalisation, nouveaux traitements, amélioration, aggravation."* — F-009
- *"Depuis quand une anomalie existe — c'est toujours la question."* — F-005
- *"L'évolution depuis la dernière séance."* — F-007
- *"Comment ça s'est passé, ce qui s'est amélioré, ce qui s'est aggravé."* — F-009

**Deux modes de reconstruction observés :**

| Mode | Contexte | Question primaire |
|---|---|---|
| **Delta** | Patient connu, suivi régulier | "Qu'est-ce qui a changé ?" |
| **État** | Patient nouveau / reprise après interruption | "Qui est ce patient ?" |

**Condition de réfutation :** Observation de praticiens en suivi régulier qui, dans plus de 50 % des cas observés in vivo, ouvrent l'historique complet plutôt que le delta.

### Dépendances

- **CN-02** — Cognitive Need : je dois identifier ce qui a changé
- **WR-02** — Delta comme état par défaut
- **WR-08** — Deux modes (suivi / découverte)

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — corpus F-001 à F-009 |

---

---

## CI-03 — Cognitive Load Management

**Identifiant :** CI-03
**Famille :** Cognitive Load
**Statut :** Active — révision de falsifiabilité requise
**Confiance terrain :** ★★★★ — 9/9 profils / falsifiabilité insuffisante

### Définition

La mémoire de travail clinique est limitée. Tout praticien développe des stratégies observables pour maintenir sa charge cognitive dans des limites opérationnelles : filtrage de l'information, externalisation mémorielle, délégation de tâches, partitionnement temporel.

**Note de révision :** L'énoncé "tout praticien développe des stratégies actives" risque la non-falsifiabilité si "actives" inclut les stratégies implicites ou automatisées. Une révision est en cours pour préciser les critères observables distinguant la stratégie de la contrainte intrinsèque.

### Motivation

Sans CI-03, aucun requirement sur la quantité d'information affichée par défaut ne peut être justifié. CI-03 fonde l'obligation de progressivité dans la présentation de l'information et l'interdiction de tout affichage exhaustif à l'ouverture.

### Relations

```
CCF-01       --[DEFINES]-->   CI-03
CI-03        --[IMPLIES]-->   CN-03
F-001 à F-009 --[SUPPORTS]--> CI-03  (via Evidence EV-CI03)
Sweller 1988  --[SUPPORTS]--> CI-03  (Cognitive Load Theory)
```

### Justification scientifique

**Corpus terrain :** 9/9 profils documentent des comportements de réduction de charge.

*Externalisation* — transférer la charge mémorielle vers un artefact. Observé dans F-002, F-004, F-008, F-009.
*Filtrage* — réduire volontairement l'information consultée. Observé dans F-003 (30 secondes), F-005 (une question précise), F-009 (3 éléments).
*Partitionnement temporel* — reporter les informations non urgentes. Observé dans F-007, F-009, F-002, F-004.

**Littérature :** Sweller (1988) — Cognitive Load Theory. Trois types de charge : intrinsèque (irréductible), extrinsèque (minimiser), germane (préserver).

**Condition de réfutation :** Observation de praticiens qui ne développent aucune stratégie de filtrage, externalisation ou partitionnement — et dont la qualité clinique n'est pas dégradée.

**Phénomène associé — Limbo informationnel :**
Information reçue ou produite mais non encore intégrée au raisonnement actif.
```
Information reçue → [LIMBO] → INTÉGRÉE → UTILISÉE
```
Observé dans F-007 et F-009. Documenté en CC-000 sous H-08.

### Dépendances

- **CN-03** — Cognitive Need : je dois pouvoir me concentrer sur peu d'informations
- **WR-03** — Information minimale par défaut
- **WR-07** — Gestion du limbo informationnel

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — note de révision falsifiabilité ajoutée |

---

---

## CI-04 — Distributed Cognition

**Identifiant :** CI-04
**Famille :** Distributed Cognition
**Statut :** Active
**Confiance terrain :** ★★★★★ — 9/9 profils (degré variable)

### Définition

Le raisonnement clinique n'est pas localisé dans l'esprit d'un seul praticien. Il est distribué entre les acteurs du soin (équipe, prescripteurs, patient), les artefacts (dossier, ordonnances, transmissions) et les outils (logiciel). Optimiser pour un individu sans modéliser le réseau peut dégrader le système clinique global.

### Motivation

Sans CI-04, le design se concentrerait sur l'expérience individuelle du praticien. CI-04 impose de considérer le réseau de soin comme unité d'analyse. Il justifie les requirements sur la visibilité des contributions inter-professionnelles et l'attribution des informations.

### Relations

```
CCF-01        --[DEFINES]-->   CI-04
CI-04         --[IMPLIES]-->   CN-04
F-001 à F-009 --[SUPPORTS]-->  CI-04  (via Evidence EV-CI04)
Hutchins 1995 --[SUPPORTS]-->  CI-04  (Cognition in the Wild)
Berg 1999     --[SUPPORTS]-->  CI-04  (dossier médical comme artefact cognitif distribué)
```

### Justification scientifique

**Corpus terrain :** 9/9 profils. Distribution minimale (F-001) à maximale (F-009 coordinatrice).

*Distribution séquentielle* — chaque praticien produit une documentation que le suivant utilisera. Observé dans 8/9 profils.
*Distribution synchrone* — plusieurs praticiens coordonnent activement autour d'un même patient. Cas maximal : F-009.

**Profil coordinateur — configuration distincte :**
F-009 révèle un profil où la coordinatrice *est* la cognition distribuée. Son travail n'est pas de soigner directement — c'est de faire circuler la bonne information entre les bons acteurs au bon moment. Modélisé dans CCP-003.

**Littérature :** Hutchins (1995) — le raisonnement est dans le réseau, pas dans la tête. Berg (1999) — le dossier médical comme artefact cognitif distribué.

**Condition de réfutation :** Observation d'un praticien dont le travail clinique est de haute qualité et qui n'utilise aucune forme de cognition distribuée — ni notes des autres, ni transmission, ni coordination.

### Dépendances

- **CN-04** — Cognitive Need : je dois voir les contributions des autres praticiens
- **WR-05** — Contributions inter-professionnelles visibles et attribuées
- **WR-09** — File de triage pour profils coordinateurs
- **CCP-003** — configure CI-04 en mode production synchrone

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — corpus F-001 à F-009 |

---

---

## CI-05 — Trust Calibration by Attribution

**Identifiant :** CI-05
**Famille :** Trust & Attribution
**Statut :** Active
**Confiance terrain :** ★★★★ — 7/9 explicite (2/9 non observé)

### Définition

Un praticien ne traite pas toute information avec le même poids. Il calibre sa confiance en fonction de trois paramètres : qui a produit l'information, dans quel contexte, et quand. Une information sans attribution crée une confiance non calibrée — risque clinique documenté.

### Motivation

Sans CI-05, une interface pourrait afficher des informations sans source ni date. CI-05 impose que toute information soit attribuée — c'est une condition de la confiance clinique, pas une option d'affichage.

### Relations

```
CCF-01         --[DEFINES]-->   CI-05
CI-05          --[IMPLIES]-->   CN-05
F-002, F-008, F-009 --[SUPPORTS]--> CI-05  (via Evidence EV-CI05)
Suchman 1987   --[SUPPORTS]-->  CI-05  (Plans and Situated Actions)
```

### Justification scientifique

**Corpus terrain :** 7/9 profils confirment explicitement la calibration par attribution. 2/9 ne mentionnent pas le phénomène — absence d'observation ne signifie pas absence du comportement.

Verbatims représentatifs :
- *"Je regarde toujours qui a prescrit, et quand."* — F-008
- *"Son traitement en cours — et donc par qui il a été prescrit."* — F-009
- *"Je relisais la séance précédente — ma propre note."* — F-002, F-004

**Trois paramètres d'attribution observés :**

| Paramètre | Exemple terrain |
|---|---|
| **Auteur** | Qui a écrit cette note ? Qui a prescrit ? |
| **Temporalité** | Quand cette information a-t-elle été produite ? |
| **Contexte de production** | Urgence ? Consultation de routine ? |

**Littérature :** Suchman (1987) — le contexte de production comme condition de sens.

**Condition de réfutation :** Étude de simulation montrant que des praticiens prennent des décisions cliniques correctes sur la base d'informations non attribuées, sans dégradation observable de la qualité clinique.

### Dépendances

- **CN-05** — Cognitive Need : je dois connaître la source de chaque information
- **WR-06** — Attribution obligatoire de toute information
- **WR-05** — Contributions inter-professionnelles attribuées

### Historique des révisions

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Création — corpus F-001 à F-009 |

---

*Registre CI — Draft v0.1 — 2026-07-30*
*Prochain invariant candidat : à identifier lors de l'extension du corpus hospitalier.*
*Toute proposition de nouvel invariant doit passer par la procédure définie dans MKG-000.*
