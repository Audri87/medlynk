# WS-003 — Consultation Blueprint

| Field | Value |
|---|---|
| ID | WS-003 |
| Version | 3.2 |
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

Extension (2026-09-10) — Actions accessibles pendant la consultation :
Principle:       WS-003 SHALL also expose the production actions currently reserved to Mode Clôture
                 (Ordonnance, Rendez-vous, Examen, Courrier) as reachable DURING the consultation,
                 via a dedicated full-screen mode symmetric to Mode Lookup (Mode Action, §9) — not
                 gated behind the patient's departure. Mode Présence's minimal budget (PP-009) is
                 not altered by this extension: Mode Action is reached only by an explicit
                 practitioner action, never surfaced passively.
Design Decision: Décision produit (Founder-Driven) confirmant l'option (a) discutée sur le "Nouveau
                 parcours" — plutôt que de lier la production au départ du patient (frontière
                 temporelle historique de PP-013), la frontière devient purement fonctionnelle
                 (Capture = note libre ponctuelle, Action = production structurée), symétrique à la
                 distinction déjà actée pour Mode Lookup. Alternative écartée : garder la production
                 exclusivement en Mode Clôture — jugée trop rigide face à des praticiens qui
                 rédigent une ordonnance pendant que le patient est encore présent.
Origine:         Founder-Driven — décision produit, evidence: ? (hors corpus, non testée). Distincte
                 du evidence ≈ qui porte sur le principe original "pendant OU après" — cette
                 extension n'a reçu aucun ancrage corpus propre.
Statut:          → Décidé. ⚠ Cohérence avec PP-009/PP-010/PP-015 à vérifier en prototype — voir
                 OQ-W-013, OQ-W-014 (§14).
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

### Sept états, un seul flux

*(⚠ Extension 2026-09-10, PP-013 — Mode Action ajouté. Les six états d'origine ne sont pas modifiés ;
un septième état est ajouté, symétrique à Mode Lookup dans son fonctionnement.)*

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
    ├──→ Mode Action       "Je fais une ordonnance / un RDV / un examen / un courrier, maintenant."
    │         └──→ Mode Présence            (⚠ 2026-09-10 — voir §9 Mode Action)
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
    └──→ Clôture complète   récapitulatif + note + actions restantes ──→ consultation FERMÉE
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

*(⚠ Extension 2026-09-10, PP-013 — une 4ᵉ action rapide est ajoutée : ▤ Agir (ouvre Mode Action, §9
ci-dessous). Icône seule, sans texte, même budget que les trois autres — ne modifie pas PP-009.)*

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

### Mode Action *(⚠ ajouté 2026-09-10 — Extension PP-013, evidence: ?, non testée)*

**Objectif :** produire une ordonnance, une orientation, un examen, un courrier ou un RDV sans
attendre la fin de la consultation — symétrique à Mode Lookup dans son fonctionnement, pas dans son
contenu.

Déclenchement : action praticien explicite (icône ▤ Agir, Mode Présence) — jamais automatique, jamais
suggéré.

Comportement :
- Plein écran — remplace Mode Présence (même patron que Mode Lookup, PP-010)
- Retour explicite : un seul bouton "Retour à la consultation"
- Choix parmi : Ordonnance / Orientation / Examen / Courrier / Rendez-vous — même contenu que les
  "Actions optionnelles" de Mode Clôture (voir plus bas), pas un objet distinct *(⚠ Orientation et
  Courrier sont deux sorties distinctes, pas un renommage l'une de l'autre — résolu 2026-09-10,
  OQ-W-013)*

Ce qui est produit ici alimente la même liste de sorties que Mode Clôture (PP-013) — pas un second
circuit. Une action réalisée en Mode Action reste visible comme **« Déjà réalisé »** au retour en
Mode Présence, et apparaît dans le récapitulatif de Mode Clôture plutôt que d'y être proposée à
nouveau.

