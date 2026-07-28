# ADR-000 — Guide officiel des ADR de MedLink

**Version :** 1.0
**Statut :** Active — Norme
**Date :** 2026-07-28
**Autorité :** Ce document est la norme de toutes les décisions architecturales de MedLink.
Tout ADR produit après cette date doit s'y conformer.

---

## Préambule

### Pourquoi les ADR existent

Un ADR — *Architectural Decision Record* — est la trace écrite d'une décision qui a changé la façon dont MedLink est construit.

Dans la plupart des projets, les décisions sont prises oralement, dans des réunions, et oubliées. Le code résultant est là, mais son *pourquoi* a disparu. Six mois plus tard, une décision identique est débattue à nouveau — depuis zéro.

MedLink refuse cette perte.

Mais la raison profonde d'écrire des ADR n'est pas la mémoire organisationnelle.

La raison est architecturale : **toute décision technique doit être justifiée par le domaine**. Un ADR est l'acte de rendre cette justification explicite, traçable, et contestable.

Si une décision ne peut pas être justifiée par le domaine, elle ne devrait pas être prise.

Si une décision peut être justifiée, écrire son ADR est un acte de compréhension, pas une formalité administrative.

### Ce que ce document définit

Ce document définit :

- la **taxonomie** des ADR (trois types distincts),
- la **structure** de chaque type (sections obligatoires et optionnelles),
- le **bloc de traçabilité domaine** (section non négociable),
- le **cycle de vie** d'un ADR (états et transitions),
- le **niveau de détail** attendu (ni trop court, ni trop long),
- la **relation avec M-000** (le manifeste),
- la **relation avec le Domain Atlas** (la source des concepts et invariants),
- le **template officiel** pour chaque type,
- le **processus d'approbation**.

---

## 1. Taxonomie — Trois types d'ADR

MedLink produit trois types de décisions, qui correspondent à trois niveaux de responsabilité distincts.

### Type D — Domain ADR

**Préfixe :** `ADR-0xxx` (convention historique, maintenue)

**Objet :** Décisions sur la **forme du domaine** — ce qu'un concept est, ce qu'il n'est pas, comment deux concepts se rapportent, quels invariants le domaine impose.

**Questions typiques :**
- *Ce concept est-il un agrégat ou une entité ?*
- *Ce rôle appartient-il à la relation ou à l'entité ?*
- *Cette responsabilité appartient-elle à ce contexte ou à celui-là ?*

**Règle :** Un ADR de type D ne mentionne jamais de technologie. Il n'y a aucune raison technique de créer un ADR de type D.

**Exemples existants :** ADR-0007, ADR-0010, ADR-0014

---

### Type SA — Software Architecture ADR

**Préfixe :** `ADR-SA-xxx`

**Objet :** Décisions sur la **traduction du domaine en logiciel** — comment un concept domaine est implémenté, comment les Bounded Contexts communiquent, comment la persistance est organisée.

**Questions typiques :**
- *Comment les Domain Events sont-ils garantis fiables ?*
- *Comment les Integration Events sont-ils versionnés ?*
- *Comment la couche de lecture est-elle organisée ?*

**Règle :** Un ADR de type SA doit toujours justifier d'abord par le domaine, ensuite par l'architecture. Une justification purement technique sans fondement dans le domaine est insuffisante.

**Exemples existants :** ADR-SA-005, ADR-SA-010, ADR-SA-012

---

### Type P — Process ADR

**Préfixe :** `ADR-P-xxx` (anciennement `DE-P-xxx`)

**Objet :** Décisions sur les **pratiques et protocoles d'ingénierie** — comment le domaine est modélisé, quelles règles gouvernent le processus de découverte, comment les concepts sont promus.

**Questions typiques :**
- *Quand un concept est-il promu en agrégat ?*
- *Comment un nouveau terme entre-t-il dans l'UL ?*
- *Comment un scénario de référence est-il falsifié ?*

**Règle :** Un ADR de type P décrit un protocole reproductible, pas un cas particulier.

