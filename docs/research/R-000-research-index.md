# R-000 — Research Index

**Version :** 1.0
**Statut :** Document fondateur — Porte d'entrée du projet
**Date :** 2026-07-28

---

## 1. Objectif de ce document

Ce document est la porte d'entrée intellectuelle du projet MedLink.

Il n'explique pas ce que MedLink fait.

Il explique comment MedLink pense.

Plus précisément, il répond à quatre questions :

1. Pourquoi la recherche précède-t-elle le produit ?
2. Comment les documents fondateurs s'enchaînent-ils ?
3. Comment une observation de terrain devient-elle un concept métier ?
4. Comment un concept métier devient-il un choix architectural ?

Toute personne rejoignant le projet doit lire ce document avant de lire n'importe quel autre. Il n'enseigne pas le domaine clinique — il enseigne la méthode par laquelle le domaine clinique a été compris.

---

## 2. La conviction fondatrice : observation avant produit

La plupart des projets logiciels commencent par une vision.

La vision génère un produit.

Le produit génère du code.

MedLink commence différemment.

MedLink commence par une observation.

L'observation génère une question de recherche.

La question génère une théorie.

La théorie génère une constitution.

La constitution génère un modèle.

Le modèle génère une architecture.

L'architecture génère un produit.

Cette inversion n'est pas un formalisme. Elle est une protection contre l'un des risques les plus courants dans le développement logiciel : construire une solution avant d'avoir compris le problème.

**La conviction fondatrice de MedLink est la suivante :**

> Un produit qui n'est pas fondé sur une observation rigoureuse du terrain est un produit qui résout le problème qu'il imagine, pas le problème qui existe.

Les conséquences de cette conviction sont structurelles. Chaque décision dans MedLink — fonctionnelle, architecturale, ou produit — doit pouvoir être tracée jusqu'à une observation de terrain ou un invariant démontré. Si cette trace n'existe pas, la décision est suspecte.

---

## 3. La chaîne complète

La chaîne intellectuelle de MedLink comporte sept niveaux. Chaque niveau est fondé sur le précédent. Chaque niveau est plus concret que le précédent.

```
Niveau 0 — Terrain
           Observations du travail clinique réel.
           Ce qui se passe avant tout logiciel, avant toute théorie.
           ↓
Niveau 1 — Recherche
           Formalisation des observations.
           Identification du problème structurel.
           Questions de recherche. Hypothèses.
           ↓
Niveau 2 — Théorie
           Explication du problème.
           Définition des concepts fondamentaux.
           Invariants démontrés.
           ↓
Niveau 3 — Constitution
           Mission. Frontières. Philosophie.
           Ce que MedLink choisit de résoudre, et pourquoi.
           ↓
Niveau 4 — Modèle
           Concepts métier déduits de la théorie.
           Domain Atlas. Ubiquitous Language.
           Traçabilité : chaque concept pointe vers la théorie.
           ↓
Niveau 5 — Architecture
           Décisions techniques fondées sur le modèle.
           ADRs. Patterns. Contraintes.
           ↓
Niveau 6 — Produit
           Fonctionnalités. Interfaces. Expériences utilisateur.
           Ce que l'utilisateur voit et touche.
```

**Principe de priorité :**

Les niveaux supérieurs ont toujours précédence sur les niveaux inférieurs.

Si une décision de produit (Niveau 6) contredit une observation de terrain (Niveau 0), c'est la décision de produit qui doit être réexaminée — pas l'observation.

Si un choix architectural (Niveau 5) contredit un invariant théorique (Niveau 2), c'est le choix architectural qui doit être justifié ou abandonné.

Cette règle protège la cohérence du projet sur le long terme. Elle empêche que les contraintes commerciales ou techniques du moment ne déforment progressivement les fondements intellectuels du projet.

---

## 4. Les niveaux de la hiérarchie

### 4.1 Niveau 0 — Le terrain

Le terrain est la réalité du travail clinique avant toute intervention logicielle.

Il comprend : ce que les professionnels font, dans quel ordre, avec quelles informations, sous quelles contraintes, avec quels risques d'erreur, et à quel coût cognitif.

Le terrain n'est pas documenté directement dans un document de Niveau 0 — il est la source implicite de tous les documents de Niveau 1. Il précède les mots.

Toute affirmation présentée comme une observation dans les documents de Niveau 1 est censée provenir du terrain. Elle est distinguée des hypothèses par la mention explicite `[Observation]`.

### 4.2 Niveau 1 — La recherche

