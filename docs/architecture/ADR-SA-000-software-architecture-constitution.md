# ADR-SA-000 — Constitution de l'Architecture Logicielle

**Type :** Software Architecture Decision — Fondation
**Statut :** Released — Software Foundation v1.0
**Date :** 2026-07-28
**Gelé le :** 2026-07-29
**Autorité :** Ce document gouverne toutes les ADR-SA qui le suivent. Toute ADR-SA qui contredit un principe de ce document doit explicitement le superséder avec justification.

---

## Objet

Le domaine de MedLink est gelé (Architecture Freeze v1.0 — 2026-07-28).

Ce document établit les principes d'architecture logicielle qui s'appliquent à toute décision d'implémentation. Ces principes sont indépendants du stack technique. Ils protègent le modèle de domaine contre la contamination par l'infrastructure.

Toute ADR-SA qui propose une exception à ces principes doit démontrer que l'exception ne compromet pas l'invariant protégé.

---

## Fondation

Ces principes dérivent des décisions de domaine déjà figées :

| Document | Principe fondé |
|---|---|
| CLAUDE.md — Development Principles | Indépendance du Domain · CQRS · Event-driven |
| ADR-0003 — Hexagonal Architecture | Ports & Adapters · le Domain ne dépend pas de l'infrastructure |
| ADR-0004 — CQRS | Séparation stricte lecture / écriture |
| ADR-0005 — Business Events | Immuabilité des événements |
| ADR-SA-013 — Domain Event Publication | Outbox Pattern · publication post-commit |
| DE-001 — Domain Event Taxonomy | Contrats d'événements figés |

---

## Principes

> **Note fondatrice — à lire avant tout principe**
>
> Les principes de ce document protègent des **invariants architecturaux**, non des choix technologiques.
>
> L'implémentation de référence citée dans chaque principe est l'implémentation courante qui satisfait l'invariant. Elle n'est pas la contrainte. Si une implémentation alternative satisfait le même invariant avec des garanties équivalentes, elle est conforme à ce principe.
>
> Lorsqu'une ADR future modifie une implémentation de référence, elle doit démontrer que l'invariant protégé reste satisfait — pas qu'elle utilise la même technologie.

---

### P-01 — Indépendance du Domain

**Le Domain ne dépend d'aucun framework, d'aucune bibliothèque d'infrastructure, d'aucun outil de persistance.**

Les classes du Domain (`Domain/`) n'importent aucune classe Symfony, Doctrine, ou autre. Elles n'étendent aucune classe externe. Elles n'implémentent aucune interface externe sauf celles définies dans `Shared/Domain/`.

*Pourquoi :* un Domain couplé à son infrastructure ne peut pas évoluer indépendamment. Le stack peut changer ; le modèle de domaine doit rester intact.

---

### P-02 — Les Aggregates sont les gardiens des invariants

**Aucun invariant de domaine n'est enforced en dehors de l'Aggregate Root concerné.**

Les Application Services, les Projectors, les handlers de commande ne prennent aucune décision métier. Ils orchestrent. L'Aggregate Root valide, refuse, ou accepte.

*Pourquoi :* disperser la logique métier dans les services conduit à des états incohérents non détectés par les tests unitaires du domaine.

---

### P-03 — Les Application Services orchestrent sans décider

**Un Application Service (Command Handler) : charge l'Aggregate, appelle une méthode métier, persiste, publie les événements. Il ne contient aucune logique conditionnelle métier.**

Si un Application Service contient un `if` qui détermine un comportement de domaine, cette logique appartient à l'Aggregate.

*Pourquoi :* la logique dans les services est invisible aux tests de domaine et ne bénéficie pas des garanties d'invariant de l'Aggregate.

---

### P-04 — Les Repositories ne retournent que des Aggregates

**Un Repository ne retourne jamais un DTO, un tableau, ou une projection. Il ne retourne que l'Aggregate Root complet.**

Les lectures (Query side) n'utilisent pas les Repositories. Elles accèdent directement à la couche de persistance via DBAL ou Projection (ADR-SA-009).

*Pourquoi :* un Repository qui retourne des structures partielles incite à l'utilisation des Aggregates en lecture — ce qui couple les Read Models au modèle de domaine et contamine le CQRS.

---

### P-05 — Les Domain Events sont immuables

**Un Domain Event est un fait passé. Il ne peut pas être modifié après publication.**

Les Domain Events n'ont pas de setters. Leurs champs sont `readonly`. Leur contrat de payload est figé par ADR (DE-001 · ADR-SA-015 · ADR-SA-016). Toute modification de payload nécessite une nouvelle version de l'événement et une ADR.

*Pourquoi :* un événement modifiable n'est plus un fait — il devient un message mutable, ce qui détruit la valeur d'audit et de rejeu.

---

### P-06 — Une transaction = une commande = un Aggregate modifié

**Une Command Handler ne modifie qu'un seul Aggregate Root dans une transaction.**

Si une opération métier requiert la modification de deux Aggregates, elle est décomposée en deux commandes reliées par un événement de domaine.

