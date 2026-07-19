<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Event;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\PractitionerId;

/**
 * Recorded when an authorized Practitioner approves a Validated contribution.
 * The contribution is immutable from this point. Immutable fact.
 */
final readonly class ClinicalContributionApproved
{
    public function __construct(
        public readonly ClinicalContributionId $clinicalContributionId,
        public readonly CareRecordId $careRecordId,
        public readonly PractitionerId $approvingPractitionerId,
        public readonly ContributionTimestamp $approvedAt,
    ) {}
}
