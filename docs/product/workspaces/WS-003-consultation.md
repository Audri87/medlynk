# WS-003 — Consultation Blueprint

| Field | Value |
|---|---|
| ID | WS-003 |
| Version | 2.7 |
| Status | **Discovery Blueprint — Corpus Partial** |
| Lifecycle | ☑ Discovery · ☑ Blueprint · ☑ Prototype · ☐ User Test · ☐ Production |
| Workspace Lifecycle Chain | Discovery Blueprint → Corpus Consolidated → Candidate for Prototype → Validated Prototype — WS-003 est à l'étape 1 (voir §7 Definition of Done) |
| Date | 2026-08-04 |
| Sprint | Sprint 2 |
| Depends on | PP-009 → PP-015 (identifiants gelés — voir §4) |
| Display Rules | DR-006 (voir aussi UX Constraints, §5) |
| Sources | Corpus CWRM (F001–F009, partiel — voir Corpus Gaps §3) · [Model C](../../research/challenge-consultation-workspace.md), décisions confirmées le 2026-08-04, hors corpus |
| Prototype | [WS-003-prototype-v0.1.html](WS-003-prototype-v0.1.html) |

> **Note de méthode — v2.0.** Cette version corrige une confusion épistémique introduite en v1.1 :
> OBS-W-001 et OBS-W-002 y étaient présentées comme des observations de la consultation elle-même,
> alors qu'elles portent sur d'autres contextes (séance de kinésithérapie, travail de coordination).
> Le corpus ne contient **aucun** ACT observant directement le déroulement d'une consultation
> praticien-patient. C'est un **Corpus Gap** explicite (§3) — pas une absence à combler par inférence.
>
> v2.0 introduit aussi la couche manquante entre Pattern et Product Principle : la **Design Decision**.
> Un Principle n'est jamais la conséquence automatique d'un Pattern ou d'une décision Model C — c'est un
> choix, fait en connaissance des alternatives écartées. Chaque PP l'expose désormais explicitement.
>
> Enfin, cette version restaure trois éléments de structure jugés nécessaires à la lecture d'un
> Blueprint comme contrat de conception : le **Cognitive Contract** (§2), la **Definition of Done**
> (§7) et un **Read Model Contract** de niveau produit (§10) — sans le détail technique, qui relève de
> l'Engineering.

---

## 1. Product Goal

**Q-003 — Puis-je consacrer toute mon attention au patient — et clore proprement quand c'est terminé ?**

Deux sous-questions, correspondant aux deux phases d'une consultation (Model C) :

1. **Pendant** — puis-je écouter sans que le logiciel s'impose ?
2. **Après** — puis-je capturer ce qu'il faut, sans que cela devienne une charge ?

C'est le cœur de MedLink. Toutes les autres questions (préparation, contexte, documentation) existent
pour rendre celle-ci possible. Un praticien qui entre en consultation en pensant "où cliquer ?" a déjà
échoué. Un praticien qui redoute la fin de journée à cause des consultations non fermées a échoué
différemment.

---

## 2. Cognitive Contract

Un Blueprint décrit ce que le Workspace montre. Un Cognitive Contract décrit ce qu'il **garantit** — et
ce qu'il attend en retour du praticien. C'est un engagement à double sens, pas une liste de fonctions.

**WS-003 garantit :**
- Pendant l'écoute (Mode Présence), aucune information n'apparaît sans action explicite du praticien.
- Une interruption ne fait jamais perdre le fil — l'état est retrouvable en une action (Mode Recovery).
- Une consultation n'exige jamais d'être documentée pour être fermée (PP-015).
- La fermeture d'une consultation ne bloque jamais l'ouverture de la suivante.

**En retour, WS-003 attend du praticien :**
- D'ouvrir explicitement une consultation quand elle commence (PP-014) — le Workspace ne le déduit pas.
- De la fermer explicitement quand elle est finie, même sans contenu (clôture rapide, PP-015).
- D'accepter que le rappel d'une consultation non fermée n'est pas rendu par WS-003 lui-même, mais par
  un autre Workspace (§11 — frontière avec WS-002 et le Practitioner Workspace).

**Rupture de contrat :** si WS-003 interrompt l'attention pendant l'écoute, perd l'état après une
interruption, ou empêche une fermeture rapide, il a échoué — indépendamment de toute autre métrique.

---

## 3. Evidence

### Légende

> Convention gelée au niveau projet — voir [GOV-000](../../process/GOV-000-medlink-governance-v1.0.md).
> `?` couvre à la fois les Corpus Gaps et les hypothèses non testées ; la distinction structurelle
> reste portée par l'identifiant (`GAP-W-NNN` vs `HYP-W-NNN`) et par la table, pas par un symbole séparé.
> `→` marque une décision assumée, quel que soit son ancrage (✓, ≈, ou ?) — il ne signifie jamais
> "validé". Un `⚠` reste attaché à toute décision non encore passée par un Gate.

| Symbole | Niveau | Définition |
|---|---|---|
| ✓ | Confirmé par le corpus | Directement issu du corpus verbatim, dans son scope propre |
| ≈ | Pattern probable | Fortement suggéré — convergent mais non universel |
| ? | Gap ou inconnue | Corpus Gap (table dédiée) ou hypothèse produit non testée |
| → | Décision produit | Choix assumé par le porteur produit — évidence ✓/≈/? précisée en Source |
| ⚠ | À valider avant le prochain Gate | Voir §7 Definition of Done et GOV-000 §4 |

---

### ✓ Observations directes (hors scope consultation)

