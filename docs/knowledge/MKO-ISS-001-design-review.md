# MKO-ISS-001 — MKO-000 Design Review

**Type :** Issue List — Revue de conception pré-v0.2
**Statut :** In Review
**Date :** 2026-07-30
**Scope :** MKO-000 v0.1 — toutes sections
**Source :** Auto-audit + revue humaine

---

## Objet de ce document

Ce document recense chaque remarque issue de la revue de MKO-000 v0.1 avant production de la v0.2.

Pour chaque issue :
- **Verdict** : `Acceptée` | `Rejetée` | `À discuter`
- **Justification** : décision et raisonnement
- **Impact** : chapitres et règles affectés
- **Priorité** : `Bloquant` | `Important` | `Amélioration`

Une issue `Bloquante` empêche MKO-000 d'être utilisé comme fondation. Elle doit être résolue avant toute référence par un document subordonné.

---

---

## ISSUE #01 — IR-004 : relation inférée non déclarée

**Résumé :**
IR-004 produit la relation `CONFIGURES_EXPRESSION_OF` via inférence. Cette relation n'est pas déclarée dans le Chapitre II. L'ontologie génère ainsi un type de relation dont les propriétés, les contraintes et la cardinalité sont inconnues.

**Verdict :** `Acceptée`

**Justification :**
Une ontologie ne peut pas créer un nouveau type de relation par inférence. Toute relation inférée doit soit être déclarée explicitement dans le catalogue (si sa sémantique est distincte), soit être remplacée par une relation déjà déclarée (si elle est redondante). Les deux sémantiques sont effectivement distinctes :
- `CONFIGURES` — relation déclarée entre un Profile et une Architecture (scope : l'Architecture entière)
- `CONFIGURES_EXPRESSION_OF` — relation entre un Profile et un Invariant individuel (scope : l'expression d'un invariant spécifique dans ce Profile)

**Résolution retenue :** Déclarer `CONFIGURES_EXPRESSION_OF` dans le Chapitre II avec ses propriétés propres.

**Impact :**
- Chapitre II — Relation Types : ajouter `CONFIGURES_EXPRESSION_OF`
- IR-004 : la règle reste, mais pointe désormais vers une relation déclarée

**Priorité :** `Bloquant`

---

## ISSUE #02 — `DERIVES` couvre quatre transformations de natures différentes

**Résumé :**
La relation `DERIVES` est utilisée pour toute la chaîne CI → CN → WR → UX → IP. Ces quatre transitions ont des natures logiques distinctes : implication nécessaire, traduction normative, décision de design, instanciation. Les unifier sous `DERIVES` masque ces différences et rend les règles d'inférence imprécises.

**Verdict :** `Acceptée`

**Justification :**
Chaque transition correspond à une opération différente avec des propriétés différentes :

| Transition | Relation proposée | Nature |
|---|---|---|
| CI → CN | `IMPLIES` | Implication nécessaire — si l'invariant tient, le besoin existe |
| CN → WR | `SATISFIED_BY` | Traduction — ce requirement est une condition suffisante pour le besoin |
| WR → UX | `IMPLEMENTED_BY` | Décision révisable — ce principe est une des réponses possibles |
| UX → IP | `REALIZED_BY` | Concrétisation — ce pattern instancie ce principe |
| IP → PC | `IMPLEMENTED_AS` | Déploiement — cette capability implémente ce pattern dans un produit |

Cette distinction permettra des règles d'inférence plus précises — par exemple, l'invalidation d'un Invariant invalide par `IMPLIES` tous les CN qui en dépendent, mais une alternative à un UX Principle peut être proposée sans invalider le WR (relation `IMPLEMENTED_BY` révisable).

**Impact :**
- Chapitre II — Relation Types : remplacer `DERIVES` par cinq relations distinctes
- Toutes les IR qui référencent `DERIVES` doivent être mises à jour pour préciser quelle sous-relation est concernée
- IR-003 (transitivité) : redéfinir — la transitivité s'applique uniquement si les relations de même type se composent

**Priorité :** `Bloquant`

---

## ISSUE #03 — IR-002 : cascade de réfutation s'arrête aux Requirements

**Résumé :**
IR-002 place en `UNDER_REVIEW` les Cognitive Needs et Requirements dérivés d'un Invariant réfuté. La cascade ne descend pas jusqu'aux UX Principles, Interaction Patterns, et Product Capabilities. Un produit peut donc continuer à implémenter une fonctionnalité fondée sur un Invariant invalidé.

**Verdict :** `Acceptée`

**Justification :**
La chaîne de dérivation étant complète (CI → CN → WR → UX → IP → PC), une réfutation doit se propager sur l'ensemble. Les Product Capabilities sont les implémentations concrètes — si leur ancrage scientifique est invalide, les équipes produit doivent être alertées. L'arrêt aux Requirements est une demi-mesure qui crée exactement le risque que l'ontologie est censée prévenir.

**Résolution retenue :** Étendre IR-002 jusqu'aux Product Capabilities. La cascade complète est :

```
IF Experiment --[REFUTES]--> CI-X
THEN ∀ CN derived via IMPLIES       → status = UNDER_REVIEW
AND  ∀ WR derived via SATISFIED_BY  → status = UNDER_REVIEW
AND  ∀ UX derived via IMPLEMENTED_BY → status = UNDER_REVIEW
AND  ∀ IP derived via REALIZED_BY   → status = UNDER_REVIEW
AND  ∀ PC derived via IMPLEMENTED_AS → status = UNDER_REVIEW
```

**Impact :**
- IR-002 : réécriture complète avec cascade étendue
- OT-08 (Product Capability) : ajouter `UNDER_REVIEW` au vocabulaire de status

**Priorité :** `Bloquant`

---

## ISSUE #04 — IR-001 : propagation de support logiquement incorrecte

**Résumé :**
IR-001 infère que si une Observation supporte un Invariant, elle supporte aussi le Cognitive Need dérivé. Cette inférence est incorrecte : une observation supporte l'*existence* d'un mécanisme (proposition descriptive), pas la *nécessité* de le servir (proposition normative). Ces deux propositions appartiennent à des niveaux épistémiques différents.

**Verdict :** `Acceptée — avec reformulation`

**Justification :**
L'audit a raison sur le problème mais la solution n'est pas la suppression d'IR-001 — c'est l'introduction d'une distinction dans la sémantique de `SUPPORTS`.

Actuellement, `SUPPORTS` est utilisé comme une relation unique. En réalité, une Observation ne supporte pas directement un Cognitive Need — elle contribue à une Evidence, et c'est l'Evidence qui supporte l'Invariant, lequel implique le Cognitive Need.

**Résolution retenue :** Introduire la relation `CONTRIBUTES_TO` (Observation → Evidence) et reformuler la chaîne :

```
Observation --[CONTRIBUTES_TO]--> Evidence
Evidence    --[SUPPORTS]-------> CI-X
CI-X        --[IMPLIES]--------> CN-X
```

IR-001 devient alors :
```
IF   Evidence --[SUPPORTS]--> CI-X
AND  CI-X --[IMPLIES]--> CN-X
THEN Evidence --[INDIRECTLY_SUPPORTS]--> CN-X
```

La propagation reste — mais elle part d'une Evidence structurée (agrégat d'Observations qualifiées), pas d'une Observation brute individuelle.

