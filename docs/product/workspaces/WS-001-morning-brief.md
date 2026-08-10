# WS-001 — Morning Brief Blueprint

| Field | Value |
|---|---|
| ID | WS-001 |
| Version | 0.1 |
| Status | **VALIDATED FOR PROTOTYPING** |
| Lifecycle | ☐ Discovery · ☑ Blueprint · ☐ Prototype · ☐ User Test · ☐ Production |
| Date | 2026-08-04 |
| Sprint | Sprint 0 |
| Depends on | PAT-M-001, PAT-M-002, PAT-M-003 · PP-001, PP-002, PP-003, PP-004 |
| Wireframe | [wireframe-WS-001-v0.1.md](wireframe-WS-001-v0.1.md) |
| Device policy | Device-independent — same concept on mobile, tablet, desktop |

---

## 1. Product Question

**Q-001 — Puis-je commencer sereinement ma journée ?**

Cette question est la raison d'être du Workspace.

---

## 2. Evidence

### Patterns (≈)

| ID | Énoncé | Statut |
|---|---|---|
| PAT-M-001 | Signal precedes Horizon — tout praticien cherche les changements avant le planning | ≈ |
| PAT-M-002 | Preparation follows Uncertainty — la préparation est déclenchée par l'incertitude, pas le temps | ≈ |
| PAT-M-003 | Context reconstruction is fragmented — plusieurs outils sont nécessaires aujourd'hui | ≈ |

### Observations confirmées

| ID | Observation | Statut |
|---|---|---|
| OBS-M-001 | Le praticien recherche les changements avant de consulter son planning | ✓ |
| OBS-M-002 | Le début de journée est structuré entre Signal et Horizon | ✓ |
| OBS-M-003 | La reprise de contexte peut commencer avant l'arrivée au cabinet | ✓ |
| OBS-M-004 | La préparation détaillée dépend du besoin de reconstruire le contexte | ✓ |
| OBS-M-005 | Plusieurs praticiens consacrent une partie du début de journée à des obligations non cliniques | ✓ |

---

## 3. Product Principles

| Principe | Énoncé | Source |
|---|---|---|
| PP-001 | Signal precedes Horizon — afficher les changements avant le planning | PAT-M-001 |
| PP-002 | Preparation follows Uncertainty — aider davantage quand le contexte est moins présent | PAT-M-002 |
| PP-003 | One Morning Entry Point — un seul outil pour la reprise de contexte matinale | PAT-M-003 *(hypothèse — à valider)* |
| PP-004 | Administrative obligations SHALL NOT dominate clinical preparation | OBS-M-005 |

---

## 4. Cognitive Transition

```
PERDU (no context)
    ↓
Reprise de contexte
    ↓
ORIENTÉ
    ↓
Prêt à commencer
```

Le Morning Brief ne décide rien. Il réduit le coût de cette transition.

---

## 5. User Outcome

À la fermeture du Morning Brief, le praticien doit pouvoir dire :

> "Je sais ce qui a changé, je sais ce qui m'attend, je peux commencer."

---

## 6. Information Architecture

Trois blocs, ordonnés par les Product Rules. Chaque bloc répond à une question.

### Bloc 1 — Signals

**Question :** Qu'est-ce qui a changé ?

Contenu :
- Résultats reçus
- Messages non lus (cliniques)
- Examens disponibles
- Annulations ou modifications
- Événements inattendus (hospitalisations, urgences)

Comportement : toujours visible. Jamais collapsed. État vide = "Rien de nouveau."

### Bloc 2 — Today's Horizon

**Question :** Qu'est-ce qui m'attend aujourd'hui ?

Contenu :
- Nombre de patients
- Compte à rebours premier rendez-vous
- Liste du jour : heure · nom · type (nouveau / suivi)
- Indicateur préparation recommandée (PR-002)

Comportement : visible par défaut, sous le Bloc Signal.

### Bloc 3 — Obligations

**Question :** Qu'est-ce que je dois traiter aujourd'hui ?

Contenu :
- Télétransmissions en attente
- Prescriptions à valider
- Documents à compléter
- Tâches administratives

Comportement : **collapsed par défaut** (PR-004). Une interaction révèle le bloc.

---

## 7. Explicit Non-Goals

Le Morning Brief n'est pas :

- un agenda complet ;
- une messagerie ;
- un tableau de bord administratif ;
- un outil d'aide à la décision clinique.

Son objectif est uniquement la reprise de contexte matinale.

---

## 8. Success Metrics

| Métrique | Nature | Baseline requis |
|---|---|---|
| Temps pour atteindre un état de préparation | Comportemental | Oui |
| Nombre d'outils ouverts avant la première consultation | Comportemental | Oui |
| Temps consacré à la reconstruction du contexte | Comportemental | Oui |
| Sentiment de maîtrise de la journée | Qualitatif | Test utilisateur |
| Signaux importants découverts seulement pendant une consultation | Indicateur de défaillance | Oui |

> La baseline doit être mesurée avec les outils actuels avant tout test du Morning Brief.

---

## 9. Open Questions

| # | Question | Impact | Status |
|---|---|---|---|
| OQ-001 | Durée moyenne de la préparation matinale avec les outils actuels ? | Baseline metrics | Open |
| OQ-002 | Les praticiens souhaitent-ils clôturer explicitement ("Je suis prêt") ou passent-ils naturellement ? | Interaction design | Open |
| OQ-003 | Quelle quantité de signaux reste lisible avant de créer une surcharge ? | Signal taxonomy | Open |
| OQ-004 | Les priorités diffèrent-elles significativement selon les professions ? | Segmentation | Open |
| OQ-005 | Un signal peut-il être dismissé ou snoozé ? Qui décide du niveau d'urgence ? | Signal taxonomy | Open |

---

## 10. Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-08-04 | Blueprint initial — Sprint 0 |
