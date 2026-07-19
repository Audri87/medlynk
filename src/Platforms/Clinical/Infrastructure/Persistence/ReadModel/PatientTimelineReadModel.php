<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence\ReadModel;

use App\Platforms\Clinical\Application\Port\PatientTimelineReadModelPort;
use App\Platforms\Clinical\Application\ReadModel\PatientTimelineView;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\CareRecordId;

/**
 * Read Model implementation — Infrastructure layer.
 * Implements: PatientTimelineReadModelPort.
 *
 * Single responsibility: read the Patient Timeline from the Read Model store
 * and return a PatientTimelineView.
 *
 * Store is independent from the Aggregate Persistence store (SA-007 I-011, §10.3).
 * This class has no write authority — written exclusively by PatientTimelineProjection (SA-007 §10.4).
 */
final class PatientTimelineReadModel implements PatientTimelineReadModelPort
{
    public function getTimeline(CareRecordId $careRecordId, int $pageSize, ?string $pageToken): PatientTimelineView
    {
        throw new \LogicException('Not yet implemented.');
    }
}