Les documents de recherche formalisent les observations du terrain. Ils posent des questions, cartographient le problème, formulent des hypothèses, et identifient ce que l'on sait avec certitude et ce que l'on ignore encore.

Les documents de recherche sont délibérément sans solution. Ils décrivent le problème aussi rigoureusement que possible, sans le contaminer par des réponses prématurées.

**Documents actuels :**

| Document | Question de recherche |
|---|---|
| P-001 | Pourquoi la reprise de contexte est-elle un problème structurel ? |
| CW-001 | Que fait réellement un professionnel lorsqu'il reprend un patient ? |

**Statut :** Ces documents sont figés. Ils peuvent être enrichis par de nouvelles observations, pas contredits par des décisions produit.

### 4.3 Niveau 2 — La théorie

La théorie transforme les observations en concepts. Elle répond à la question : "Pourquoi le problème observé existe-t-il, et quelles sont ses propriétés fondamentales ?"

Un document théorique est indépendant de toute implémentation. Il doit pouvoir être lu dans dix ans sans référence à une technologie ou un logiciel particulier.

**Documents actuels :**

| Document | Question théorique |
|---|---|
| M-003 | Qu'est-ce que la Compréhension Clinique ? |

**Statut :** M-003 est le sommet de la pyramide intellectuelle. Après M-003, les documents descendent vers le concret. Aucun nouveau document théorique ne doit être créé à ce niveau.

### 4.4 Niveau 3 — La constitution

La constitution traduit la théorie en engagements. Elle répond à la question : "Étant donné ce que nous savons, que choisissons-nous de résoudre, et avec quelles limites ?"

La constitution est normative : elle dit ce que MedLink est, ce qu'il fait, et ce qu'il refuse de faire.

**Documents actuels :**

| Document | Engagement |
|---|---|
| M-000 | Mission, vision, définitions fondatrices, invariants |
| M-001 | Frontières du Core Domain, règles et tests |
| M-002 | Philosophie du choix du Core Domain |

**Statut :** Ces documents sont figés. Ils ne peuvent être modifiés que par une décision explicite qui démontre que la théorie ou les observations ont évolué.

### 4.5 Niveau 4 — Le modèle

Le modèle traduit la constitution en concepts métier utilisables dans l'implémentation. Il répond à la question : "Si la théorie est vraie et la constitution est juste, quels concepts doivent exister dans le code ?"

Chaque concept du modèle est tracé vers la section ou l'invariant de la théorie qui le justifie.

**Documents attendus :**

| Document | Contenu |
|---|---|
| M-004 | Theory to Model Mapping — traçabilité théorie → concepts |
| Domain Atlas | Registre de tous les concepts métier et leurs relations |
| UL-001 | Ubiquitous Language — glossaire normatif |

**Statut :** Ces documents évoluent avec la découverte du domaine, mais chaque évolution doit être justifiée par la théorie.

### 4.6 Niveau 5 — L'architecture

L'architecture traduit le modèle en décisions techniques. Elle répond à la question : "Comment implémenter le modèle de façon à respecter ses contraintes théoriques ?"

Les ADRs (Architecture Decision Records) documentent chaque décision technique significative et la justifient par référence au modèle ou à la théorie.

**Documents existants :** Voir CLAUDE.md pour la liste complète des ADRs actifs.

### 4.7 Niveau 6 — Le produit

Le produit est l'expression visible de toute la chaîne. Il répond à la question : "Quelle expérience l'utilisateur reçoit-il ?"

Les spécifications produit, les workflows, les interfaces découlent du modèle — pas l'inverse. Une fonctionnalité qui ne peut pas être tracée jusqu'à un concept du modèle n'a pas sa place dans MedLink.

---

## 5. Les dépendances entre documents

Le schéma suivant représente les dépendances directes entre les documents fondateurs actuels.

```
Terrain (observations non documentées)
    │
    ├──▶ P-001 (formalise le problème de la reprise)
    │        │
    │        └──▶ M-003 (théorie — s'appuie sur P-001 et CW-001)
    │
    └──▶ CW-001 (formalise le travail cognitif réel)
             │
             └──▶ M-003 (théorie)
                      │
                      ├──▶ M-002 (philosophie du Core Domain)
                      │        │
                      │        └──▶ M-000 (constitution)
                      │                  │
                      │                  └──▶ M-001 (frontières)
                      │
                      └──▶ M-004 (mapping théorie → modèle) [à venir]
                                │
                                └──▶ Domain Atlas [à venir]
                                          │
                                          └──▶ ADRs
                                                    │
                                                    └──▶ Produit
```

