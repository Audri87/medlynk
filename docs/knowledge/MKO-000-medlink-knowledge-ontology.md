# MKO-000 — MedLink Knowledge Ontology

**Type :** Ontological Foundation — Precedes all other knowledge documents
**Statut :** Draft v0.1
**Date :** 2026-07-30
**Autorité :** Ce document est la fondation formelle du système de connaissance de MedLink.
Tous les documents CCF, CCP, WR, UX, CI sont des projections narratives de ce modèle.
Toute contradiction entre ce document et un document de projection est résolue en faveur de ce document.

---

## Positionnement

```
MKO-000 — MedLink Knowledge Ontology
═══════════════════════════════════════════════════════════════════

  Le modèle formel. Types, relations, contraintes, inférences.
  La vérité du système — indépendante de tout document.

              │
              ▼

  Documents de projection (narratifs, lisibles)
  ─────────────────────────────────────────────
  CCF-000   Projection : Framework narratif (anciennement charter)
  CCF-01    Projection : Architecture cognitive (narrative)
  CCF-02    Projection : Episode cognitif (narrative)
  CI-xxx    Projection : Registre des invariants
  WR-xxx    Projection : Registre des requirements
  UX-xxx    Projection : Registre des principes UX
  CCP-xxx   Projection : Registre des profils cognitifs
```

**Distinction fondamentale :**
Un document est une *vue* sur le graphe. La vérité est dans le graphe.
Si un document contredit le graphe : le document est mis à jour.
Si le graphe est insuffisant : une issue est ouverte pour étendre le graphe.

---

---

# Chapitre I — Object Types

Le système de connaissance de MedLink est constitué de deux familles d'objets.

## 1.1 Chaîne de dérivation (objets ordonnés)

Ces objets forment une chaîne stricte. Chaque niveau dérive du précédent.
Aucun niveau ne peut être sauté dans la chaîne de dérivation.

```
Framework
    │  DEFINES
    ↓
Architecture
    │  DEFINES
    ↓
Invariant
    │  DERIVES
    ↓
Cognitive Need
    │  DERIVES
    ↓
Requirement
    │  DERIVES
    ↓
UX Principle
    │  DERIVES
    ↓
Interaction Pattern
    │  REALIZES
    ↓
Product Capability
```

---

### OT-01 — Framework

**Définition :** Un Framework est un document de gouvernance qui définit les règles d'un système de connaissance. Il précède et gouverne tous les autres objets du système.

**Propriétés :**
- `id` : identifiant unique (ex. CCF-000, MKO-000)
- `scope` : le domaine couvert (ex. "clinical cognition")
- `version` : numéro de version (sémantique)
- `status` : Draft | Accepted | Deprecated

**Exemples :** MKO-000, CCF-000

**Règle :** Un Framework ne dérive d'aucun autre objet — il est une fondation.

---

### OT-02 — Architecture

**Définition :** Une Architecture décrit la structure universelle et permanente d'un domaine de connaissance. Elle n'est pas liée à une occurrence temporelle ni à un contexte spécifique. Elle est vraie pour toutes les instances.

**Propriétés :**
- `id` : identifiant unique (ex. CCF-01)
- `domain` : le domaine modélisé (ex. "clinical cognition")
- `question` : la question fondatrice (ex. "Quelle est la structure permanente de la cognition clinique ?")
- `corpus_scope` : le périmètre du corpus empirique qui la fonde
- `status` : Draft | Validated | Extended | Deprecated

**Analogie UML :** Une Architecture est une *métaclasse* — elle définit les propriétés communes de toutes ses instances (les Episodes).

**Exemples :** CCF-01 — Clinical Cognitive Architecture

---

### OT-03 — Invariant

**Définition :** Un Invariant est une propriété stable et falsifiable observée dans tous les contextes couverts par l'Architecture. Il capture ce qui ne change pas malgré la diversité des spécialités, des outils et des styles individuels.

