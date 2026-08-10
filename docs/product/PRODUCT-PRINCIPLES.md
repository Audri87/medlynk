# MedLink Product Principles

| Field | Value |
|---|---|
| Status | Living document — grows with each sprint |
| Format | [PRODUCT-PIPELINE-v1.0.md](PRODUCT-PIPELINE-v1.0.md) |
| Governed by | [Product Constitution v1.0](PRODUCT-CONSTITUTION-v1.0.md) · [GOV-000 — MedLink Governance v1.0](../process/GOV-000-medlink-governance-v1.0.md) |

> No principle is added without a referenced Observation, Pattern, or explicit Design Decision.
> A statement without empirical grounding AND without an explicit, labelled founder decision is an
> opinion, not a Product Principle.
>
> Marqueurs — convention gelée par GOV-000, §3. Chaque Principle est une **décision** (`→`) ; son
> **ancrage** est noté séparément : `✓`/`≈` s'il dérive du corpus, `?` s'il n'a aucune ancre (Corpus Gap
> ou décision fondateur type Model C — voir PP-012 à PP-015). `→` ne signifie jamais "validé" ; un `⚠`
> reste attaché tant que le Gate suivant n'a pas confirmé la décision.
>
> A Principle may have exceptions. Those exceptions are documented in the Display Rulebook — not to be
> confused with UX Constraints, which recalibrate a Principle's intensity without changing content.
>
> Every Principle SHALL state its Design Decision explicitly: the choice made, and the alternative
> discarded. A Principle is never the automatic consequence of a Pattern or a Decision — it is a choice.

---

## PP-001 — Signal precedes Horizon

```
Source:     PAT-M-001
            "Tout praticien cherche les changements avant de consulter le planning."
            Corpus: ACT-F009-001, ACT-F009-002 (verbatim) + 7 profils convergents
Principle:  Any Morning Brief layout SHALL display the Signal zone
            before the Horizon zone. No variant SHALL reverse this order.
Scope:      UX layout
            MorningBriefQuery DTO structure: {signals[], horizon[], obligations[]}
            Notification priority: signal alerts preempt calendar items
Compliance: Signals appear as the first scrollable element in Morning Brief.
            MorningBriefQuery DTO returns signals before horizon before obligations.
            No notification system delivers calendar items before unread signals.
```

---

## PP-002 — Preparation follows Uncertainty

```
Source:     PAT-M-002
            "La préparation d'un dossier est déclenchée par l'incertitude,
            pas par le temps écoulé."
            Corpus: ACT-F004-003 (conditionnel), ACT-F007-005, ACT-F001-015 (verbatim)
Principle:  Patient preparation context SHALL be scoped to the practitioner's
            uncertainty, not to a fixed time window or calendar distance.
            A patient seen yesterday SHALL NOT trigger a full context reload.
Scope:      UX — Patient Workspace pre-consultation depth
            Read Model — PatientContextQuery: context-gap scoring, not date comparison
            API — preparation endpoint returns depth based on uncertainty signal
Compliance: Preparation depth is variable, not uniform.
            No Workspace loads a full patient history by default for recently-seen patients.
```

---

## PP-003 — Context reconstruction must be unified

```
Source:     PAT-M-003
            "La reprise de contexte nécessite plusieurs sources d'information."
            Corpus: F001 (Vega + répondeur), F002 (mail + dossiers + questionnaires),
            F009 (téléphone + mail + planning)
Principle:  Morning Brief SHALL consolidate Signal, Horizon, and Obligations
            from all relevant sources into a single entry point.
            No practitioner SHALL need to navigate to a second application
            to complete their morning scan.
Scope:      UX — Morning Brief is the single entry point
            Integration — all signals route through a unified read model
            API — no separate endpoint for signals vs horizon
Compliance: A practitioner completes their morning scan without leaving Morning Brief.
            All signal sources (messages, results, alerts) feed a single MorningBriefQuery.
```

---

## PP-004 — Obligations are secondary, not invisible

