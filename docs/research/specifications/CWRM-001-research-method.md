# Clinical Work Research Method v2.1

**Statut :** Accepted
**Date :** 2026-07-30 (v2.0) / 2026-08-05 (v2.1)
**Origine :** Pipeline v1.0 + Red Team méthodologique + Révision du critère d'évaluation

---

## Ce que nous savons

Nous n'observons pas le travail clinique.

Nous analysons des récits de travail clinique issus d'entretiens.

Cette méthode vise à construire un modèle utile pour la conception produit, et non une description exhaustive de la cognition clinique.

Cette limite est assumée.

---

## Le pipeline

```
Interviews (verbatims)
        │
        ▼
ACT — Reported Clinical Actions
        │
        ▼
SEQ — Analytical View (vue comparative, pas nouvelle couche de connaissance)
        │
        ├──────────────────────────────┐
        ▼                              ▼
OBS issues de séquences       OBS issues d'états,
                               comparaisons inter-entretiens,
                               absences documentées
        │
        └──────────────┬───────────────┘
                       ▼
                      RQ — Research Questions
                       │
                       ▼
                      INV — Invariants de conception
                       │
                       ▼
                      UX Principles
                       │
                       ▼
                      Features
                       │
                       ▼
                      Architecture
```

---

## Les artefacts

### 1. Sources — Interviews (verbatims)

Les interviews brutes.

Aucune interprétation. Le verbatim est la seule source de vérité empirique.

---

### 2. ACT — Reported Clinical Actions

Une action rapportée par le praticien lors d'un entretien.

**Format d'une entrée ACT :**

```
ACT-[FXXX]-[NNN]
Action   : [Verbe + complément — formulé tel que le praticien le rapporte]
Source   : [Verbatim direct / Synthèse rapportée]
Verbatim : "[Citation exacte ou marqueur SYNTHÈSE RAPPORTÉE]"
Contexte : [Phase temporelle : avant / pendant / après consultation]
```

**Exemples valides :**
- Consulter la note de la dernière séance
- Vérifier les e-mails avant de commencer
- Préparer le matériel en salle

**Exemples invalides :**
- "Le praticien gère sa charge cognitive" ← interprétation
- "Le praticien compense un manque d'information" ← inférence
- "Le praticien optimise son flux de travail" ← abstraction

**Règle de granularité :** Une action = un verbe principal. Si deux verbes sont distincts et séparables, deux entrées ACT.

---

### 3. SEQ — Analytical View

Une séquence n'est pas une nouvelle couche de connaissance.

C'est une représentation permettant de comparer l'organisation du travail entre professions et entre profils.

SEQ est produite par agrégation d'ACT. Elle ne produit pas d'information nouvelle — elle rend l'information comparable.

---

### 4. OBS — Observations

Une observation est une régularité empirique.

Elle peut provenir de :

- (a) plusieurs ACT issus du même entretien
- (b) une ou plusieurs SEQ
- (c) une comparaison entre entretiens
- (d) un état décrit dans les verbatims (environnement, artefact, configuration)
- (e) une absence documentée (ce qui ne se passe pas)

**Règle :** Une OBS ne contient aucun mot interprétatif. Elle décrit ce qui est rapporté, pas ce que ça signifie.

---

### 5. RQ — Research Questions

Une question née d'une ou plusieurs observations.

Une RQ est ouverte : elle ne contient pas sa réponse.

---

### 6. INV — Invariants de conception

Une hypothèse suffisamment corroborée pour gouverner les décisions de conception.

Un INV n'est jamais produit directement depuis une interview ou une observation unique.

---

### 7. UX Principles → Features → Architecture

Conséquences de conception dérivées des invariants.

---

## Les règles

**Règle 1 — Traçabilité totale.**
Chaque élément doit pouvoir remonter jusqu'aux verbatims d'origine.

**Règle 2 — Ne jamais inventer un invariant.**
Un invariant ne peut émerger que d'un corpus d'observations corroborées.

**Règle 3 — Une interview n'est jamais une preuve.**
Elle est une source. La preuve est dans la convergence.

**Règle 4 — Les interviews racontent le travail. Elles ne montrent pas le travail.**
Notre corpus capture : ce que le praticien raconte, ce qu'il se rappelle, ce qu'il accepte de raconter. Il ne capture pas : l'intuition, la reconnaissance de patterns, les automatismes, le savoir tacite incorporé. Cette limite est structurelle et assumée.

**Règle 5 — Toute observation doit pouvoir être réfutée.**
Une OBS sans condition de réfutation n'est pas une observation — c'est une croyance.

**Règle 6 — Le pipeline est un outil de conception, pas une théorie du travail clinique.**
Le critère d'évaluation de cette méthode n'est pas "décrit-elle fidèlement la cognition clinique ?" mais "produit-elle de meilleures décisions de conception que les alternatives (personas, user journeys, JTBD) ?"