**Impact :**
- Chapitre II : ajouter la relation `CONTRIBUTES_TO` (Observation → Evidence)
- IR-001 : reformulation
- OT-11 (Observation) : retirer la relation directe `SUPPORTS → CI-X` — remplacer par `CONTRIBUTES_TO → Evidence`
- C-007 : mettre à jour — une Observation cible désormais une Evidence, pas directement un Invariant

**Priorité :** `Bloquant`

---

## ISSUE #05 — C-001 interdit la réutilisation d'Invariants entre Architectures

**Résumé :**
C-001 exige que tout Invariant soit `DEFINED_BY` exactement une Architecture. Cette contrainte interdit le partage d'un Invariant entre deux Architectures — par exemple, CI-04 (Distributed Cognition) pourrait s'appliquer à la fois à la Clinical Architecture et à une future Learning Architecture.

**Verdict :** `Acceptée — avec reformulation`

**Justification :**
La contrainte "exactement une Architecture" est trop stricte. Certains Invariants sont des propriét��s de la cognition humaine générale, pas d'un domaine spécifique. Les forcer à être copiés-collés sous des IDs différents dans chaque Architecture dégrade la cohérence du graphe.

**Résolution retenue :** Remplacer `DEFINED_BY` par deux relations distinctes :
- `DEFINED_IN` — relation unique et canonique. L'Architecture qui a découvert et formalisé l'Invariant. Un seul `DEFINED_IN` par Invariant.
- `APPLIES_TO` — relation multiple. Toute Architecture dans laquelle l'Invariant est actif. N `APPLIES_TO` possibles.

