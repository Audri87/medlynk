# Golden Path — Use Case Template

**Statut :** Référence officielle
**Date :** 2026-07-29
**Conformité :** ADR-SA-017 · ADR-SA-018 · ADR-SA-019 · ADR-SA-020 · ADR-SA-021 · ADR-SA-022 · ADR-SA-025

---

## Objet

Ce document est le modèle officiel à reproduire pour tout nouveau Use Case dans MedLink.

Il décrit la structure complète d'un Use Case en suivant le cas concret : **ProduireContributionClinique**.

Chaque fichier est annoté de l'ADR qu'il satisfait. Toute déviation de ce modèle requiert une justification dans le commentaire du Pull Request.

---

## Structure de fichiers

```
src/Platforms/Clinical/
│
├── Domain/ClinicalContribution/
│   ├── ClinicalContribution.php                     ← Aggregate Root
│   ├── ClinicalContributionId.php                   ← Value Object
│   ├── ClinicalContributionRepository.php           ← Interface (Port)
│   ├── Exception/
│   │   └── ClinicalContributionNotFound.php
│   └── Event/
│       └── ContributionCreated.php                  ← Domain Event
│
├── Application/Command/ProduireContributionClinique/
│   ├── ProduireContributionCliniqueCommand.php      ← Command (DTO)
│   └── ProduireContributionCliniqueHandler.php      ← Application Service
│
├── Infrastructure/Persistence/
│   ├── DoctrineClinicalContributionRepository.php   ← Adapter
│   └── Mapping/
│       └── ClinicalContribution.orm.xml             ← Doctrine mapping
│
└── Presentation/Api/
    ├── Resource/
    │   └── ContributionResource.php                 ← DTO d'entrée API
    └── Processor/
        └── ProduireContributionProcessor.php        ← Primary Adapter HTTP

tests/
├── Unit/Platforms/Clinical/Domain/ClinicalContribution/
│   └── ClinicalContributionTest.php
├── Integration/Platforms/Clinical/Application/Command/
│   └── ProduireContributionCliniqueHandlerTest.php
└── Contract/DomainEvent/
    └── ContributionCreatedContractTest.php
```

---

## 1. Domain Event

**Fichier :** `src/Platforms/Clinical/Domain/ClinicalContribution/Event/ContributionCreated.php`
**Réf. :** ADR-SA-005 (P-05), DE-001 (E-01), ADR-SA-015, ADR-SA-019 §7

```php
<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Event;

use App\Shared\Domain\Event\DomainEventInterface;

final readonly class ContributionCreated implements DomainEventInterface
{
    public function __construct(
        private string            $eventId,           // UUID — clé de déduplication (ADR-SA-019 §7)
        public readonly string    $contributionId,
        public readonly string    $clinicalActivityId, // ADR-SA-015 — jamais null
        public readonly string    $patientId,
        public readonly string    $auteurId,
        private \DateTimeImmutable $occurredAt,
    ) {}

    public function eventId(): string             { return $this->eventId; }
    public function occurredAt(): \DateTimeImmutable { return $this->occurredAt; }
    public function aggregateId(): string          { return $this->contributionId; }
    public function aggregateType(): string        { return 'ClinicalContribution'; }
}
```

---

## 2. Aggregate Root

**Fichier :** `src/Platforms/Clinical/Domain/ClinicalContribution/ClinicalContribution.php`
**Réf. :** ADR-SA-000 (P-02), ADR-SA-017 §4, ADR-SA-021 §5

```php
<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution;

use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ContributionCreated;
use App\Shared\Domain\Event\RecordsEvents;

final class ClinicalContribution
{
    use RecordsEvents; // accumule les Domain Events — ADR-SA-017 §8, ADR-SA-021 §5

    private function __construct(
        private readonly ClinicalContributionId $id,
        private readonly ClinicalActivityId     $clinicalActivityId,
        private readonly PatientId              $patientId,
        private readonly PractitionerId         $auteurId,
        private readonly \DateTimeImmutable     $createdAt,
        private int                             $version = 1, // optimistic locking — ADR-SA-018 §7
    ) {}

    /**
     * Named constructor — seul point de création de l'Aggregate.
     * Enforce les invariants et produit le Domain Event.
     */
    public static function produce(
        ClinicalContributionId $id,
        ClinicalActivityId     $clinicalActivityId,
        PatientId              $patientId,
        PractitionerId         $auteurId,
    ): self {
        // Invariants métier — ADR-SA-000 P-02
        // [ajouter les règles métier ici]

        $contribution = new self(
            id:                 $id,
            clinicalActivityId: $clinicalActivityId,
            patientId:          $patientId,
            auteurId:           $auteurId,
            createdAt:          new \DateTimeImmutable(),
        );

        // Produit le Domain Event — ADR-SA-017 §8
        $contribution->record(new ContributionCreated(
            eventId:            (string) \Symfony\Component\Uid\Uuid::v4(),
            contributionId:     $id->value(),
            clinicalActivityId: $clinicalActivityId->value(),
            patientId:          $patientId->value(),
            auteurId:           $auteurId->value(),
            occurredAt:         $contribution->createdAt,
        ));

        return $contribution;
    }

    public function id(): ClinicalContributionId { return $this->id; }
}
```

