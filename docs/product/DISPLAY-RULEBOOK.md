# MedLink Display Rulebook

| Field | Value |
|---|---|
| Status | Living document — grows with each sprint |
| Governed by | [PRODUCT-PRINCIPLES.md](PRODUCT-PRINCIPLES.md) |
| Nature | Specialty-specific adaptations of Product Principles |

> A Display Rule is not a new Product Principle.
> It is a specialization of an existing Principle for a given clinical profile.
> Same principle. Different presentation.
>
> A Principle can have exceptions. Those exceptions are Display Rules.

---

## What is a Display Rule?

Product Principles are universal constraints — they apply to every practitioner.

Display Rules answer the question: *how does this Principle manifest for a specific clinical context?*

```
Product Principle (universal)
    ↓
Display Rule (specialized)
    ↓
Workspace component (rendered)
```

**Invariant:** the underlying Product Principle is never violated by a Display Rule.
A Display Rule that would require violating a Principle is evidence that the Principle is wrong.

---

## Lifecycle

Each Display Rule has its own lifecycle, independent of its source Principle.
Display Rules evolve as clinical specialties are added to the corpus.

| Field | Values |
|---|---|
| Version | Semantic (0.1, 0.2, 1.0, ...) |
| Status | Draft · Under Validation · Validated · Deprecated |
| Validated | Confirmed by practitioner test of the matching profile |
| Updated | Date of last revision |

---

## Format

```
DR-NNN — [profile name]

Lifecycle: v0.x · Status · Validated: true/false · Updated: YYYY-MM-DD

Profil:      [clinical profile or specialty context]
Source PP:   [Product Principle(s) being adapted]
Adaptation:  [how the principle manifests for this profile]
Rationale:   [corpus support — epistemic level ✓/≈/?]
```

---

## Sprint 1 — WS-002 Patient Context

### DR-001 — Suivi longitudinal

> Lifecycle: v0.1 · Draft · Validated: false · Updated: 2026-08-04

```
Profil:      Praticiens en relation de soin longitudinale
             (Psychologue, Infirmière libérale, Kinésithérapeute, Sophrologue)
Source PP:   PP-005, PP-006, PP-008
Adaptation:
  Bloc Continuité (primaire) : résumé de la dernière séance
  Bloc Intention (secondaire) : plans notés en fin de séance précédente,
                                 affichés uniquement si documentés
  Bloc Historique             : collapsed par défaut
Rationale:   ✓ OBS-P-001 (ACT-F004-004, ACT-F004-005, ACT-F008-008, ACT-F006-008)
             ≈ PAT-P-001 — point d'entrée le plus fréquent pour ces profils
```

**Évolution attendue:** premier profil à valider en test praticien. Si invalidé sur la notion de "dernière séance" comme point d'entrée, revoir le Bloc Continuité.

---

### DR-002 — Suivi grossesse

> Lifecycle: v0.1 · Draft · Validated: false · Updated: 2026-08-04

```
Profil:      Sage-femme en suivi prénatal et postnatal
Source PP:   PP-005, PP-006, PP-008
Adaptation:
  Bloc Continuité (primaire) : terme de la grossesse + stade actuel + dernière consultation
  Bloc Intention (secondaire) : éléments de suivi attendus (poids, TA, mouvements fœtaux)
  Bloc Historique             : collapsed par défaut
Rationale:   ✓ OBS-P-001 (ACT-F006-008)
             ✓ Terme de grossesse comme ancre temporelle primaire (ACT-F006-004)
             Note: le terme est un fait biologique fixe, pas une donnée "récente" —
             il illustre que "contexte récent" est défini par le profil clinique,
             pas par la date de dernière modification.
```

**Évolution attendue:** la notion d'"éléments de suivi attendus" (poids, TA) comme Bloc Intention est une hypothèse produit non directement corpus. À valider.

---

### DR-003 — Acte sur demande

> Lifecycle: v0.1 · Draft · Validated: false · Updated: 2026-08-04

```
Profil:      Praticiens réalisant des actes sur prescription ou demande externe
             (Échographiste, et par extension : radiologue, biologiste, kiné sur ordonnance)
Source PP:   PP-005, PP-006
             (PP-008 ne s'applique pas — exception documentée)
Adaptation:
  Bloc Continuité (primaire) : ordonnance — motif + prescripteur + date
  Bloc Intention (secondaire) : absent (l'intention est dans l'ordonnance)
  Bloc Historique             : DÉPLOYÉ par défaut — images et comptes rendus
                                 précédents sont le contexte primaire
Exception PP-008:
  PP-008 prescrit "collapse historical detail by default."
  Pour DR-003, l'historique (images, CR précédents) est le contexte primaire,
  pas un détail secondaire. L'exception est justifiée corpus.
Rationale:   ✓ OBS-P-002 (ACT-F005-005 "Je cherche : l'ordonnance")
             ✓ ACT-F005-006 "Pourquoi ce patient est-il devant moi ?"
             ✓ ACT-F005-007, ACT-F005-008 — images et CR précédents consultés systématiquement
```

**Évolution attendue:** DR-003 est le seul profil avec une exception documentée à PP-008. Si d'autres profils "acte" émergent du corpus, les regrouper ici ou créer des sous-Display Rules par spécialité.

---

### DR-004 — Coordination multi-intervenants

> Lifecycle: v0.1 · Draft · Validated: false · Updated: 2026-08-04

```
Profil:      Praticiens coordinateurs ou de liaison
             (Infirmière coordinatrice, case manager, médecin traitant en coordination)
Source PP:   PP-005, PP-006, PP-008
Adaptation:
  Bloc Continuité (primaire) : statut actuel des intervenants actifs sur ce patient
                                + dernière note de transmission
  Bloc Intention (secondaire) : transmissions en attente + actions à coordonner
  Bloc Historique             : collapsed par défaut
Rationale:   ✓ ACT-F009-027 "Tout le monde m'appelle. Je fais le lien entre les médecins."
             ≈ PAT-P-001 adapté — la "dernière interaction" est ici
             la dernière transmission inter-praticien, pas la dernière séance directe.
             Note: OQ-P-001 reste ouvert — le contexte multi-intervenant implique
             que la "continuité" est distribuée entre plusieurs acteurs.
```

**Évolution attendue:** DR-004 est le profil le moins validé corpus (1 ACT de base). Le Bloc Continuité avec statut des intervenants est une hypothèse produit forte. À valider en priorité après DR-001.

---

## Règle de gouvernance

1. Chaque Display Rule doit référencer au moins un Product Principle source.
2. Chaque Display Rule doit avoir une ancre corpus (✓ ou ≈). Une DR sans ancre corpus est une opinion.
3. Une Display Rule ne peut pas contredire son Principle source — elle peut uniquement le spécialiser.
4. Toute exception à un Principle doit être explicitement documentée (comme DR-003 vs PP-008).
5. Le lifecycle de chaque DR est indépendant — une DR peut être Validated avant les autres.

---

## Sprints suivants

| Sprint | Workspace | Display Rules attendues |
|---|---|---|
| Sprint 2 | WS-003 Clinical Summary | DR-005 à DR-008 |
| Sprint 3 | WS-006 Consultation | DR-009 à DR-012 |
| Sprint 4 | WS-007 Documentation | DR-013 à DR-016 |
