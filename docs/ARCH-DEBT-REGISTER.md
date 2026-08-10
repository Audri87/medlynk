# ARCH-DEBT — Architecture Debt Register

**Version :** 1.1
**Statut :** Accepted
**Date :** 2026-08-06
**Gouvernance :** Les items listés ici sont explicitement exclus du périmètre de M1 (voir
[M1-ARCHITECTURE-FOUNDATION](M1-ARCHITECTURE-FOUNDATION.md)). Ce n'est pas une liste de bugs — c'est
un registre de dette architecturale connue, avec statut de suivi, sur le modèle de
[ADB-001](architecture/ADB-001-domain-events-backlog.md). Toute décision fermant un item doit être
formalisée (ADR ou mise à jour d'un document existant), puis l'item marqué `Resolved` avec référence.

---

## Statuts possibles

| Statut | Signification |
|---|---|
| `Open` | Question identifiée, non encore analysée |
| `Under Review` | Discussion ouverte, options en cours d'évaluation |
| `Decided` | Décision prise, ADR ou mise à jour documentaire en cours |
| `Resolved` | ADR ou document mis à jour — item fermé |
| `Deferred` | Question reportée délibérément, hors périmètre actuel |

---

## ARCH-DEBT-001 — Frontière WE ↔ PDR déjà franchie en pratique

**Statut :** `Deferred` — exclu de M1 ([ADR-0019](adr/ADR-0019-close-milestone-m1.md))
**Impact :** Moyen
**Origine :** Critique Q2.2, revue d'architecture M1 (2026-08-06)

**Constat.** [PDR-004](product/workspaces/PDR-004-documentation.md) §Audit documente lui-même le
renvoi d'un contenu initialement rédigé côté PDR (`DD-403`) vers WE-004 (`HYP-D-001`), au motif qu'il
ne s'agissait pas réellement d'une décision. [GOV-000](process/GOV-000-medlink-governance-v1.0.md)
§2 déclare pourtant explicitement qu'*"une couche ne produit pas les artefacts d'une autre."*

**Impact si non traité.** Rien ne garantit aujourd'hui que ce type de bascule reste rare ou
détectable a priori — le seul précédent disponible dans le corpus montre justement l'inverse.

**Bloque :** Rien à ce jour — non bloquant pour M1.

**Traitement proposé (non engagé).** Un futur ADR pourrait clarifier le critère exact distinguant
"hypothèse non décidée" (→ WE) de "décision" (→ PDR), pour qu'un rédacteur tranche a priori plutôt
qu'après coup.

---

## ARCH-DEBT-002 — Module Workspace historiquement présent en Domain

**Statut :** `Deferred` — exclu de M1 ([ADR-0019](adr/ADR-0019-close-milestone-m1.md))
**Impact :** Faible
**Origine :** Critique Q4.2, revue d'architecture M1 (2026-08-06)

**Constat.** `git status` montre la suppression non commitée de `src/Workspace/Domain/.gitkeep`,
`src/Workspace/Application/Workspace.php` et `WorkspaceAssembler.php` — une violation passée de
CLAUDE.md (*"Workspace = Projection… never manually build"*) et de GOV-000 §1ter-a. Le module
équivalent existe désormais légitimement en `Application/ReadModel` côté
`src/Platforms/Clinical/`.

**Impact si non traité.** La suppression reste un état de travail non garanti tant qu'elle n'est pas
commitée ; un rebase ou un stash mal géré pourrait la faire disparaître silencieusement sans laisser
de trace de la correction.

**Bloque :** Rien à ce jour — non bloquant pour M1 (le code n'entre pas dans le périmètre de cette
revue documentaire).

**Traitement proposé (non engagé).** Commit explicite de la suppression, avec référence à cet item
dans le message de commit.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — ouverture d'ARCH-DEBT-001 et ARCH-DEBT-002, suite au sign-off M1 |
| 2026-08-06 | 1.1 | Ajout de la colonne Impact (Moyen / Faible) et renvoi vers [ADR-0019](adr/ADR-0019-close-milestone-m1.md), qui formalise la clôture M1 dans la série ADR |