---

## 3. Repository Interface (Port)

**Fichier :** `src/Platforms/Clinical/Domain/ClinicalContribution/ClinicalContributionRepository.php`
**Réf. :** ADR-SA-000 (P-04), ADR-SA-017 §4

```php
<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution;

interface ClinicalContributionRepository
{
    // Persist ou update — ADR-SA-000 P-04 : jamais de DTO en retour
    public function save(ClinicalContribution $contribution): void;

    // Lève ClinicalContributionNotFound si absent — jamais null
    public function load(ClinicalContributionId $id): ClinicalContribution;
}
```

---

## 4. Command (DTO)

**Fichier :** `src/Platforms/Clinical/Application/Command/ProduireContributionClinique/ProduireContributionCliniqueCommand.php`
**Réf. :** ADR-SA-017 §5

```php
<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Command\ProduireContributionClinique;

final readonly class ProduireContributionCliniqueCommand
{
    public function __construct(
        public readonly string $clinicalActivityId,
        public readonly string $patientId,
        public readonly string $auteurId,
        // Ajouter les autres dimensions cliniques nécessaires
    ) {}
}
```

---

## 5. Application Service (Command Handler)

**Fichier :** `src/Platforms/Clinical/Application/Command/ProduireContributionClinique/ProduireContributionCliniqueHandler.php`
**Réf :** ADR-SA-017 §5, ADR-SA-018 §9, ADR-SA-021 §2

```php
<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Command\ProduireContributionClinique;

use App\Platforms\Clinical\Domain\ClinicalActivity\ClinicalActivityRepository;
use App\Platforms\Clinical\Domain\ClinicalActivity\Exception\ClinicalActivityNotActive;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContributionRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final class ProduireContributionCliniqueHandler
{
    public function __construct(
        // Aggregate consultatif — lecture seule (ADR-SA-017 §5)
        private readonly ClinicalActivityRepository     $activities,
        // Aggregate principal — modifié (ADR-SA-017 §5)
        private readonly ClinicalContributionRepository $contributions,
    ) {}

    // Retourne l'identifiant créé — jamais un Aggregate (ADR-SA-017 §5 — Résultat)
    public function __invoke(ProduireContributionCliniqueCommand $command): string
    {
        // 1. Charger l'Aggregate consultatif — précondition (ADR-SA-017 §5)
        $activity = $this->activities->load(
            new ClinicalActivityId($command->clinicalActivityId)
        );

        if (!$activity->isActive()) {
            throw new ClinicalActivityNotActive($command->clinicalActivityId);
        }

        // 2. Créer l'Aggregate principal — enforce les invariants + produit l'event
        $contribution = ClinicalContribution::produce(
            id:                 ClinicalContributionId::generate(),
            clinicalActivityId: new ClinicalActivityId($command->clinicalActivityId),
            patientId:          new PatientId($command->patientId),
            auteurId:           new PractitionerId($command->auteurId),
        );

        // 3. Persister — la transaction est gérée par TransactionMiddleware (ADR-SA-021 §2)
        $this->contributions->save($contribution);

        // 4. Les Domain Events sont collectés par DomainEventPublisherMiddleware (ADR-SA-021 §2)
        //    Aucun dispatch manuel ici.

        return $contribution->id()->value();
    }
}
```

---

## 6. Repository Doctrine (Adapter)

**Fichier :** `src/Platforms/Clinical/Infrastructure/Persistence/DoctrineClinicalContributionRepository.php`
**Réf :** ADR-SA-000 (P-04), ADR-SA-021 §3

