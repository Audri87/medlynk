# AR-001 — Architecture Review (pré-ouverture WS-006)

**Statut :** In Progress
**Date d'ouverture :** 2026-08-06
**Identifiant réservé par :** [ADR-0019](adr/ADR-0019-close-milestone-m1.md)
**Condition posée par ADR-0019 :** l'ouverture de WS-006 est précédée par cette revue.
**Méthode :** [REV-001](#) — protocole de revue scientifique indépendante appliqué à l'architecture
consolidée post-M1 (session du 2026-08-06, non encore fichier séparé).

---

## Objet

Ce document recense les *Findings* de la revue d'architecture exigée avant l'ouverture de WS-006. Un
Finding devient `Resolved` quand une action est décidée et exécutée ; il reste `Open` sinon. Aucun
Finding ne bloque, à lui seul, l'ouverture de WS-006, sauf mention explicite.

---

## Findings

### Finding-004 — La définition de WS-004 empiète sur le mandat de WS-005

**Statut :** `Resolved`
**Origine :** REV-001 §4/§8/§9 (hypothèse de fusion WS-004/WS-005), testée contre le corpus à la
demande explicite du Product Owner.

**Observation du reviewer.** La définition de WS-004 dans WBD-004 v2.0 incluait *"pour soi-même et
pour d'autres"* — un mandat qui recouvre celui de WS-005.

**Preuve corpus.**
- ACT-F002-019 (finaliser les notes) / ACT-F002-021 (envoyer un compte rendu, **conditionnel**) —
  deux ACT distincts et séquentiels.
- ACT-F005-013 (finaliser le compte rendu) / ACT-F005-016 (envoyer au prescripteur) — idem.
- ACT-F009-025 (remplir la grille de suivi) / ACT-F009-026 (préparer le résumé au prescripteur) — idem.
- ACT-F004 (profil entier, 17 ACT, psychologue) — construction de mémoire durable exercée sans aucun
  acte de transmission documenté (absence, evidence plus faible que les trois exemples ci-dessus).

**Conclusion.** Le corpus ne soutient pas la formulation actuelle. Il soutient l'inverse : deux
transformations cognitives distinctes, dont l'une (transmission) est conditionnelle et jamais fondue
avec l'autre.

**Action exécutée.** Correction documentaire uniquement — retrait de *"et pour d'autres"* du mandat de
WS-004 dans [WBD-004](product/workspaces/WBD-004-consultation-vs-documentation.md) v2.1.
OQ-WBD-004-1 et OQ-WBD-004-4 marquées résolues. **Aucune modification du noyau, du Domain, ni d'un
Workspace existant — correction du texte qui les décrit.**

**Effet secondaire positif.** Réduit (sans l'éliminer) le risque de dépendance circulaire WS-002 ↔
WS-005 signalé en Critique 3/Q3 (revue d'architecture M1) : WS-005 lit désormais une mémoire dont le
mandat est explicitement borné, plutôt qu'un mandat partagé et ambigu avec WS-004.

**Corroboration indépendante.** [AR-001B](AR-001B-empirical-audit-ws005.md) reproduit la même
dissociation (T4/T5) par une méthode de clustering aveugle, sans connaissance de WS-004/WS-005 au
moment de l'analyse. Un seul corpus, une seule reproduction — ne suffit pas à généraliser, mais
renforce la confiance dans ce Finding au-delà de son évidence initiale.

---

### Finding-005 — Empirical Corroboration of the WS-005 Mandate

**Statut :** `Resolved` (en tant que constat) — **ne préjuge d'aucune décision d'architecture**
**Origine :** Application stricte de [CWRM-EXP-001](research/specifications/CWRM-EXP-001-state-transition-analysis.md)
§8 aux quatre composantes du mandat de WS-005 tel qu'énoncé dans
[WBD-004](product/workspaces/WBD-004-consultation-vs-documentation.md) v2.1 (*"transmission, avis,
délégation, reprise de patient"*).

> **Périmètre explicite.** Ce Finding ne remet pas en cause l'architecture. Il ne recommande ni de
> réduire, ni de conserver le mandat de WS-005. Il constate un fait unique : l'écart entre le mandat
> tel que déclaré et le niveau réel de corroboration empirique de chacune de ses composantes,
> mesuré par un protocole appliqué identiquement aux quatre. La décision d'architecture qui en
> découle éventuellement n'est pas prise ici — voir §Suites.

**Résultat de l'audit (CWRM-EXP-001 §8, cinq critères appliqués indépendamment) :**

| Composante du mandat | Sources indépendantes | Verbatim direct | Verdict |
|---|---|---|---|
| Transmission | 5 profils (F002, F005, F007, F008, F009) | Oui | **Evidence** |
| Avis | 0 profil — recherche exhaustive sur les 9 transcripts bruts | — | **Unsupported** |
| Délégation | 1 profil (F009) | Non (synthèse rapportée uniquement) | **Observation** |
| Reprise de patient | 4 profils (F002, F004, F008, F009) | Oui | **Evidence — mais recouvre intégralement T2, déjà `Stable`** ; CWRM-EXP-001 ne peut pas statuer sur l'appartenance à WS-005 (hors périmètre, §12 du protocole) |

**Conclusion du Finding (strictement constatative).** Sur les quatre composantes déclarées, une seule
(Transmission) atteint le niveau de corroboration `Evidence` sans réserve. Une (Avis) n'a aucun
support empirique. Une (Délégation) a un support partiel, insuffisant pour la stabilité. Une (Reprise
de patient) est fortement evidencée, mais pour une transformation déjà rattachée ailleurs (T2), pas
pour une transformation propre à WS-005.

**Action exécutée.** Documentation de l'écart, uniquement. **Aucune modification de WBD-004, d'aucun
Workspace, ni d'aucun ADR.**

---

### Suites — ADR-0020 (identifiant réservé, non rédigé)

`ADR-0020` est réservé pour la question d'architecture que Finding-005 rend visible sans la trancher :

> Faut-il réduire le mandat de WS-005 à la seule transformation aujourd'hui corroborée (Transmission),
> ou conserver les responsabilités encore non corroborées (Avis, Délégation, Reprise de patient) comme
> hypothèses architecturales explicites ?

Cet ADR n'est pas rédigé dans ce tour. L'ordre est délibéré : documenter le constat empirique
(Finding-005) avant de statuer sur ses conséquences d'architecture (ADR-0020) — même discipline que
celle qui a produit AR-001B avant CWRM-EXP-001, appliquée cette fois dans le bon sens dès le départ.

---

### Findings 001 à 003 — non encore formalisés

REV-001 a identifié trois autres `MAJOR ISSUE` qui n'ont pas encore reçu de Finding numéroté dans ce
document, faute de décision explicite du Product Owner sur l'action à mener :

| Correspondance provisoire | Origine REV-001 | Résumé |
|---|---|---|
| *Finding-001 (à confirmer)* | §1/§2 | PAT n'a aucune Gate formelle ; CWRM-030 (Coding Manual) n'existe pas |
| *Finding-002 (à confirmer)* | §6 | CONSTITUTION.md / Mission généralisent au-delà de la portée soutenue par CWRM-001 (ambulatoire/libéral uniquement) |
| *Finding-003 (à confirmer)* | §8 | Frontière WS-006 → WS-001 (jour suivant) non spécifiée |

Ces items ne sont pas perdus — ils restent dans REV-001. Ils ne deviennent des Finding-00X de ce
document que sur décision explicite, pour ne pas préjuger d'une action avant que le Product Owner ne
l'ait validée.

---

## Condition de clôture

AR-001 peut être clos, et WS-006 ouvert, quand chaque Finding listé est `Resolved` ou explicitement
accepté comme `Deferred` (avec entrée dans [ARCH-DEBT-REGISTER](ARCH-DEBT-REGISTER.md) si pertinent).

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Ouverture — Finding-004 résolu ; Findings 001-003 identifiés mais non formalisés |
| 2026-08-06 | 1.1 | Finding-005 ajouté (corroboration empirique du mandat WS-005, constat pur, aucune décision d'architecture) ; ADR-0020 réservé pour la question d'architecture qui en découle |
