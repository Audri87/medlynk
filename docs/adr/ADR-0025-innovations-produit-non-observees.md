# ADR-0025 — Innovations produit non observées : cadre d'application et types de code autorisés

**Statut** : Accepted — 2026-10-05 (Product Owner)
**Date** : 2026-10-05
**Répond à** : relecture des fiches d'implémentation Phase 2 (WS-001 → WS-006, 2026-10-05), qui ont
qualifié de *"non fondés"* des éléments du prototype au seul motif de leur absence d'observation
terrain.
**Nature** : Application et précision de règles existantes — **pas une nouvelle méthodologie, pas une
nouvelle chaîne, pas un nouveau vocabulaire de statut.**
**Dépend de** : [GOV-000](../process/GOV-000-medlink-governance-v1.0.md) §1bis (PDX, RG-001 à RG-004,
indicateur d'Origine), §3 (marqueurs), §4 (Gates) · [ADR-0022](ADR-0022-m2-freeze-protocol.md) (gel M2)
· [ADR-0015](ADR-0015-canonical-discovery-pipeline.md) Règle 4

---

## Contexte

GOV-000 §1bis autorise déjà l'exploration de solutions non observées : *"Les problèmes viennent du
terrain. Les solutions peuvent venir du terrain, du Product, de la technologie ou de la recherche.
Elles doivent toutes être validées par le terrain avant de devenir des décisions produit."* Il nomme
même la dérive à éviter : *"Le corpus ne parle pas de X, donc on ne peut pas le faire. — Faux."*

Les fiches Phase 2 ont pourtant appliqué exactement cette dérive. Exemple le plus net :
[WS-006-implementation.md](../product/workspaces/WS-006-implementation.md) classe quatre blocs sur
sept *"Aucun ancrage / Non fondé"* et conclut *"pas de la conception fondée"*. La lacune réelle de ces
blocs n'est pas l'absence d'observation — c'est l'absence d'**hypothèse formulée** : quel problème,
quel test, quel critère d'abandon.

Le problème n'est donc pas une règle manquante, mais une règle **non appliquée**, pour trois raisons
identifiables :

1. Le format PDX (GOV-000 §1bis) est un document complet par idée — trop lourd pour un bloc d'écran ;
   en pratique, il n'a été utilisé qu'une fois (PDX-001).
2. Le cycle PDX ne prévoit pas de **critère d'abandon déclaré à l'avance** : RG-004 autorise
   l'abandon, mais rien ne le déclenche. Sans lui, une hypothèse ne meurt jamais — dérive déjà vue sur
   "widget" (OBS-M2-002/003) et traitée au cas par cas par ADR-0020 (3 rounds, sinon retrait).
3. Aucun texte ne dit **quel code** peut être écrit pour une idée non validée. Le passage
   prototype → code est donc soit bloqué par prudence, soit franchi par inertie.

Par ailleurs, une proposition de classification à sept statuts (OBSERVED / INFERRED /
PRODUCT_DECISION / INNOVATION / HYPOTHESIS / VALIDATED / REJECTED) a été formulée le 2026-10-05. Elle a
été écartée **en tant que nouveau système** : elle dupliquerait l'indicateur d'Origine et les
marqueurs ✓/≈/?/→/⚠, et elle mélange deux axes (d'où vient l'idée / où en est sa preuve). Son contenu
est repris ci-dessous sous forme de correspondance avec l'existant.

---

## Décision

### 1. Principe — réaffirmé, pas créé

L'absence d'observation terrain **n'est jamais à elle seule un motif de retrait** d'un élément produit
(GOV-000 §1bis, dérive n°1). Un élément non observé est qualifié comme hypothèse et testé ; il n'est
pas qualifié de *"non fondé"*.

Le terrain sert à répondre à *"quel problème réel ?"* — pas nécessairement à *"quelle interface ?"*.

### 2. Frontière — ce qui peut être inventé et ce qui ne le peut jamais

| MedLink peut inventer | MedLink n'invente jamais |
|---|---|
| Interactions, workflows, représentations | Une information clinique |
| Aides cognitives, automatisations | Une intention ou une décision médicale |
| Manières de préparer, reprendre, fermer une situation | Une responsabilité médicale |
| | Un événement qui n'a pas eu lieu, une donnée patient absente |
| | Une règle réglementaire inexistante |

**Inventer une expérience produit, jamais une réalité clinique.** Cette frontière découle de
[DE-P-001](../process/DE-P-001-human-reasoning-boundary.md), [DE-P-002](../process/DE-P-002-clinical-reasoning-ownership.md)
et des AI Principles de `CLAUDE.md` ; elle n'ajoute rien à leur portée.

**Précision structurante** : l'innovation est libre au niveau **Product / UX**, jamais au niveau
**Domain**. Une innovation ne peut ni contredire un invariant Domain (ex. [ADR-0010](ADR-0010-care-record.md)
Invariant 3), ni introduire un concept Domain (GOV-000 §1ter-a). Une contradiction avec le Domain se
règle par le track Domain Engineering, pas par la qualification "innovation".

### 3. Correspondance — pas de nouveau vocabulaire

Deux axes distincts, tous deux existants :

| Notion proposée | Axe | Équivalent existant |
|---|---|---|
| OBSERVED | Preuve | `✓` |
| INFERRED | Preuve | `≈` (avec confiance obligatoire, GOV-000 §3) — ou `?` si aucune convergence mesurable |
| PRODUCT_DECISION | Statut de décision | `→` + Origine (Evidence-Driven, Constraint-Driven ou Founder-Driven) |
| INNOVATION | Origine | Founder-Driven (idée du porteur) ou PDX en cours (Discovery-Driven une fois validé) |
| HYPOTHESIS | Preuve | `?` + `⚠` — identifiant `HYP-X-NNN` (GOV-000 §3, note Corpus Gap / hypothèse) |
| VALIDATED | Preuve | Validation praticiens (cycle PDX) / Gate 3 |
| REJECTED | Statut | PDX abandonné (RG-004) |

Règle de lecture : **un élément porte toujours une Origine ET un niveau de preuve.** Les deux ne se
confondent jamais.

### 4. Fiche hypothèse légère — pour un élément, pas pour un concept

Un élément d'écran non observé (bloc, action, état) n'exige **pas** un document PDX complet. Il exige
une fiche courte, inline dans la fiche d'implémentation du Workspace concerné :

```
HYP-<WS>-NNN — [Élément]
Origine:            Founder-Driven | PDX-NNN
Problème visé:      [friction documentée : ACT/OBS/PAT/GAP — ou "aucune, à documenter"]
Hypothèse:          [ce que l'élément doit produire chez le praticien]
Valeur attendue:    [pourquoi on pense que c'est utile]
Risque si faux:     [coût d'une hypothèse erronée — bruit, charge cognitive, fausse confiance…]
Test:               [question ou observation au prochain round]
Critère d'abandon:  [signal observable qui entraîne le retrait — déclaré AVANT le test]
Statut:             ? ⚠ — À tester | Validé | Abandonné (round N, date)
```

Règles :
- **Critère d'abandon obligatoire, déclaré avant le test.** C'est l'unique ajout de cet ADR à la
  discipline PDX. Il généralise le garde-fou d'ADR-0020 : une hypothèse sans critère d'abandon n'est
  pas testable.
- **Problème visé** : RG-001 reste inchangée — un PDX exige une friction documentée. Un élément dont le
  problème n'est rattaché à aucune friction documentée reste autorisé **en prototype**, avec l'Origine
  `Founder-Driven` et la mention *"Problème visé : aucun ancrage, à documenter"* ; il ne peut pas
  devenir PDX tant que la friction n'est pas documentée.
- **Escalade vers PDX** : une fiche HYP devient un PDX complet si l'idée dépasse un écran (concept
  transverse, ex. PDX-001 capture IA) ou si elle vise à devenir un Product Principle.

