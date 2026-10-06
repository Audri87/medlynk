# GOV-000 — MedLink Governance v1.0

| Field | Value |
|---|---|
| ID | GOV-000 |
| Version | 1.9 |
| Status | **Accepted** — convention de marqueurs et chaîne de Gates contraignantes pour tout nouvel artefact |
| Date | 2026-08-04 |
| Nature | Charte de gouvernance — chaîne de responsabilité complète, de Reality à Software et retour |
| Supersede / englobe | [PRODUCT-PIPELINE-v1.0.md](../product/PRODUCT-PIPELINE-v1.0.md) (niveau macro — voir §7, Réconciliation) |
| Gouverne | Tous les artefacts de `docs/` — CWRM, Product, UX, Engineering, Validation |

> Ce document répond à une question simple : **qui décide quoi, avec quelle preuve, et dans quel
> ordre ?** Il ne remplace aucune méthode existante (CWRM, Product Pipeline) — il les situe les unes
> par rapport aux autres et fige le langage commun (symboles, Gates) qui les traverse toutes.

---

## 1. Les six niveaux

```
Niveau 0 — Reality (Immutable)
    │  Interviews · Observations terrain · Tests utilisateurs · Analytics
    │  Question : Que se passe-t-il réellement ?
    │  Aucune décision produit ici.
    ▼
Niveau 1 — Discovery (CWRM)
    │  ACT → OBS ✓ → PAT ≈ → Tensions ⚠ → Corpus Gaps ?
    │  Mission : transformer les observations en connaissance structurée.
    │  Aucune décision produit.
    ▼
Niveau 2 — Product
    │  Workspace Evidence (WE) → [Workspace Boundary Decision (WBD), si le périmètre est contesté]
    │                          → Product Decision Record (PDR) → Workspace Blueprint
    │                          → ou, en parallèle, Product Discovery (PDX) — voir §1bis
    │  Mission : transformer la connaissance en décisions produit — ou explorer une solution
    │            qui n'en découle pas directement, avant de décider (§1bis).
    ▼
Niveau 3 — Design
    │  User Flow → Wireframe → Prototype → Tests
    │  Mission : transformer les décisions en expérience utilisateur.
    ▼
Niveau 4 — Engineering
    │  ADR → Architecture → Symfony → Tests techniques
    │  Mission : transformer l'expérience en logiciel.
    ▼
Niveau 5 — Validation
    │  Tests praticiens → Feedback → Analytics → Reality
    │  La boucle se referme.
```

**Le principe fondamental :**

```
Reality → Discovery → Decision → Experience → Software → Reality
```

Une seule chaîne de responsabilité. Chaque flèche est un passage de relais, jamais un raccourci.

---

## 1bis. Product Discovery (PDX) — v1.4, remplace le "circuit Innovation" (v1.3)

> **Renommage délibéré (v1.4).** "Innovation" biaisait la réflexion vers la technologie — une
> amélioration peut être un simple bouton déplacé. Le mot juste est **Product Discovery** : l'objectif
> n'est pas d'être innovant, c'est de découvrir une meilleure solution.
>
> **Désambiguïsation obligatoire — deux "Discovery" distincts dans GOV-000, à ne jamais confondre :**
> - **Discovery** (Niveau 1, CWRM) = décrit le présent à partir du corpus. Contraint, empirique.
> - **Product Discovery (PDX)** = explore des solutions possibles à une friction identifiée par le
>   corpus, sans que le corpus les décrive. Exploratoire, pas empirique au sens CWRM.
>
> **Principe fondamental :** Le terrain révèle les problèmes. Le Product explore les solutions. Les
> praticiens valident les solutions. Reformulation de la philosophie MedLink (v1.4) : *"Les problèmes
> viennent du terrain. Les solutions peuvent venir du terrain, du Product, de la technologie ou de la
> recherche. Elles doivent toutes être validées par le terrain avant de devenir des décisions
> produit."* — remplace l'ancienne formulation implicite "toutes les décisions viennent du terrain",
> devenue trop étroite pour couvrir ce que ce document autorise désormais.

### Position dans la gouvernance

```
Reality
    │
    ▼
Discovery (CWRM)
    │
    ▼
Workspace Evidence (WE)
    │
    ├──────────────────────┐
    │                       │
    ▼                       ▼
Product Decision        Product Discovery
(PDR)                   (PDX)
    │                       │
    ▼                       ▼
Blueprint            Prototype exploratoire
    │            (Product layer — PRÉ-Blueprint,
    │             jamais confondu avec le Prototype
    │             de Design/Niveau 3, qui vient APRÈS
    │             un Blueprint)
    │                       │
    └───────────┬───────────┘
                ▼
        Validation praticiens
                ▼
        Product Principle
```

Le PDR et le PDX partent tous deux de WE, mais ne poursuivent pas le même objectif :

| | PDR | PDX |
|---|---|---|
| Verbe | Décider | Explorer |
| Fondement | Evidence (corpus) | Opportunité (friction + solution non observée) |
| Produit | Une spécification | Un prototype exploratoire |
| Réduit | L'incertitude de conception | L'incertitude d'innovation |
| Peut mener directement à | Un Blueprint | **Jamais** directement à un Blueprint |

