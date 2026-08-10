# WE-005 — Workspace Evidence — Information Flow Between Clinical Interventions

| Field | Value |
|---|---|
| ID | WE-005 |
| Workspace | WS-005 |
| Version | 1.0-draft |
| Status | Draft — **non conforme [ADR-0018](../../adr/ADR-0018-evidence-traceability.md)** (confiance manquante sur PAT-005-001→005, identifiants OBS-005-NNN absents) |
| Basé sur | ACT-005, OBS-005, PAT-005 |
| Nature | Research Synthesis (Layer Product Discovery) |
| Méthode | [CWRM-020-APX-WS005](../../research/specifications/CWRM-020-APX-WS005-coordination-guide.md) — grille ACT/OBS/PAT, RP-WS005-001→005 |
| Product Question | Comment les informations cliniques circulent-elles entre les interventions et entre les acteurs du parcours de soins ? |

> **Traçabilité.** Cette synthèse porte sur l'ensemble des 9 entretiens du corpus (RP-WS005-003 —
> exhaustivité avant synthèse). Les identifiants `ACT-005`/`OBS-005`/`PAT-005` désignent ici le
> résultat du recodage du corpus existant sous la grille [CWRM-020-APX-WS005](../../research/specifications/CWRM-020-APX-WS005-coordination-guide.md)
> (Mode A) ; ils ne correspondent pas encore à des fichiers séparés dans `docs/research/act/` ou
> `docs/research/observations/` — à produire si une trace détaillée par profil est requise en aval.

---

## 1. Objet de l'étude

Ce Workspace vise à comprendre comment les professionnels utilisent, produisent et font circuler des
informations cliniques au cours de leur activité.

L'objectif n'est pas de concevoir une solution logicielle, mais de caractériser les mécanismes
observables de circulation de l'information dans le corpus étudié.

---

## 2. Corpus étudié

### Population

9 entretiens.

Profils couverts :

- masseur-kinésithérapeute (×2)
- médecin
- psychologue
- échographiste
- sage-femme
- infirmière libérale
- infirmière coordinatrice
- infirmière / sophrologue

### Données produites

- ACT-005
- OBS-005
- PAT-005

### Limites

Le corpus comporte notamment :

- un seul médecin ;
- un entretien entièrement synthétisé (F003) ;
- une majorité de professionnels exerçant en ambulatoire.

Ces éléments limitent la portée des conclusions.

---

## 3. Observations synthétiques

Le corpus montre plusieurs régularités comportementales.

En particulier :

- plusieurs professionnels consultent des documents avant leur intervention ;
- plusieurs professionnels produisent un document après leur intervention ;
- certains échanges prennent la forme d'appels téléphoniques ;
- plusieurs professionnels transmettent explicitement des documents à d'autres acteurs du parcours.

Ces observations sont décrites dans OBS-005.

---

## 4. Patterns identifiés

L'analyse des observations conduit à plusieurs mécanismes explicatifs.

**PAT-005-001**
Les professionnels commencent fréquemment leur activité en s'appuyant sur des informations déjà
disponibles.

**PAT-005-002**
Une intervention conduit fréquemment à la production d'une nouvelle information destinée à être
réutilisée.

**PAT-005-003**
La communication synchrone apparaît dans des situations particulières.

**PAT-005-004**
Les modalités de circulation de l'information diffèrent selon les rôles cliniques observés.

**PAT-005-005**
La circulation de l'information repose sur plusieurs modalités complémentaires (lecture, production,
transmission, appel, relais).

---

## 5. Contre-exemples

Tous les profils ne présentent pas les mêmes comportements.

Les entretiens F002, F003 et F004 contiennent peu ou pas de comportements relevant du périmètre
actuel de WS-005.

Deux interprétations restent compatibles avec le corpus :

- certains métiers mobilisent effectivement moins ces comportements ;
- le corpus actuel ne les documente pas suffisamment.

Le corpus ne permet pas de départager ces deux hypothèses.

---

## 6. Questions non résolues

Le corpus ne répond pas encore à plusieurs questions.

**GAP-005-001**
Comment un professionnel décide-t-il qu'une information mérite d'être transmise ?

**GAP-005-002**
Quels éléments sont effectivement relus par le professionnel suivant ?

**GAP-005-003**
Quels événements déclenchent le passage d'une communication différée à une communication synchrone ?

**GAP-005-004**
Comment ces mécanismes évoluent-ils dans des organisations hospitalières ou pluriprofessionnelles
plus complexes ?

---

## 7. Portée des résultats

Les résultats décrivent les comportements observés dans le corpus étudié.

Ils ne permettent pas de conclure à leur universalité.

Toute généralisation nécessitera un corpus complémentaire.

---

## 8. Conséquences potentielles pour le produit

Le corpus suggère que plusieurs comportements observés reposent sur la consultation, la production
et la circulation d'informations cliniques.

Cette constatation peut avoir des implications pour la conception du produit.

**Aucune décision produit n'est prise dans ce document.**

Les décisions éventuelles relèvent de PDR-005.

---

## 9. Recommandations pour le PDR

Au vu des observations et des Patterns :

- réexaminer si le terme *Clinical Coordination* décrit correctement le phénomène étudié ;
- vérifier si un concept plus général centré sur la circulation de l'information représente mieux
  les mécanismes observés ;
- conserver cette question comme une décision produit explicite dans PDR-005, sans la trancher dans
  le présent document.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-05 | 1.0-draft | Synthèse initiale — recodage du corpus F001–F009 sous la grille CWRM-020-APX-WS005, 5 Patterns et 4 Gaps identifiés, aucune décision produit prise |
