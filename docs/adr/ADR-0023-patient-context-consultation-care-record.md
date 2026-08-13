# ADR-0023 — Structure Produit Figée : Patient Context / Consultation / Care Record

**Statut** : Accepted — Frozen (voir ADR-0017 pour la sémantique exacte de ce statut)
**Date** : 2026-08-06
**Version** : v1.0
**Nature** : Gèle les frontières architecturales entre Dashboard, WS-002, WS-003 et Care Record. Ne
gèle **pas** l'UX finale — densité visuelle, transitions, composants restent explorables (§8).

---

## 1. Décision

La structure de référence est :

```
MON ESPACE / DASHBOARD
    → sélection d'un patient
    → WS-002 — PATIENT CONTEXT
    → action explicite « Démarrer la consultation »
    → WS-003 — CONSULTATION
    → CARE RECORD accessible à la demande
```

Ces éléments sont des niveaux distincts de l'architecture produit et ne doivent pas être fusionnés.

---

## 2. Mon Espace / Dashboard

Le Dashboard est l'espace d'orientation du praticien.

**Question :** *"Où en est ma journée et qu'est-ce qui mérite mon attention maintenant ?"*

Il peut présenter l'agenda, les patients du jour, les changements, les éléments en suspens, les
transmissions et les autres informations utiles au travail quotidien.

Le Dashboard doit rester familier et compatible avec les habitudes des praticiens. **Il n'est pas un
Workspace clinique.**

---

## 3. WS-002 — Patient Context

WS-002 est l'état initial lorsqu'un patient est ouvert.

**Question centrale :** *"Pourquoi ce patient est-il devant moi aujourd'hui ?"*

Les 4 blocs sont figés :

| Bloc | Comportement |
|---|---|
| Présence | Toujours visible |
| Continuité | Toujours visible |
| Intention | Visible seulement si documentée |
| Historique | Collapsed par défaut, avec les exceptions déjà documentées (DR-003) |

WS-002 n'est pas le Care Record, ni une consultation, ni un visualiseur complet du dossier.

---

## 4. WS-003 — Consultation

WS-003 n'est ouvert que par une action explicite du praticien.

**Règle :** Ouvrir un patient ≠ démarrer une consultation.

**Action de transition :** *"Démarrer la consultation"*

WS-003 est une architecture de modes, avec : Présence, Capture, Lookup, Interruption / Recovery,
Clôture.

Pendant WS-003, WS-002 ne reste pas affiché en bandeau ou en split-screen.

**Transition :** WS-002 → « Démarrer la consultation » → WS-003 / Présence.

---

## 5. Care Record

Le Care Record représente la profondeur et la totalité des informations cliniques disponibles sur le
patient.

Il n'est pas un Workspace, pas l'écran d'entrée du patient, et pas automatiquement affiché.

Il est accessible à la demande, notamment via Lookup dans WS-003 ou « Consulter le dossier complet »
depuis WS-002.

**Principe :** La profondeur est disponible, mais elle n'est jamais imposée.

---

## 6. Modèle mental global

```
Dashboard   = s'orienter
WS-002      = comprendre
WS-003      = agir
Care Record = approfondir
```

**Parcours cible :**

```
Dashboard → Patient → WS-002 → Démarrer la consultation → WS-003 → Lookup / Care Record si nécessaire → Clôture
```

---

## 7. Règles non négociables

1. La sélection d'un patient ne crée jamais automatiquement une consultation.
2. WS-002 précède WS-003.
3. WS-002 ne doit pas devenir un dossier médical complet.
4. Le Care Record est consulté à la demande.
5. WS-002 et WS-003 sont séparés visuellement.
6. Le Dashboard peut reprendre les habitudes des praticiens sans modifier les frontières des
   Workspaces.
7. Ne pas inventer de nouveaux Workspaces sans les confronter au corpus et aux décisions existantes.

---

## 8. Ce qui reste libre

La structure est figée, mais les détails UX restent explorables :

- présentation exacte du Dashboard ;
- présentation graphique de WS-002 ;
- emplacement et formulation finale de « Démarrer la consultation » ;
- transition WS-002 → WS-003 ;
- présentation du Care Record ;
- comportement exact de Lookup ;
- détails graphiques, densité et responsive.

Toute proposition non établie doit être marquée : `HYPOTHÈSE — À TESTER`.

---

## 9. Instruction pour Claude

Utiliser cette structure comme contrainte d'architecture produit pour les prochaines conceptions.

- Ne pas revenir silencieusement à un modèle de dossier patient comme écran central.
- Ne pas fusionner WS-002 et Care Record.
- Ne pas fusionner WS-002 et WS-003.
- Ne pas transformer le Dashboard en Workspace clinique.
- Si une proposition UX contredit cette structure, signaler explicitement la contradiction avant de
  proposer une alternative.

Cette structure est **Frozen**. Les prochaines itérations portent sur la conception et la validation
UX, pas sur la remise en cause silencieuse de ces frontières.

---

## Conséquences

**OQ-W-012 (WS-003) est résolue par cet ADR.** Cette Open Question demandait : *"L'ouverture d'une
consultation est-elle toujours explicite (PP-014), ou peut-elle être déduite de l'ouverture du
dossier pendant un créneau planifié ?"* — la Règle 1 (§7) tranche explicitement : jamais déduite.
Le Blueprint WS-003 est mis à jour en conséquence.

**Relation avec ADR-0022.** Les deux gels sont compatibles mais de nature différente : ADR-0022 gèle
la **méthode** M2 (workflow, règle de stabilité, journal) pour la durée de trois Workspaces. Cet ADR
gèle des **décisions d'architecture produit** spécifiques (les frontières Dashboard/WS-002/WS-003/
Care Record), sans limite de durée — jusqu'à ce qu'une contradiction empirique démontrée déclenche le
protocole d'évolution (ADR-0015 Règle 4).

**Pour le Care Record.** Ce document confirme son rôle de destination "à la demande" depuis WS-002 et
WS-003, sans le redéfinir — il reste le concept Domain déjà établi (CLAUDE.md : *"Care Record is
Clinical Memory"*). Sa relation avec WS-004 (qui produit la mémoire persistée) n'est pas tranchée ici
et reste hors périmètre de cet ADR.

---

## Relation avec les documents existants

| Document | Relation |
|---|---|
| ADR-0015 Règle 4 | Protocole applicable si cette structure doit évoluer |
| ADR-0017 | Sémantique du statut `Frozen` appliquée ici |
| ADR-0022 | Gel parallèle, de nature différente (méthode vs décisions d'architecture) |
| WS-003 §14 | OQ-W-012 marquée résolue par cet ADR |
| WS-002-WS-003-transition-prototype-v0.1.html | Premier prototype déjà conforme à cette structure |

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-08-06 | 1.0 | Création — structure produit figée, formalisée telle que rédigée par le Product Owner |
