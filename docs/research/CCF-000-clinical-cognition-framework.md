# CCF-000 — Clinical Cognition Framework

**Type :** Framework Charter — Document de référence taxonomique
**Statut :** Accepted v1.0
**Date :** 2026-07-30
**Autorité :** Ce document définit la taxonomie scientifique de MedLink.
Tous les documents CCF, CI, WR et UX y sont subordonnés.
Toute contradiction entre un document de niveau inférieur et ce charter est résolue en faveur de ce charter.

---

## Définition

Le **Clinical Cognition Framework (CCF)** est le cadre scientifique de MedLink.

Il décrit comment les professionnels de santé construisent, utilisent et partagent leur raisonnement clinique.

Il est indépendant de toute implémentation logicielle, de tout composant, et de toute décision de design.

Son rôle est de fonder les décisions de conception sur des observations empiriques et une littérature scientifique rigoureuse — non sur des intuitions de design.

---

## Le schéma canonique

Ce schéma apparaît en tête de tout document CCF. Il positionne chaque document dans la hiérarchie et rappelle la séparation entre la réalité, le cadre scientifique, et les spécifications produit.

```
REALITY
════════════════════════════════════════════════════════════════

  Clinical Work
  ─────────────────────────────────────────────────────────────
  Le travail clinique réel. Observable. Indépendant de MedLink.

                            │
                            ▼

SCIENTIFIC FRAMEWORK
════════════════════════════════════════════════════════════════

  Clinical Cognitive Architecture                    CCF-01
  ─────────────────────────────────────────────────────────────
  La structure permanente de la cognition clinique.
  Invariants. Familles. Cycle. Modèle statique.

                            │
                            ▼

  Clinical Cognitive Episode                         CCF-02
  ─────────────────────────────────────────────────────────────
  L'unité fondamentale d'analyse.
  7 phases. Transitions. Ruptures. Modèle dynamique.

                            │
                            ▼

  Cognitive Invariants                               CI-xxx
  ─────────────────────────────────────────────────────────────
  Ce qui est toujours vrai dans chaque épisode.
  Transversaux. Falsifiables. Traçables au corpus.

                            │
                            ▼

PRODUCT SPECIFICATION
════════════════════════════════════════════════════════════════

  Workspace Requirements                             WR-xxx
  ─────────────────────────────────────────────────────────────
  Ce que tout système doit fournir.
  Dérivés des invariants. Système-agnostiques.
  Réutilisables par tous les Workspaces.

                            │
                            ▼

  UX Principles                                      UX-xxx
  ─────────────────────────────────────────────────────────────
  Comment les requirements sont implémentés.
  Anchor. Progressive Disclosure. Delta View. Etc.
  Décisions de design — modifiables.

                            │
                            ▼

WORKSPACES
════════════════════════════════════════════════════════════════

  Patient Workspace
  Practitioner Workspace
  Collaboration Workspace
  Care Relationship Workspace
  Organisation Workspace
  ─────────────────────────────────────────────────────────────
  Les produits. Implémentent les UX Principles.
  Validés par les tests utilisateurs.
```

---

---

# I. La hiérarchie en sept niveaux

## Niveau 1 — Clinical Work

**Nature :** Réalité observable. Phénomène indépendant de MedLink.

**Définition :** Le travail clinique est l'ensemble des activités par lesquelles un professionnel de santé prend en charge une situation médicale. Il inclut : l'examen, le raisonnement, la décision, l'acte, la documentation, la coordination.

**Rôle dans le CCF :** Source des observations empiriques. Tout invariant, toute phase, toute exigence est ultimement traçable à une observation de ce niveau.

**Relation avec MedLink :** MedLink est conçu pour servir le travail clinique — pas pour le redéfinir. Si une décision de design contredit ce niveau, c'est la décision de design qui est incorrecte.

---

## Niveau 2 — Clinical Cognitive Architecture (CCF-01)

**Document :** `CCF-01 — Clinical Cognitive Architecture`
**Question :** Quelle est la structure permanente de la cognition clinique ?
**Nature :** Modèle statique — l'anatomie de la cognition clinique.

**Contenu :**
- Les invariants cognitifs (CI-01 à CI-05 — voir Niveau 4)
- Les familles d'invariants (Context Construction, Cognitive Load, Distributed Cognition, Trust)
- Le cycle cognitif clinique (structure générale)
- La pyramide de transformation (Invariants → Besoins → Requirements → Principes → UI)

