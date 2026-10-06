# ADR-0022 — M2 Freeze Protocol (Validation à trois Workspaces)

**Statut** : Accepted (v1.1 — périmètre amendé le 2026-09-08, voir §2 et Historique)
**Date** : 2026-08-06
**Répond à** : discussion de session sur la méthode M2 (Sprint 1, WS-002)
**Nature** : Applique à M2 le même protocole déjà utilisé pour Cognitive Responsibility
(GOV-000 §1ter-b) — hypothèse méthodologique, test à échantillon défini, critère de sortie explicite.

---

## Contexte

La méthode M2 (traduction d'une loi M1 en décision produit) a été discutée sur plusieurs échanges de
cette session — workflow en trois axes, règle de stabilité à trois critères, format de journal — sans
jamais être consolidée en un seul endroit avec un état daté. Avant de la geler pendant qu'elle est
mise à l'épreuve, il faut un point de départ précis : sinon la revue finale n'aura rien de fixe à
comparer à ce qui aura réellement changé.

`CWRM-SCI-000` Rule 9 : *"le corpus évolue uniquement lorsqu'une meilleure explication ou une meilleure
prédiction est démontrée. Pas lorsqu'une meilleure idée est formulée."* Cette règle s'applique ici à M2
lui-même, pas seulement aux lois qu'il traduit.

---

## Décision

### 1. Instantané de M2 au moment du gel

**Workflow (trois axes parallèles) :**

| Axe | Contenu |
|---|---|
| A — Recherche | Protocole d'entretien ciblé ([CWRM-020-APX-M2](../research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md)), entretiens, observation praticien, verbatims |
| B — Produit | Hypothèses de traduction, maquettes, chaque décision documentée, rien de définitif tant que non confronté au terrain |
| C — Validation | Pour chaque entretien : confirme / infirme / surprend / nouvelle hypothèse — vocabulaire aligné sur [CC-000](../product/CC-000-clinical-cognitive-architecture.md) (Confirme/Réfute/Suspendue/Abandonnée), pas un nouveau système parallèle |

**Règle de stabilité d'une traduction M2** (trois critères cumulatifs) :
1. Cohérente avec les lois de M1.
2. Confrontée à des praticiens.
3. Non réfutée à ce stade.

Cette règle est l'application, côté M2, de Gate 3 (GOV-000 §4, Design → Engineering) — pas un système
de validation parallèle.

### 2. Périmètre du gel

Le gel porte sur **WS-002, WS-005, WS-006** — les trois seuls Workspaces réellement construits sous
M2. **WS-003 est explicitement exclu** : Gold Standard, achevé avant que M2 n'existe comme cadre ; le
tester ne dirait rien de la robustesse de M2.

> **Amendement 2026-09-08 ([ADR-0024](ADR-0024-ws004-nature-et-proof-set-m2.md), Option A adoptée).**
> WS-004 a été retiré de ce périmètre, remplacé par WS-006. Raison : audit falsificateur
> ([OBS-M2-013](../product/M2-JOURNAL-observations.md)) — WS-004 ne satisfait pas la définition
> normative de Workspace ([WSP-001](../workspace/WSP-001-workspace.md), *"assemblée pour un Actor"*) ;
> aucune responsabilité Actor-facing distincte de WS-003 n'a été démontrée. **WS-006 n'est pas un
> remplacement fonctionnel de WS-004** — les deux ne portent pas la même responsabilité. WS-004 est
> retiré parce qu'il ne satisfait pas actuellement le critère Workspace ; WS-006 est inclus parce qu'il
> le satisfait et constitue un véritable objet Actor-facing à tester. Cette substitution ne constitue
> pas une résolution générale de la classification des objets du système — la question plus large
> (taxonomie Workspace / Research Workspace / Application Service interne, critère de vérification
> avant admission dans un proof set) reste un chantier de gouvernance distinct, délibérément non traité
> ici (Option B d'`ADR-0024`, différée).

### 3. Règle du gel

Pendant la construction de ces trois Workspaces :
- **Aucune modification de M2 lui-même** (workflow, règle de stabilité, format de journal) — sauf via
  un nouvel ADR suivant le protocole d'évolution habituel (ADR-0015 Règle 4).
- Toute difficulté rencontrée est consignée dans le [Journal M2](../product/M2-JOURNAL-observations.md),
  jamais résolue en modifiant M2 à la volée.
- Chaque entrée du journal est reformulée en **hypothèse d'amélioration testable**, jamais actée
  directement — elle attend la revue de fin de gel.

**Seuil de journalisation.** Une entrée est créée uniquement si la difficulté a forcé : un
contournement du workflow déclaré, une décision de scope imprévue, ou une contradiction directe avec
ce que M2 dit faire. Pas pour toute friction mineure — sinon le journal devient soit vide, soit
inexploitable.

### 4. Condition de sortie

Le gel se termine quand les trois Workspaces ont chacun atteint : un Blueprint rédigé, au moins un
round d'entretien praticien conduit, et une entrée dans le Journal M2 pour chaque écart rencontré. La
revue de M2 qui suit se fonde sur le contenu du Journal — pas sur une impression a posteriori.

---

## Conséquences

**Pour WS-002** — Déjà en cours (Sprint 1). Le gel s'applique à partir de maintenant : toute
difficulté déjà identifiée (bloc Nouveautés non ancré, `OQ-P-001`, granularité widget non tranchée)
devient une entrée de journal, pas une révision immédiate de M2.

**Pour WS-005 et WS-006** — Construits sous ce protocole dès leur lancement. (WS-006 remplace WS-004
dans le périmètre depuis le 2026-09-08 — voir amendement §2.)

**Pour WS-003** — Aucun effet. Reste Gold Standard, hors périmètre de ce gel.

**Pour toute évolution de M2 pendant le gel** — Doit suivre le protocole d'évolution d'ADR-0015 Règle
4, pas une simple révision de conversation — le gel n'empêche pas une urgence réelle, il empêche une
révision non tracée.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| GOV-000 §1ter-b | Modèle direct — même structure (hypothèse, test, échantillon défini, critère de sortie) appliquée à M2 au lieu de Cognitive Responsibility |
| CWRM-EXP-001 §8 | Le choix de trois Workspaces reprend le seuil des 3 sources indépendantes déjà utilisé partout ailleurs dans ce corpus |
| CWRM-020-APX-M2 | Instrument de recherche déjà en place pour l'Axe A |
| M2-JOURNAL-observations | Artefact vivant créé par cet ADR, alimenté pendant toute la durée du gel |
| ADR-0015 Règle 4 | Protocole d'évolution applicable si M2 doit changer pendant le gel |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — gel de M2 pour la durée de WS-002/004/005, instantané intégré, journal ouvert |
| 2026-09-08 | 1.1 | Amendement (ADR-0024, Option A) — WS-004 retiré du périmètre §2, remplacé par WS-006. WS-004 ne satisfaisait pas la définition normative de Workspace (WSP-001), confirmé par audit falsificateur (OBS-M2-013). WS-006 explicitement non présenté comme un remplacement fonctionnel — inclus parce qu'il satisfait le critère Workspace, pas parce qu'il porterait la responsabilité de WS-004. Question de gouvernance plus large (taxonomie des objets, critère de vérification préalable) volontairement différée — Option B d'ADR-0024, chantier séparé |
