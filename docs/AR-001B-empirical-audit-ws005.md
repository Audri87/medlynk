# AR-001B — Empirical Audit of WS-005

**Statut :** Figé (Accepted — Archive) — ce document n'est plus modifié après sa rédaction initiale.
**Date de l'audit réel :** 2026-08-06 (session unique)
**Date de formalisation de cet artefact :** 2026-08-06
**Rattachement :** [AR-001](AR-001-architecture-review.md) — audit empirique complémentaire à Finding-004

> **Note de provenance (importante — à ne jamais retirer).** AR-001B a été reconstruit a posteriori
> à partir des travaux effectivement réalisés durant la revue de WS-005. Il s'agit d'une
> formalisation documentaire d'une analyse déjà conduite, et non d'un compte rendu écrit en temps
> réel pendant l'audit lui-même. Rien n'a été ajouté, amélioré, ou réinterprété au moment de la
> rédaction de ce document par rapport à ce qui a été effectivement produit pendant l'audit.

> **Note d'ordre (honnêteté sur la chronologie réelle).** La séquence idéale — documenter le cas
> d'étude avant de généraliser — n'a pas été respectée dans les faits : le protocole général
> [CWRM-EXP-001](research/specifications/CWRM-EXP-001-state-transition-analysis.md) a été rédigé
> *avant* le présent document. Ce document ne prétend pas le contraire. CWRM-EXP-001 a été amendé
> après coup pour citer AR-001B comme son cas d'étude d'origine, plutôt que de laisser une note
> anonyme ("un premier passage exploratoire").

---

## 1. Objet de l'audit

