# ADR-SA-025 — Testing Strategy

**Type :** Software Architecture Decision — Politique transversale
**Statut :** Accepted
**Date :** 2026-07-29
**Autorité :** Ce document gouverne la stratégie de test de MedLink. Il est subordonné à ADR-SA-000.
**Règle absolue :** Les tests d'intégration ne mockent jamais la base de données (CLAUDE.md).

---

## Conformité ADR-SA-000

| Principe | Statut | Note |
|---|---|---|
| P-01 — Indépendance du Domain | ✅ Conforme | Les tests unitaires du Domain n'ont aucune dépendance externe |
| P-02 — Aggregates gardiens | ✅ Conforme | Chaque invariant est couvert par un test unitaire |
| P-03 — Application Services orchestrent | ✅ Conforme | Les tests d'intégration vérifient l'orchestration |
| P-05 — Events immuables | ✅ Conforme | Les tests contractuels vérifient les payloads d'événements |
| autres | ⚪ Sans objet | |

---

## 1. Contexte

Sans stratégie de test explicite, trois dérives apparaissent :
- les développeurs mockent la base de données dans les tests d'intégration, créant une divergence entre les tests et la production,
- les invariants du Domain ne sont pas testés — seul le comportement HTTP est testé,
- l'architecture est contournée sans qu'aucun test ne le détecte.

Cette ADR définit les quatre types de tests, leurs périmètres, et leurs règles.

---

## 2. Pyramide des tests

```
          /‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾\
         /   Architecture      \    (Deptrac — quelques règles)
        /‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾\
       /    Contractuels         \   (Event payloads, API schema)
      /‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾\
     /      Intégration            \  (Command Handlers, Projections — DB réelle)
    /‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾\
   /         Unitaires               \ (Domain — Aggregates, VOs, Domain Events)
  /___________________________________\
```

Les tests unitaires sont les plus nombreux. Les tests d'architecture sont les moins nombreux.

---

## 3. Tests unitaires — Domain

### Périmètre

Uniquement le Domain Layer :
- Aggregate Roots et leurs méthodes
- Value Objects et leurs invariants
- Exceptions de domaine
- Domain Services (si existants)

### Règles