| ID | Observation | Corpus | Scope réel |
|---|---|---|---|
| OBS-W-001 | Le kinésithérapeute ne prend pas de notes pendant la séance | ACT-F001-019 | Séance de kinésithérapie — pas une consultation médecin-patient |
| OBS-W-002 | L'infirmière coordinatrice est régulièrement interrompue pendant son travail | ACT-F009-027 | Travail de coordination — pas une consultation en cours |

> Ces deux observations sont ✓ **dans leur scope propre**. Elles ne sont PAS des observations du
> comportement pendant une consultation médecin-patient — aucun ACT de ce type n'existe dans le corpus
> actuel (GAP-W-001 ci-dessous). Elles servent d'indices pour construire des Patterns, pas de preuves
> directes pour WS-003.

---

### Corpus Gaps (explicites)

> Un Corpus Gap n'est pas une absence à combler par inférence. C'est un manque documenté qui borne la
> confiance qu'on peut accorder à tout ce qui est construit dessus.

| ID | Gap | Conséquence |
|---|---|---|
| GAP-W-001 | Aucun ACT n'observe directement le déroulement d'une consultation praticien-patient (écoute, dialogue, capture en temps réel) | PAT-W-001/002/003 et PP-009/010/011 restent non confirmés pour le volet "pendant" |
| GAP-W-002 | Aucun ACT ne mesure un coût cognitif de la reprise après interruption | HYP-W-003 et PP-011 sont qualitatifs, pas quantifiés |
| GAP-W-003 | Aucun ACT ne documente la phase de clôture (décision de fermer, contenu de la note post-séance) | PP-012 à PP-015 (Model C) ne sont ni corroborés ni infirmés par le corpus |

---

### ≈ Patterns (inférence à partir d'observations hors scope)

| ID | Pattern | Construit sur |
|---|---|---|
| PAT-W-001 | Les profils relationnels (psychologue, sophrologue) ne documentent pas pendant la séance | OBS-W-001 par extrapolation de profil + F002, F004 |
| PAT-W-002 | La reprise après interruption est une compétence clinique — le logiciel ne l'assiste pas aujourd'hui | OBS-W-002 + absence de tout outil de recovery observé dans le corpus |
| PAT-W-003 | L'écran est soit absent, soit central — pas intermédiaire — selon le type d'acte | Inférence F004 (absent) vs F005 (central) |

---

### → Décisions produit confirmées (Model C — hors corpus, evidence: ?)

| ID | Décision | Source |
|---|---|---|
| DEC-W-001 | La note de consultation est en texte libre — aucune structure imposée | Model C §1 |
| DEC-W-002 | La capture peut se faire pendant ou après — les deux chemins sont valides | Model C §2 |
| DEC-W-003 | Une consultation reste explicitement "ouverte" tant qu'elle n'a pas été fermée | Model C §3 |
| DEC-W-004 | Une consultation peut être fermée en un clic, sans contenu | Model C §4 |

---

### ? Hypothèses produit

| ID | Hypothèse | Risque |
|---|---|---|
| HYP-W-001 | Les praticiens initient moins d'interactions logiciel quand le software est minimal par défaut | Medium |
| HYP-W-002 | La capture de note en un geste réduit la rupture d'attention | Medium |
| HYP-W-003 | Un mécanisme de recovery explicite réduit le temps de désynchronisation après interruption | High — GAP-W-002 |
| HYP-W-004 | PP-009 "software disappears" est applicable à tous les profils relationnels | High — contredit par F005 (échographiste) |
| HYP-W-005 | Un praticien peut capturer une note utile en moins de 3 secondes | High — aucun baseline |
| HYP-W-006 | Le rappel contextuel non bloquant (PP-014) suffit à éviter l'accumulation de consultations non fermées | High — GAP-W-003 |
| HYP-W-007 | Les praticiens acceptent la clôture rapide sans contenu (PP-015) comme un geste légitime, pas un raccourci coupable | Medium — risque de sous-documentation non mesuré |

---

## 4. Product Principles

> **Règle de gel des identifiants.** Une fois assigné, un PP-NNN ne change jamais de sens et n'est
> jamais renuméroté — il peut évoluer (reformulation, précision de portée) mais garde son identité, pour
> que la traçabilité ne se perde pas. PP-009 à PP-015 sont gelés depuis leur introduction dans WS-003.
> Voir la mise à jour correspondante dans le registre central
> [PRODUCT-PRINCIPLES.md](../PRODUCT-PRINCIPLES.md).
>
> Chaque Principle expose désormais sa **Design Decision** : le choix fait, et l'alternative écartée.
> Un Pattern ou une décision Model C n'oblige rien — il informe un choix que MedLink assume.

### Pendant la consultation (hypothèses — corpus requis)

**PP-009 — Software disappears during care**

```
Source:          PAT-W-003 (écran absent ou central — jamais intermédiaire) + GAP-W-001
Design Decision: Face à l'absence de corpus direct sur le comportement pendant l'écoute, MedLink
                 choisit de rendre le logiciel invisible par défaut plutôt que de risquer
                 l'interruption de l'attention clinique. Alternative écartée : un panneau de contexte
                 permanent — plus d'information disponible, au prix d'une sollicitation visuelle
                 continue.
Principle:       During active consultation, WS-003 SHALL display only what the practitioner
                 actively chose to show. No information SHALL appear without explicit action.
Scope:           UX — default state is ultra-minimal. No persistent sidebars, no auto-updating panels.
Exception:       DR-006 — Imagerie/Échographiste, l'écran EST l'acte (§5)
Origine:         Founder-Driven (GOV-000 v1.4) — Mission + Pattern partiel, pas encore Evidence-Driven
Statut:          ? Hypothèse — à valider par corpus extraction + test praticien
```

