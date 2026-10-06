# WS-001 — Morning Brief Blueprint

| Field | Value |
|---|---|
| ID | WS-001 |
| Version | 0.4 |
| Status | **VALIDATED FOR PROTOTYPING** |
| Lifecycle | ☐ Discovery · ☑ Blueprint · ☐ Prototype · ☐ User Test · ☐ Production |
| Date | 2026-08-04 |
| Sprint | Sprint 0 |
| Depends on | PAT-M-001, PAT-M-002, PAT-M-003 · PP-001, PP-002, PP-003, PP-004 |
| Wireframe | [wireframe-WS-001-v0.1.md](wireframe-WS-001-v0.1.md) |
| Device policy | Device-independent — same concept on mobile, tablet, desktop |

---

## 1. Product Question

**Q-001 — Puis-je commencer sereinement ma journée ?**

Cette question est la raison d'être du Workspace.

---

## 2. Evidence

### Patterns (≈)

| ID | Énoncé | Statut |
|---|---|---|
| PAT-M-001 | Signal precedes Horizon — tout praticien cherche les changements avant le planning | ≈ |
| PAT-M-002 | Preparation follows Uncertainty — la préparation est déclenchée par l'incertitude, pas le temps | ≈ |
| PAT-M-003 | Context reconstruction is fragmented — plusieurs outils sont nécessaires aujourd'hui | ≈ |

### Observations confirmées

| ID | Observation | Statut |
|---|---|---|
| OBS-M-001 | Le praticien recherche les changements avant de consulter son planning | ✓ |
| OBS-M-002 | Le début de journée est structuré entre Signal et Horizon | ✓ |
| OBS-M-003 | La reprise de contexte peut commencer avant l'arrivée au cabinet | ✓ |
| OBS-M-004 | La préparation détaillée dépend du besoin de reconstruire le contexte | ✓ |
| OBS-M-005 | Plusieurs praticiens consacrent une partie du début de journée à des obligations non cliniques | ✓ |

---

## 3. Product Principles

| Principe | Énoncé | Source |
|---|---|---|
| PP-001 | Signal precedes Horizon — afficher les changements avant le planning | PAT-M-001 |
| PP-002 | Preparation follows Uncertainty — aider davantage quand le contexte est moins présent | PAT-M-002 |
| PP-003 | One Morning Entry Point — un seul outil pour la reprise de contexte matinale | PAT-M-003 *(hypothèse — à valider)* |
| PP-004 | Administrative obligations SHALL NOT dominate clinical preparation | OBS-M-005 |

---

## 4. Cognitive Transition

```
PERDU (no context)
    ↓
Reprise de contexte
    ↓
ORIENTÉ
    ↓
Prêt à commencer
```

Le Morning Brief ne décide rien. Il réduit le coût de cette transition.

---

## 5. User Outcome

À la fermeture du Morning Brief, le praticien doit pouvoir dire :

> "Je sais ce qui a changé, je sais ce qui m'attend, je peux commencer."

---

## 6. Information Architecture

Trois blocs, ordonnés par les Product Rules. Chaque bloc répond à une question.

### Bloc 1 — Signals

**Question :** Qu'est-ce qui a changé ?

Contenu :
- Résultats reçus
- Messages non lus (cliniques)
- Examens disponibles
- Annulations ou modifications
- Événements inattendus (hospitalisations, urgences)

Comportement : toujours visible. Jamais collapsed. État vide = "Rien de nouveau."

### Bloc 2 — Today's Horizon

**Question :** Qu'est-ce qui m'attend aujourd'hui ?

Contenu :
- Nombre de patients
- Compte à rebours premier rendez-vous
- Liste du jour : heure · nom · type (nouveau / suivi)
- Indicateur préparation recommandée (PR-002)

Comportement : visible par défaut, sous le Bloc Signal.

### Bloc 3 — Obligations

**Question :** Qu'est-ce que je dois traiter aujourd'hui ?

Contenu :
- Télétransmissions en attente
- Prescriptions à valider
- Documents à compléter
- Tâches administratives

Comportement : **collapsed par défaut** (PR-004). Une interaction révèle le bloc.

---

## 7. Explicit Non-Goals

Le Morning Brief n'est pas :

- un agenda complet ;
- une messagerie ;
- un tableau de bord administratif ;
- un outil d'aide à la décision clinique.

Son objectif est uniquement la reprise de contexte matinale.

---

## 8. Success Metrics

| Métrique | Nature | Baseline requis |
|---|---|---|
| Temps pour atteindre un état de préparation | Comportemental | Oui |
| Nombre d'outils ouverts avant la première consultation | Comportemental | Oui |
| Temps consacré à la reconstruction du contexte | Comportemental | Oui |
| Sentiment de maîtrise de la journée | Qualitatif | Test utilisateur |
| Signaux importants découverts seulement pendant une consultation | Indicateur de défaillance | Oui |

