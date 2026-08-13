# WS-003 — Synthèse M2 (Product Discovery / Product Design)

**Source unique :** [WS-003-consultation.md](WS-003-consultation.md) v2.5 (Blueprint). Aucun contenu
n'est ajouté ici qui ne soit déjà écrit dans cette source ou dans les documents qu'elle cite
explicitement.

> **Relation avec ADR-0022.** Ce document ne compte pas comme une entrée du gel M2
> ([ADR-0022](../../adr/ADR-0022-m2-freeze-protocol.md)) — WS-003 en est explicitement exclu (déjà
> Gold Standard, construit avant que M2 n'existe). C'est une synthèse préparatoire à la conception UX,
> pas une construction sous protocole M2.

---

## 1. Identité du Workspace

| Champ | Valeur |
|---|---|
| ID | WS-003 |
| Nom actuel | Consultation |
| Question produit | **Q-003 — Puis-je consacrer toute mon attention au patient — et clore proprement quand c'est terminé ?** |
| Objectif | *"Protéger l'attention du praticien pendant la consultation, et rendre sa fermeture triviale une fois le patient parti."* (§12) |
| Statut établi | **Discovery Blueprint — Corpus Partial.** Pas encore Prototype. Le volet "pendant" reste dominé par des hypothèses ; le volet "après" (Model C) est décidé mais non challengé empiriquement — les deux statuts *"ne doivent jamais être fusionnés dans la communication produit"* (§15, verbatim du Blueprint) |

---

## 2. Evidence M1

| ID | Source exacte | Observation / Décision | Ce que cela démontre | Ce que cela ne démontre pas |
|---|---|---|---|---|
| OBS-W-001 | ACT-F001-019 | Le kinésithérapeute ne prend pas de notes pendant sa séance | Un comportement de non-documentation, **en séance de kinésithérapie** | Rien sur le comportement en consultation médecin-patient — scope différent, explicitement noté dans le Blueprint |
| OBS-W-002 | ACT-F009-027 | L'infirmière coordinatrice est régulièrement interrompue pendant son travail | L'interruption existe **dans le travail de coordination** | Rien sur l'interruption pendant une consultation en cours |
| GAP-W-001 | Absence documentée | Aucun ACT n'observe directement le déroulement d'une consultation (écoute, dialogue, capture temps réel) | — | PAT-W-001/002/003 et PP-009/010/011 restent non confirmés pour le volet "pendant" |
| GAP-W-002 | Absence documentée | Aucun ACT ne mesure un coût cognitif de reprise après interruption | — | HYP-W-003 et PP-011 restent qualitatifs, non quantifiés |
| GAP-W-003 | Absence documentée | Aucun ACT ne documente la phase de clôture (décision de fermer, contenu de la note) | — | PP-012 à PP-015 (Model C) ne sont ni corroborés ni infirmés |
| PAT-W-001 | Inférence — OBS-W-001 extrapolé + F002, F004 | Les profils relationnels ne documentent pas pendant la séance | Une inférence plausible | Ce n'est pas une observation directe — construit sur du hors-scope |
| PAT-W-002 | Inférence — OBS-W-002 + absence d'outil de recovery observé | La reprise après interruption est une compétence clinique non assistée aujourd'hui | Une inférence plausible | Idem — pas une observation directe |
| PAT-W-003 | Inférence — F004 (absent) vs F005 (central) | L'écran est absent ou central selon le type d'acte | Une inférence à partir de deux cas contrastés | Ne couvre pas les profils non testés |
| DEC-W-001 à W-004 | Model C, hors corpus | Texte libre / capture pendant ou après / état ouvert-fermé / clôture 1-clic | Une décision fondateur assumée | **Aucune preuve corpus** — evidence explicitement `?` à l'origine |
| PP-013 | PAT-D-005, WE-004, PDR-004 EV-401 | Capture pendant OU après, les deux valides | 7/9 profils convergents — evidence renforcée `≈` | Ne prouve pas que les deux chemins sont perçus comme équivalents par le praticien |
| PP-014 | PAT-D-002, WE-004 (état) ; Model C seul (rappels) | État ouvert/fermé explicite | L'état ouvert/fermé lui-même, `≈`, 7/9 profils | Le **mécanisme des deux rappels** n'a aucun ancrage — evidence `?`, scindé explicitement après audit (PDR-004) |

**Aucun autre élément du corpus M1 ne concerne WS-003.** Tout le reste de ce qui suit (§3 à §6) est soit
une décision fondateur (Model C / Mission), soit une hypothèse — jamais une observation.

---

## 3. Activité du praticien

**Non établi dans le corpus, pour la quasi-totalité du déroulement pendant la consultation** — GAP-W-001
le dit explicitement : aucun ACT n'observe l'écoute, le dialogue, ou la capture en temps réel.

| Élément demandé | Statut |
|---|---|
| Déclencheur (entrée en consultation) | **Non établi** — PP-014 suppose une ouverture explicite, evidence `?` sur ce point précis |
| Préparation | Hors du périmètre de WS-003 — traité par WS-002 (déjà synthétisé séparément) |
| Compréhension pendant l'acte | **Non établi dans le corpus** — DE-P-001/DE-P-002 (Domain Engineering Charter) posent que le raisonnement clinique est **hors du domaine logiciel** ; ce n'est pas une découverte du corpus, c'est une règle de gouvernance qui explique pourquoi WS-003 ne cherche pas à l'observer |
| Actions / décisions pendant l'acte | **Non établi** — GAP-W-001 |
| Observations / capture d'information | **Non établi** pour le "pendant" — seule la structure de Mode Capture est décrite, comme décision (§9), pas comme observation |
| Alternances ou boucles | **Hypothèse — à tester.** Le Blueprint décrit *"Observer ⇄ Raisonner ⇄ Observer ⇄ Capturer…"* (§6) mais ce schéma n'est adossé à **aucun ACT cité** — c'est une supposition de travail, cohérente avec DE-P-001/002, pas une observation |
| Sortie de l'activité (clôture) | **Décidé (Model C), non corroboré par le corpus** sauf sur deux points précis : l'état ouvert/fermé lui-même (`≈`, PP-014) et l'existence des deux chemins de capture (`≈`, PP-013). Le reste du mécanisme de clôture — contenu exact, déclencheur perçu, légitimité du "rien à signaler" — reste `?` |

---

## 4. Contraintes produit

**Contraintes établies** (traçables à une règle du projet, pas une hypothèse produit) :

- Le raisonnement clinique est hors du domaine logiciel (DE-P-001, DE-P-002) — WS-003 n'a pas vocation
  à modéliser le cycle interne d'observation/raisonnement.
- *"Never build a God Object"* (principe MedLink cité §11) — WS-003 ne porte pas la liste des
  consultations non fermées, ni le planning ; ce sont d'autres Workspaces qui les portent.
- Cognitive Contract (§2) — quatre garanties **décidées**, pas observées : pas d'information sans
  action explicite pendant l'écoute ; état retrouvable en une action après interruption ; aucune
  consultation n'exige d'être documentée pour être fermée ; la fermeture d'une consultation ne bloque
  jamais l'ouverture de la suivante.

**Hypothèses M2 :**

- PP-009 (software disparaît pendant le soin) — `? Hypothèse`, Founder-Driven, contredite en l'état
  par un cas déjà connu (HYP-W-004 : *"contredit par F005, échographiste"*).
- PP-010 (un seul focus cognitif) — `? Hypothèse`, aucun corpus, Mission uniquement.
- PP-011 (interruptions récupérables) — `? Hypothèse`, fondée sur un indice hors-scope (OBS-W-002),
  pas une observation directe.
- PP-012, PP-015 — décidées (Model C), evidence `?`.
- PP-013 — décidée, evidence `≈` (7/9 profils).
- PP-014 — décidée, evidence scindée : `≈` pour l'état ouvert/fermé, `?` pour le mécanisme de rappel.

---

## 5. Traduction produit actuelle

| Proposition | Origine | Justification | Statut |
|---|---|---|---|
| Mode Présence (écran minimal, 3 actions icône) | PP-009, PP-010 | Mission + Pattern partiel (PAT-W-003) | `Hypothèse — à tester` |
| Mode Capture (saisie rapide, retour auto) | PP-012, PP-013 | Model C + PAT-D-005/WE-004 | Partiellement `evidence ≈` (l'existence du chemin), le reste `Hypothèse — à tester` (latence <3s, HYP-W-005) |
| Mode Lookup (plein écran, un bouton retour) | PP-010 | Mission uniquement | `Hypothèse — à tester` |
| Mode Interruption / Recovery | PP-011 | Indice hors-scope (OBS-W-002) + absence d'outil observée | `Hypothèse — à tester`, risque `High` (HYP-W-003) |
| Mode Clôture (note libre pré-remplie, actions optionnelles, "rien à signaler") | DEC-W-001 à 004 (Model C) | Hors corpus | `Décidé` (→), evidence `?` sauf état ouvert/fermé (`≈`) |
| DR-006 — Échographiste, écran central | Inférence F004 vs F005 | Exception à PP-009 | `Hypothèse — à tester`, non validée (Evidence Quality Summary le dit explicitement) |
| ex-DR-005/007/008 — curseur minimal↔continu par profil | Inférence par profil | Calibration de PP-009/010, pas un contenu différent | `Hypothèse — à tester` (OQ-W-006 ouverte) |

**Aucune de ces propositions n'est améliorée ici — elles sont listées telles qu'elles existent dans le
Blueprint.**

---

## 6. UX — découvertes actuelles

**Vérification demandée sur l'architecture "noyau + widgets" découverte pendant WS-002 : elle ne
s'applique pas ici, et ce n'est pas une supposition de ma part — le Blueprint le dit explicitement :**

> *"L'architecture d'information de WS-003 est une architecture de **modes**, pas de blocs."* (§9)

WS-003 utilise une machine à six états (Présence, Capture, Lookup, Interruption, Recovery, Clôture),
pas une composition de widgets métier. C'est une décision (Founder-Driven), pas une découverte
empirique — au même titre que le reste du volet "pendant."

> **Ratifié explicitement le 2026-08-06.** Le modèle noyau + widgets adaptatifs découvert sur WS-002
> n'est pas transposé à WS-003. Chaque Workspace vérifie indépendamment si son architecture
> d'interface est justifiée par son propre corpus/Blueprint — ce n'est jamais un héritage automatique
> d'un autre Workspace. Voir [M2-JOURNAL-observations](../M2-JOURNAL-observations.md) OBS-M2-003.

Aucune découverte UX supplémentaire, au-delà de ce qui est déjà listé en §5, n'est suffisamment
étayée pour être documentée ici. Aucun widget n'est fabriqué au-delà de ce que le Blueprint décrit
déjà.

---

## 7. Questions encore ouvertes

Reprises de §14 du Blueprint, priorisées sur leur capacité à modifier fortement la conception :

| # | Question | Impact si la réponse diffère de l'hypothèse actuelle |
|---|---|---|
| OQ-W-006 | PP-009 s'applique-t-il uniformément, ou varie-t-il par profil ? | **Fort** — pourrait transformer un Principle universel en plusieurs Display Rules réelles, pas de simples UX Constraints |
| OQ-W-001 | Quelle information minimale suffit en Mode Présence ? | **Fort** — définit directement le contenu de l'écran par défaut |
| OQ-W-012 | L'ouverture d'une consultation est-elle toujours explicite, ou déductible du planning ? | **Fort** — change le déclencheur de tout PP-014 |
| OQ-W-009 | La note libre (PP-012) nécessite-t-elle un format minimal pour conformité légale ? | **Fort** — pourrait contraindre le modèle de données, pas seulement l'UX |
| OQ-W-004 | Durée réelle de désynchronisation après interruption ? | Moyen — calibre PP-011 sans remettre en cause son existence |
| OQ-W-007 | Capture utile en moins de 3 secondes ? (HYP-W-005) | Moyen — calibre Mode Capture |
| OQ-W-002 | Saisie vocale acceptable en consultation ? | Suivi séparément — [PDX-001](../discovery/PDX-001-capture-clinique-assistee.md), le corpus ne peut pas trancher une modalité qu'il n'a jamais observée |
| OQ-W-003, 005, 008, 010, 011 | Voir §14 du Blueprint | Impact moindre ou hors périmètre direct de la conception initiale |

---

## 8. Décisions provisoires

Le Blueprint lui-même les qualifie de décidées, indépendamment du statut Discovery du volet "pendant"
(§7, Definition of Done : *"Le volet Model C ne bloque pas cette transition"*) :

- La note de consultation est en texte libre — aucune structure imposée (PP-012).
- La capture peut se faire pendant ou après la consultation — les deux chemins restent valides
  (PP-013, evidence `≈`).
- Une consultation reste explicitement "ouverte" tant qu'elle n'a pas été fermée (PP-014, état
  evidence `≈`).
- Une consultation peut être fermée en un clic, sans contenu (PP-015).
- WS-003 ne rend pas lui-même les rappels de fin de journée ni le contexte du patient suivant — ce
  sont WS-002, WS-004, WS-006 qui les portent (§11).

---

## 9. Ce qui doit rester ouvert

- **Tout le volet "pendant"** (PP-009, 010, 011) — zéro ancrage corpus direct, un contre-exemple déjà
  identifié (HYP-W-004, F005) contre l'application universelle de PP-009. Ne pas figer le contenu
  exact de Mode Présence avant OQ-W-001 et OQ-W-006.
- **Le mécanisme des rappels de PP-014** — evidence `?`, jamais scindé de l'état ouvert/fermé avant
  l'audit du 2026-08-04 ; rester prudent sur toute UI qui présupposerait un mécanisme précis de
  rappel avant OQ-W-011/012.
- **La question du curseur par profil (ex-DR-005/007/008)** — trois lignes non validées, un seul
  cas contrasté (F004 vs F005) derrière PAT-W-003.
- **Le volet "pendant" dans son ensemble (PP-009/010/011) et la dynamique non linéaire
  (§3)** — restent explicitement des hypothèses à éprouver, pas des décisions à figer. Confirmé le
  2026-08-06.
- **Toute application de l'architecture "widget/composition"** découverte sur WS-002 — le Blueprint
  l'exclut explicitement aujourd'hui, et cette exclusion est désormais confirmée comme décision
  (non transposée), tout en restant elle-même non testée contre le terrain.

---

## 10. Résumé opérationnel

- **Nous savons :** deux comportements hors-scope (kiné, coordination) existent dans le corpus, mais
  aucun n'observe directement une consultation. La différence écran-absent/écran-central entre F004
  et F005 est réelle et documentée.
- **Nous supposons :** que le logiciel doit s'effacer pendant l'écoute (PP-009/010/011), que la
  clôture doit être rapide et sans contrainte (PP-012 à 015) — décidé, pas prouvé, sauf pour
  l'existence des deux chemins de capture et l'état ouvert/fermé (`≈`).
- **Nous allons construire :** les six modes déjà spécifiés (§9 du Blueprint), sur une architecture
  de machine à états, pas de blocs composables.
- **Nous devons tester :** en priorité OQ-W-006 (universalité de PP-009), OQ-W-001 (contenu minimal
  de Mode Présence), OQ-W-012 (déclenchement de l'ouverture) — ce sont les trois questions dont la
  réponse changerait le plus la conception.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Synthèse initiale, entièrement dérivée de WS-003-consultation.md v2.5 — aucun contenu ajouté |
