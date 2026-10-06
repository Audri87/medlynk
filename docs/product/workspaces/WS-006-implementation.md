# WS-006 — Fiche d'implémentation (Phase 2 — Freeze V1)

| Field | Value |
|---|---|
| ID | WS-006 |
| Nom | *"Je termine"* (WBD-004 v2.0) — affiché "Fin de journée" / "Terminer ma journée" dans le prototype |
| Statut | `Research Workspace` (GOV-000 §4) — **aucun Blueprint, aucun WE, aucune PDR** |
| Version | 0.5 |
| Date | 2026-10-05 |
| Sources | [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) (lecture des éléments non observés) · [WBD-004](WBD-004-consultation-vs-documentation.md) · [ADR-0024](../../adr/ADR-0024-ws004-nature-et-proof-set-m2.md) (entrée dans le proof set M2) · [AR-001](../../AR-001-architecture-review.md) Finding-003 · [CWRM-020-APX-M2-workspace-questionnaires](../../research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md) §6 · [WS-003](WS-003-consultation.md) §11 |
| Prototype | `WS-002-WS-003-parcours-v8.html`, section `#ws6` |

> Comme WS-005, WS-006 n'a pas passé Gate 2. Contrairement à WS-005, il n'est pas bloqué par
> Finding-001 (aucun PAT ne le fonde) — il est simplement **non instruit** : les ACT existent, la
> synthèse n'a jamais été faite.

---

## Statut au regard du proof set M2

ADR-0024 a intégré WS-006 au proof set M2. ADR-0022 §4 exige pour en sortir : Blueprint rédigé, au
moins un round praticien, une entrée Journal M2 par écart.

| Condition ADR-0022 §4 | État |
|---|---|
| Blueprint rédigé | ✗ |
| ≥ 1 round d'entretien praticien | ✗ — les 4 questions §6 n'ont jamais été posées |
| Entrée Journal M2 par écart | ✗ — aucune |

**0/3.** WS-006 est inclus dans le gel M2 depuis le 2026-09-08 sans qu'aucune condition de sortie
n'ait progressé. Ce n'est pas une faute — c'est la description exacte d'un `Research Workspace`.
Mais "WS-006 obligatoire en V1" (bilan d'octobre) ne doit pas être lu comme "WS-006 conçu".

---

## Objectif

Pas de Product Question formelle. Les questions de recherche existent (CWRM-020-APX-M2 §6) :
*"Comment savez-vous que votre journée est vraiment terminée ?"* · *"Qu'est-ce qui vous empêcherait de
partir tranquille, ce soir ?"* Intention produit du bilan : fermer la boucle quotidienne, *"une bonne
raison de revenir demain"*.

**Rôle — décision produit du 2026-10-06** (`Founder-Driven`, `→ (evidence: ?)`). WS-006 est un
**point de clôture du travail dans MedLink** : identifier ce qui reste ouvert, laisser le praticien
décider ce qui sera repris, le conserver dans **« À traiter »**
([A-TRAITER-implementation](A-TRAITER-implementation.md)) pour la reprise du lendemain. WS-006 **ne
possède pas** « À traiter » : il en affiche une vue filtrée.

« Terminer ma journée » ne signifie pas *"MedLink décide que votre journée est terminée"*, mais *"vous
avez terminé votre travail dans MedLink, et ce qui reste à traiter est conservé pour votre reprise"*.

## Entrée / Sortie

- **Entrée** : sidebar "🌙 Terminer ma journée" (5 écrans). Aucune autre.
- **Sortie** : "Terminer ma journée" → écran de confirmation (*"Travail enregistré — N éléments
  conservés dans À traiter"*, depuis 2026-10-06) → Mon Espace. "Reprendre" (consultation
  en pause) → WS-003 Recovery. "Ouvrir" (Michel Rousseau, élément à traiter) → WS-002.

## Actions (réelles vs décoratives)

- **Réelles** : Terminer ma journée, Reprendre (si `consultationPaused`), Ouvrir (Michel Rousseau),
  cases à cocher "Avant de partir" (cochables, sans effet).
- **Décoratives** : "Ouvrir" (Sophie Martin), tuiles, statistiques.

## Données — chaque bloc confronté au corpus

Il n'y a pas de Blueprint : la première question est *quel bloc repose sur quoi ?* (Question A —
Evidence, ADR-0025 §6). La colonne "Force" ne dit **que** cela — elle ne juge pas la valeur du bloc.
La Question B (Design) et le sort de chaque bloc sont traités dans la section suivante.

