<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Event;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;

/**
 * Recorded when a Draft contribution fails one or more domain invariant checks.
 * The contribution remains in Draft. Immutable fact.
 */
final readonly class ClinicalContributionValidationFailed
{
    public function __construct(
        public readonly ClinicalContributionId $clinicalContributionId,
        public readonly CareRecordId $careRecordId,
        public readonly string $failureReason,
        public readonly ContributionTimestamp $occurredAt,
    ) {}
}
