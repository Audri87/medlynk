# WS-005 — Fiche d'implémentation (Phase 2 — Freeze V1)

| Field | Value |
|---|---|
| ID | WS-005 |
| Nom | *Clinical Coordination* — nom candidat, provisoire, vocabulaire produit (contesté, voir ci-dessous) |
| Version | 0.3 |
| Date | 2026-10-05 |
| Sources | [WE-005](WE-005-information-flow.md) (Evidence, **Draft non conforme ADR-0018**) · [ADR-0020](../../adr/ADR-0020-perimetre-mandat-ws005-coordination.md) (mandat, Accepted) · [AR-001](../../AR-001-architecture-review.md) Finding-005 · [CWRM-020-APX-WS005](../../research/specifications/CWRM-020-APX-WS005-coordination-guide.md) |
| Prototype | `WS-002-WS-003-parcours-v8.html`, section `#ws5` ("Coordination") |

> **Il n'existe ni Blueprint ni PDR pour WS-005.** La chaîne GOV-000 est : WE-005 (Draft, non
> conforme) → PDR-005 (**jamais rédigé** — seule mention dans tout le corpus : WE-005 §8, *"Les
> décisions éventuelles relèvent de PDR-005"*) → Blueprint (inexistant). WS-005 n'a donc **pas passé
> Gate 2**. Cette fiche documente le prototype existant face aux seules sources disponibles — elle
> ne tient pas lieu de Blueprint.

---

## Constat structurant — WS-005 est le cas où Finding-001 devient bloquant

AR-001 Finding-001 (`Open — Methodology Debt Confirmed`) prévoit une exception explicite : la dette
PAT ne bloque pas la Phase 2 *"sauf si une décision de Phase 2 dépend directement d'un PAT dont la
validité serait mise en question."*

**WS-005 est exactement ce cas.** Son unique Workspace Evidence (WE-005) repose sur `PAT-005-001` à
`005`, qui sont précisément les PAT non conformes cités comme impact démontré de Finding-001 (aucune
confiance affichée, identifiants OBS-005-NNN absents). Gate 2 exige un WE *validé* — WE-005 ne peut
pas l'être tant que la Gate PAT n'existe pas.

Conséquence : **"WS-005 obligatoire en V1" (bilan d'octobre) et "WS-005 a passé Gate 2" sont deux
affirmations différentes, et seule la première est vraie.** Le périmètre V1 l'inclut ; la
méthodologie ne l'a pas encore validé. Ce n'est pas un motif pour retirer WS-005 de la V1 — c'est un
motif pour ne pas présenter son contenu actuel comme stabilisé.

---

## Objectif

Pas de Product Question formelle (pas de Blueprint). WE-005 pose une question de recherche : *"Comment
les informations cliniques circulent-elles entre les interventions et entre les acteurs du parcours
de soins ?"* — question d'étude, explicitement pas une décision produit (WE-005 §8). Le bilan
d'octobre formule l'intention produit : *"Que dois-je faire après cette consultation ?"*

⚠ **Ces deux formulations ne disent pas la même chose.** WE-005 parle de *circulation
d'information entre acteurs* ; le bilan parle de *suites à donner par le praticien lui-même*. La
seconde recoupe largement l'écran "À traiter" (backlog personnel) et le Mode Clôture de WS-003 —
pas la coordination entre praticiens. À trancher dans PDR-005, pas ici.

## Entrée

Sidebar, item "🔗 Coordination", présent sur les 5 écrans à sidebar (Mon espace, Patients, À traiter,
Terminer ma journée, Coordination). Aucune entrée depuis WS-003 ou le Care Record — alors que la table
§11 du Blueprint WS-003 fait de WS-005 le destinataire du *"Partage avec d'autres acteurs"* produit en
Clôture. **Le lien WS-003 → WS-005 décrit dans le Blueprint de WS-003 n'existe pas dans le
prototype.**

## Sortie

Retour par la sidebar ou la topbar. Aucune action ne mène à un autre Workspace.

## Actions (réelles vs décoratives)

- **Décoratives** : toutes — "Lire" / "Voir" (Transmission), "Demander un avis à un confrère"
  (alerte de prototype).
- Aucune action réelle n'existe dans cet écran.

## Données nécessaires

| Composante (ADR-0020) | Niveau | Prototype |
|---|---|---|
| Transmission | `Evidence` — mandat V1 | 3 lignes (Sophie Martin reçu, Jean Morel reçu, Michel Rousseau envoyé) — données réutilisées du fichier, pas inventées |
| Avis | `Unsupported` — hypothèse | Section vide, statut affiché |
| Délégation | `Observation` — hypothèse | Section vide, statut affiché |
| Reprise de patient | Hors mandat (T2/WS-002) | Absente — conforme ADR-0020 |

## Règles

| Règle | Source | Prototype |
|---|---|---|
| Transmission seule composante construite | ADR-0020 Décision §1 | ✓ |
| Avis/Délégation sans contenu peuplé | ADR-0020 Décision §2 | ✓ |
| Reprise de patient retirée | ADR-0020 Décision §3 | ✓ |
| Garde-fou : 3 rounds de test sur cet écran | ADR-0020 Décision §4 | ⚠ compteur : **0 round** à ce jour |
| Nom "Clinical Coordination" non figé | ADR-0020, guide §8 | ✓ affiché comme "Coordination", provisoire |

## Écarts non couverts par ADR-0020

1. **Transmission verbale absente.** WE-005 §3 observe que *"certains échanges prennent la forme
   d'appels téléphoniques"* et PAT-005-003 porte sur la communication synchrone. Le prototype ne
   montre que des transmissions écrites (courriers). Rejoint **HR-001 H-VRB-001** (`Open`) : la
   transmission verbale est-elle hors Domain par construction, ou un concept à représenter ? Non
   tranché — signalé.
2. **Le nom lui-même est contesté par sa propre preuve.** WE-005 §9 recommande de *"réexaminer si le
   terme Clinical Coordination décrit correctement le phénomène"* et suggère un concept plus général
   centré sur la *circulation de l'information*. ADR-0020 n'a pas figé le nom ; personne ne l'a
   réexaminé depuis.
3. **Direction du flux.** Transmissions *reçues* et *envoyées* mélangées dans une même liste. Le
   "store de sortie" de la transmission est déjà noté ouvert ailleurs (ARCH-000, écart "Sens du flux
   de WS-005") — le prototype ne le résout pas.

## États

- Liste de transmissions peuplée — seul état construit.
- Aucune transmission — non construit.
- Transmission en attente de lecture vs lue — non distingué.

## Erreurs / cas limites non couverts

GAP-005-001 à 004 (WE-005 §6), tous ouverts : critère de décision de transmettre, ce qui est
réellement relu, déclencheur du passage au synchrone, comportement en organisation hospitalière.

## UX

Renvoi au prototype — mais c'est l'écran le moins mûr de tous ceux couverts par cette Phase 2 :
aucune action réelle, aucun Blueprint, aucune PDR, Evidence non conforme, nom contesté. À ne pas
lire comme une conception, mais comme un support de test pour les 3 rounds exigés par ADR-0020.

---

## Pré-requis avant Phase 3/4

Dans cet ordre, aucun n'est engagé par cette fiche :
1. Résoudre Finding-001 (Gate PAT + CWRM-030) **ou** mettre WE-005 en conformité ADR-0018 par une
   autre voie — sans quoi Gate 2 reste inatteignable.
2. Rédiger PDR-005 — dont trancher la tension *circulation entre acteurs* vs *suites personnelles*,
   et le nom.
3. Blueprint WS-005.
4. Premier des 3 rounds de test praticien exigés par ADR-0020.

---

## Relation avec « À traiter » — décision du 2026-10-06

- **Transmission** — `Product Decision` (seule composante V1, ADR-0020) : une transmission **reçue qui
  demande une action** du praticien apparaît dans **« À traiter »**, provenance Entrant / Transmission
  ([A-TRAITER-implementation](A-TRAITER-implementation.md)). L'écran Coordination garde l'**historique**
  des transmissions — il ne devient pas une seconde liste "à faire".
- **Avis, Délégation** — si un jour validés (ADR-0020 §4), une demande d'avis reçue ou une tâche
  déléguée produiraient naturellement un élément « À traiter ». **Noté, non construit** : ADR-0020 §2
  interdit toute fonctionnalité réelle tant qu'elles restent hypothèses. ADR-0020 non modifié.
- **Demande verbale d'un confrère** (cas d'interruption, HYP-003-005) — touche HR-001 H-VRB-001 et
  H-PND-001, tous deux `Open`. Pas une composante de WS-005 à ce stade.

## Requalification ADR-0025 (2026-10-06)

> Lecture [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md). WS-005 est le cas où
> la requalification change le moins : **le blocage porte sur le problème, pas sur la solution**
> (Finding-001, WE-005 fondé sur des PAT non conformes). ADR-0025 ne le lève pas. Avis et Délégation
> ont déjà leur critère d'abandon (ADR-0020 §4 : 3 rounds, sinon retrait) — pas de nouvelle fiche.
> "Majorité" = plus de la moitié des praticiens du round.

| HYP | Élément | Origine | Problème visé |
|---|---|---|---|
| 001 | Liste unique des transmissions reçues et envoyées | Founder-Driven (forme) | Transmission — Evidence, 5 profils (ADR-0020) ; WE-005 non conforme |
| 002 | Bouton "Demander un avis à un confrère" | Founder-Driven — sonde de test | Avis — `Unsupported` (ADR-0020) |
| — | Avis, Délégation (sections vides) | ADR-0020 | Critère d'abandon existant : ADR-0020 §4 |

```
HYP-005-001 — Liste unique reçues / envoyées
Hypothèse:          Une seule liste suffit à suivre ce qui circule, dans les deux sens
Risque si faux:     Confusion entre ce que j'attends et ce que j'ai à lire — le "store de sortie"
                    reste non défini (ARCH-000)
                    ; (2026-10-06) la liste devient une seconde collection "à faire", concurrente de
                    « À traiter »
Test:               "Qu'est-ce qui attend une action de votre part dans cette liste ?"
Critère d'abandon:  La majorité confond reçu et envoyé → deux listes distinctes
Statut:             ? ⚠ — À tester

HYP-005-002 — "Demander un avis"
Hypothèse:          Une affordance visible fait émerger un besoin d'avis que les entretiens n'ont pas
                    capté (Avis : 0 profil, question posée tardivement)
Risque si faux:     Une affordance suggère une fonctionnalité que le produit n'a pas l'intention de
                    construire
Test:               Le praticien clique-t-il ? Que s'attend-il à obtenir ?
Critère d'abandon:  Compté dans le garde-fou d'ADR-0020 §4 : pas de critère propre
Statut:             ? ⚠ — À tester (compte pour le round 1/3 d'ADR-0020)
```

**Hors HYP — décisions, pas tests** : la tension *circulation entre acteurs* vs *suites
personnelles* et le nom relèvent de PDR-005. Le lien WS-003 → WS-005 (§11 du Blueprint WS-003) est
une décision existante non implémentée, pas une hypothèse.

---

## Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-10-05 | Création — fiche d'implémentation Phase 2. Pas de Blueprint ni de PDR (PDR-005 jamais rédigé). **WS-005 identifié comme le cas où Finding-001 devient bloquant** (WE-005 repose sur les PAT non conformes). Tension relevée entre la question de recherche de WE-005 (circulation entre acteurs) et l'intention produit du bilan (suites personnelles). Lien WS-003 → WS-005 du Blueprint WS-003 absent du prototype. Transmission verbale absente (H-VRB-001). |
| 0.2 | 2026-10-06 | Requalification [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) : HYP-005-001 (liste reçues/envoyées), HYP-005-002 ("Demander un avis", compté dans le garde-fou d'ADR-0020). Le blocage Finding-001 porte sur le problème, pas sur la solution — non levé. |
| 0.3 | 2026-10-06 | Relation avec « À traiter » : une transmission reçue demandant une action y apparaît (provenance Transmission) ; Coordination reste l'historique. Avis/Délégation : conséquence notée, non construite (ADR-0020 non modifié). HYP-005-001 : risque de collection concurrente ajouté. |
