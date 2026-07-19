<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Query;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;

/**
 * Intent: retrieve the ordered timeline of contributions for one Care Record.
 * Dispatched via query.bus → GetPatientTimelineHandler.
 * No side effects. Immutable data carrier.
 */
final readonly class GetPatientTimeline
{
    public function __construct(
        public readonly CareRecordId $careRecordId,
        public readonly int $pageSize,
        public readonly ?string $pageToken,
    ) {}
}