---

**PP-010 — One cognitive focus at a time**

```
Source:          Mission MedLink uniquement — aucun Pattern, GAP-W-001
Design Decision: En l'absence de tout signal corpus, MedLink choisit la simplicité maximale (une
                 seule chose visible à la fois) plutôt qu'un mode expert multi-fenêtres permettant de
                 croiser plusieurs informations. Le choix privilégie l'attention sur la densité
                 d'information.
Principle:       WS-003 SHALL NOT display competing panels simultaneously. Accessing information
                 (record, result, history) SHALL replace the primary view — not layer over it.
                 Returning to consultation SHALL require one action only.
Scope:           UX — fullscreen modality for any lookup. No split-screen during consultation.
Origine:         Founder-Driven (GOV-000 v1.4) — Mission uniquement, aucun corpus
Statut:          ? Hypothèse — aucun corpus direct
```

---

**PP-011 — Interruptions must be recoverable**

```
Source:          OBS-W-002 (hors scope, indice) + PAT-W-002 + GAP-W-002
Design Decision: Face à l'absence constatée de tout outil de recovery (PAT-W-002), MedLink choisit
                 d'assister explicitement la reprise plutôt que de laisser cette charge reposer
                 uniquement sur la compétence individuelle du praticien. Alternative écartée : ne rien
                 faire — au motif que les praticiens s'en sortent déjà, hypothèse non vérifiée non plus.
Principle:       WS-003 SHALL maintain consultation state across interruptions. A practitioner
                 returning SHALL resume consultation focus in one action. State SHALL include:
                 current topic, last note, pending items.
Scope:           UX — interruption state saved automatically. Recovery view: "Où en étiez-vous ?"
Origine:         Founder-Driven (GOV-000 v1.4) — indice hors scope, pas encore Evidence-Driven
Statut:          ? Hypothèse — fondée sur un indice hors scope (OBS-W-002), pas une observation directe
```

---

### Après la consultation (décisions fondateur — Model C)

**PP-012 — Free text over imposed structure**

```
Source:          → DEC-W-001 — décision fondateur (Model C §1), evidence: ? (hors corpus, GAP-W-003)
Design Decision: MedLink choisit le texte libre plutôt qu'un format structuré (SOAP, champs
                 obligatoires). Alternative écartée : structure minimale imposée pour faciliter la
                 recherche/l'interopérabilité plus tard — jugée prématurée sans preuve d'usage réel.
Principle:       The consultation note SHALL be free text. WS-003 SHALL NOT impose SOAP structure,
                 mandatory fields, or templates.
Scope:           Data model — ConsultationNote is a single free-text field, not a structured form.
Origine:         Founder-Driven (GOV-000 v1.4) — Model C, hors corpus
Statut:          → Décidé — non sujet à validation avant implémentation.
                 ⚠ Conséquence à valider : OQ-W-009 (conformité légale d'une note libre).
```

---

**PP-013 — Capture during OR after — both paths valid**

```
Source:          → DEC-W-002 — décision fondateur (Model C §2), evidence: ≈ (PAT-D-005, WE-004,
                 7/9 profils — la fin de consultation est le déclencheur par défaut, l'écriture
                 pendant reste l'exception documentée. Renforcé le 2026-08-04, voir PDR-004 EV-401.)
Design Decision: MedLink choisit de ne jamais imposer l'un des deux chemins (pendant / après).
                 Alternative écartée : rendre la capture pendant obligatoire pour garantir la
                 fraîcheur de l'information — jugée incompatible avec PP-009 (l'écran n'impose rien).
Principle:       WS-003 SHALL offer an optional capture area during consultation (Mode Capture) AND
                 a wrap-up screen after (Mode Clôture). The wrap-up screen SHALL be pre-filled with
                 whatever was captured during; if nothing was captured, it starts empty.
Scope:           UX — Mode Capture and Mode Clôture share the same note field.
Origine:         Founder-Driven (GOV-000 v1.4) — Model C à l'origine ; evidence renforcée depuis par
                 WE-004, mais l'Origine ne change pas rétroactivement (GOV-000 §1bis, note)
Statut:          → Décidé, evidence ≈. ⚠ Cohérence avec PP-009/PP-010 à vérifier en prototype.
```

---

**PP-014 — Consultation stays open until explicitly closed**

```
Source:          → DEC-W-003 — décision fondateur (Model C §3). Evidence **scindée** (correction
                 PDR-004 EV-401, 2026-08-04) : le principe d'état ouvert/fermé lui-même est
                 evidence: ≈ (PAT-D-002, WE-004, 7/9 profils — la rédaction formelle est
                 systématiquement reportée hors présence du patient) ; le mécanisme des deux rappels
                 non bloquants ci-dessous reste evidence: ? — aucun Pattern de WE-004 ne porte sur le
                 besoin ou la tolérance d'un rappel logiciel, seulement sur le moment de la rédaction.
Design Decision: MedLink choisit un état explicite (ouvert/fermé) plutôt qu'une fermeture implicite
                 (par ex. à l'ouverture du patient suivant). Alternative écartée : fermeture
                 automatique — jugée risquée (perte silencieuse de contenu non sauvegardé).
Principle:       A consultation SHALL be explicitly opened when the practitioner enters consultation
                 mode, and explicitly closed when the practitioner saves and closes. WS-003 SHALL
                 expose this state to other Workspaces via two non-blocking reminders it does not
                 render itself (§11). — evidence: ? sur le mécanisme de rappel spécifiquement.
Scope:           Domain — Consultation aggregate exposes an explicit open/closed state.
Origine:         Founder-Driven (GOV-000 v1.4) — Model C à l'origine ; evidence partiellement
                 renforcée depuis par WE-004, l'Origine ne change pas rétroactivement (GOV-000 §1bis)
Statut:          → Décidé, evidence ≈ (état) / ? (rappels). ⚠ Conséquence à valider : HYP-W-006,
                 OQ-W-011, OQ-W-012.
```