**Exemples existants :** DE-P-011 (Aggregate Promotion Rule), DE-P-020 (Modelling Defaults)

---

## 2. Numérotation

### Convention

| Type | Préfixe | Série | Exemple |
|---|---|---|---|
| Domain | `ADR-0` | 0001 à 0999 | `ADR-0015` |
| Software Architecture | `ADR-SA-` | 001 à 999 | `ADR-SA-014` |
| Process | `ADR-P-` | 001 à 999 | `ADR-P-021` |

### Règles de numérotation

1. Les numéros sont attribués séquentiellement, sans trous.
2. Un numéro attribué ne peut pas être réattribué, même si l'ADR est rejeté.
3. Les ADRs rejetés conservent leur numéro et leur document, avec le statut `Rejected`.
4. Le numéro reflète l'ordre de création, pas l'ordre d'importance.

---

## 3. Cycle de vie

```
Draft ──→ Proposed ──→ Review ──→ Accepted
                                    │
                               ┌────┴────┐
                            Superseded  Deprecated
                                    │
                               Rejected (depuis Review seulement)
```

### États

| État | Signification | Modification possible |
|---|---|---|
| `Draft` | En cours de rédaction. Non partagé. | Oui — totale |
| `Proposed` | Soumis pour avis. | Oui — mineure |
| `Review` | En cours d'examen formel par les parties concernées. | Non — gelé pendant la review |
| `Accepted` | Approuvé. Normatif. Immutable dans son contenu de décision. | Non — seul le statut peut changer |
| `Rejected` | Examiné et non adopté. La raison du rejet est documentée dans l'ADR. | Non |
| `Superseded` | Remplacé par un ADR plus récent. Conserve sa valeur historique. | Non |
| `Deprecated` | N'est plus applicable. Pas de remplaçant spécifique. | Non |

### Transitions

**Draft → Proposed**
L'auteur considère que le problème est bien posé et que la décision est formulée.

**Proposed → Review**
Au moins une autre personne a lu le draft et confirmé que la question mérite une review formelle.

**Review → Accepted**
Toutes les parties concernées par l'impact de la décision ont été consultées et n'ont pas d'objection bloquante.