---

## Exigences normatives — OBS-REQ

Ces règles ne créent aucune nouvelle définition. Elles donnent un identifiant traçable, au même
format que les IP-REQ de CWRM-020, à des règles déjà Accepted plus haut dans ce document (§4 —
OBS, Règle 5, Gate 2).

**OBS-REQ-001**
**Titre :** Régularité empirique exclusive
**Énoncé :** Une Observation décrit exclusivement une régularité empirique observée dans le corpus
(actions, séquences, états, comparaisons, absences — §4, sources a–e).
**Vérification :** Relecture de l'OBS contre les sources ACT/SEQ citées ; conformité au 1ᵉʳ critère
de Gate 2 ("L'observation est descriptive").
**Rationale :** Formalise §4 ("Une observation est une régularité empirique") sans en restreindre
les cinq sources déjà admises — notamment (d) état et (e) absence documentée, qui ne sont pas des
régularités *comportementales* au sens strict.
**Dépendances :** §4, Gate 2

**OBS-REQ-002**
**Titre :** Absence d'hypothèse explicative
**Énoncé :** Une Observation ne contient aucune hypothèse explicative ni aucun mot interprétatif
(*donc, parce que, cela montre, toujours, jamais*).
**Vérification :** Contrôle contre la liste des mots interdits (Gate 2, 4ᵉ critère).
**Rationale :** Formalise §4 ("Une OBS ne contient aucun mot interprétatif. Elle décrit ce qui est
rapporté, pas ce que ça signifie.").
**Dépendances :** §4, Gate 2, OBS-REQ-001

**OBS-REQ-003**
**Titre :** Réfutabilité par un nouvel ACT
**Énoncé :** Une Observation peut être invalidée par un nouvel ACT — sa condition de réfutation doit
être identifiable dans le corpus, ou son absence explicitement documentée.
**Vérification :** Un contre-exemple existe dans le corpus, ou son absence est documentée (Gate 2,
2ᵉ critère).
**Rationale :** Opérationnalise Règle 5 ("Toute observation doit pouvoir être réfutée... sinon c'est
une croyance") en ancrant le mécanisme de réfutation dans la couche ACT, seule source de vérité
empirique du pipeline.
**Dépendances :** Règle 5, Gate 2

---

## Les Quality Gates

Un élément ne peut passer au niveau supérieur que s'il satisfait les critères de sa gate.

### Gate 1 — ACT → OBS

- [ ] Les actions sont formulées sans interprétation
- [ ] La granularité est cohérente (un verbe = une action)
- [ ] Le verbatim ou le marqueur SYNTHÈSE RAPPORTÉE est cité
- [ ] La phase temporelle est identifiée

### Gate 2 — OBS → RQ

- [ ] L'observation est descriptive (pas explicative, pas interprétative)
- [ ] Un contre-exemple existe dans le corpus, ou son absence est documentée
- [ ] L'observation repose sur au moins une source identifiée (ACT, état, comparaison)
- [ ] L'observation ne contient aucun mot interdit : donc, parce que, cela montre, toujours, jamais

### Gate 3 — RQ → INV

- [ ] La question a reçu une réponse empirique dans le corpus
- [ ] L'invariant est corroboré dans au moins deux professions distinctes
- [ ] Les cas où l'invariant ne s'applique pas sont documentés
- [ ] L'invariant est formulé comme une proposition testable et falsifiable
- [ ] Une condition de réfutation explicite est définie

---

## Limites explicites du corpus actuel

Ce pipeline est validé pour :

- Praticiens libéraux ou en cabinet
- Consultations relativement séquentielles
- Acteur principal unique par séquence
- Relation patient avec documentation accessible

Ce pipeline n'a pas été validé pour :

- Bloc opératoire (savoir incorporé non verbalisable)
- Urgences (interrupt-driven, parallèle, pas de séquence stable)
- SAMU (environnement chaotique, absence de dossier)
- Réanimation (continu, multi-dimensionnel, >24h)

Ces contextes constituent une Phase 2 de la recherche.

---

## Historique

| Date | Version | Nature |
|---|---|---|
| 2026-07-30 | v1.0 | Pipeline initial |
| 2026-07-30 | v2.0 | Red Team + révision : ACT → "Reported Actions", SEQ → vue analytique, OBS sources élargies, Quality Gates ajoutées, limites explicites |
| 2026-08-05 | v2.1 | Ajout d'OBS-REQ-001 à 003 — formalisation en règles identifiées de §4 et Règle 5, sans nouvelle définition ni nouvelle couche (conforme à CWRM-AF-001). Origine : session de définition de la grille WS-005 (CWRM-020-APX-WS005). "Pattern" (PAT) n'est **pas** introduit ici — proposé mais volontairement non intégré au pipeline core ; voir CWRM-020-APX-WS005 §6bis et CWRM-AF-001. |