| Bloc du prototype | Ancrage corpus | Force |
|---|---|---|
| **Consultations encore ouvertes** | ACT-F007-025, verbatim : *"Que tous les dossiers sont fermés."* + WS-003 §11 (rappel de fin de journée attribué explicitement à WS-006, PP-014) | **Le mieux fondé** — verbatim direct + décision existante d'un autre Blueprint |
| **À reporter à demain** | ACT-F009-033, verbatim : *"Les tâches qui restent seront reprises le lendemain."* | Le *fait* du report est attesté (1 profil). **Où il est retrouvé** = Finding-003, `Open` |
| **Avant de partir** (matériel, sauvegarde, tour du cabinet) | ACT-F001-024 → 026 | **Faible** — un seul profil, **synthèse rapportée**, aucun verbatim |
| Éléments à traiter (tableau) | Aucun ancrage propre à la fin de journée | Sans ancrage + doublon → HYP-006-004 |
| Rendez-vous à planifier | Aucun | Sans ancrage → HYP-006-005 |
| Tuiles d'état | Aucun | Sans ancrage → HYP-006-006 |
| Statistiques de la journée | Aucun | Sans ancrage → HYP-006-007 |

### Un contre-signal à ne pas ignorer

ACT-F001-027, **verbatim direct** : *"Ma journée est vraiment terminée quand je sors la porte du
cabinet."* Le critère de fin de journée exprimé par ce praticien est **physique, pas logiciel**. Ce
n'est pas une réfutation de WS-006 — un seul profil — mais c'est la seule réponse verbatim existante à
la question centrale de WS-006, et elle ne pointe pas vers un écran. Lecture ADR-0025 : ce
contre-signal ne justifie pas un retrait anticipé. Il était le critère d'abandon de l'écran (v0.2) ; **depuis le
2026-10-06, c'est une contrainte respectée** : WS-006 ne prétend plus déterminer la fin de la journée,
il clôt le travail *dans MedLink*. Le praticien peut considérer sa journée terminée à la porte du
cabinet ; WS-006 ne le contredit pas.

---

## Requalification ADR-0025 — chaque élément comme hypothèse testable

> WS-006 dans son ensemble est une **innovation produit** : le terrain atteste des frictions de fin
> de journée (dossiers non fermés, tâches reportées, routine de départ), pas le besoin d'un écran
> dédié. *"Fermer cognitivement sa journée"* est une solution MedLink, pas une observation.
> Format : GOV-000 §1bis v1.9. Critères d'abandon déclarés **avant** le round v8. "Majorité" =
> plus de la moitié des praticiens du round.

### Synthèse

| HYP | Élément | Origine | Problème visé | Preuve | Statut |
|---|---|---|---|---|---|
| 000 | L'écran "Fin de journée" — clôture du travail dans MedLink | Founder-Driven | ACT-F007-025, F009-033, F001-024→026 | `?` ⚠ (F001-027 = contrainte respectée) | À tester — reformulée 2026-10-06 |
| 001 | Consultations encore ouvertes | Evidence-Driven (contenu) / Founder-Driven (forme) | ACT-F007-025 + WS-003 §11 / PP-014 | `✓` 1 profil | À tester (forme) |
| 002 | À reporter à demain → geste « Garder pour demain » | Founder-Driven | ACT-F009-033 | `✓` 1 profil (fait) · `→ (evidence: ?)` (reprise via « À traiter ») | À tester — mise à jour 2026-10-06 |
| 003 | Avant de partir | Founder-Driven | ACT-F001-024→026 (synthèse rapportée) | `?` | À tester |
| 004 | Éléments à traiter | Founder-Driven | Aucun ancrage propre — à documenter | `→` | **Résolue par décision, 2026-10-06** — vue filtrée de « À traiter » |
| 005 | Rendez-vous à planifier | Founder-Driven | Aucun ancrage — à documenter | `?` | À tester — si conservé, type de « À traiter » |
| 006 | Tuiles d'état | Founder-Driven | Aucun ancrage — à documenter | `?` | À tester |
| 007 | Statistiques de la journée | Founder-Driven | Aucun ancrage — à documenter | `?` | À tester |

