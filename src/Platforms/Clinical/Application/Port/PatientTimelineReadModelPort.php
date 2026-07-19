<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Port;

use App\Platforms\Clinical\Application\ReadModel\PatientTimelineView;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;

/**
 * Retrieval contract for the Patient Timeline Read Model.
 * Read-only. No write operations. Implemented in Infrastructure.
 * Accessed exclusively by GetPatientTimelineHandler — never by Command Handlers.
 *
 * SA-007 I-012, I-014.
 */
interface PatientTimelineReadModelPort
{
    public function getTimeline(CareRecordId $careRecordId, int $pageSize, ?string $pageToken): PatientTimelineView;
}
