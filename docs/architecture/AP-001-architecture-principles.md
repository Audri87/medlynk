# AP-001 — Architecture Principles

**Version :** 1.0
**Statut :** Accepted
**Date :** 2026-07-28
**Sources :** M-003 · P-001 · CW-001 · Domain Atlas V1 · SD-005 · CM-001 · FOUNDATIONS.md

---

## Préambule — L'inversion fondamentale

L'architecture de MedLink repose sur une inversion volontaire et permanente.

La règle n'est pas : *"nous avons choisi DDD parce que c'est une bonne pratique."*

La règle est : **le domaine a une forme. L'architecture reproduit cette forme.**

Chaque décision décrite dans ce document est d'abord une réponse à une propriété observée du travail clinique, pas un choix technologique. La technologie est nommée en dernier — jamais en premier.

> "La réalité dicte le modèle. Le modèle dicte l'architecture. L'architecture dicte la technologie." — FOUNDATIONS.md

Si un principe de ce document ne peut pas être justifié par un document fondateur (M-003, P-001, CW-001, Domain Atlas), il n'a pas sa place ici.

---

## 1. Le problème que l'architecture doit résoudre

Avant de justifier aucune décision, il faut nommer le problème.

### 1.1 Le problème fondateur

Le domaine clinique produit structurellement un problème irréductible (P-001 §3) :

Le Patient est continu. Les Professionnels de Santé sont transitoires.

Toute organisation dans laquelle plusieurs professionnels interviennent successivement sur un même patient nécessite un mécanisme explicite de préservation et de transmission de la Compréhension Clinique. *(M-003 §12 — Théorème Central)*

Ce mécanisme n'existe pas naturellement. Il doit être construit.

### 1.2 Ce que le domaine a à préserver

Ce n'est pas de l'information. C'est de la **Compréhension Clinique** (M-003 §3).

La Compréhension Clinique est la représentation synthétique, interprétative, et perspectivale de la situation d'un Patient à un moment donné. Elle comprend quatre dimensions : Situation Clinique, Raisonnement Clinique, Incertitudes Cliniques, Intentions Cliniques.

Elle possède sept propriétés invariantes (M-003 §4) :
1. Elle est **située** — produite depuis un moment et une perspective particuliers.
2. Elle est **partielle** — aucun Professionnel ne possède la totalité de la compréhension.
3. Elle est **irréductible à ses sources** — la compréhension n'est pas la liste des informations.
4. Elle est **non-destructive** — aucune compréhension passée ne doit être effacée.
5. Elle est **perspectivale** — deux Professionnels peuvent légitimement comprendre différemment.
6. Elle est **temporellement dépréciable** — sans transmission, elle se dégrade.
7. Elle **inclut l'incertitude** — une compréhension sans incertitude explicite est suspecte.

### 1.3 Ce que cela implique pour le logiciel

Un logiciel qui répond à ce problème doit être capable de :

1. **Enregistrer** chaque acte de compréhension externalisé (→ Contribution Clinique).
2. **Accumuler** sans détruire l'historique (→ Parcours de Soins).
3. **Restituer** la compréhension la plus pertinente à un Professionnel entrant (→ Reprise de Contexte).
4. **Maintenir** la distinction entre écriture (production) et lecture (reprise).
5. **Propager** les changements de manière fiable entre les composants.

Ces cinq exigences ne sont pas des spécifications fonctionnelles. Ce sont des **contraintes architecturales dérivées du domaine**. Les sections suivantes établissent pourquoi chaque décision architecturale répond à l'une de ces contraintes.

---

## 2. Pourquoi le Modular Monolith

### La question

Pourquoi ne pas distribuer les composants en unités déployables indépendantes dès le départ ?

### La réponse du domaine

La Compréhension Clinique est **un actif qui traverse plusieurs Bounded Contexts dans un seul flux cohérent**.

Le flux est :

```
Contribution Clinique produite
    → intégrée dans le Parcours de Soins
        → consultée lors de la Reprise de Contexte
```

Ce flux n'est pas une succession d'opérations indépendantes. C'est un **enchaînement causal** fondé sur la non-destructivité (Domain Atlas §10, Invariant III).

La non-destructivité exige une **garantie forte** : une Contribution produite doit nécessairement être intégrée dans le Parcours de Soins. Aucun échec de transport ne doit interrompre ce flux.

