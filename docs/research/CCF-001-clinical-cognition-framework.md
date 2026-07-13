# Clinical Cognition Framework – CCF-001 v0.1

## Statut

Active — en cours de validation terrain

---

## Contexte

Les CCF décrivent les mécanismes cognitifs observés sur le terrain.

Ils complètent les ADR (décisions d'architecture) et les RFC (décisions ouvertes).

Les décisions d'architecture doivent être justifiées autant par le modèle métier que par les observations terrain.

---

## Corpus

Entretiens réalisés :

* Médecin
* Psychologue
* Sophrologue
* Sage-femme
* Infirmière libérale
* Coordinatrice clinique
* Échographiste

Approche qualitative. Recherche d'invariants cognitifs indépendants des logiciels utilisés.

---

## Découverte majeure

Les différences entre professions portent principalement sur les actes cliniques.

Les ressemblances portent sur les mécanismes cognitifs.

Les professionnels n'effectuent pas les mêmes gestes.

En revanche ils semblent tous suivre un cycle cognitif comparable.

---

## Cycle Cognitif Clinique

```
Préparer
    ↓
Reconstruire rapidement le contexte
    ↓
Comprendre la situation actuelle
    ↓
Prendre une décision
    ↓
Produire une nouvelle connaissance clinique
    ↓
Maintenir la continuité
    ↓
Clôturer la charge mentale
```

Ce cycle est observé chez plusieurs professions.

Il reste à être confronté à des archétypes plus éloignés (urgentistes, anesthésistes, radiologues).

---

## Observations corroborées

### O-001 — Journée commencée par le planning

Les praticiens commencent leur journée par leur planning.

Ils ne commencent jamais par parcourir un dossier complet.

---

### O-002 — Reconstruction rapide, jamais exhaustive

Avant chaque consultation, ils reconstruisent rapidement le contexte.

Ils recherchent quelques éléments prioritaires.

Jamais une lecture exhaustive.

---

### O-003 — Externalisation progressive du raisonnement

Le raisonnement clinique est progressivement externalisé.

Supports observés : logiciel, papier, modèles, copier/coller, notes, photographies.

Le support importe peu. Le mécanisme est constant.

---

### O-004 — Anamnèse comme construction du contexte

L'anamnèse n'est pas un formulaire administratif.

C'est un mécanisme de construction du contexte clinique.

---

### O-005 — Clôture de charge mentale, pas de dernier patient

La journée ne se termine pas lorsque le dernier patient part.

Elle se termine lorsque la charge mentale est refermée.

Les praticiens utilisent les périodes calmes pour intégrer les résultats, rappeler les patients et maintenir la continuité clinique.

---

### O-006 — Interruptions intégrées au travail clinique

Les interruptions font partie intégrante du travail clinique.

Téléphone, résultats, messages, nouveaux documents.

Le praticien développe des stratégies pour reprendre son raisonnement après interruption.

---

### O-007 — La continuité comme condition de clôture

Un praticien ne considère pas une Clinical Activity comme terminée au seul motif que l'acte clinique est accompli.

Il la considère terminée lorsqu'il s'est assuré que la prise en charge peut être poursuivie correctement par le prochain acteur concerné.

Le mécanisme varie selon les professions : transmissions écrites, appel téléphonique, envoi de rapport, coordination informelle.

Le besoin observé reste constant : la clôture requiert que la continuité soit assurée.

---

### O-008 — Saillance cognitive des situations non résolues

Les praticiens maintiennent une attention cognitive plus soutenue sur les situations qu'ils considèrent non résolues.

Les situations qu'ils estiment terminées s'effacent rapidement de leur attention active.

Le critère utilisé pour juger une situation résolue varie selon la profession et le contexte clinique.

Le phénomène cognitif — les situations non résolues génèrent une charge mentale persistante — est observé de manière constante entre les professions.

La charge de travail mentale semble moins déterminée par le nombre de patients que par le nombre de situations en attente de résolution.

---

## Cas clinique structurant

Entretien avec une gynécologue.

Situation : une patiente évoque des idées suicidaires. Le psychiatre connaît une partie de la situation que la patiente elle-même ne restitue pas correctement.

**Découverte : la compréhension clinique est distribuée entre plusieurs professionnels.**

Le patient ne possède pas toujours l'ensemble de cette compréhension.

Conséquence : MedLink ne doit pas seulement stocker des informations. Il doit soutenir la continuité d'une connaissance distribuée.

---

## Évolution du concept de Context Reconstruction

Initialement : Context Reconstruction était vu comme une reconstruction documentaire.

Aujourd'hui : il est compris comme un mécanisme de reprise du raisonnement clinique.

Le praticien ne cherche pas à lire le passé.

Il cherche à retrouver rapidement l'état mental nécessaire pour poursuivre son raisonnement.

---

## Conséquences architecturales provisoires

Le modèle métier reste inchangé :

```
Clinical Activity → Clinical Contribution → Care Record
```

Le Workspace devra présenter ce domaine selon les priorités cognitives de chaque profession.

**Le domaine reste commun. L'expérience de travail devient spécifique au métier.**

---

## Principe directeur

MedLink ne remplace pas le raisonnement clinique.

Il restaure le contexte nécessaire à ce raisonnement.

---

## Prochaine étape

Question centrale du prochain chantier :

> **Qu'est-ce qu'un professionnel doit comprendre dans les trente premières secondes après avoir ouvert un patient ?**

Les réponses devront être dérivées du CCF et non de choix d'interface arbitraires.