### Cycle d'un PDX

```
Friction observée (WE)
    ↓
Opportunité (solution non observée par le corpus)
    ↓
Hypothèse testable
    ↓
Prototype exploratoire
    ↓
Tests praticiens
    ↓
Validation / Rejet
    ↓ (si validé uniquement)
PDR → Blueprint
```

**Format d'un PDX (`PDX-NNN`)** — voir [PDX-001](../product/discovery/PDX-001-capture-clinique-assistee.md)
pour un cas réel complet :

```
PDX-NNN — [Titre]
Origine:                [WE-XXX dont ce PDX découle]
Friction:                [ce que le corpus montre — la douleur documentée]
Hypothèse:               [la solution explorée — jamais présentée comme venant du corpus]
Hypothèses à tester:     [liste — ce que le prototype/test doit vérifier]
Ce que le corpus prouve: [limité, explicite]
Ce que le corpus ne prouve pas: [limité, explicite — la partie la plus importante du document]
Prototype:               Oui/Non
Blueprint:                Non (toujours, tant que non validé)
Statut:                  Discovery (PDX) — jamais Décidé, jamais →
```

### Règles de gouvernance (RG)

- **RG-001** — Un PDX ne peut être créé que si une friction est explicitement documentée dans un WE.
  Pas de PDX sans ancrage à une PAT ou un GAP réel.
- **RG-002** — Un PDX ne crée jamais de Product Principle. Il ne peut qu'ouvrir un PDR, après
  validation.
- **RG-003** — Un PDX doit être validé par un prototype exploratoire ou un test terrain avant toute
  décision produit. Aucun raccourci vers Gate 1 (conditions Discovery) ou Gate 2 (PDR direct).
- **RG-004** — Un PDX peut être abandonné sans impact sur le reste du produit. L'échec fait partie du
  processus — un PDX rejeté n'est pas un échec de gouvernance, au même titre qu'un PDR concluant qu'il
  est prématuré de décider (§4, Gate 2, v1.2).