### 5. Types de code autorisés — selon le Gate franchi

GOV-000 §4 fixe déjà la frontière : l'Engineering commence à **Gate 3** (prototype basse fidélité,
tests sur au moins 5 praticiens, ajustements intégrés) — pas à Gate 2. Cet ADR nomme les types de
code qui peuvent exister avant :

| Type | Finalité | Autorisé | Contraintes |
|---|---|---|---|
| **Prototype UX** | Montrer, faire réagir | Dès maintenant, quel que soit le statut | HTML statique, `docs/product/workspaces/` ; chaque élément non `✓` porte sa mention d'hypothèse |
| **Prototype de recherche** | Instrument de test praticien (cliquable, données fictives, éventuellement persistance locale) | Dès maintenant, quel que soit le statut | Hors de `src/` ; **aucune donnée patient réelle** ; jamais déployé en production ; jamais promu en code produit par copie — il est réécrit |
| **Code jetable (spike)** | Lever une incertitude technique (ex. faisabilité de la transcription IA) | Dès maintenant | Hors de `src/`, ou branche non fusionnée ; supprimé ou archivé après conclusion |
| **Code produit** | Le logiciel MedLink | **Uniquement pour les éléments ayant franchi Gate 3** | `src/` ; conformité totale à `CLAUDE.md` et aux ADR-SA (hexagonal, CQRS/Messenger, DBAL, Outbox, Voters, HDS) |