```
Source:     OBS-M-005
            "Plusieurs praticiens consacrent une partie du début de journée
            à des tâches non directement liées au soin."
            Corpus: ACT-F001-005, ACT-F001-006, ACT-F001-007
Principle:  Morning Brief SHALL display an Obligations zone distinct from Signal
            and Horizon. Obligations zone SHALL be collapsed by default.
            Obligations SHALL NOT compete visually with Signal or Horizon.
Scope:      UX layout — collapsed state is default
            Information architecture — three zones: Signal / Horizon / Obligations
Compliance: Obligations zone is not visible in Morning Brief default view.
            One interaction reveals the Obligations zone.
            Obligations zone renders below Signal and Horizon when expanded.
```

---

## PP-005 — Surface the relevant recent interaction first

```
Source:     PAT-P-001
            "La dernière consultation est le point d'entrée privilégié
            pour les praticiens en suivi longitudinal."
            Corpus: ACT-F004-004, ACT-F004-005, ACT-F008-008, ACT-F006-008
            Exception documentée: ACT-F005-005 (échographiste — l'ordonnance est primaire)
Principle:  WS-002 SHALL surface the most clinically relevant recent interaction
            as its primary element. What constitutes 'most relevant' is governed
            by Display Rules — it is not always the most recent by date.
Scope:      UX layout — Bloc Continuité is the primary visible element
            PatientContextQuery DTO: primary_interaction before historical_detail
            Display Rules DR-001 to DR-004 define specialty-specific implementations
Compliance: The primary element in WS-002 is the Display Rule-defined entry point,
            not a generic "last modified" timestamp.
            A practitioner does not need to scroll to find their primary entry point.
Statut:     ≈ — dérivée d'un Pattern, pas d'une Observation universelle. À valider.
```

---

## PP-006 — Historical depth follows context gap

```
Source:     PAT-P-003
            "Pour les profils longitudinaux, le récent précède le complet
            dans la séquence de préparation."
            Corpus: PAT-P-002 (familiarité + distance temporelle), ACT-F004-003
Principle:  WS-002 SHALL default to showing recent context only.
            Extended historical detail SHALL be available on demand.
            Display Rules SHALL specify exceptions where historical context
            is the primary preparation source.
Scope:      UX — Bloc Historique collapsed by default (except DR-003 exception)
            PatientContextQuery: context_gap_score governs depth, not fixed window
Compliance: Historical detail is not visible in WS-002 default view for DR-001, DR-002, DR-004.
            DR-003 (échographiste) is the documented exception — historical NOT collapsed.
Statut:     ≈ — dérivée de Patterns, exceptions explicitement documentées. À valider.
```

---

## PP-007 — VOID

```
Proposition originale: "Expose unfinished intentions automatically."
Raison: aucun support corpus direct.
  OBS-P-003 montre que les praticiens CHERCHENT les intentions dans leurs notes.
  Il ne montre pas qu'ils souhaitent une surface automatique.
  OBS-P-005: certains praticiens ne documentent pas (ACT-F001-019) —
  une surface automatique produirait un signal vide interprété à tort comme "rien de prévu."
Reclassé en: OQ-P-003 dans WS-002.
Numéro réservé pour éviter toute confusion de numérotation.
```

---

## PP-008 — Collapse historical detail by default

```
Source:     PAT-P-003
            "Pour les profils longitudinaux, le récent précède le complet."
            Corpus: ACT-F004-003, inference convergente multi-profils
            Exception documentée: ACT-F005-007, ACT-F005-008 (échographiste)
Principle:  Historical detail SHALL be collapsed by default in WS-002.
            One interaction reveals historical content.
            Display Rules SHALL explicitly document any exceptions
            where historical detail is the primary context source.
Scope:      UX — Bloc Historique default state
            Display Rules: DR-003 is the documented exception (historical NOT collapsed)
Compliance: Bloc Historique is not visible in WS-002 default view (except DR-003).
            DR-003 exception is documented in DISPLAY-RULEBOOK.md with corpus justification.
            Any new exception requires corpus anchor — opinion is insufficient.
Statut:     ≈ — dérivée d'un Pattern avec exception profilée. À valider.
```