**Application à l'échelle d'un élément d'écran (v1.9, [ADR-0025](../adr/ADR-0025-innovations-produit-non-observees.md)).**
Un élément non observé (bloc, action, état) n'exige pas un PDX complet : une fiche `HYP-<WS>-NNN`
inline dans la fiche du Workspace suffit (Origine, problème visé, hypothèse, valeur attendue, risque
si faux, test, **critère d'abandon**, statut). Le **critère d'abandon est obligatoire et déclaré avant
le test** — seul ajout d'ADR-0025 à la discipline PDX. RG-001 à RG-004 inchangées : un élément sans
friction documentée reste autorisé en prototype (Origine `Founder-Driven`) mais ne peut pas devenir
PDX. Code produit : uniquement après Gate 3 (§4) — voir ADR-0025 §5 pour les types de code autorisés
avant.

**Deux dérives que ces règles préviennent, symétriques et aussi graves l'une que l'autre :**
1. *"Le corpus ne parle pas de X, donc on ne peut pas le faire."* Faux — le corpus décrit des douleurs,
   pas toutes les solutions possibles (RG-001 l'autorise explicitement, à condition que la douleur soit
   réelle).
2. *"La technologie peut tout faire, donc faisons X partout."* Faux également — un PDX doit toujours
   partir d'une friction documentée (RG-001), jamais d'une capacité technologique seule.

### Indicateur d'Origine (v1.4) — obligatoire sur tout artefact Product

| Origine | Signification |
|---|---|
| **Evidence-Driven** | Décision directement fondée sur le corpus (OBS ✓ / PAT ≈) |
| **Discovery-Driven** | Solution exploratoire ayant passé le cycle PDX (friction → hypothèse → prototype → test validé) |
| **Constraint-Driven** | Décision imposée par une contrainte externe (réglementation, sécurité, technique, interopérabilité) |
| **Founder-Driven** *(ajout, à confirmer)* | Décision prise directement par le porteur produit, hors des trois circuits ci-dessus — ex. les décisions Model C de WS-003 (PP-012 à PP-015 à leur origine). Catégorie nécessaire : sans elle, plusieurs Product Principles déjà gelés dans le Gold Standard n'ont aucune case où se ranger. Une décision Founder-Driven reste légitime mais devrait, dans l'idéal, migrer vers Evidence-Driven ou Discovery-Driven avec le temps — pas y rester indéfiniment. |

> **Note.** L'Origine décrit *comment l'idée est née*, pas son niveau de preuve actuel (qui reste porté
> par ✓/≈/?/→/⚠, §3). Une décision Founder-Driven dont l'evidence est ensuite renforcée par un WE
> (ex. PP-013/014, voir Changelog v1.2) reste Founder-Driven dans son Origine — seule son evidence
> change. Ne jamais réécrire l'historique d'origine d'une décision a posteriori.

---

## 1ter. Deux clarifications (v1.5)

### a) Le vocabulaire Product ne descend jamais dans le Domain — règle gelée, non conditionnelle

Workspace, WBD, PDX, Origine, Cognitive Responsibility (ci-dessous), et tout futur concept de
gouvernance Product sont des outils de raisonnement pour l'équipe Produit. **Aucun d'eux n'a le droit
d'exister comme concept Domain** — pas d'enum, pas de colonne, pas d'agrégat qui porterait leur nom.
CLAUDE.md le dit déjà pour Workspace ("Workspace = Projection... never manually build... always
compute") et pour le Kernel ("must NOT know Patient, Practitioner, Care Record"). Cette charte
l'étend explicitement à tout artefact qu'elle introduit : **si un jour un ticket Engineering référence
"Cognitive Responsibility" comme table, colonne ou classe Domain, c'est une violation de frontière
hexagonale, à traiter avec la même sévérité qu'une fuite du Kernel vers le Domain.** Le vocabulaire
Product peut changer de nom trois fois dans une session (ça vient d'arriver : Innovation→PDX,
Documentation→Continuity/à confirmer) précisément *parce qu'*il ne touche jamais le Domain — c'est ce
qui rend ce vocabulaire sûr à faire évoluer vite.

### b) Cognitive Responsibility — statut : hypothèse méthodologique en expérimentation, pas gouvernance officielle

> **Ceci n'est pas une couche gelée.** Elle est testée sur deux Workspaces réels (WS-005, puis
> WS-006) avant toute intégration officielle — voir critère de sortie ci-dessous. Traiter la méthode
> elle-même comme un produit : formuler l'hypothèse, l'expérimenter, la valider ou la rejeter,
> exactement la discipline déjà imposée à un PDX (RG-001 à RG-004), appliquée cette fois à la
> gouvernance elle-même.
>
> **Extension v1.6 :** le test initial ne portait que sur WS-005. Décision (2026-08-06) : la
> résistance de la méthode sur un seul Workspace ne suffit pas à conclure — elle doit tenir sur
> WS-005 **et** WS-006 avant adoption officielle. Un résultat positif sur WS-005 seul reste un
> résultat partiel, pas une validation.

**Hypothèse :** un niveau `Responsibility` au-dessus de `Product Question → Workspace` stabilise la
construction d'un Workspace (moins de changements de Product Question en cours de route) et délimite
mieux sa frontière avec les Workspaces voisins.

**Relation avec Clinical State (si l'hypothèse est confirmée) :** une Responsibility n'est **pas** une
paire (Current State, Target State). C'est un **cluster stable d'états** du modèle de travail
illustratif PERDU/ORIENTÉ/COMPREND/ÉCOUTE/DÉCIDE/DOCUMENTE/CONTINUE (WS-003 §6, *"Illustrative
Cognitive Flow"*). Les transitions *à l'intérieur* d'un cluster sont le flux normal de travail. Les
transitions *entre* clusters sont les événements d'interruption / perte de contexte — c'est
exactement ce que PP-011 (WS-003, "Interruptions must be recoverable") protège déjà : la transition
DÉCIDE → PERDU traverse Clinical Interaction → Clinical Orientation. Réduire Responsibility à un
simple couple Current/Target supprimerait le vocabulaire nécessaire pour exprimer cette transition-là
— donc, si l'hypothèse est retenue, **ce modèle de travail n'est pas remplacé, il devient le graphe
fin qui vit à l'intérieur et entre les Responsibilities.**
>
> **Correction 2026-08-06 (Sprint M1.1, réponse à la Critique Q4.3 de la revue d'architecture M1).**
> Le paragraphe ci-dessus citait *"le modèle Clinical State existant"*, formulation qui lui prêtait
> une autorité établie. Or WS-003 §6 qualifie ce même diagramme de *"simplification pédagogique... Ce
> n'est pas ce qui se passe réellement"*, et précise que *"le raisonnement clinique est hors du
> domaine logiciel (DE-P-001, DE-P-002)"*. Ce diagramme n'existe dans aucun document du track Domain
> (`docs/domain/`, `docs/adr/`, `docs/clinical/`) — recherche exhaustive, résultat négatif. Il reste
> utilisable comme vocabulaire de travail **Product**, à condition de ne jamais être présenté comme un
> modèle Domain établi. Cette clarification ne change aucune décision ; elle corrige uniquement une
> formulation qui aurait pu laisser croire le contraire.

**Protocole de test (v1.6 — étendu à deux Workspaces) :**
1. Construire WS-005 en partant réellement de `Responsibility → Product Question → Workspace`, sans
   retour en arrière théorique.
2. Rétrospective à la fin de WS-005 :
   - Moins de churn de Product Question que WS-004 (qui en a eu trois) ?
   - La Responsibility a-t-elle réellement stabilisé les décisions prises en cours de route ?
   - A-t-elle aidé à mieux délimiter WS-005 par rapport à ses voisins (WS-004, WS-006) ?
3. **Répéter l'exercice sur WS-006**, avec les trois mêmes questions (churn vs Workspace précédent,
   stabilisation, délimitation vis-à-vis de ses voisins).
4. **Si oui aux trois critères, sur WS-005 *et* WS-006 : la couche est intégrée officiellement à
   cette charte (nouvelle version majeure, avec Gate et artefact dédiés si nécessaire).** Si le
   résultat diverge entre les deux Workspaces (positif sur l'un, négatif sur l'autre), l'hypothèse
   n'est pas validée en l'état — documenter la divergence plutôt que trancher par défaut. Si non aux
   deux : l'hypothèse est rejetée et documentée comme telle — un rejet n'est pas un échec de
   gouvernance, au même titre qu'un PDX abandonné (RG-004).

**Nommage — leçon appliquée par avance.** "Collaboration" est déjà un nom de Plateforme dans
CLAUDE.md (`src/Platforms/Collaboration/`). Nommer un Workspace "Collaboration" reproduirait la
collision "Clinical Memory" / Care Record identifiée sur WS-004. Le nom de Responsibility candidat
pour WS-005 (**Clinical Coordination**) est préféré à "Collaboration" pour cette raison, avant même
que la question ne se pose formellement.

---

## 2. Les responsabilités

| Couche | Responsable | Question |
|---|---|---|
| Reality | Terrain | Que se passe-t-il ? |
| Discovery | CWRM | Que savons-nous ? |
| Product | Product Owner | Que choisissons-nous ? |
| Design | UX | Comment cela fonctionne-t-il ? |
| Engineering | Tech Lead | Comment l'implémenter ? |
| Validation | Toute l'équipe | Avions-nous raison ? |

Chaque couche a une responsabilité unique. Une couche ne produit pas les artefacts d'une autre — le
CWRM ne décide pas de Product Principle, le Product ne dessine pas de wireframe, l'Engineering ne
réinterprète pas une Décision Produit qu'il juge mal fondée (il la remonte, il ne la contourne pas).

---

## 3. Convention des marqueurs (gelée)

| Symbole | Signification |
|---|---|
| ✓ | Confirmé par le corpus |
| ≈ | Pattern probable |
| ? | Gap ou inconnue — absence de donnée ou question non résolue |
| → | Décision produit |
| ⚠ | Point à valider avant le prochain Gate |

Ces cinq symboles sont le langage commun de toute l'équipe, sur tout document, à toute couche.

**Note de composition — comment lire un artefact à la couche Product.** Un artefact de niveau 2
(Product Decision Record, Product Principle) porte en général deux informations distinctes, et les
deux utilisent ce même alphabet :

- son **ancrage** — la qualité de la preuve qui le sous-tend (✓, ≈, ou ? si aucune preuve directe) ;
- son **statut de décision** — → dès qu'un choix a été fait, indépendamment de la qualité de l'ancrage.

Une décision peut donc s'écrire `→ (evidence: ≈)` (choix fait, appuyé sur un pattern probable) aussi
bien que `→ (evidence: ?)` (choix fait, sans ancrage corpus — cas des décisions fondateur type Model
C). **Le symbole → ne dit jamais "validé".** Seule la Validation (Niveau 5) peut le dire. Un ⚠ reste
attaché à toute décision dont l'ancrage est ? ou ≈, tant que le Gate suivant ne l'a pas levé.

> Un Corpus Gap (absence de donnée documentée dans le corpus CWRM) et une hypothèse produit (idée
> proposée mais non testée) partagent le même symbole `?` par choix de simplicité de ce langage commun.
> Là où la distinction structurelle importe (par ex. §3 d'un Workspace Blueprint), elle reste portée
> par la table et l'identifiant (`GAP-X-NNN` vs `HYP-X-NNN`), pas par un symbole séparé.

**Confiance d'un Pattern — obligatoire, jamais laissée au lecteur.** Tout `≈` doit afficher sa
confiance à côté du symbole, calculée sur la proportion de profils/sources convergents parmi ceux
disponibles :

| Confiance | Seuil |
|---|---|
| HIGH | ≥ 65% des profils disponibles convergent |
| MEDIUM | 30% à 65% |
| LOW | < 30% |

Un Pattern soutenu par 7/9 profils (78%) et un Pattern soutenu par 2/9 (22%) ne doivent jamais
s'afficher de façon visuellement équivalente. Format attendu : `PAT-X-NNN — ≈ HIGH — Confidence N/M
(pourcentage)`.

**Tension — nouvelle catégorie Discovery (v1.1).** Une Tension (`TEN-X-NNN`, marqueur `⚠`) documente
un comportement **directement opposé** entre deux sources/profils sur le même axe — à ne pas confondre
avec un Corpus Gap (absence de donnée) ni un Pattern (convergence). Une Tension signale qu'un Product
Principle universel est probablement le mauvais outil pour ce comportement ; une Display Rule ou un
choix de conception assumé (avec un camp perdant explicite) l'est davantage. Une Tension n'est jamais
résolue par la moyenne des deux positions — elle est tranchée, ou explicitement portée comme Open
Question jusqu'à Gate 1.

---

## 4. Les Quality Gates

Chaque Workspace, chaque feature, franchit les mêmes portes. Aucune porte ne se saute.

### Gate 1 — Discovery → Product

Conditions :
- ACTs suffisants
- OBS consolidées
- PAT identifiés
- Gaps explicités

➡️ Autorise le passage en Product.

### Gate 2 — Product → Design

Conditions :
- Workspace Evidence (WE) validé
- Product Decision Record (PDR) rédigé
- Workspace Blueprint validé

➡️ Autorise le passage en UX.

**Règle v1.2 — un PDR a le droit de conclure qu'aucune décision ne peut encore être prise.** Ce n'est
pas un échec du PDR — c'est l'une de ses deux issues valides, au même titre qu'une décision positive.
Un PDR qui démontre qu'il est prématuré de décider a rempli sa mission : il évite un Blueprint construit
sur une preuve insuffisante. Cette issue **bloque** Gate 2 (le Blueprint n'est pas rédigé) mais ne
bloque pas le Workspace lui-même : voir le statut `Research Workspace` ci-dessous.

**Statut `Research Workspace — Boundary under investigation`.** Un Workspace dont le périmètre reste
disputé (recouvrement avec un autre Workspace, responsabilité non unique) n'est ni en `Discovery
Blueprint` (le périmètre y est supposé acquis) ni abandonné. Il porte ce statut tant qu'un
**Workspace Boundary Decision (WBD)** n'a pas tranché sa frontière. Un Workspace en `Research Workspace`
ne peut pas produire de Blueprint — seule une Discovery Question unique, ciblée sur la frontière
elle-même (pas sur le contenu du Workspace), peut le faire progresser.

**Règle v1.8 — un WBD a le droit de conclure qu'une responsabilité ne revient à aucun Workspace.**
Symétrique à la Règle v1.2 ci-dessus, pour la même raison : ce n'est pas un échec du WBD, c'est l'une
de ses issues valides (verdict `NO-WORKSPACE`, §5). Avant d'attribuer une responsabilité à une partie
nommée Workspace, le WBD vérifie que cette partie satisfait la définition de `WSP-001` (projection
assemblée pour un Actor). Une partie qui échoue à ce contrôle ne peut pas recevoir de statut Workspace,
quelle que soit par ailleurs la qualité de la responsabilité qu'on cherchait à lui attribuer — cette
responsabilité reste valide, mais relève d'un autre artefact (typiquement un ADR côté Engineering).
Origine de cette règle : le cas WS-004 (`OBS-M2-013`, `ADR-0024`), qui a révélé que le format WBD
antérieur à v1.8 ne posait jamais la question d'éligibilité avant de chercher à attribuer une
responsabilité — WS-004 reste le cas qui a fait apparaître ce besoin, pas une exception réécrite pour
lui : sa propre reclassification (`WBD-004` v2.2) n'est pas modifiée rétroactivement par cette règle.

### Gate 3 — Design → Engineering

Conditions :
- Prototype basse fidélité
- Tests sur au moins 5 praticiens
- Ajustements intégrés

➡️ Autorise le passage en Engineering.

### Gate 4 — Engineering → MVP

Conditions :
- Architecture validée
- API définies
- Tests unitaires
- Intégration

➡️ Autorise le passage en MVP.

### Gate 5 — Validation → Reality

Conditions :
- Usage réel
- Mesures
- Feedback
- Nouvelles observations

➡️ Retour vers Reality — la boucle se referme.

**Correspondance avec le vocabulaire déjà en usage dans les Workspace Blueprints :** le statut
`Discovery Blueprint` (WS-003) se situe avant Gate 1 ; `Corpus Consolidated` marque le franchissement
de Gate 1 ; `Candidate for Prototype` marque Gate 2 ; `Validated Prototype` marque Gate 3. Un
Blueprint doit exposer une **Definition of Done** par Gate à franchir — voir WS-003 §7 comme référence.

---

## 5. Les artefacts officiels

```
/discovery
├── ACT
├── OBS
├── PAT
├── Tension (divergence non résolue entre profils, v1.1)
└── WE (Workspace Evidence — trait d'union vers Product)

/product
├── WBD (Workspace Boundary Decision — quand le périmètre est contesté, v1.2)
├── PDX (Product Discovery — circuit parallèle exploratoire, v1.4, voir §1bis)
├── PDR (Product Decision Record)
└── Workspace Blueprint

/ux
├── Prototype
└── Test Report

/engineering
├── ADR
├── Architecture
└── API

/validation
├── Field Report
└── Metrics
```

Aucun autre type de document n'est officiel. Un document qui ne rentre dans aucune de ces cases sert
un de ces artefacts (annexe, template, notes de travail) ou est superflu.

**Format d'un WBD (v1.2 ; contrôle d'éligibilité ajouté en v1.8, voir Changelog)**, symétrique à
DE-P-011 (Aggregate Promotion Rule) côté Domain — un WBD décide une frontière, pas un comportement
produit. **v1.8 ajoute un gate préalable** : avant de chercher quelle responsabilité revient à quel
Workspace, vérifier que chaque partie en présence est effectivement un Workspace. Ce gate est distinct
de l'attribution de responsabilité elle-même — il la précède, il ne s'y substitue pas.

```
WBD-NNN — [Workspaces concernés]
Éligibilité: Chacune des parties auxquelles une responsabilité Workspace est attribuée satisfait-elle
            la définition de Workspace établie par WSP-001 (projection assemblée pour un Actor) ?
            Si non pour une partie : cette partie ne peut pas recevoir de responsabilité Workspace,
            quelle que soit la responsabilité identifiée — voir Verdict NO-WORKSPACE ci-dessous.
Question:   Quelle responsabilité unique revient à quel Workspace ?
Evidence:   [PAT/OBS disponibles, avec confiance — pas d'evidence sur le comportement lui-même,
            evidence sur QUI en est responsable]
Verdict:    RESOLVED — territoire attribué explicitement à chaque Workspace
            | UNRESOLVED — evidence insuffisante pour trancher
            | NO-WORKSPACE — la responsabilité identifiée ne revient à aucun Workspace ; la partie
              concernée échoue au contrôle d'éligibilité, indépendamment de la qualité de la
              responsabilité elle-même, qui peut rester valide sous une autre forme
Si UNRESOLVED :
  - Workspace(s) concerné(s) passent au statut `Research Workspace — Boundary under investigation`
  - Une Discovery Question UNIQUE est formulée, ciblée sur la frontière elle-même
  - Aucun Blueprint n'est rédigé tant que le WBD n'est pas RESOLVED
Si NO-WORKSPACE :
  - Issue valide, pas un échec du WBD — symétrique à la règle Gate 2 v1.2 (un PDR a le droit de
    conclure qu'aucune décision ne peut encore être prise)
  - La responsabilité reste valide en tant que telle ; seule sa classification Workspace est retirée
  - La partie concernée n'est listée dans aucun échantillon ou proof set de Workspaces
  - La responsabilité est orientée vers l'artefact du niveau approprié (typiquement un ADR côté
    Engineering) — ce document n'anticipe pas la forme que prendra cet artefact au cas par cas
```

Un WBD n'est jamais un Product Decision Record déguisé : un PDR décide *ce qu'on construit*, un WBD
décide *qui a le droit de le construire*. Les deux ne se substituent jamais l'un à l'autre.

---

## 6. Forme d'un artefact (v1.1)

Tout artefact Discovery ou Product qui répond à plusieurs questions (un WE, un PDR) commence par un
**Executive Summary** : la liste des questions traitées, chacune avec sa réponse en une phrase et sa
confiance. Le détail (OBS, PAT, Tensions, Gaps) suit, question par question. Objectif : un lecteur
comprend le document en deux minutes ; il ne lit le détail que s'il en a besoin. La synthèse ne se
déduit pas de la lecture complète — elle est écrite en premier, pas recalculée à la fin.

---

## 7. Réconciliation avec l'existant

Cette charte est un **modèle cible**, pas une purge rétroactive. Deux principes de transition :

**a) Aucun document déjà marqué Frozen/Accepted n'est déprécié par ce seul document.**
[PRODUCT-PIPELINE-v1.0.md](../product/PRODUCT-PIPELINE-v1.0.md) (Frozen) reste la référence fine du
détail d'artefacts pour les couches Discovery + Product + Engineering — GOV-000 l'englobe (ajoute
Reality, Design, Validation comme couches explicites ; ajoute les Gates ; fige les 5 symboles) sans le
contredire sur le fond. Sa table d'artefacts ("neuf artefacts officiels") reste valide comme *détail
opérationnel* de ce que GOV-000 nomme WE / PDR / Workspace Blueprint / Prototype / Field Report.

**b) La liste d'artefacts officiels (§5) gouverne les documents nouvellement créés, pas les documents
existants antérieurs à cette charte.** `docs/product/` contient aujourd'hui plusieurs documents qui ne
rentrent pas strictement dans WE / PDR / Blueprint (Constitution, Operating Model, Architecture,
Rulebook, Display Rulebook, Questions). Ils ne sont pas invalidés par GOV-000. **Décision ouverte, non
tranchée ici :** faut-il les consolider dans PDR/Blueprint à terme, ou les traiter comme une couche
"méta" (gouvernance produit elle-même, au même titre que GOV-000 est méta pour l'ensemble) distincte des
artefacts par Workspace ? Cette question doit être tranchée explicitement avant toute suppression ou
fusion de document existant — elle n'est pas résolue par la simple publication de GOV-000.

**Mapping vers l'arborescence réelle actuelle** (`/discovery`, `/product`, etc. sont des noms
conceptuels de couche, pas des dossiers physiques à créer) :

| Couche GOV-000 | Dossier réel aujourd'hui |
|---|---|
| Discovery | `docs/research/` (act/, observations/, interviews/, specifications/ — spécifications CWRM) |
| Product | `docs/product/` (workspaces/, PRODUCT-*.md) |
| Design | `docs/ux/`, prototypes HTML dans `docs/product/workspaces/` |
| Engineering | `docs/architecture/` (ADR-SA-*), `docs/adr/` (ADR-000x) |
| Validation | à créer — aucun dossier dédié aujourd'hui |

Aucune migration physique de fichiers n'est effectuée par ce document. Si une réorganisation de
dossiers (`docs/discovery/`, `docs/product/`, `docs/ux/`, `docs/engineering/`, `docs/validation/`) est
souhaitée, c'est une décision séparée — elle touche `CLAUDE.md` (table de référence) et tous les liens
relatifs des documents existants, et mérite d'être actée explicitement avant exécution.

---

## 8. Ce que cette charte fige définitivement

- Les cinq symboles (§3) et leur composition evidence/decision/gate.
- Les seuils de confiance HIGH/MEDIUM/LOW pour tout Pattern (§3, v1.1) — jamais laissés au lecteur.
- La catégorie Tension (§3, v1.1) comme quatrième type d'artefact Discovery, distincte de OBS/PAT/Gap.
- L'ordre des six niveaux et le sens des flèches (§1) — aucun niveau ne saute une étape.
- Les cinq Gates et leurs conditions (§4).
- La liste des artefacts officiels par couche (§5), comme cible pour tout nouveau document.
- La forme Executive Summary → détail pour tout artefact multi-questions (§6, v1.1).
- Le Workspace Boundary Decision (WBD, §5/§6, v1.2) comme artefact distinct du PDR.
- Le droit d'un PDR à conclure qu'aucune décision ne peut encore être prise (§4 Gate 2, v1.2), et le
  statut `Research Workspace — Boundary under investigation` qui en découle.
- Le contrôle d'éligibilité Workspace préalable à toute attribution de responsabilité par un WBD (§5,
  v1.8), et le droit symétrique d'un WBD à conclure qu'une responsabilité ne revient à aucun Workspace
  (verdict `NO-WORKSPACE`, §4 Gate 2 Règle v1.8).
- Product Discovery (PDX, §1bis, v1.4 — remplace le "circuit Innovation" v1.3), parallèle au circuit
  Discovery, et les quatre règles RG-001 à RG-004 : pas de PDX sans friction documentée, jamais de
  Product Principle direct, validation par prototype/test obligatoire, l'abandon fait partie du
  processus.
- L'indicateur d'Origine (§1bis, v1.4) — Evidence-Driven / Discovery-Driven / Constraint-Driven /
  Founder-Driven — obligatoire sur tout artefact Product, distinct du niveau de preuve (§3).

Ce qui reste ouvert : la réconciliation fine avec les documents `docs/product/` antérieurs (§7b), et
la décision de migration physique des dossiers (§7, mapping).

---

## 9. Changelog

| Version | Date | Nature |
|---|---|---|
| 1.0 | 2026-08-04 | Charte initiale — 6 niveaux, 5 Gates, 5 symboles, artefacts officiels. |
| 1.1 | 2026-08-04 | Ajout suite à la revue de [WE-004](../product/workspaces/WE-004-documentation.md) : seuils de confiance obligatoires pour tout Pattern (HIGH/MEDIUM/LOW, §3) ; nouvelle catégorie Discovery **Tension** (`TEN-X-NNN`, marqueur `⚠`, §1/§3/§5) pour les divergences directement opposées entre profils ; forme recommandée Executive Summary → détail pour tout artefact multi-questions (§6). |
| 1.2 | 2026-08-04 | Ajout suite à l'audit critique de [PDR-004](../product/workspaces/PDR-004-documentation.md) : nouvel artefact **Workspace Boundary Decision** (`WBD-NNN`, §1/§5/§6), symétrique à DE-P-011 côté Domain, pour trancher *qui* est responsable d'un comportement plutôt que *quoi* construire ; règle explicite qu'**un PDR a le droit de conclure qu'aucune décision ne peut encore être prise** — issue valide, pas un échec (§4, Gate 2) ; nouveau statut `Research Workspace — Boundary under investigation` pour tout Workspace dont le WBD reste UNRESOLVED. |
| 1.3 | 2026-08-04 | Ajout du **circuit Innovation** (§1bis), parallèle au circuit Discovery : nouvel artefact **Innovation Hypothesis** (`IH-NNN`, §5), motivé par une friction Discovery (PAT/GAP) mais explorant une solution que le corpus n'a pas pu observer par construction. Règle fondatrice : "Les Observations décrivent le présent. Les Innovation Hypotheses explorent des futurs possibles." Une IH ne devient jamais Product Principle sans passer par son propre cycle Prototype → Tests praticiens — elle ne peut pas emprunter Gate 1 (conditions Discovery) comme raccourci. Premier cas d'usage : IH-001 (renommé PDX-001 en v1.4). |
| 1.4 | 2026-08-04 | **Renommage** : "circuit Innovation" / `IH-NNN` → **Product Discovery** / `PDX-NNN` (§1bis) — le terme "Innovation" biaisait vers la technologie, "Product Discovery" couvre aussi les explorations UX ou workflow sans solution technologique. Désambiguïsation explicite ajoutée entre Discovery (Niveau 1, décrit le présent) et Product Discovery (explore des futurs). Diagramme repositionné : WE se ramifie en PDR et PDX, les deux convergent vers Validation praticiens → Product Principle ; le "Prototype exploratoire" de PDX est explicitement distingué du Prototype de Design/Niveau 3 (pré- vs post-Blueprint). Quatre **Règles de gouvernance** ajoutées (RG-001 à RG-004). Nouvel **indicateur d'Origine** obligatoire sur tout artefact Product (Evidence-Driven / Discovery-Driven / Constraint-Driven / **Founder-Driven**, cette dernière catégorie ajoutée pour couvrir les décisions Model C déjà gelées dans WS-003, absentes des trois catégories proposées). Reformulation de la philosophie MedLink : "Les problèmes viennent du terrain. Les solutions peuvent venir du terrain, du Product, de la technologie ou de la recherche. Elles doivent toutes être validées par le terrain avant de devenir des décisions produit." Fichier renommé : `docs/product/innovation/IH-001-*.md` → [PDX-001](../product/discovery/PDX-001-capture-clinique-assistee.md). |
| 1.5 | 2026-08-04 | Suite à une revue d'architecture produit critique (Workspaces vs Cognitive Responsibilities) : **règle gelée non conditionnelle** — le vocabulaire Product ne descend jamais dans le Domain, étendue explicitement à tout futur artefact de gouvernance (§1ter-a). **Cognitive Responsibility introduite comme hypothèse méthodologique en expérimentation, pas comme gouvernance officielle** (§1ter-b) — protocole de test défini : construire WS-005 avec `Responsibility → Product Question → Workspace`, rétrospective (churn vs WS-004, stabilisation des décisions, délimitation du Workspace), intégration officielle seulement si validée. Relation avec Clinical State explicitée : une Responsibility est un cluster stable d'états, pas une paire (Current, Target) — la distinction préserve la transition inter-cluster DÉCIDE→PERDU déjà protégée par PP-011. Leçon de nommage appliquée par avance : "Collaboration" est déjà un nom de Plateforme (CLAUDE.md) — "Clinical Coordination" préféré pour l'éventuel WS-005. |
| 1.7 | 2026-08-06 | **Sprint M1.1 — Consolidation.** Correction §1ter-b : la citation *"modèle Clinical State existant"* est reformulée en *"modèle de travail illustratif"*, avec renvoi explicite au disclaimer de WS-003 §6 (*"simplification pédagogique... hors du domaine logiciel, DE-P-001/002"*) — ce diagramme n'a jamais été un artefact du track Domain. Complète le Sprint M1.1 avec [ADR-0015](../adr/ADR-0015-canonical-discovery-pipeline.md) (pipeline canonique), [ADR-0016](../adr/ADR-0016-status-of-experimental-concepts.md) (statut des concepts), [ADR-0017](../adr/ADR-0017-freeze-semantics.md) (sémantique Accepted/Experimental/Frozen) et [ADR-0018](../adr/ADR-0018-evidence-traceability.md) (traçabilité evidence), plus des édits directs sur [WBD-004](../product/workspaces/WBD-004-consultation-vs-documentation.md) (table Sens du flux complétée pour WS-005/WS-006) et [WS-003](../product/workspaces/WS-003-consultation.md) §11 (frontières WS-004/WS-005/WS-006 explicitées). Aucun nouveau concept, aucun nouveau Workspace — réponse à la revue d'architecture M1 du 2026-08-06. |
| 1.6 | 2026-08-06 | **Extension du protocole de test §1ter-b** : la validation de l'hypothèse Cognitive Responsibility ne repose plus sur WS-005 seul — elle doit résister à l'application sur WS-006 également avant toute intégration officielle. Décision utilisateur suite au démarrage effectif du test sur WS-005 (voir [WE-005](../product/workspaces/WE-005-information-flow.md), [CWRM-020-APX-WS005](../research/specifications/CWRM-020-APX-WS005-coordination-guide.md)). Un résultat positif sur un seul des deux Workspaces reste partiel ; une divergence entre les deux doit être documentée, pas arbitrée par défaut. |
| 1.8 | 2026-09-09 | **Amendement ciblé, pas une nouvelle taxonomie — [ADR-0024](../adr/ADR-0024-ws004-nature-et-proof-set-m2.md), Option B.** Le cas WS-004 (`OBS-M2-013`) a révélé que le format WBD (§5) ne vérifiait jamais si les parties en présence satisfaisaient réellement `WSP-001` avant de leur attribuer une responsabilité Workspace — il tranchait *qui* possède une responsabilité, jamais *si l'objet qui la reçoit mérite le statut Workspace*. Deux ajouts, délibérément minimaux : (1) §5 — nouveau champ `Éligibilité` en tête du format WBD, et nouveau verdict `NO-WORKSPACE` (une responsabilité peut rester valide sans que son porteur soit un Workspace — orientée vers l'artefact du niveau approprié, typiquement un ADR) ; (2) §4 Gate 2 — Règle v1.8, symétrique à la Règle v1.2 déjà existante (un PDR peut conclure qu'aucune décision ne peut être prise ; un WBD peut désormais conclure qu'aucun Workspace ne reçoit la responsabilité). Explicitement écarté : une taxonomie complète des types d'objets (Application Service / Domain Concept / Platform...) — non nécessaire, `WSP-001` §"Ce que le Workspace n'est pas" couvre déjà "un Application Service" depuis l'origine du document. `WBD-004` n'est pas modifié rétroactivement par cet amendement — WS-004 reste le cas qui a révélé le besoin du garde-fou, pas une exception construite pour lui. |
| 1.9 | 2026-10-05 | **Annotation, aucune règle modifiée — [ADR-0025](../adr/ADR-0025-innovations-produit-non-observees.md).** Les fiches d'implémentation Phase 2 avaient appliqué la dérive n°1 de §1bis (*"non observé donc non fondé"*). §1bis reçoit un paragraphe d'application : fiche `HYP-<WS>-NNN` légère pour un élément d'écran (au lieu d'un PDX complet), **critère d'abandon obligatoire déclaré avant le test** (généralise le garde-fou d'ADR-0020), renvoi vers ADR-0025 §5 pour les types de code autorisés avant Gate 3. RG-001 à RG-004, Gates, marqueurs, Origine : inchangés. |
