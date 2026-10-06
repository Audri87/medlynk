# ADR-0020 — Périmètre du mandat de WS-005 ("Clinical Coordination")

**Statut** : Accepted — Option B retenue le 2026-10-05 (Product Owner), avec le garde-fou de révision
décrit ci-dessous.
**Date** : 2026-10-05
**Répond à** : [Finding-005](../AR-001-architecture-review.md#finding-005--empirical-corroboration-of-the-ws-005-mandate)
(`AR-001-architecture-review.md`), qui a explicitement réservé cet identifiant sans trancher la
question.
**Nature** : Décision initiale — comble un emplacement réservé (`ADR-0020`, identifiant déjà annoncé
par Finding-005), pas un amendement d'un document existant.
**Dépend de** : [WBD-004](../product/workspaces/WBD-004-consultation-vs-documentation.md) v2.1 (mandat
initial de WS-005, *"transmission, avis, délégation, reprise de patient"*),
[CWRM-020-APX-WS005-coordination-guide.md](../research/specifications/CWRM-020-APX-WS005-coordination-guide.md)
(nom candidat "Clinical Coordination", provisoire, vocabulaire produit).

---

## Contexte

Finding-005 a appliqué CWRM-EXP-001 §8 identiquement aux quatre composantes du mandat déclaré de
WS-005 et a mesuré un écart net entre ce qui est énoncé et ce qui est corroboré :

| Composante | Sources indépendantes | Verbatim direct | Verdict |
|---|---|---|---|
| Transmission | 5 profils (F002, F005, F007, F008, F009) | Oui | **Evidence** |
| Avis | 0 profil — recherche exhaustive sur 9 transcripts | — | **Unsupported** |
| Délégation | 1 profil (F009) | Non (synthèse rapportée) | **Observation** |
| Reprise de patient | 4 profils (F002, F004, F008, F009) | Oui | **Evidence — mais recouvre T2, déjà `Stable`** ; hors périmètre de WS-005 |

Finding-005 est strictement constatatif — il ne préjuge d'aucune décision. La question qu'il laisse
ouverte, verbatim :

> *"Faut-il réduire le mandat de WS-005 à la seule transformation aujourd'hui corroborée
> (Transmission), ou conserver les responsabilités encore non corroborées (Avis, Délégation, Reprise
> de patient) comme hypothèses architecturales explicites ?"*

**Élément nouveau depuis Finding-005** : une première matérialisation visuelle de WS-005 a été
construite dans le prototype (`WS-002-WS-003-parcours-v8.html`, 2026-10-04, écran "Coordination") —
non comme une anticipation de cette décision, mais comme un prototype `HYPOTHÈSE — À TESTER` construit
en suivant déjà, sans le savoir formellement avant la rédaction de cet ADR, la logique de l'Option B
ci-dessous (Transmission peuplée d'exemples, Avis/Délégation affichées vides avec leur niveau de
preuve explicite, Reprise de patient absente). Ce fait est rapporté ici pour mémoire — il ne constitue
pas une validation terrain et ne doit pas peser dans la décision au-delà de ce qu'il est : un indice
que l'Option B est implémentable sans détour.

---

## Problème

Deux lectures possibles, aux conséquences différentes :

1. **Réduire maintenant** — ne garder que ce qui est `Evidence`. Discipline stricte, cohérente avec le
   principe déjà appliqué ailleurs dans le corpus (OBS-M2-002 : *"ne pas nommer ni figer d'unité avant
   d'avoir observé"*). Risque : abandonner un signal faible mais réel (Délégation, 1 profil) et fermer
   la porte à Avis avant d'avoir sondé la question frontalement (le guide d'entretien WS-005 ne pose la
   question d'Avis que depuis sa version récente — `0 profil` peut refléter une fenêtre de mesure
   courte, pas une absence structurelle).
2. **Garder les quatre, hypothèses explicites** — ne rien perdre, mais risquer la dérive déjà vue sur
   "widget" (OBS-M2-002/003) : une hypothèse jamais confrontée qui s'installe par l'usage sans jamais
   être formellement validée ni retirée.

Le choix est un choix de gouvernance sur le niveau de preuve exigé pour committer un périmètre produit,
pas un fait supplémentaire à aller chercher dans le corpus — c'est l'objet de cet ADR, comme
`ADR-0024` l'a fait pour WS-004.

---

## Décision

**Option B retenue (2026-10-05, Product Owner), avec garde-fou explicite contre la dérive "hypothèse
permanente".**

1. **Transmission** devient la seule composante du mandat traitée comme acquise pour V1 — seule
   transformation `Evidence`, seule construite avec du contenu réel dans le prototype.
2. **Avis** et **Délégation** restent dans le périmètre nominal de WS-005, mais explicitement comme
   **hypothèses architecturales non construites** : aucun contenu peuplé, aucune fonctionnalité réelle
   tant qu'elles n'ont pas progressé en preuve. Le prototype actuel (écran "Coordination") matérialise
   déjà cette distinction (`Unsupported`/`Observation` affichés comme tels, sections vides).
3. **Reprise de patient est formellement retirée du mandat de WS-005.** Finding-005 établit qu'elle
   recouvre intégralement T2 (déjà `Stable`, rattachée à WS-002) — la garder dans WS-005 créerait un
   doublon de responsabilité entre deux Workspaces pour la même transformation.
4. **Garde-fou (condition de sortie de l'état "hypothèse")** : Avis et Délégation ne peuvent être
   promues en fonctionnalité construite qu'après corroboration terrain (seuil `IP-REQ-007`, comme pour
   toute autre composante du corpus). **Si, après les trois prochains rounds de test praticien portant
   sur WS-005, Avis reste à 0 occurrence et Délégation reste à 1 profil sans verbatim, les deux doivent
   être explicitement retirées du mandat** — pas laissées indéfiniment en statut hypothèse. Ce
   garde-fou est la différence structurelle avec le risque "widget" : une échéance de révision nommée,
   pas une hypothèse ouverte sans limite.
5. **WBD-004** doit être amendé en conséquence (mandat reformulé : Transmission comme responsabilité
   confirmée ; Avis/Délégation comme hypothèses sous condition explicite ; Reprise de patient retirée
   et renvoyée formellement vers WBD-002/T2).

### Option A (écartée, documentée pour mémoire)

Réduire immédiatement le mandat à la seule Transmission. Écartée parce que : (a) Avis n'a jamais été
sondé frontalement avant la version récente du guide d'entretien — `Unsupported` après une fenêtre de
mesure courte n'a pas la même force qu'`Unsupported` après sondage direct répété ; (b) le garde-fou de
l'Option B (étape 4 ci-dessus) obtient la même discipline sans fermer la question prématurément — si
le terrain confirme l'Option A dans les faits, l'Option B y converge d'elle-même à l'échéance fixée.

---

## Justification (grille CWRM-AF-001, gabarit repris d'ADR-0015 Règle 3 / ADR-0024)

| # | Question | Réponse |
|---|---|---|
| 1 | Quel problème empirique résout-elle ? | L'écart mesuré par Finding-005 entre le mandat déclaré de WS-005 et sa corroboration réelle, qui laissait le prototype et le questionnaire WS-005 sans périmètre officiel pour trancher quoi construire. |
| 2 | Quel Claim renforce-t-elle ? | Aucun Claim CWRM (H1/H2/H3) — décision de gouvernance produit sur un Workspace, pas une méthode de recherche. |
| 3 | Quelle hypothèse est concernée ? | Le mandat "Clinical Coordination" (nom candidat, vocabulaire produit, non Domain) tel que décrit dans `CWRM-020-APX-WS005-coordination-guide.md` §8. |
| 4 | Comment sera-t-elle validée ? | Par les trois prochains rounds de test praticien portant explicitement sur l'écran "Coordination" (Transmission, Avis, Délégation) — pas seulement WS-002/WS-003 comme jusqu'ici. |
| 5 | Quelle métrique permettra de conclure ? | Avis et Délégation atteignent `IP-REQ-007` (promotion) ou sont formellement retirées du mandat à l'échéance des trois rounds (statu quo impossible au-delà). |

---

## Conséquences

- `WBD-004` à amender (nouvelle version) : mandat reformulé selon la Décision ci-dessus.
- `CWRM-020-APX-WS005-coordination-guide.md` : les questions sur Avis/Délégation restent légitimes à
  poser, mais doivent être explicitement comptées vers le garde-fou de l'étape 4 (suivi du nombre de
  rounds écoulés).