Cette garantie est naturellement disponible dans un monolithe modulaire, où les Bounded Contexts partagent le même processus et où une transaction peut couvrir plusieurs opérations. La distribuer en unités déployables indépendantes introduirait une complexité de coordination que le domaine n'exige pas.

### La justification documentaire

- **P-001 §4** — Le coût de reconstruction est réel et évitable. Toute rupture dans le flux d'accumulation des Contributions crée une Lacune structurelle.
- **Domain Atlas §10** — Le Parcours de Soins est non-destructif. Cette propriété doit être garantie par le système, pas seulement déclarée.
- **M-003 §8.5** — La Compréhension Clinique a une valeur économique. Sa perte est irréductible. Un système qui perd des Contributions (à cause d'une indisponibilité de réseau entre composants distribués) inflige un coût irréductible.
- **ADR-0002** — MedLink est une plateforme en construction progressive. Le Modular Monolith permet d'ajouter des plateformes (Learning, Conference...) sans redéfinir les frontières existantes.

### Ce que ce choix interdit

- Distribuer les Bounded Contexts en unités déployables indépendantes avant que le domaine n'en exige la séparation.
- Justifier une future distribution par des préférences de déploiement plutôt que par une contrainte du domaine.

### Ce que ce choix autorise

- Chaque Bounded Context reste un **module logiciel autonome** avec ses propres règles, ses propres tables, et ses propres invariants. L'indépendance est réelle. La co-localisation est une décision d'exécution, pas une décision de modèle.

---

## 3. Pourquoi le Domain-Driven Design

### La question

Pourquoi ne pas construire le système à partir d'un modèle de données générique, ou d'un modèle orienté fonctionnalités ?

### La réponse du domaine

Le domaine clinique est structurellement polysémique : le même mot désigne des réalités différentes dans des contextes différents.

Le terme *"patient"* désigne :
- un acteur authentifié dans l'Identity Platform,
- le sujet d'une Contribution Clinique dans BC-1,
- le propriétaire d'un Parcours de Soins dans BC-2,
- l'entité dont la continuité est à préserver dans BC-3.

Ce n'est pas une ambiguïté à résoudre par un consensus de définition. C'est une **propriété structurelle du domaine** : le sens d'un concept dépend du contexte d'action.

Un modèle générique qui uniformise ces sens produit un système qui ne représente aucune de ces réalités avec précision. Il accumule de l'information sans préserver de la compréhension.

Plus fondamentalement : la Compréhension Clinique est **perspectivale** (M-003 Invariant V). Elle ne peut pas être représentée dans un modèle unique neutre. Elle exige des modèles distincts qui coexistent et sont délimités par leur contexte de production.

Le DDD est la seule méthodologie qui formalise cette polysémie comme une propriété fondamentale plutôt qu'un problème à résoudre.

### La justification documentaire

- **M-003 §5 — Perspectivisme clinique** — "Deux Professionnels qui forment des compréhensions différentes du même Patient ne se contredisent pas nécessairement — ils se complètent." Représenter cela dans un modèle unique est impossible sans perdre la perspective.
- **UL-001 v3.0** — Le Ubiquitous Language confirme que le vocabulaire change selon le contexte. *Patient* dans le contexte de Contribution Clinique n'est pas le même objet que *Patient* dans le contexte de Parcours de Soins.
- **FOUNDATIONS.md §5 — The Domain Describes Practice** — "Le Domain Model décrit la pratique clinique. Jamais une profession particulière."
- **SD-005** — Les 3 Bounded Contexts ont été dérivés directement des concepts du Domain Atlas, pas d'un organigramme ou d'une organisation d'équipes.

### Ce que ce choix interdit

- Construire un modèle de données central partagé entre tous les contextes.
- Importer les types d'un Bounded Context dans un autre.
- Laisser un Bounded Context connaître les règles d'un autre.

---

## 4. Pourquoi le CQRS

### La question

Pourquoi ne pas utiliser un modèle unique pour lire et écrire les données cliniques ?

### La réponse du domaine

La production d'une Compréhension Clinique et la consultation d'une Compréhension Clinique sont deux **actes cognitifs fondamentalement différents** — avec des modèles d'information différents.

**L'acte d'écriture — Produire une Contribution Clinique** (Domain Atlas §4)

Le Professionnel de Santé externalise sa compréhension. L'acte de production exige que le système garantisse :
- l'authorship (qui a produit),
- la non-destructivité (aucune Contribution passée n'est altérée),
- l'intégrité des dimensions (au moins une dimension clinique est présente),
- la temporalité (à quel moment cette compréhension était vraie).

Ce sont des **invariants de domaine**. Ils doivent être protégés par l'agrégat. Aucune opération de lecture ne devrait jamais mettre ces invariants en danger.

**L'acte de lecture — Effectuer une Reprise de Contexte** (Domain Atlas §12, CW-001)

Le Professionnel de Santé reconstruit sa compréhension. Cet acte cognitif exige que le système présente :
- les informations les plus pertinentes pour la situation actuelle,
- dans un ordre de Signal avant Bruit (CW-001 §9),
- avec les Lacunes potentielles mises en évidence.

Ce sont des **besoins de présentation cognitifs**. Ils n'ont pas de rapport avec les invariants de production. Un modèle de Contribution conçu pour la production (avec ses règles d'invariant, sa structure d'agrégat, son cycle de vie) est structurellement inadapté à la restitution.

Forcer le même modèle à servir les deux actes crée inévitablement l'un de ces deux problèmes :
- Soit le modèle de production se dégrade pour accommoder les besoins de lecture.
- Soit le modèle de lecture est contraint par les règles de production et ne peut pas être optimisé.

Le CQRS résout ce problème en reconnaissant que **deux modèles distincts répondent à deux actes distincts**.

### La justification documentaire

- **CW-001 §3 à §8** — Les 6 phases de la Reprise de Contexte (Orientation, Acquisition sélective, Construction du modèle, Identification des lacunes, Priorisation, Clôture) montrent que le lecteur ne consomme pas la même représentation que celle produite par l'auteur.
- **M-003 §3 — Les dimensions de la Compréhension** — La Compréhension est irréductible à ses sources (Invariant III). Une lecture de l'agrégat ne donne pas la Compréhension — seulement ses composants. La Projection construit la représentation qui donne accès à la Compréhension.
- **ADR-SA-005 D-001** — "Each application Use Case SHALL be implemented by exactly one Command Handler or one Query Handler." Ce principe n'est pas une convention de code — c'est la traduction du CQRS au niveau applicatif.
- **ADR-SA-005 D-002** — "A Handler SHALL NEVER directly access Aggregates or Repositories belonging to another Bounded Context." Cette règle protège l'indépendance des Bounded Contexts, rendue possible par la séparation des chemins de lecture et d'écriture.

### Ce que ce choix interdit

- Lire depuis l'agrégat pour servir une interface utilisateur.
- Construire un endpoint API qui effectue simultanément une modification de l'agrégat et retourne un résultat calculé.
- Partager le même objet entre le chemin de commande et le chemin de requête.

---

## 5. Pourquoi les Projections

### La question

Pourquoi ne pas lire directement depuis le modèle de domaine ou depuis les tables de l'agrégat ?

### La réponse du domaine

La Compréhension Clinique est **toujours relative à un contexte** (M-003 Invariant I).

Il n'existe pas de "vue neutre" d'un Parcours de Soins. La même accumulation de Contributions produit une vue différente pour :
- le cardiologue en consultation (focalisé sur les Intentions Cliniques cardiaques récentes),
- le médecin généraliste en garde (focalisé sur la chronologie des Incertitudes actives),
- l'infirmière de nuit (focalisée sur les Intentions Cliniques à exécuter immédiatemment).

Cette multiplicité des vues n'est pas un problème de présentation. C'est une propriété fondamentale du domaine : le **perspectivisme clinique** (M-003 §5).

Chaque Projection est la réalisation d'une vue perspectivale. Elle transforme l'accumulation de Contributions en une représentation optimisée pour l'acte cognitif spécifique qu'elle sert — Reprise de Contexte, surveillance, chronologie, alertes.

Si les Projections n'existaient pas, chaque lecteur devrait reconstruire sa propre vue à partir des données brutes de l'agrégat. Ce serait transférer la charge cognitive du système vers l'utilisateur — exactement l'inverse de la mission de MedLink.

Par ailleurs, les Projections sont **jetables et reconstruisibles** (CLAUDE.md : "Projections are disposable. Never embed business logic inside projections."). Cette propriété est fondamentale : si une Projection est corrompue, le système peut la reconstruire depuis les événements. Elle n'est jamais la source de vérité — elle est une vue calculée de la source de vérité.

### La justification documentaire

- **M-003 Invariant I** — "Toute Compréhension est située." Toute lecture doit être situated — adaptée au contexte de l'acteur qui lit.
- **CW-001 §9 — Signal vs Bruit** — La distinction entre information utile (Signal) et information présente mais non utile (Bruit) lors d'une Reprise de Contexte est le critère de conception de chaque Projection de Reprise.
- **CLAUDE.md — Workspace Engine** — "Workspace = Projection. Generated from: Actor + Organization + Domain Context + Work Context." Le Workspace est une Projection construite à partir de quatre paramètres de situation.
- **ADR-SA-011** — Read Model Strategy — "One Projection per access pattern." Chaque pattern d'accès a ses propres invariants de lecture que seule une Projection dédiée peut optimiser.
- **ADR-SA-013** — Le pattern Outbox garantit que les Domain Events qui alimentent les Projections ne sont jamais perdus. La reconstruisibilité des Projections repose sur la durabilité des événements.

### Ce que ce choix interdit

- Incorporer de la logique métier dans une Projection (une Projection calcule une vue — elle ne prend pas de décision).
- Traiter une Projection comme une source de vérité.
- Servir une interface utilisateur en lisant depuis les tables de l'agrégat.

---

## 6. Pourquoi les Événements

### La question

Pourquoi utiliser des événements pour propager les changements entre Bounded Contexts, plutôt que des appels directs ?

### La réponse du domaine

La Compréhension Clinique est **non-destructive** (Domain Atlas §10, Invariant III) et **temporellement ancrée** (Invariant IV).

Ces deux propriétés se traduisent directement en événements.

**Pourquoi non-destructif implique des événements :**

Si le système stockait uniquement l'état courant (CRUD classique), la mise à jour d'une Contribution détruirait la compréhension précédente. La non-destructivité exige que chaque changement d'état soit un **fait ajouté à l'historique**, pas une modification de l'existant. Un Domain Event est la représentation formelle d'un tel fait.

**Pourquoi temporellement ancré implique des événements :**

La Contribution Clinique porte un `produitLe` (M-003 Propriété dynamique 4) — le moment où la compréhension était vraie. Cette temporalité est une dimension du domaine, pas une métadonnée technique. Les événements sont la représentation naturelle d'une réalité temporellement ordonnée : ils sont immuables, datés, et ordonnés.

**Pourquoi le découplage est une conséquence du domaine, pas un but en soi :**

Le Parcours de Soins n'a pas besoin de savoir *comment* une Contribution a été produite — seulement *qu'elle a été produite*. Cette indépendance n'est pas une préférence de couplage faible ; c'est le reflet de l'autonomie des Bounded Contexts dans le domaine. Chaque contexte possède ses propres invariants et son propre modèle. La communication par événements respecte ces frontières naturellement.

**Pourquoi la fiabilité est une exigence du domaine :**

Un Domain Event perdu dans un système clinique n'est pas un problème technique de synchronisation. C'est une Contribution clinique qui n'atteint jamais le Parcours de Soins. C'est une Lacune créée par le système lui-même. *(ADR-SA-010)* La fiabilité des événements est une exigence de non-perte de Compréhension Clinique.

### La justification documentaire

- **Domain Atlas §10 — Parcours de Soins** — "non-destructif... jamais réduit." Cette propriété est implémentée via l'événement `ContributionCliniqueCreée` : le Parcours n'est jamais modifié, seulement enrichi par réaction à des événements.
- **M-003 §8.5 — Valeur économique de la préservation** — La perte d'une Contribution a un coût économique réel. La garantie de livraison (at-least-once via Outbox) répond à cette exigence.
- **ADR-SA-010 — Reliable Event Delivery** — "A Domain Event is the only record that a business state transition occurred." Ce n'est pas une description technique — c'est l'affirmation que l'événement EST le fait, pas sa copie.
- **ADR-0005** — La distinction entre `BusinessEvent` (Kernel) et `Platform Domain Event` (Clinical) n'est pas une convention de namespace — elle reflète deux niveaux de signification dans le domaine.

### Ce que ce choix interdit

- Appeler directement les méthodes d'un autre Bounded Context.
- Interroger les tables d'un autre Bounded Context pour propager un changement.
- Utiliser des événements dont la livraison peut être perdue sans mécanisme de compensation.

---

## 7. Pourquoi l'Event Sourcing n'est pas utilisé

### La question

Si les événements sont si centraux au domaine, pourquoi ne pas utiliser l'Event Sourcing — où l'état des agrégats est reconstruit depuis les événements ?

### La réponse du domaine

L'Event Sourcing est justifié quand **la séquence complète des transitions d'état est plus importante que l'état courant**. MedLink présente une situation différente pour chacun de ses agrégats.

**Contribution Clinique — immuable par domaine, pas par infrastructure**

La Contribution Clinique est non-destructive (Domain Atlas §4). Elle ne change jamais après création. La seule "modification" possible est un amendement qui crée une **nouvelle** Contribution.

Appliquer l'Event Sourcing à cet agrégat signifierait reconstruire son état à chaque lecture depuis une séquence d'événements. Mais l'état d'une Contribution n'évolue jamais — il n'y a rien à reconstruire. L'Event Sourcing ajouterait de la complexité infrastructure pour gérer un problème que le domaine résout lui-même par invariant.

**Parcours de Soins — agrégat qui EST une accumulation**

Le Parcours de Soins est constitué de l'ensemble de ses Contributions Cliniques dans l'ordre chronologique. C'est-à-dire qu'il est déjà, par définition, une accumulation de faits.

L'appliquer à l'Event Sourcing serait tautologique : le Parcours serait reconstruit depuis des événements qui sont eux-mêmes des entrées du Parcours. La distinction entre l'agrégat et ses événements sources disparaîtrait, créant une ambiguïté de modèle sans gain de domaine.

**Transition / Reprise de Contexte — cycle de vie court et linéaire**

La Transition suit un cycle de vie simple : Ouverte → EnCours → Clôturée. L'historique des transitions de statut n'est pas un actif du domaine — seule la Transition elle-même l'est. Reconstruire cet agrégat depuis une séquence d'événements ajouterait une infrastructure de projection d'agrégat sans valeur clinique.

**La non-destructivité est une propriété du domaine, pas une justification pour Event Sourcing**

La tentation de l'Event Sourcing vient souvent de la propriété de non-destructivité : "si rien ne doit être effacé, stockons tout sous forme d'événements." Mais dans MedLink, la non-destructivité est implémentée par les invariants des agrégats (interdiction de DELETE et UPDATE sur les Contributions) et par le Parcours de Soins (liste qui ne se réduit jamais). Ces règles sont des règles de domaine, et elles doivent vivre dans le domaine — pas être déléguées à une infrastructure.

**Ce qui est utilisé à la place**

L'Outbox Pattern (ADR-SA-013) garantit que les Domain Events sont persistés et livrés de manière fiable. Il donne une durabilité des événements — propriété souvent associée à l'Event Sourcing — sans restructurer la persistance des agrégats. Les agrégats sont persistés en état courant. Les événements sont persistés en parallèle, dans une table dédiée. Les Projections sont reconstruisibles depuis ces événements.

Ce modèle répond aux exigences du domaine sans les coûts de l'Event Sourcing : schémas d'événements évolutifs complexes, performance de reconstruction, projections d'agrégats, et migration de snapshots.

### La justification documentaire

- **Domain Atlas §4 — Contribution Clinique** — "immuable après création." L'agrégat ne transite pas entre états multiples — l'Event Sourcing n'a rien à reconstituer.
- **Domain Atlas §10 — Parcours de Soins** — "constitué de l'ensemble des Contributions ordonnées chronologiquement." L'agrégat IS son historique — l'Event Sourcing ne lui apporterait pas de nouveau pouvoir d'expression.
- **ADR-SA-013 — Outbox Pattern** — La durabilité des événements est assurée par l'Outbox, sans Event Sourcing.
- **ADR-SA-009 — Persistence Technology Policy** — "DBAL over ORM. Direct mapping." La persistence directe est une décision fondée sur la clarté du modèle, pas sur la peur de l'Event Sourcing.

### Ce que cela n'exclut pas

L'Event Sourcing reste une option légitime pour des Bounded Contexts futurs dont le domaine exigerait la reconstruction historique de l'état de l'agrégat. Le principe est : l'Event Sourcing est adopté si et seulement si le domaine le justifie. Pas par défaut.

---

## 8. La chaîne de justification complète

Chaque décision architecturale s'inscrit dans une chaîne causale qui remonte jusqu'au domaine.

```
OBSERVATION TERRAIN (P-001)
Patient continu / Professionnels transitoires
        │
        ↓
INVARIANT THÉORIQUE (M-003 §12 — Théorème Central)
Toute organisation à plusieurs intervenants successifs
nécessite un mécanisme de préservation et transmission
de la Compréhension Clinique.
        │
        ↓
PROPRIÉTÉ DU DOMAINE (Domain Atlas §4, §10)
Contribution Clinique immuable + Parcours non-destructif
        │
        ├──→ MODULAR MONOLITH
        │    Le flux de préservation est un enchaînement causal.
        │    Sa garantie doit être locale, pas distribuée.
        │
        ├──→ DDD
        │    La Compréhension est perspectivale (M-003 Inv. V).
        │    Elle nécessite des modèles distincts par contexte.
        │
        ├──→ CQRS
        │    Produire une Compréhension ≠ Lire une Compréhension.
        │    (CW-001 : la Reprise de Contexte est un acte cognitif distinct.)
        │
        ├──→ PROJECTIONS
        │    Toute Compréhension est située (M-003 Inv. I).
        │    Toute lecture doit être contextualisée pour être utile.
        │
        ├──→ ÉVÉNEMENTS
        │    L'accumulation est non-destructive.
        │    Le fait produit doit rejoindre le Parcours de façon fiable.
        │
        └──→ PAS D'EVENT SOURCING
             L'immuabilité est une règle du domaine, pas de l'infrastructure.
             L'agrégat ne transite pas entre états multiples qui nécessiteraient
             une reconstruction.
```

---

## 9. Ce que ces principes interdisent

Ces interdictions ne sont pas des conventions de code. Elles sont les conséquences directes des justifications de domaine ci-dessus.

| Pratique interdite | Raison de domaine |
|---|---|
| Lire depuis l'agrégat pour servir l'UI | La lecture et l'écriture servent deux actes cognitifs différents (CQRS) |
| Partager les types entre Bounded Contexts | La Compréhension est perspectivale — un modèle unique ne peut pas représenter deux perspectives |
| Modifier une Contribution après création | La non-destructivité est un invariant de domaine (Domain Atlas §4) |
| Supprimer des entrées du Parcours de Soins | Le Parcours ne se réduit jamais (Domain Atlas §10) |
| Incorporer de la logique métier dans une Projection | Une Projection est une vue — les décisions appartiennent au domaine |
| Requêter les tables d'un autre Bounded Context | Chaque contexte possède ses propres tables (CM-001 Règle 4) |
| Utiliser des Domain Events entre plateformes | Un Domain Event porte les concepts du domaine d'une plateforme — les exposer couple les plateformes (ADR-0014) |
| Justifier une décision architecturale sans référence au domaine | L'architecture reproduce la forme du domaine — pas la préférence de l'architecte |

---

## 10. Gouvernance de ce document

### Qui peut modifier ces principes ?

Ces principes ne peuvent être modifiés qu'en modifiant d'abord les documents fondateurs qui les justifient (M-003, P-001, CW-001, Domain Atlas).

Un principe architectural sans fondement dans les documents de domaine doit être retiré.

### Priorité des documents

```
Niveau 0 — Terrain (P-001, CW-001)
    ↓
Niveau 2 — Théorie (M-003)
    ↓
Niveau 3 — Constitution (CLAUDE.md, FOUNDATIONS.md)
    ↓
Niveau 4 — Modèle (Domain Atlas, UL-001)
    ↓
Niveau 5 — Architecture (AP-001 ← ce document, SD-005, CM-001, ADR-SA-xxx)
    ↓
Niveau 6 — Produit / Implémentation
```

Tout conflit entre un principe de ce document et un document de niveau supérieur se résout en faveur du niveau supérieur. Ce document ne peut pas contredire M-003.

---

## Références

| Document | Rôle dans ce document |
|---|---|
| P-001 | Fondation empirique — asymétrie structurelle Patient/Professionnel |
| CW-001 | Fondation empirique — 6 phases de la Reprise de Contexte |
| M-003 | Fondation théorique — Théorème Central, 7 Invariants, 4 dimensions |
| Domain Atlas V1 | Modèle — 15 concepts et leurs invariants |
| SD-005 | Découpage en 3 Bounded Contexts |
| CM-001 | Relations entre contextes et plateformes |
| ADR-SA-005 | Décisions CQRS — D-001 à D-009 |
| ADR-SA-009 | Politique de persistance — pas d'ORM sur les Projections |
| ADR-SA-010 | Outbox — garantie de livraison des Domain Events |
| ADR-SA-013 | Publication des Domain Events — Outbox Pattern |
| ADR-0014 | Domain Events ne franchissent pas les frontières de plateforme |
| FOUNDATIONS.md | Principes fondateurs — Reality First · Human Judgment First |