---

## Display Rules

Les Product Principles sont universels. Les Display Rules les adaptent par profil clinique.
Un Principle peut avoir des exceptions. Ces exceptions sont les Display Rules.

> Voir [DISPLAY-RULEBOOK.md](DISPLAY-RULEBOOK.md) pour la spécification complète.

| DR | Profil | Source PP |
|---|---|---|
| DR-001 | Suivi longitudinal | PP-005, PP-006, PP-008 |
| DR-002 | Suivi grossesse | PP-005, PP-006, PP-008 |
| DR-003 | Acte sur demande (exception PP-008) | PP-005, PP-006 |
| DR-004 | Coordination | PP-005, PP-006, PP-008 |

---

## Registre des identifiants PP-009 et suivants

> **Règle de gel des identifiants.** Une fois assigné, un PP-NNN ne change jamais de sens et n'est
> jamais renuméroté ni réassigné à un autre Workspace. Il peut évoluer (reformulation, précision de
> portée) mais garde son identité — sinon la traçabilité corpus → décision → implémentation se perd.
> La table ci-dessous remplace l'ancienne table "Principes à dériver" (obsolète — elle assignait
> PP-009/010/011 à des Workspaces différents de ceux réellement utilisés).
>
> Spécification complète de chaque Principle : voir le Workspace propriétaire, pas ce registre.

| PP | Workspace propriétaire | Énoncé | Origine (GOV-000 v1.4) | Statut |
|---|---|---|---|---|
| PP-009 | WS-003 — Consultation | Software disappears during care | Founder-Driven | → Décision, evidence ? |
| PP-010 | WS-003 — Consultation | One cognitive focus at a time | Founder-Driven | → Décision, evidence ? |
| PP-011 | WS-003 — Consultation | Interruptions must be recoverable | Founder-Driven | → Décision, evidence ? |
| PP-012 | WS-003 — Consultation | Free text over imposed structure | Founder-Driven (Model C) | → Décision, evidence ? |
| PP-013 | WS-003 — Consultation | Capture during OR after — both paths valid | Founder-Driven (Model C) | → Décision, evidence ≈ (PAT-D-005, WE-004, 7/9 profils) |
| PP-014 | WS-003 — Consultation | Consultation stays open until explicitly closed | Founder-Driven (Model C) | → Décision, evidence **scindée** : ≈ (état ouvert/fermé, PAT-D-002) / ? (mécanisme de rappel, non couvert) |
| PP-015 | WS-003 — Consultation | One-click closure with no content | Founder-Driven (Model C) | → Décision, evidence ? |

Prochain identifiant disponible : **PP-016**.

> **Origine ≠ niveau de preuve** (GOV-000 v1.4 §1bis) : l'Origine décrit comment l'idée est née
> (Evidence-Driven / Discovery-Driven / Constraint-Driven / Founder-Driven), pas sa force actuelle.
> PP-013/014 restent Founder-Driven dans leur origine (Model C) même si leur evidence a été renforcée
> a posteriori par WE-004 — l'historique ne se réécrit pas.
>
> PP-013 et PP-014 mis à jour le 2026-08-04 — voir [WE-004](workspaces/WE-004-documentation.md) et
> [PDR-004](workspaces/PDR-004-documentation.md) EV-401 (evidence de PP-014 corrigée/scindée suite à
> audit critique le même jour). La frontière WS-003/WS-004 est **RESOLVED** depuis — voir
> [WBD-004](workspaces/WBD-004-consultation-vs-documentation.md) v2.0 : WS-003 capture (déjà couvert
> ci-dessus, PP-009 à 015 inchangés), WS-004 préserve/persiste (nom provisoire — "Clinical Memory"
> écarté pour collision avec le concept Care Record de CLAUDE.md). Le circuit Product Discovery (PDX)
> explore par ailleurs une piste scindée entre les deux Workspaces — voir
> [PDX-001](discovery/PDX-001-capture-clinique-assistee.md).
