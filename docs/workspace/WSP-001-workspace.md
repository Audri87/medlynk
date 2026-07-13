# WSP-001 — Workspace

**Statut** : Validé
**Revue** : ✅ VALIDÉ — 2026-07-09

---

## Contexte

Les observations terrain montrent que les praticiens ne consultent jamais un dossier de manière exhaustive.

Avant toute décision clinique, ils reconstruisent rapidement une représentation mentale de la situation à partir d'un ensemble limité d'informations pertinentes.

Le Workspace est la réponse architecturale à ce besoin.

Il ne remplace ni le raisonnement du praticien, ni le Domain Model.

Il prépare les conditions permettant à ce raisonnement de s'exercer.

---

## Définition

> **Un Workspace est une projection calculée depuis l'état du domaine, assemblée pour un Actor dans une Organization et un Context donnés, afin de lui permettre de reconstruire la situation pertinente à son travail, en lui présentant les informations, les actions disponibles et les signaux d'attention nécessaires à l'exercice de sa responsabilité.**

L'Organization détermine les permissions, la gouvernance et le membership. Elle est encodée dans les permissions calculées en amont de l'assemblage.

Le mode de calcul du Workspace (synchrone, pré-calculé, reconstruit depuis les domain events) est un choix d'architecture, pas une propriété du Workspace.

---

## Responsabilité

Le Workspace possède une responsabilité unique :

> **Assembler le domaine pour un acteur dans un contexte donné.**

Il ne produit jamais de connaissance clinique.

Il ne prend jamais de décision clinique.

Il ne contient jamais de règles métier.

---

## Entrées

Le Workspace consomme :

* Clinical Knowledge
* Clinical Activities
* Clinical Contributions
* Care Relationships
* Context Reconstruction
* Permissions déjà calculées (encodant l'Organization)
* Domain Events publiés

Les Care Relationships sont requises pour les scénarios multi-praticiens. Pour un praticien seul (Sprint 1), cette dépendance est absente.

---

## Sorties

Le Workspace expose uniquement :

* informations pertinentes
* actions disponibles
* signaux d'attention
* continuité clinique
* changements significatifs (delta)

Aucune logique clinique nouvelle n'est produite.

---

## Position dans l'architecture

```
Domain Model
      │
      ▼
Application Services  ←  Context Engine (calcule ce qui est visible)
      │
      ▼
Workspace             ←  Workspace Engine (assemble le résultat)
      │
      ▼
User Interface
```

Le Context Engine détermine ce qui est visible, les capacités disponibles et les priorités.

Le Workspace Engine assemble ces éléments en une projection cohérente pour l'acteur.

Le Workspace constitue la frontière entre le modèle métier et l'expérience de travail.

---

## Ce que le Workspace n'est pas

Le Workspace n'est pas :

* un écran
* une page web
* une interface utilisateur
* un workflow
* un cas d'usage
* un Aggregate
* un Application Service
* un Bounded Context

---

## Principes

### W-001

Le Workspace ne modifie jamais le Domain.

### W-002

Le Workspace ne contient aucune règle clinique.

### W-003

Le Workspace reste indépendant du média.

Une interface Web, mobile, vocale ou imprimée peut utiliser le même Workspace.

### W-004

Le Workspace prépare le raisonnement.

Il ne raisonne jamais.

### W-005

Le jugement clinique appartient exclusivement au praticien.

---

## Conséquences

Une évolution de l'interface utilisateur ne modifie pas le Workspace.

Une évolution du Domain n'impose pas nécessairement une évolution de l'interface.

Le Workspace constitue la frontière entre le modèle métier et l'expérience de travail.

---

## Dépendances ouvertes

* **G1 — Clinical Authorization** : les scénarios multi-praticiens requièrent que les Care Relationships soient formalisées (ADR non encore écrite). Sprint 1 (praticien seul) n'est pas bloqué.
* **Context Reconstruction** : le périmètre exact de ce qu'il lit dans Clinical Knowledge reste à préciser.

---

## Relation avec le Clinical Cognition Framework

Le Workspace matérialise le résultat de la reconstruction du contexte (CCF-001 — O-002).

Il soutient le praticien dans la reconstruction de la situation clinique sans jamais interpréter cette situation à sa place.

Les sorties du Workspace répondent directement aux trois questions du praticien (MP-001) :

* **Où en étais-je ?** → continuité clinique, dernier fil de raisonnement
* **Qu'est-ce qui a changé ?** → delta, signaux d'attention
* **Que dois-je faire ?** → actions disponibles