---

**PP-015 — One-click closure with no content**

```
Source:          → DEC-W-004 — décision fondateur (Model C §4), evidence: ? (hors corpus)
Design Decision: MedLink choisit d'autoriser une fermeture sans contenu plutôt que d'exiger une
                 justification minimale. Alternative écartée : forcer une raison de fermeture même
                 vide — jugée contraire au Cognitive Contract (ne jamais bloquer une fermeture, §2).
Principle:       WS-003 SHALL allow closing a consultation in one action with no note content, via
                 an explicit "Nothing to report" choice.
Scope:           UX — Mode Clôture quick-close action. Data model — ConsultationNote MAY be empty.
Origine:         Founder-Driven (GOV-000 v1.4) — Model C, hors corpus
Statut:          → Décidé. ⚠ Conséquence à valider : HYP-W-007 (légitimité perçue du raccourci).
```

---

## 5. UX Constraints & Display Rules

> v1.1 présentait DR-005 à DR-008 comme des Display Rules — l'adaptation d'un Principle pour un profil
> clinique, au sens où WS-002 l'utilise (contenu réellement différent par profil). En réalité, seule
> DR-006 répond à cette définition : une vraie exception à PP-009 pour un profil identifié. DR-005,
> DR-007 et DR-008 ne faisaient que recalibrer l'intensité du même Principle sur un curseur
> minimal↔continu, sans contenu d'interface différent. Elles deviennent des UX Constraints — des notes
> de calibration attachées au Principle, pas des Display Rules.

### UX Constraints (calibration de PP-009 / PP-010 — pas des variantes de contenu)

| Ex-ID | Constraint | Attaché à |
|---|---|---|
| ex-DR-005 | Thérapie / Psychologue / Sophrologue — écran minimal ou fermé, zéro documentation pendant séance | PP-009, extrémité "minimal" |
| ex-DR-007 | Médecin généraliste — documentation semi-continue, Mode Capture fréquent | PP-010, calibration partielle |
| ex-DR-008 | Soin manuel / Kinésithérapeute — mains occupées, software minimal ou inutilisé | PP-009, extrémité "minimal" |

> Le curseur minimal↔continu par profil reste une hypothèse (OQ-W-006) — aucune de ces trois lignes
> n'est validée. Elles ne sont pas renumérotées en DR car elles ne font pas varier le contenu affiché,
> seulement sa fréquence d'apparition.

### Display Rules (véritable exception profilée)

| DR | Profil | Comportement logiciel | Exception à |
|---|---|---|---|
| DR-006 | Imagerie / Échographiste | L'écran EST l'acte — software toujours visible et central | PP-009 — exception documentée, pas calibration |

> Voir [DISPLAY-RULEBOOK.md](../DISPLAY-RULEBOOK.md).

---

## 6. Cognitive Flow

### Illustrative Cognitive Flow (pédagogique — pas la dynamique réelle)

```
ORIENTÉ (WS-002 outcome)
    ↓
ÉCOUTE (Mode Présence / Capture / Lookup / Interruption / Recovery)
    ↓
CLOS (Mode Clôture)
```

> **Ce schéma est une simplification pédagogique.** Il suggère une progression linéaire. Ce n'est pas
> ce qui se passe réellement pendant une consultation — voir la dynamique réelle ci-dessous.

### Dynamique réelle (non linéaire)

```
Observer ⇄ Raisonner ⇄ Observer ⇄ Capturer ⇄ Observer ⇄ ...
```

Le praticien ne traverse pas des états dans l'ordre. Il oscille en continu entre observation clinique,
raisonnement et capture ponctuelle, jusqu'à ce que la consultation se termine et bascule en Mode
Clôture. WS-003 ne modélise pas ce cycle interne — le raisonnement clinique est hors du domaine
logiciel (DE-P-001, DE-P-002). Il protège seulement les points d'entrée/sortie de ce cycle : ne pas
l'interrompre (PP-009/010), permettre une capture ponctuelle sans y forcer (PP-013), permettre une
reprise après interruption externe (PP-011).

---

## 7. Definition of Done

> Statut actuel : **Discovery Blueprint — Corpus Partial**. Ce Blueprint n'est pas prêt pour le
> prototype. Voici ce qui manque pour franchir chaque étape de la chaîne de gouvernance des Workspaces :

```
Discovery Blueprint (ici)
    ↓  Combler GAP-W-001, GAP-W-002, GAP-W-003 — extraire des ACTs de consultation réelle
Corpus Consolidated
    ↓  PAT-W-001/002/003 confirmés ou réfutés par au moins 2 profils convergents chacun
Candidate for Prototype
    ↓  Test praticien sur Consultation Presence (§13) avec baseline mesurée
Validated Prototype
```

**WS-003 passe à "Corpus Consolidated" quand :**
- un protocole d'entretien ciblé a été mené pour chacune des Open Questions du volet "pendant" (OQ-W-001 à 008) ;
- GAP-W-001 est comblé par au moins 3 ACTs de consultation réelle (écoute/dialogue observé) ;
- chaque Pattern (PAT-W-001/002/003) est soit confirmé (≥ 2 profils convergents), soit rétrogradé en hypothèse pure.

