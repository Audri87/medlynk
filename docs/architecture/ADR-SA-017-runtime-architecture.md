# ADR-SA-017 — Runtime Architecture & Application Services

**Type :** Software Architecture Decision — Fondation
**Statut :** Released — Software Foundation v1.0
**Date :** 2026-07-28
**Gelé le :** 2026-07-29
**Autorité :** Ce document gouverne toutes les ADR-SA qui décrivent l'implémentation d'un Use Case. Il est subordonné à ADR-SA-000.
**Indépendance :** Ce document est indépendant de tout framework. Symfony sera traité dans une ADR ultérieure.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | Le Domain n'a aucune dépendance — c'est l'invariant central de cette ADR |
| P-02 — Aggregates gardiens | ✅ Conforme | Les Application Services ne décident pas — §5 |
| P-03 — Application Services orchestrent | ✅ Conforme | L'ADR définit précisément ce rôle — §5 |
| P-04 — Repositories retournent des Aggregates | ✅ Conforme | Énoncé explicitement — §4, §12 |
| P-05 — Events immuables | ✅ Conforme | Les Domain Events sont produits par le Domain, immuables — §8 |
| P-06 — Une transaction | ✅ Conforme | Frontières définies avec les nuances nécessaires — §7 |
| P-07 — Publication post-commit | ✅ Conforme | Mécanisme de collecte et publication différée — §8 |
| P-08 — Integration Events | ⚪ Sans objet | Traité dans ADR-SA-012 |
| P-09 — Frontières de plateforme | ⚪ Sans objet | Traité dans ADR-0014 |
| P-10 — Read Models | ⚪ Sans objet | Traité dans ADR-SA-011 |

---

## 1. Contexte

### Le problème que cette ADR résout

Le Domain Design (Architecture Freeze v1.0) répond à la question : **quoi modéliser ?**

Il définit les Aggregates, les Bounded Contexts, les Domain Events, les invariants métier. Il ne répond pas à la question : **comment le modèle est-il exécuté ?**

Sans réponse explicite à cette question, chaque développeur construira le runtime selon sa propre intuition. Les décisions critiques seront prises implicitement :

- Qui ouvre la transaction ?
- Qui collecte les Domain Events ?
- Qui décide du moment de publication ?
- Quelle couche peut appeler quelle autre ?
- Où réside la logique d'orchestration ?

Les dérives les plus communes en l'absence de réponse explicite :
- la logique métier migre vers les Application Services ;
- les Controllers accèdent directement aux Repositories ;
- les Domain Events sont publiés avant le commit ;
- les Aggregates deviennent anémiques, les Services omnipotents.

Cette ADR ferme ces questions. Elle établit le modèle d'exécution de MedLink comme référence normative pour toutes les ADR-SA suivantes.

### Ce que cette ADR ne fait pas

Elle ne modifie aucune décision métier. Elle ne décrit pas Symfony, Messenger, Doctrine, ou aucun autre framework. Elle décrit le **modèle d'exécution** — indépendant de toute technologie — dans lequel ces frameworks s'inscriront.

---

## 2. Principes retenus

### Séparation stricte des responsabilités

Chaque couche a une responsabilité unique et ne peut pas empiéter sur celle d'une autre.

- Le **Domain** exprime les invariants métier et produit les Domain Events.
- L'**Application** orchestre l'exécution d'un Use Case sans prendre aucune décision métier.
- l'**Infrastructure** implémente les interfaces définies par le Domain et l'Application.
- l'**Interface** reçoit les entrées externes et retourne les résultats.

### Orchestration sans décision

Un Use Case est orchestré par un Application Service. L'Application Service sait **quoi faire** (charger, appeler, persister, collecter). Il ne sait pas **comment décider** (c'est le rôle du Domain).

La frontière est nette : si une règle détermine le comportement, elle appartient au Domain. Si une séquence d'opérations connecte les pièces, elle appartient à l'Application.

### Isolation totale du Domain

Le Domain ne sait pas qu'il est exécuté dans un contexte HTTP, un bus de commandes, ou un test unitaire. Il ne voit jamais un Repository concret, une connexion à une base de données, ou un objet de framework.

Cette isolation est la condition de sa testabilité et de sa pérennité.

### Atomicité transactionnelle locale

