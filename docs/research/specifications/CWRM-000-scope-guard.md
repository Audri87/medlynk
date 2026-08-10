# CWRM-000 — Constitution
## Scope Guard and Governance

**Status:** Draft v1.2
**Type:** Foundational Specification
**Category:** Governance
**Depends on:** None
**Supersedes:** None

---

## 1. Purpose

Ce document est la constitution du Clinical Work Research Method (CWRM).

Il établit :

- la philosophie de conception qui guide toutes les décisions du framework ;
- le périmètre officiel de la méthode ;
- les définitions normatives de tous les concepts fondamentaux ;
- les hypothèses assumées explicitement ;
- les règles de gouvernance et de versioning.

Aucun autre document du CWRM ne peut contredire ce document.

En cas de contradiction, ce document prévaut.

---

## 2. Design Philosophy

Le CWRM est fondé sur une conviction centrale :

> Les décisions de conception logicielle doivent être guidées par des preuves empiriques explicites plutôt que par l'intuition, les préférences individuelles ou les conventions de l'industrie.

Cette conviction repose sur trois observations :

**Les professionnels ont un travail réel.** Ce travail a une structure, des régularités, des contraintes. Il existe indépendamment de ce que les concepteurs imaginent.

**Les logiciels qui ignorent ce travail créent de la friction.** Un outil conçu sans compréhension du travail réel impose sa logique aux professionnels au lieu de s'y adapter.

**La traçabilité protège les décisions.** Une décision fondée sur une preuve peut être réévaluée, contestée, améliorée. Une décision fondée sur l'intuition ne peut pas.

Le CWRM ne prétend pas produire une description complète du travail clinique. Il produit suffisamment de compréhension pour concevoir des logiciels plus adaptés. C'est tout ce qu'il cherche à faire.

---

## 3. Framework and Methods

### 3.1 Distinction

Le CWRM est un **framework**.

Un framework définit une structure, des principes et des règles.

À l'intérieur du framework, il existe quatre **méthodes** distinctes.

Chaque méthode est un processus opérationnel avec ses propres règles, artefacts et critères de qualité.

### 3.2 Les quatre méthodes

**Méthode d'acquisition**
Comment conduire les entretiens.
Protocole, questions, collecte des verbatims, contextualisation.

**Méthode d'analyse**
Comment transformer les verbatims en connaissances.
Extraction des ACT, formulation des OBS, construction des RQ, identification des INV.

**Méthode de traduction**
Comment transformer les invariants en décisions produit.
Design Reasoning, principes UX, décisions fonctionnelles, justification des choix.

**Méthode de validation**
Comment vérifier la qualité de chaque étape.
Inter-rater reliability, Quality Gates, conditions de réfutation, audit de traçabilité.

### 3.3 Règle de séparation

Une décision prise dans une méthode ne peut pas court-circuiter une méthode antérieure.

On ne peut pas passer directement d'un verbatim à une décision produit sans passer par l'analyse et la traduction.

---

## 4. Definitions

Les termes suivants sont définis ici une seule fois.

Tous les autres documents du CWRM y font référence sans les redéfinir.

**Evidence**
Donnée issue d'un entretien avec un professionnel de santé, classifiée selon son niveau de confiance épistémique. Voir section 12 — Evidence Levels.

**Verbatim**
Citation directe, mot pour mot, extraite de l'entretien sans modification. Niveau de confiance E3.

**ACT — Reported Clinical Action**
Unité d'analyse de base. Action rapportée par un professionnel lors d'un entretien, formulée en langage descriptif sans interprétation. Format : verbe d'action + complément + contexte temporel. Une ACT = un verbe principal.

**OBS — Observation**
Régularité empirique identifiée à partir d'une ou plusieurs ACT, formulée sans langage interprétatif. Une OBS peut émerger de plusieurs ACT issues du même entretien, de comparaisons entre entretiens, d'états décrits dans les verbatims, ou d'absences documentées.