Précisions :
- Le schéma simplifié *Controller → Use Case → Domain → Projection → View* n'est **pas** une
  architecture : c'est un résumé, déjà couvert et précisé par ADR-0003, ADR-0004 et ADR-SA-005 à 013.
  En cas d'écart, les ADR-SA prévalent.
- Le code Domain issu du track Domain Engineering ([DE Baseline V1](../DE-BASELINE-V1.md), ES-001→004
  Frozen) suit son propre track ; il n'est pas conditionné aux Gates des Workspaces et n'est pas
  affecté par cet ADR.
- Un prototype de recherche **est un outil de recherche** (GOV-000 Niveau 3/5) : son existence ne
  vaut jamais validation. Le fait qu'il fonctionne ne dit rien de son utilité.

### 6. Revue — deux questions systématiques

Pour chaque élément revu :
- **Question A — Evidence** : *qu'est-ce qui nous permet de penser que ce problème existe ?*
- **Question B — Design** : *quelle est la meilleure solution que MedLink puisse imaginer pour ce
  problème ?*

Les deux réponses peuvent diverger ; c'est attendu. Une réponse faible à A n'invalide pas B — elle
rend B plus risquée, donc son critère d'abandon plus important.

---

## Ce que cet ADR ne fait pas

- **Ne modifie pas M2** (ADR-0022 §1 : workflow, règle de stabilité, format de journal). L'Axe B de M2
  prévoit déjà *"hypothèses de traduction, maquettes… rien de définitif tant que non confronté au
  terrain"* ; cet ADR en précise l'application. Le gel M2 n'est pas levé, ses conditions de sortie
  (§4) sont inchangées.
- **N'introduit pas de nouvelle chaîne** : le cycle utilisé est celui de PDX (GOV-000 §1bis). ADR-0015
  Règle 4 n'est donc pas déclenchée.
- **Ne modifie pas RG-001 à RG-004**, ni les Gates, ni les marqueurs.
- **Ne modifie pas `CLAUDE.md`**.
- **Ne requalifie aucune fiche** — c'est la conséquence suivante, pas le contenu de cet ADR.
- **Ne lève aucun blocage existant** : WS-005 reste bloqué par Finding-001 pour sa partie fondée sur
  les PAT ; qualifier un élément d'"innovation" ne le soustrait pas à une dette méthodologique qui
  porte sur le *problème*, pas sur la solution.