Une transaction possède un **Aggregate principal** responsable de l'invariant métier. Elle peut consulter d'autres Aggregates en lecture, mais ne modifie qu'un seul Aggregate.

La persistance de l'Aggregate modifié et la persistance des Domain Events (mécanisme d'Outbox — ADR-SA-013) sont atomiques dans la même transaction. La publication des événements est différée après le commit.

### Publication différée

Les Domain Events ne sont jamais publiés directement dans la transaction. Ils sont collectés, persistés dans la même transaction que l'Aggregate, puis relayés par un mécanisme séparé après le commit (P-07).

---

## 3. Runtime global

### Diagramme de flux

```
┌─────────────────────────────────────────────────────────────────┐
│  Interface Layer (HTTP / CLI / Test)                            │
│  Reçoit l'entrée → valide le format → construit la Command      │
└───────────────────────────┬─────────────────────────────────────┘
                            │ Command (DTO immutable)
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│  Application Layer — Application Service (Command Handler)      │
│                                                                 │
│  1. Ouvre la transaction                                        │
│  2. Charge l'Aggregate via Repository                           │
│  3. Invoque la méthode domaine sur l'Aggregate                  │
│  4. Persiste l'Aggregate                                        │
│  5. Collecte les Domain Events depuis l'Aggregate               │
│  6. Persiste les Domain Events (Outbox — même transaction)      │
│  7. Commit                                                      │
│  8. Retourne un résultat si nécessaire                          │
└──────┬──────────────────────┬────────────────────────────────────┘
       │                      │
       ▼                      ▼
┌─────────────┐    ┌──────────────────────┐
│  Domain     │    │  Infrastructure      │
│             │    │                      │
│  Aggregate  │    │  Repository (impl)   │
│  ├ invariants│   │  Outbox (impl)       │
│  └ Domain   │    │  Transaction (impl)  │
│    Events   │    └──────────────────────┘
└─────────────┘
                            │
                     (post-commit)
                            │
                            ▼
┌───────────────────────────────────────────────────────────��─────┐
│  Mécanisme de relais asynchrone                                 │
│  Lit les Domain Events persistés → Dispatche vers le bus        │
└───────────────────────┬─────────────────────────────────────────┘
                        │
          ┌─────────────┴──────────────┐
          ▼                            ▼
   Projectors                Integration Event
   (Read Models)              Publishers
```

### Diagramme de séquence — cycle nominal

```
Interface        Application Service    Repository(i)    Aggregate      Outbox(i)
    │                    │                   │               │               │
    │── Command ────────►│                   │               │               │
    │                    │── begin tx ──────────────────────────────────────►│
    │                    │── load(id) ───────►│               │               │
    │                    │◄──────────────────│ Aggregate      │               │
    │                    │── method(args) ───────────────────►│               │
    │                    │                   │         ┌──────┴──────┐        │
    │                    │                   │         │ enforce     │        │
    │                    │                   │         │ invariants  │        │
    │                    │                   │         │ produce     │        │
    │                    │                   │         │ DomainEvents│        │
    │                    │                   │         └──────┬──────┘        │
    │                    │◄── [events] ──────────────────────│               │
    │                    │── save(aggregate)─►│               │               │
    │                    │── store(events) ──────────────────────────────────►│
    │                    │── commit ────────────────────────────────────────►│
    │◄── result ─────────│                   │               │               │
    │                    │                   │               │               │
                                         (post-commit)
                                              │
                                    [relay mechanism]
                                              │
                                    Domain Events → bus
```

*(i) = interface — jamais une classe concrète dans l'Application Layer*

---

## 4. Responsabilités des couches

### Interface Layer

**Rôle :** point d'entrée du monde extérieur vers l'Application.

**Responsabilités :**
- Recevoir et désérialiser les entrées (HTTP, CLI, message de bus externe)
- Valider le **format** de l'entrée (présence des champs, types) — jamais les règles métier
- Construire la Command ou la Query correspondante
- Dispatcher vers l'Application Service approprié
- Formater et retourner le résultat

**Dépendances autorisées :**
- Application Layer (interfaces des Application Services, objets Command/Query)

**Dépendances interdites :**
- Domain directement (Aggregates, Value Objects, Domain Events)
- Infrastructure directement (Repositories concrets, connexions)
- Autre Bounded Context directement

---

### Application Layer