**RQ — Research Question**
Question ouverte née d'une ou plusieurs observations. Une RQ ne contient pas sa réponse. Elle oriente les analyses suivantes ou les entretiens futurs.

**INV — Invariant**
Hypothèse de conception suffisamment corroborée pour gouverner une décision produit. Un invariant est promu depuis une ou plusieurs RQ, est corroboré par des observations issues d'au moins deux professions distinctes, et est formulé comme une proposition testable et falsifiable avec une condition de réfutation explicite.

**Design Reasoning**
Étape explicite reliant un invariant à une décision de conception. Elle documente le raisonnement qui transforme une connaissance empirique en principe UX, en fonctionnalité ou en choix architectural. Elle ne peut jamais être implicite.

**CWO — Clinical Work Ontology**
Schéma conceptuel définissant les dimensions de chaque ACT : Actor, Action, Object, Purpose, Situation, Moment, Evidence, Source. Sert de cadre de référence pour l'extraction et la normalisation du corpus.

---

## 5. Assumptions

Le CWRM repose sur les hypothèses suivantes.

Elles sont assumées explicitement, pas occultées.

**A1 — Verbalisabilité partielle du travail**
Les professionnels de santé sont capables de décrire une partie significative de leur travail lors d'un entretien. Cette description est partielle : les automatismes, le savoir tacite incorporé et la reconnaissance de patterns restent structurellement sous-représentés.

**A2 — Pertinence des récits d'entretien**
Les récits issus d'entretiens constituent une représentation partielle mais pertinente du travail réel. Ils ne décrivent pas le travail avec exactitude — ils en révèlent la structure et les régularités suffisamment pour orienter des décisions de conception.

**A3 — Amélioration par la compréhension**
La conception logicielle peut être améliorée par une meilleure compréhension du travail réel des utilisateurs. Un logiciel conçu à partir de données terrain sera plus adapté qu'un logiciel conçu à partir de l'intuition ou de l'expérience du concepteur seul.

**A4 — Valeur des régularités inter-praticiens**
Les régularités identifiées à travers plusieurs praticiens et plusieurs professions sont plus utiles à la conception que les variations individuelles. La convergence est un signal de conception.

**A5 — Supériorité de la traçabilité**
Une chaîne de preuve explicite entre les données de terrain et les décisions produit génère de meilleures décisions — et des décisions plus défendables — qu'une approche fondée sur l'intuition ou l'expérience seule.

---

## 6. Mission

Le CWRM a pour mission de :

> Transformer des données qualitatives issues d'entretiens avec des professionnels de santé en décisions de conception logicielle traçables, reproductibles et justifiées.

Le CWRM n'a pas vocation à expliquer toute l'activité clinique.

Il cherche à produire suffisamment de compréhension pour améliorer la conception d'un logiciel.

---

## 7. Problem Statement

Les méthodes de conception de logiciels reposent souvent sur :

- des ateliers de conception ;
- des interviews peu structurées ;
- des personas ;
- des parcours utilisateurs ;
- l'expérience des concepteurs.

Ces approches rendent difficile :

- la justification des décisions ;
- leur reproductibilité ;
- leur réévaluation lorsque de nouvelles données apparaissent.

Le CWRM répond à ce problème en proposant une chaîne de transformation explicite reliant les données de terrain aux décisions produit.

---

## 8. Scope

Le CWRM couvre :

**Acquisition**
- entretiens semi-directifs ;
- collecte des verbatims ;
- contextualisation des données.

**Analyse**
- extraction des ACT ;
- formulation des observations ;
- construction des Research Questions ;
- identification des Invariants.

**Traduction**
- Design Reasoning ;
- principes UX ;
- décisions fonctionnelles ;
- justification des choix.

**Traçabilité**

Le framework garantit qu'une décision peut être reliée à son origine empirique.

---

## 9. Out of Scope

Le CWRM ne couvre pas les domaines suivants.

**Médecine**
Il ne produit aucun raisonnement médical.
Il n'interprète pas les données cliniques.

**Diagnostic**
Le framework ne participe pas au diagnostic.