**Règle de lecture des dépendances :**

Un document dépend des documents au-dessus de lui dans le schéma. Il peut les citer, les appliquer, les déduire. Il ne peut pas les contredire sans déclencher une révision formelle.

---

## 6. Comment une observation devient un concept métier

La transformation d'une observation de terrain en concept métier suit un parcours précis. Le tracer permet de comprendre pourquoi un concept existe — et de résister à la tentation de l'éliminer sous prétexte de simplification.

### Exemple : la Clinical Contribution

**Étape 1 — Observation de terrain** *(Niveau 0)*

Un professionnel prend des notes lors d'une consultation. Ces notes reflètent sa compréhension de la situation du patient à ce moment précis. Une semaine plus tard, un autre professionnel consulte ce dossier. Il peut lire les faits consignés, mais pas comprendre le raisonnement qui les a produits.

**Étape 2 — Formalisation du problème** *(Niveau 1 — CW-001)*

CW-001 documente que le professionnel cherche en priorité "la note de synthèse récente et bien rédigée" et que "l'explication du raisonnement accélère et sécurise la construction du modèle de situation." Il documente également que les notes "purement descriptives" constituent du bruit, pas du signal.

**Étape 3 — Concept théorique** *(Niveau 2 — M-003)*

M-003, Section 3, décompose la Compréhension Clinique en sept composants — dont le "raisonnement interprétatif" (3.2), les "décisions prises et leur justification" (3.5), et le "point de vue et contexte de production" (3.7). La Section 9, Invariant I établit que la compréhension est "toujours située" — elle appartient à un auteur et à un moment.

**Étape 4 — Conséquence constitutionnelle** *(Niveau 3 — M-000)*

M-000 formule : "Une contribution clinique appartient toujours à son auteur et à son contexte." Ce qui était une propriété théorique devient un engagement normatif.

**Étape 5 — Concept métier** *(Niveau 4 — Domain Atlas)*

Le concept `ClinicalContribution` est défini dans le Domain Atlas comme l'unité fondamentale de la Compréhension Clinique externalisée — datée, attribuée, contextualisée, non-destructive.

Ses attributs ne sont pas arbitraires :
- `author` ← Invariant I (compréhension toujours située et personnelle)
- `occurredAt` ← Propriété dynamique 4 (temporalité)
- `context` ← Propriété dynamique 3 (contextualité)
- `reasoning` ← Composant 3.2 (raisonnement interprétatif)
- `uncertainties` ← Composant 3.4 (incertitudes non résolues)
- `intentions` ← Composant 3.6 (intentions et plans)

Chaque attribut est la traduction directe d'une propriété théorique. Aucun n'est présent par habitude, par convention, ou par analogie avec d'autres systèmes.

---

## 7. Comment un concept devient un choix architectural

La chaîne inverse — du concept vers l'architecture — est tout aussi importante. Elle garantit que les décisions techniques ne sont pas arbitraires.

### Exemple : la non-destructivité

**Concept métier**

La `ClinicalContribution` est non-destructive. Une contribution ne peut pas être effacée. Elle peut être amendée, mais l'amendement est lui-même une nouvelle contribution qui coexiste avec l'originale.

**Justification théorique** *(M-003 — Invariant IV)*

"Les compréhensions successives s'accumulent ; elles ne s'effacent pas. Ce qui a été compris à T reste historiquement réel — même si c'était incorrect ou incomplet."

**Justification de terrain** *(P-001 — Section 4.3)*

"[Hypothèse] La perte de la compréhension lors d'une transition clinique est plus coûteuse — en temps de reconstruction et en risque d'erreur — que la perte d'une donnée brute récupérable."

**Choix architectural** *(Niveau 5)*

Pas de `UPDATE` ni de `DELETE` sur les contributions cliniques en base de données. Les corrections passent par une nouvelle contribution marquée comme amendement. L'historique complet est toujours interrogeable.

Ce choix architectural n'est pas né d'une contrainte technique. Il est né d'un invariant théorique, lui-même né d'une observation de terrain. Il peut être tracé entièrement.

---

## 8. Registre des documents fondateurs

### Niveau 1 — Recherche

| Identifiant | Titre | Question centrale | Statut |
|---|---|---|---|
| P-001 | Clinical Context Resumption | Pourquoi la reprise de contexte est-elle un problème structurel ? | Figé v2.0 |
| CW-001 | Reprendre un patient | Que fait réellement un professionnel lors d'une reprise ? | Figé v2.0 |