Tester, par une méthode indépendante et délibérément aveugle au vocabulaire architectural existant
(aucune mention de Workspace, d'ADR, de Blueprint), si des transformations d'état cohérentes émergent
naturellement du corpus ACT — et si ces transformations, une fois trouvées, confirment ou contredisent
la frontière entre mémoire personnelle et transmission à un tiers établie par
[AR-001 Finding-004](AR-001-architecture-review.md#finding-004--la-définition-de-ws-004-empiète-sur-le-mandat-de-ws-005).

## 2. Pourquoi AR-001B a été lancé

`REV-001` (revue scientifique indépendante) avait généré une hypothèse de fusion entre deux
Workspaces à partir du texte de `WBD-004`. Cette hypothèse a été testée une première fois avec un
seul ACT ciblé, ce qui a produit `AR-001 Finding-004` (correction de `WBD-004`, retrait de "pour
d'autres" du mandat de WS-004). Il a ensuite été demandé d'aller plus loin : reprendre l'exercice de
façon totalement aveugle, sans même l'hypothèse "WS-004/WS-005", pour vérifier si la même frontière
émergerait d'une classification construite sans aucune connaissance préalable des Workspaces —
un test plus sévère qu'une simple relecture ciblée.

## 3. Questions de recherche

- **QR1.** Quelles transformations d'état émergent du corpus ACT-F001 → ACT-F009 si l'on ignore
  complètement le vocabulaire Workspace existant ?
- **QR2.** Ces transformations, une fois identifiées à l'aveugle, recoupent-elles la distinction
  "mémoire personnelle" / "transmission à un tiers" déjà établie par AR-001 Finding-004 ?

## 4. Corpus utilisé

- **Fichiers :** `ACT-F001` à `ACT-F009` (docs/research/act/), soit 9 profils, ~204 actions rapportées.
- **Limites.** `ACT-F003` (médecin, 9 actions, 100 % synthèse rapportée) a été explicitement exclu du
  clustering — granularité insuffisante, aucun verbatim direct disponible pour trancher.
- **Niveau de preuve.** Corpus mixte : verbatim direct et synthèse rapportée, non homogène entre
  profils (F004 et F007 sont les plus riches en verbatim direct ; F002, F003, F005, F006, F008 sont
  majoritairement en synthèse rapportée).

## 5. Phase 1 — Evidence Collection

**Note méthodologique.** Dans l'audit réellement conduit, la collecte d'evidence (ce paragraphe) et
l'extraction des transformations (§6) n'ont pas été deux passes séquentielles distinctes — elles ont
été réalisées en une seule lecture combinée du corpus. Elles sont présentées ici en deux sections
séparées pour la lisibilité de l'archive, pas parce que l'audit a effectivement procédé en deux temps.

L'ensemble des 9 fichiers ACT a été lu intégralement (F001, F002, F004, F005, F006, F007, F008 lus en
totalité pendant cette phase ; F003 et F009 déjà lus intégralement lors de tours antérieurs de la même
session). Aucune ligne n'a été échantillonnée ou ignorée, à l'exception de F003 (§4).

## 6. Phase 2 — State Transition Extraction

Résultat produit, groupé par transformation observée (et non ligne par ligne, un groupement fidèle
n'ajoutant ni ne retranchant rien à 204 lignes de structure répétitive) :

| Transformation | État avant | État après | Profils | Exemples (ACT) |
|---|---|---|---|---|
| T1 | Environnement de travail non prêt | Environnement prêt à l'usage | F001, F002, F005, F007, F008, F009 | F001-003/004/007/008, F002-001/002, F007-002/003/004 |
| T2 | Absence de contexte sur la situation en cours | Contexte reconstruit, présent à l'esprit | F002, F004, F005, F006, F008, F009 | F004-004→007, F005-005→010, F008-007→011 |
| T3 | Échange en cours, non capturé | Éléments retenus, présence préservée | F002, F004, F005, F006, F007, F008, F009 | F004-008/009, F008-013 |
| T4 | Capture brute, non structurée | Mémoire consolidée, structurée, durable | F002, F004, F005, F006, F007, F008, F009 | F004-010/011, F007-016/017 |
| T5 | Information connue de soi seul | Information transmise à un tiers externe | F001, F002, F005, F007, F008, F009 | F002-021 *(conditionnel)*, F005-016, F007-021/024, F009-015/026 |
| T6 | Plan de prise en charge non défini/ajusté | Plan défini ou ajusté | F001, F002, F006, F007 | F001-016/017, F007-012/013 |
| T7 | Tâche administrative en attente | Tâche traitée | F001, F007, F009 | F001-006/021/025, F007-020/022/023 |
| T8 | Signal d'alerte détecté | Prise en charge déclenchée | F005, F009 | F005-017/018/019, F009-003/031 |
| T9 | Journée/dossiers encore ouverts | Journée/dossiers clos | F001, F007, F009 | F001-024→027, F007-025, F009-033 |

## 7. Phase 3 — Blind Clustering

**Hypothèses générées (avant destruction) :**

- H1. T1 et T9 sont une seule transformation.
- H2. T2 et T4 sont une seule transformation (même objet mémoire, lu puis écrit).
- H3. T3 et T4 sont une seule transformation.
- H4. T5 est une variante conditionnelle de T4, pas une transformation distincte.
- H5. T8 est un cas particulier urgent de T5, pas une transformation distincte.
- H6. T6 fait partie du contenu de T3/T4, pas une transformation séparée.
- H7. T7 est une transformation autonome et cohérente.

## 8. Hypothèses générées

(Voir §7 — les sept hypothèses ci-dessus constituent l'intégralité des hypothèses générées pendant
l'audit. Aucune autre n'a été formulée.)

## 9. Tentatives de réfutation

- **H1** — testée contre F001/F007. États distincts (disponibilité matérielle vs statut de
  complétion). **Non détruite, non confirmée** — traitée par défaut comme deux transformations, sans
  preuve positive de fusion.
- **H2** — testée contre F004. États portant sur deux entités différentes (cognition du praticien vs
  artefact). **Détruite.**
- **H3** — testée contre F004 et F007, verbatims opposant explicitement "pendant" et "après".
  **Détruite.**
- **H4** — testée contre F002 (marqueur "conditionnel" sur T5) et F004 (dix-sept occurrences de T4,
  zéro occurrence de T5). **Détruite.**
- **H5** — testée contre F005-018. Aucun état qualitativement distinct démontré ; T8 présent sur 2/9
  profils seulement. **Confirmée — T8 fusionne dans T5.**
- **H6** — testée contre F001, qui exerce T6 (ajustement tactile) en déclarant explicitement ne
  prendre aucune note (absence de T4) sur la même séance. **Détruite.**
- **H7** — testée contre son propre contenu : hétérogène, mélange de variantes de T5 et de T1.
  **Détruite comme cluster autonome**, sans hypothèse de rattachement unique validée.

## 10. Résultats

| Transformation | Verdict |
|---|---|
| T1 — Mise en disponibilité de l'environnement | **KEEP** |
| T2 — Reconstruction du contexte (lecture) | **KEEP** |
| T3 — Capture en temps réel | **KEEP** |
| T4 — Consolidation de la mémoire | **KEEP** |
| T5 — Diffusion vers un tiers | **KEEP** |
| T6 — Ajustement du plan de prise en charge | **KEEP** |
| T7 — Tâches administratives en attente | **INSUFFICIENT EVIDENCE** (cluster autonome) |
| T8 — Réponse à un signal d'alerte | **MERGE → T5** |
| T9 — Clôture de la journée | **UNKNOWN** |

## 11. Questions ouvertes

- **T7** reste sans rattachement clair — ni fusionné ni maintenu comme cluster autonome. Nécessiterait
  un corpus plus large pour trancher.
- **T9** reste `UNKNOWN` vis-à-vis de T1 — aucune preuve positive de fusion ni de distinction
  définitive.
- **QR2 (recoupement avec AR-001 Finding-004).** T4 et T5 se sont dissociés de façon indépendante :
  absence totale de T5 sur un profil entier exerçant T4 (F004), et marqueur "conditionnel" opposant
  les deux sur un autre profil (F002). C'est la même conclusion qu'AR-001 Finding-004, obtenue par une
  méthode qui ignorait délibérément WS-004/WS-005 au moment de l'analyse. La question de savoir si ce
  recoupement est une coïncidence de corpus ou une régularité structurelle reste ouverte — un seul
  corpus, une seule reproduction, ne suffit pas à trancher (voir CWRM-EXP-001 §8, critère des 3
  sources indépendantes, ici appliqué au niveau du corpus entier plutôt qu'à une transformation
  individuelle).

## 12. Conclusion

L'audit aveugle n'a pas cherché à confirmer ou infirmer une décision d'architecture — il a cherché à
voir ce qu'un corpus produit sans qu'on lui pose de question orientée. Il a produit neuf candidats,
dont six retenus, un fusionné, un classé preuve insuffisante, un resté sans conclusion. Le fait le
plus notable n'est pas une découverte nouvelle : c'est qu'une distinction déjà établie par une autre
voie (AR-001 Finding-004) a réapparu sans avoir été cherchée. Ce document ne prétend pas que ceci
prouve la validité générale de la méthode par transformations d'état — cette question reste celle de
[CWRM-EXP-001](research/specifications/CWRM-EXP-001-state-transition-analysis.md), qui la traite
séparément et explicitement comme non tranchée.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Formalisation a posteriori de l'audit réalisé dans la session du 2026-08-06. Figé. |