**Théorie générale du travail**
Le CWRM ne cherche pas à expliquer le travail humain dans son ensemble.

**Psychologie cognitive**
Il ne modélise pas les processus cognitifs des praticiens.

**Ontologie médicale universelle**
Le framework ne constitue pas une ontologie clinique formelle.

**Intelligence artificielle**
L'IA peut assister certaines étapes.
Elle ne fait pas partie du cœur méthodologique.

**Architecture logicielle**
Le framework justifie les décisions.
Il ne prescrit pas une architecture technique particulière.

---

## 10. Non-goals

Cette section est distincte de Out of Scope.

Out of Scope délimite les domaines que le CWRM n'entre pas.

Non-goals précise ce que le CWRM ne cherche pas à accomplir, même à l'intérieur de son périmètre.

**Produire une description complète du travail clinique**
Le CWRM capture suffisamment, pas exhaustivement. La complétude n'est pas un critère de succès.

**Remplacer l'observation ethnographique directe**
Les entretiens ne se substituent pas au travail de terrain. Le CWRM est complémentaire à l'ethnographie, pas concurrent.

**Valider ou invalider des pratiques cliniques**
Le framework décrit ce que les praticiens rapportent faire. Il ne juge pas si ces pratiques sont correctes.

**Produire une théorie générale du travail humain**
Les invariants du CWRM sont des hypothèses de conception, pas des lois générales du comportement professionnel.

**Produire de la recherche académique comme finalité première**
La rigueur scientifique est un moyen. La publication n'est pas l'objectif.

**Standardiser la terminologie clinique**
Le CWRM utilise un vocabulaire contrôlé pour ses propres concepts. Il ne cherche pas à normaliser la terminologie médicale.

**Modéliser la cognition des professionnels de santé**
Les ACT décrivent des actions rapportées, pas des processus mentaux. Le raisonnement clinique reste hors du périmètre.

---

## 11. Research and Product Objectives

**Research Objective**

> Développer une méthode reproductible permettant de transformer des données qualitatives en décisions de conception documentées.

Le résultat attendu est une méthode. Pas une théorie générale.

**Product Objective**

Le premier domaine d'application est MedLink.

Le framework existe afin d'améliorer la qualité des décisions prises lors de la conception de MedLink.

Le succès du framework est évalué par sa capacité à produire un logiciel plus fidèle au travail réel des professionnels de santé.

---

## 12. Evidence Levels

Toutes les preuves n'ont pas le même poids.

Le CWRM reconnaît deux dimensions d'évaluation des preuves.

### 12.1 Qualité de la preuve individuelle (E1–E3)

Évalue la fiabilité d'un élément de preuve isolé.

| Niveau | Définition |
|---|---|
| E3 | Verbatim direct — citation exacte du praticien |
| E2 | Reformulation fidèle — paraphrase validée par le contexte |
| E1 | Reconstruction analytique — inférence du chercheur |

### 12.2 Force d'une observation (Level A–D)

Évalue la solidité d'une observation ou d'un invariant, en tenant compte du nombre et de la diversité des sources.

| Niveau | Définition |
|---|---|
| A | Observation directe — constatée sur le terrain, pas seulement rapportée |
| B | Verbatims convergents — plusieurs praticiens, professions différentes, même observation |
| C | Verbatim isolé — un seul praticien, non encore corroboré |
| D | Hypothèse du chercheur — reconstruction analytique sans verbatim direct |

La spécification complète des critères de promotion entre niveaux fera l'objet d'un document dédié.

---

## 13. Core Principles

Le CWRM repose sur huit principes.

**P1 — Evidence First**
Toute décision doit être fondée sur des données.

**P2 — Traceability**
Toute décision doit pouvoir être reliée à son origine.

**P3 — Reproducibility**
Deux équipes doivent pouvoir appliquer la méthode selon le même protocole.

**P4 — Explicit Reasoning**
Les étapes intermédiaires ne doivent jamais être implicites.

**P5 — Product-Oriented Research**
La recherche sert la conception. Elle n'est pas une fin.

