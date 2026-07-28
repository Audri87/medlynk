# CM-001 — Context Map complet de MedLink

**Version :** 1.0
**Statut :** Accepted
**Sources :** Domain Atlas V1 · SD-005 · ADR-0002 · ADR-0014 · ADR-SA-012 · KERNEL-SPEC-v0.3
**Date :** 2026-07-28

---

## Préambule

### Ce que ce document est

Un Context Map documente les **relations entre Bounded Contexts** : qui fournit quoi, qui dépend de quoi, comment la connaissance traverse les frontières, et qui possède chaque concept partagé.

Ce document couvre l'intégralité de MedLink — Platform Kernel, plateformes actives, plateformes planifiées, et plateformes futures.

### Ce que ce document n'est pas

Ce document ne décrit pas de déploiements, de services, de bases de données, ou d'infrastructure.

Il modélise uniquement le domaine.

### Règle fondamentale des frontières (ADR-0014)

> Un Domain Event ne franchit jamais une frontière de plateforme.
> Seuls les Integration Events traversent les frontières entre plateformes.
> Chaque plateforme consommatrice traduit les Integration Events entrants via une couche Anti-Corruption.

À l'intérieur d'une même plateforme, les Domain Events circulent librement entre Bounded Contexts.

---

## 1. Vue générale

```
╔═══════════════════════════════════════════════════════════════════╗
║                      PLATFORM KERNEL                             ║
║                                                                   ║
║   Actor · Organization · Work Context · BusinessEvent            ║
║                    [Open Host Service]                            ║
╚══════════╤════════════════════════════════════════════════════════╝
           │ [OHS → CF]         (toutes les plateformes se conforment)
           ↓
╔══════════════════════════════╗
║     IDENTITY PLATFORM        ║   Possède : Practitioner · Patient · Organization
║           [OHS]              ║
╚══════════╤═══════════════════╝
           │ [C/S + ACL]       (Integration Events → chaque plateforme)
           │
    ┌──────┴───────────────────────────────────────────────────┐
    ↓                                                          ↓
╔══════════════════════════════════╗      ╔══════════════════════════╗
║      CLINICAL PLATFORM           ║      ║  SCHEDULING PLATFORM     ║
║                                  ║      ║  (planifiée)             ║
║  ┌─────────────────────────┐     ║      ║  Possède : Appointment   ║
║  │  Contribution Clinique  │     ║      ║            TimeSlot      ║
║  └────────────┬────────────┘     ║      ╚══════════╤═══════════════╝
║               │ Domain Events    ║                 │
║  ┌────────────↓────────────┐     ║      ╔══════════↓═══════════════╗
║  │   Parcours de Soins     │     ║      ║  BILLING PLATFORM        ║
║  └────────────┬────────────┘     ║      ║  (planifiée)             ║
║               │ Domain Events    ║      ║  Possède : Invoice        ║
║  ┌────────────↓────────────┐     ║      ║            Payment       ║
║  │   Continuité Clinique   │     ║      ╚══════════════════════════╝
║  └─────────────────────────┘     ║
║         Possède : CareRecord     ║
║                   ClinicalContrib ║      ╔══════════════════════════╗
║                   CarePlan       ║      ║  MESSAGING PLATFORM      ║
╚══════════╤═══════════════════════╝      ║  (planifiée)             ║
           │                             ║  Possède : Notification  ║
    ┌──────┤ Integration Events          ╚══════════════════════════╝
    │      │
    ↓      ↓
╔══════════════════╗  ╔═══════════════════════╗
║  TRUST PLATFORM  ║  ║  COLLABORATION        ║
║  [Partnership]   ║  ║  PLATFORM             ║
║  (planifiée)     ║  ║  [Partnership]        ║
║                  ║  ║  (planifiée)          ║
║  Consent         ║  ║  Mission              ║
║  Compliance      ║  ║  Discussion           ║
║  Traceability    ║  ║  Consultation         ║
╚══════════════════╝  ╚═══════════════════════╝
           │
    ┌──────┤ Integration Events (future)
    ↓      ↓
╔══════════════════╗  ╔═══════════════════════╗  ╔════════════════╗
║  LEARNING        ║  ║  AI PLATFORM          ║  ║  ANALYTICS     ║
║  PLATFORM        ║  ║  (future)             ║  ║  PLATFORM      ║
║  (future)        ║  ║                       ║  ║  (future)      ║
╚══════════════════╝  ╚═══════════════════════╝  ╚════════════════╝
```

