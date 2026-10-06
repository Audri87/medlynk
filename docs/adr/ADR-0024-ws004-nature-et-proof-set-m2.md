# ADR-0024 — Nature de WS-004 et périmètre du proof set M2

**Statut** : Accepted — Option A adoptée le 2026-09-08 (Product Owner). Option B différée comme
chantier de gouvernance distinct, non tranchée par ce document.
**Date** : 2026-09-08
**Répond à** : [OBS-M2-013](../product/M2-JOURNAL-observations.md) — contradiction entre la
responsabilité démontrée pour WS-004 et sa classification comme Workspace, confirmée par audit
falsificateur (G1/Clinical Authorization, PDX-001).
**Nature** : Protocole d'évolution — amende [ADR-0022](ADR-0022-m2-freeze-protocol.md) selon le
mécanisme que celui-ci prescrit pour toute évolution de M2 pendant le gel (*"Doit suivre le protocole
d'évolution d'ADR-0015 Règle 4, pas une simple révision de conversation"*). Suit le même gabarit de
justification que celui qu'`ADR-0015` a appliqué à lui-même (grille `CWRM-AF-001`, cinq questions).

---

## Contexte

`ADR-0022` (M2 Freeze Protocol) déclare que le gel porte sur *"WS-002, WS-004, WS-005 — les trois
seuls Workspaces réellement construits sous M2"* (§2), et que la condition de sortie exige, pour
chacun, *"un Blueprint rédigé, au moins un round d'entretien praticien conduit, et une entrée dans le
Journal M2 pour chaque écart rencontré"* (§4).

Le challenge du 2026-09-08 (falsification WS-003/WS-004, puis audit ciblé documenté dans
`OBS-M2-013`) a établi que WS-004, à l'état actuel du corpus, ne satisfait pas la définition normative
de Workspace ([WSP-001](../workspace/WSP-001-workspace.md) : *"assemblée pour un Actor"*, exclut
explicitement *"un Application Service"*). Aucune responsabilité Actor-facing distincte de WS-003 n'a
été démontrée sur les scénarios testés (A–G). Les deux pistes cherchées activement pour contredire ce
constat (G1/Clinical Authorization, PDX-001) n'ont pas renversé la conclusion :
- G1 est classé *"Domain Behaviour"* dans `HR-001`, résolu par *"Strategic Design"* — pas une
  responsabilité de Workspace.
- PDX-001 contient une exigence Actor-facing réelle (*"validation explicite du praticien, non
  contournable"*, tirée de CLAUDE.md) mais conditionnelle à une capacité elle-même non démontrée,
  jamais prototypée, jamais testée (`Discovery (PDX)`).

**Conséquence directe** : la condition de sortie d'`ADR-0022` §4 (*"un round d'entretien praticien
conduit"*) est structurellement impossible à satisfaire pour WS-004 tel que classé aujourd'hui — il
n'existe rien qu'un praticien puisse tester.

---

## Problème

Deux lectures possibles de ce qui doit changer, avec des conséquences différentes :

1. **WS-004 est le mauvais objet dans un échantillon par ailleurs correctement défini** — il suffit de
   le remplacer par un Workspace qui, lui, satisfait WSP-001.
2. **La définition même du proof set M2 avait un angle mort** — aucun critère n'a jamais vérifié
   qu'un objet candidat au gel M2 est réellement un Workspace avant de l'y inclure. Remplacer WS-004
   sans corriger ce trou méthodologique laisse la possibilité qu'un futur Workspace soit mal classé de
   la même manière.

Le choix entre ces deux lectures est un choix de gouvernance, pas un fait à démontrer davantage — c'est
l'objet de cet ADR.

---

## Décision

**Option A retenue maintenant. Option B différée comme chantier séparé.**

Raison méthodologique donnée par le Product Owner : la contradiction est déjà établie et son périmètre
immédiat est clair — corriger le proof set M2 actuel ne nécessite pas de résoudre au préalable toute la
gouvernance des catégories d'objets du système. Transformer une anomalie locale en refonte de
gouvernance prématurée serait une erreur de proportion, symétrique à celle qui a produit l'anomalie
(traiter une question locale comme si elle exigeait une réponse architecturale globale).

**Décision immédiate (A)** :
1. Retirer WS-004 du proof set M2.
2. Intégrer WS-006 à sa place.
3. Conserver `OBS-M2-013` comme trace de la découverte — non modifié, non supprimé.
4. **Fait (2026-09-08).** Amendement ciblé de `WBD-004` (v2.2 — Erratum) : nature de l'objet
   reclassifiée, responsabilité de persistance inchangée, texte v2.1 conservé avec annotations
   ponctuelles plutôt que réécrit.
5. **Fait (2026-09-08).** Questionnaire WS-004 (`CWRM-020-APX-M2-workspace-questionnaires` §4)
   reclassé : deux questions déplacées vers le test WS-003/Mode Clôture, la question de nommage
   retirée (sans objet), la question de relecture personnelle conservée mais différée.
6. Rien n'est décidé aujourd'hui sur la future UX de PDX-001, si sa capacité sous-jacente est un jour
   validée — reste explicitement ouvert.

**Décision différée (B) — Fait (2026-09-09), sous une forme plus ciblée que prévu.** L'instruction du
cas WS-004 comme matériau a montré qu'une taxonomie complète des objets n'était pas nécessaire — le
trou était un contrôle manquant, pas un modèle manquant. Amendement minimal apporté à `GOV-000`
(v1.8) : le format WBD (§5) exige désormais un contrôle d'éligibilité Workspace (contre `WSP-001`)
avant toute attribution de responsabilité, avec un nouveau verdict possible `NO-WORKSPACE` ; Gate 2
(§4) reçoit une Règle v1.8 symétrique à la Règle v1.2 déjà existante. Aucune nouvelle catégorie
d'objet créée — `WSP-001` excluait déjà "un Application Service" de sa définition, avant même cette
discussion.

**Point de vigilance explicite, à ne pas perdre en relisant cette décision plus tard** : WS-006 n'est
**pas** un remplacement fonctionnel de WS-004. Les deux ne portent pas la même responsabilité — WS-004
gérait (sur le papier) la persistance/structuration de la mémoire clinique, WS-006 gère la clôture de
journée. WS-004 est retiré parce qu'il ne satisfait pas actuellement le critère Workspace ; WS-006 est
inclus parce qu'il le satisfait et constitue un véritable objet Actor-facing à tester — pas parce qu'il
reprendrait la mission de WS-004.

---

### Option A (retenue) — Remplacer WS-004 par WS-006 dans le proof set M2

Amende `ADR-0022` §2 (liste des trois Workspaces) et, de fait, §4 (le round d'entretien praticien
s'appliquera à WS-006 plutôt qu'à WS-004).

**Pourquoi WS-006 est le candidat naturel** :
- Déjà `Research Workspace` (GOV-000 §4) — aucun Blueprint écrit à ce jour, donc réellement construit
  *sous* M2 si on l'y inclut maintenant (cohérent avec le critère d'ADR-0022 §2).
- Réellement Actor-facing par construction (*"Je termine"* — clôture de journée, tâches reportées).
- Les questions de recherche existent déjà, jamais posées :
  [CWRM-020-APX-M2-workspace-questionnaires](../research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md) §6.
- Rejoint directement une frontière déjà identifiée comme ouverte —
  [OBS-M2-005](../product/M2-JOURNAL-observations.md), mise à jour du 2026-09-08 : frontière WS-006 →
  WS-001, jamais spécifiée.

**Limite assumée** : corrige le symptôme (le mauvais objet dans l'échantillon), pas la cause racine
(l'absence de critère de vérification au moment de la constitution du proof set). Un futur Workspace
pourrait être mal classé de la même façon sans qu'on le détecte avant construction.

### Option B (différée — chantier séparé) — Réviser la définition du proof set, pas seulement son contenu

Ajoute un critère de vérification explicite : avant qu'un objet ne soit qualifié "Workspace" et inclus
dans un proof set M2 (actuel ou futur), vérifier qu'il satisfait `WSP-001` (assemblée pour un Actor).
Peut inclure WS-006 en remplacement (comme l'Option A) ou réduire temporairement le proof set à deux
Workspaces (WS-002, WS-005) en attendant qu'un troisième candidat soit vérifié.

**Ce que ça touche en plus de l'Option A** : potentiellement `GOV-000` — création d'une catégorie
d'objet explicite ("Application Service interne" ou équivalent), distincte de Workspace et de Research
Workspace, pour que des responsabilités comme celle de WS-004 (persistance, structuration) aient un
endroit normatif où exister sans être confondues avec un Workspace.

**Limite assumée** : plus lent, rouvre une discussion de gouvernance au niveau GOV-000 pendant que le
gel M2 est censé geler la méthode — tension à clarifier avec l'esprit d'`ADR-0022` (la modification
porterait sur GOV-000, au-dessus de M2, pas sur M2 lui-même ; à confirmer que ce n'est pas ce que le
gel protège).

---

## Justification (grille CWRM-AF-001, reprise du gabarit déjà appliqué par ADR-0015 Règle 3)

| # | Question | Réponse |
|---|---|---|
| 1 | Quel problème empirique résout-elle ? | WS-004 ne peut structurellement jamais satisfaire la condition de sortie du gel M2 (§4, round d'entretien praticien) — rien qu'un praticien puisse tester n'existe pour cet objet, confirmé par audit falsificateur. |
| 2 | Quel Claim renforce-t-elle ? | Aucun Claim scientifique CWRM (H1/H2/H3) — décision de gouvernance produit, pas de méthode de recherche. |
| 3 | Quelle hypothèse est concernée ? | Aucune hypothèse M1/CWRM ; concerne la classification WSP-001 d'un objet produit spécifique (WS-004), pas une loi de recherche. |
| 4 | Comment sera-t-elle validée ? | Option A : par la conduite effective d'un round d'entretien praticien sur WS-006. Option B : par l'absence, dans les 90 jours suivant l'adoption, d'un nouveau cas d'objet classé Workspace sans vérification contre WSP-001. |
| 5 | Quelle métrique permettra de conclure ? | Option A : WS-006 atteint les trois conditions de sortie d'`ADR-0022` §4. Option B : `GOV-000` dispose d'un critère de vérification explicite, appliqué rétroactivement à WS-002/003/005/006 sans en disqualifier aucun (test de non-régression sur les Workspaces déjà acceptés). |

---

## Conséquences communes aux deux options (indépendantes du choix A/B)

**WBD-004** (`RESOLVED`) doit être amendé dans les deux cas — pas supprimé : la responsabilité de
persistance/structuration reste valide, sa classification comme "Workspace" doit changer. Amendement
proposé : nouvelle version (v2.2), pas une réouverture complète du document.

**Prototype** — `#ws4` retiré du parcours praticien testable dès `WS-002-WS-003-parcours-v5.html`
(aucun chemin de clic n'y mène). **Fait (2026-09-08, étape 3 de la séquence)** : premier écran WS-006
("Je termine") construit dans `WS-002-WS-003-parcours-v6.html`, à partir des ACT déjà codés
(ACT-F001-024→027, ACT-F009-033) et des questions déjà écrites, jamais posées
(`CWRM-020-APX-M2-workspace-questionnaires` §6). Aucun Blueprint WS-006 n'existe encore — cet écran est
une première matérialisation `HYPOTHÈSE — À TESTER`, pas une conception validée.

**Questionnaire WS-004** (`CWRM-020-APX-M2-workspace-questionnaires` §4) — ses questions supposaient un
entretien praticien sur un Workspace. À reformuler pour informer soit Mode Clôture (WS-003), soit les
critères de fiabilité de Care Record, plutôt qu'un Workspace qui n'existe peut-être pas comme tel.

---

## Ce que cet ADR ne tranche pas

- La forme UX que prendrait une future validation liée à PDX-001, si sa capacité sous-jacente est un
  jour démontrée — explicitement laissé ouvert (`OBS-M2-013`), pas préjugé par ce document.
- Le nom final de WS-006 (déjà noté "nom à confirmer" ailleurs dans le corpus).

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| ADR-0022 — M2 Freeze Protocol | Amendé par cet ADR (§2 périmètre, §4 condition de sortie) si Option A ou B est adoptée |
| ADR-0015 — Pipeline Canonique | Fournit le protocole d'évolution suivi ici (Règle 4) et le gabarit de justification (Règle 3, repris ci-dessus) |
| WSP-001 — Workspace | Définition normative dont la non-satisfaction par WS-004 motive cet ADR ; non modifiée |
| WBD-004 — Consultation vs WS-004 | À amender en conséquence (v2.2), quelle que soit l'option retenue |
| OBS-M2-013 — M2-JOURNAL-observations | Contradiction et audit falsificateur à l'origine de cet ADR |
| GOV-000 | Potentiellement amendé si Option B est retenue (nouvelle catégorie d'objet) |

---

## Avis initial (suivi par la décision retenue)

L'avis donné avant décision allait dans le même sens que la décision finalement retenue : l'Option A
débloque le gel immédiatement, sans dette méthodologique nouvelle ; l'Option B répond à la question la
plus intéressante (pourquoi cette erreur a pu passer inaperçue) mais n'a pas besoin de bloquer l'Option
A — les deux ne sont pas mutuellement exclusives. Le Product Owner a retenu exactement cette séquence.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-09-08 | 0.1 | Création — Draft, deux options présentées suite à OBS-M2-013 et à son audit falsificateur, en attente de décision du Product Owner |
| 2026-09-08 | 1.0 | Accepted — Option A retenue (WS-004 retiré du proof set M2, WS-006 intégré à sa place, explicitement pas comme remplacement fonctionnel), Option B différée comme chantier de gouvernance GOV-000 séparé. ADR-0022 amendé en conséquence (v1.1) |