**Rôle :** orchestrer l'exécution d'un Use Case sans contenir aucune règle métier.

**Responsabilités :**
- Recevoir une Command ou une Query
- Ouvrir et gérer la frontière transactionnelle
- Charger les Aggregates via les interfaces de Repository
- Invoquer la méthode de domaine appropriée sur l'Aggregate
- Collecter les Domain Events produits par l'Aggregate
- Persister l'Aggregate et les Domain Events dans la même transaction
- Retourner un résultat (identifiant créé, void, ou projection minimale) — jamais un Aggregate

**Dépendances autorisées :**
- Domain Layer (interfaces des Repositories, types des Aggregates et Value Objects, types des Domain Events)
- Interfaces d'infrastructure définies dans l'Application Layer elle-même (ports)

**Dépendances interdites :**
- Implémentations concrètes d'Infrastructure (seulement via interfaces)
- Autre Bounded Context directement (uniquement via Command dispatching ou Event Bus)
- Interface Layer (aucune dépendance inverse)
- Toute logique conditionnelle qui détermine un comportement métier

---

### Domain Layer

**Rôle :** exprimer les invariants métier et produire les Domain Events.

**Responsabilités :**
- Enforcer tous les invariants de domaine via les Aggregate Roots
- Produire les Domain Events qui certifient les faits métier
- Définir les interfaces des Repositories (contrats, jamais implémentations)
- Définir les Value Objects, les Entités, les Exceptions de domaine

**Dépendances autorisées :**
- `Shared/Domain/` uniquement (Value Objects partagés, interfaces communes)
- Aucune autre dépendance

**Dépendances interdites :**
- Application Layer
- Infrastructure Layer
- Tout framework ou bibliothèque externe
- Tout autre Bounded Context directement

Le Domain ignore comment il est exécuté. Il ignore qui l'appelle, comment il est persisté, comment ses événements sont transportés.

---

### Infrastructure Layer

**Rôle :** implémenter les interfaces définies par le Domain et l'Application.

**Responsabilités :**
- Implémenter les interfaces de Repository (persistance des Aggregates)
- Implémenter les interfaces de stockage des Domain Events (Outbox)
- Implémenter les adaptateurs vers les systèmes externes (bus, Email, APIs tierces)
- Configurer et fournir les connexions aux ressources externes

**Dépendances autorisées :**
- Domain Layer (pour implémenter ses interfaces et manipuler ses types)
- Application Layer (pour implémenter ses ports)
- Bibliothèques externes (ORM, bus de messages, clients HTTP)

**Dépendances interdites :**
- Être importée directement par le Domain ou l'Application (seulement via interfaces)

---

## 5. Application Services

Un Application Service implémente exactement un Use Case.

### Ce qu'un Application Service fait

```
1. Recevoir la Command (DTO immutable)
2. Ouvrir la transaction
3. Charger l'Aggregate principal via l'interface Repository
4. Invoquer une méthode sur l'Aggregate principal
5. Persister l'Aggregate principal
6. Collecter les Domain Events depuis l'Aggregate
7. Persister les Domain Events (même transaction — Outbox)
8. Committer
9. Retourner un résultat (jamais un Aggregate — voir §Résultat)
```

La séquence est strictement ordonnée. L'Application Service ne réordonne pas ces étapes selon un contexte.

### Résultat d'un Application Service

Un Application Service retourne l'une des formes suivantes :

| Forme | Usage |
|---|---|
| `void` | La Command ne produit aucun résultat observable par l'appelant |
| Identifiant créé (`AggregateId`) | Permet à l'appelant de référencer la ressource créée |
| Succès/échec structuré | Lorsque le résultat est observable mais ne justifie pas une Query |
| Read Model (DTO) | Uniquement si une projection immédiate est nécessaire |

**Jamais un Aggregate.** Retourner un Aggregate expose les internals du Domain à la couche Interface et rompt l'encapsulation de l'Aggregate Root. Si l'appelant a besoin de données sur la ressource créée, il dispatche une Query.

### Ce qu'un Application Service ne fait jamais