**Propriétés :**
- `id` : identifiant unique (ex. CI-01)
- `name` : nom anglais canonique
- `statement` : l'énoncé de l'invariant (testable, non ambigu)
- `family` : famille d'appartenance (ex. Context Construction)
- `confidence_level` : {LOW | MEDIUM | HIGH | VERY_HIGH} dérivé du corpus
- `corpus_support` : fraction du corpus confirmant (ex. 9/9)
- `refutation_condition` : condition explicite d'invalidation
- `status` : Active | Under_Review | Suspended | Refuted

**Règle :** Tout Invariant doit avoir un `refutation_condition` non vide. Sans cela, il n'est pas un Invariant — c'est une croyance.

**Exemples :** CI-01 (Context Reconstruction), CI-02 (Delta Reasoning), CI-03 (Cognitive Load Management), CI-04 (Distributed Cognition), CI-05 (Trust Calibration by Attribution)

---

### OT-04 — Cognitive Need

**Définition :** Un Cognitive Need est le besoin cognitif humain qui découle d'un Invariant. Il est formulé du point de vue du praticien (voix active, première personne). Il existe entre l'Invariant (ce que le cerveau fait) et le Requirement (ce que le système doit fournir).

**Propriétés :**
- `id` : identifiant unique (ex. CN-03)
- `statement` : énoncé en voix active praticien (ex. "Je dois pouvoir me concentrer sur peu d'informations simultanément.")
- `derived_from` : liste de CI-xxx dont ce besoin dérive
- `status` : Active | Superseded

**Pourquoi ce niveau existe :** Le saut direct Invariant → Requirement court-circuite la perspective praticien. "La mémoire de travail est limitée" (Invariant, voix scientifique) n'est pas la même chose que "le système doit afficher l'information minimale" (Requirement, voix ingénierie). Le Cognitive Need est la traduction indispensable entre les deux voix.

**Exemples :**
- CN-01 : Je dois comprendre rapidement la situation actuelle du patient avant d'agir.
- CN-02 : Je dois identifier ce qui a changé depuis ma dernière interaction — pas reconstruire l'histoire.
- CN-03 : Je dois pouvoir me concentrer sur un petit nombre d'informations sans être submergé.
- CN-04 : Je dois voir ce que les autres praticiens ont contribué autour de ce patient.
- CN-05 : Je dois savoir qui a produit chaque information, quand, et dans quel contexte.

---

### OT-05 — Requirement

**Définition :** Un Requirement est une contrainte système-agnostique exprimant ce que tout système doit fournir pour satisfaire un Cognitive Need. Il est formulé en voix système ("Le système doit permettre..."). Il est réutilisable par tous les Workspaces.

**Propriétés :**
- `id` : identifiant unique (ex. WR-01)
- `statement` : énoncé en voix système
- `derived_from` : liste de CN-xxx dont ce requirement dérive
- `measurable_criterion` : condition de vérification objective (ex. "p95 < 30s")
- `status` : Active | Implemented | Deprecated

**Exemples :** WR-01 (Reconstruction < 30s), WR-02 (Delta comme état par défaut), WR-03 (Information minimale par défaut)

---

### OT-06 — UX Principle

**Définition :** Un UX Principle est une décision de conception qui implémente un ou plusieurs Requirements. C'est une réponse au *comment* (contrairement au Requirement qui répond au *quoi*). Il est modifiable si une meilleure réponse au même Requirement est trouvée.

**Propriétés :**
- `id` : identifiant unique (ex. UX-P01)
- `name` : nom du principe (ex. "Context First", "Information Minimalism")
- `implements` : liste de WR-xxx implémentés
- `rationale` : justification du choix de ce principe plutôt qu'un autre
- `status` : Proposed | Validated | Deprecated

---

### OT-07 — Interaction Pattern

**Définition :** Un Interaction Pattern est une solution de design réutilisable qui réalise un UX Principle dans une interface concrète. Il est plus spécifique qu'un principe et plus générique qu'un composant.

