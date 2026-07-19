<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Event;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalText;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\PractitionerId;

/**
 * Recorded when a new Clinical Contribution is created in Draft state.
 * Immutable fact. Carries only projection-relevant data.
 */
final readonly class ClinicalContributionCreated
{
    public function __construct(
        public readonly ClinicalContributionId $clinicalContributionId,
        public readonly CareRecordId $careRecordId,
        public readonly PractitionerId $contributingPractitionerId,
        public readonly ClinicalText $clinicalText,
        public readonly ContributionTimestamp $occurredAt,
    ) {}
}