| Interdit | Raison |
|---|---|
| Contenir une règle métier | Les règles métier appartiennent au Domain (P-02) |
| Prendre une décision conditionnelle de domaine | Un `if` métier dans un Service est un invariant sans garde |
| Accéder directement à un autre Bounded Context | La communication inter-BC passe uniquement par le bus d'événements |
| Publier un Domain Event directement | La publication est différée post-commit (P-07) |
| Modifier deux Aggregates dans la même transaction | Violation de P-06 |
| Appeler un Repository depuis le Domain | Le Domain définit les interfaces, l'Application les utilise |
| Instancier une classe d'Infrastructure | Seulement via injection de dépendance par interface |
| Retourner un Aggregate | Les Aggregates ne traversent pas la frontière Application → Interface |

### Queries — séparation CQRS

Les Queries n'ouvrent pas de transaction métier et ne manipulent jamais d'Aggregate.

Un Query Handler charge directement les données de lecture (via DBAL ou Projection — ADR-SA-009, ADR-SA-011) et retourne un Read Model. Il ne passe pas par un Repository, ne touche pas d'Aggregate, et ne produit pas de Domain Event.

La séparation est absolue : un composant ne peut pas être à la fois Command Handler et Query Handler.

### Aggregates consultatifs et Aggregate principal

Une transaction peut charger plusieurs Aggregates. Un seul d'entre eux est l'**Aggregate principal** — celui qui est modifié et dont l'invariant est enforced. Les autres sont **consultatifs** : chargés en lecture seule pour vérifier une précondition, jamais modifiés.

Un Aggregate consultatif est légitime lorsque :
- La précondition ne peut pas être garantie sans état extérieur à l'Aggregate principal
- La charge est en lecture seule — aucune modification sur l'Aggregate consultatif
- La précondition est documentée explicitement dans l'Application Service

Exemple : créer une `ClinicalContribution` nécessite de vérifier que la `ClinicalActivity` est en état actif. `ClinicalActivity` est l'Aggregate consultatif ; `ClinicalContribution` est l'Aggregate principal.

La présence d'Aggregates consultatifs **ne justifie jamais** de modifier deux Aggregates dans la même transaction. Si une opération métier requiert la modification coordonnée de deux Aggregates, elle se décompose en deux Commands reliées par un Domain Event.

---

## 6. Cycle d'un Use Case — Création d'une Contribution Clinique

### Contexte métier

Un Professionnel de Santé a terminé sa Clinical Activity et valide une Contribution Clinique. L'Application doit créer l'Aggregate `ClinicalContribution`, persister l'événement `ContributionCliniqueCreée`, et notifier les Bounded Contexts consommateurs (BC-2, BC-3).

### Commande

```
ProduireContributionClinique {
    clinicalActivityId : ClinicalActivityId
    patientId          : PatientId
    auteurId           : PractitionerId
    situationClinique  : SituationCliniqueDTO
    [autres dimensions : ...]
}
```

### Déroulement complet

**Étape 1 — Interface Layer**

```
POST /api/v1/patients/{patientId}/contributions
```

Le State Processor valide le format de la requête, construit `ProduireContributionClinique`, dispatche vers `ContributionProducerService`.

**Étape 2 — Application Service : `ContributionProducerService`**

```
ouvre transaction

charge ClinicalActivity(clinicalActivityId)          // lecture seule — précondition
  ├── vérifie : ClinicalActivity est en état actif   // précondition applicative

construit ClinicalContribution(                      // crée l'Aggregate
    clinicalActivityId,
    patientId,
    auteurId,
    [dimensions cliniques...]
)
// L'Aggregate enforce ses invariants à la construction
// L'Aggregate produit ContributionCliniqueCreée

persiste ClinicalContribution                        // via ClinicalContributionRepository

collecte [ContributionCliniqueCreée] depuis ClinicalContribution     // via mécanisme de collecte

persiste [ContributionCliniqueCreée] dans Outbox     // même transaction

commit

retourne ContributionId
```

**Étape 3 — Domain : `ClinicalContribution` Aggregate**

À la construction :
- Vérifie qu'au moins une dimension clinique est présente
- Vérifie que `auteurId` est non null
- Crée et enregistre `ContributionCliniqueCreée` dans sa liste d'événements internes

L'Aggregate ne sait pas qu'une `ClinicalActivity` a été chargée avant lui. Il ne connaît pas le Repository. Il ne publie rien.

**Étape 4 — Post-commit**

Le mécanisme de relais lit `ContributionCliniqueCreée` dans l'Outbox, le dispatche sur le bus d'événements.