- Prototype (`WS-002-WS-003-parcours-v8.html`, écran "Coordination") : déjà conforme à cette décision,
  aucun changement requis à ce stade. Son propre `hyp-note` doit être mis à jour pour citer `ADR-0020`
  une fois ce document accepté, au lieu de renvoyer uniquement à Finding-005.
- Aucune conséquence sur WS-002/T2 : "Reprise de patient" y reste `Stable`, inchangée.

---

## Ce que cet ADR ne tranche pas

- La forme UX finale d'Avis/Délégation si elles atteignent un jour `IP-REQ-007` — non anticipée.
- Le nom définitif "Clinical Coordination" — reste vocabulaire produit provisoire (guide §8), cet ADR
  ne le fige pas.
- Le calendrier exact des "trois prochains rounds" — dépend du rythme réel de recrutement praticien,
  pas fixé en dates calendaires ici.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| Finding-005 (`AR-001-architecture-review.md`) | Constat empirique à l'origine de cet ADR ; non modifié |
| WBD-004 — Consultation vs Documentation | À amender en conséquence (mandat WS-005 reformulé) |
| CWRM-020-APX-WS005-coordination-guide.md | Guide d'entretien ; §8 (nom candidat) non affecté, grille de questions à instrumenter pour le garde-fou |
| ADR-0024 — Nature de WS-004 | Précédent méthodologique direct : même gabarit de justification, même discipline Option retenue/Option écartée |
| ADR-0015 — Pipeline Canonique | Fournit le gabarit de justification (Règle 3) |
| `WS-002-WS-003-parcours-v8.html` (écran "Coordination") | Première matérialisation prototype, déjà conforme à l'Option B — à mettre à jour pour citer cet ADR une fois accepté |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-10-05 | 0.1 | Création — Draft, Option B recommandée avec garde-fou de révision explicite, Option A documentée et écartée. En attente de décision du Product Owner. |
| 2026-10-05 | 1.0 | Accepted — Product Owner confirme l'Option B telle que recommandée, garde-fou inclus (3 rounds de test, sinon retrait formel d'Avis/Délégation). |
