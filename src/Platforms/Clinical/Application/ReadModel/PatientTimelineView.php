<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\ReadModel;

/**
 * Query result: the ordered timeline of clinical contributions for one Care Record.
 * Projection-derived. Read-only. Returned by GetPatientTimelineHandler.
 * Never sourced from a Repository — sourced from PatientTimelineReadModelPort exclusively.
 */
final readonly class PatientTimelineView
{
    /**
     * @param PatientTimelineEntry[] $entries
     */
    public function __construct(
        public readonly string $careRecordId,
        public readonly array $entries,
        public readonly ?string $nextPageToken,
    ) {}
}