**Propriété :** Les structures décrites à ce niveau sont stables. Elles ne changent pas d'un épisode à l'autre, d'une spécialité à l'autre, d'un outil à l'autre. Un invariant cognitif vrai dans ce document est vrai pour toute rencontre clinique dans le scope du corpus.

---

## Niveau 3 — Clinical Cognitive Episode (CCF-02)

**Document :** `CCF-02 — Clinical Cognitive Episode`
**Question :** Que se passe-t-il, dans quel ordre, pendant un épisode cognitif clinique ?
**Nature :** Modèle dynamique — la physiologie de la cognition clinique.

**Contenu :**
- Définition formelle du CCE comme unité d'analyse
- Les 7 phases du CCE (Situation Intake → Documentation & Transmission)
- Les transitions entre phases
- Les ruptures cognitives et leurs mécanismes
- Les mécanismes compensatoires
- La frontière humain / assistable

**Propriété :** Le CCE est l'unité atomique d'analyse. Toute consultation, toute visite, toute rencontre clinique est un CCE. Une journée de travail est une succession de CCE. Un suivi de patient est une série de CCE connectés.

**Relation avec CCF-01 :** CCF-02 est la mise en mouvement de CCF-01. Les invariants (Niveau 4) s'expriment dans les phases du CCE.

---

## Niveau 4 — Cognitive Invariants (CI-xxx)

**Préfixe :** CI
**Question :** Qu'est-ce qui est toujours vrai dans chaque épisode cognitif, quelles que soient la spécialité, l'outil, le style individuel ?

**Nature :** Les invariants sont les lois stables de la cognition clinique. Ils sont :
- **Traçables** — chaque invariant est lié à des observations terrain documentées
- **Falsifiables** — chaque invariant peut être réfuté par une observation contraire
- **Transversaux** — ils s'appliquent à tous les CCE, pas à une phase ou un profil spécifique

**Groupés en familles :**

| Famille | Invariants actuels | Phases CCE concernées |
|---|---|---|
| Context Construction | CI-01, CI-02 | Situation Intake, Situation Assessment |
| Cognitive Load | CI-03 | Toutes phases |
| Distributed Cognition | CI-04 | Situation Assessment, Action, Documentation |
| Trust & Attribution | CI-05 | Situation Assessment, Decision |

**Registre courant :**

| ID | Nom | Famille | Confiance terrain |
|---|---|---|---|
| CI-01 | Context Reconstruction | Context Construction | ★★★★★ (9/9) |
| CI-02 | Delta Reasoning | Context Construction | ★★★★★ (9/9) |
| CI-03 | Cognitive Load Management | Cognitive Load | ★★★★★ (9/9) |
| CI-04 | Distributed Cognition | Distributed Cognition | ★★★★★ (9/9) |
| CI-05 | Trust Calibration by Attribution | Trust & Attribution | ★★★★ (7/9) |

**Nomenclature :** Le préfixe canonique est CI-xxx (Cognitive Invariant — anglais, cohérent avec la nomenclature CCF). Migration IC-xxx → CI-xxx complétée le 2026-07-30 dans CCF-01 et CCF-02.

---

## Niveau 5 — Workspace Requirements (WR-xxx)

**Préfixe :** WR
**Question :** Que doit fournir tout système pour servir les invariants cognitifs cliniques ?

**Nature :** Les Requirements sont la traduction des invariants en contraintes d'ingénierie. Ils sont :
- **Système-agnostiques** — formulés "Le système doit permettre...", jamais "Le Workspace doit..."
- **Réutilisables** — un même WR peut être implémenté différemment selon le Workspace
- **Dérivés** — chaque WR est traçable à un ou plusieurs CI

**Registre courant :**

| ID | Énoncé court | Dérivé de |
|---|---|---|
| WR-01 | Reconstruction de contexte en < 30s | CI-01 |
| WR-02 | Delta comme état par défaut | CI-02 |
| WR-03 | Information minimale par défaut | CI-03 + CI-01 |
| WR-04 | Anchor de sécurité minimum accessible | CI-01 + CI-03 |
| WR-05 | Contributions inter-pro visibles et attribuées | CI-04 + CI-05 |
| WR-06 | Attribution obligatoire de toute information | CI-05 |
| WR-07 | Gestion du limbo informationnel | CI-03 |
| WR-08 | Deux modes (suivi / découverte) | CI-02 + CI-01 |
| WR-09 | File de triage pour profils coordinateurs | CI-04 |