### Niveau 2 — Théorie

| Identifiant | Titre | Question centrale | Statut |
|---|---|---|---|
| M-003 | Theory of Clinical Understanding | Qu'est-ce que la Compréhension Clinique ? | Figé v1.0 |

### Niveau 3 — Constitution

| Identifiant | Titre | Engagement | Statut |
|---|---|---|---|
| M-000 | Constitution of MedLink | Mission, vision, invariants | Figé v1.0 |
| M-001 | Product Boundaries | Frontières du Core Domain | Figé v1.0 |
| M-002 | Domain Philosophy | Philosophie du choix du Core Domain | Figé v1.0 |

### Niveau 4 — Modèle (à venir)

| Identifiant | Titre | Contenu | Statut |
|---|---|---|---|
| M-004 | Theory to Model Mapping | Traçabilité théorie → concepts métier | À rédiger |
| — | Domain Atlas | Registre complet des concepts métier | En cours |
| UL-001 | Ubiquitous Language | Glossaire normatif du projet | En cours |

---

## 9. La règle de priorité

La règle de priorité est simple et non négociable :

> **Un document de niveau N ne peut pas contredire un document de niveau N-1 ou inférieur.**

En pratique, cela signifie :

- Un ADR ne peut pas contredire un concept du Domain Atlas.
- Un concept du Domain Atlas ne peut pas contredire un invariant de M-003.
- Un invariant de M-003 ne peut pas contredire une observation validée de P-001 ou CW-001.
- Une décision produit ne peut pas contredire la constitution (M-000, M-001, M-002).

Lorsqu'une tension apparaît entre niveaux, le protocole est :

1. Identifier exactement quel document de quel niveau est remis en question.
2. Remonter à la source : l'observation de terrain qui justifie ce document est-elle encore valide ?
3. Si l'observation est valide, la décision de niveau inférieur doit être adaptée.
4. Si l'observation est contestée, elle doit être revalidée sur le terrain avant que quoi que ce soit d'autre ne change.

Ce protocole protège le projet contre la dérive progressive : la tendance naturelle des systèmes complexes à se déformer sous la pression des contraintes locales jusqu'à perdre leur cohérence d'origine.

---

## 10. Guide de lecture

Ce guide aide chaque collaborateur à trouver le bon document selon sa question.

**"Je veux comprendre pourquoi MedLink existe."**
→ Lire M-000 (Constitution), puis M-002 (Domain Philosophy).

**"Je veux comprendre le problème que MedLink résout."**
→ Lire P-001 (Clinical Context Resumption), puis CW-001 (Reprendre un patient).

**"Je veux comprendre ce qu'est la Compréhension Clinique."**
→ Lire M-003 (Theory of Clinical Understanding).

**"Je veux savoir ce que MedLink fait et ne fait pas."**
→ Lire M-001 (Product Boundaries).

**"Je veux comprendre pourquoi un concept métier existe."**
→ Consulter M-004 (Theory to Model Mapping) qui trace chaque concept vers sa justification théorique.

**"Je veux comprendre pourquoi un choix architectural a été fait."**
→ Consulter l'ADR correspondant, qui pointe vers le concept métier, qui pointe vers la théorie.

**"Je veux ajouter une fonctionnalité."**
→ Commencer par M-001 (tests de frontière), puis M-004 (le concept métier correspondant existe-t-il ?), puis les ADRs pertinents.

**"Je veux contester une décision."**
→ Identifier à quel niveau de la chaîne la décision se situe. Remonter jusqu'à l'observation qui la fonde. Contester l'observation, pas la décision.

---

## 11. Ce que ce document ne couvre pas

Ce document décrit la méthode et la structure. Il ne contient pas le domaine lui-même.

Pour le domaine :
- La définition de la Compréhension Clinique → M-003
- Les concepts métier → Domain Atlas
- Le glossaire → UL-001

Pour l'architecture :
- Les décisions techniques → ADRs (voir CLAUDE.md)

Pour le produit :
- Les spécifications → docs/product/

---

*Ce document est un document vivant. Il doit être mis à jour à chaque fois qu'un nouveau document est ajouté à la hiérarchie, ou qu'une dépendance change. Sa pertinence dépend de son exactitude : un R-000 incomplet ou obsolète est plus dangereux qu'un R-000 absent, parce qu'il oriente mal les collaborateurs.*