C-001 devient : "Tout Invariant doit avoir exactement un `DEFINED_IN` et au moins un `APPLIES_TO`."

**Impact :**
- Chapitre II : remplacer `DEFINES` (Architecture → Invariant) par `DEFINED_IN` + `APPLIES_TO`
- C-001 : reformulation
- IR-004 : mettre à jour — la configuration d'un Profile concerne les Invariants `APPLIES_TO` son Architecture, pas seulement ceux `DEFINED_IN`

**Priorité :** `Important`

---

## ISSUE #06 — Interaction Pattern manque de rôle formel

**Résumé :**
OT-07 (Interaction Pattern) n'est référencé dans aucune contrainte ni aucune règle d'inférence. Un niveau sans rôle formel est éditorial, pas ontologique.

**Verdict :** `Rejetée sur le fond — Acceptée sur le besoin de contraintes`

**Justification :**
L'Interaction Pattern est un niveau nécessaire dans la hiérarchie. Son utilité sera évidente dès que le produit existera — un UX Principle comme "Anchor" peut se concrétiser en plusieurs patterns (Compact Anchor, Expanded Anchor, Emergency Anchor) selon le contexte d'usage, avant même d'atteindre la Product Capability. Supprimer ce niveau reviendrait à aplatir prématurément une distinction qui sera utile.

En revanche, l'audit a raison : le niveau doit avoir des contraintes formelles pour exister dans l'ontologie.

**Résolution retenue :** Conserver OT-07 et ajouter :
- Une contrainte : "Tout Interaction Pattern doit être `REALIZED_BY` au moins un UX Principle"
- Une règle d'inférence : si un Interaction Pattern est `REALIZED_BY` un UX Principle, et que ce UX Principle est invalidé, le Pattern entre en `UNDER_REVIEW`