**Le volet Model C (PP-012 à PP-015) ne bloque pas cette transition.** Ce sont des décisions déjà
prises (→, evidence ?), pas des hypothèses en attente de corpus. Elles suivent leur propre cycle de validation via
OQ-W-009 à 012, indépendant du statut Discovery du volet "pendant."

---

## 8. User Outcome

À la sortie de WS-003, le praticien doit pouvoir dire :

> "Je n'ai pas eu besoin de penser au logiciel pendant que j'écoutais.
> Et j'ai pu fermer la consultation sans que ça devienne une corvée en fin de journée."

---

## 9. Information Architecture

### Le paradoxe de WS-003

Tout autre Workspace cherche à montrer. WS-003 cherche à disparaître pendant l'écoute — puis, une fois
le patient parti, à rendre la fermeture rapide plutôt qu'invisible.

L'architecture d'information de WS-003 est une architecture de **modes**, pas de blocs.

---

### Six états, un seul flux

```
Mode Présence (défaut)
    │  "J'écoute mon patient."
    │
    ├──→ Mode Capture     "Je note quelque chose rapidement."
    │         └──→ Mode Présence
    │
    ├──→ Mode Lookup      "Je consulte un résultat ou l'historique."
    │         └──→ Mode Présence
    │
    └──→ Mode Interruption  "Je suis appelé."
              └──→ Mode Recovery  "Je reprends."
                        └──→ Mode Présence

[Le patient quitte la pièce — consultation toujours OUVERTE — PP-014]
    ↓
Mode Clôture   "Je termine cette consultation."
    │
    ├──→ Clôture rapide     "Rien à signaler." (PP-015) ──→ consultation FERMÉE
    │
    └──→ Clôture complète   note + prescription + orientation + RDV suivant ──→ consultation FERMÉE
```

---

### Mode Présence (défaut)

**Objectif :** le logiciel ne prend aucune attention cognitive.

Contenu visible :
- Nom du patient + durée écoulée
- 3 actions rapides (icônes uniquement, aucun texte)
- Aucune autre information

Les 3 actions rapides :
- ⊞ Capturer une note
- ◎ Consulter le dossier
- → Marquer pour suivi

Comportement : aucune notification. Aucune mise à jour automatique. Aucun mouvement sur l'écran.

---

### Mode Capture

**Objectif :** saisir sans quitter la consultation.

Contenu visible :
- Champ de saisie rapide — texte libre, pas de formulaire (PP-012)
- Confirmation en un geste (enregistré, retour automatique au Mode Présence)

Contrainte : la capture doit être possible sans regarder l'écran (HYP-W-005).

Ce qui est saisi ici alimente la même note que le Mode Clôture (PP-013) — pas un objet distinct.

---

### Mode Lookup

**Objectif :** consulter sans se perdre.

Comportement :
- Plein écran — remplace Mode Présence (PP-010)
- Retour explicite : un seul bouton "Retour à la consultation"
- Le contexte de retour est affiché en haut : "Consultation — Marie Dubois"

Contenu : résultat demandé, ou historique demandé — rien d'autre.

---

### Mode Interruption

**Objectif :** capturer l'état actuel et se libérer.

Déclenchement : action praticien (jamais automatique).

Ce qui est sauvegardé :
- Dernier sujet (libre ou structuré)
- Notes en cours
- Items marqués pour suivi

Affichage : confirmation "Consultation mise en pause."

---

### Mode Recovery

**Objectif :** reprendre en un regard.

Contenu visible :
- "Où vous en étiez" : dernier sujet + dernière note capturée
- Action unique : "Reprendre"
- Timer de reprise (combien de temps l'interruption a duré)

---

### Mode Clôture

**Objectif :** transformer ce qui a été observé/capturé en actions, sans imposer de forme.

Déclenchement : le praticien quitte la consultation active — le patient n'est plus présent. Ce n'est
pas un mode "pendant" : l'attention au patient n'est plus en jeu, la contrainte devient la rapidité de
traitement, pas l'invisibilité (PP-013).

Contenu visible :
- Note de consultation — texte libre, pré-rempli avec tout contenu de Mode Capture (PP-012, PP-013)
- Actions optionnelles : prescription, orientation/référence, examen, prochain rendez-vous
- Action "Rien à signaler" — clôture en un clic sans contenu (PP-015)

Ce que produit une consultation fermée :

| Sortie | Nature |
|---|---|
| Note de consultation | Enregistrement clinique immuable |
| Prescription (optionnelle) | Immuable, signée |
| Orientation (optionnelle) | Immuable |
| Examen prescrit (optionnel) | Immuable |
| Prochain rendez-vous (optionnel) | Planifiable |

Ces sorties alimentent l'historique du patient et deviennent le **delta** visible à la prochaine
consultation (WS-002, Bloc Continuité).

Tant que Mode Clôture n'a pas été exécuté, la consultation reste **OUVERTE** (PP-014) — WS-003 expose
cet état ; il ne l'affiche pas lui-même sous forme de rappel (voir §11, frontière de Workspace).

---

## 10. Read Model Needs (Product Contract)

> Le Product décrit le besoin de lecture. L'Engineering choisit ensuite le Read Model technique — nom
> de champs, forme du DTO, table de projection — hors de portée de ce Blueprint. Voir ADR-SA-008
> (Model Existence Principle) et ADR-SA-011 (Read Model Strategy).

WS-003 nécessite un modèle de lecture capable de répondre, sans calcul supplémentaire côté client, à :

- Quel est le patient actif, et depuis combien de temps la consultation est-elle en cours ? (Mode Présence)
- Qu'est-ce qui a été capturé depuis l'ouverture de la consultation ? (Mode Capture → Mode Clôture, continuité — PP-013)
- Quel était le dernier sujet et la dernière note avant une interruption ? (Mode Recovery)
- Cette consultation est-elle actuellement ouverte ou fermée ? (PP-014 — consommé par WS-002 et le Practitioner Workspace, pas rendu par WS-003 lui-même)
- Le praticien a-t-il le droit d'accéder au dossier consulté en Mode Lookup ? (consentement / droits d'accès du Care Record — WS-003 ne contourne jamais ces règles)