Conformément à RG-001, les HYP 004 à 007 restent autorisées en prototype mais ne peuvent pas devenir
PDX tant que leur friction n'est pas documentée.

### HYP-006-000 — L'écran "Fin de journée" (reformulée 2026-10-06)

**Pourquoi le critère d'abandon change.** L'ancien critère retirait l'écran si *"la majorité situe la
fin de journée hors du logiciel (type F001-027) ET déclare ne pas ouvrir cet écran spontanément"*. La
première moitié n'est plus une réfutation : l'hypothèse reformulée **accepte** que la journée se
termine à la porte du cabinet — WS-006 ne prétend plus la déterminer. Garder cette condition testerait
une hypothèse abandonnée. La seconde moitié (ouverture spontanée) reste pertinente et est conservée.
Une condition est ajoutée : comme « À traiter » conserve tout ce qui reste ouvert, même sans clôture
(CAL-I-007), la clôture peut n'apporter aucune valeur — c'est désormais le vrai test.

```
Origine:            Founder-Driven
Problème visé:      Fin de journée incomplète — dossiers non fermés (ACT-F007-025), tâches reprises
                    le lendemain (ACT-F009-033), routine de départ (ACT-F001-024→026)
Hypothèse:          Un acte explicite de clôture du travail DANS MEDLINK — passer en revue ce qui
                    reste ouvert, décider ce qui sera repris — a de la valeur, même si tout reste
                    conservé de toute façon dans « À traiter »
Valeur attendue:    Partir en sachant que rien n'est perdu ; reprise du lendemain préparée par une
                    décision, pas par un empilement
Risque si faux:     Un rituel de plus dans une journée déjà saturée ; écran ignoré ; sentiment d'être
                    évalué par le logiciel
Contrainte:         ACT-F001-027 — la journée peut se terminer hors du logiciel. WS-006 ne le contredit
                    pas : aucun texte ne déclare la journée terminée à la place du praticien
Test:               Questions §6 (CWRM-020-APX-M2) + "Ouvririez-vous cet écran sans qu'on vous le
                    demande ? À quel moment ?" + le lendemain (scénario) : "Vous a-t-il manqué
                    quelque chose de ne pas être passé par cet écran ?"
Critère d'abandon:  La majorité n'ouvre pas l'écran spontanément (conservé), OU retrouve son travail le
                    lendemain dans « À traiter » sans être passée par la clôture et n'y voit aucun
                    manque (ajouté) → écran retiré ; « À traiter » suffit ; le rappel des
                    consultations ouvertes (PP-014) est porté par le compteur de Mon Espace
Statut:             ? ⚠ — À tester (round v8)
Historique:         v0.2 (2026-10-05) — "Un moment explicite de clôture permet au praticien de partir
                    en sachant que rien n'est oublié" ; abandon si fin de journée hors logiciel ET
                    pas d'ouverture spontanée
```

### HYP-006-001 — Consultations encore ouvertes

```
Origine:            Evidence-Driven pour le besoin (rappel attribué à WS-006 par WS-003 §11, PP-014)
                    · Founder-Driven pour la forme (tableau en fin de journée)
Problème visé:      "Que tous les dossiers sont fermés" (ACT-F007-025, verbatim)
Hypothèse:          Lister les consultations non clôturées au moment du départ évite la perte silencieuse
                    d'un brouillon (CAL-I-007)
Valeur attendue:    Aucun dossier laissé ouvert sans le savoir
Risque si faux:     Faible — au pire, information redondante si le praticien clôture toujours en direct
Test:               "Vous arrive-t-il de partir avec une consultation non terminée ? Comment le
                    savez-vous aujourd'hui ?"
Critère d'abandon:  Si HYP-006-000 est abandonnée, ce bloc n'est pas retiré mais déplacé (le besoin
                    est porté par PP-014). Retiré seulement si la majorité déclare ne jamais laisser de
                    consultation ouverte
Statut:             ? ⚠ — À tester (forme) · besoin `✓` 1 profil
```