**Propriétés :**
- `id` : identifiant unique (ex. IP-01)
- `name` : nom du pattern (ex. "Anchor", "Delta View", "Source Badge")
- `realizes` : UX Principle réalisé
- `validated_by` : référence aux tests utilisateurs validant le pattern

**Note :** L'Anchor, la Progressive Disclosure, le Team Panel sont des Interaction Patterns — pas des Invariants ni des Requirements.

---

### OT-08 — Product Capability

**Définition :** Une Product Capability est une capacité fonctionnelle concrète d'un produit spécifique. Elle implémente un ou plusieurs Interaction Patterns dans le contexte d'un Workspace.

**Propriétés :**
- `id` : identifiant unique (ex. PC-PatientWS-001)
- `name` : nom de la capacité
- `implements` : liste d'Interaction Patterns implémentés
- `workspace` : Workspace dans lequel la capacité est déployée
- `status` : Planned | Implemented | Validated | Deprecated

---

## 1.2 Objets orthogonaux (non ordonnés dans la chaîne)

Ces objets existent à côté de la chaîne de dérivation. Ils interagissent avec elle via des relations spécifiques mais ne s'y substituent pas.

---

### OT-09 — Clinical Episode (CCE)

**Définition :** Un Clinical Episode est une occurrence temporelle bornée de la cognition clinique. Il a une Architecture comme classe et des Invariants comme propriétés transversales.

**Analogie UML :** Architecture = classe. Clinical Episode = instance d'exécution.

**Propriétés :**
- `id` : identifiant unique (ex. CCE-001)
- `instantiates` : Architecture dont il est une instance
- `phases` : séquence de phases (modélisée dans CCF-02)
- `duration` : durée observée
- `profile` : Clinical Profile du praticien observé

**Relation critique :** Un Episode `INSTANTIATES` une Architecture. Il ne `DERIVES` pas d'elle. Cette distinction est fondamentale : une occurrence n'est pas une dérivation.

---

### OT-10 — Clinical Profile (CCP)

**Définition :** Un Clinical Profile est une configuration stable de l'expression des Invariants pour un contexte de pratique spécifique. Il ne modifie pas les Invariants — il module leur expression, leur poids et leurs stratégies de compensation.

**Propriétés :**
- `id` : identifiant unique (ex. CCP-001)
- `name` : nom du profil (ex. "Memory-First Ambulatory", "Documentation-Centric", "Coordinator")
- `configures` : Architecture dont le profil est une configuration
- `invariant_configurations` : pour chaque CI, expression spécifique dans ce profil
- `observed_in` : liste de profils du corpus confirmant

**Note terminologique :** "Configuration" est préféré à "instance" et à "spécialisation". Un Profile ne crée pas de nouveaux Invariants (ce n'est pas une spécialisation). Il ne change pas les Invariants (ce n'est pas une instance). Il change *l'expression* des Invariants — leur poids, leur stratégie, leur manifestation observable.

**Exemples actuels :**
- CCP-001 : Memory-First (F-001, F-003, F-007 partiel) — CI-01 via mémoire long terme
- CCP-002 : Documentation-Centric (F-002, F-004, F-008, F-009) — CI-01 via relecture notes
- CCP-003 : Coordinator (F-009) — CI-04 en mode production synchrone, N patients parallèles

---

### OT-11 — Observation

**Définition :** Une Observation est une donnée terrain extraite d'un entretien ou d'une session d'observation directe. Elle constitue l'évidence primaire du système de connaissance.

**Propriétés :**
- `id` : identifiant unique (ex. OBS-F003-001)
- `source` : fichier de corpus (ex. F-003)
- `verbatim` : citation exacte si entretien
- `context` : contexte de l'observation
- `supports` / `challenges` : liste de CI-xxx concernés

