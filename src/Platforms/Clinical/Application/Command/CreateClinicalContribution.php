<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Command;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalText;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributorRoleType;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\PractitionerId;

/**
 * Intent: record a new Clinical Contribution in Draft state.
 * Dispatched via command.bus → CreateClinicalContributionHandler.
 * Immutable data carrier. No behaviour.
 *
 * WHY the caller supplies ClinicalContributionId:
 * The client (API State Processor) generates the UUID before dispatching.
 * This enables command idempotency: the same command ID always produces
 * the same aggregate identity. The Handler does not generate IDs — ID
 * generation is a caller responsibility, not an Application-layer responsibility.
 *
 * WHY ContributorRoleType is in the Command:
 * The practitioner's role at contribution time is part of the create intent
 * (ADR-0007 — Roles on Relations). The Handler cannot derive it from context;
 * it is supplied by the caller as part of their explicit clinical act.
 */
final readonly class CreateClinicalContribution
{
    public function __construct(
        public readonly ClinicalContributionId $clinicalContributionId,
        public readonly CareRecordId $careRecordId,
        public readonly PractitionerId $contributingPractitionerId,
        public readonly ContributorRoleType $contributorRoleType,
        public readonly ClinicalText $clinicalText,
        public readonly ContributionTimestamp $requestedAt,
    ) {}
}