### HYP-006-002 — À reporter à demain → « Garder pour demain » (mise à jour 2026-10-06)

```
Origine:            Founder-Driven
Problème visé:      "Les tâches qui restent seront reprises le lendemain" (ACT-F009-033, verbatim)
Hypothèse:          Marquer explicitement un élément de « À traiter » comme "gardé pour demain" aide à
                    le reprendre sans effort de mémoire, mieux qu'une simple persistance
Valeur attendue:    Continuité entre deux journées
Risque si faux:     Liste tenue en double (papier, agenda) ; le praticien ne distingue pas "gardé pour
                    demain" de "simplement en attente" (ajouté 2026-10-06)
Test:               Les 4 questions §6, en particulier "Les tâches reportées, vous les retrouvez où le
                    lendemain ?" — test de la décision du 2026-10-06 (Finding-003 annoté, reste Open)
Critère d'abandon:  La majorité retrouve ses reports dans un autre outil et ne souhaite pas en changer
                    → geste retiré. La majorité ne distingue pas "gardé pour demain" de "en attente"
                    (ajouté) → geste retiré, tout reste simplement dans « À traiter »
Statut:             ? ⚠ — À tester
Mise à jour:        Le lieu de reprise est décidé (« À traiter », signalé par Mon Espace) —
                    Founder-Driven, evidence ?. Le bloc ne possède plus de liste propre : c'est un
                    geste appliqué aux éléments de « À traiter »
```

### HYP-006-003 — Avant de partir

```
Origine:            Founder-Driven
Problème visé:      Routine de départ — ACT-F001-024 (matériel), 025 (sauvegarde informatique
                    quotidienne), 026 (tour du cabinet) : 1 profil, synthèse rapportée, aucun verbatim
Hypothèse:          Une courte liste de vérifications réduit l'oubli d'une tâche non clinique ; et la
                    friction "sauvegarde" (025), propre à un logiciel local, disparaît dans MedLink —
                    l'afficher comme acquise rassure au lieu de demander une action
Valeur attendue:    "Partir tranquille"
Risque si faux:     Bruit non clinique dans un outil clinique
Test:               "Qu'est-ce qui vous empêcherait de partir tranquille, ce soir ?" — sans montrer la
                    liste d'abord ; puis réaction à la ligne "Dossiers enregistrés automatiquement"
Critère d'abandon:  Aucun praticien du round ne cite spontanément une vérification de départ, ou les
                    éléments cités ne relèvent pas du logiciel → bloc retiré
Statut:             ? ⚠ — À tester
Corrigé (v0.3):     "Sauvegarder les dossiers du jour" (case à cocher) laissait croire que MedLink ne
                    sauvegarde pas → remplacé par une information "Dossiers enregistrés
                    automatiquement — aucune sauvegarde à faire"
```

### HYP-006-004 — Éléments à traiter

```
Origine:            Founder-Driven
Problème visé:      Aucun ancrage propre à la fin de journée — à documenter
Hypothèse:          Voir ce qui reste ouvert avant de partir évite de découvrir une urgence le lendemain
Valeur attendue:    Pas de résultat critique non lu au départ
Risque si faux:     Troisième affichage de la même liste (tuile Mon Espace, écran "À traiter", ce
                    tableau) — charge cognitive accrue, contraire à la Mission
Test:               Aucun avant décision : la question de propriété est une décision produit, pas une
                    question de terrain
Critère d'abandon:  Si la décision de propriété attribue les éléments à traiter à l'écran "À traiter",
                    ce tableau devient un simple compteur avec lien
Statut:             → Résolue par décision, 2026-10-06 — pas abandonnée. Le tableau est une vue
                    filtrée de « À traiter » (éléments du jour encore ouverts), à des fins de revue ;
                    il ne possède rien. Le risque "troisième affichage" est levé par la propriété
                    unique, pas par la suppression
```