> La baseline doit être mesurée avec les outils actuels avant tout test du Morning Brief.

---

## 9. Open Questions

| # | Question | Impact | Status |
|---|---|---|---|
| OQ-001 | Durée moyenne de la préparation matinale avec les outils actuels ? | Baseline metrics | Open |
| OQ-002 | Les praticiens souhaitent-ils clôturer explicitement ("Je suis prêt") ou passent-ils naturellement ? | Interaction design | Open |
| OQ-003 | Quelle quantité de signaux reste lisible avant de créer une surcharge ? | Signal taxonomy | Open |
| OQ-004 | Les priorités diffèrent-elles significativement selon les professions ? | Segmentation | Open |
| OQ-005 | Un signal peut-il être dismissé ou snoozé ? Qui décide du niveau d'urgence ? | Signal taxonomy | Open |

---

## 10. Fiche d'implémentation (Phase 2 — Freeze V1, 2026-10-05)

> Couche ajoutée au-dessus du Blueprint Discovery ci-dessus (§1-9, inchangé). Ne redécide rien —
> traduit ce qui est déjà validé/hypothèse en dimensions directement actionnables pour l'engineering.
> Statut global : **non implémenté côté produit réel** — "Mon espace" du prototype
> (`WS-002-WS-003-parcours-v8.html`) couvre une partie de ce territoire (planning, tuiles, "À votre
> attention") mais n'a jamais été construit *comme* WS-001/Morning Brief explicitement ; voir §Écart
> ci-dessous.

**Objectif.** Inchangé — Q-001, §1.

**Entrée.** Point d'entrée quotidien, avant tout autre Workspace — pas de navigation "depuis" un autre
écran, c'est l'écran de connexion/accueil. Dans le prototype actuel, ce rôle est occupé par `#dash`
("Mon espace"), atteint par défaut (`show('dash')` au chargement) ou depuis n'importe quelle sidebar.

**Sortie.** Vers WS-002 (ouvrir un patient), WS-005/WS-006 (sidebar), ou sortie du logiciel. Aucune
sortie ne doit être bloquante (§7, Non-Goals — ce n'est pas un gate obligatoire).

**Actions (réelles vs décoratives, vérifié contre le prototype).** Sur `#dash` aujourd'hui : *réelles*
— "Rechercher" (`show('search')`), "Terminer ma journée" (`show('ws6')`), "Reprendre" (consultation en
pause, conditionnel), ouvrir Michel Rousseau. *Décoratives* — "Planning", "Nouveautés", "Messages",
navigateur de date, tous les boutons "Ouvrir" sauf Michel Rousseau. Cet écart (beaucoup de décoratif)
est documenté comme tel depuis la review de "Mon espace" — pas un oubli de cette fiche.

**Données nécessaires (déduites de §6 Information Architecture).**
- Bloc Signals : résultats reçus, messages cliniques non lus, examens disponibles, annulations/modifs,
  événements inattendus — **aucun n'existe comme donnée réelle dans le prototype actuel**, qui mélange
  planning et attention dans deux blocs différents (tuiles + "À votre attention"), pas sous la forme
  Signal/Horizon/Obligations de ce Blueprint.
- Bloc Horizon : nombre de patients, countdown premier RDV, liste heure/nom/type — **partiellement
  couvert** par "Patients du jour", sans countdown.
- Bloc Obligations : télétransmissions, prescriptions à valider, documents à compléter — **non
  distingué** dans le prototype, mélangé aux "Éléments à traiter" (écran `todo`, construit après coup,
  jamais rapproché explicitement de ce Blueprint avant cette fiche). **Décision 2026-10-06** : le Bloc
  Obligations *est* une vue de « À traiter ». Dans Mon espace, il se réduit à « À traiter [N] » + accès,
  replié par défaut (PP-004). §6 n'est pas réécrit ; la correspondance est notée ici.

**Règles (dérivées de PP-001 à PP-004, reformulées vérifiables).**
- R1 (PP-001) : le bloc Signal doit être rendu avant le bloc Horizon dans l'ordre de lecture — jamais
  l'inverse.
- R2 (PP-002) : le niveau de détail de préparation proposé doit croître avec l'absence de contexte
  préalable (patient jamais vu > patient vu récemment) — non implémenté, aucune donnée de "dernière
  visite" utilisée pour moduler quoi que ce soit dans le prototype actuel.
- R3 (PP-003, hypothèse non validée) : un seul point d'entrée matinal. Était en tension directe avec le
  prototype — **levée par décision produit du 2026-10-06** : Mon espace reste **le** point d'entrée ;
  « À traiter » est une destination (collection unique, [A-TRAITER-implementation](A-TRAITER-implementation.md)),
  pas un second point d'entrée ; WS-006 est un point de fin de journée, hors du champ matinal de PP-003.
  PP-003 n'est pas amendé et reste une hypothèse.
- R4 (PP-004) : le bloc Obligations est `collapsed` par défaut, ne doit jamais dominer visuellement les
  deux autres blocs.

**États.** Vide (*"Rien de nouveau"*, §6 Bloc 1) — jamais testé dans le prototype actuel (toujours au
moins un signal affiché). Chargement — non spécifié. Erreur de chargement — non spécifié.

**Erreurs / cas limites non couverts aujourd'hui.**
- Plus d'un signal "important" simultané — pas de hiérarchisation définie (OQ-003, toujours `Open`).
- Snooze/dismiss d'un signal (OQ-005, toujours `Open`) — aucune interaction de ce type dans le
  prototype.
- Tâches reportées de la veille (WS-006) — **décision 2026-10-06** : retrouvées via « À traiter [N] »,
  `→ (evidence: ?)` Founder-Driven. AR-001 Finding-003 reste `Open — Empirical Resolution Required` (annoté) :
  les 4 questions §6 deviennent le test de cette décision. Indice à ne pas perdre : la biologiste
  (session 4, OBS-M2-005) *"je regarderai mon planning [...] puis les éléments en suspens"* — le
  compteur ne doit pas passer devant le planning sans test.

**UX.** Renvoi au prototype — mais avec un écart à traiter avant Phase 3/4 : *"Mon espace"* du
prototype **n'est pas une traduction fidèle de ce Blueprint**. Il a dérivé vers un format
dashboard/tuiles (inspiré d'une maquette externe, 2026-10-03/04) plutôt que vers la structure
Signal/Horizon/Obligations à trois blocs définie ici. Aucun des deux n'est "faux" — mais ce sont deux
conceptions différentes du même Workspace, jamais réconciliées. **Ne pas lire le prototype actuel
comme une implémentation validée de ce Blueprint.**

### Requalification ADR-0025 (2026-10-06)

> Lecture [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) / GOV-000 §1bis v1.9.
> Les PP-001 à PP-004 restent les décisions en vigueur (`→`). Les éléments de "Mon espace" qui ne les
> traduisent pas ne sont ni "faux" ni "non fondés" : ce sont des hypothèses, chacune avec son critère
> d'abandon. Quand un élément contredit un PP, **le PP reste normatif** ; le critère d'abandon de
> l'hypothèse est le retour au PP. "Majorité" = plus de la moitié des praticiens du round.

| HYP | Élément de Mon espace | Origine | Problème visé | Relation au Blueprint |
|---|---|---|---|---|
| 000 | Format dashboard (au lieu de Signal/Horizon/Obligations) | Founder-Driven | Q-001 (PAT-M-001, PAT-M-003) | Alternative à §6 |
| 001 | Tuiles d'état du cabinet en tête | Founder-Driven | OBS-M-005 | ⚠ tension PP-001, PP-004 |
| 002 | "Continuité de travail" (consultation interrompue) | Founder-Driven (forme) | PP-011 (WS-003) | Hors Blueprint, cohérent |
| 003 | "À votre attention" en colonne séparée | Evidence-Driven (contenu) / Founder-Driven (forme) | PAT-M-001 | Traduit PP-001 ; ⚠ OBS-M2-011 |
| 004 | Pastilles sur les patients du jour | Founder-Driven | PP-002, PAT-M-001 | Doublon possible avec 003 |
| 005 | Navigateur de date, "Ajouter un rendez-vous", "Voir plus" | Founder-Driven | Aucun ancrage — à documenter | ⚠ tension §7 (*"pas un agenda complet"*) |
| 006 | Accès rapides | Founder-Driven | Aucun ancrage — à documenter | Hors Blueprint |

```
HYP-001-000 — Format dashboard
Hypothèse:          Le format "Mon espace" répond à Q-001 aussi bien que la structure à trois blocs
Risque si faux:     Le praticien voit beaucoup de choses mais ne sait pas ce qui a changé
Test:               Après 30 s sur l'écran, demander : "Qu'est-ce qui a changé depuis hier ? Qu'est-ce
                    qui vous attend ?" — critère User Outcome §5
Critère d'abandon:  La majorité ne sait pas dire ce qui a changé → retour à la structure §6
                    (Signal / Horizon / Obligations)
Statut:             ? ⚠ — À tester

HYP-001-001 — Tuiles d'état en tête
Hypothèse:          Une vue chiffrée du cabinet entier oriente avant la liste des patients
Risque si faux:     Les obligations dominent la préparation clinique (contraire à PP-004) ; le signal
                    n'arrive plus en premier (contraire à PP-001)
Test:               Où le regard va-t-il en premier ? Les tuiles sont-elles citées dans la réponse à
                    HYP-001-000 ?
Critère d'abandon:  La majorité ne les utilise pas, ou dit qu'elles retardent l'accès aux patients →
                    tuiles déplacées sous le planning ou repliées (PP-004)
Statut:             ? ⚠ — À tester

HYP-001-002 — Continuité de travail
Hypothèse:          Une consultation interrompue doit être reprise avant toute autre chose
Risque si faux:     Faible — bloc absent quand rien n'est interrompu
Test:               Scénario : consultation mise en pause, retour sur Mon espace — le praticien
                    retrouve-t-il la reprise sans aide ?
Critère d'abandon:  La majorité ne voit pas le bloc → déplacement, pas retrait (le besoin est porté par
                    PP-011)
Statut:             ? ⚠ — À tester (forme)

HYP-001-003 — "À votre attention" séparée du planning
Hypothèse:          Isoler ce qui a changé le rend plus visible que de le mêler au planning
Risque si faux:     Ambiguïté déjà observée (OBS-M2-011, 1 profil : *"on sait pas si c'est quelque
                    chose en plus"*)
Test:               "Ce bloc contient-il des patients en plus de ceux du planning ?"
Critère d'abandon:  L'ambiguïté OBS-M2-011 se reproduit pour la majorité → bloc fusionné dans le
                    planning via les pastilles (HYP-001-004)
Mise à jour:        (2026-10-06) "À votre attention" est un SIGNAL (ce qui a changé — AttentionProvider),
                    « À traiter » une ACTION (ce qui reste à faire — WorkItemProvider). Le lien "Voir
                    tous les éléments à traiter →" depuis ce bloc mélange les deux. Risque ajouté :
                    l'ambiguïté OBS-M2-011 peut s'étendre à trois blocs (planning / attention / à traiter)
Statut:             ? ⚠ — À tester

HYP-001-004 — Pastilles sur les patients du jour
Hypothèse:          Un signal posé sur la ligne du patient indique où se préparer (PP-002)
Risque si faux:     Le même signal est affiché deux fois (pastille + "À votre attention")
Test:               Lié à HYP-001-003 — lequel des deux le praticien utilise-t-il ?
Critère d'abandon:  Conserver celui des deux que la majorité utilise, retirer l'autre
Statut:             ? ⚠ — À tester (couplé à 003)

HYP-001-005 — Navigation de date et ajout de rendez-vous
Hypothèse:          Le praticien veut préparer les jours suivants depuis Mon espace
Risque si faux:     Mon espace devient un agenda, ce que §7 exclut ; doublon avec l'outil d'agenda
                    existant du cabinet
Test:               "Où gérez-vous vos rendez-vous aujourd'hui ? Changeriez-vous ?"
Critère d'abandon:  La majorité garde son outil d'agenda → retour à "aujourd'hui seulement". Si
                    validé : §7 (Non-Goals) à amender formellement
Statut:             ? ⚠ — À tester

HYP-001-006 — Accès rapides
Hypothèse:          Les actions fréquentes hors patient du jour doivent être à un clic
Risque si faux:     Mon espace devient un lanceur ; dilue Q-001
Test:               Les raccourcis sont-ils utilisés pendant les tâches du round ?
Critère d'abandon:  Non utilisés par la majorité → retirés (la sidebar suffit)
Statut:             ? ⚠ — À tester
```

Hors HYP — **décision prise le 2026-10-06** : R3 / PP-003 — voir §10 Règles. La tuile « Éléments à
traiter » de HYP-001-001 est conforme comme compteur.
**Manque, pas hypothèse** : l'état vide (*"Rien de nouveau"*, §6).

---

## 11. Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-08-04 | Blueprint initial — Sprint 0 |
| 0.2 | 2026-10-05 | §11 ajoutée — Fiche d'implémentation (Phase 2, freeze V1). Écart matériel identifié entre ce Blueprint (Signal/Horizon/Obligations) et "Mon espace" du prototype v8 (dashboard/tuiles) — non réconcilié, signalé explicitement pour ne pas être lu comme une validation implicite |
| 0.3 | 2026-10-06 | Requalification [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) (§10) : 7 fiches HYP-001-000 à 006 pour les éléments de "Mon espace" qui ne traduisent pas §6. PP-001 à PP-004 restent normatifs ; le critère d'abandon d'une hypothèse en tension avec un PP est le retour au PP. R3/PP-003 renvoyée à la décision de propriété des éléments à traiter. |
| 0.4 | 2026-10-06 | Décisions produit du 2026-10-06 : Mon espace = seul point d'entrée, « À traiter » = destination (R3/PP-003 levée sans amender PP-003) ; Bloc Obligations = vue de « À traiter » (compteur replié) ; reprise des reports via « À traiter [N] » (Founder-Driven, Finding-003 reste Open, annoté). HYP-001-003 : distinction signal / action ajoutée. |