⚠ Non tranché : l'effet de Mode Action sur le sens de "Rien à signaler" (PP-015) en Mode Clôture —
voir OQ-W-014.

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
- Actions optionnelles : prescription, orientation/référence, examen, prochain rendez-vous *(⚠ +
  courrier, ajouté 2026-09-10 — sortie distincte d'orientation/référence, résolu OQ-W-013)*
- Action "Rien à signaler" — clôture en un clic sans contenu (PP-015)

*(⚠ Extension 2026-09-10, PP-013 — Mode Clôture n'est plus l'unique porte d'entrée de ces actions.
Contenu ajouté, rien retiré :*
- *Récapitulatif des actions déjà réalisées en Mode Action pendant la consultation (« Déjà réalisé »)*
- *"Actions optionnelles" ne propose plus que ce qui n'a pas déjà été fait en Mode Action*
- *"Rien à signaler" (PP-015) reste disponible tel quel — son sens exact quand des actions ont déjà*
  *été faites via Mode Action n'est pas tranché, voir OQ-W-014)*

Ce que produit une consultation fermée :

| Sortie | Nature |
|---|---|
| Note de consultation | Enregistrement clinique immuable |
| Prescription (optionnelle) | Immuable, signée |
| Orientation (optionnelle) | Immuable |
| Examen prescrit (optionnel) | Immuable |
| Prochain rendez-vous (optionnel) | Planifiable |
| Courrier (optionnel) *(⚠ ajouté 2026-09-10)* | Immuable — sortie distincte d'Orientation, pas un renommage (résolu 2026-09-10, OQ-W-013, décision Founder-Driven) |

Ces sorties alimentent l'historique du patient et deviennent le **delta** visible à la prochaine
consultation (WS-002, Bloc Continuité).

Tant que Mode Clôture n'a pas été exécuté, la consultation reste **OUVERTE** (PP-014) — WS-003 expose
cet état ; il ne l'affiche pas lui-même sous forme de rappel (voir §11, frontière de Workspace).

*(⚠ Ajout 2026-10-06 — décision produit Founder-Driven, evidence ?, non testée. Une action identifiée
pendant la consultation mais non terminée à la clôture — ordonnance, courrier, examen, orientation,
rendez-vous à poser, résultat à vérifier — n'est ni perdue (CAL-I-007) ni portée par WS-003 : elle
apparaît dans **« À traiter »**, collection unique des actions restant à effectuer par le praticien,
avec la provenance **Consultation** ([A-TRAITER-implementation](A-TRAITER-implementation.md)). WS-003
ne possède pas cette collection ; il l'alimente. Aucun PP modifié. Dépend de la persistance réelle du
Brouillon — HR-001 H-ES-001, `Open`.)*

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
| ⚠ Reste-à-faire non traité *(ajout 2026-10-06)* | Action identifiée en consultation, non terminée à la clôture | **« À traiter »** — vue de travail, pas un Workspace ([A-TRAITER-implementation](A-TRAITER-implementation.md)) ; décision Founder-Driven, evidence ?, non testée |

Cette séparation évite qu'un Consultation Workspace connaisse le planning ou le tableau de bord
praticien — cohérent avec le principe MedLink "Never build a God Object."

> Ajout 2026-08-06 (Sprint M1.1 — Consolidation, réponse à la Critique 4 / Q1 de la revue
> d'architecture M1). Cette table ne citait à l'origine que WS-002 et un "équivalent fin de journée à
> définir" — jamais mis à jour après l'introduction de WS-006 par WBD-004 v2.0, et sans jamais
> mentionner WS-004/WS-005 alors que WBD-004 les établit comme destinataires directs de la Clôture.
> Les deux lignes ajoutées reflètent ce que WBD-004 affirme déjà ailleurs ; elles ne constituent pas
> une nouvelle décision.

> ⚠ **Flag 2026-09-10, non corrigé ici** — la ligne "WS-004" de la table ci-dessus cite encore le
> texte antérieur à [WBD-004](WBD-004-consultation-vs-documentation.md) v2.3 (verdict NO-WORKSPACE,
> 2026-09-09). La responsabilité qu'elle décrit reste réelle mais n'est plus portée par un Workspace
> nommé WS-004 — voir WBD-004 v2.3 pour la redistribution exacte (CAL-001, HR-001 H-G1, capacité
> Engineering conditionnelle à PDX-001). Correction de cette table hors scope du présent amendement
> (qui porte sur PP-013/Mode Action) — signalé, non résolu unilatéralement ici.

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
| OQ-W-013 | ~~"Courrier" (Mode Action/Clôture) est-il un renommage d'"Orientation/référence", ou une sortie distincte avec sa propre nature de donnée ?~~ **Résolue (2026-09-10, décision Founder-Driven)** — sortie distincte : un praticien peut produire une Orientation et un Courrier séparément sur la même consultation. | Sorties Mode Clôture — modèle de données | Resolved |
| OQ-W-014 *(⚠ ajoutée 2026-09-10)* | "Rien à signaler" (PP-015) garde-t-il le même sens quand des actions ont déjà été réalisées en Mode Action pendant la consultation, ou faut-il distinguer "rien à signaler" (note vide) de "rien à ajouter" (actions déjà faites) ? | PP-015 × Mode Action — cohérence | Open — Founder-Driven, non tranché |

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
| PP-013 — extension Mode Action *(⚠ ajoutée 2026-09-10)* | → Décision fondateur, evidence **?** (non testée, distincte du ≈ ci-dessus) + Design Decision explicite | Aucun ancrage corpus — décision Founder-Driven pure |
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

## 16. Fiche d'implémentation (Phase 2 — Freeze V1, 2026-10-05)

> Couche ajoutée au-dessus du Blueprint ci-dessus (§1-15, inchangé). WS-003 est le Workspace le plus
> construit du prototype (`WS-002-WS-003-parcours-v8.html`) — beaucoup d'alignements forts, mais aussi
> les déviations les plus précises et les plus importantes à tracer de toute cette Phase 2.

**Objectif.** Inchangé — Q-003, §1.

**Entrée.** Depuis WS-002 uniquement ("Démarrer la consultation") — jamais déduite de l'ouverture du
dossier (OQ-W-012, `Resolved` par ADR-0023, respecté : le bouton "Démarrer une consultation" retiré du
Care Record pendant cette session allait dans ce sens).

**Sortie.** → Mode Clôture → consultation fermée → écran "Consultation clôturée" → Mon Espace. → Care
Record (bouton tête de bandeau + onglet contexte, "Voir le dossier complet"). → Mon Espace via "Mettre
en pause" (Interruption, PP-011).

**Actions (réelles vs décoratives).** Tout est réel dans ce Workspace — aucun bouton décoratif
identifié, contrairement aux autres écrans du prototype. Seul le chrono "depuis 10:30" reste statique
(pas un vrai décompte).

**Alignements forts, confirmés précisément contre le Blueprint.**
- **"Déjà réalisé"** (§9, Mode Action) — correspond exactement aux badges `presence-done` du
  prototype : une action validée en Mode Action reste visible en Présence et disparaît du récapitulatif
  de Clôture plutôt que d'y être reproposée. Match textuel, pas seulement fonctionnel.
- **Mode Interruption/Recovery (PP-011)** — "dernier sujet + dernière note capturée, action unique
  Reprendre" (§9) correspond précisément à `renderRecovery()`/`doResume()`.
- **PP-015 ("Rien à signaler")** — `quickClose()` implémente exactement la clôture rapide sans
  contenu décrite au §9.
- **Frontière de Workspace (§11, table PP-014)** — le "Rappel de fin de journée" que WS-003
  n'affiche pas lui-même est explicitement attribué à WS-006 dans le Blueprint. La carte
  "Consultations encore ouvertes" de WS-006 (construite plus tôt dans cette session, avant la lecture
  de ce passage) **est** ce rappel — alignement confirmé a posteriori, pas conçu comme tel au départ.
- **OQ-W-013 (Resolved)** — Ordonnance/Orientation/Examen/Courrier/Rendez-vous comme 5 sorties
  distinctes : exactement les 5 tuiles du Mode Action du prototype.

**Déviations confirmées, précises — pas de simples rappels de la session précédente.**
- **Contexte patient permanent.** PP-009 §Scope dit explicitement *"No persistent sidebars, no
  auto-updating panels."* PP-010 dit explicitement *"Accessing information [...] SHALL replace the
  primary view — not layer over it [...] No split-screen during consultation."* Le prototype fait
  l'inverse sur les deux points à la fois (colonne latérale fixe, décision consciente du Product Owner,
  déjà actée). Ce n'était pas seulement une tension avec le "Cognitive Contract" en général (§2) — ce
  sont deux clauses de Scope nommément citées, contredites nommément.
- **Barre d'onglets visible en permanence.** Le Blueprint décrit une "architecture de modes" sans
  aucune chrome persistante en dehors des 3-4 icônes de Mode Présence — Mode Lookup et Mode Action sont
  tous deux explicitement "plein écran — remplace Mode Présence." Une barre d'onglets visible dans
  tous les modes est elle-même une forme de persistance/layering, renforçant la déviation PP-010
  ci-dessus plutôt qu'une déviation séparée.
- **Notes multiples (`validatedNotes`, array).** C'est la déviation la plus significative, **jamais
  formalisée comme telle au moment de sa construction.** PP-012 : *"The consultation note SHALL be
  free text"* — singulier. PP-013 : *"Ce qui est saisi [en Mode Capture] alimente **la même note** que
  le Mode Clôture — pas un objet distinct."* La table des sorties de Mode Clôture (§9) liste **une
  seule** "Note de consultation" comme sortie. Le prototype construit l'inverse : une liste ouverte de
  notes indépendantes, chacune validée séparément comme Clinical Contribution immuable. Contrairement à
  l'extension Mode Action (PP-013, amendement explicite et daté du 2026-09-10), **cette déviation n'a
  reçu aucun amendement formel du Blueprint** — elle a été construite directement en session, sur
  demande explicite ("pouvoir créer plusieurs notes"), sans jamais revenir corriger PP-012/013. À
  traiter avant Phase 3/4 : soit amender PP-012/013 formellement (comme pour Mode Action), soit
  reconnaître que le prototype a dérivé sans décision.

**Données nécessaires.** Conformes au Blueprint pour Mode Action/Clôture (5 types de sortie). Non
couvertes : persistance réelle du Brouillon au-delà de la session navigateur (`currentDraft` est un
état JS volatile, pas un Aggregate — cf. `H-ES-001`, Hotspot Domain toujours `Open`, voir §trous
identifiés en Phase 1).

**États.** Présence, Draft (par clé), Action, Interruption/Recovery, Clôture — tous implémentés.
Non implémenté : consultation s'étendant sur plusieurs sessions (OQ-W-010, toujours `Open`).

**Erreurs / cas limites non couverts.**
- OQ-W-014 (sens de "Rien à signaler" quand des actions ont déjà été validées en Mode Action) — reste
  `Open`, correctement signalé dans le `hyp-note` du prototype depuis sa construction, pas résolu ici.
- Une seule consultation en pause à la fois (`consultationPaused`, booléen global) — limite connue,
  signalée dans le prototype, non corrigée.
- Transcription IA (bouton "🎙️ Transcrire via IA") — correctement rattachée à PDX-001 (`Discovery`,
  RG-002/RG-003 : aucun PP de WS-003 n'est modifié tant que PDX-001 n'est pas testé et validé). Le
  prototype respecte cette règle — l'IA ne fait que proposer un contenu dans un Brouillon, jamais
  d'écriture directe.

**UX.** Renvoi au prototype v8 — avec deux niveaux de déviation à traiter distinctement avant Phase
3/4 : les déviations **conscientes et déjà actées** (contexte permanent, onglets) contre la déviation
**non formalisée** (notes multiples). Les deux premières ont été des décisions explicites du Product
Owner, tracées dans le code au moment de la décision. La troisième ne l'a pas été — c'est la correction
la plus importante à faire avant de considérer WS-003 comme une base stable pour l'engineering.

### Requalification ADR-0025 (2026-10-06)

> Lecture [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md). WS-003 est le Gold
> Standard : ses PP restent normatifs. Les trois déviations relevées ci-dessus ne sont plus des
> "dérives" : ce sont des **hypothèses explicites en concurrence avec un PP**, chacune avec un critère
> d'abandon qui ramène au PP. **Aucun PP n'est amendé par cette section** — l'amendement (comme pour
> Mode Action, v2.8) ne se fera qu'après résultat du test. Cela règle le statut de la déviation "notes
> multiples" (qui n'est plus non tracée), pas la question elle-même. "Majorité" = plus de la moitié
> des praticiens du round.

| HYP | Élément | Origine | PP en concurrence | Problème visé |
|---|---|---|---|---|
| 001 | Carte "Contexte patient" permanente | Founder-Driven (PO, décision consciente) | PP-009 §Scope, PP-010 | Retrouver le contexte vite sans quitter l'échange |
| 002 | Barre d'onglets persistante | Founder-Driven | PP-010 | Même que 001 + historique des actions (demande PO) |
| 003 | Notes multiples | Founder-Driven (demande PO) | PP-012, PP-013, sorties de Clôture §9 | Aucun ancrage — à documenter |
| 004 | Modèles (ordonnance) dans le Brouillon | Founder-Driven | — | Aucun ancrage — à documenter |

```
HYP-003-001 — Contexte patient permanent
Hypothèse:          Garder allergies, pathologies et traitement visibles évite les allers-retours sans
                    détourner l'attention du patient
Risque si faux:     Exactement ce que PP-010 protège : attention captée par l'écran, charge visuelle
                    pendant la relation
Test:               Consultation simulée : le praticien consulte-t-il la carte ? Mesurer les passages
                    en Lookup ; demander s'il s'est senti distrait
Critère d'abandon:  La majorité ne la regarde pas pendant l'échange, ou se dit distraite → retour à
                    PP-010 (Lookup plein écran à la demande)
Statut:             ? ⚠ — À tester · PP-009/PP-010 restent normatifs

HYP-003-002 — Onglets persistants
Hypothèse:          Une navigation visible permet de retrouver historique, notes et actions sans
                    mémoriser des modes
Risque si faux:     Chrome permanente contraire à l'architecture de modes (§9)
Test:               Couplé à HYP-003-001 ; tâche "retrouvez la dernière ordonnance" — onglet ou Lookup ?
Critère d'abandon:  Abandon conjoint avec HYP-003-001, ou si la majorité ne passe jamais par les onglets
Statut:             ? ⚠ — À tester

HYP-003-003 — Notes multiples
Hypothèse:          Un praticien veut séparer ses notes au cours d'une même consultation (par sujet, par
                    moment)
Risque si faux:     Fragmentation ; Capture (PP-013) ne sait plus quelle note alimenter ; Clôture moins
                    lisible
Test:               Consultation simulée à deux sujets : le praticien crée-t-il une 2ᵉ note sans y être
                    invité ? Pourquoi ?
Critère d'abandon:  La majorité écrit une seule note → retour à une note unique (PP-012/013)
Statut:             ? ⚠ — À tester · PP-012/PP-013 restent normatifs. Côté Domain, aucune
                    contradiction relevée (chaque note validée = une Clinical Contribution, CAL-001) —
                    la question est de produit, pas de Domain

HYP-003-004 — Modèles dans le Brouillon
Hypothèse:          Pré-remplir un brouillon à partir d'un modèle accélère les sorties répétitives
Risque si faux:     Contenu générique non relu, validé tel quel
Test:               Le praticien utilise-t-il le modèle ? Le modifie-t-il avant validation ?
Critère d'abandon:  Non utilisé par la majorité → retiré. Validé sans relecture → maintenu mais
                    l'action de validation doit être revue (CAL-I-003, validation explicite)
Statut:             ? ⚠ — À tester
```

### Décisions du 2026-10-06 — « À traiter » et fiche patient

**Reste-à-faire de consultation → « À traiter »** — `Product Decision` (Founder-Driven, evidence ?).
Inscrit en ⚠ dans §9 (Mode Clôture) et §11 (table des frontières). Déjà fondé dans le Blueprint :
PP-011 (*"pending items"*), Mode Interruption (*"Items marqués pour suivi"*), Mode Clôture
(récapitulatif + reste-à-faire, v2.8). Seule nouveauté : la destination.

**Fiche patient (données administratives)** — `Product Decision` + `Architecture Constraint`
(ADR-0010 Invariant 3). Accessible depuis WS-003 sans quitter la consultation. **Forme dans WS-003 :
déjà fixée par PP-010** (*"replace the primary view — not layer over it [...] returning SHALL require
one action only"*) — Lookup plein écran, état de consultation conservé. Un drawer, modal ou panneau
superposé serait une hypothèse en concurrence avec PP-010, au même titre que HYP-003-001 ; aucune
n'est ouverte à ce jour. Voir [CARE-RECORD-implementation](CARE-RECORD-implementation.md).

```
HYP-003-005 — Noter une action pendant une interruption
Origine:            Founder-Driven — Innovation
Problème visé:      PP-011 / PAT-W-002 (pas d'outil de reprise après interruption). Pour la demande
                    d'un confrère pendant la consultation : aucun ancrage corpus — à documenter ;
                    rejoint HR-001 H-VRB-001 (transmission verbale, Open)
Hypothèse:          Pouvoir noter en quelques mots une action à faire au moment de l'interruption, sans
                    traiter la demande, évite de la perdre ou de la garder en tête
Valeur attendue:    Reprendre la consultation l'esprit libre ; retrouver l'action dans « À traiter »,
                    provenance Interruption
Risque si faux:     Chrome supplémentaire en consultation (PP-009) ; l'action concerne souvent un
                    AUTRE patient que celui de la consultation — tension avec PP-010 (un seul focus).
                    Garde-fou : saisie en texte libre, patient facultatif, aucun contexte de l'autre
                    patient ouvert dans WS-003
Test:               Scénario d'interruption scripté (confrère demande un rappel concernant un autre
                    patient) : le praticien utilise-t-il la saisie ? Préfère-t-il papier ou mémoire ?
Critère d'abandon:  La majorité ne l'utilise pas ou préfère un autre support → retrait. Placement :
                    en Mode Interruption uniquement ; Mode Recovery garde son action unique "Reprendre"
Statut:             ? ⚠ — À tester. Côté écriture : source de vérité non définie (HR-001, question
                    Domain ouverte du 2026-10-06)
```

**OQ-W-011** (rappel de fin de journée : push ou tableau de bord ?) — partiellement couverte : la
présence au tableau de bord passe par le compteur « À traiter » de Mon espace. La question du push
reste `Open`.

**PDX-001 (transcription IA)** : déjà sous cycle PDX, aucun PP modifié. Mais PDX-001 n'a **pas de
critère d'abandon** déclaré, et ADR-0025 le rend obligatoire. Proposition, à confirmer avant le
round : *la majorité refuse l'enregistrement, ou corrige plus de la moitié de la synthèse proposée →
PDX-001 abandonné (RG-004)*. Non reporté dans PDX-001 sans validation.

---

## 17. Évolution

| Version | Date | Nature |
|---|---|---|
| 3.2 | 2026-10-06 | Décisions produit du 2026-10-06 : ⚠ ajout §9 (Mode Clôture) et §11 (table des frontières) — le reste-à-faire non traité à la clôture alimente « À traiter », collection unique dont WS-003 n'est pas propriétaire (Founder-Driven, evidence ?, aucun PP modifié). §16 : HYP-003-005 (noter une action pendant une interruption, Innovation) ; fiche patient accessible en Lookup, forme fixée par PP-010 ; OQ-W-011 partiellement couverte. |
| 3.1 | 2026-10-06 | Requalification [ADR-0025](../../adr/ADR-0025-innovations-produit-non-observees.md) (§16) : contexte permanent, onglets persistants et notes multiples deviennent des hypothèses explicites en concurrence avec PP-009/010 et PP-012/013 (HYP-003-001 à 003), critère d'abandon = retour au PP. **Aucun PP amendé.** HYP-003-004 (modèles). PDX-001 sans critère d'abandon — proposition formulée, non reportée. |
| 3.0 | 2026-10-05 | §16 ajoutée — Fiche d'implémentation (Phase 2, freeze V1). Alignements forts confirmés (Mode Action/"Déjà réalisé", Interruption/Recovery, PP-015, frontière WS-006). Déviations précisées : contexte permanent et onglets persistants contredisent nommément PP-009 §Scope et PP-010 (pas seulement le Cognitive Contract en général) ; notes multiples contredisent PP-012/PP-013 et la table des sorties de Mode Clôture — **jamais amendée formellement**, contrairement à l'extension Mode Action qui l'a été. Transcription IA correctement rattachée à PDX-001, aucun PP modifié. |
| 2.9 | 2026-09-10 | **Résolution OQ-W-013** (décision Founder-Driven). "Courrier" et "Orientation/référence" sont deux sorties distinctes, pas un renommage l'une de l'autre — un praticien peut produire les deux séparément sur la même consultation. Mode Action (§9) mis à jour : 5 choix (Ordonnance / Orientation / Examen / Courrier / RDV) au lieu de 4. "Actions optionnelles" de Mode Clôture annoté en conséquence (+ courrier). Table des sorties (§9) : annotation "statut non tranché" retirée de la ligne Courrier. OQ-W-013 marquée Resolved (§14). OQ-W-014 (sens de "Rien à signaler") reste seule ouverte. |
| 2.8 | 2026-09-10 | **Amendement — extension PP-013 (décision Founder-Driven, evidence ?, non testée).** Suite à la confirmation explicite de l'option (a) sur le "Nouveau parcours" WS-003 : les actions de production (Ordonnance, Rendez-vous, Examen, Courrier), jusqu'ici réservées à Mode Clôture, deviennent accessibles pendant la consultation via un nouveau **Mode Action** (§9), symétrique à Mode Lookup — plein écran, retour explicite, déclenché par une 4ᵉ icône en Mode Présence (▤ Agir). PP-009/PP-010 ne sont pas modifiés (même budget minimal). Mode Clôture devient récapitulatif + reste-à-faire, plus l'unique porte d'entrée ; "Rien à signaler" (PP-015) préservé tel quel. "Courrier" ajouté à la table des sorties, statut non tranché (renommage d'Orientation ou sortie distincte — OQ-W-013). OQ-W-013 et OQ-W-014 ajoutées. Table §11 (frontière WS-004) flaguée comme obsolète suite à WBD-004 v2.3 (NO-WORKSPACE), non corrigée ici — hors scope de cet amendement. Rien retiré du texte v2.7 ; toutes les additions sont marquées ⚠ et datées in situ. |
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