**Règle :** Une Observation ne peut pas SUPPORTS ou CHALLENGES un Requirement, un UX Principle ou un Product Capability directement. Elle cible exclusivement des Invariants ou des Cognitive Needs.

---

### OT-12 — Evidence

**Définition :** Une Evidence est un corpus structuré d'Observations ou de références bibliographiques qui constituent une base de confiance pour un ou plusieurs Invariants.

**Propriétés :**
- `id` : identifiant unique (ex. EV-001)
- `type` : Empirical (corpus terrain) | Bibliographic (littérature) | Mixed
- `strength` : LOW | MEDIUM | HIGH | VERY_HIGH
- `supports` / `refutes` : liste de CI-xxx concernés

---

### OT-13 — Experiment

**Définition :** Un Experiment est une étude contrôlée conçue pour tester spécifiquement un ou plusieurs Invariants ou Cognitive Needs. Il peut CONFIRM ou REFUTE sa cible.

**Propriétés :**
- `id` : identifiant unique (ex. EXP-001)
- `target` : CI-xxx ou CN-xxx ciblé
- `hypothesis` : hypothèse testée
- `protocol` : description du protocole
- `outcome` : Pending | Confirmed | Refuted | Inconclusive
- `result_ref` : référence aux résultats

---

### OT-14 — Workspace

**Définition :** Un Workspace est un contexte d'usage produit. Il implémente un ensemble de Product Capabilities pour répondre à une question cognitive spécifique d'un acteur spécifique.

**Propriétés :**
- `id` : identifiant unique (ex. WS-Patient)
- `name` : nom du Workspace (ex. "Patient Workspace")
- `cognitive_question` : la question cognitive centrale (ex. "Comment un praticien reconstruit-il le contexte d'un patient avant son acte ?")
- `implements` : liste de Product Capabilities déployées
- `target_profiles` : Clinical Profiles pour lesquels ce Workspace est conçu

**Note :** Le Workspace est un objet produit. Il ne fait pas partie de la chaîne scientifique de dérivation. Il est le point d'atterrissage des Product Capabilities — pas un niveau du savoir scientifique.

---

---

# Chapitre II — Relation Types

Toute relation dans le graphe a un type explicite. Une relation sans type est invalide.

## 2.1 Tableau des relations

| Relation | Source | Cible | Sémantique | Transitive |
|---|---|---|---|---|
| `DEFINES` | Framework, Architecture | Invariant | La source établit l'existence et les règles de la cible | Non |
| `USES` | Architecture, Episode | Invariant, CN | La source référence la cible sans la définir | Non |
| `DERIVES` | CI → CN → WR → UX → IP | Niveau suivant dans la chaîne | La cible est logiquement dérivée de la source | Oui |
| `CONFIGURES` | Profile | Architecture, Invariant | La source module l'expression de la cible sans la modifier | Non |
| `INSTANTIATES` | Episode | Architecture | La source est une occurrence temporelle de la cible | Non |
| `SUPPORTS` | Observation, Evidence | Invariant, CN | La source augmente la confiance dans la cible | Non |
| `CHALLENGES` | Observation, Evidence | Invariant, CN | La source questionne la cible — déclenche une revue | Non |
| `REFUTES` | Experiment, Evidence | Invariant | La source invalide la cible avec une évidence suffisante | Non |
| `CONFIRMS` | Experiment, Evidence | Invariant | La source valide la cible sous protocole contrôlé | Non |
| `REALIZED_BY` | UX Principle, IP | Product Capability | La source est implémentée par la cible | Non |
| `SPECIALIZES` | Architecture, Profile | Framework, Architecture | La source étend la cible pour un sous-domaine | Non |

## 2.2 Notation formelle

