# DR-002 — Introduction d'une couche Requirements entre Invariants et Features

**Status :** Accepted
**Date :** 2026-07-31
**Affects :** CWRM-002 (Layer Architecture), CWRM-300 (Translation — à venir)
**Supersedes :** —

---

## 1. Contexte

Dans la version initiale du pipeline CWRM, la chaîne de transformation passait directement de l'Invariant à la Feature :

```
INV → Feature
```

Cette structure posait un problème structurel : elle confondait l'expression d'un besoin (ce que le système doit permettre) avec son implémentation (comment ce besoin est satisfait).

La question qui a motivé cette décision :

> Si demain nous changeons l'implémentation d'une Feature, perdons-nous la justification de son existence ?

Avec INV → Feature directement, oui. Le lien entre la connaissance empirique et la décision produit ne survit pas aux changements d'implémentation.

---

## 2. Décision

Introduire une couche Requirements (exigences de conception) entre les Invariants et les Features.

La chaîne devient :

```
INV → Design Reasoning → Requirement → Feature(s)
```

Un Requirement exprime un besoin stable.

Une Feature est une implémentation possible de ce besoin.

---

## 3. Alternatives considérées

**Alternative A — Conserver INV → Feature directement**

Rejetée.

Avantages : plus simple, moins de niveaux.

Inconvénients : quand une Feature change, le lien avec l'INV qui la justifie se perd ou doit être reconstruit. Le besoin sous-jacent n'est jamais exprimé indépendamment de son implémentation.

---

**Alternative B — Utiliser uniquement les ADR pour documenter les décisions**

Rejetée.

Les Architecture Decision Records capturent les décisions d'implémentation et leur justification. Ils ne sont pas conçus pour exprimer des besoins stables issus de la recherche empirique. Les ADR sont un outil de MedLink, pas du CWRM.

---

**Alternative C — Utiliser les Design Principles comme intermédiaire**

Rejetée comme couche unique.

Les Design Principles expriment des orientations générales. Ils ne sont pas assez précis pour constituer la base d'une Feature. Une Feature doit pouvoir être reliée à une exigence spécifique, pas seulement à un principe général.

---

**Alternative retenue — Couche Requirements explicite**

Un Requirement est une exigence de conception stable, formulée indépendamment de toute solution technique.

Propriétés d'un Requirement valide dans le CWRM :

- formulé du point de vue du système ("Le système doit...") ;
- traceable à au moins un INV ;
- stable — ne change pas quand l'implémentation change ;
- testable — on peut vérifier si une Feature le satisfait ou non.

---

## 4. Justification

**Inspiration : ingénierie des systèmes critiques**

Dans les domaines où la traçabilité des exigences est obligatoire (NASA, ISO 13485, DO-178C, IEC 62304), la séparation entre besoins et implémentations n'est pas une option. Elle est imposée précisément parce que les implémentations changent mais les besoins restent.

Le CWRM s'inspire de cette pratique non par convention, mais parce qu'elle résout un problème réel : la durabilité de la justification des décisions produit.

**Stabilité de la justification**

Une Feature peut être supprimée, redessinée ou fusionnée avec une autre. Si son lien avec la recherche empirique passe uniquement par elle-même, cette justification disparaît avec elle. Un Requirement survit aux changements d'implémentation.

**Flexibilité de conception**

Plusieurs Features peuvent satisfaire le même Requirement. Cette structure permet d'explorer des alternatives d'implémentation sans remettre en question la validité du besoin empirique sous-jacent.

---

## 5. Conséquences

**Pour le corpus**

Les OBS, RQ et INV existants ne changent pas. La couche Requirements s'ajoute en aval des INV.

**Pour la méthode de traduction**

Le Design Reasoning produit désormais un Requirement, pas directement une Feature. La Feature est une décision de conception qui répond au Requirement.

**Pour MedLink**

Chaque Feature du backlog MedLink doit pouvoir être reliée à un Requirement, lui-même relié à un INV. Cette exigence sera documentée dans les ADR de MedLink.

**Pour les futurs chercheurs**

La distinction Requirement / Feature est explicite et documentée. Un reviewer peut vérifier indépendamment si la Feature satisfait le Requirement, et si le Requirement est justifié par les preuves empiriques.

---

## 6. Reviewer Checklist

- [ ] La distinction entre Requirement et Feature est-elle claire ?
- [ ] Les alternatives ont-elles été considérées honnêtement ?
- [ ] La justification est-elle indépendante des préférences individuelles ?
- [ ] Cette décision est-elle compatible avec CWRM-000 (principes P1–P8) ?
- [ ] Cette décision renforce-t-elle la traçabilité (P2) sans nuire à la simplicité (P6) ?

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-31 | v1.0 | Création |