- **Aucune base de données** — pas de Doctrine, pas de connexion
- **Aucun framework** — pas de Symfony, pas de container DI
- **Aucun mock de la base de données** (inutile — la DB n'est pas en jeu)
- Les Repository interfaces peuvent être implémentées par des fakes en mémoire
- Chaque invariant du Domain a au moins un test
- Chaque chemin d'exception a au moins un test

### Organisation

```
tests/Unit/
└── Platforms/
    └── Clinical/
        └── Domain/
            ├── ClinicalActivity/
            │   └── ClinicalActivityTest.php
            └── ClinicalContribution/
                ├── ClinicalContributionTest.php
                └── Event/
                    └── ContributionCreatedTest.php
```

### Conventions de nommage

```
test_{scénario}_{résultatAttendu}

Exemples :
test_produce_contribution_raises_event_with_correct_payload()
test_produce_contribution_with_inactive_activity_throws_exception()
test_self_approval_throws_SelfApprovalAttemptedException()
```

### Structure Given / When / Then

```php
public function test_produce_contribution_raises_ContributionCreated(): void
{
    // Given
    $activityId = ClinicalActivityId::generate();
    $patientId  = PatientId::generate();
    $auteurId   = PractitionerId::generate();

    // When
    $contribution = ClinicalContribution::produce(
        id: ClinicalContributionId::generate(),
        clinicalActivityId: $activityId,
        patientId: $patientId,
        auteurId: $auteurId,
    );

    // Then
    $events = $contribution->releaseEvents();
    self::assertCount(1, $events);
    self::assertInstanceOf(ContributionCreated::class, $events[0]);
    self::assertSame($activityId->value(), $events[0]->clinicalActivityId);
}
```

### Vitesse attendue

Un test unitaire Domain s'exécute en moins de **5ms**. Une suite complète de tests Domain s'exécute en moins de **10 secondes**.

---

## 4. Tests d'intégration

### Périmètre

- Command Handlers (Application Services) avec base de données réelle
- Repository implementations (Doctrine)
- Projectors (mise à jour des Read Models)
- Relay Outbox (publication des événements)

### Règle absolue

**La base de données n'est jamais mockée.** Les tests d'intégration utilisent une base de données PostgreSQL dédiée aux tests, identique en schéma à la base de production.

Cette règle vient d'une contrainte explicite de CLAUDE.md : *"Integration tests use a dedicated test database (never mock the database)"*.

### Organisation

```
tests/Integration/
└── Platforms/
    └── Clinical/
        ├── Application/
        │   └── Command/
        │       └── ProduceContributionHandlerTest.php
        └── Infrastructure/
            ├── Persistence/
            │   └── DoctrineClinicalContributionRepositoryTest.php
            └── Projection/
                └── WorkspaceProjectionTest.php
```

### Isolation des tests

Chaque test démarre dans une transaction de base de données ouverte et la rollback à la fin. Cela garantit que la base est dans son état initial pour chaque test, sans nécessiter de fixture ou de truncation.

```php
protected function setUp(): void
{
    parent::setUp();
    $this->beginTransaction();  // transaction ouverte avant le test
}

protected function tearDown(): void
{
    $this->rollbackTransaction();  // rollback systématique — l'état est restauré
    parent::tearDown();
}
```

### Ce que les tests d'intégration vérifient

| Comportement | Test |
|---|---|
| L'Aggregate est correctement persisté | `Repository.load()` après `Handler.dispatch()` |
| Les Domain Events sont insérés dans l'Outbox | SELECT dans `domain_events` après Handler |
| L'Aggregate et les Events sont dans la même transaction | Vérification atomique de la présence des deux |
| Le Repository ne retourne que des Aggregates complets | Vérification du type retourné |
| Le Projector met à jour la Read Model en réaction à l'event | State final de la projection |

### Vitesse attendue

Un test d'intégration s'exécute en moins de **500ms**. La suite complète d'intégration s'exécute en moins de **5 minutes**.

---

## 5. Tests contractuels

### Périmètre

Vérifient que les contrats figés (DE-001, ADR-SA-015, ADR-SA-016) sont respectés par les implémentations.

### Tests de payload Domain Event

Chaque Domain Event a un test qui vérifie que son payload correspond exactement au contrat défini dans DE-001.

```php
public function test_ContributionCreated_payload_conforms_to_DE001(): void
{
    $event = ContributionCreated::fromAggregate(...);

    // Champs obligatoires (DE-001, §E-01)
    self::assertNotEmpty($event->eventId());
    self::assertNotEmpty($event->contributionId);
    self::assertNotEmpty($event->clinicalActivityId);    // ADR-SA-015
    self::assertNotEmpty($event->patientId);
    self::assertNotEmpty($event->auteurId);
    self::assertInstanceOf(\DateTimeImmutable::class, $event->occurredAt());

    // Champs absents du contrat
    self::assertFalse(property_exists($event, 'description'));  // absent — ADR-SA-016
}
```

### Tests de schema API

Vérifient que les réponses API correspondent au schema OpenAPI documenté.

```php
public function test_POST_contributions_returns_conformant_response(): void
{
    $response = $this->client->request('POST', '/api/v1/patients/{id}/contributions', [...]);

    self::assertResponseStatusCodeSame(201);
    self::assertMatchesJsonSchema($response->toArray(), 'contribution-created.schema.json');
}
```

### Organisation

```
tests/Contract/
├── DomainEvent/
│   ├── ContributionCreatedContractTest.php
│   └── ClinicalActivityStartedContractTest.php
└── Api/
    └── ContributionApiContractTest.php
```

---

## 6. Tests d'architecture

### Périmètre

Vérifient que les règles de dépendances définies dans ADR-SA-017 §9 sont respectées dans le code source.

### Outil — Deptrac

Deptrac analyse les imports PHP et détecte les violations de dépendances entre couches.

```yaml
# deptrac.yaml
layers:
    - name: Domain
      collectors:
          - type: directory
            value: src/Platforms/*/Domain

    - name: Application
      collectors:
          - type: directory
            value: src/Platforms/*/Application

    - name: Infrastructure
      collectors:
          - type: directory
            value: src/Platforms/*/Infrastructure

    - name: Interface
      collectors:
          - type: directory
            value: src/Platforms/*/Presentation

ruleset:
    Domain:
        - ~                 # Le Domain ne dépend de rien (sauf Shared/Domain)
    Application:
        - Domain
    Infrastructure:
        - Domain
        - Application
    Interface:
        - Application
```

### Règles vérifiées automatiquement

| Règle | Violation détectée |
|---|---|
| Domain n'importe pas Application | `use App\...\Application\...` dans `Domain/` |
| Domain n'importe pas Infrastructure | `use App\...\Infrastructure\...` dans `Domain/` |
| Application n'importe pas Infrastructure concrète | `use App\...\Infrastructure\Doctrine\...` dans `Application/` |
| Interface n'importe pas Domain directement | `use App\...\Domain\...\Aggregate` dans `Presentation/` |

### Exécution

```bash
vendor/bin/deptrac analyse
```

Exécuté dans la CI à chaque Pull Request. Un échec bloque le merge.

---

## 7. Commandes d'exécution

```bash
# Tests unitaires Domain uniquement — rapides
php bin/phpunit tests/Unit/

# Tests d'intégration — base de données réelle
php bin/phpunit tests/Integration/

# Tests contractuels
php bin/phpunit tests/Contract/

# Tests d'architecture
vendor/bin/deptrac analyse

# Suite complète
php bin/phpunit
```

---

## 8. Ce qui n'est pas testé dans cette stratégie

| Périmètre | Raison |
|---|---|
| Tests de performance | Traité séparément selon les besoins |
| Tests de charge | Hors périmètre MVP |
| Tests E2E navigateur | Symfony UX — traité dans l'ADR Frontend |
| Tests de sécurité (pentest) | Traité dans ADR-SA-023 |

---

## 9. Invariants protégés

| Invariant | Protégé par |
|---|---|
| Chaque invariant Domain est testé | Tests unitaires obligatoires — §3 |
| Les tests ne divergent pas de la production | DB réelle en intégration — §4 |
| Les contrats de Domain Events sont vérifiés | Tests contractuels — §5 |
| Les violations de dépendances sont détectées en CI | Deptrac — §6 |

---

## Références

| Document | Relation |
|---|---|
| ADR-SA-000 | Constitution logicielle |
| ADR-SA-017 | Runtime Architecture — règles de dépendances testées par Deptrac |
| ADR-SA-020 | Transactional Outbox — tests d'intégration de l'Outbox |
| DE-001 | Domain Event Taxonomy — contrats vérifiés par les tests contractuels |
| CLAUDE.md | "Integration tests use a dedicated test database (never mock the database)" |