### HYP-006-005 — Rendez-vous à planifier

```
Origine:            Founder-Driven
Problème visé:      Aucun ancrage — à documenter
Hypothèse:          Les rendez-vous de suivi décidés en consultation mais non encore posés se perdent
Valeur attendue:    Suivi patient non perdu
Risque si faux:     Bloc toujours vide (seul état construit aujourd'hui)
Test:               "Après une consultation, qui pose le prochain rendez-vous, et quand ?"
Critère d'abandon:  Le rendez-vous est posé pendant la consultation ou par un secrétariat pour la
                    majorité du round → bloc retiré
Statut:             ? ⚠ — À tester. Si conservé (2026-10-06) : un TYPE d'élément de « À traiter »,
                    pas une liste propre à WS-006
```

### HYP-006-006 — Tuiles d'état

```
Origine:            Founder-Driven (maquette externe, 2026-10-04)
Problème visé:      Aucun ancrage — à documenter
Hypothèse:          Un résumé chiffré permet de juger en un coup d'œil si la journée est "propre"
Valeur attendue:    Lecture plus rapide que les tableaux
Risque si faux:     Redondance avec les tableaux et avec les statistiques
Corrigé (v0.3):     Incohérence tuile "7 consultations terminées" / statistique "6 consultations
                    réalisées" — la statistique reprend désormais le libellé et la valeur câblée de la
                    tuile (updateWS6State)
Test:               Observation : le praticien lit-il les tuiles ou va-t-il directement aux tableaux ?
Critère d'abandon:  La majorité ignore les tuiles ou les juge redondantes → tuiles retirées
Statut:             ? ⚠ — À tester
```

### HYP-006-007 — Statistiques de la journée

```
Origine:            Founder-Driven
Problème visé:      Aucun ancrage — à documenter
Hypothèse:          Voir ce qui a été accompli donne un sentiment de clôture et une raison de revenir
Valeur attendue:    Satisfaction de fin de journée
Risque si faux:     Métrique perçue comme une mesure de productivité ou de surveillance ; quantification
                    du soin contraire à la posture du produit
Test:               "Que vous inspirent ces chiffres ?" — réaction spontanée
Critère d'abandon:  Réaction neutre ou négative pour la majorité → bloc retiré
Statut:             ? ⚠ — À tester
```

## Règles

Aucune règle propre à WS-006 n'existe (pas de PP). Règles héritées :
- **PP-014 (WS-003)** : WS-006 doit exposer les consultations non fermées — ✓ respecté.
- **Finding-003** : la consigne "ne pas construire la reprise avant le round" est remplacée le 2026-10-06 par une
  décision produit Founder-Driven (reprise via « À traiter ») ; Finding-003 reste `Open`, annoté, et le
  round §6 devient le test de cette décision.
- **Propriété unique de « À traiter »** (2026-10-06) : WS-006 affiche, filtre, transfère — ne possède
  pas.
- **ADR-0025** : chaque élément non observé porte une fiche HYP avec critère d'abandon — ✓ (section
  ci-dessus).

## Doublon — tranché le 2026-10-06