Ce que ce Blueprint NE spécifie PAS : noms de champs, forme du DTO, table de projection. C'est une
décision d'Engineering, pas de Product.

---

## 11. Scope Limitations

**Ce Blueprint est valide pour :**
- Consultations en face-à-face praticien-patient
- Durée de consultation définie (pas de consultation "continue")
- Un seul praticien présent
- La phase de clôture (Mode Clôture) pour un praticien traitant sa propre consultation

**Ce Blueprint n'a PAS été validé pour :**
- Téléconsultation (l'écran change de rôle)
- Consultation d'urgence (tempo différent)
- Consultation à plusieurs praticiens simultanés
- Actes techniques où l'écran est l'outil principal (DR-006 est une exception, pas la règle)
- Consultations sans rendez-vous (walk-in)
- Consultation s'étendant sur plusieurs sessions (patient qui revient en cours — OQ-W-010)

**Frontière explicite avec d'autres Workspaces (PP-014) :**

WS-003 possède et expose l'état "consultation ouverte / fermée". Il ne rend pas lui-même les deux
mécanismes de rappel décrits par Model C — ceux-ci appartiennent à d'autres niveaux de Workspace :

| Rappel | Déclencheur | Workspace propriétaire |
|---|---|---|
| Rappel contextuel | Ouverture du patient suivant | WS-002 — Patient Context |
| Rappel de fin de journée | Liste des consultations non fermées | WS-006 — *"Je termine"* (nom fixé par [WBD-004](WBD-004-consultation-vs-documentation.md) v2.0 ; aucun Blueprint à ce jour, statut `Research Workspace`) |
| Persistance de la capture | Contenu produit en Mode Clôture (note, prescription, orientation, examen, RDV) | WS-004 — nom à confirmer ([WBD-004](WBD-004-consultation-vs-documentation.md) : *"transformer la capture brute en mémoire clinique fiable, structurée, réutilisable"*) |
| Partage avec d'autres acteurs | Sous-ensemble de ce que WS-004 persiste, destiné à être transmis | WS-005 — nom candidat *Clinical Coordination*, contesté (voir [WE-005](WE-005-information-flow.md) §9) |

Cette séparation évite qu'un Consultation Workspace connaisse le planning ou le tableau de bord
praticien — cohérent avec le principe MedLink "Never build a God Object."

> Ajout 2026-08-06 (Sprint M1.1 — Consolidation, réponse à la Critique 4 / Q1 de la revue
> d'architecture M1). Cette table ne citait à l'origine que WS-002 et un "équivalent fin de journée à
> définir" — jamais mis à jour après l'introduction de WS-006 par WBD-004 v2.0, et sans jamais
> mentionner WS-004/WS-005 alors que WBD-004 les établit comme destinataires directs de la Clôture.
> Les deux lignes ajoutées reflètent ce que WBD-004 affirme déjà ailleurs ; elles ne constituent pas
> une nouvelle décision.

---

## 12. Explicit Non-Goals

WS-003 n'est pas :
- un formulaire de documentation structuré (la note reste libre — PP-012) ;
- un visualisateur de dossier ;
- un outil d'aide à la décision clinique ;
- un agenda ;
- le propriétaire de la liste "consultations à fermer" (voir §11 — appartient au Practitioner Workspace).

Son objectif est de protéger l'attention du praticien pendant la consultation, et de rendre sa
fermeture triviale une fois le patient parti.

---

## 13. Success Metrics

| Métrique | Nature | Baseline requis |
|---|---|---|
| **Consultation Presence** — "Pendant cette consultation, à quel point étiez-vous concentré sur votre patient ?" (1–5) | Qualitatif — déclaratif | Oui — avec les outils actuels |
| Ratio temps-écran / durée-consultation | Comportemental — observationnel | Oui |
| Nombre d'actions logiciel initiées par le praticien (target: minimum) | Comportemental | Oui — baseline prototype |
| "Ai-je interrompu mon patient pour chercher quelque chose ?" | Indicateur de défaillance (binaire) | Test utilisateur |
| Temps de recovery après interruption | Comportemental | Non — observable en prototype |
| Délai entre fin de consultation (patient parti) et fermeture effective | Comportemental | Oui |
| Taux de clôture via "Rien à signaler" (PP-015) | Comportemental — surveiller sous-documentation (HYP-W-007) | Non — observable en prototype |
| Nombre de consultations encore ouvertes en fin de journée | Indicateur de défaillance | Oui |

> **Consultation Presence** est la métrique principale de WS-003, parallèle à **Context Confidence**
> (WS-002). Les métriques de clôture surveillent une régression possible : disparaître pendant l'écoute
> ne doit pas créer une dette qui s'accumule après.

---

## 14. Open Questions

| # | Question | Impact | Status |
|---|---|---|---|
| OQ-W-001 | Quelle information minimale suffit pour maintenir l'orientation pendant l'écoute ? | Mode Présence — contenu | Open |
| OQ-W-002 | La saisie vocale est-elle acceptable en consultation clinique ? | Mode Capture — modalité | Open — voir [PDX-001](../discovery/PDX-001-capture-clinique-assistee.md), Product Discovery |
| OQ-W-003 | Quelles informations les praticiens consultent-ils PENDANT (vs avant) la consultation ? | Mode Lookup — triggers | Open |
| OQ-W-004 | Quelle est la durée de désynchronisation réelle après une interruption ? | PP-011 — baseline | Open |
| OQ-W-005 | Comment les praticiens marquent-ils quelque chose "à traiter plus tard" pendant la consultation ? | Mode Capture — intention | Open |
| OQ-W-006 | PP-009 "software disappears" s'applique-t-il uniformément, ou varie-t-il par profil (curseur ex-DR-005/007/008) ? | UX Constraints — périmètre | Open |
| OQ-W-007 | Un praticien peut-il capturer une note utile en moins de 3 secondes ? (HYP-W-005) | Mode Capture — latence | Open |
| OQ-W-008 | Les praticiens distinguent-ils "regarder le dossier" (informatif) de "regarder l'écran pour éviter le regard patient" (défensif) ? | PP-009 — usage réel vs déclaré | Open |
| OQ-W-009 | La note de consultation en texte libre (PP-012) nécessite-t-elle un format minimal pour conformité légale ? | Mode Clôture — contrainte réglementaire | Open — Model C |
| OQ-W-010 | Comment WS-003 gère-t-il une consultation qui s'étend sur plusieurs sessions (le patient revient en cours) ? | Scope limitation — hors périmètre actuel | Open — Model C |
| OQ-W-011 | Le rappel de fin de journée (§11, Practitioner Workspace) doit-il déclencher une notification push, ou la présence au tableau de bord suffit-elle ? | Cross-Workspace — hors périmètre WS-003 direct | Open — Model C |
| OQ-W-012 | ~~L'ouverture d'une consultation est-elle toujours explicite (PP-014), ou peut-elle être déduite de l'ouverture du dossier pendant un créneau planifié ?~~ **Résolue (ADR-0023, 2026-08-06)** — toujours explicite, jamais déduite. Ouvrir un patient ≠ démarrer une consultation. | PP-014 — déclenchement | Resolved |

> OQ-W-001 à 008 définissent le programme d'extraction corpus pour le volet "pendant" (Sprint 2, voir
> §7 Definition of Done). OQ-W-009 à 012 reprennent le Challenge Request de Model C pour le volet
> "après" — non encore confronté au corpus. Elles doivent être investiguées contre la pratique réelle,
> pas contre l'élégance du modèle (cf. Model C : "Do not optimise for elegance").
>
> **OQ-W-002 suit un chemin différent des sept autres.** Elle n'attend pas une extraction corpus
> supplémentaire — le corpus ne peut par construction pas trancher une modalité qu'il n'a jamais vue
> (GOV-000 v1.4 §1bis). Elle est prise en charge par [PDX-001](../discovery/PDX-001-capture-clinique-assistee.md)
> via Product Discovery (Hypothèse → Prototype exploratoire → Tests praticiens), en parallèle du
> circuit Discovery des sept autres. Aucun PP de WS-003 n'est modifié par PDX-001 tant qu'il n'a pas été
> testé et validé (RG-002, RG-003).

---

## 15. Evidence Quality Summary

| Élément | Niveau | Ancre |
|---|---|---|
| OBS-W-001 | ✓ Direct, hors scope | ACT-F001-019 |
| OBS-W-002 | ✓ Direct, hors scope | ACT-F009-027 |
| GAP-W-001 à W-003 | ? Corpus Gap | Absence documentée |
| PAT-W-001 | ≈ Pattern | Inférence F002, F004, F001 |
| PAT-W-002 | ≈ Pattern | OBS-W-002 + absence dans corpus |
| PAT-W-003 | ≈ Pattern | Inférence F004 vs F005 |
| DEC-W-001 à W-004 | → Décision fondateur, evidence ? | Model C — hors corpus |
| PP-009, PP-010, PP-011 | → Décision, evidence ? + Design Decision explicite | Mission + Pattern partiel, GAP-W-001/002 |
| PP-012, PP-015 | → Décision fondateur, evidence ? + Design Decision explicite | DEC-W-001, DEC-W-004 |
| PP-013 | → Décision fondateur, evidence ≈ (renforcé 2026-08-04) + Design Decision explicite | DEC-W-002 + PAT-D-005 (WE-004, PDR-004 EV-401) |
| PP-014 | → Décision fondateur, evidence **scindée** : ≈ pour l'état ouvert/fermé, ? pour le mécanisme de rappel (corrigé 2026-08-04, audit PDR-004) | DEC-W-003 + PAT-D-002 (état) ; Model C seul (rappels) |
| DR-006 | ? Hypothèse | Inférence F004 vs F005 — non validé |
| ex-DR-005/007/008 | ? Hypothèse (UX Constraint, pas Display Rule) | Inférence par profil — non validé |
| HYP-W-001 à W-007 | ? Hypothèse | À extraire |

**Ratio épistémique :** 2 observations ✓ (hors scope) · 3 Corpus Gaps explicites (?) · 3 patterns ≈ ·
4 décisions fondateur → (Model C, chacune avec Design Decision documentée) — dont **2 encore evidence ?**
(PP-012, PP-015), **1 désormais pleinement evidence ≈** (PP-013) et **1 evidence scindée ≈/?**
(PP-014 — état ouvert/fermé confirmé, mécanisme de rappel non confirmé, corrigé le 2026-08-04) ·
3 Principles décidés → evidence ? (pendant, chacun avec Design Decision documentée) ·
1 Display Rule réelle · 3 UX Constraints (non profilées) · 7 hypothèses ?.

> Première boucle de Validation (GOV-000 Niveau 5) effective sur ce Blueprint : une décision fondateur
> sans corpus (Model C, PP-013/014) a reçu un ancrage corpus réel a posteriori, via le travail de
> Discovery mené pour un autre Workspace (WS-004). Mais cette boucle a elle-même été sur-appliquée une
> première fois (PP-014 traitée comme intégralement confirmée) avant d'être corrigée par un audit
> critique — la Validation (Niveau 5) s'applique aussi aux décisions de renforcement d'evidence,
> pas seulement aux décisions fondateur d'origine.

Ce Blueprint reste dominé par les hypothèses pour le volet "pendant" — c'est attendu et assumé (Status
§ header). Le volet "après" est décidé (Model C) mais non challengé empiriquement. Les deux statuts ne
doivent jamais être fusionnés dans la communication produit : "décidé" ne veut pas dire "validé", et
"observé" ne veut pas dire "observé dans ce scope."