```
<source_id> --[RELATION_TYPE]--> <target_id>

Exemples :
  CCF-01  --[DEFINES]-->   CI-01
  CCF-02  --[USES]-->      CI-01
  CI-03   --[DERIVES]-->   CN-03
  CN-03   --[DERIVES]-->   WR-03
  WR-03   --[DERIVES]-->   UX-P02
  OBS-F003-001 --[SUPPORTS]--> CI-01
  EXP-001 --[REFUTES]-->   CI-03
  CCP-001 --[CONFIGURES]--> CCF-01
  CCE-001 --[INSTANTIATES]--> CCF-01
```

## 2.3 Transitivity explicite

La relation `DERIVES` est transitive :

> Si A `DERIVES` B et B `DERIVES` C, alors A `TRANSITIVELY_DERIVES` C.

Conséquence : CI-03 `TRANSITIVELY_DERIVES` WR-03 via CN-03.
Conséquence : CI-03 `TRANSITIVELY_DERIVES` UX-P02 via CN-03 → WR-03.

La transitivity permet de tracer n'importe quel Product Capability jusqu'à l'Invariant qui le justifie — et de détecter les Product Capabilities sans ancrage scientifique.

---

---

# Chapitre III — Constraints

Les Constraints sont les règles d'intégrité du graphe. Elles définissent ce qui est autorisé ou interdit. Toute violation est une erreur de modélisation — pas une exception à traiter.

## Contraintes sur les objets

**C-001 — Tout Invariant doit être DEFINED_BY exactement une Architecture.**
Un Invariant sans Architecture parent n'a pas de scope défini.
Un Invariant rattaché à deux Architectures crée une ambiguïté de gouvernance.

**C-002 — Tout Invariant doit avoir un `refutation_condition` non vide.**
Un Invariant sans condition de réfutation est une croyance, pas un invariant scientifique.

**C-003 — Tout Cognitive Need doit DERIVE d'au moins un Invariant.**
Un Cognitive Need sans Invariant parent n'est pas un besoin cognitif fondé — c'est une intuition de design.

**C-004 — Tout Requirement doit DERIVE d'au moins un Cognitive Need.**
Un Requirement qui dérive directement d'un Invariant (sans Cognitive Need intermédiaire) court-circuite la perspective praticien. Interdit.

**C-005 — Aucun UX Principle ne peut DERIVE directement d'un Invariant.**
La chaîne obligatoire est : Invariant → Cognitive Need → Requirement → UX Principle.
Un UX Principle qui dérive directement d'un Invariant est une décision de design déguisée en science.

**C-006 — Tout Invariant doit avoir au moins une Observation le SUPPORTING.**
Un Invariant sans évidence terrain n'est pas empirique — c'est une hypothèse théorique. Il doit être marqué `status: Hypothesis` jusqu'à preuve terrain.

## Contraintes sur les relations

**C-007 — Une Observation ne peut pas SUPPORTS ou CHALLENGES un Requirement, UX Principle ou Product Capability.**
Les Observations ciblent exclusivement des Invariants ou des Cognitive Needs.
Les Observations sont des faits terrain — elles ne valident pas des décisions de design.

**C-008 — Un Clinical Profile CONFIGURES une Architecture — il ne DEFINES pas d'Invariants.**
Un Profile ne peut pas introduire un nouvel Invariant. Seule une Architecture peut définir des Invariants.
Si un Profile révèle un besoin non couvert par les Invariants existants, cela déclenche une proposition d'extension à l'Architecture — pas une définition locale.

**C-009 — Un Experiment ne peut cibler qu'un Invariant ou un Cognitive Need.**
Les Experiments sont des outils de falsification scientifique. Ils ne testent pas des Interaction Patterns ou des Product Capabilities — ceux-ci sont testés par des user tests, pas des expériences contrôlées.

**C-010 — Un Workspace n'appartient pas à la chaîne de dérivation scientifique.**
Un Workspace IMPLEMENTS des Product Capabilities. Il ne DERIVES d'aucun objet scientifique.
Nommer des Workspaces dans des documents scientifiques (CCF-01, CI-xxx) est une violation de la Constraint C-005.

