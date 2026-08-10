# ADR-0019 — Clôture du Jalon M1 (Architecture Foundation)

**Statut** : Accepted
**Date** : 2026-08-06

---

## Contexte

Le jalon M1 (*"Architecture Foundation"*) avait pour objectif de stabiliser les fondations
méthodologiques et architecturales de MedLink avant l'ouverture de nouveaux Workspaces.

À l'issue du Sprint M1.1 :

- une chaîne canonique de Product Discovery est définie ([ADR-0015](ADR-0015-canonical-discovery-pipeline.md)) ;
- le statut des concepts est clarifié ([ADR-0016](ADR-0016-status-of-experimental-concepts.md),
  [ADR-0017](ADR-0017-freeze-semantics.md)) ;
- les règles de traçabilité sont formalisées ([ADR-0018](ADR-0018-evidence-traceability.md)) ;
- les principales incohérences documentaires identifiées lors de la revue d'architecture externe du
  2026-08-06 ont été corrigées ([WBD-004](../product/workspaces/WBD-004-consultation-vs-documentation.md),
  [WS-003](../product/workspaces/WS-003-consultation.md) §11, GOV-000 §1ter-b) ou explicitement
  documentées ([ARCH-DEBT-REGISTER](../ARCH-DEBT-REGISTER.md)).

---

## Décision

Le jalon **M1 — Architecture Foundation** est déclaré **Accepted**.

Les fondations sont considérées comme suffisamment stables pour ouvrir une nouvelle phase de
découverte produit.

Cet ADR est la version formelle, numérotée, de la signature déjà enregistrée dans
[M1-ARCHITECTURE-FOUNDATION.md](../M1-ARCHITECTURE-FOUNDATION.md) — les deux documents portent la
même décision ; celui-ci en est l'enregistrement dans la série ADR.

---

## Dette architecturale connue

La clôture de M1 n'implique pas l'absence totale de dette architecturale.

Les écarts suivants restent ouverts, avec les identifiants déjà enregistrés dans
[ARCH-DEBT-REGISTER](../ARCH-DEBT-REGISTER.md) (pas de nouvel identifiant créé ici, pour éviter que
les deux mêmes écarts portent deux ID différents selon le document consulté) :

| ID | Description | Impact |
|---|---|---|
| [ARCH-DEBT-001](../ARCH-DEBT-REGISTER.md#arch-debt-001--frontière-we--pdr-déjà-franchie-en-pratique) | Frontière documentaire entre WE et PDR à consolider | Moyen |
| [ARCH-DEBT-002](../ARCH-DEBT-REGISTER.md#arch-debt-002--module-workspace-historiquement-présent-en-domain) | Ancien module Workspace (Domain) — documenté dans le registre, suppression non encore commitée | Faible |

Ces éléments sont volontairement reportés à un sprint de consolidation ultérieur (statut `Deferred`).
Ils ne bloquent pas la poursuite du projet.

---

## Conséquences

À partir de cette décision :

- [GOV-000](../process/GOV-000-medlink-governance-v1.0.md) v1.7 devient la référence de gouvernance ;
- ADR-0015 → ADR-0018 constituent la base canonique du Product Discovery ;
- aucune nouvelle évolution méthodologique n'est prévue avant validation sur un nouveau Workspace
  (voir le protocole de test §1ter-b de GOV-000, WS-005 + WS-006) ;
- l'ouverture de **WS-006** est précédée d'une revue d'architecture, **AR-001** (identifiant
  réservé par cet ADR ; document non encore rédigé — voir §Suites).

---

## Suites — AR-001

`AR-001` désigne la revue d'architecture qui doit précéder l'ouverture de WS-006. `AR` est ajouté au
tableau des préfixes réservés de
[CWRM-STD-002](../research/specifications/CWRM-STD-002-identity-identifier-standard.md) §9 par cet
ADR (type d'objet : *Architecture Review*, 3 chiffres), pour rester cohérent avec la discipline
d'identifiants déjà appliquée au reste du corpus.

**Mise à jour 2026-08-06** — [AR-001](../AR-001-architecture-review.md) est ouvert. Finding-004
(frontière WS-004/WS-005) est `Resolved`. Findings 001-003, identifiés par la revue REV-001, restent
à formaliser.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| [M1-ARCHITECTURE-FOUNDATION.md](../M1-ARCHITECTURE-FOUNDATION.md) | Enregistrement narratif de la même décision — cet ADR en est la version numérotée |
| [ARCH-000](../ARCH-000-architecture-index.md) | Pointera vers cet ADR comme acte de clôture formel de M1 |
| [ARCH-DEBT-REGISTER](../ARCH-DEBT-REGISTER.md) | Source unique des ID ARCH-DEBT-001/002, réutilisés ici sans duplication |
| ADR-0015 → ADR-0018 | Base canonique déclarée stable par cette clôture |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — clôture formelle du jalon M1, réservation de l'identifiant AR-001 pour la revue précédant WS-006 |
