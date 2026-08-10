# WS-002 — Patient Context Blueprint

| Field | Value |
|---|---|
| ID | WS-002 |
| Version | 0.2 |
| Status | **Prototype — Pending User Test** |
| Lifecycle | ☐ Discovery · ☑ Blueprint · ☑ Prototype · ☐ User Test · ☐ Production |
| Date | 2026-08-04 |
| Sprint | Sprint 1 |
| Depends on | PAT-P-001, PAT-P-002 · PP-005, PP-006, PP-008 |
| Display Rules | DR-001, DR-002, DR-003, DR-004 |
| Prototype | [WS-002-prototype-v0.1.html](WS-002-prototype-v0.1.html) |

---

## 1. Product Question

**Q-002 — Pourquoi ce patient est-il devant moi aujourd'hui ?**

Cette question contient quatre sous-questions imbriquées, qui structurent l'Information Architecture :

1. Qui est ce patient et pourquoi est-il là maintenant ?
2. Où en étions-nous lors de notre dernière interaction ?
3. Qu'avions-nous prévu ?
4. Y a-t-il quelque chose de l'historique qui compte aujourd'hui ?

---

## 2. Evidence

> Ce Blueprint distingue explicitement trois niveaux épistémiques.
> Aucun élément n'est promu d'un niveau à l'autre sans justification.

### Légende

| Symbole | Niveau | Définition |
|---|---|---|
| ✓ | Observation | Directement issu du corpus verbatim |
| ≈ | Pattern | Fortement suggéré — convergent mais non universel |
| ? | Hypothèse produit | Décision de conception à valider empiriquement |

---

### ✓ Observations directes

| ID | Observation | Corpus |
|---|---|---|
| OBS-P-001 | Les praticiens consultent la dernière interaction clinique avant de recevoir le patient | ACT-F004-004, ACT-F004-005, ACT-F008-008, ACT-F006-008 |
| OBS-P-002 | L'échographiste consulte l'ordonnance en premier — pas la dernière consultation | ACT-F005-005, ACT-F005-006 |
| OBS-P-003 | Les praticiens recherchent les intentions ou plans notés en fin de séance précédente | ACT-F004-007, ACT-F002-015 |
| OBS-P-004 | La profondeur de préparation augmente avec le temps écoulé depuis la dernière consultation | ACT-F004-003 |
| OBS-P-005 | Certains praticiens ne documentent pas en fin de séance — la mémoire remplace le dossier | ACT-F001-015, ACT-F001-019 |

---

### ≈ Patterns

| ID | Pattern | Corpus | Profils |
|---|---|---|---|
| PAT-P-001 | La dernière consultation est le point d'entrée privilégié pour les praticiens en suivi longitudinal | ACT-F004-004, ACT-F008-008, ACT-F006-008, ACT-F002-012 | 4–5 / 9 |
| PAT-P-002 | La préparation est proportionnelle à la distance temporelle et à la familiarité avec le patient | ACT-F004-003 | Indirect |
| PAT-P-003 | Pour les profils longitudinaux, le récent précède le complet dans la séquence de lecture | Multi-profils | Longitudinaux uniquement |

---

### ? Hypothèses produit

| ID | Hypothèse | Niveau de risque |
|---|---|---|
| HYP-P-001 | Afficher le contexte récent avant l'historique réduit le temps de préparation | Medium |
| HYP-P-002 | Les intentions inachevées peuvent être automatiquement détectées et surfacées | High — dépend de la qualité de documentation |
| HYP-P-003 | Un résumé de continuité réduit la charge cognitive de reconstruction | Medium — non mesurable sans test |
| HYP-P-004 | Un temps de préparation cible de 30 secondes est atteignable | High — issu d'un seul ACT synthétique non verbatim (ACT-F003-001) |

---

## 3. Product Principles

> Les Product Principles sont des décisions de conception, pas des découvertes.
> Ils dérivent de Patterns et d'Observations. Ils peuvent avoir des exceptions.
> Ces exceptions sont les Display Rules.

| Principe | Énoncé | Source | Statut |
|---|---|---|---|
| PP-005 | Surface the relevant recent interaction first | PAT-P-001 | À valider |
| PP-006 | Historical depth follows context gap | PAT-P-002, PAT-P-003 | À valider |
| PP-008 | Collapse historical detail by default (Display Rules specify exceptions) | PAT-P-003 | À valider |

