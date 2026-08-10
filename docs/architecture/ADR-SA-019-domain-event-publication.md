# ADR-SA-019 — Domain Event Publication

**Type :** Software Architecture Decision — Politique
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document définit la politique de publication des Domain Events. Il est subordonné à ADR-SA-000 et ADR-SA-017. Le mécanisme concret est défini dans ADR-SA-020.
**Indépendance :** Ce document est indépendant de tout framework et de tout mécanisme de transport.

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | Le Domain produit des événements — il ne les publie pas |
| P-02 — Aggregates gardiens | ✅ Conforme | Les événements naissent dans l'Aggregate, pas dans la politique |
| P-03 — Application Services orchestrent | ✅ Conforme | La collecte est orchestrée par l'Application — §3 |
| P-04 — Repositories retournent des Aggregates | ⚪ Sans objet | |
| P-05 — Events immuables | ✅ Conforme | Les Domain Events ne sont jamais modifiés après production — §2 |
| P-06 — Une transaction | ✅ Conforme | La collecte se fait dans la transaction de l'Aggregate principal |
| P-07 — Publication post-commit | ✅ Conforme | C'est l'invariant fondateur de cette politique — §5 |
| P-08 — Integration Events | ✅ Conforme | Séparation Domain Events / Integration Events — §6 |
| P-09 — Frontières de plateforme | ✅ Conforme | Les Domain Events ne traversent pas les plateformes — §6 |
| P-10 — Read Models | ⚪ Sans objet | |

---

## 1. Contexte

ADR-SA-017 établit que les Domain Events sont produits par l'Aggregate, collectés par l'Application Service, et publiés post-commit. ADR-SA-018 définit le commit point.

Cette ADR définit la **politique** complète de publication : collecte, ordonnancement, garanties de livraison, idempotence, et gestion des erreurs. Elle ne décrit pas le mécanisme — l'Outbox est traité dans ADR-SA-020.

---

## 2. Principes fondateurs

### Les Domain Events sont des faits immuables

Un Domain Event certifie qu'un fait s'est produit dans le Domain. Il ne peut pas être modifié après sa création. Son payload est figé par contrat (DE-001). Sa sémantique ne change pas après publication.

### Le Domain produit — l'Application collecte — l'Infrastructure publie

```
Domain     → produit les events (dans l'Aggregate)
Application → collecte les events (après la méthode, avant commit)
Infrastructure → publie les events (post-commit, via mécanisme de relais)
```

Aucune couche ne franchit cette séparation.

### La publication ne fait pas partie du Use Case

La publication d'un Domain Event n'est pas observable par l'appelant de la Command. Elle se produit de manière asynchrone, après que la réponse est retournée. Le Use Case est terminé à la fin du commit.

---

## 3. Collecte

### Contrat d'accumulation

**Invariant :** les Domain Events produits par une méthode de domaine doivent être collectables une fois cette méthode terminée, dans l'ordre de leur production, sans que l'Aggregate ne publie quoi que ce soit.

L'Aggregate expose ses événements non publiés. Le mécanisme d'exposition (accesseur, EventRecorder, etc.) est défini dans ADR-SA-021.

### Qui collecte

L'Application Service est responsable de la collecte — ou d'activer un mécanisme transparent qui collecte en son nom. La responsabilité de la collecte ne peut pas être déléguée au Domain.

### Quand collecter

Après l'exécution de la méthode de domaine sur l'Aggregate principal, avant le commit. La collecte fait partie de la transaction.

### Ce qui est collecté

Uniquement les événements de l'Aggregate principal de la transaction. Les Aggregates consultatifs (chargés en lecture seule) ne produisent pas d'événements dans la transaction courante.

---

## 4. Ordonnancement

### Garanties

| Périmètre | Garantie |
|---|---|
| Événements produits par un seul Aggregate dans une transaction | Ordre de production préservé |
| Événements de transactions différentes | Aucune garantie d'ordre global |
| Événements de plusieurs Aggregates (cross-transaction) | Cohérence éventuelle — ordre non garanti |

### Conséquence pour les consommateurs

Les consommateurs ne peuvent pas supposer un ordre global entre des événements produits par des transactions différentes. Ils doivent être conçus pour fonctionner correctement quelle que soit l'ordre d'arrivée des événements d'Aggregates différents.

L'ordre intra-transaction est la seule garantie. Elle est suffisante pour les invariants de MedLink.

---

## 5. Publication

### Invariant fondateur (P-07)

**Un Domain Event ne peut jamais être reçu par un consommateur si la transaction qui l'a produit a été annulée.**

Cette propriété est non négociable. Elle est garantie par la co-persistance Aggregate + Outbox dans la même transaction, et par la publication strictement post-commit.

### Sémantique de livraison

**At-least-once.** Chaque Domain Event est livré à chaque consommateur au moins une fois. Il peut être livré plusieurs fois (voir §7 — Idempotence).

**Pas d'exactly-once.** La livraison exactly-once n'est pas garantissable sans protocole de transaction distribué. Ce coût est incompatible avec les exigences de performance et de simplicité de MedLink. L'idempotence des consommateurs est la réponse correcte à cette contrainte.

### Délai de publication