---

## Niveau 6 — UX Principles (UX-xxx)

**Préfixe :** UX
**Question :** Comment les Requirements sont-ils implémentés en interface ?

**Nature :** Les UX Principles sont des décisions de conception — pas des fondations. Ils sont :
- **Modifiables** — si un meilleur principe implémente le même Requirement, le principe change, pas le Requirement
- **Non-substituables aux Requirements** — l'Anchor est une réponse à WR-01 et WR-02, pas un invariant
- **Testables** — leur efficacité est validée par des tests utilisateurs, pas par déduction

**Exemples :**

| Principe | Implémente | Type |
|---|---|---|
| Anchor | WR-01, WR-02, WR-04 | Concept de présentation |
| Progressive Disclosure | WR-03 | Pattern d'interaction |
| Delta View | WR-02 | Pattern d'affichage |
| Source Badge | WR-06 | Composant d'attribution |
| Team Panel | WR-05 | Composant de collaboration |

**Règle fondamentale :** Aucun principe UX ne peut être cité dans un document de Niveau 2, 3 ou 4. L'Anchor, la Progressive Disclosure, le Timeline n'apparaissent jamais dans CCF-01 ou CCF-02 — seulement dans les documents UX et les Workspaces.

---

## Niveau 7 — Workspaces

**Nature :** Les produits. Implémentations concrètes des UX Principles pour un contexte d'usage spécifique.

**Registre courant :**

| Workspace | Question centrale | Requirements implémentés |
|---|---|---|
| Patient Workspace | Comment un praticien reconstruit-il le contexte d'un patient ? | WR-01 à WR-08 |
| Practitioner Workspace | Comment un praticien gère-t-il sa journée / semaine ? | WR-01, WR-03, WR-07, WR-09 |
| Collaboration Workspace | Comment un praticien s'inscrit-il dans le réseau de soin ? | WR-05, WR-06, WR-07 |
| Care Relationship Workspace | Comment patient et praticien partagent-ils une représentation commune ? | À définir |
| Organisation Workspace | Comment une organisation pilote-t-elle son activité clinique ? | À définir |

---

---

# II. Conventions de nommage

## Préfixes canoniques

| Préfixe | Niveau | Format | Exemple |
|---|---|---|---|
| `CCF-` | Framework documents | CCF-000, CCF-01, CCF-02 | CCF-02 — Clinical Cognitive Episode |
| `CI-` | Cognitive Invariants | CI-01, CI-02 | CI-01 — Context Reconstruction |
| `WR-` | Workspace Requirements | WR-01, WR-02 | WR-01 — Context reconstruction in < 30s |
| `UX-` | UX Principles | UX-P01, UX-P02 | UX-P01 — Context First |

## Règles de nommage

**Les noms sont en anglais.** La taxonomie CCF utilise l'anglais pour garantir la cohérence entre les documents et permettre une référence internationale dans la littérature.

**Les numéros sont séquentiels.** CI-01, CI-02... sans hiérarchie numérique. L'appartenance à une famille est déclarée explicitement, pas encodée dans le numéro.

**Les documents CCF sont numérotés par ordre logique.** CCF-000 est le charter (ce document). CCF-01 est l'Architecture. CCF-02 est l'Episode. Les futurs documents continueront la séquence.

## Nommage des Workspaces

Les Workspaces ne reçoivent pas de préfixe numérique. Ils sont nommés par leur contexte d'usage :
- Patient Workspace (non : Workspace-001)
- Practitioner Workspace (non : WS-002)

---

---

# III. Règles d'utilisation du CCF

## Règle 1 — La hiérarchie est unidirectionnelle

Un document de niveau N peut référencer un document de niveau N-1 ou N-2, jamais un document de niveau N+1.

- CCF-01 peut être cité dans CCF-02. ✅
- CCF-02 peut citer CI-01. ✅
- CI-01 ne peut pas citer un UX Principle. ❌
- Un UX Principle ne peut pas modifier un CI. ❌

## Règle 2 — Aucun design dans les niveaux 2, 3, 4

Les niveaux 2 (Architecture), 3 (Episode) et 4 (Invariants) ne contiennent pas de références à des composants, patterns UX, ou décisions de design.

L'Anchor, la Progressive Disclosure, le Delta View n'apparaissent jamais dans CCF-01, CCF-02, ou les documents CI-xxx.