BC-2 (`IntégrateurDeContributions`) et BC-3 le reçoivent et réagissent dans leurs propres transactions.

---

## 7. Frontières transactionnelles

### Règle fondamentale

Une transaction possède un **Aggregate principal** responsable de l'invariant métier.

- Elle modifie exactement un seul Aggregate.
- Elle peut consulter d'autres Aggregates en lecture pour vérifier des préconditions.
- Elle co-persiste l'Aggregate modifié et ses Domain Events dans la même opération atomique.

### Ce qui est atomique (dans la même transaction)

| Opération | Atomique ? |
|---|---|
| Chargement d'un Aggregate (lecture) | Oui — dans la transaction courante |
| Modification de l'Aggregate cible | Oui |
| Persistance de l'Aggregate modifié | Oui |
| Persistance des Domain Events (Outbox) | Oui — **même transaction** |

La co-persistance de l'Aggregate et des Domain Events dans la même transaction est l'invariant central de P-07. Si la transaction échoue, ni l'état ni les événements ne sont persistés. Il n'y a pas d'état fantôme possible.

### Ce qui est différé (post-commit)

| Opération | Différée ? |
|---|---|
| Dispatch des Domain Events sur le bus | Oui — après commit |
| Exécution des Projectors | Oui — réactive, après dispatch |
| Publication des Integration Events | Oui — réactive, après dispatch |
| Modification d'autres Aggregates (cross-aggregate) | Oui — via Domain Events, transactions séparées |

### Cas des opérations cross-Aggregate

Si une opération métier requiert la coordination de deux Aggregates, la décomposition est :

```
Command A → modifie Aggregate X → produit EventX
EventX reçu → Command B → modifie Aggregate Y → produit EventY
```

Chaque Command a sa propre transaction. La cohérence est éventuelle, pas immédiate. C'est le modèle correct pour les systèmes distribués et les Bounded Contexts indépendants.

---

## 8. Domain Events

### Où ils sont produits

Dans l'Aggregate Root, en réponse à une méthode de domaine. L'Aggregate est la seule entité autorisée à produire un Domain Event. Aucun Service, Handler, ou Infrastructure ne crée de Domain Event.

### Comment ils sont accumulés

**Invariant :** les Domain Events produits par une méthode de domaine doivent être collectables une fois cette méthode terminée, sans que l'Aggregate ne publie quoi que ce soit.

L'Aggregate accumule les Domain Events produits dans une structure interne transiente. Cette structure ne fait pas partie de l'état persisté — elle est vidée après chaque collecte. L'Aggregate ne publie rien : il accumule et expose.

Le mécanisme concret (liste interne avec accesseur, EventRecorder mixin, Unit of Work, etc.) relève de l'implémentation et sera défini dans l'ADR technique correspondante.

### Quand ils sont collectés

Après l'exécution de la méthode de domaine et avant le commit. L'Application Service — ou un mécanisme transparent qu'il active — déclenche la collecte sur l'Aggregate et transmet les événements à l'Outbox.

### Qui les collecte

L'Application Service — ou un mécanisme d'infrastructure transparent activé par l'Application Service (middleware de transaction). Dans tous les cas, la collecte appartient à la couche Application, pas au Domain.

### Pourquoi leur publication est différée

Un événement publié avant le commit peut être reçu par un consommateur avant que la transaction committée. Si la transaction échoue ensuite, le consommateur a réagi à un fait qui n'existe pas. Il n'y a pas de mécanisme fiable pour rappeler un événement déjà publié.

La publication différée garantit : **un événement ne peut être reçu que si l'état qu'il certifie est durablement persisté.**

---

## 9. Dépendances

### Dépendances autorisées

```
 ┌──────────────┐
 │   Interface  │───────────────────────────────┐
 └──────────────┘                               │
                                                ▼
                                     ┌─────────────────┐
                                     │   Application   │
                                     └────────┬────────┘
                                              │
                                              ▼
                                     ┌─────────────────┐
                                     │     Domain      │
                                     └─────────────────┘
                                              ▲
                                              │
                                     ┌─────────────���───┐
                                     │ Infrastructure  │
                                     └─────────────────┘
```

**Règle de direction :** les dépendances pointent vers le bas ou vers le Domain. Jamais vers le haut.

### Table des dépendances