**PP-007 supprimé de ce Blueprint** — "Expose unfinished intentions" n'a pas de support corpus direct. Reclassé en Open Question OQ-P-003. Voir [PRODUCT-PRINCIPLES.md](../PRODUCT-PRINCIPLES.md) pour le détail.

---

## 4. Display Rules

> Une Display Rule est une adaptation spécialisée d'un Product Principle pour un profil clinique.
> Même Principle. Présentations différentes selon le profil.

| DR | Profil | Point d'entrée primaire | Secondaire | Historique |
|---|---|---|---|---|
| DR-001 | Suivi longitudinal (Psychologue, Infirmière libérale, Kinésithérapeute) | Dernière séance — résumé + plans notés | Intentions documentées (si présentes) | Collapsed |
| DR-002 | Suivi grossesse (Sage-femme) | Terme + stade de grossesse + dernière consultation | Éléments de suivi (poids, TA, mouvements) | Collapsed |
| DR-003 | Acte sur demande (Échographiste) | Ordonnance — motif + prescripteur | Comptes rendus précédents | **NON collapsed** — exception PP-008 |
| DR-004 | Coordination (Infirmière coordinatrice) | Statut des intervenants actifs + dernière note | Transmissions entre praticiens | Collapsed |

> Voir [DISPLAY-RULEBOOK.md](../DISPLAY-RULEBOOK.md) pour la spécification complète et les lifecycles.

---

## 5. Cognitive Transition

```
PERDU
(le patient est devant moi — je n'ai pas de contexte)
    ↓
Reprise de contexte patient
(WS-002 — réponse à Q-002)
    ↓
ORIENTÉ
(je sais pourquoi ce patient est là,
où nous en étions, ce que nous avions prévu)
```

WS-002 ne décide rien. Il réduit le coût de cette transition.

---

## 6. User Outcome

À la fermeture de WS-002, le praticien doit pouvoir dire :

> "Je sais pourquoi ce patient est là, où nous en étions, et ce que je dois aborder."

---

## 7. Information Architecture

Quatre blocs ordonnés par Q-002. Chaque bloc répond à une sous-question.

### Bloc 1 — Présence

**Sous-question :** Qui est ce patient et pourquoi est-il là aujourd'hui ?

Contenu :
- Identité — nom, âge, type de visite (nouveau / suivi / urgence)
- Motif de la consultation du jour (si connu)
- Indicateur de familiarité (première consultation ? retour après longue absence ?)

Comportement : toujours visible. Jamais collapsed.

---

### Bloc 2 — Continuité

**Sous-question :** Où en étions-nous ?

Contenu : Display Rule-dependent (DR-001 à DR-004)

| Profil | Contenu du Bloc 2 |
|---|---|
| DR-001 (longitudinal) | Résumé de la dernière séance |
| DR-002 (grossesse) | Terme + stade + dernière consultation |
| DR-003 (acte) | Ordonnance — motif + prescripteur |
| DR-004 (coordination) | Statut intervenants + dernière note |

Comportement : toujours visible. Jamais collapsed.

---

### Bloc 3 — Intention

**Sous-question :** Qu'avions-nous prévu ?

Contenu : Plans ou intentions notés en fin de dernière séance (si documentés)

Comportement : visible uniquement si des intentions sont documentées (OBS-P-005 : certains praticiens ne documentent pas — le bloc est absent, pas vide).

> **Note de risque (HYP-P-002) :** ce bloc présuppose que les intentions sont écrites dans le dossier. Pour les praticiens qui ne documentent pas (ACT-F001-019), ce bloc est systématiquement absent. Il ne doit pas signifier "rien de prévu" mais "aucune trace écrite."

---

### Bloc 4 — Historique

**Sous-question :** Y a-t-il quelque chose de l'historique qui compte aujourd'hui ?

Contenu : Display Rule-dependent

| Profil | Comportement Historique |
|---|---|
| DR-001 (longitudinal) | Collapsed par défaut — une interaction révèle les séances précédentes |
| DR-002 (grossesse) | Collapsed par défaut — éléments de suivi longitudinaux disponibles |
| DR-003 (acte) | **Déployé par défaut** — comptes rendus et images précédents sont le contexte primaire |
| DR-004 (coordination) | Collapsed par défaut |

---

## 8. Scope Limitations

> Section obligatoire dans tout Blueprint.
> La transparence sur les limites évite les généralisations abusives.

**Ce Blueprint est valide pour :**
- Praticiens ambulatoires et communautaires (libéral, ville)
- Relations de soin longitudinales (suivi régulier)
- Praticien lisant ses propres notes