**Review → Rejected**
La review a conclu que la décision ne devrait pas être adoptée. La raison est documentée dans la section **Raison du rejet** (ajoutée à l'ADR à ce moment).

**Accepted → Superseded**
Un nouvel ADR est créé qui remplace explicitement l'ADR précédent. L'ancien ADR est mis à jour avec le champ **Superseded by** pointant vers le nouveau.

**Accepted → Deprecated**
La décision n'est plus applicable (contexte disparu, plateforme retirée) mais aucun ADR de remplacement n'est nécessaire.

### Immutabilité des ADR acceptés

La **décision elle-même** dans un ADR accepté est immuable.

Si la décision doit changer, un **nouvel ADR est rédigé** qui la remplace.

Des corrections mineures (fautes de frappe, liens cassés, reformulations non sémantiques) peuvent être apportées sans créer de nouvel ADR. Ces corrections sont documentées dans le champ **Révisions mineures** en en-tête de l'ADR.

---

## 4. Le bloc de traçabilité domaine

**C'est la section la plus importante de ce guide.**

Tout ADR de MedLink — quel que soit son type — doit contenir un bloc de traçabilité domaine.

Ce bloc est placé **en premier**, avant tout autre contenu.

Il contient trois sous-sections obligatoires :

```markdown
## Références domaine

### Principes concernés
- [Source §X — Nom du principe] : [En quoi ce principe justifie ou contraint cette décision]

### Concepts métier concernés
- [Domain Atlas §X — Nom du concept] : [En quoi ce concept est affecté par cette décision]

### Invariants concernés
- [Source de l'invariant — Nom de l'invariant] : [En quoi cet invariant est protégé ou affecté]
```

### Sources valides pour les principes

| Source | Contenu |
|---|---|
| `FOUNDATIONS §X` | Les 10 principes fondateurs |
| `AP-001 §X` | Les 6 principes d'architecture |
| `CLAUDE.md §[section]` | Les règles de développement de la Constitution |
| `M-000` | La mission fondatrice |

### Sources valides pour les concepts métier

| Source | Contenu |
|---|---|
| `Domain Atlas §X` | Les 15 concepts du Domain Atlas V1 |
| `UL-001 §X` | Le vocabulaire ubiquitaire |

### Sources valides pour les invariants

| Source | Contenu |
|---|---|
| `M-003 Invariant X` | Les 7 invariants de la Compréhension Clinique |
| `M-003 Propriété dynamique X` | Les propriétés temporelles |
| `Domain Atlas §X, Invariant Y` | Les invariants spécifiques d'un concept |
| `SD-005, Règle X` | Les règles de dépendance des Bounded Contexts |

### Ce qui se passe si le bloc est vide

Un ADR dont le bloc de traçabilité est vide — ou rempli de références génériques sans pertinence explicite — est **retourné à l'état Draft** lors de la Review.

La question à poser : *"Si je supprime la section Références domaine, est-ce que la décision a encore un sens ?"*

Si oui : l'ADR a peut-être un problème de fond — il justifie une décision par la technologie, pas par le domaine.

Si non : le bloc de traçabilité capture bien quelque chose de réel.

---

## 5. Structure d'un ADR de type D

Les ADRs de type D concernent le domaine. Ils doivent être courts, précis, et dépourvus de tout contenu technique.

### Sections obligatoires

```markdown
# ADR-0XXX — [Titre]

**Statut :** [Draft | Proposed | Review | Accepted | Rejected | Superseded | Deprecated]
**Version :** [x.0]
**Date :** [YYYY-MM-DD]
**Supersède :** [référence si applicable]
**Supersédé par :** [référence si applicable]

## Références domaine

### Principes concernés
### Concepts métier concernés
### Invariants concernés

## Contexte

[Quelle situation dans le domaine a rendu cette décision nécessaire ?
Quelle question a émergé du travail de modélisation ou d'observation ?]

## Problème

[La question précise à laquelle cet ADR répond.
Formulée en une ou deux phrases maximum.]

## Décision

[La réponse. La décision elle-même.
Formulée en langage du domaine — jamais en langage technique.]

## Justification

[Pourquoi cette décision est-elle correcte du point de vue du domaine ?
Tracée aux invariants et aux principes du bloc de traçabilité.]

## Conséquences

[Ce qui change après cette décision.
Pas ce que le développeur doit faire — ce que le domaine dit maintenant.]

## Invariants protégés

[Liste explicite des invariants du domaine que cette décision protège ou crée.]

## Ce que cette décision n'est pas

[Délimitation explicite : ce que l'ADR pourrait sembler dire mais ne dit pas.]

## Règles

[Règles normatives qui découlent de la décision.
Numérotées. Formulées au présent.]
```

### Sections optionnelles pour type D

```markdown
## Raison du rejet (si Rejected)
## Modèle (schéma ASCII si nécessaire)
## Exemples (si le concept nécessite illustration)
## Relations (liens vers ADRs connexes)
```

### Niveau de détail — type D

**Cible :** 300 à 600 mots de contenu (hors template).

Un ADR de domaine trop long est le signal que deux décisions distinctes ont été confondues.

Si le problème est réellement complexe, envisager de le découper en deux ADRs ou de produire d'abord un document de recherche (P-001, CW-001) ou théorique (M-003).

---

## 6. Structure d'un ADR de type SA

Les ADRs de type SA traduisent le domaine en logiciel. Ils peuvent être plus longs parce qu'ils doivent exposer les conséquences techniques. Mais la justification domaine reste première.

### Sections obligatoires

```markdown
# ADR-SA-XXX — [Titre]

**Statut :** [...]
**Version :** [x.0]
**Date :** [YYYY-MM-DD]
**Supersède :** [...]
**Supersédé par :** [...]

## Références domaine

### Principes concernés
### Concepts métier concernés
### Invariants concernés

## Principe AP-001 concerné

[Lequel des 6 principes d'AP-001 cet ADR implémente ou affecte ?]

## Contexte

[Quelle propriété du domaine crée un besoin architectural ?
Quelle situation technique reflète une exigence du domaine ?]

## Problème

[La question architecturale précise.
Elle doit pouvoir être reliée à une contrainte du domaine.]

## Décision

[La décision architecturale.
Formulée clairement, sans ambiguïté.]

## Justification domaine

[Pourquoi le domaine exige cette décision.
Tracée aux références du bloc de traçabilité.
C'est la justification primaire — elle est toujours présente.]

## Justification architecturale

[Pourquoi cette implémentation est préférable à une alternative.
C'est la justification secondaire — elle complète, ne remplace pas la justification domaine.]

## Conséquences

[Ce qui change dans le logiciel après cette décision.]

## Ce que cette décision interdit

[Liste explicite des pratiques que cette décision rend non conformes.]

## Règles

[Règles normatives, numérotées.]

## Relations

[Liens vers ADRs concernés.]
```

### Sections optionnelles pour type SA

```markdown
## Exemple d'implémentation
## Diagramme
## Monitoring (si la décision implique des signaux d'alerte)
## Migration (si la décision remplace une pratique existante)
```

### Niveau de détail — type SA

**Cible :** 500 à 1000 mots de contenu.

**Maximum :** 5 pages imprimées. Au-delà, envisager de séparer en un ADR de décision + un document de spécification technique.

---

## 7. Structure d'un ADR de type P

Les ADRs de type P définissent des protocoles d'ingénierie. Ils doivent être opérationnels et testables.

### Sections obligatoires

```markdown
# ADR-P-XXX — [Titre]

**Statut :** [...]
**Date :** [YYYY-MM-DD]

## Références domaine

### Principes concernés
### Concepts métier concernés
### Invariants concernés

## Objet

[Quel problème de processus ce protocole résout-il ?]

## Règle / Protocole

[Le protocole lui-même. Étapes numérotées si procédural.
Critères explicites si décisionnel.]

## Test d'application

[Comment savoir si le protocole a été appliqué correctement ?
Un critère binaire est préférable.]

## Exemples

[Minimum un exemple d'application correcte.
Un exemple de cas limite si pertinent.]

## Ce que ce protocole ne couvre pas

[Délimitation : quels cas sont hors périmètre de ce protocole ?]
```

### Niveau de détail — type P

**Cible :** 200 à 400 mots.

Un ADR de process trop long est le signal qu'il essaie de couvrir trop de cas. Préférer deux ADRs de process courts et précis à un ADR de process long et ambigu.

---

## 8. Relation avec M-000

### Le manifeste comme test ultime

M-000 est la déclaration de mission de MedLink.

Avant qu'un ADR soit proposé, une question doit être posée :

> **Cette décision protège-t-elle ou sert-elle la mission de M-000 ?**

Si la réponse est non, la décision n'a pas sa place dans MedLink.

Si la réponse est oui, l'ADR doit rendre cette connexion explicite — pas implicite.

### Comment citer M-000 dans le bloc de traçabilité

M-000 n'est pas encore formalisé en sections numérotées. En attendant, la référence à M-000 se fait par citation directe :

```markdown
### Principes concernés
- M-000 — "Réduire l'effort cognitif nécessaire pour comprendre une situation clinique" :
  Cette décision préserve ce principe en garantissant que [...]
```

### Quand M-000 est obligatoire

M-000 est obligatoire dans le bloc de traçabilité de tout ADR de type D.

Il est optionnel pour les ADRs de type SA et P, sauf si la décision touche directement à la mission (par exemple, une décision sur l'accès aux données cliniques d'un Patient ou sur la responsabilité clinique).

---

## 9. Relation avec le Domain Atlas

### Le Domain Atlas comme source des concepts et invariants

Le Domain Atlas V1 est la **source canonique** des concepts métier de MedLink.

Toute décision qui affecte un concept du Domain Atlas doit citer la section correspondante dans le bloc de traçabilité.

### Les invariants du Domain Atlas

Chaque concept du Domain Atlas possède des invariants explicites. Ces invariants sont les **contraintes dures** que les ADRs doivent protéger — jamais violer.

Exemple pour Contribution Clinique (§4) :
- Invariant : immuable après création
- Invariant : auteur obligatoire et non modifiable
- Invariant : au moins une dimension clinique présente
- Invariant : amendement non-destructif uniquement

Un ADR qui implique la Contribution Clinique doit citer ces invariants dans son bloc de traçabilité et expliquer comment la décision les protège — ou, dans le cas exceptionnel, justifier pourquoi un invariant est révisé (ce qui nécessite une mise à jour du Domain Atlas).

### Quand le Domain Atlas doit être mis à jour

Si un ADR **redéfinit** un concept, **ajoute un invariant**, ou **supprime une responsabilité** d'un concept du Domain Atlas, le Domain Atlas doit être mis à jour **avant** que l'ADR soit accepté.

L'ordre est :

```
Observation / Falsification → Domain Atlas mis à jour → ADR rédigé → ADR accepté
```

Un ADR ne peut pas redéfinir le domaine sans mise à jour préalable du Domain Atlas.

---

## 10. Ce que les ADR ne sont pas

### Un ADR n'est pas une spécification d'implémentation

Un ADR de type D dit *quoi* le domaine décide. Il ne dit pas *comment* implémenter la décision.

Un ADR de type SA dit *quelle approche architecturale* est adoptée. Il ne dit pas *comment écrire le code*.

Les spécifications d'implémentation appartiennent aux documents d'architecture dédiés (SA-xxx) ou aux documents de référence (ENGINEERING-HANDBOOK.md).

### Un ADR n'est pas un ticket de tâche

Un ADR ne dit jamais "TODO" ni "à implémenter". Une décision est prise ou elle ne l'est pas. Si elle n'est pas encore prise, l'ADR est en Draft.

### Un ADR n'est pas rétrospectif

Un ADR ne documente pas ce qui a été fait. Il documente ce qui a été **décidé**. La différence est importante : une décision peut être prise avant ou après l'implémentation, mais elle doit être explicite et consciente.

### Un ADR n'est pas un débat

Un ADR accepté reflète une décision prise. Il n'ouvre pas un débat. Pour rouvrir une décision, il faut produire un **nouvel ADR** qui la remet en question avec un problème nouveau ou une information nouvelle.

---

## 11. Processus d'approbation

### Qui écrit

Tout membre de l'équipe peut rédiger un ADR.

L'auteur est responsable de :
- compléter le bloc de traçabilité domaine,
- relire les ADRs connexes pour détecter les conflits,
- proposer la décision dans l'état Draft.

### Qui review

La review implique au minimum :
- **Pour les ADR de type D** : l'architecte domaine et une personne ayant une connaissance clinique.
- **Pour les ADR de type SA** : l'architecte logiciel et l'auteur de l'ADR de type D qui justifie la décision.
- **Pour les ADR de type P** : l'auteur et un pair.

### Critères d'acceptation

Un ADR peut être accepté si et seulement si :

| Critère | Description |
|---|---|
| Traçabilité complète | Le bloc de traçabilité cite au moins un principe, un concept, et un invariant — avec pertinence explicite |
| Problème clair | La section Problème est formulée en une ou deux phrases sans ambiguïté |
| Décision sans ambiguïté | La décision peut être testée — il est possible de dire si une implémentation la respecte ou non |
| Absence de conflit | L'ADR ne contredit pas un ADR accepté sans le superseder explicitement |
| Cohérence avec le Domain Atlas | Si un concept est cité, ses invariants sont respectés ou le Domain Atlas est mis à jour |

### Durée de review

Une review ne dure pas plus de **5 jours ouvrés** pour les ADRs de type SA et P.

Pour les ADRs de type D, la durée n'est pas plafonnée — la clarté du domaine prime sur la vitesse de décision.

---

## 12. Template officiel

### Template type D

```markdown
# ADR-0XXX — [Titre]

**Statut :** Draft
**Version :** 1.0
**Date :** YYYY-MM-DD
**Supersède :** —
**Supersédé par :** —

---

## Références domaine

### Principes concernés
- [Source §X — Nom] : [Pertinence en une ligne]

### Concepts métier concernés
- [Domain Atlas §X — Nom du concept] : [Pertinence en une ligne]

### Invariants concernés
- [Source — Nom de l'invariant] : [Pertinence en une ligne]

---

## Contexte

[...]

## Problème

[...]

## Décision

[...]

## Justification

[...]

## Conséquences

[...]

## Invariants protégés

[...]

## Ce que cette décision n'est pas

[...]

## Règles

1. [...]
2. [...]
```

---

### Template type SA

```markdown
# ADR-SA-XXX — [Titre]

**Statut :** Draft
**Version :** 1.0
**Date :** YYYY-MM-DD
**Supersède :** —
**Supersédé par :** —

---

## Références domaine

### Principes concernés
- [AP-001 §X — Nom] : [Pertinence en une ligne]
- [FOUNDATIONS §X — Nom] : [Pertinence en une ligne]

### Concepts métier concernés
- [Domain Atlas §X — Nom du concept] : [Pertinence en une ligne]

### Invariants concernés
- [Source — Nom de l'invariant] : [Pertinence en une ligne]

---

## Principe AP-001 concerné

[§X — Nom du principe]

## Contexte

[...]

## Problème

[...]

## Décision

[...]

## Justification domaine

[...]

## Justification architecturale

[...]

## Conséquences

[...]

## Ce que cette décision interdit

1. [...]
2. [...]

## Règles

1. [...]
2. [...]

## Relations

- [ADR-0XXX] — [Nature du lien]
```

---

### Template type P

```markdown
# ADR-P-XXX — [Titre]

**Statut :** Draft
**Version :** 1.0
**Date :** YYYY-MM-DD

---

## Références domaine

### Principes concernés
- [Source §X — Nom] : [Pertinence en une ligne]

### Concepts métier concernés
- [Domain Atlas §X — Nom du concept] : [Pertinence en une ligne]

### Invariants concernés
- [Source — Nom de l'invariant] : [Pertinence en une ligne]

---

## Objet

[...]

## Règle / Protocole

1. [...]
2. [...]

## Test d'application

[Critère binaire : comment savoir si le protocole a été respecté ?]

## Exemples

### Exemple d'application correcte

[...]

## Ce que ce protocole ne couvre pas

[...]
```

---

## 13. Règles non négociables

Ces règles s'appliquent à tout ADR, quel que soit son type.

1. Le bloc de traçabilité domaine est **obligatoire**. Un ADR sans bloc de traçabilité est retourné en Draft.

2. Un ADR de type D ne contient **aucun terme technique** (classe, méthode, table, bus, ORM...).

3. Un ADR ne peut pas **redéfinir un concept du Domain Atlas** sans mise à jour préalable du Domain Atlas.

4. Un ADR accepté ne peut pas être **silencieusement modifié**. Toute modification sémantique exige un nouvel ADR.

5. Un ADR ne peut pas **contredire un ADR accepté** sans le superseder explicitement.

6. Un ADR **rejeté** conserve son document et son numéro. Sa valeur est dans la trace du *pourquoi le rejet*, pas dans la décision elle-même.

7. La **justification domaine prime** sur la justification architecturale dans les ADRs de type SA. Si les deux sont en conflit, la justification architecturale est incorrecte.

---

*Ce document est lui-même un ADR de type P. Il s'auto-applique : toute modification de ce guide exige un nouvel ADR qui le remplace ou l'amende avec les mêmes règles de traçabilité.*
