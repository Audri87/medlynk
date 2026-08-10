# M1 — Architecture Foundation

**Statut :** Accepted
**Date :** 2026-08-06
**Jalon :** M1 — Architecture Freeze (Foundation)
**Périmètre :** séparation Discovery / Product / Domain · Clinical Loop WS-001 → WS-006 · pipeline
Product Discovery · `Responsibility → Product Question → Workspace` (statut **Experimental**, voir
[ADR-0016](adr/ADR-0016-status-of-experimental-concepts.md)) · Domain indépendant.

---

> **Architecture Foundation accepted.**
>
> Les écarts ARCH-DEBT-001 et ARCH-DEBT-002 sont connus, documentés et explicitement exclus du
> périmètre de M1. Leur traitement est reporté à un sprint de consolidation ultérieur.

Cette décision est également enregistrée, sous forme numérotée, dans
[ADR-0019 — Clôture du Jalon M1](adr/ADR-0019-close-milestone-m1.md). Les deux documents portent la
même décision ; en cas de divergence future, ADR-0019 fait foi (série ADR versionnée).

---

## Ce qui a été vérifié avant signature

1. **Revue d'architecture adversariale** (2026-08-06) — 5 critiques initiales + 4 questions ciblées
   (Clinical Loop, minimalité du pipeline, dépendance circulaire, frontières Domain/Product), chaque
   constat démontré avec preuve, gravité et remise en cause explicite.
2. **Sprint M1.1 — Consolidation** — [ADR-0015](adr/ADR-0015-canonical-discovery-pipeline.md) à
   [ADR-0018](adr/ADR-0018-evidence-traceability.md), plus édits directs sur
   [WBD-004](product/workspaces/WBD-004-consultation-vs-documentation.md),
   [WS-003](product/workspaces/WS-003-consultation.md) §11 et
   [GOV-000](process/GOV-000-medlink-governance-v1.0.md) (v1.7).
3. **[ARCH-000](ARCH-000-architecture-index.md)** publié — table des matières de l'architecture,
   aucune règle propre.
4. **[ARCH-DEBT-REGISTER](ARCH-DEBT-REGISTER.md)** ouvert — 2 items, statut `Deferred`, non
   bloquants par déclaration explicite ci-dessus.

## Ce que "M1 accepted" signifie — et ne signifie pas

**Signifie :** la chaîne canonique de Product Discovery, le statut de chaque concept, la sémantique
du gel (Accepted/Experimental/Frozen) et les règles de traçabilité de la preuve sont désormais
explicites et uniques — plus aucune version contradictoire ne coexiste sans arbitrage.

**Ne signifie pas :**
- que ARCH-DEBT-001 et ARCH-DEBT-002 sont résolus — ils sont `Deferred`, pas `Resolved` ;
- que `Cognitive Responsibility` / *Clinical Coordination* sont validées — leur statut reste
  **Experimental** ([ADR-0016](adr/ADR-0016-status-of-experimental-concepts.md)), leur test se
  poursuit sur WS-005 **et** WS-006 (GOV-000 §1ter-b, v1.6) ;
- que WE-005 est conforme — il reste `Draft — non conforme`
  ([ADR-0018](adr/ADR-0018-evidence-traceability.md)) ;
- qu'aucune nouvelle dette ne peut apparaître — seulement que celle connue à cette date est tracée,
  pas masquée.

## Dette explicitement exclue du périmètre

| ID | Résumé | Détail |
|---|---|---|
| ARCH-DEBT-001 | Frontière WE ↔ PDR déjà franchie une fois en pratique (PDR-004 §Audit) | [Registre](ARCH-DEBT-REGISTER.md#arch-debt-001--frontière-we--pdr-déjà-franchie-en-pratique) |
| ARCH-DEBT-002 | Module `Workspace` historiquement présent en `Domain`, suppression non commitée | [Registre](ARCH-DEBT-REGISTER.md#arch-debt-002--module-workspace-historiquement-présent-en-domain) |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Signature M1 — Architecture Foundation accepted, avec exclusions explicites ARCH-DEBT-001/002 |