---

## 2. Platform Kernel

### Description

Le Kernel est la couche fondatrice de MedLink. Il définit les concepts les plus stables — ceux qui seront valides dans vingt ans, quelle que soit l'évolution des plateformes.

Le Kernel ne connaît aucun concept clinique, éducatif, ou commercial.

**Concepts validés du Kernel :** Actor · Organization · Work Context · BusinessEvent

### Relation avec les plateformes

Le Kernel s'adresse à toutes les plateformes via un **Open Host Service** : il publie un modèle bien défini auquel les plateformes se conforment sans négociation.

| Propriété | Valeur |
|---|---|
| Rôle du Kernel | Fournisseur universel — Upstream |
| Rôle de chaque plateforme | Conformiste — adapte les concepts Kernel à son domaine |
| Ownership des concepts Kernel | Platform Kernel — intouchables par les plateformes |

**Ce que chaque plateforme fait des concepts Kernel :**

| Concept Kernel | Traduction dans Clinical Platform |
|---|---|
| Actor | → Professionnel de Santé (auteur de Contributions) · Patient (objet de soins) |
| Organization | → Établissement ou structure dans lequel la Contribution est produite |
| Work Context | → ContexteId attaché à chaque Contribution Clinique |
| BusinessEvent | → Implémenté optionnellement par les Integration Events à signification Kernel |

Le Kernel ne sait pas que Patient et Professionnel de Santé existent.

La Clinical Platform sait que Actor existe — et l'adapte.

---

## 3. Identity Platform

### Description

L'Identity Platform possède la définition canonique des acteurs de MedLink : qui ils sont, comment ils sont authentifiés, et quelles organisations ils représentent.

**Concepts possédés :** Practitioner · Patient · Organization

### Relation avec la Clinical Platform

```
IDENTITY PLATFORM [U · OHS]
        │
        │ PractitionerRegisteredIntegration
        │ PatientRegisteredIntegration
        │ PractitionerUpdatedIntegration
        │
        ↓ [ACL]
CLINICAL PLATFORM [D · Customer]
        │
        ├── BC-1 Contribution Clinique → PractitionerId (value object local)
        └── BC-2 Parcours de Soins     → PatientId (value object local)
```

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier + Anti-Corruption Layer |
| **Sens** | Identity = Upstream · Clinical = Downstream |
| **Responsabilité d'Identity** | Maintenir l'identité canonique des acteurs. Publier un Integration Event à chaque changement. |
| **Responsabilité de Clinical** | Consommer les Integration Events. Maintenir une **projection locale** des acteurs (ne jamais requêter les tables Identity). Traduire via ACL. |
| **Ownership** | Identity possède Practitioner et Patient. Clinical ne peut jamais modifier ces concepts — seulement lire. |

**Integration Events échangés (Identity → Clinical) :**

| Événement | Déclencheur | Consommé par |
|---|---|---|
| `PractitionerRegisteredIntegration` | Nouveau professionnel enregistré | BC-1 : crée la projection locale `PractitionerId` |
| `PatientRegisteredIntegration` | Nouveau patient enregistré | BC-2 : initialise la possibilité de créer un Parcours de Soins |
| `PractitionerUpdatedIntegration` | Changement de nom / spécialité | BC-1 : met à jour la projection locale |

**Ce que l'ACL fait dans Clinical :**

La Clinical Platform ne connaît pas les types d'Identity. Elle traduit `PractitionerRegisteredIntegration.practitionerId` (string) → `PractitionerId` (value object clinique). Cette traduction est l'Anti-Corruption Layer.

---

## 4. Relations internes — Clinical Platform

