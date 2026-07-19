<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\CommandHandler;

use App\Platforms\Clinical\Application\Command\CreateClinicalContribution;
use App\Platforms\Clinical\Application\Port\ClinicalContributionRepositoryPort;
use App\Platforms\Clinical\Application\Port\DomainEventCollectorPort;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;

/**
 * Command Handler — UC-001: Create Clinical Contribution.
 *
 * Single responsibility: execute the Create use case within exactly one transaction
 * boundary owned by the Application Runtime (SA-007 §6.2, SA-005 D-003).
 *
 * Execution sequence (RVS-001 §10 CreateClinicalContributionHandler):
 *  1. Runtime opens transaction (via command.bus doctrine_transaction middleware).
 *  2. Handler creates ClinicalContribution aggregate via factory.
 *  3. Aggregate records ClinicalContributionCreated (pending — not yet published).
 *  4. Handler calls repository.persist() — aggregate state written within transaction.
 *  5. Handler calls eventCollector.collect() — events held for post-commit publication.
 *  6. Runtime commits transaction.
 *  7. Infrastructure implementation of DomainEventCollectorPort publishes events (PR-004).
 *
 * WHY the Handler does not contain the transaction boundary:
 * The Application Runtime (Symfony Messenger's doctrine_transaction middleware) opens and
 * commits the transaction. The Handler trusts the Runtime and concentrates on orchestration.
 * Splitting concerns this way means transaction policy changes don't require Handler changes.
 *
 * WHY the Handler does not dispatch to the event.bus directly:
 * Domain Events must not be published inside the transaction (SA-005 D-008).
 * Publishing inside the transaction makes events observable before state is committed.
 * If the transaction rolls back, published events would describe a state that never existed.
 * DomainEventCollectorPort decouples collection (inside transaction) from publication (post-commit).
 *
 * WHY the Handler does not know the Infrastructure repository implementation:
 * The Handler depends on ClinicalContributionRepositoryPort — the Application-layer interface.
 * The Infrastructure implementation is injected by the DI container and invisible to this class.
 * This is the Dependency Inversion Principle applied at the layer boundary (ADR-0003, SA-003).
 *
 * Depends on: ClinicalContributionRepositoryPort, DomainEventCollectorPort, ClinicalContribution.
 * Never depends on: Read Model Ports, Infrastructure implementations, event.bus, any framework service.
 */
final class CreateClinicalContributionHandler
{
    public function __construct(
        private readonly ClinicalContributionRepositoryPort $repository,
        private readonly DomainEventCollectorPort $eventCollector,
    ) {}

    public function __invoke(CreateClinicalContribution $command): void
    {
        $contribution = ClinicalContribution::create(
            id: $command->clinicalContributionId,
            careRecordId: $command->careRecordId,
            contributingPractitionerId: $command->contributingPractitionerId,
            contributorRoleType: $command->contributorRoleType,
            clinicalText: $command->clinicalText,
            createdAt: $command->requestedAt,
        );

        $this->repository->persist($contribution);
        $this->eventCollector->collect($contribution->pullPendingEvents());
    }
}
