# M1_FINAL_ARCHIVE — Archive Scientifique du Programme de Recherche M1

**Statut du programme :** Terminé. M1 ne doit plus être modifié.
**Date d'archivage :** 2026-08-06
**Rédigé par :** Research Archivist (rôle tenu pour ce document)
**Portée :** Tout artefact produit entre l'ouverture du travail CWRM/GOV-000 et la clôture formelle
de M1 ([ADR-0019](adr/ADR-0019-close-milestone-m1.md)), y compris [AR-001](AR-001-architecture-review.md)
Finding-004 (revue de transition vers M2, exécutée après la clôture mais rattachée à M1 par son
origine).

**Convention de ce document.** Chaque affirmation porte une étiquette :
- **[Evidence]** — donnée brute vérifiable (verbatim, fichier, citation exacte).
- **[Observation]** — constat dérivé d'une lecture ou d'une recherche du corpus, non interprété.
- **[Hypothèse]** — proposition non tranchée, testable.
- **[Décision]** — choix acté, avec référence à l'artefact qui l'a formalisé.

Ce document ne propose rien. Il ne modifie aucun ADR. Il documente l'état final.

---

## 1. Executive Summary

M1 ("Architecture Foundation") visait à stabiliser les fondations méthodologiques et
architecturales de MedLink avant l'ouverture de nouveaux Workspaces. **[Décision]** M1 est déclaré
`Accepted` par [ADR-0019](adr/ADR-0019-close-milestone-m1.md), avec deux items de dette
explicitement exclus du périmètre (`ARCH-DEBT-001`, `ARCH-DEBT-002`, statut `Deferred`).

Le chemin vers cette clôture n'a pas été une simple validation : une revue d'architecture
contradictoire (deux passes, 9 constats documentés) a d'abord établi que l'architecture, telle
qu'énoncée initialement comme "acquise", contenait des incohérences réelles — chaînes de pipeline
multiples et contradictoires, un concept pivot (`PAT`) sans définition formelle dans aucune
spécification "Accepted", une hypothèse (`Cognitive Responsibility`) présentée comme gelée alors
qu'elle ne l'était pas. Un Sprint de Consolidation (M1.1, 5 ADR) a corrigé ces points. Une revue
scientifique indépendante ultérieure (`REV-001`) a de nouveau testé le modèle consolidé et rendu un
verdict `MAJOR REVISION` — pas `REJECT`, mais pas `ACCEPT` non plus. Un test empirique direct contre
le corpus (`AR-001` Finding-004) a ensuite falsifié une recommandation issue de cette revue (la
fusion WS-004/WS-005), tout en révélant une erreur réelle dans `WBD-004`, désormais corrigée.

L'archive qui suit documente cette trajectoire complète, pas seulement son point d'arrivée.

---

## 2. Chronologie de M1