Les relations internes utilisent des **Domain Events** (jamais d'Integration Events). Elles constituent le flux fondamental de la plateforme.

### R-INT-01 — Contribution Clinique → Parcours de Soins

```
CONTRIBUTION CLINIQUE [U · Supplier]
        │
        │ ContributionCliniqueCreée    (Domain Event)
        │ ContributionCliniqueAmendée  (Domain Event)
        │
        ↓
PARCOURS DE SOINS [D · Customer]
```

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier |
| **Sens** | Contribution Clinique = Upstream · Parcours de Soins = Downstream |
| **Responsabilité de BC-1** | Produire des Contributions Cliniques valides. Publier un Domain Event à chaque production ou amendement. Ne jamais connaître le Parcours. |
| **Responsabilité de BC-2** | Souscrire aux Domain Events. Intégrer chaque Contribution dans le Parcours du Patient concerné, dans l'ordre chronologique. |
| **Ownership** | BC-1 possède la Contribution Clinique (source de vérité). BC-2 possède le Parcours de Soins (source de vérité). |
| **Partagé** | `ContributionId` et `PatientId` comme value objects sans sémantique croisée. |

**Domain Events échangés :**

| Événement | Données transportées | Effet dans BC-2 |
|---|---|---|
| `ContributionCliniqueCreée` | `contributionId`, `patientId`, `auteurId`, `produitLe` | Intégration dans le Parcours du Patient |
| `ContributionCliniqueAmendée` | `contributionId`, `amendeDe`, `patientId`, `produitLe` | Intégration de l'amendement ; l'originale reste intacte |

---

### R-INT-02 — Contribution Clinique → Continuité Clinique

```
CONTRIBUTION CLINIQUE [U · Supplier]
        │
        │ ContributionCliniqueCreée  (Domain Event)
        │
        ↓
CONTINUITÉ CLINIQUE [D · Customer]
```

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier |
| **Sens** | Contribution Clinique = Upstream · Continuité Clinique = Downstream |
| **Responsabilité de BC-1** | Publier `ContributionCliniqueCreée` à chaque production. |
| **Responsabilité de BC-3** | Détecter si la Contribution est une **Contribution de Transmission** (produite explicitement avant une Transition) et l'associer à la Transition ouverte. |
| **Ownership** | BC-1 possède la Contribution. BC-3 possède la Transition et la Reprise. |

**Domain Events échangés :**

| Événement | Données transportées | Effet dans BC-3 |
|---|---|---|
| `ContributionCliniqueCreée` | `contributionId`, `patientId`, `auteurId`, `produitLe` | Vérification : Contribution de Transmission à associer à une Transition ouverte ? |

---

### R-INT-03 — Parcours de Soins → Continuité Clinique

```
PARCOURS DE SOINS [U · Supplier]
        │
        │ ContributionCliniqueIntégrée  (Domain Event)
        │ ParcoursDeSoinsInitié         (Domain Event)
        │
        │ ← lecture directe (Application Service) ←
        │
        ↓
CONTINUITÉ CLINIQUE [D · Customer]
```

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier (avec lecture directe via Application Service) |
| **Sens** | Parcours de Soins = Upstream · Continuité Clinique = Downstream |
| **Responsabilité de BC-2** | Maintenir le Parcours à jour. Répondre aux requêtes de lecture de l'Application Service. |
| **Responsabilité de BC-3** | Souscrire aux événements du Parcours. Requêter le Parcours via l'Application Service `AssembleurDeReprise` pour obtenir les Contributions pertinentes lors d'une Reprise de Contexte. |
| **Ownership** | BC-2 possède le Parcours de Soins. BC-3 ne possède aucun contenu clinique — seulement les agrégats Transition, Reprise, et Lacune. |

**Domain Events échangés :**

| Événement | Données transportées | Effet dans BC-3 |
|---|---|---|
| `ParcoursDeSoinsInitié` | `patientId`, `initiéLe` | Premier Parcours connu — BC-3 peut désormais ouvrir des Transitions pour ce Patient |
| `ContributionCliniqueIntégrée` | `contributionId`, `patientId`, `produitLe` | Signal que le Parcours est enrichi — une Reprise en cours peut être mise à jour |

**Lecture directe :** lors d'une Reprise de Contexte active, l'Application Service `AssembleurDeReprise` de BC-3 interroge le Parcours de Soins pour récupérer et ordonner les Contributions selon leur pertinence (Signal vs. Bruit). Cette lecture est synchrone et encapsulée dans l'Application Service — elle ne traverse pas le Domain.

---

## 5. Clinical Platform → Trust Platform

### Description de la relation

La Trust Platform est responsable de deux choses qui concernent directement la Clinical Platform :

1. **Consentement** — avant d'exposer le Parcours de Soins d'un Patient, le consentement doit être vérifié.
2. **Traçabilité** — chaque accès à une donnée clinique doit être enregistré pour conformité légale (GDPR, HDS).

Ces deux responsabilités créent une relation **bidirectionnelle** : Trust impose des contraintes à Clinical (consentement) et Clinical fournit les faits à auditer (traçabilité).

```
CLINICAL PLATFORM
        │
        │ ContributionCliniqueProduiteIntegration
        │ ParcoursAccédéIntegration
        │ TransitionOuverteIntegration
        │
        ↓
TRUST PLATFORM
        │
        │ ConsentementValiféIntegration
        │ AccèsNonAutoriséIntegration
        │
        ↓
CLINICAL PLATFORM
```

| Attribut | Valeur |
|---|---|
| **Type de relation** | Partnership (obligations bidirectionnelles) |
| **Sens** | Bidirectionnel — coévolution coordonnée |
| **Responsabilité de Clinical** | Publier les faits cliniques significatifs pour audit. Consulter Trust avant d'exposer un Parcours de Soins. Respecter les réponses de Trust sans discussion. |
| **Responsabilité de Trust** | Vérifier le consentement et répondre immédiatement. Enregistrer les faits cliniques pour conformité. Ne jamais altérer le contenu clinique. |
| **Ownership** | Clinical possède le contenu clinique. Trust possède le registre de consentement et le journal d'audit. Aucun n'écrit dans les tables de l'autre. |

**Integration Events (Clinical → Trust) :**

| Événement | Déclencheur | Usage dans Trust |
|---|---|---|
| `ContributionCliniqueProduiteIntegration` | Production d'une Contribution | Enregistrement dans le journal d'audit |
| `ParcoursAccédéIntegration` | Accès au Parcours de Soins d'un Patient | Log GDPR : qui a accédé, quand, depuis quel contexte |
| `TransitionOuverteIntegration` | Ouverture d'une Transition | Log du changement de Professionnel référent |
| `LacuneIdentifiéeIntegration` | Identification d'une Lacune | Log : une information attendue était absente |

**Integration Events (Trust → Clinical) :**

| Événement | Déclencheur | Usage dans Clinical |
|---|---|---|
| `ConsentementValiféIntegration` | Réponse positive à une demande de consultation du Parcours | Clinical autorise la Reprise de Contexte |
| `AccèsNonAutoriséIntegration` | Consentement absent ou révoqué | Clinical refuse l'exposition du Parcours |

**Note sur le consentement :** le flux de vérification du consentement est synchrone du point de vue métier — Clinical ne peut pas commencer une Reprise de Contexte sans réponse de Trust. L'implémentation technique de ce flux est décidée par l'Architecture.

---

## 6. Clinical Platform ↔ Collaboration Platform

### Description de la relation

La Collaboration Platform gère les interactions entre acteurs qui transcendent les prises en charge individuelles : missions transversales, consultations entre spécialistes, discussions cliniques.

La relation avec Clinical est bidirectionnelle : des événements cliniques déclenchent des collaborations, et des résultats de collaboration alimentent la Clinical Platform.

```
CLINICAL PLATFORM
        │
        │ LacuneIdentifiéeIntegration
        │ TransitionOuverteIntegration
        │
        ↓
COLLABORATION PLATFORM
        │
        │ ConsultationRésoluIntegration
        │ MissionAcceptéeIntegration
        │
        ↓
CLINICAL PLATFORM
```

| Attribut | Valeur |
|---|---|
| **Type de relation** | Partnership (coévolution) |
| **Sens** | Bidirectionnel |
| **Responsabilité de Clinical** | Publier les événements qui peuvent déclencher une collaboration (Lacune identifiée, Transition ouverte). Consommer les résultats de collaboration qui génèrent de nouvelles Contributions Cliniques. |
| **Responsabilité de Collaboration** | Recevoir les signaux cliniques et initier les workflows de collaboration appropriés. Publier les résultats de collaboration pour que Clinical puisse les incorporer. |
| **Ownership** | Clinical possède les Contributions Cliniques. Collaboration possède les Missions et Consultations. Un résultat de consultation devient une Contribution Clinique seulement si un Professionnel le produit explicitement dans Clinical. |

**Integration Events (Clinical → Collaboration) :**

| Événement | Déclencheur | Usage dans Collaboration |
|---|---|---|
| `LacuneIdentifiéeIntegration` | Une Lacune est identifiée lors d'une Reprise de Contexte | Collaboration peut initier une demande de consultation auprès d'un spécialiste |
| `TransitionOuverteIntegration` | Une Transition est ouverte | Collaboration peut coordonner un soutien au transfert (mission transversale) |

**Integration Events (Collaboration → Clinical) :**

| Événement | Déclencheur | Usage dans Clinical |
|---|---|---|
| `ConsultationRésoluIntegration` | Un spécialiste a produit une réponse de consultation | Signal pour le Professionnel référent : une nouvelle Contribution peut être produite |
| `MissionAcceptéeIntegration` | Un Professionnel accepte une mission transversale concernant un Patient | Contexte additionnel pour la prochaine Reprise de Contexte |

**Invariant :** un résultat de Collaboration n'entre jamais directement dans le Parcours de Soins. Il doit être transformé en Contribution Clinique par un Professionnel de Santé dans BC-1. Collaboration informe — Clinical produit.

---

## 7. Clinical Platform → Scheduling Platform

### Description de la relation

La Scheduling Platform possède les rendez-vous et les disponibilités. La Clinical Platform consomme cette information pour contextualiser les Reprises de Contexte.

```
SCHEDULING PLATFORM [U · Supplier]
        │
        │ AppointmentConfirmedIntegration
        │ AppointmentCancelledIntegration
        │
        ↓ [ACL]
CLINICAL PLATFORM [D · Customer]
```

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier + ACL |
| **Sens** | Scheduling = Upstream · Clinical = Downstream |
| **Responsabilité de Scheduling** | Maintenir les rendez-vous. Publier les changements via Integration Events. |
| **Responsabilité de Clinical** | Consommer les Integration Events via ACL. Utiliser l'information de rendez-vous comme contexte pour l'ouverture de Transitions et l'initiation de Reprises de Contexte. |
| **Ownership** | Scheduling possède Appointment et TimeSlot. Clinical ne peut jamais modifier un rendez-vous — seulement en être informé. |

**Integration Events (Scheduling → Clinical) :**

| Événement | Déclencheur | Usage dans Clinical |
|---|---|---|
| `AppointmentConfirmedIntegration` | Rendez-vous confirmé | BC-3 : préparation anticipée de la Reprise de Contexte |
| `AppointmentCancelledIntegration` | Rendez-vous annulé | BC-3 : annulation d'une Reprise préparée |

---

## 8. Clinical Platform → Messaging Platform

### Description de la relation

La Messaging Platform est le canal de notification de MedLink. La Clinical Platform génère des événements dont certains doivent déclencher des notifications à des acteurs spécifiques.

```
CLINICAL PLATFORM [U · Supplier]
        │
        │ TransitionOuverteIntegration
        │ LacuneIdentifiéeIntegration
        │
        ↓
MESSAGING PLATFORM [D · Customer]
```

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier |
| **Sens** | Clinical = Upstream · Messaging = Downstream |
| **Responsabilité de Clinical** | Publier les événements significatifs. Ne jamais décider du format ou du canal de notification. |
| **Responsabilité de Messaging** | Décider comment, quand, et à qui notifier en fonction des événements reçus. Posséder Notification. |
| **Ownership** | Clinical possède les faits cliniques. Messaging possède Notification et les préférences de canal. |

**Integration Events (Clinical → Messaging) :**

| Événement | Destinataire de la notification | Contenu |
|---|---|---|
| `TransitionOuverteIntegration` | Professionnel entrant | "Un Patient vous est transféré — une Reprise de Contexte est disponible." |
| `LacuneIdentifiéeIntegration` | Professionnel sortant (si Lacune récupérable) | "Une information que vous pourriez compléter a été identifiée comme manquante." |

---

## 9. Plateformes futures

Ces plateformes sont anticipées dans ADR-SA-012 et CLAUDE.md. Leur modèle interne n'est pas encore défini. Leurs relations avec la Clinical Platform sont dérivables des principes généraux.

### AI Platform

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier + Published Language |
| **Sens** | Clinical = Upstream · AI = Downstream |
| **Principe** | L'AI reçoit des Contributions Cliniques validées (avec consentement du Patient) pour produire des résumés, des suggestions de structure, ou des analyses de continuité. |
| **Invariant fondamental** | L'AI ne produit jamais de Contributions Cliniques. Elle produit des **suggestions** que le Professionnel de Santé peut choisir d'incorporer comme Contribution. La responsabilité de la Contribution reste celle du Professionnel. |
| **Ownership** | Clinical possède ClinicalContribution. AI ne possède que ses propres outputs (résumés, suggestions). |

### Learning Platform

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier |
| **Sens** | Clinical = Upstream · Learning = Downstream |
| **Principe** | Des Contributions Cliniques validées et anonymisées (avec consentement explicite) peuvent alimenter des cas cliniques pour l'apprentissage. |
| **Invariant fondamental** | La désidentification est obligatoire. Trust valide le consentement avant toute transmission à Learning. |

### Analytics Platform

| Attribut | Valeur |
|---|---|
| **Type de relation** | Customer / Supplier |
| **Sens** | Clinical = Upstream · Analytics = Downstream |
| **Principe** | Analytics consomme des données agrégées et anonymisées pour produire des tableaux de bord sans jamais avoir accès aux données individuelles des Patients. |

---

## 10. Tableau récapitulatif des relations

### Relations internes — Clinical Platform

| Relation | Type | Upstream | Downstream | Domain Events échangés |
|---|---|---|---|---|
| R-INT-01 | Customer / Supplier | Contribution Clinique | Parcours de Soins | `ContributionCliniqueCreée` · `ContributionCliniqueAmendée` |
| R-INT-02 | Customer / Supplier | Contribution Clinique | Continuité Clinique | `ContributionCliniqueCreée` |
| R-INT-03 | Customer / Supplier + lecture | Parcours de Soins | Continuité Clinique | `ParcoursDeSoinsInitié` · `ContributionCliniqueIntégrée` |

### Relations externes — entre plateformes

| Relation | Type | Upstream / Fournisseur | Downstream / Client | Sens |
|---|---|---|---|---|
| R-EXT-01 | OHS / Conformist | Platform Kernel | Toutes les plateformes | Kernel → toutes |
| R-EXT-02 | C/S + ACL | Identity Platform | Clinical Platform | Identity → Clinical |
| R-EXT-03 | Partnership | Clinical ↔ Trust | bidirectionnel | Clinical ↔ Trust |
| R-EXT-04 | Partnership | Clinical ↔ Collaboration | bidirectionnel | Clinical ↔ Collaboration |
| R-EXT-05 | C/S + ACL | Scheduling Platform | Clinical Platform | Scheduling → Clinical |
| R-EXT-06 | C/S | Clinical Platform | Messaging Platform | Clinical → Messaging |
| R-EXT-07 | C/S + PL | Clinical Platform | AI Platform | Clinical → AI |
| R-EXT-08 | C/S | Clinical Platform | Learning Platform | Clinical → Learning |
| R-EXT-09 | C/S | Clinical Platform | Analytics Platform | Clinical → Analytics |

*C/S = Customer/Supplier · ACL = Anti-Corruption Layer · OHS = Open Host Service · CF = Conformist · PL = Published Language*

---

## 11. Ownership des concepts partagés

Chaque concept appartient à exactement une plateforme.

| Concept | Propriétaire | Consommateurs |
|---|---|---|
| Actor | Platform Kernel | Toutes les plateformes (via conformisme) |
| Organization | Identity Platform | Clinical · Scheduling · Billing |
| Practitioner | Identity Platform | Clinical · Scheduling · Billing · Messaging · AI |
| Patient | Identity Platform | Clinical · Scheduling · Billing · Messaging |
| Professionnel de Santé | Clinical Platform (traduction locale) | — |
| ClinicalContribution / Contribution Clinique | Clinical Platform — BC-1 | AI · Analytics |
| CareRecord / Parcours de Soins | Clinical Platform — BC-2 | AI · Analytics |
| Transition | Clinical Platform — BC-3 | Messaging |
| Lacune | Clinical Platform — BC-3 | Messaging · Collaboration |
| Appointment | Scheduling Platform | Clinical · Billing · Messaging |
| Invoice | Billing Platform | Clinical · Messaging |
| Notification | Messaging Platform | — |
| Course | Learning Platform | AI · Analytics |

**Règle d'ownership :** un concept n'est jamais modifié par un non-propriétaire. Un consommateur envoie une **commande** au propriétaire via API. Il attend un Integration Event confirmant le changement. Il ne modifie jamais directement.

---

## 12. Règles de gouvernance du Context Map

### Règle 1 — Unicité de l'ownership

Tout concept a exactement un propriétaire.

Si deux plateformes semblent posséder le même concept, c'est un signal que le découpage est incorrect ou que les concepts sont distincts et ont besoin de noms différents.

### Règle 2 — Direction des Domain Events

Les Domain Events ne franchissent jamais une frontière de plateforme.

À l'intérieur de la Clinical Platform : les Domain Events circulent librement entre Bounded Contexts.

### Règle 3 — Direction des Integration Events

Les Integration Events franchissent les frontières de plateformes.

Ils sont produits par la couche d'intégration du propriétaire.

Ils sont consommés via ACL par les consommateurs.

### Règle 4 — Lecture locale uniquement

Une plateforme ne requête jamais les tables d'une autre plateforme.

Elle maintient une **projection locale** à partir des Integration Events.

### Règle 5 — Stabilité des Integration Events

Un Integration Event publié en production est immuable.

Tout changement incompatible crée une nouvelle version (`v2`).

Les deux versions coexistent 90 jours (ADR-SA-012).

### Règle 6 — Mise à jour du Context Map

Toute nouvelle plateforme, tout nouveau Bounded Context, ou toute nouvelle relation nécessite une mise à jour de ce document avant implémentation.

Le Context Map est le contrat stratégique du projet.

---

## 13. Ce que ce Context Map ne couvre pas

| Élément | Raison |
|---|---|
| Workspace / Projections | Composants de présentation — pas des Bounded Contexts (projections sans business model) |
| Search / Discovery | Composant architectural — optimisation des lectures, pas un contexte métier |
| Anti-Corruption Layer interne | Détail d'implémentation — décidé par l'Architecture |
| Format des Integration Events | Décidé par ADR-SA-012 — hors périmètre de ce document |
| Déploiement des plateformes | Décision d'infrastructure — jamais de ce document |

---

## Références

| Document | Sujet |
|---|---|
| Domain Atlas V1 | Source des 15 concepts cliniques |
| SD-005 | Bounded Contexts internes de la Clinical Platform |
| ADR-0002 | Catalogue des plateformes MedLink |
| ADR-0014 | Règle : Domain Events ne franchissent pas les frontières |
| ADR-SA-012 | Ownership table · Integration Events · Versioning |
| KERNEL-SPEC-v0.3 | Concepts du Platform Kernel |
| UL-001 v3.0 | Vocabulaire canonique |