---

## 16. Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-08-04 | Blueprint initial — Discovery phase. Corpus extraction à lancer. |
| 1.1 | 2026-08-04 | Merge avec Model C — ajout Mode Clôture, DEC-W-001 à 004, PP-012 à PP-015, OQ-W-009 à 012, frontière WS-002 / Practitioner Workspace. |
| 2.0 | 2026-08-04 | Reconstruction post-review externe : Cognitive Contract (§2) et Definition of Done (§7) restaurés ; couche Design Decision ajoutée à chaque PP ; Corpus Gaps rendus explicites (GAP-W-001 à 003) ; correction du scope réel de OBS-W-001/002 (hors consultation, pas dans-scope) ; Display Rules non profilées reclassées en UX Constraints (§5) ; identifiants PP gelés définitivement ; Cognitive Flow renommé Illustrative + dynamique réelle non linéaire ajoutée (§6) ; Read Model Needs de niveau produit ajouté, détail technique renvoyé vers ADR-SA-008/011 (§10) ; statut corrigé en "Discovery Blueprint — Corpus Partial". |
| 2.1 | 2026-08-04 | Alignement sur la convention de marqueurs gelée par [GOV-000](../../process/GOV-000-medlink-governance-v1.0.md) : `💡` remplacé par `→` (Décision produit, composable avec l'évidence ✓/≈/?) ; `—` (Corpus Gap) replié sous `?` (structure préservée via les identifiants GAP-W-NNN) ; `⚠` ajouté partout où une conséquence reste à valider avant le prochain Gate. Aucun changement de contenu, seulement de notation. |
| 2.2 | 2026-08-04 | PP-013 et PP-014 passent de `evidence: ?` à `evidence: ≈`, suite à l'extraction [WE-004](WE-004-documentation.md) (PAT-D-002, PAT-D-005 — 7/9 profils chacun) et sa formalisation dans [PDR-004](PDR-004-documentation.md) DD-402. PP-012 et PP-015 restent `evidence: ?` — non confirmés par WE-004. Premier cas concret de la boucle de Validation GOV-000 (Niveau 5) : la preuve circule d'un Workspace à l'autre. |
| 2.3 | 2026-08-04 | Correction suite à l'audit critique de PDR-004 : l'evidence `≈` de PP-014 était sur-étendue. PAT-D-002 confirme le principe d'état ouvert/fermé, pas le mécanisme des deux rappels (§11) — resté sans ancrage, pur héritage Model C. Evidence de PP-014 scindée en conséquence (`≈` état / `?` rappels). PP-013 inchangée (pleinement supportée). Aucun autre contenu modifié. |
| 2.4 | 2026-08-04 | Pointeur ajouté (§14) : OQ-W-002 (saisie vocale) reversée vers IH-001 (circuit Innovation, GOV-000 v1.3 §1bis). Aucun Product Principle modifié — WS-003 reste Gold Standard, la stabilisation n'est pas rouverte. |
| 2.7 | 2026-08-06 | OQ-W-012 résolue par [ADR-0023](../../adr/ADR-0023-patient-context-consultation-care-record.md) — l'ouverture d'une consultation est toujours explicite, jamais déduite. Structure Dashboard/WS-002/WS-003/Care Record figée. |
| 2.6 | 2026-08-06 | Prototype v0.1 ajouté (six modes, fidèle à l'architecture par états — pas de blocs/widgets, conformément à la décision du 2026-08-06, voir WS-003-M2-synthese.md). Aucun Product Principle modifié. |
| 2.5 | 2026-08-04 | Renommage suite à GOV-000 v1.4 : IH-001 → [PDX-001](../discovery/PDX-001-capture-clinique-assistee.md) (Product Discovery remplace "circuit Innovation"). Indicateur d'**Origine** (Evidence-Driven / Discovery-Driven / Constraint-Driven / Founder-Driven) ajouté à chaque Product Principle (§4) — tous PP-009 à PP-015 sont **Founder-Driven** dans leur origine (Model C ou raisonnement Mission), y compris PP-013/014 dont l'evidence a depuis été renforcée : Origine et niveau de preuve sont deux axes distincts, l'un ne réécrit pas l'autre. |
