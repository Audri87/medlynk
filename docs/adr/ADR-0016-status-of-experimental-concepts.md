# ADR-0016 — Statut des Concepts (Stable / Experimental / Historical)

**Statut** : Accepted
**Date** : 2026-08-06
**Sprint** : M1.1 — Consolidation (priorité 1)
**Répond à** : Critique 2 et, en partie, Critique 5 de la revue d'architecture M1

---

## Contexte

ADR-0015 déclare une chaîne canonique. Il reste nécessaire de savoir, pour chaque concept qui y
apparaît (ou qui apparaît dans un document adjacent), s'il est prêt à être traité comme une couche
officielle sur laquelle une décision produit peut s'appuyer sans réserve.

Avant cet ADR, `PAT` était utilisé exactement comme `OBS` ou `INV` — sans qu'aucune des trois
spécifications CWRM "Accepted" (CWRM-000A, CWRM-001, CWRM-002) ne le définisse, et sans qu'aucune
Gate ne le régule (Critique 2). `Cognitive Responsibility` était listée comme "acquise" dans un
message de freeze alors que sa propre spécification (GOV-000 §1ter-b) la qualifie de non gelée
(Critique 5).

---

## Décision

### Les trois statuts

| Statut | Définition | Peut fonder une décision produit sans réserve ? | Peut apparaître dans un jalon "acquis" ? |
|---|---|---|---|
| **Stable** | Défini, doté d'une Gate ou d'un format vérifiable, exercé par au moins un artefact réel | Oui | Oui |
| **Experimental** | Utilisé en pratique mais sans Gate stabilisée, ou explicitement soumis à un protocole de test non conclu | Non — toute décision qui s'appuie dessus doit porter la mention `⚠ (fondé sur un concept Experimental)` | **Non, jamais** (voir ADR-0017) |
| **Historical** | Spécifié dans un document Accepted, mais non exercé par la chaîne canonique actuelle (ADR-0015) | Non — réactivation requiert le protocole d'évolution (ADR-0015 Règle 3) | Non |

### Table de statut (2026-08-06)

| Concept | Couche / Source | Statut | Justification |
|---|---|---|---|
| ACT | CWRM-001 Layer 1 | **Stable** | Gate 1 défini, exercé sans interruption depuis F-001 |
| OBS | CWRM-001 Layer 1/2 | **Stable** | Gate 2 défini ; usage réel mais non uniforme — voir ADR-0018 |
| SEQ | CWRM-001 | **Historical** | Jamais utilisé par un artefact Product réel ; absent de la chaîne canonique (ADR-0015) |
| RQ | CWRM-001/002 Layer 2 | **Historical** | Aucun RQ-xxx n'existe dans le corpus |
| INV | CWRM-001/002 Layer 2 | **Historical** | Aucun INV-xxx n'existe ; Gate 3 jamais franchie |
| Requirement / Design Reasoning | CWRM-002 Layer 3 | **Historical** | Idem — jamais produit |
| PAT | GOV-000 Niveau 1 | **Experimental** | Aucune Gate formelle dans CWRM-000A/001/002 ; pivot de tout le travail Product réel malgré cela |
| Tension (`TEN-X-NNN`) | GOV-000 §3 v1.1 | **Stable** | Définition, symbole et règle de résolution explicites ; déjà exercé (TEN-D-001/002) |
| Corpus Gap (`GAP-X-NNN`) | GOV-000 §3 | **Stable** | Symbole et distinction avec `HYP` explicites |
| RH | Message de freeze M1 | **Experimental — non défini** | Aucune définition trouvée dans le corpus ; usage suspendu tant que non défini ou retiré |
| WE — Workspace Evidence | GOV-000 Niveau 2 | **Stable** | Format établi, deux instances réelles (WE-004, WE-005) |
| WBD — Workspace Boundary Decision | GOV-000 §4 v1.2 | **Stable** | Un cas réel (WBD-004), critères de sortie explicites |
| PDR — Product Decision Record | GOV-000 Niveau 2 | **Stable** | Un cas réel (PDR-004), Gate 2 v1.2 explicite |
| PDX — Product Discovery | GOV-000 §1bis v1.4 | **Stable** | RG-001→004, un cas réel (PDX-001) |
| Cognitive Responsibility | GOV-000 §1ter-b v1.5 | **Experimental** | Explicitement non gelée par sa propre spécification ; test en cours (v1.6, WS-005+WS-006) |
| *Clinical Coordination* (nom candidat) | GOV-000 §1ter-b v1.5 | **Experimental — contesté** | WE-005 §9 recommande déjà de le réexaminer |

### Règle contraignante

**Aucun jalon d'architecture (Freeze, Milestone) ne peut lister un concept au statut `Experimental`
parmi ses éléments "acquis".** Un concept `Experimental` cité dans un jalon doit être explicitement
étiqueté comme tel, jamais fondu dans la liste des éléments stables.

---

## Conséquences

**Pour PAT** — Reste utilisable (il est le seul mécanisme d'agrégation disponible aujourd'hui), mais
toute décision qui en dépend directement porte désormais la mention `⚠`. Sa promotion à `Stable`
nécessite qu'une Gate équivalente à Gate 2/Gate 3 (CWRM-001) soit spécifiée pour lui — travail non
fait par cet ADR, seulement rendu visible comme manquant.

**Pour Cognitive Responsibility / Clinical Coordination** — Ne peuvent plus être cités comme acquis
dans un futur jalon tant que le protocole GOV-000 §1ter-b (v1.6) n'a pas conclu sur WS-005 **et**
WS-006.

**Pour RH** — Suspendu. À définir explicitement ou retiré de tout futur diagramme de pipeline.

**Pour SEQ/RQ/INV/Requirement/Design Reasoning** — Disponibles pour réactivation si un besoin
empirique apparaît (par exemple si un Pattern nécessite une corroboration inter-profession plus
stricte que ce que PAT offre aujourd'hui).

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| ADR-0015 — Canonical Discovery Pipeline | Cet ADR définit le statut de chaque nœud de la chaîne qu'ADR-0015 déclare canonique |
| ADR-0017 — Freeze Semantics | Définit ce que "ne peut pas apparaître dans un jalon acquis" signifie précisément |
| GOV-000 §1ter-b | Cognitive Responsibility conserve son statut Experimental déjà déclaré ; cet ADR le rend opposable au niveau de tout futur jalon, pas seulement au niveau de GOV-000 |
| WE-005 | Source de la contestation du nom *Clinical Coordination* |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — Sprint M1.1, réponse aux Critiques 2 et 5 de la revue d'architecture M1 |