**P6 — Minimal Necessary Modeling**
Le framework modélise uniquement ce qui est nécessaire à la prise de décision.

**P7 — Separation of Concerns**
La méthode, la connaissance, et le produit restent séparés.

**P8 — Evolvability**
Le framework peut évoluer uniquement si la modification améliore la méthode.

---

## 14. Falsifiability Principles

La falsifiabilité n'est pas une contrainte optionnelle. Elle est constitutive de la méthode.

**F1 — Toute observation doit pouvoir être réfutée**
Une OBS sans condition de réfutation n'est pas une observation. C'est une croyance.

**F2 — Tout invariant doit exposer ses conditions d'invalidation**
Un INV doit répondre à la question : dans quelles circonstances cette hypothèse serait-elle fausse ?

**F3 — Le CWRM ne cherche pas à confirmer**
Il cherche à produire la meilleure explication disponible à partir des données actuelles.

**F4 — Les nouvelles données peuvent invalider les invariants existants**
Un INV promu peut être rétrogradé si de nouvelles preuves le contredisent. C'est un signe de santé, pas d'échec.

**F5 — L'absence de réfutation n'est pas une preuve**
Si aucun contre-exemple n'existe dans le corpus, c'est peut-être parce que le corpus est insuffisant.

---

## 15. Decision Criteria

Un nouveau concept ne peut être intégré que s'il répond positivement aux questions suivantes.

**Utilité** — Améliore-t-il la qualité des décisions ?

**Traçabilité** — Renforce-t-il la chaîne de preuve ?

**Simplicité** — Est-il plus simple qu'une alternative ?

**Reproductibilité** — Peut-il être appliqué par une autre équipe ?

**Cohérence** — Respecte-t-il les principes fondateurs ?

Si une réponse est négative, le concept est rejeté ou reporté dans les Future Works.

---

## 16. Versioning

### 16.1 Règle générale

Tout changement au CWRM produit une nouvelle version.

### 16.2 Changement majeur → Version X.0

Un changement est majeur si :

- il modifie un concept fondamental (ACT, OBS, RQ, INV, Design Reasoning) ;
- il modifie le pipeline (ordre des étapes, ajout ou suppression d'une étape) ;
- il modifie une méthode (acquisition, analyse, traduction, validation) ;
- il modifie les principes ou les hypothèses fondateurs.

Un changement majeur requiert : justification argumentée, analyse d'impact sur tous les documents dépendants, validation explicite.

### 16.3 Changement mineur → Version X.Y

Un changement est mineur si :

- il corrige une formulation sans changer le sens ;
- il ajoute des exemples ou des illustrations ;
- il clarifie un terme sans le redéfinir.

Un changement mineur ne requiert pas de révision complète.

---

## 17. Governance

Ce document est le document de référence du CWRM.

En cas de contradiction entre ce document et un autre document du framework, celui-ci prévaut.

Les documents dépendants doivent référencer explicitement la version de ce document sur laquelle ils s'appuient.

---

## 18. Expected Outputs

Le CWRM produit :

- une méthode documentée ;
- des analyses reproductibles ;
- des invariants argumentés ;
- une chaîne de justification complète ;
- des d��cisions de conception traçables.

Le CWRM ne produit pas directement un logiciel.

Il produit les connaissances permettant de concevoir un logiciel.

---

## 19. Success Criteria

Le CWRM sera considéré comme réussi si une équipe indépendante est capable de :

- appliquer la méthode ;
- reproduire les principales étapes de l'analyse ;
- comprendre les décisions prises ;
- relier chaque fonctionnalité aux preuves ayant conduit à sa conception.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-31 | v1.0 | Draft initial — Foundational Specification |
| 2026-07-31 | v1.1 | Ajout : Definitions, Assumptions, Non-goals |
| 2026-07-31 | v1.2 | Ajout : Design Philosophy, Framework vs Methods, Evidence Levels (A–D), Falsifiability Principles, Versioning — renommé Constitution |