---

---

# Chapitre IV — Inference Rules

Les Inference Rules sont les conséquences logiques qui découlent automatiquement des relations. Elles permettent à terme d'automatiser une partie de la gouvernance scientifique du framework.

## IR-001 — Propagation du support

```
IF   Observation --[SUPPORTS]--> CI-X
AND  CI-X --[DERIVES]--> CN-X
THEN Observation --[INDIRECTLY_SUPPORTS]--> CN-X
```

*Effet :* Toute Observation qui renforce un Invariant renforce automatiquement tous les Cognitive Needs qui en dérivent.

---

## IR-002 — Cascade de réfutation

```
IF   Experiment --[REFUTES]--> CI-X
THEN ∀ CN-Y such that CI-X --[DERIVES]--> CN-Y
     → status(CN-Y) = UNDER_REVIEW
AND  ∀ WR-Z such that CN-Y --[DERIVES]--> WR-Z
     → status(WR-Z) = UNDER_REVIEW
```

*Effet :* Réfuter un Invariant place automatiquement en état de revue tous les Cognitive Needs et Requirements qui en dépendent. Les Product Capabilities basées sur ces Requirements doivent être réévaluées.

---

## IR-003 — Transitivité de la dérivation

```
IF   A --[DERIVES]--> B
AND  B --[DERIVES]--> C
THEN A --[TRANSITIVELY_DERIVES]--> C
```

*Effet :* La chaîne de traçabilité est complète. Tout Product Capability est traçable jusqu'à l'Invariant qui le justifie.

---

## IR-004 — Scope de la configuration

```
IF   CCP-X --[CONFIGURES]--> Architecture-Y
AND  Architecture-Y --[DEFINES]--> CI-Z
THEN CCP-X --[CONFIGURES_EXPRESSION_OF]--> CI-Z
```

*Effet :* Un Profile qui configure une Architecture configure implicitement l'expression de tous les Invariants définis par cette Architecture. La configuration est toujours totale — il n'est pas possible de configurer sélectivement certains Invariants sans positionner le Profile par rapport à l'ensemble.

---

## IR-005 — Détection d'Invariant orphelin

```
IF   CI-X has no CN-Y such that CI-X --[DERIVES]--> CN-Y
THEN CI-X → status: INCOMPLETE
     → warning: "Invariant CI-X has no derived Cognitive Need — not yet operational"
```

*Effet :* Un Invariant sans Cognitive Need n'est pas utilisable dans la chaîne de dérivation. Il est scientifiquement valide mais sans conséquence sur le design. Ce n'est pas une erreur — c'est un signal que le travail de traduction est incomplet.

---

## IR-006 — Détection de Requirement non implémenté

```
IF   WR-X has no UX-Y such that WR-X --[DERIVES]--> UX-Y
THEN WR-X → flag: UNIMPLEMENTED
     → warning: "Requirement WR-X has no UX Principle — no design solution exists yet"
```

*Effet :* Un Requirement sans UX Principle est une contrainte système sans réponse de design. Cela doit déclencher un travail de conception, pas être silencieusement ignoré.

---

## IR-007 — Calcul du niveau de confiance

```
confidence_level(CI-X) = f(
    count(Observations SUPPORTING CI-X),
    count(Experiments CONFIRMING CI-X),
    count(Observations CHALLENGING CI-X),
    count(Experiments REFUTING CI-X),
    scope(corpus)
)

Niveaux :
  VERY_HIGH : > 6 supports, 0 refutations, corpus > 3 spécialités
  HIGH      : 4-6 supports, 0 refutations
  MEDIUM    : 2-3 supports, 0 refutations — ou > 0 challenges non résolus
  LOW       : < 2 supports — ou challenge non résolu dominant
```

---

## IR-008 — Déclenchement automatique de revue

```
IF   count(Observations CHALLENGING CI-X) > count(Observations SUPPORTING CI-X)
THEN CI-X → status: UNDER_REVIEW
     → trigger: "Review required — challenges exceed supports for CI-X"
```