```php
<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence;

use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContributionRepository;
use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\ClinicalContributionNotFound;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineClinicalContributionRepository implements ClinicalContributionRepository
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {}

    public function save(ClinicalContribution $contribution): void
    {
        // persist() enqueue dans l'UoW Doctrine — flush géré par TransactionMiddleware
        $this->em->persist($contribution);
    }

    public function load(ClinicalContributionId $id): ClinicalContribution
    {
        $contribution = $this->em->find(ClinicalContribution::class, $id);

        if ($contribution === null) {
            throw new ClinicalContributionNotFound($id->value());
        }

        return $contribution; // Aggregate Root complet — P-04
    }
}
```

---

## 7. Mapping Doctrine (sans contamination du Domain)

**Fichier :** `src/Platforms/Clinical/Infrastructure/Persistence/Mapping/ClinicalContribution.orm.xml`
**Réf :** ADR-SA-021 §3 — aucun attribut Doctrine dans le Domain

```xml
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping">
    <entity name="App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution"
            table="clinical_contributions">

        <id name="id" type="clinical_contribution_id" column="id" />

        <field name="clinicalActivityId" type="clinical_activity_id" column="clinical_activity_id" nullable="false" />
        <field name="patientId"          type="patient_id"           column="patient_id"           nullable="false" />
        <field name="auteurId"           type="practitioner_id"      column="auteur_id"            nullable="false" />
        <field name="createdAt"          type="datetime_immutable"   column="created_at"           nullable="false" />

        <field name="version" type="integer" column="version">
            <options><option name="default">1</option></options>
        </field>
        <version name="version" type="integer" />

    </entity>
</doctrine-mapping>
```

---

## 8. API Resource et State Processor

**Fichier :** `src/Platforms/Clinical/Presentation/Api/Processor/ProduireContributionProcessor.php`
**Réf :** ADR-SA-021 §6 — Primary Adapter HTTP, aucune logique métier

```php
<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Presentation\Api\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Platforms\Clinical\Application\Command\ProduireContributionClinique\ProduireContributionCliniqueCommand;
use App\Platforms\Clinical\Presentation\Api\Resource\ContributionResource;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class ProduireContributionProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {}

    /**
     * @param ContributionResource $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        // Construit la Command depuis le DTO API — aucune logique métier ici
        $envelope = $this->commandBus->dispatch(
            new ProduireContributionCliniqueCommand(
                clinicalActivityId: $data->clinicalActivityId,
                patientId:          $uriVariables['patientId'],
                auteurId:           $data->auteurId,
            )
        );

        $contributionId = $envelope->last(HandledStamp::class)->getResult();

        return ['contributionId' => $contributionId];
    }
}
```

---

## 9. Test unitaire Domain

**Fichier :** `tests/Unit/Platforms/Clinical/Domain/ClinicalContribution/ClinicalContributionTest.php`
**Réf :** ADR-SA-025 §3

```php
<?php

declare(strict_types=1);

namespace Tests\Unit\Platforms\Clinical\Domain\ClinicalContribution;

use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ContributionCreated;
use PHPUnit\Framework\TestCase;

final class ClinicalContributionTest extends TestCase
{
    // Aucune DB, aucun framework, aucun mock — ADR-SA-025 §3

    public function test_produce_raises_ContributionCreated_event(): void
    {
        // Given
        $activityId = ClinicalActivityId::generate();
        $patientId  = PatientId::generate();
        $auteurId   = PractitionerId::generate();

        // When
        $contribution = ClinicalContribution::produce(
            id:                 ClinicalContributionId::generate(),
            clinicalActivityId: $activityId,
            patientId:          $patientId,
            auteurId:           $auteurId,
        );

        // Then
        $events = $contribution->releaseEvents();
        self::assertCount(1, $events);
        self::assertInstanceOf(ContributionCreated::class, $events[0]);
        self::assertSame($activityId->value(), $events[0]->clinicalActivityId);
        self::assertSame($patientId->value(),  $events[0]->patientId);
        self::assertSame($auteurId->value(),   $events[0]->auteurId);
        self::assertNotEmpty($events[0]->eventId()); // clé de déduplication
    }

    public function test_releaseEvents_clears_internal_buffer(): void
    {
        $contribution = ClinicalContribution::produce(
            id:                 ClinicalContributionId::generate(),
            clinicalActivityId: ClinicalActivityId::generate(),
            patientId:          PatientId::generate(),
            auteurId:           PractitionerId::generate(),
        );

        $contribution->releaseEvents(); // première collecte

        self::assertEmpty($contribution->releaseEvents()); // buffer vidé
    }
}
```

---

## 10. Test d'intégration

