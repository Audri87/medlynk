# CWRM-AF-001 — Architectural Freeze v1.0

---

| Field | Value |
|---|---|
| Document ID | CWRM-AF-001 |
| Title | Architectural Freeze v1.0 |
| Date | 2026-08-04 |
| Status | Accepted — Binding |
| Nature | Governance decision — milestone declaration |

---

## Decision

L'architecture conceptuelle du CWRM est considérée comme suffisamment mature pour entrer en phase de validation expérimentale.

À partir du 2026-08-04 :

- Aucun nouveau concept fondamental n'est ajouté.
- Aucune nouvelle couche architecturale n'est créée.
- Toute évolution majeure nécessite une justification empirique ou une contradiction scientifique démontrée.

---

## Phase précédente — Ce qui a été construit

| Document | Nature | Statut |
|---|---|---|
| CWRM-000 | Scope Guard & Constitution | Draft v1.2 |
| CWRM-000A | Conceptual Model | Accepted |
| CWRM-SCI-000 | Scientific Constitution | Accepted |
| CWRM-FND-001 | Epistemological Foundations | Draft |
| CWRM-STD-001 | Specification Standard | Draft |
| CWRM-STD-002 | Identity & Identifier Standard | Draft |
| CWRM-020 | Interview Protocol | Draft v1.0-RC |
| CWRM-001 | Research Method v2.0 | Accepted |
| CWRM-002 | Layer Architecture | Accepted |
| DR-001, DR-002 | Decision Records | Accepted |

---

## Ce qui est gelé

### 1. Le programme scientifique

```
Theory
    ↓
Language
    ↓
Method
    ↓
Validation
```

Ces quatre niveaux sont stables. Aucune nouvelle couche.

### 2. Les Claims

Les hypothèses de la méthode — H1, H2, H3 (CWRM-FND-001 §9) — constituent le noyau dur du programme.

Tout nouveau concept devra démontrer qu'il soutient directement un Claim existant. Sans ce lien, il est rejeté.

### 3. Le méta-modèle

Les concepts fondamentaux de CWRM-000A sont stables :

- Identity
- Representation
- Evidence
- Provenance
- Relationship
- Scientific Object
- Version
- Metadata

Ils ne pourront évoluer qu'après validation expérimentale démontrant une insuffisance.

### 4. La chaîne méthodologique

```
Interview
    ↓
ACT
    ↓
Observation
    ↓
Invariant
    ↓
Requirement
    ↓
Design Decision
```

Cette chaîne est la colonne vertébrale du CWRM. Toute proposition de modification devra démontrer un gain mesurable sur au moins une des métriques de H1.

---

## Ce qui change

Nous ne sommes plus dans une phase de conception.

Nous sommes dans une phase de recherche expérimentale.

| Avant | Après |
|---|---|
| "Est-ce une bonne idée ?" | "Existe-t-il une preuve que cette modification améliore la théorie ou la méthode ?" |
| Piloté par des idées | Piloté par des résultats expérimentaux |
| Critère : cohérence intellectuelle | Critère : validation empirique |

---

## Critères d'acceptation pour toute évolution future

Toute proposition d'évolution devra répondre aux cinq questions suivantes. Sans réponse à toutes les cinq, la proposition reste hors du corpus.

| # | Question |
|---|---|
| 1 | Quel problème empirique résout-elle ? |
| 2 | Quel Claim renforce-t-elle ? |
| 3 | Quelle hypothèse est concernée ? |
| 4 | Comment sera-t-elle validée ? |
| 5 | Quelle métrique permettra de conclure ? |

---

## Roadmap scientifique

### Phase A — Publications

| Livrable | Contenu |
|---|---|
| P0 — Position Paper | Positionnement du CWRM dans la littérature existante |
| P1 — Foundations | CWRM-FND-001 soumis à une revue peer-reviewed |
| P2 — Method | Description complète de la méthode, protocoles, coding manual |
| P3 — Validation | Résultats expérimentaux H1, H2, H3 |

### Phase B — Validation expérimentale

- Validation du Coding Manual (CWRM-030) : accord inter-codeurs (Cohen's κ)
- Comparaison CWRM vs analyse thématique (protocole H1)
- Études de réplication avec équipes indépendantes
- Falsification ou confirmation de H2, H3

### Phase C — Industrialisation

- Intégration dans MedLink
- Études terrain avec des praticiens
- Itérations fondées uniquement sur des preuves

---

## Référence à CWRM-SCI-000

Les dix règles de la Constitution Scientifique (CWRM-SCI-000) s'appliquent à toute activité du programme à partir de cette date.

En particulier : Rule 2, Rule 8, Rule 9, Rule 10.

---

*Adopted: 2026-08-04*
