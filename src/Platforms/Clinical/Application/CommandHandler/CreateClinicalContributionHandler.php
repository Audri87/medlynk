<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\CommandHandler;

use App\Platforms\Clinical\Application\Command\CreateClinicalContribution;
use App\Platforms\Clinical\Application\Port\ClinicalContributionRepositoryPort;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;

/**
 * Command Handler — UC-001: Create Clinical Contribution.
 *
 * Single responsibility: execute the Create use case within exactly one transaction
 * boundary owned by the Application Runtime (SA-007 §6.2, SA-005 D-003).
 *
 * Execution sequence (ADR-SA-013 §6.4):
 *  1. Runtime opens transaction (via command.bus doctrine_transaction middleware, outer).
 *  2. DomainEventPublisherMiddleware delegates to the handler (inner).
 *  3. Handler creates ClinicalContribution aggregate via factory.
 *  4. Aggregate records ClinicalContributionCreated (pending in AggregateRoot).
 *  5. Handler calls repository.persist() — aggregate state written within transaction.
 *  6. Repository calls collector.collect(contribution.releaseDomainEvents()) — events held.
 *  7. DomainEventPublisherMiddleware flushes collector, creates EventEnvelopes, writes to Outbox.
 *  8. doctrine_transaction COMMIT — aggregate write + Outbox write are atomic.
 *
 * WHY the Handler no longer injects DomainEventCollectorPort:
 * Per ADR-SA-013 R-006 and R-010, the Repository is the sole caller of collect().
 * Moving collection into the Repository eliminates a coupling point from every Handler
 * and makes the collection contract impossible to forget.
 *
 * Depends on: ClinicalContributionRepositoryPort, ClinicalContribution.
 * Never depends on: Read Model Ports, Infrastructure implementations, event.bus, any framework service.
 */
final class CreateClinicalContributionHandler
{
    public function __construct(
        private readonly ClinicalContributionRepositoryPort $repository,
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
    }
}