"Éléments à traiter" apparaissait **à trois endroits** non réconciliés (tuile de Mon Espace, écran "À
traiter", tableau de WS-006). Décision produit : **un seul propriétaire, l'écran « À traiter »**
([A-TRAITER-implementation](A-TRAITER-implementation.md)). La tuile de Mon Espace est un compteur ; le
tableau de WS-006 est une vue filtrée pour la revue de fin de journée.

## États

- Consultation en pause / aucune consultation en pause — les deux construits, réellement câblés.
- Journée sans aucun élément ouvert (vraie fin propre) — non construit pour les autres blocs.

## Erreurs / cas limites non couverts

- Plusieurs consultations en pause — `consultationPaused` est un booléen unique (limite connue).
- **Corrigé le 2026-10-06** : la ligne « Consultations encore ouvertes » restait masquée en permanence —
  une consultation en pause n'y apparaissait jamais, et HYP-006-001 était intestable. Elle s'affiche
  désormais pour toute consultation ouverte, en pause (« Reprendre ») ou en cours (« Retourner »),
  conformément à PP-014.
- Le praticien ferme sa journée avec un brouillon non validé — couvert par décision (2026-10-06) : le
  brouillon reste dans « À traiter », provenance Consultation (CAL-I-007). Dépend de la persistance réelle
  du Brouillon (H-ES-001, `Open`).
- Frontière avec le lendemain — décidée (Founder-Driven) ; **Finding-003** reste `Open — Empirical
  Resolution Required`, annoté.
- Écriture des décisions de revue ("garder pour demain", "fait") — source de vérité non définie,
  HR-001 **H-PND-001**, `Open`.

## UX

Renvoi au prototype. La mise en page actuelle (tuiles, tableaux, statistiques) vient d'une maquette
externe ; deux blocs sur sept ont un ancrage verbatim. Les autres ne sont pas "non fondés" : ce sont
des hypothèses de conception (HYP-006-003 à 007), chacune avec son test et son critère d'abandon.
Les deux corrections indépendantes du test (incohérence 7/6, libellé "Sauvegarder") sont faites
(v0.3).

---

## Pré-requis avant Phase 3/4

1. Round praticien posant les 4 questions §6 **et les tests des fiches HYP-006-000 à 007** — teste la
   décision du 2026-10-06 (Finding-003), conclut chaque HYP.
2. Synthèse WE-006 à partir de ACT-F001-024→027, ACT-F007-025, ACT-F009-033 + résultats du round.
3. Propriété des "éléments à traiter" — tranchée le 2026-10-06 (voir Doublon).
4. Blueprint WS-006 — première des trois conditions ADR-0022 §4.

---

## Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-10-05 | Création — fiche d'implémentation Phase 2. `Research Workspace`, 0/3 conditions de sortie ADR-0022 §4. Chaque bloc du prototype confronté au corpus : 2/7 ancrés en verbatim (consultations ouvertes, report), 1 faible (checklist, synthèse rapportée), 4 sans ancrage. Contre-signal F001-027 (critère de fin de journée physique, pas logiciel) relevé. "Éléments à traiter" présent à trois endroits non réconciliés. |
| 0.2 | 2026-10-05 | Requalification [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) — premier cas d'application. Les blocs qualifiés "Non fondé" en v0.1 deviennent des hypothèses testables : 8 fiches HYP-006-000 à 007 (l'écran lui-même + 7 blocs), Origine et preuve séparées, critère d'abandon déclaré avant le round v8. Le contre-signal F001-027 devient le critère d'abandon de l'écran. HYP-006-004 bloquée par décision (propriété des éléments à traiter), pas par un test. Deux corrections indépendantes du test relevées : incohérence 7/6 consultations, libellé "Sauvegarder les dossiers du jour". |
| 0.3 | 2026-10-06 | Corrections prototype : statistique alignée sur la tuile câblée (7/6 selon `consultationPaused`) ; "Sauvegarder les dossiers du jour" remplacé par une information (sauvegarde automatique). HYP-006-003 précisée : la sauvegarde est observée (ACT-F001-025) mais propre à un logiciel local — friction supprimée par conception, pas une tâche à rappeler. |
| 0.4 | 2026-10-06 | Décisions produit du 2026-10-06. Rôle : point de clôture du travail dans MedLink, transfert vers « À traiter », pas propriétaire. **HYP-006-000 reformulée** — critère d'abandon modifié et justifié (la condition "fin de journée hors logiciel" n'est plus une réfutation ; condition "aucun manque sans clôture" ajoutée) ; F001-027 devient une contrainte respectée. HYP-006-002 → geste « Garder pour demain », critère ajouté. HYP-006-004 résolue par décision (pas abandonnée). HYP-006-005 : type de « À traiter » si conservé. Doublon tranché. Brouillon non validé en fin de journée couvert ; écriture des décisions de revue → HR-001 H-PND-001. |
| 0.5 | 2026-10-06 | Correction prototype : la ligne « Consultations encore ouvertes » n'était jamais affichée (bug préexistant). Elle couvre désormais toute consultation ouverte, en pause ou en cours (`consultationOpen`). HYP-006-001 devient testable. |