| Étape | Artefact(s) | Nature |
|---|---|---|
| 1 | CWRM-000, CWRM-000A, CWRM-001, CWRM-002, CWRM-020, CWRM-AF-001, CWRM-STD-001/002, CWRM-SCI-000, CWRM-FND-001 | Fondations méthodologiques de recherche (préexistantes à ce fil d'archivage) |
| 2 | GOV-000 (v1.0 → v1.4) | Gouvernance produit — 6 niveaux, 5 Gates, marqueurs, circuit Product Discovery (PDX) |
| 3 | WS-001, WS-002, WS-003, WBD-004 (v1.0), WE-004, PDR-004, PDX-001 | Premiers Workspaces construits, premier cycle Discovery → Product complet |
| 4 | WBD-004 v2.0 | Résolution de frontière WS-003/WS-004, Clinical Loop étendue jusqu'à WS-006 |
| 5 | GOV-000 v1.5 | Introduction expérimentale de `Cognitive Responsibility` (§1ter-b), non gelée par construction |
| 6 | CWRM-020-APX-WS005, RP-WS005-001→005, OBS-REQ-001→003 (CWRM-001 v2.1), PAT-REQ-001 (scopé local) | Instrumentation du test WS-005 ; conflit avec CWRM-AF-001 identifié et traité (PAT-REQ non intégré au core) |
| 7 | WE-005 | Premier résultat empirique du test WS-005 — contient déjà une remise en question de son propre nom candidat (§9) |
| 8 | GOV-000 v1.6 | Extension du protocole de test à WS-005 **et** WS-006 |
| 9 | **Revue d'architecture, passe 1** (5 critiques) | Pipeline multiple, PAT non défini, WE-005 non conforme, frontière WS-005/006 contradictoire, Responsibility déclarée acquise à tort |
| 10 | **Revue d'architecture, passe 2** (4 questions ciblées) | Boucle incomplète, pipeline non minimal, absence de garde-fou anti-cycle sur WS-005, une fuite d'autorité Domain→Product (citation Clinical State) |
| 11 | ADR-0015, ADR-0016, ADR-0017, ADR-0018 + édits directs (WBD-004, WS-003 §11, GOV-000 v1.7) | **Sprint M1.1 — Consolidation** |
| 12 | ARCH-000, ARCH-DEBT-REGISTER, M1-ARCHITECTURE-FOUNDATION | Index d'architecture, registre de dette, enregistrement narratif de clôture |
| 13 | ADR-0019 | **Clôture formelle de M1** — `Accepted`, ARCH-DEBT-001/002 `Deferred`, `AR-001` réservé |
| 14 | CONSTITUTION.md | Texte philosophique fondateur — coexiste avec FOUNDATIONS.md/MANIFESTO.md sans hiérarchie déclarée (choix explicite du Product Owner) |
| 15 | **REV-001** | Revue scientifique indépendante du modèle consolidé — verdict `MAJOR REVISION` |
| 16 | AR-001, Finding-004 | Test empirique de l'hypothèse de fusion WS-004/WS-005 (REV-001) contre le corpus ACT — hypothèse rejetée, WBD-004 v2.1 corrigé |

---

## 3. Principales découvertes

**[Evidence]** `PAT` (Pattern) n'apparaît dans aucune des trois spécifications CWRM marquées
`Accepted` (CWRM-000A, CWRM-001, CWRM-002) — recherche exhaustive, zéro occurrence — alors qu'il est
l'unique mécanisme d'agrégation utilisé par les quatre artefacts Product réels du corpus (WE-004,
WE-005, PDR-004, PDX-001).

**[Evidence]** Cinq documents du corpus décrivaient cinq chaînes de transformation Discovery → Product
non identiques, dont deux mutuellement gelées et contradictoires (CWRM-002 §3 vs CWRM-AF-001).

**[Evidence]** WE-005 ne respecte pas la règle de confiance obligatoire pour tout Pattern, gelée
depuis GOV-000 v1.1 — vérifié ligne par ligne, aucun des cinq PAT-005-NNN n'affiche de confiance.

**[Evidence]** `WS-004` et `WS-005` sont deux transformations cognitives distinctes, pas une seule.
ACT-F002-019/021, ACT-F005-013/016, ACT-F009-025/026 codent systématiquement deux ACT séquentiels
(mémoire, puis transmission — cette dernière explicitement *"conditionnelle"* dans ACT-F002-021).
ACT-F004 (profil entier, 17 ACT) exerce la construction de mémoire durable sans aucun acte de
transmission documenté.

**[Observation]** `CWRM-030` (Coding Manual), qui devrait spécifier la procédure de passage
verbatim → ACT, n'a jamais été rédigé (statut "Prévu" depuis l'origine de l'INDEX des spécifications).
L'étape la plus utilisée du pipeline n'a donc aucune procédure documentée, seulement des exemples de
format.

**[Observation]** Le module `Workspace` a historiquement existé comme concept `Domain`
(`src/Workspace/Domain/`), en contradiction avec CLAUDE.md et GOV-000 §1ter-a — sa suppression est
en cours mais non commitée au moment de l'archivage (`ARCH-DEBT-002`).

---

## 4. Décisions architecturales retenues (ADR)

Liste des décisions actées durant M1. Aucune n'est réécrite ici — seule la référence et l'objet sont
rappelés.

| ADR | Objet |
|---|---|
| [ADR-0015](adr/ADR-0015-canonical-discovery-pipeline.md) | Déclare une chaîne Product Discovery canonique unique ; les chaînes CWRM-001/002/AF-001 antérieures passent `Historical` |
| [ADR-0016](adr/ADR-0016-status-of-experimental-concepts.md) | Table de statut Stable / Experimental / Historical pour chaque concept du pipeline |
| [ADR-0017](adr/ADR-0017-freeze-semantics.md) | Distingue Accepted / Experimental / Frozen, évalués par clause et non par document |
| [ADR-0018](adr/ADR-0018-evidence-traceability.md) | Règles de traçabilité (confiance obligatoire, ancrage PAT→OBS→ACT) |
| [ADR-0019](adr/ADR-0019-close-milestone-m1.md) | Clôture formelle de M1, dette ARCH-DEBT-001/002 `Deferred`, identifiant `AR-001` réservé |

---

## 5. Hypothèses rejetées

**[Décision]** La fusion des Workspaces WS-004 et WS-005 en un seul — hypothèse posée par `REV-001`
§4/§8/§9 à partir du texte de WBD-004 (*"pour soi-même et pour d'autres"*) — est **rejetée**.
[Evidence] Le niveau ACT du corpus montre deux actes distincts, séquentiels, à statut différent
(l'un systématique, l'autre conditionnel). Rejeter cette fusion n'a pas restauré le texte d'origine :
`WBD-004` v2.1 a été corrigé pour retirer *"et pour d'autres"* du mandat de WS-004 — la frontière
existe, elle était seulement mal placée dans le texte (`AR-001` Finding-004).

**[Décision]** La chaîne SEQ → RQ → INV → Requirement → Design Reasoning (CWRM-001/002/AF-001) comme
chaîne *opérationnelle* du Product Discovery — non falsifiée en tant que méthode de recherche, mais
déclarée **non exercée** (`Historical`, ADR-0016) : aucun artefact réel du corpus n'a jamais produit
de RQ ou d'INV.

**[Décision]** *"Le modèle Clinical State existant"* comme artefact Domain établi — corrigé dans
GOV-000 §1ter-b (v1.7) : ce diagramme est un outil de travail Product, explicitement qualifié par
WS-003 §6 lui-même de *"simplification pédagogique"*, absent de tout document du track Domain.

---

## 6. Hypothèses encore ouvertes

**[Hypothèse]** `Cognitive Responsibility` / nom candidat *Clinical Coordination* — statut
`Experimental` (ADR-0016). Protocole de sortie défini (GOV-000 §1ter-b v1.6/1.7) : validation
conditionnée à la résistance de la méthode sur WS-005 **et** WS-006. Non conclu.

**[Hypothèse]** Le store de sortie exact de WS-005 (canal externe distinct, ou sous-ensemble marqué
de la mémoire WS-004) — clarifié partiellement par `AR-001` Finding-004, non tranché.

**[Hypothèse]** Trois `MAJOR ISSUE` de `REV-001` (PAT sans Gate / CWRM-030 absent ; généralisation de
portée dans CONSTITUTION.md et la Mission au-delà de ce que CWRM-001 soutient ; frontière WS-006 →
WS-001 du jour suivant non spécifiée) — identifiées, non formalisées en Finding AR-001, en attente de
décision du Product Owner.

**[Hypothèse]** Le nom définitif de WS-004 — toujours *"à confirmer"* (WBD-004 depuis sa v1.0).

---

## 7. Limites connues

**[Evidence]** Corpus : 9 entretiens, France, majoritairement ambulatoire/libéral, un seul médecin,
un entretien entièrement synthétisé sans verbatim (F-003) — CWRM-001 §"Limites explicites du corpus
actuel" documente noir sur blanc l'exclusion du bloc opératoire, des urgences, du SAMU et de la
réanimation.

**[Observation]** Cette limite de portée, explicite au niveau recherche (CWRM-001), n'est pas
répercutée dans les documents que lit en premier un nouveau contributeur (CONSTITUTION.md, Mission
CLAUDE.md) — signalé par `REV-001` §6, non corrigé à ce jour.

**[Observation]** Aucun accord inter-codeurs (IRR) n'a été mesuré, alors que CWRM-SCI-000 le présente
comme la mesure de validité principale de la méthode. Neuf entretiens ont été codés sans ce contrôle.

---

## 8. Validation obtenue

**[Evidence]** Indépendance du Domain vis-à-vis du vocabulaire Product/CWRM — vérifiée par recherche
exhaustive dans `src/` (aucune occurrence de `PDX-`, `WE-00X`, `PDR-00X`, `WBD-00X`, `Cognitive
Responsibility`).

**[Evidence]** WS-001, WS-002, WS-003 disposent chacun d'un Blueprint avec chaîne de preuve
identifiable (WE-004 → PDR-004 pour PP-013/PP-014 de WS-003, notamment).

**[Evidence]** La frontière WS-004/WS-005, contestée par `REV-001`, a résisté à un test empirique
direct contre le corpus ACT (`AR-001` Finding-004) — c'est une validation obtenue, pas seulement une
affirmation non contestée.

**[Décision]** La chaîne canonique unique (ADR-0015) et le système de statut de concept (ADR-0016)
sont adoptés et appliqués rétroactivement sans contradiction relevée sur les artefacts existants.

---

## 9. Validation encore manquante

**[Hypothèse non validée]** `Cognitive Responsibility` — test en cours, non conclu.

**[Gate absente]** `PAT` — aucun mécanisme de validation (Gate, seuil, condition de réfutation)
n'existe, malgré son usage central.

**[Non conforme]** WE-005 — reste `Draft — non conforme ADR-0018` (confiance et ancrage OBS
manquants) ; sa correction attend un recodage réel du corpus (Mode A, CWRM-020-APX-WS005).

**[Non actionné]** Trois `MAJOR ISSUE` de REV-001 (§1/2, §6, §8) — identifiés, non formalisés en
Finding AR-001.

---

## 10. Questions transmises à M2

1. `PAT` doit-il recevoir une Gate formelle, ou être fusionné dans `OBS` comme une observation
   agrégée porteuse d'une confiance ?
2. La portée évidencée (ambulatoire/libéral, France) doit-elle être rendue explicite dans
   CONSTITUTION.md et la Mission (CLAUDE.md), pas seulement dans CWRM-001 ?
3. Quel est le Blueprint de WS-006, et que lit-il exactement de WS-004/WS-005 ?
4. Quel est le store de sortie précis de WS-005 ?
5. `CWRM-030` (Coding Manual) doit-il être rédigé avant toute nouvelle campagne de codage ?
6. `FOUNDATIONS.md` / `MANIFESTO.md` / `CONSTITUTION.md` doivent-ils un jour être hiérarchisés
   explicitement, ou cette coexistence reste-t-elle un choix assumé ?
7. `ARCH-DEBT-001` (frontière WE↔PDR) et `ARCH-DEBT-002` (module Workspace historique) — traités dans
   quel sprint ?
8. Les Findings 001-003 de `REV-001`, non formalisés dans `AR-001` — formalisés ou classés
   `Deferred` ?

---

## 11. Leçons méthodologiques

**[Observation]** Un concept peut devenir central en pratique (`PAT`) bien avant d'être formellement
spécifié — l'usage informel dépasse la gouvernance si rien ne le rattrape explicitement.

**[Observation]** Un document de synthèse (WBD-004) peut affirmer une frontière plus large que ce que
le niveau de preuve le plus bas (`ACT`) soutient réellement — la fusion WS-004/WS-005 semblait
défendable au niveau du texte de synthèse ; elle a été rejetée uniquement en redescendant au niveau
`ACT`. La discipline "le corpus prime sur l'hypothèse produit" (RP-WS005-001) a changé une
conclusion, pas seulement confirmé une intuition.

**[Observation]** Une discipline d'identifiants (CWRM-STD-002) peut être spécifiée et rester non
appliquée dans les faits — le registre d'unicité qu'elle exige (`corpus/registry.yaml`) n'a jamais
été créé, ce qui a directement permis une collision d'identifiants (ADR-0008→0011 déjà pris).

**[Observation]** Une citation peut transférer une autorité non voulue : GOV-000 a cité un diagramme
explicitement qualifié de pédagogique par son propre document source (WS-003) comme s'il s'agissait
d'un modèle établi — corrigé, mais révèle que la discipline de citation n'était pas systématique.

---

## 12. Ce qui ne doit plus être modifié dans M1

- Les décisions actées par [ADR-0001](adr/ADR-0001-platform-kernel.md) à
  [ADR-0019](adr/ADR-0019-close-milestone-m1.md) : leur contenu, tel qu'il existe à la clôture de M1,
  est un fait historique. Une évolution future crée un nouvel ADR ou une nouvelle version — elle ne
  réécrit pas l'historique de M1.
- [GOV-000](process/GOV-000-medlink-governance-v1.0.md) v1.7 comme instantané de gouvernance à la
  clôture de M1.
- Le corpus source (`docs/research/interviews/`, `docs/research/act/`, `docs/research/observations/`)
  — immuable par construction (CWRM-020, Failed Interview Management, Retention).
- Les deux hypothèses rejetées (§5) — elles ne doivent pas être re-proposées sans preuve nouvelle,
  au même titre que RP-WS005-001 l'impose déjà pour `Cognitive Responsibility`.
- Le statut `Deferred` de `ARCH-DEBT-001`/`ARCH-DEBT-002` tel qu'accepté par ADR-0019 — leur
  traitement est une décision de sprint futur, pas une réouverture de M1.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Archive initiale et finale de M1 |
