<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\CommandHandler;

use App\Platforms\Clinical\Application\Command\ValidateClinicalContribution;
use App\Platforms\Clinical\Application\Port\ClinicalContributionRepositoryPort;
use App\Platforms\Clinical\Application\Port\DomainEventCollectorPort;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;

/**
 * Command Handler — UC-002: Validate Clinical Contribution.
 *
 * Single responsibility: execute the Validate use case within exactly one transaction
 * boundary owned by the Application Runtime (SA-007 §6.2, SA-005 D-003).
 *
 * Execution sequence (RVS-001 §10 ValidateClinicalContributionHandler):
 *  1. Runtime opens transaction.
 *  2. Handler retrieves ClinicalContribution via repository.retrieve().
 *  3. Handler calls aggregate.validate(validatedAt).
 *  4. Aggregate enforces BI-004 (status must be Draft) — throws if violated.
 *  5. Aggregate records ClinicalContributionValidated (or ClinicalContributionValidationFailed).
 *  6. Handler calls repository.persist() — updated aggregate state written within transaction.
 *  7. Handler calls eventCollector.collect() — events held for post-commit publication.
 *  8. Runtime commits transaction.
 *  9. Infrastructure publishes events post-commit (PR-004).
 *
 * WHY the Handler generates validatedAt rather than receiving it in the Command:
 * The validation timestamp is "the moment this use case executes" — a temporal fact
 * captured by the Application layer when orchestrating the transition. It is not
 * a business input from the caller; it is the Application Runtime's wall-clock at
 * the moment of validation. ContributionTimestamp::now() is the correct source.
 * The caller has no business reason to supply a backdated validation timestamp.
 *
 * WHY this Handler does not implement validation logic:
 * All validation logic lives inside ClinicalContribution.validate(). The Handler
 * supplies the timestamp and delegates entirely. If validate() throws a domain exception,
 * the exception propagates through the transaction boundary, which the Runtime rolls back.
 * No catch block is needed here — exception propagation is the intended control flow.
 *
 * Depends on: ClinicalContributionRepositoryPort, DomainEventCollectorPort, ContributionTimestamp.
 * Never depends on: Read Model Ports, Infrastructure implementations, any business rule.
 */
final class ValidateClinicalContributionHandler
{
    public function __construct(
        private readonly ClinicalContributionRepositoryPort $repository,
        private readonly DomainEventCollectorPort $eventCollector,
    ) {}

    public function __invoke(ValidateClinicalContribution $command): void
    {
        $contribution = $this->repository->retrieve($command->clinicalContributionId);

        $contribution->validate(ContributionTimestamp::now());

        $this->repository->persist($contribution);
        $this->eventCollector->collect($contribution->pullPendingEvents());
    }
}