## Règle 3 — Tout WR est traçable à au moins un CI

Un Workspace Requirement qui ne peut pas être rattaché à un Cognitive Invariant n'est pas un Requirement — c'est une décision de design déguisée. Il appartient au Niveau 6 (UX Principles).

## Règle 4 — Tout CI est falsifiable

Un Cognitive Invariant doit comporter :
- Un énoncé testable
- Des signaux de confirmation
- Des signaux de réfutation
- Une traçabilité au corpus ou à la littérature

Un invariant sans critères de falsification n'est pas un invariant — c'est une croyance.

## Règle 5 — Le schéma canonique apparaît dans chaque document CCF

Tout document CCF, CI ou WR commence par le schéma canonique de la hiérarchie (simplifié si nécessaire) avec la position du document surlignée ou annotée.

---

---

# IV. Registre des documents

## Documents existants

| ID | Titre | Niveau | Statut |
|---|---|---|---|
| CCF-000 | Clinical Cognition Framework (ce document) | Charter | Accepted v1.0 |
| CCF-01 | Clinical Cognitive Architecture | 2 — Architecture | Draft v1.1 |
| CCF-02 | Clinical Cognitive Episode | 3 — Episode | Draft v1.0 |

## Documents à créer (planifiés)

| ID | Titre | Niveau | Priorité |
|---|---|---|---|
| CI-001 | Cognitive Invariants — Registre complet | 4 — Invariants | Haute |
| WR-001 | Workspace Requirements — Registre complet | 5 — Requirements | Haute |
| CCF-03 | Clinical Cognitive Flow *(opérationnel — flux minute par minute)* | 3 — Episode extension | Moyenne |

## Documents existants à migrer

| Document actuel | Action requise | Priorité |
|---|---|---|
| CCF-01 | ~~Renommer IC-xxx → CI-xxx~~ ✅ · ~~Ajouter schéma canonique~~ ✅ | Complété |
| CCF-02 | ~~Mettre à jour références IC → CI~~ ✅ | Complété |
| CC-000 (ancien) | Archiver — contenu migré vers CCF-01 + CI-xxx | Moyenne |

---

---

# V. Gouvernance du CCF

## Qui peut modifier un document CCF ?

Les documents de Niveau 2 et 3 (Architecture, Episode) requièrent une validation explicite avant modification — ils sont la fondation de tous les Workspaces.

Les documents de Niveau 4 (Invariants) peuvent être étendus par l'ajout de nouveaux invariants ou la révision de l'état de confiance d'un invariant existant. Une réfutation d'invariant requiert une évidence documentée.

Les documents de Niveau 5 et 6 (Requirements, UX) peuvent évoluer plus librement — ils ne modifient pas les fondations scientifiques.

## Conditions de mise à jour d'un CI

Un Cognitive Invariant peut être :
- **Renforcé** : évidence terrain supplémentaire (nouvel entretien, test utilisateur)
- **Nuancé** : évidence d'un domaine d'application limité (ex. CI-02 ne s'applique pas aux coordinateurs)
- **Suspendu** : évidence contradictoire — l'invariant ne gouverne plus les décisions le temps de la résolution
- **Réfuté et archivé** : évidence suffisante d'invalidity — retiré du registre actif

## Extension du corpus

L'ajout de nouveaux profils cliniques au corpus (hospitalier, urgences, pédiatrie) peut :
- Confirmer des invariants existants (augmente la confiance)
- Révéler des variantes d'un invariant (affine le scope)
- Introduire de nouveaux invariants (étend le registre CI)
- Réfuter un invariant (déclenche révision)

Chaque extension de corpus est documentée dans un fichier F-xxx et son impact sur le CCF est évalué explicitement.

---

---

# Synthèse

> Le Clinical Cognition Framework n'est pas une théorie.
>
> C'est la colonne vertébrale intellectuelle de MedLink.
>
> Il organise ce que nous savons du travail clinique,
> comment nous l'avons appris,
> et comment nous le traduisons en exigences produit.
>
> Il sépare ce qui est observé (Clinical Work),
> ce qui est modélisé (Architecture, Episode, Invariants),
> et ce qui est conçu (Requirements, Principles, Workspaces).
>
> Cette séparation est la garantie que MedLink reste ancré
> dans la réalité du soin — et non dans les intuitions du design.

---

*Version 1.0 — Taxonomie figée — 2026-07-30*
*Ce document ne peut être modifié que par décision explicite et documentée.*