---

## Justification (grille CWRM-AF-001, gabarit d'ADR-0015 Règle 3 / ADR-0020 / ADR-0024)

| # | Question | Réponse |
|---|---|---|
| 1 | Quel problème empirique résout-il ? | Les fiches Phase 2 ont qualifié de "non fondés" des éléments non observés, contrairement à GOV-000 §1bis ; et aucun texte ne dit quel code est autorisé avant validation. |
| 2 | Quel Claim renforce-t-il ? | Aucun Claim CWRM — décision de gouvernance produit. |
| 3 | Quelle hypothèse est concernée ? | Qu'une fiche HYP légère avec critère d'abandon suffit à rendre testables les éléments non observés, sans alourdir la documentation. |
| 4 | Comment sera-t-il validé ? | Par la requalification de WS-006 (cas le plus défavorable : 4/7 blocs sans ancrage), puis par le round praticien v8 : les critères d'abandon déclarés doivent permettre de conclure élément par élément. |
| 5 | Quelle métrique permettra de conclure ? | Après le round v8, chaque fiche HYP de WS-006 porte un statut Validé / Abandonné / À re-tester avec justification — aucune ne reste "À tester" sans raison. Si ce n'est pas le cas, le format HYP est à revoir avant d'être étendu aux autres Workspaces. |

---

## Conséquences

Dans cet ordre :
1. **Requalification de WS-006** ([WS-006-implementation.md](../product/workspaces/WS-006-implementation.md)) :
   chaque bloc "non fondé" devient une fiche HYP (problème, hypothèse, test, critère d'abandon).
   Le contre-signal ACT-F001-027 devient le critère d'abandon de l'écran lui-même, pas un motif de
   retrait anticipé.
2. Si la méthode tient sur WS-006 : même mécanique sur WS-001, WS-002, WS-003, Care Record, WS-005.
3. **Round praticien v8** : le guide d'entretien intègre les tests déclarés par les fiches HYP.
4. **GOV-000 §1bis** : à annoter à l'acceptation (fiche HYP légère, critère d'abandon obligatoire) —
   nouvelle version mineure, aucune règle existante modifiée.
5. **ARCH-000** : référence à ajouter à l'acceptation.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| GOV-000 §1bis | Cadre appliqué ; format HYP = forme légère du PDX ; critère d'abandon = seul ajout |
| GOV-000 §3 | Marqueurs et identifiants `HYP-X-NNN` réutilisés, pas remplacés |
| GOV-000 §4 | Gate 3 confirmée comme frontière du code produit |
| ADR-0022 | Gel M2 inchangé ; cet ADR s'inscrit dans l'Axe B |
| ADR-0020 | Précédent direct du critère d'abandon (3 rounds, sinon retrait) |
| ADR-0015 Règle 4 | Non déclenchée — aucune nouvelle chaîne |
| ADR-SA-005 à 013 | Seule référence d'architecture pour le code produit |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-10-05 | 0.1 | Création — Proposed. Réaffirme GOV-000 §1bis contre la dérive "non observé = non fondé" relevée dans les fiches Phase 2 ; frontière expérience produit / réalité clinique / Domain ; correspondance de la classification proposée avec l'existant (aucun nouveau statut) ; fiche HYP légère avec critère d'abandon obligatoire ; quatre types de code, code produit conditionné à Gate 3. En attente de décision du Product Owner. |
| 2026-10-05 | 1.0 | Accepted — Product Owner confirme le texte tel que proposé, y compris le maintien intact de RG-001 (un élément sans friction documentée reste autorisé en prototype, Origine `Founder-Driven`, mais ne peut pas devenir PDX). Conséquences 4 et 5 appliquées (GOV-000 v1.9, ARCH-000 v2.2). |
