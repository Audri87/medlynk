# MedLink Product Operating Model v1.0

| Field | Value |
|---|---|
| Version | 1.0 |
| Status | **Frozen** |
| Date | 2026-08-04 |
| Nature | Operational — how the product team works |
| Governed by | [Product Constitution v1.0](PRODUCT-CONSTITUTION-v1.0.md) |

---

## Notre mission

Concevoir le meilleur environnement de travail numérique pour les professionnels de santé.

Pas le logiciel avec le plus de fonctionnalités.

Le logiciel qui réduit le plus la charge cognitive.

---

## Notre boucle de travail

Chaque sprint suit exactement cette boucle. Aucune exception.

```
Observer
    │  ← toujours déclenché par une observation concrète
    │    (ACT, extrait d'entretien, résultat de test utilisateur)
    │    jamais par une opinion de design
    │
    ▼
Comprendre le problème
    │
    ▼
Identifier la transition cognitive
    │
    ▼
Formuler la question utilisateur
    │
    ▼
Concevoir un Workspace
    │
    ▼
Prototyper
    │
    ▼
Tester avec les praticiens
    │
    ▼
Apprendre
```

---

## Notre unité de conception

Nous ne concevons plus :

- des pages
- des modules
- des fonctionnalités

Nous concevons :

**des réponses à des questions utilisateur.**

| Question | Workspace |
|---|---|
| Puis-je commencer sereinement ? | Morning Brief |
| Pourquoi ce patient est-il là ? | Patient Context |
| Qu'est-ce qui a changé ? | Timeline |
| Que dois-je faire maintenant ? | Consultation Workspace |
| Qui doit savoir quoi ? | Collaboration Workspace |

---

## Notre règle d'or

Chaque Workspace doit satisfaire 5 critères :

1. Il répond à une seule question principale.
2. Il réduit une transition cognitive identifiable.
3. Il est justifié par au moins une observation terrain.
4. Il peut être testé auprès d'un praticien.
5. Si on le supprime, on sait exactement quelle valeur disparaît.

---

## Notre backlog

Le backlog est organisé par questions, pas par fonctionnalités.

| Sprint | Question |
|---|---|
| Sprint 0 | Puis-je commencer sereinement ma journée ? |
| Sprint 1 | Pourquoi ce patient est-il devant moi ? |
| Sprint 2 | Comment rester concentré pendant la consultation ? |
| Sprint 3 | Comment documenter sans perdre le fil ? |
| Sprint 4 | Comment passer au patient suivant sans effort ? |

---

## Le rôle du CWRM

Le CWRM est le moteur de découverte. Il intervient en amont :

```
Entretien → Observation → Décision Produit
```

Le relais passe ensuite au Product Design.

Le produit est le centre de gravité. Le CWRM l'informe — il ne le bloque pas.

---

## Notre définition du succès

Nous ne mesurons pas MedLink par :

- le nombre de fonctionnalités ;
- le nombre d'écrans ;
- le nombre de formulaires.

Nous le mesurons par :

| Métrique | Nature |
|---|---|
| Temps pour reprendre le contexte d'un patient | Mesurable — baseline requis |
| Temps pour préparer la première consultation | Mesurable — baseline requis |
| Nombre d'interruptions nécessitant une re-navigation | Mesurable — baseline requis |
| Temps de documentation après une consultation | Mesurable — baseline requis |
| Sentiment de maîtrise de la journée | Qualitatif — tests utilisateurs |

> **Baseline Sprint 0 :** Avant de mesurer l'amélioration, observer et chronométrer ces métriques avec les outils actuels des praticiens. Sans baseline, les métriques de succès n'ont pas de zéro.

---

## Notre slogan d'équipe

> **Nous ne dessinons jamais un écran. Nous répondons à une question.**

Chaque fois que nous sommes bloqués, nous demandons : quelle est la question du praticien ?
