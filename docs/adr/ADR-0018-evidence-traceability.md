# ADR-0018 — Traçabilité de l'Evidence (Confidence, Ancrage ACT/OBS)

**Statut** : Accepted
**Date** : 2026-08-06
**Sprint** : M1.1 — Consolidation (priorité 2)
**Répond à** : Critique 3 de la revue d'architecture M1

---

## Contexte

Ce sont des règles de forme — elles n'introduisent aucun nouveau concept, elles uniformisent
l'usage de concepts déjà `Stable` (ACT, OBS, PAT) au sens d'ADR-0016.

GOV-000 §3 (v1.1, déjà gelée) exige un format de confiance obligatoire pour tout Pattern :
`PAT-X-NNN — ≈ HIGH — Confidence N/M (pourcentage)`. WE-004 le respecte systématiquement. WE-005,
produit plus récemment, ne le respecte pas : ses cinq PAT-005-001 à 005 n'affichent ni symbole `≈`,
ni seuil HIGH/MEDIUM/LOW, ni fraction. Sa section Observations n'attribue aucun identifiant
`OBS-005-NNN` individuel, contrairement à WE-004 qui ancre chaque observation à un `ACT-Fxxx-NNN`
précis.

---

## Décision

### Règle 1 — Confiance obligatoire pour tout PAT

Tout `PAT-X-NNN` affiche, sans exception, sa confiance au format `≈ [HIGH|MEDIUM|LOW] — Confidence
N/M (pourcentage)`, conformément à GOV-000 §3. Un WE contenant un PAT sans confiance affichée ne
peut pas être promu au-delà du statut `Draft`.

### Règle 2 — Un PAT cite les OBS qu'il agrège

Tout `PAT-X-NNN` cite explicitement l'identifiant de chaque `OBS-X-NNN` qu'il synthétise. Un saut
direct d'une liste de constats en prose à un PAT numéroté, sans identifiants OBS intermédiaires
vérifiables, n'est pas conforme.

### Règle 3 — Un OBS cite son ancrage ACT

Tout `OBS-X-NNN` cite l'identifiant `ACT-Fxxx-NNN` dont il dérive, ou le marqueur explicite
`[SYNTHÈSE RAPPORTÉE]` en l'absence de verbatim direct (convention déjà en vigueur dans
`docs/research/act/`).

### Règle 4 — Checklist de conformité avant promotion d'un WE

Un Workspace Evidence ne peut passer de `Draft` à un statut supérieur que si :
- [ ] Chaque PAT affiche sa confiance (Règle 1)
- [ ] Chaque PAT cite ses OBS sources (Règle 2)
- [ ] Chaque OBS cite son ancrage ACT ou porte le marqueur SYNTHÈSE RAPPORTÉE (Règle 3)

---

## Non-conformité constatée (2026-08-06)

**WE-005** ne satisfait aucune des trois règles ci-dessus : PAT-005-001 à 005 sans confiance, sans
citation d'OBS, et §3 ("Observations synthétiques") sans identifiants OBS-005-NNN individuels. Son
statut reste `1.0-draft` — cet ADR ne le corrige pas rétroactivement (aucune donnée de confiance
n'est disponible pour l'inventer sans se substituer à une analyse réelle du corpus). La correction
relève du recodage Mode A déjà recommandé par
[CWRM-020-APX-WS005](../research/specifications/CWRM-020-APX-WS005-coordination-guide.md) §3.

---

## Conséquences

**Pour WE-005** — Reste `Draft — non conforme ADR-0018` jusqu'à ce qu'un recodage produise les
identifiants OBS-005-NNN et les confidences manquantes. Ses recommandations (§9) restent valables en
tant que signal, mais ne peuvent pas fonder un PDR tant que la checklist n'est pas satisfaite.

**Pour tout futur WE** — La Règle 4 devient une condition de Gate 1 (GOV-000 §4), en complément de
*"OBS consolidées"* et *"PAT identifiés"*, qui étaient déjà nommés mais non vérifiables faute de
checklist.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| GOV-000 §3 | Règle de confiance déjà gelée ; cet ADR la rend vérifiable via une checklist |
| GOV-000 §4 Gate 1 | La Règle 4 complète les conditions de Gate 1 |
| WE-004 | Référence de conformité — respecte déjà les trois règles |
| WE-005 | Non conforme — statut documenté explicitement, non corrigé par cet ADR |
| ADR-0016 | OBS et PAT y sont respectivement Stable et Experimental ; cet ADR uniformise leur usage sans changer leur statut |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — Sprint M1.1, réponse à la Critique 3 de la revue d'architecture M1 |