**Ce Blueprint n'a PAS été validé pour :**
- Médecine intra-hospitalière (aucun profil corpus)
- Médecine d'urgence (aucun profil corpus)
- Première consultation — nouveau patient (aucun état initial défini)
- Reprise de contexte inter-praticien (handoff, remplacement, référé)
- Soins partagés multi-spécialistes simultanés
- Praticiens lisant les notes d'un collègue

---

## 9. Explicit Non-Goals

WS-002 n'est pas :
- un visualisateur de dossier patient complet ;
- un remplaçant du dossier clinique ;
- un outil d'aide à la décision ;
- un résumé IA du patient.

Son objectif est uniquement la reprise de contexte pré-consultation.

---

## 10. Success Metrics

| Métrique | Nature | Baseline requis |
|---|---|---|
| Temps pour atteindre l'état ORIENTÉ | Comportemental | Oui |
| Nombre d'interactions avec le dossier avant de se sentir prêt | Comportemental | Oui |
| **Context Confidence** — "Avant d'entrer dans cette consultation, à quel point avez-vous l'impression de comprendre où en est ce patient ?" (échelle 1–5) | Qualitatif — déclaratif | Test utilisateur pré-consultation |
| Taux d'expansion du Bloc 4 (falsification PP-008) | Comportemental — prototype observable | Non |
| Praticiens ayant ouvert le dossier complet après WS-002 | Indicateur de défaillance | Non |

> **Context Confidence** est la métrique principale de WS-002. C'est exactement ce que ce Workspace cherche à améliorer. Baseline à mesurer avec les outils actuels avant tout test du prototype.

---

## 11. Open Questions

| # | Question | Impact | Ancre | Status |
|---|---|---|---|---|
| OQ-P-001 | Comment MedLink définit-il "dernière interaction clinique" quand plusieurs praticiens interviennent sur le même patient ? | Architecture — Read Model | HYP-P-002 | Open |
| OQ-P-002 | Quelle est la durée réelle de préparation avec les outils actuels ? | Baseline — HYP-P-004 | ACT-F003-001 (synthétique) | Experiment Planned |
| OQ-P-003 | Les praticiens souhaitent-ils que les intentions inachevées soient surfacées automatiquement, ou préfèrent-ils les chercher eux-mêmes ? | PP-007 future — comportement du Bloc 3 | OBS-P-003, OBS-P-005 | Open |
| OQ-P-004 | Comment WS-002 se comporte-t-il lors d'une première consultation (aucune interaction précédente) ? | Edge case non couvert | Scope limitation | Open |
| OQ-P-005 | La Display Rule change-t-elle au sein du même praticien selon le type de patient (nouveau vs suivi long) ? | Segmentation DR | PAT-P-002 | Open |

> Statuts possibles : Open · Experiment Planned · Validated · Rejected

---

## 12. Evidence Quality Summary

| Élément | Niveau | Ancre corpus |
|---|---|---|
| OBS-P-001 | ✓ Direct | ACT-F004-004, F004-005, F008-008, F006-008 |
| OBS-P-002 | ✓ Direct | ACT-F005-005, F005-006 |
| OBS-P-003 | ✓ Direct | ACT-F004-007, F002-015 |
| OBS-P-004 | ✓ Direct | ACT-F004-003 |
| OBS-P-005 | ✓ Direct | ACT-F001-015, F001-019 |
| PAT-P-001 | ≈ Pattern | 4/9 profils — longitudinal uniquement |
| PAT-P-002 | ≈ Pattern | ACT-F004-003 + inference convergente |
| PAT-P-003 | ≈ Pattern | Profils longitudinaux — non testé acte/demande |
| PP-005 | 💡 Décision produit | Dérivée de PAT-P-001 + OBS-P-002 |
| PP-006 | 💡 Décision produit | Dérivée de PAT-P-002, PAT-P-003 |
| PP-008 | 💡 Décision produit | Dérivée de PAT-P-003, exceptions via Display Rules |
| DR-001 à DR-004 | 💡 Adaptation produit | Dérivées de OBS-P-001, OBS-P-002 par profil |
| HYP-P-001 à P-004 | ? Hypothèse | À valider — non testées |

---

## 13. Évolution

| Version | Date | Nature |
|---|---|---|
| 0.1 | 2026-08-04 | Blueprint initial post-revue critique — Sprint 1.1 consolidation |
| 0.1 | 2026-08-04 | Prototype v0.1 créé — 4 profils Display Rule |
| 0.2 | 2026-08-04 | Suppression Invariants · PR→PP · Context Confidence · OQ Status |
