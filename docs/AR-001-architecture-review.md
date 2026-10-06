# AR-001 — Architecture Review (pré-ouverture WS-006)

**Statut :** `Closed` — Findings formally classified and dispositioned (2026-10-05).
**Date d'ouverture :** 2026-08-06
**Date de clôture :** 2026-10-05
**Identifiant réservé par :** [ADR-0019](adr/ADR-0019-close-milestone-m1.md)
**Condition posée par ADR-0019 :** l'ouverture de WS-006 est précédée par cette revue. **Non respectée
dans l'ordre prévu** — voir §Note de séquence ci-dessous, conservée pour mémoire, non corrigée
rétroactivement.
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

### Finding-002 — Mission scope vs evidence scope

**Statut :** `Resolved` — décision prise, aucune modification de `CLAUDE.md`.
**Origine :** REV-001 §6 — la Mission de MedLink (`CLAUDE.md`) généraliserait au-delà de la portée
réellement soutenue par `CWRM-001`.

**Constat : confirmé.**

La Mission de MedLink est formulée à un niveau général et ne limite pas explicitement son ambition au
contexte libéral ou ambulatoire — *"MedLink is a platform that organizes the work of healthcare
actors"*, *"réduire l'effort cognitif [...] afin que les praticiens [...]"* : aucune restriction de
cadre d'exercice nulle part dans le document.

Le corpus `CWRM-001` ayant fondé les premières décisions de conception est cependant explicitement
restreint. Section *"Limites explicites du corpus actuel"* :

> *"Ce pipeline est validé pour : Praticiens libéraux ou en cabinet [...] Ce pipeline n'a pas été
> validé pour : Bloc opératoire (savoir incorporé non verbalisable), Urgences (interrupt-driven,
> parallèle, pas de séquence stable), SAMU (environnement chaotique, absence de dossier), Réanimation
> (continu, multi-dimensionnel, >24h). Ces contextes constituent une Phase 2 de la recherche."*

Vérification sur le corpus de base (F001-F009) : 8 profils sur 9 sont explicitement libéraux/cabinet ;
le 9ᵉ (F-005, échographiste) a un cadre d'exercice non précisé dans l'entretien lui-même — un trou de
collecte, pas un contre-exemple.

