<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\CommandHandler;

use App\Platforms\Clinical\Application\Command\ValidateClinicalContribution;
use App\Platforms\Clinical\Application\Port\ClinicalContributionRepositoryPort;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;

/**
 * Command Handler — UC-002: Validate Clinical Contribution.
 *
 * Single responsibility: execute the Validate use case within exactly one transaction
 * boundary owned by the Application Runtime (SA-007 §6.2, SA-005 D-003).
 *
 * Execution sequence (ADR-SA-013 §6.4):
 *  1. Runtime opens transaction.
 *  2. Handler retrieves ClinicalContribution via repository.retrieve().
 *  3. Handler calls aggregate.validate(validatedAt).
 *  4. Aggregate enforces BI-004 (status must be Draft) — throws if violated.
 *  5. Aggregate records ClinicalContributionValidated (or ClinicalContributionValidationFailed).
 *  6. Handler calls repository.persist() — updated aggregate state written within transaction.
 *  7. Repository calls collector.collect(contribution.releaseDomainEvents()) — events held.
 *  8. DomainEventPublisherMiddleware flushes, creates EventEnvelopes, writes to Outbox.
 *  9. doctrine_transaction COMMIT — aggregate write + Outbox write are atomic.
 *
 * WHY the Handler generates validatedAt rather than receiving it in the Command:
 * The validation timestamp is "the moment this use case executes" — a temporal fact
 * captured by the Application layer when orchestrating the transition. It is not
 * a business input from the caller; it is the Application Runtime's wall-clock at
 * the moment of validation.
 *
 * WHY the Handler no longer injects DomainEventCollectorPort:
 * Per ADR-SA-013 R-006 and R-010, the Repository is the sole caller of collect().
 *
 * Depends on: ClinicalContributionRepositoryPort, ContributionTimestamp.
 * Never depends on: Read Model Ports, Infrastructure implementations, any business rule.
 */
final class ValidateClinicalContributionHandler
{
    public function __construct(
        private readonly ClinicalContributionRepositoryPort $repository,
    ) {}

    public function __invoke(ValidateClinicalContribution $command): void
    {
        $contribution = $this->repository->retrieve($command->clinicalContributionId);

        $contribution->validate(ContributionTimestamp::now());

        $this->repository->persist($contribution);
    }
}
