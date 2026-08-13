# M2 — Journal des observations

**Statut :** Living document — alimenté pendant toute la durée du gel [ADR-0022](../adr/ADR-0022-m2-freeze-protocol.md)
**Périmètre :** WS-002, WS-004, WS-005 uniquement (WS-003 hors gel)
**Règle :** aucune entrée ne modifie M2 directement. Chaque entrée est une observation, reformulée en
hypothèse d'amélioration, en attente de la revue de fin de gel.

> Seuil de journalisation (ADR-0022 §3) : une entrée existe seulement si la difficulté a forcé un
> contournement, une décision de scope imprévue, ou une contradiction avec ce que M2 dit faire.

---

## Format d'une entrée

```
OBS-M2-[NNN]
Workspace  : [WS-002 / WS-004 / WS-005]
Date       : [YYYY-MM-DD]
Difficulté : [ce qui a été rencontré, factuellement]
Loi motivante déjà connue (si applicable) : [T-NNN, PP-NNN, ou "aucune"]
Hypothèse d'amélioration : [reformulation testable — pas une solution actée]
Statut     : Confirme / Réfute / Suspendue / Abandonnée (vocabulaire CC-000)
```

---

## Entrées

### OBS-M2-001

**Workspace :** WS-002
**Date :** 2026-08-06
**Difficulté :** Le bloc "Nouveautés" proposé pour le prototype v0.2 ne s'ancre à aucune Observation
existante de WS-002, et son contenu (courrier confrère, rapport reçu) touche une limite de portée
explicitement exclue par le Blueprint (*"praticiens lisant les notes d'un collègue"*).
**Loi motivante déjà connue :** Aucune — proche de PP-001 (WS-001, Signal precedes Horizon) sans
en être une extension actée.
**Hypothèse d'amélioration :** Le bloc Nouveautés répond peut-être à une question de frontière entre
WS-002 et WS-005 (store de sortie de la transmission, déjà noté ouvert dans AR-001 Finding-004) plutôt
qu'à une extension propre de WS-002.
**Statut :** Suspendue — en attente de confrontation praticien (CWRM-020-APX-M2 §2 et §5).

---

### OBS-M2-002

**Workspace :** WS-002
**Date :** 2026-08-06
**Difficulté :** La granularité du mécanisme de composition ("widget") n'est définie nulle part —
Challenge 4 (N micro-actes ⇄ N widgets) reste non tranché, et la proposition "Clinical Capability
Block" a tenté de le figer en ADR avant tout test terrain.
**Loi motivante déjà connue :** Aucune — Challenge 9 conclut à une relation de traduction possible,
pas à un objet réutilisable démontré.
**Hypothèse d'amélioration :** Ne pas nommer ni figer d'unité de composition avant d'avoir observé au
moins deux traductions indépendantes (deux Workspaces) suivant le même besoin de composition par
métier.
**Statut :** Suspendue — condition de sortie liée à ADR-0022 (trois Workspaces, pas un seul).

---

### OBS-M2-003

**Workspace :** Transversal (constaté sur WS-003, applicable à WS-004/005 à venir)
**Date :** 2026-08-06
**Difficulté :** Risque de transposer automatiquement l'architecture noyau + widgets adaptatifs
découverte sur WS-002 aux autres Workspaces, sans vérifier si leur propre corpus/Blueprint la
justifie. WS-003 a un Blueprint qui écarte explicitement ce modèle (*"architecture de modes, pas de
blocs"*, §9) en faveur d'une machine à états.
**Loi motivante déjà connue :** Aucune — le choix d'architecture d'interface (widgets vs modes) n'est
lui-même établi par aucune loi M1 ; c'est une décision produit par Workspace.
**Hypothèse d'amélioration :** Chaque Workspace vérifie indépendamment, avant d'adopter un modèle
d'architecture, si son propre corpus/Blueprint le justifie — jamais un héritage automatique d'un autre
Workspace.
**Statut :** Confirme — ratifié explicitement par le Product Owner le 2026-08-06. Ne modifie pas le
workflow, la règle de stabilité, ni le format du journal (donc ne rouvre pas le gel M2, ADR-0022 §3) ;
s'applique comme critère de vérification lors de la construction de WS-004/005.

---

### OBS-M2-004

**Workspace :** Transversal (WS-001, WS-002, WS-005)
**Date :** 2026-08-06
**Difficulté :** Le même besoin — signaler ce qui a changé / doit être transmis — apparaît sous trois
formes distinctes sans qu'aucune loi commune ne soit établie : *"Ce qui a changé depuis hier"* +
*"Transmissions à réaliser"* dans `probe-dashboard-v3.html` (échelle jour), le bloc "Nouveautés"
testé sur WS-002 v0.2 (échelle patient), et le mandat même de WS-005 (transmission entre acteurs).
**Loi motivante déjà connue :** Aucune — convergence de surface, pas encore une Loi corroborée.
**Hypothèse d'amélioration :** Vérifier explicitement, lors des entretiens déjà prévus
([CWRM-020-APX-M2](../research/specifications/CWRM-020-APX-M2-workspace-questionnaires.md) §2 et §5),
si les praticiens distinguent réellement ces trois échelles ou les vivent comme une seule
préoccupation continue.
**Statut :** Suspendue.

---

### OBS-M2-005

**Workspace :** Transversal
**Date :** 2026-08-06
**Difficulté :** `probe-dashboard-v3.html` mélange un shell de navigation persistant (sidebar, barre
du haut, nav Aujourd'hui/Patients/Transmissions/Paramètres) avec le contenu propre à WS-001. Aucun
document existant (GOV-000, PRODUCT-ARCHITECTURE-v1.0, Blueprints) ne définit ni ne nomme ce shell
comme concept d'architecture produit.
**Loi motivante déjà connue :** Aucune.
**Hypothèse d'amélioration :** Nommer et scoper ce shell explicitement avant d'y intégrer d'autres
Workspaces — sinon il s'installe par l'usage sans définition, répétant la dérive déjà observée avec
"widget" (OBS-M2-002/003).
**Statut :** Suspendue.

> **Mise à jour 2026-08-06.** Le Product Owner formule explicitement le rôle attendu du shell
> ("Mon Espace") : préserver les habitudes du praticien — sa journée, ses patients, ses alertes, ses
> éléments en attente, ses accès habituels — pendant que WS-002/WS-003 peuvent, une fois un patient
> ouvert, faire vivre une expérience différente. Ceci précise le périmètre à tester, sans encore
> constituer une confirmation terrain — reste `Suspendue`, mais moins ouvert qu'avant.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Ouverture du journal — 2 entrées initiales reprises des difficultés déjà identifiées en session sur WS-002 |
| 2026-08-06 | 1.1 | OBS-M2-003 ajoutée — non-transposition du modèle noyau+widgets de WS-002 vers les autres Workspaces, ratifiée par le Product Owner |
| 2026-08-06 | 1.2 | OBS-M2-004 et OBS-M2-005 ajoutées, suite à l'examen de `probe-dashboard-v3.html` et `probe-dossier-v1.html` — triangulation Nouveautés/Transmissions à trois échelles ; shell de navigation non défini |
