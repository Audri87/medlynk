<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Command;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\PractitionerId;

/**
 * Intent: formally approve a Validated contribution.
 * Dispatched via command.bus → ApproveClinicalContributionHandler.
 * Immutable data carrier. No behaviour.
 */
final readonly class ApproveClinicalContribution
{
    public function __construct(
        public readonly ClinicalContributionId $clinicalContributionId,
        public readonly PractitionerId $approvingPractitionerId,
        public readonly ContributionTimestamp $approvedAt,
    ) {}
}