| Couche | Peut importer | Ne peut pas importer |
|---|---|---|
| Domain | `Shared/Domain` uniquement | Application · Infrastructure · Interface · Frameworks |
| Application | Domain | Infrastructure (concrète) · Interface · Frameworks directs |
| Infrastructure | Domain · Application (interfaces) · Frameworks | Interface |
| Interface | Application | Domain (direct) · Infrastructure |

### Dépendances interdites spécifiques

| Dépendance | Raison |
|---|---|
| Domain → Repository concret | Le Domain définit l'interface, ne connaît pas l'implémentation |
| Domain → Bus d'événements | Le Domain produit des événements, ne les publie pas |
| Application → Infrastructure concrète | Seulement via interface (port) |
| BC-1 Application → BC-2 Application | Communication uniquement via Domain Events / Command Bus |
| Interface → Aggregate directement | Les Aggregates ne sont pas des DTOs |

---

## 10. Alternatives rejetées

### Transaction Script

**Description :** la logique métier réside dans le handler de commande ou le service. Le handler charge les données, calcule l'état suivant, persiste.

**Rejeté parce que :**
- Les règles métier sont dispersées dans les services — invisibles aux tests unitaires du domaine
- Les invariants ne sont pas centralisés — ils peuvent être violés depuis plusieurs points d'entrée
- Tout changement de règle métier nécessite de retrouver tous les points d'implémentation

### Anemic Domain Model

**Description :** les Aggregates sont des structures de données (getters/setters). Toute la logique réside dans des Domain Services ou des Application Services.

**Rejeté parce que :**
- Les invariants ne sont pas enforced par l'Aggregate — ils peuvent être contournés
- Les Domain Events ne peuvent pas être produits naturellement par le Domain
- Le modèle de domaine ne représente pas le métier — il représente le schéma de base de données
- Violation directe de P-02

### Domain Services omniprésents

**Description :** dès qu'une opération implique plus d'un Aggregate, un Domain Service est créé. Les Domain Services prolifèrent.

**Définition positive — quand un Domain Service est légitime :**

Un Domain Service n'existe que lorsqu'une règle métier ne possède pas de maison naturelle dans un Aggregate ou un Value Object — typiquement une règle qui coordonne plusieurs Aggregates sans appartenir conceptuellement à aucun d'eux. Il exprime une logique métier pure. Il n'ouvre pas de transaction et ne publie pas d'événement.

**Rejeté (en tant que pattern systématique) parce que :**
- La prolifération des Domain Services est un symptôme d'Aggregates trop petits ou anémiques
- Recourir systématiquement à un Domain Service dès qu'il y a plusieurs Aggregates évite de poser la vraie question : quel Aggregate est le bon propriétaire de cet invariant ?
- Les Domain Services ne doivent jamais orchestrer des transactions — c'est le rôle de l'Application

### Orchestration dans les Controllers

**Description :** les Controllers HTTP ouvrent les transactions, chargent les Repositories, invoquent le domaine.