*Effet :* La gouvernance scientifique n'est pas manuelle. Le graphe détecte automatiquement les Invariants dont l'équilibre évidentiel a basculé.

---

---

# Synthèse — Ce que cette ontologie rend possible

## Ce qui change par rapport à CCF-000

| Avant (CCF-000) | Après (MKO-000) |
|---|---|
| Document hierarchy | Knowledge graph |
| Niveaux numérotés | Objets typés avec relations explicites |
| Règles éditoriales | Contraintes formelles vérifiables |
| Mise à jour manuelle | Inférences automatiques |
| Validité par consensus | Validité par cohérence du graphe |

## Ce que MKO-000 permet à terme

**Automatisation de la gouvernance :** IR-002 (cascade de réfutation) et IR-008 (déclenchement de revue) peuvent être implémentés comme des règles d'un outil de gestion du graphe. Réfuter CI-03 déclenche automatiquement la revue de CN-03 → WR-03 → UX-P02 — sans aucune intervention manuelle.

**Traçabilité complète :** Tout Product Capability peut être tracé jusqu'à l'Invariant qui le justifie via IR-003 (transitivité). Un Capability sans ancrage scientifique est détecté automatiquement (C-004, C-005).

**Évolution contrôlée du corpus :** Chaque nouvel entretien produit des Observations (OT-11) qui SUPPORTS ou CHALLENGES des Invariants, modifiant automatiquement les confidence_level via IR-007.

**Validation des profils cognitifs :** CCP-xxx (Clinical Profiles) sont des objets formels — pas des notes informelles dans CCF-01. Chaque Profile a une traçabilité aux entretiens qui le fondent (OT-11) et des règles explicites sur quels Invariants il configure (IR-004).

## Ce que MKO-000 ne fait pas

MKO-000 ne remplace pas les documents narratifs. CCF-01, CCF-02, CI-xxx restent nécessaires — ils sont la forme lisible par des humains du graphe formel. La relation est celle d'un modèle UML vers son code : le modèle est la vérité, le code est l'implémentation lisible.

---

## Registre des objets courants (état au 2026-07-30)

### Frameworks
| ID | Titre | Status |
|---|---|---|
| MKO-000 | MedLink Knowledge Ontology (ce document) | Draft v0.1 |
| CCF-000 | Clinical Cognition Framework Charter | Accepted v1.0 |

### Architectures
| ID | Titre | Status |
|---|---|---|
| CCF-01 | Clinical Cognitive Architecture | Draft v1.1 |

### Invariants
| ID | Nom | Confiance | Status |
|---|---|---|---|
| CI-01 | Context Reconstruction | VERY_HIGH (9/9) | Active |
| CI-02 | Delta Reasoning | VERY_HIGH (9/9) | Active |
| CI-03 | Cognitive Load Management | HIGH (9/9, falsifiabilité faible) | Active — révision requise |
| CI-04 | Distributed Cognition | VERY_HIGH (9/9) | Active |
| CI-05 | Trust Calibration by Attribution | HIGH (7/9 explicite) | Active |

### Clinical Profiles
| ID | Nom | Fondé sur | Status |
|---|---|---|---|
| CCP-001 | Memory-First | F-001, F-003, F-007 | Draft |
| CCP-002 | Documentation-Centric | F-002, F-004, F-008, F-009 | Draft |
| CCP-003 | Coordinator | F-009 | Draft — profil unique, confirmation requise |

### Épisodes modélisés
| ID | Document | Status |
|---|---|---|
| CCE-model | CCF-02 — Clinical Cognitive Episode | Draft v1.0 |

---

*Version 0.1 — Fondation ontologique — 2026-07-30*
*Ce document précède tous les autres documents du système de connaissance MedLink.*
*Il ne peut être modifié que par décision explicite et documentée.*