La publication se produit après le commit. Le délai entre le commit et la réception par les consommateurs dépend du mécanisme de relais (ADR-SA-020). Il est non nul et non garanti. Les consommateurs ne doivent pas supposer que les événements arrivent immédiatement après la Command.

---

## 6. Périmètre de publication

### Domain Events — intra-plateforme uniquement

Les Domain Events produits dans la Clinical Platform ne sont consommés que par des composants de la Clinical Platform (P-09). Ils ne traversent jamais les frontières de plateforme.

### Integration Events — inter-plateforme

Si un fait du Clinical Domain doit être communiqué à une autre plateforme, un Integration Event est produit à partir du Domain Event (P-08). L'Integration Event est un contrat public — son payload est stable et versionné indépendamment du Domain Event source.

| Type | Portée | Consommateurs |
|---|---|---|
| Domain Event | Intra-plateforme | Projectors, Handlers du même Bounded Context ou de BC voisins dans la même plateforme |
| Integration Event | Inter-plateforme | Plateformes externes (Learning, Trust, etc.) |

---

## 7. Idempotence

### Responsabilité

L'idempotence est la **responsabilité exclusive du consommateur**. Le publisher garantit at-least-once ; le consommateur garantit at-most-once-effect.

Un consommateur non idempotent est non conforme à cette ADR.

### Contrat de déduplication

Chaque Domain Event porte un `eventId` unique (UUID généré à la création de l'événement). Le consommateur utilise `eventId` comme clé de déduplication.

**Comportement attendu :**
- Premier traitement : traitement normal
- Traitements suivants (duplicata) : no-op — retour succès sans re-traitement

### Fenêtre de déduplication

La fenêtre de déduplication est définie par chaque consommateur selon ses contraintes métier. Elle doit couvrir au minimum la durée maximale de retry du publisher (ADR-SA-020 §5).

### Mécanisme de référence

Le mécanisme recommandé est une table de déduplication :

```
processed_events {
    event_id     : UUID      PRIMARY KEY
    processed_at : TIMESTAMPTZ NOT NULL
}
```

Le consommateur vérifie la présence de l'`event_id` avant tout traitement, dans la même transaction que son effet.

---

## 8. Gestion des erreurs de publication

### Niveaux d'erreur

| Erreur | Nature | Réponse |
|---|---|---|
| Bus indisponible | Infrastructure transitoire | Retry avec backoff — §8.1 |
| Consommateur en erreur | Logique ou infrastructure | Retry côté consommateur — §8.2 |
| Événement non traitable définitivement | Corrompu ou bug permanent | Dead Letter Queue — §8.3 |

### 8.1 — Retry du publisher

Si le publisher ne peut pas relayer un événement vers le bus, il réessaie selon la politique suivante :

- Maximum de tentatives : **5**
- Backoff : exponentiel (1s, 2s, 4s, 8s, 16s)
- Après 5 échecs : événement marqué DEAD → Dead Letter Queue

La politique de retry est configurable par type d'événement si une raison métier le justifie.

### 8.2 — Retry du consommateur

Si un consommateur échoue à traiter un événement reçu, la politique de retry est la responsabilité du consommateur. Elle est définie dans l'ADR du consommateur concerné.

Le publisher ne connaît pas le résultat du traitement consommateur.

### 8.3 — Dead Letter Queue

Un événement passe en Dead Letter Queue (DLQ) lorsque :
- Le publisher a épuisé ses tentatives (§8.1), ou
- Le consommateur a épuisé ses tentatives et signale un échec définitif

Les événements en DLQ **ne sont pas retentés automatiquement**.

**Résolution :**
1. Identifier et corriger la cause racine (bug consommateur, format invalide, bus indisponible prolongé)
2. Replayer l'événement manuellement depuis la DLQ
3. L'idempotence du consommateur garantit la sécurité du replay

**Monitoring :** la profondeur de la DLQ est une métrique critique. Toute augmentation déclenche une alerte.

---

## 9. Ce que cette politique interdit explicitement

| Interdit | Raison |
|---|---|
| Publication d'un Domain Event avant le commit | Événement fantôme — violation de P-07 |
| Publication directe depuis le Domain | Le Domain produit — il ne publie pas |
| Publication directe depuis l'Application Service | La publication passe par le mécanisme de relais post-commit |
| Consommateur non idempotent | Violation du contrat d'idempotence — §7 |
| Domain Event traversant une frontière de plateforme | Violation de P-09 |
| Modification d'un Domain Event après publication | Violation de P-05 |
| Suppression d'un événement de l'Outbox avant publication | Perte garantie — violation de la livraison at-least-once |

---

## 10. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Aucun événement fantôme | Publication post-commit uniquement — P-07 |
| Aucune perte d'événement définitive | Outbox + retry — §8.1 |
| Les événements sont reçus au moins une fois | At-least-once — §5 |
| Les consommateurs résistent aux duplicatas | Idempotence obligatoire — §7 |
| Le Domain ne publie rien directement | Séparation Domain/Infrastructure — P-01 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle — autorité supérieure |
| ADR-SA-017 | Runtime Architecture — collecte des Domain Events |
| ADR-SA-018 | Transaction Management — point de commit |
| ADR-SA-020 | Transactional Outbox — mécanisme implémentant cette politique |
| ADR-SA-012 | Platform Integration — Integration Events inter-plateforme |
| DE-001 | Domain Event Taxonomy — contrats de payload |