**Rejeté parce que :**
- Les Controllers deviennent impossibles à tester sans serveur HTTP
- La logique d'orchestration est couplée au protocole de transport
- Aucun chemin pour réutiliser la même logique depuis CLI, Message Bus, ou test
- Violation de P-03 (P-03 s'applique aux Application Services — les Controllers ne sont pas des Application Services)

### Publication immédiate des Domain Events

**Description :** les Domain Events sont dispatché immédiatement dans la transaction, avant le commit.

**Rejeté parce que :**
- Un consommateur peut réagir à un événement annulé par un rollback — état fantôme
- La réaction d'un consommateur peut elle-même échouer et rendre le rollback impossible sans compensation
- Violation de P-07

---

## 11. Conséquences

### Bénéfices

**Testabilité totale du Domain.** Les Aggregates sont testables avec des primitives PHP — aucun framework, aucune base de données, aucun bus. Un test unitaire de domaine s'exécute en millisecondes.

**Application Services prédictibles.** Un Application Service suit toujours la même séquence. Il est lisible, testable par intégration, et n'héberge aucune surprise métier.

**Invariants centralisés.** Toute règle métier vit dans l'Aggregate. Il est impossible de violer un invariant depuis un chemin non prévu — le seul chemin vers l'Aggregate est la méthode de domaine.

**Fiabilité des Domain Events.** Aucun événement fantôme possible. La co-persistance Aggregate + Outbox garantit la cohérence entre état et événements.

**Indépendance du framework.** Symfony peut être remplacé sans toucher au Domain ni à la logique d'orchestration. Les Application Services ne connaissent pas Symfony.

### Compromis

**Volume de code structurel.** Cette architecture nécessite des objets Command, des interfaces de Repository, des Application Services dédiés pour chaque Use Case. Le volume de classes est supérieur à une architecture Transaction Script.

**Cohérence éventuelle pour les opérations cross-Aggregate.** La décomposition d'une opération en deux Commands reliées par un Domain Event introduit une fenêtre de cohérence éventuelle. Il faut concevoir les projections et les interfaces utilisateur en tenant compte de cette latence.

**Discipline de la frontière.** La règle "un seul Aggregate modifié par transaction" exige une discipline permanente. La tentation de modifier deux Aggregates dans une même transaction apparaîtra fréquemment — elle doit être identifiée et refusée lors des revues.

---

## 12. Critères de conformité

Cette checklist est utilisable lors de chaque revue de code impliquant un Use Case.

### Domain Layer

- [ ] L'Aggregate Root n'importe aucune classe d'Infrastructure
- [ ] L'Aggregate Root n'importe aucune classe d'Application
- [ ] L'Aggregate Root n'importe aucune classe de framework
- [ ] Les Domain Events sont créés et produits exclusivement par l'Aggregate Root
- [ ] L'interface du Repository est définie dans le Domain Layer
- [ ] Toute règle métier est dans l'Aggregate — aucun `if` métier dans un Service

### Application Layer

- [ ] L'Application Service modifie exactement un Aggregate Root par transaction
- [ ] L'Application Service ne contient aucune logique conditionnelle métier
- [ ] L'Application Service utilise uniquement des interfaces — jamais des classes concrètes d'Infrastructure
- [ ] Les Domain Events sont collectables depuis l'Aggregate après la méthode de domaine
- [ ] Les Domain Events sont persistés dans la même transaction que l'Aggregate
- [ ] L'Application Service ne publie pas directement sur le bus d'événements

### Infrastructure Layer

- [ ] Le Repository implémente l'interface définie dans le Domain Layer
- [ ] Le Repository retourne uniquement des Aggregate Roots complets
- [ ] Le Repository ne retourne pas de DTOs, de tableaux, ou de projections
- [ ] Aucune classe d'Infrastructure n'est importée directement dans le Domain ou l'Application

### Interface Layer

- [ ] Le Controller construit une Command et la dispatche — il ne contient aucune logique métier
- [ ] Le Controller ne charge pas de Repository directement
- [ ] Le Controller ne crée pas d'Aggregate directement
- [ ] La validation de format dans le Controller ne contient pas de règles métier

---

## Invariants protégés

| Invariant | Protégé par |
|---|---|
| Le Domain reste indépendant de tout framework et de toute infrastructure | P-01 — Indépendance du Domain |
| Un invariant métier ne peut pas être contourné depuis un chemin non prévu | Aggregate Root — seul point d'entrée vers l'état |
| Aucune règle métier ne réside silencieusement dans un Service | P-02 + P-03 — Aggregates gardiens, Services orchestrateurs |
| Une orchestration ne prend jamais de décision métier | P-03 — Application Services orchestrent sans décider |
| Un Aggregate modifié est toujours accompagné de ses Domain Events | Atomicité Aggregate + Outbox — même transaction |
| Aucun événement fantôme ne peut être reçu par un consommateur | P-07 — Publication post-commit uniquement |
| Les Queries ne contaminent pas le modèle de domaine | Séparation CQRS — Query Handlers sans Aggregate |
| L'architecture reste valide si le framework change | Indépendance de framework — Domain et Application sans couplage externe |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle — autorité supérieure |
| ADR-0003 | Hexagonal Architecture — fondement des dépendances §9 |
| ADR-0004 | CQRS — séparation lecture/écriture |
| ADR-SA-009 | Persistence Technology Policy — implémentation Repository |
| ADR-SA-013 | Domain Event Publication Outbox — mécanisme P-07 |
| ADR-SA-015 | clinicalActivityId dans E-01 — exemple concret §6 |
| DE-001 | Domain Event Taxonomy — contrats des événements |
| DA-010 | Clinical Activity — exemple Use Case §6 |