*Pourquoi :* modifier plusieurs Aggregates dans une transaction couple leurs cycles de vie et viole les frontières transactionnelles — la précondition de cohérence des invariants en DDD.

---

### P-07 — Les événements ne sont publiés qu'après un commit réussi, avec garantie de fiabilité

**Invariant protégé : un Domain Event ne peut jamais être reçu par un consommateur si la transaction qui l'a produit a été annulée. La livraison doit être garantie même en cas de défaillance du processus.**

L'implémentation de référence est l'Outbox Pattern (ADR-SA-013) : les événements sont persistés dans `domain_events` dans la même transaction que l'Aggregate, puis relayés par un processus séparé. Une implémentation alternative est conforme à ce principe si elle satisfait les deux propriétés de l'invariant : absence d'événements fantômes et fiabilité de livraison.

*Pourquoi :* publier avant le commit crée des états fantômes — des consommateurs réagissent à des faits qui seront annulés par un rollback. Ne pas garantir la livraison crée des pertes silencieuses d'événements.

---

### P-08 — Les Integration Events sont dérivés des Domain Events, jamais l'inverse

**Un Integration Event est produit à partir d'un Domain Event. Il transporte uniquement l'information nécessaire au consommateur externe.**

Un Domain Event n'est jamais produit en réaction à un Integration Event entrant. Les Integration Events entrants sont traités par un Anti-Corruption Layer qui produit des Commands.

*Pourquoi :* laisser les Integration Events entrants modifier directement le domaine introduit une dépendance sur le contrat d'un système externe — fragilisant le modèle interne à chaque évolution de ce système.

---

### P-09 — Les Domain Events ne traversent jamais les frontières de plateforme

**Un Domain Event produit dans la Clinical Platform ne peut pas être consommé directement par une autre plateforme (Learning, Trust, etc.).**

La communication inter-plateforme passe exclusivement par des Integration Events publiés sur `integration.bus` (ADR-0014 · ADR-SA-012).

*Pourquoi :* un Domain Event transporte le langage interne d'un Bounded Context. L'exposer à l'extérieur couple les plateformes sur le modèle interne — rendant toute évolution de l'une une rupture pour l'autre.

---

### P-10 — Les Read Models ne sont jamais des sources de vérité

**Un Read Model (Projection, Workspace, Dashboard) est reconstituable depuis les Domain Events.**

Aucune décision métier ne s'appuie sur un Read Model. Les Aggregates ne lisent pas les Projections. Si un Read Model est corrompu ou supprimé, le rejeu des événements le reconstitue intégralement.

*Pourquoi :* une Projection qui devient source de vérité est un Aggregate dégradé — sans les garanties d'invariant d'un Aggregate, mais avec ses responsabilités.

---

## Hiérarchie normative

```
CLAUDE.md (Constitution produit)
        │
        ▼
ADR-SA-000 (Constitution logicielle — ce document)
        │
        ▼
ADR-SA-xxx (Décisions d'implémentation)
        │
        ▼
DE-001 / DA-010 / SD-005 (Référence domaine)
```

Une ADR-SA-xxx ne peut pas contredire ADR-SA-000 sans le superséder explicitement.

Une ADR-SA-000 ne peut pas contredire CLAUDE.md.

---

## Violation et exception

Une violation d'un principe est acceptable uniquement si :

1. La violation est documentée dans une ADR dédiée qui cite le principe concerné.
2. La justification démontre que l'invariant protégé par le principe reste garanti par un mécanisme alternatif.
3. La violation est limitée dans son périmètre (un module, un contexte, une durée).

Une violation non documentée est une dette d'architecture non consentie.

---

## Bloc de conformité — Template pour les ADR-SA

Toute ADR-SA doit inclure, avant sa section "Décision", un bloc de conformité explicite :

```
## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain    | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| P-02 — Aggregates gardiens       | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| P-03 — Application Services      | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| P-04 — Repositories              | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| P-05 — Events immuables          | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| P-06 — Une transaction           | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| P-07 — Publication post-commit   | ✅ Conforme / ⚠️ Exception documentée §X | ... |
| P-08 — Integration Events        | ✅ Conforme / ⚠️ Sans objet             | ... |
| P-09 — Frontières de plateforme  | ✅ Conforme / ⚠️ Sans objet             | ... |
| P-10 — Read Models               | ✅ Conforme / ⚠️ Sans objet             | ... |
```

Les principes sans objet pour une ADR donnée sont marqués "Sans objet" — pas "Conforme". La distinction évite les validations formelles vides de sens.

---

## Références

| Document | Relation |
|---|---|
| CLAUDE.md | Constitution produit — autorité supérieure |
| ADR-0003 | Hexagonal Architecture — fondement de P-01 |
| ADR-0004 | CQRS — fondement de P-04 |
| ADR-0005 | Business Events — fondement de P-05 |
| ADR-0014 | Domain Events Platform Boundary — fondement de P-09 |
| ADR-SA-009 | Persistence Technology Policy — lecture directe DBAL |
| ADR-SA-013 | Domain Event Publication Outbox — fondement de P-07 |
| DE-001 | Domain Event Taxonomy — contrats figés |
