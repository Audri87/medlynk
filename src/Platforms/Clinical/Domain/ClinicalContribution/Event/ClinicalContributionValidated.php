<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Event;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;

/**
 * Recorded when a Draft contribution passes all domain invariant checks.
 * Signals readiness for approval. Immutable fact.
 */
final readonly class ClinicalContributionValidated
{
    public function __construct(
        public readonly ClinicalContributionId $clinicalContributionId,
        public readonly CareRecordId $careRecordId,
        public readonly ContributionTimestamp $occurredAt,
    ) {}
}