**Donnée supplémentaire (postérieure à REV-001, à intégrer sans lui faire dire plus qu'elle ne dit).**
Le round M2 a depuis testé un premier profil hospitalier : biologiste médical, hôpital, logiciel GLIMS
(session du 2026-09-03 —
[CWRM-020-APX-M2-workspace-questionnaires](research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md)).
Résultat compatible avec les fondements actuels (3ᵉ/4ᵉ confirmation positive de l'hypothèse
terminologie, Lecture A confirmée). Mais ce point de donnée reste un contexte de biologie/laboratoire,
pas un des contextes explicitement exclus par `CWRM-001` (bloc opératoire, urgences, SAMU, réanimation
— interrupt-driven, chaotiques). **Il ne permet donc pas, à lui seul, de valider la généralisation aux
environnements hospitaliers complexes.**

**Décision.**

La Mission de MedLink **reste volontairement générale** — elle représente une ambition produit, pas une
affirmation que son bénéfice ou ses invariants cognitifs sont déjà validés dans tous les contextes de
soins. **`CLAUDE.md` n'est pas modifié** : réduire la formulation de la Mission pour la faire
correspondre au périmètre de preuve actuel confondrait un problème de niveau de preuve avec une
décision d'ambition stratégique — deux couches différentes, qui doivent être distinguées, pas fusionnées
en forçant l'une à s'aligner sur l'autre.

Architecture documentaire retenue :

```
MISSION (CLAUDE.md)
  ↓ ambition générale MedLink
RESEARCH EVIDENCE SCOPE
  ↓ contexte actuellement validé
  ↓ extensions expérimentales
  ↓ contextes non validés
```

Cohérent avec la discipline Stable/Experimental déjà appliquée ailleurs dans le projet (`ADR-0016`).

**Statut de périmètre (nouveau, introduit par ce Finding) :**

| Élément | Statut |
|---|---|
| Mission (`CLAUDE.md`) | `Stable` — inchangée |
| Fondement empirique actuel | Validé principalement en libéral/ambulatoire |
| Hospitalier (hors contextes ci-dessous) | `Experimental` — en cours de validation (1 profil, biologiste) |
| Urgences / SAMU / réanimation / bloc opératoire | Non validé — Phase 2 de `CWRM-001`, non engagée |
| Universalité de la Mission | Non démontrée — explicitement pas revendiquée comme telle |

**Action exécutée.** Documentation du Finding et de la décision, uniquement. Aucune modification de
`CLAUDE.md`, d'aucun ADR existant, d'aucun Workspace. Toute future extension de corpus vers un contexte
hospitalier ou interrupt-driven doit être lue à l'aune de ce tableau, pas comme une validation acquise
de la Mission dans son ensemble.

---

### Finding-003 — Frontière WS-006 → WS-001 (jour suivant)

**Statut :** `Open — Empirical Resolution Required` — **pas `Resolved`**. Aucune décision produit ou
architecture n'est prise par ce Finding ; il documente une lacune de recherche, pas un choix à trancher.
**Origine :** REV-001 §8.

**Constat — confirmé des deux côtés.**
- `WS-001-morning-brief.md` (PP-001 à PP-004) ne mentionne nulle part WS-006, le report, la veille ou
  la continuité vers le lendemain — zéro occurrence vérifiée dans le Blueprint.
- Le prototype WS-006 (`WS-002-WS-003-parcours-v8.html`, bloc "À reporter à demain") ne revendique pas
  non plus la reprise du lendemain matin — son propre `hyp-note` le dit explicitement : *"la frontière
  avec WS-001 le lendemain matin [...] reste explicitement ouverte [...] non résolue par cet écran."*
- La frontière fin de journée → report → lendemain est donc **non définie des deux côtés à la fois**,
  pas juste du point de vue de WS-006.
- Les questions permettant de la résoudre existent déjà, écrites, jamais posées à un praticien
  ([CWRM-020-APX-M2-workspace-questionnaires](research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md)
  §6) :
  - *"Comment savez-vous que votre journée est vraiment terminée ?"*
  - *"Qu'est-ce qui vous empêcherait de partir tranquille, ce soir ?"*
  - *"Le lendemain matin, est-ce que vous repensez à ce qui restait en suspens la veille — et comment
    vous en souvenez-vous ?"*
  - *"Les tâches reportées — vous les retrouvez où, le lendemain ?"*
- Le Product Owner a déjà explicitement refusé de construire un mécanisme de report avant validation
  empirique ([OBS-M2-005](../product/M2-JOURNAL-observations.md), mise à jour du 2026-09-08).

**Décision : aucune.** Contrairement à Finding-002 (problème de gouvernance/portée, une décision était
nécessaire), Finding-003 est une frontière fonctionnelle **non observée** — pas de décision de
conception justifiée à ce stade. Le Finding reste explicitement `Open`. En particulier, **aucune
position provisoire n'est actée** — ni *"WS-006 montre le report, WS-001 ne le reprend jamais"*, ni
l'inverse. Que WS-006 matérialise aujourd'hui un concept de report dans le prototype ne démontre pas
que le praticien attend que ce report soit repris par WS-001 le lendemain — lire le prototype comme une
preuve de comportement utilisateur serait précisément l'erreur qu'AR-001 est censé éviter.

**Condition de résolution explicite.** Ce Finding devient `Resolved` seulement après un round de test
praticien incluant les 4 questions ci-dessus (§6). Pas de délai fixé, pas de décision par défaut si le
round tarde.

**Action exécutée.** Documentation du Finding, uniquement. Aucune modification de WS-001, WS-006, ni du
prototype.

**Annotation du 2026-10-06 — décision produit postérieure à la clôture d'AR-001. Statut inchangé :
`Open — Empirical Resolution Required`.**
Le Product Owner a pris le 2026-10-06 une décision qui donne une position à cette frontière : le travail
restant en fin de journée est conservé dans **« À traiter »**, collection unique des actions restant à
effectuer par le praticien (voir [A-TRAITER-implementation](product/workspaces/A-TRAITER-implementation.md)) ;
le lendemain, il est retrouvé via le compteur « À traiter [N] » de Mon espace (WS-001), qui n'en est
qu'un point d'entrée ; WS-006 est un point de clôture qui transfère, il ne possède rien.
- **Nature** : décision produit `Founder-Driven`, `→ (evidence: ?)`, prise dans le cadre
  d'[ADR-0025](adr/ADR-0025-innovations-produit-non-observees.md) — pas une résolution empirique.
- **Ce qu'elle ne fait pas** : elle ne résout pas ce Finding. Le texte ci-dessus (*"aucune position
  provisoire n'est actée"*) décrivait l'état au 2026-10-05 ; il n'est pas réécrit. La condition de
  résolution est inchangée : les 4 questions §6 deviennent le **test** de cette décision, pas une
  formalité. Si le round montre que les praticiens retrouvent leurs reports ailleurs et ne veulent pas
  en changer, la décision est révisée (critères d'abandon HYP-006-000 et HYP-006-002).
- **Changement de position à tracer** : cette décision revient sur le refus du 2026-09-08 de
  construire un mécanisme de report avant validation empirique ([OBS-M2-005](product/M2-JOURNAL-observations.md)).
  Le revirement est assumé et motivé (ADR-0025 : une solution non observée peut être construite comme
  hypothèse si elle porte un critère d'abandon) ; il n'est pas masqué.

---

### Finding-001 — PAT validation mechanism absent

**Statut :** `Open — Methodology Debt Confirmed` — troisième statut, distinct de `Resolved`
(Finding-002) et d'`Open — Empirical Resolution Required` (Finding-003). Ni une décision de
gouvernance à trancher maintenant, ni une donnée terrain à attendre : une dette de méthode confirmée,
déjà coûteuse, dont le contenu de résolution ne doit pas être préempté par ce Finding.
**Origine :** REV-001 §1/§2.

**1. Constat confirmé.** PAT (Pattern) est utilisé comme pivot réel du travail Product — mais ne
dispose d'aucune Gate formelle. `ADR-0016` le dit lui-même : *"PAT | GOV-000 Niveau 1 | Experimental |
Aucune Gate formelle dans CWRM-000A/001/002 ; pivot de tout le travail Product réel malgré cela."* Gate
1 de `GOV-000` exige seulement que les PAT soient *"identifiés"* — pas validés contre un seuil,
contrairement à Gate 2 qui valide réellement le format WE/WBD.

**2. Cause structurelle confirmée.** PAT a été volontairement laissé hors du pipeline core —
`CWRM-001-research-method.md` (changelog v2.1) : *"'Pattern' (PAT) n'est pas introduit ici — proposé
mais volontairement non intégré au pipeline core."* `CWRM-030` ("Coding Manual"), censé combler ce
vide, est référencé comme dépendance (CWRM-020→030→040) dans plusieurs documents mais reste statut
**"Prévu"** dans `research/specifications/INDEX.md` — planifié, jamais spécifié ni rédigé.

**3. Impact démontré — pas théorique.** `M1_FINAL_ARCHIVE.md` documente une conséquence déjà
matérialisée : les cinq `PAT-005-NNN` de WE-005 n'affichent aucune confiance, violant la règle
obligatoire d'`ADR-0018` (confiance affichée pour tout Pattern). WE-005 reste *"Draft — non conforme
ADR-0018"*, bloqué pour cette raison précise. Le document le nomme explicitement : *"[Gate absente]
PAT — aucun mécanisme de validation (Gate, seuil, condition de réfutation) n'existe, malgré son usage
central."*

**4. Condition de résolution.** La dette est résolue uniquement lorsque, dans cet ordre :
- la Gate PAT est formellement spécifiée (critères, seuils, conditions de réfutation) ;
- `CWRM-030` — Coding Manual est effectivement rédigé ;
- l'application du dispositif permet de remettre les PAT existants (dont `PAT-005-NNN`) en conformité.

**Ce que ce Finding ne fait pas.** Il ne spécifie pas le contenu de la Gate PAT ni celui de `CWRM-030`
— décider de ce contenu ici reproduirait exactement le problème méthodologique qu'il documente (un
concept central figé sans processus de spécification propre). La chaîne retenue est : Finding-001 →
Methodology Debt → chantier `CWRM-030`/Gate PAT, distinct → résolution ultérieure. Ce chantier ne
bloque pas la Phase 2 (fiche écran par écran), **sauf si une décision de Phase 2 dépend directement
d'un PAT dont la validité serait mise en question** — à vérifier au cas par cas, pas présumé ici.

**Action exécutée.** Documentation du Finding, uniquement. Aucune Gate ni Coding Manual rédigés par ce
document — ce serait précisément l'erreur à éviter.

---

## Condition de clôture (amendée le 2026-10-05)

**Règle d'origine (2026-08-06), remplacée :**
> *"AR-001 peut être clos [...] quand chaque Finding listé est `Resolved` ou explicitement accepté
> comme `Deferred`."*

**Règle amendée :**
> AR-001 peut être clos lorsque chaque Finding listé possède un statut explicite, une qualification de
> sa nature, et, lorsqu'il reste ouvert, une condition de résolution documentée. Un Finding `Open`
> n'empêche pas la clôture d'AR-001 lorsqu'il est explicitement non-bloquant et qu'aucune décision ne
> peut légitimement être prise à ce stade.

**Note de gouvernance.** Cet amendement est intentionnel, pas une relecture complaisante de la règle
d'origine : `Open` n'est pas rendu synonyme de `Resolved`. Le traitement falsificateur des Findings
001/002/003 a montré que le modèle binaire `Resolved`/`Deferred` ne permet pas de représenter
correctement les résultats d'une revue qui doit distinguer une décision prise (Finding-002), une dette
de méthode confirmée mais non urgente (Finding-001), et une question empirique non tranchable sans
terrain (Finding-003). AR-001 reconnaît désormais au minimum les états `Resolved` et `Open`, ces
derniers qualifiés par leur nature et leur condition de résolution. Raison méthodologique : le rôle
d'un audit est d'identifier, qualifier et orienter les Findings — pas de garantir que toutes les
questions qu'il révèle soient tranchées avant sa propre clôture. Ce qui doit rester garanti, ce n'est
pas l'absence de Finding `Open`, mais l'absence de Finding sans statut, sans qualification, ou sans
condition de suite.

**État final :**

| Finding | Statut | Condition | Bloquant Phase 2 ? |
|---|---|---|---|
| 001 | `Open — Methodology Debt Confirmed` | Gate PAT formellement spécifiée + `CWRM-030` rédigé | Non |
| 002 | `Resolved` | — | Non |
| 003 | `Open — Empirical Resolution Required` | 4 questions (§6) posées au prochain round praticien | Non |
| 004 | `Resolved` | — | Non |
| 005 | `Resolved` (constat) ; conséquence tranchée par `ADR-0020` | — | Non |

Aucun Finding n'est sans statut, sans qualification, ni sans condition de suite documentée — condition
suffisante pour clore AR-001 selon la règle amendée ci-dessus.

---

### Note de séquence (non corrigée rétroactivement)

WS-006 a été intégré au proof set M2 et un écran construit dans le prototype
([ADR-0024](adr/ADR-0024-ws004-nature-et-proof-set-m2.md), 2026-09-08) **avant** la clôture formelle
d'AR-001 (2026-10-05) — soit un mois avant que la précondition posée par `ADR-0019` (*"l'ouverture de
WS-006 est précédée par cette revue"*) ne soit satisfaite dans l'ordre prévu. Ce n'est pas corrigé
rétroactivement : WS-006 reste construit, le proof set M2 reste tel qu'amendé par ADR-0024. Conservé
ici comme fait de gouvernance tracé, pas comme anomalie à réparer — la clôture d'AR-001 aujourd'hui
confirme a posteriori qu'aucun Finding n'aurait empêché l'ouverture de WS-006 (tous `Resolved` ou
`Open` non-bloquants), donc que la séquence inversée n'a pas produit de décision non couverte — mais
l'ordre lui-même reste non respecté, et c'est noté comme tel.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Ouverture — Finding-004 résolu ; Findings 001-003 identifiés mais non formalisés |
| 2026-08-06 | 1.1 | Finding-005 ajouté (corroboration empirique du mandat WS-005, constat pur, aucune décision d'architecture) ; ADR-0020 réservé pour la question d'architecture qui en découle |
| 2026-10-05 | 1.2 | ADR-0020 rédigé et accepté (Option B — mandat WS-005 réduit à Transmission, Avis/Délégation en hypothèses avec garde-fou de révision) |
| 2026-10-05 | 1.3 | Finding-002 formalisé et résolu — Mission (`CLAUDE.md`) confirmée plus générale que le périmètre validé par `CWRM-001` (libéral/ambulatoire), décision : Mission inchangée (`Stable`), nouvelle distinction explicite Mission/Research Evidence Scope, statut de périmètre introduit (hospitalier `Experimental`, urgences/SAMU/réanimation/bloc opératoire non validés). Aucune modification de `CLAUDE.md`. Findings 001 et 003 restent non formalisés |
| 2026-10-05 | 1.4 | Finding-003 formalisé — `Open — Empirical Resolution Required`, explicitement non `Resolved`. Frontière WS-006 → WS-001 confirmée non définie des deux côtés (ni le Blueprint WS-001, ni le prototype WS-006 ne la revendiquent). Aucune décision produit ou position provisoire actée — condition de résolution explicite : round praticien incluant les 4 questions de CWRM-020-APX-M2-workspace-questionnaires §6. Finding-001 reste seul non formalisé |
| 2026-10-05 | 1.5 | Finding-001 formalisé — `Open — Methodology Debt Confirmed`, troisième statut distinct de `Resolved` et d'`Open — Empirical Resolution Required`. PAT confirmé sans Gate formelle (ADR-0016), `CWRM-030` confirmé statut "Prévu" jamais rédigé, impact réel démontré (WE-005/PAT-005-NNN non conforme à ADR-0018). Condition de résolution posée (Gate PAT spécifiée + CWRM-030 rédigé + mise en conformité des PAT existants) sans préempter son contenu |
| 2026-10-05 | 2.0 | **Clôture d'AR-001.** Condition de clôture amendée (le modèle binaire Resolved/Deferred remplacé par un modèle reconnaissant Resolved et Open-qualifié-avec-condition-de-résolution, amendement motivé et tracé, pas une relecture complaisante). Statut passé `In Progress` → `Closed — Findings formally classified and dispositioned`. Note de séquence ajoutée : WS-006 a été ouvert (ADR-0024, 2026-09-08) avant cette clôture, un mois avant que la précondition d'ADR-0019 soit satisfaite dans l'ordre prévu — non corrigé rétroactivement, tracé comme fait de gouvernance |
| 2026-10-06 | 2.1 | Annotation de Finding-003 (AR-001 reste `Closed`, Finding-003 reste `Open — Empirical Resolution Required`) : décision produit Founder-Driven du 2026-10-06 (travail restant conservé dans « À traiter », retrouvé via WS-001) consignée comme position testée par le round §6, pas comme résolution. Revirement par rapport à OBS-M2-005 (refus du 2026-09-08) tracé explicitement. |