**Impact :**
- Chapitre III : ajouter contrainte sur OT-07
- IR-002 : inclure IP dans la cascade de réfutation (voir #03)

**Priorité :** `Important`

---

## ISSUE #07 — Evidence mélange deux types hétérogènes

**Résumé :**
OT-12 définit Evidence comme "un corpus structuré d'Observations *ou* de références bibliographiques." Ce "ou" recouvre deux types d'objets fondamentalement différents.

**Verdict :** `Acceptée — avec sous-typage`

**Justification :**
En science, une Evidence est effectivement un concept agrégateur — elle peut combiner données empiriques et références bibliographiques. Supprimer Evidence serait une régression par rapport à la pratique scientifique. Mais les distinguer permet des règles différentes : une Evidence empirique peut être challenger par une Observation contraire ; une Evidence bibliographique peut être questionner par une méta-analyse.

**Résolution retenue :** Conserver Evidence (OT-12) et introduire deux sous-types :
- `EmpiricalEvidence` — agrège des Observations terrain (OT-11)
- `LiteratureEvidence` — agrège des références bibliographiques

Chaque sous-type a ses propres propriétés et contraintes. La relation `CONTRIBUTES_TO` (voir #04) pointe vers `EmpiricalEvidence`. Les références bibliographiques produisent des `LiteratureEvidence`.

**Impact :**
- OT-12 : reformulation avec sous-typage
- Chapitre II : préciser quelles relations s'appliquent à chaque sous-type

**Priorité :** `Important`

---

## ISSUE #08 — `USES` est trop vague

**Résumé :**
`USES` est défini comme "la source référence la cible sans la définir." C'est la relation la plus générique possible — elle capture n'importe quelle connexion implicite sans sémantique précise.

**Verdict :** `À discuter`

**Justification :**
Le problème est réel. CCF-02 `USES` CI-01 parce qu'il exprime CI-01 dans une séquence temporelle — ce n'est pas "utiliser" au sens de dépendre, c'est "opérationnaliser". Mais remplacer `USES` par `OPERATIONALIZES` ou `EXPRESSES_IN_CONTEXT_OF` introduit un vocabulaire très spécialisé dont la généralité future est incertaine.

**Question ouverte :** Doit-on remplacer `USES` par une relation plus précise, ou accepter que certaines connexions entre documents restent sémantiquement légères ?

**Impact si acceptée :**
- Chapitre II : remplacer `USES` par une ou plusieurs relations plus précises
- Tous les arcs `USES` dans le graphe courant doivent être requalifiés

**Priorité :** `Important`

---

## ISSUE #09 — `REALIZED_BY` appliqué de façon incohérente

**Résumé :**
Le tableau des relations déclare `REALIZED_BY` avec source "UX Principle, IP" et cible "Product Capability." Mais UX → Product Capability et IP → Product Capability ne sont pas la même opération. De plus, `REALIZED_BY` est utilisé à la fois comme nom d'une relation dans le tableau et comme l'une des cinq nouvelles relations proposées dans #02 (UX → IP).

**Verdict :** `Acceptée — résolue par #02`

**Justification :**
La résolution de #02 (split de `DERIVES`) clarifie automatiquement ce problème : chaque transition de la chaîne reçoit son propre nom. `REALIZED_BY` devient la relation spécifique UX → IP. IP → PC reçoit `IMPLEMENTED_AS`. Le tableau des relations n'a plus besoin de grouper UX et IP comme sources communes.

**Impact :**
- Résolu par #02
- Chapitre II : mise à jour automatique à la résolution de #02

**Priorité :** `Important` — résolu par #02

---

## ISSUE #10 — Framework → Architecture : DEFINES vs GOVERNS

**Résumé :**
MKO-000 `DEFINES` CCF-01. Mais MKO-000 ne définit pas le *contenu* de CCF-01 — il définit les *règles* que CCF-01 doit respecter. C'est une relation de gouvernance, pas une relation de définition.

**Verdict :** `À discuter`

**Justification :**
La distinction est réelle mais son impact sur l'ontologie est potentiellement faible. Dans la version actuelle, il n'y a qu'un seul Framework (MKO-000). La distinction DEFINES / GOVERNS n'a de valeur pratique que si plusieurs Frameworks coexistent avec des relations différentes à leurs Architectures.

**Question ouverte :** Anticiper deux relations distinctes (DEFINES pour Architecture → Invariant, GOVERNS pour Framework → Architecture) dès maintenant, ou attendre que le cas d'usage se présente ?

**Impact si acceptée :**
- Chapitre II : ajouter `GOVERNS` comme relation distincte
- Reformuler les propriétés de OT-01 (Framework)

**Priorité :** `Amélioration`

---

## ISSUE #11 — Cardinalités absentes de toutes les relations *(nouvelle issue)*

**Résumé :**
Les relations sont typées mais pas cardinalisées. Il est impossible de savoir si une Architecture peut définir 0 ou N Invariants, si un Cognitive Need peut dériver d'un seul Invariant ou de plusieurs, etc. Sans cardinalités, un moteur de validation du graphe ne peut pas détecter des structures incomplètes ou aberrantes.

**Verdict :** `Acceptée`

**Justification :**
Les cardinalités sont une composante fondamentale de toute ontologie formalisée (OWL, UML, RDF SHACL). Sans elles, les contraintes du Chapitre III sont partiellement redondantes avec ce que les cardinalités expriment naturellement. Par exemple, C-001 ("exactement un DEFINED_BY") est simplement la cardinalité [1..1] de la relation `DEFINED_IN`.

**Cardinalités proposées :**

| Relation | Source | Cible | Cardinalité |
|---|---|---|---|
| `DEFINED_IN` | Invariant | Architecture | 1..1 |
| `APPLIES_TO` | Invariant | Architecture | 1..n |
| `IMPLIES` | Invariant | Cognitive Need | 1..n |
| `SATISFIED_BY` | Cognitive Need | Requirement | 1..n |
| `IMPLEMENTED_BY` | Requirement | UX Principle | 0..n |
| `REALIZED_BY` | UX Principle | Interaction Pattern | 1..n |
| `IMPLEMENTED_AS` | Interaction Pattern | Product Capability | 1..n |
| `CONTRIBUTES_TO` | Observation | Evidence | 1..n |
| `SUPPORTS` | Evidence | Invariant | 1..n |
| `CHALLENGES` | Evidence | Invariant | 1..n |
| `REFUTES` | Experiment | Invariant | 1..1 |
| `CONFIGURES` | Clinical Profile | Architecture | 1..1 |
| `CONFIGURES_EXPRESSION_OF` | Clinical Profile | Invariant | 1..n |
| `INSTANTIATES` | Episode | Architecture | 1..1 |

Note sur la cardinalité `IMPLEMENTED_BY` = 0..n : un Requirement peut légitimement exister sans UX Principle réalisé (état "non encore conçu"). IR-006 le détecte comme warning, pas comme erreur.

**Impact :**
- Chapitre II : ajouter une colonne Cardinalité au tableau des relations
- Chapitre III : certaines contraintes (C-001, C-003, C-004) deviennent dérivables des cardinalités — les mentionner comme corollaires plutôt que contraintes indépendantes

**Priorité :** `Important`

---

## ISSUE #12 — IR-008 utilise des comptes absolus au lieu d'un ratio

**Résumé :**
IR-008 déclare `UNDER_REVIEW` quand `count(CHALLENGES) > count(SUPPORTS)`. Un Invariant avec 20 supports et 21 challenges serait placé en revue, ce qui est peut-être correct — mais un Invariant avec 0 supports et 1 challenge le serait aussi, ce qui est différent.

**Verdict :** `Acceptée`

**Justification :**
Le ratio `CHALLENGES / (SUPPORTS + CHALLENGES)` est une mesure plus robuste. Un seuil de 0.3 (30% de challenges) déclencherait la revue. Alternativement, un seuil absolu (> 2 challenges *et* ratio > 0.2) combine les deux critères.

**Résolution retenue :** Introduire un seuil mixte :
```
IF   count(CHALLENGES CI-X) >= 2
AND  count(CHALLENGES CI-X) / count(SUPPORTS CI-X + CHALLENGES CI-X) >= 0.25
THEN CI-X → status: UNDER_REVIEW
```

**Impact :**
- IR-008 : reformulation

**Priorité :** `Amélioration`

---

## ISSUE #13 — Vocabulaires de status non alignés entre types

**Résumé :**
Chaque type d'objet a son propre vocabulaire de status, défini localement dans sa description. Ces vocabulaires ne sont pas cohérents entre eux.

**Verdict :** `Acceptée`

**Justification :**
Un vocabulaire de status partagé permet d'écrire des règles transversales (ex. IR-002 cascade) sans avoir à spécifier un vocabulaire différent pour chaque type. Proposer un vocabulaire minimal commun avec des extensions par type.

**Résolution retenue :**

*Vocabulaire commun (tout objet) :*
- `Draft` — en cours de définition
- `Active` — actif et utilisable
- `Under_Review` — remis en question — non utilisable pour de nouvelles décisions
- `Deprecated` — retiré du graphe actif, archivé

*Extensions par type :*
- Invariant ajoute : `Hypothesis` (avant première Observation), `Suspended` (Challenge dominant, en attente de résolution), `Refuted` (invalidé par Experiment — terminal)
- Experiment ajoute : `Pending`, `Confirmed`, `Inconclusive`

**Impact :**
- OT-01 à OT-14 : harmoniser les status selon ce vocabulaire
- IR-002 et IR-008 : utiliser `Under_Review` de façon cohérente

**Priorité :** `Amélioration`

---

## ISSUE #14 — Convention de nommage CN-xxx non formalisée

**Résumé :**
MKO-000 introduit les Cognitive Needs (OT-04) avec des exemples CN-01 à CN-05, mais le préfixe `CN-` n'est déclaré dans aucun tableau de conventions de nommage — ni dans MKO-000, ni dans CCF-000.

**Verdict :** `Acceptée`

**Justification :**
Toute extension du graphe doit avoir un préfixe canonique. L'absence de déclaration formelle rend le préfixe implicite — ce qui est insuffisant pour un document normatif.

**Résolution retenue :** Ajouter `CN-` au tableau des préfixes canoniques dans MKO-000 et mettre à jour CCF-000 en conséquence.

**Impact :**
- MKO-000 : ajouter section conventions de nommage
- CCF-000 : mettre à jour le tableau des préfixes

**Priorité :** `Amélioration`

---

## ISSUE #15 — Absence de contrainte anti-cyclique sur la chaîne de dérivation

**Résumé :**
Rien dans le Chapitre III n'interdit formellement un cycle dans la chaîne de dérivation (par exemple, CI-X IMPLIES CN-Y SATISFIED_BY WR-Z IMPLEMENTED_BY UX-W qui... dépend de CI-X). La structure ordonnée le prévient en pratique, mais l'ontologie n'est pas formellement protégée.

**Verdict :** `Acceptée`

**Justification :**
Un cycle dans une chaîne de dérivation est une erreur de modélisation. L'interdire formellement protège l'ontologie contre des usages créatifs non prévus et permet à un moteur de validation de le détecter automatiquement.

**Résolution retenue :**
```
C-NEW : La relation IMPLIES (et ses successeurs dans la chaîne) ne peut pas former de cycle.
Formellement : il n'existe pas de chemin A →[*]--> A dans le graphe de dérivation.
```

**Impact :**
- Chapitre III : ajouter la contrainte

**Priorité :** `Important`

---

---

## Tableau de synthèse

| # | Titre court | Verdict | Priorité |
|---|---|---|---|
| 01 | IR-004 relation inférée non déclarée | Acceptée | **Bloquant** |
| 02 | DERIVES trop générique — 4 transformations | Acceptée | **Bloquant** |
| 03 | IR-002 cascade incomplète | Acceptée | **Bloquant** |
| 04 | IR-001 propagation de support incorrecte | Acceptée avec reformulation | **Bloquant** |
| 05 | C-001 interdit réutilisation inter-Architecture | Acceptée avec reformulation | Important |
| 06 | Interaction Pattern sans rôle formel | Rejetée / Acceptée sur contraintes | Important |
| 07 | Evidence mélange types hétérogènes | Acceptée avec sous-typage | Important |
| 08 | USES trop vague | À discuter | Important |
| 09 | REALIZED_BY incohérent | Acceptée — résolue par #02 | Important |
| 10 | Framework DEFINES vs GOVERNS | À discuter | Amélioration |
| 11 | Cardinalités absentes *(nouvelle)* | Acceptée | Important |
| 12 | IR-008 comptes absolus | Acceptée | Amélioration |
| 13 | Vocabulaires de status non alignés | Acceptée | Amélioration |
| 14 | CN-xxx non formalisé | Acceptée | Amélioration |
| 15 | Absence contrainte anti-cyclique | Acceptée | Important |

**Issues bloquantes : 4**
**Issues importantes : 7**
**Issues améliorations : 4**
**Issues à discuter : 2** (#08, #10)

---

## Deux issues ouvertes avant v0.2

Avant de produire MKO-000 v0.2, deux issues requièrent une décision explicite :

### #08 — `USES` : remplacer ou conserver ?

**Contexte :** `USES` est vague mais peut être utile pour des connexions intentionnellement légères entre documents. Remplacer par `OPERATIONALIZES` ou `EXPRESSES_IN_CONTEXT_OF` est plus précis mais réduit la généralité.

**Décision requise :** Remplacement par une relation plus précise, ou maintien de `USES` comme relation de connexion légère avec sémantique explicitement faible ?

### #10 — Framework → Architecture : `DEFINES` ou `GOVERNS` ?

**Contexte :** La distinction est réelle mais l'impact est faible tant qu'un seul Framework existe. L'anticiper maintenant ou attendre le cas d'usage concret ?

**Décision requise :** Anticiper dès v0.2, ou traiter comme amélioration future ?

---

*Document produit le 2026-07-30 — source : auto-audit MKO-000 v0.1 + revue humaine.*
*Prochaine étape : résoudre les issues #08 et #10, puis produire MKO-000 v0.2.*