**Fichier :** `tests/Integration/Platforms/Clinical/Application/Command/ProduireContributionCliniqueHandlerTest.php`
**Réf :** ADR-SA-025 §4 — DB réelle, jamais mockée

```php
<?php

declare(strict_types=1);

namespace Tests\Integration\Platforms\Clinical\Application\Command;

use App\Platforms\Clinical\Application\Command\ProduireContributionClinique\ProduireContributionCliniqueCommand;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContributionRepository;
use Tests\Integration\IntegrationTestCase; // base class avec transaction rollback

final class ProduireContributionCliniqueHandlerTest extends IntegrationTestCase
{
    public function test_handler_persists_aggregate_and_outbox_event(): void
    {
        // Given — données préexistantes insérées via fixtures DB
        $activityId = $this->givenActiveClinicalActivity();
        $patientId  = $this->givenPatient();
        $auteurId   = $this->givenPractitioner();

        // When
        $contributionId = $this->dispatch(new ProduireContributionCliniqueCommand(
            clinicalActivityId: $activityId,
            patientId:          $patientId,
            auteurId:           $auteurId,
        ));

        // Then — Aggregate persisté (DB réelle)
        $repository   = $this->get(ClinicalContributionRepository::class);
        $contribution = $repository->load(new ClinicalContributionId($contributionId));
        self::assertNotNull($contribution);

        // Then — Domain Event dans l'Outbox (ADR-SA-020)
        $events = $this->queryOutbox('ContributionCreated');
        self::assertCount(1, $events);
        self::assertSame($contributionId, $events[0]['payload']['contributionId']);
        self::assertSame('PENDING', $events[0]['status']);
    }
}
```

---

## 11. Test contractuel

**Fichier :** `tests/Contract/DomainEvent/ContributionCreatedContractTest.php`
**Réf :** ADR-SA-025 §5, DE-001 §E-01, ADR-SA-015

```php
<?php

declare(strict_types=1);

namespace Tests\Contract\DomainEvent;

use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ContributionCreated;
use PHPUnit\Framework\TestCase;

final class ContributionCreatedContractTest extends TestCase
{
    public function test_ContributionCreated_conforms_to_DE001_E01(): void
    {
        $event = new ContributionCreated(
            eventId:            'test-event-id',
            contributionId:     'test-contribution-id',
            clinicalActivityId: 'test-activity-id',  // ADR-SA-015 — jamais null
            patientId:          'test-patient-id',
            auteurId:           'test-auteur-id',
            occurredAt:         new \DateTimeImmutable(),
        );

        // Champs requis par DE-001 §E-01
        self::assertNotEmpty($event->eventId());
        self::assertNotEmpty($event->contributionId);
        self::assertNotEmpty($event->clinicalActivityId);
        self::assertNotEmpty($event->patientId);
        self::assertNotEmpty($event->auteurId);
        self::assertNotEmpty($event->aggregateId());
        self::assertSame('ClinicalContribution', $event->aggregateType());

        // Champs absents du contrat DE-001 §E-01
        self::assertFalse(property_exists($event, 'description'));
    }
}
```

---

## Checklist de conformité Pull Request

Avant de soumettre un nouveau Use Case, vérifier :

### Domain
- [ ] L'Aggregate Root n'importe aucune classe Symfony, Doctrine, ou Infrastructure
- [ ] L'Aggregate Root utilise le trait `RecordsEvents`
- [ ] Chaque méthode de domaine produit exactement les Domain Events documentés dans DE-001
- [ ] Le Repository est une interface dans le Domain Layer

### Application
- [ ] Le Command Handler modifie un seul Aggregate (principal)
- [ ] Le Command Handler ne contient aucun `if` métier
- [ ] Le Command Handler retourne un identifiant, void, ou un DTO — jamais un Aggregate
- [ ] Les Domain Events ne sont pas dispatchés manuellement

### Infrastructure
- [ ] Le mapping Doctrine est en XML dans `Infrastructure/Persistence/Mapping/`
- [ ] Aucun attribut `#[Entity]`, `#[Column]` dans les classes Domain
- [ ] Le Repository Doctrine implémente l'interface du Domain

### Interface
- [ ] Le Processor construit la Command et dispatche — aucune logique métier
- [ ] La réponse est un DTO — jamais un Aggregate

### Tests
- [ ] Test unitaire Domain couvrant le happy path et au moins une exception
- [ ] Test d'intégration vérifiant la persistance Aggregate + Outbox
- [ ] Test contractuel vérifiant le payload du Domain Event produit
- [ ] Deptrac passe sans violation
