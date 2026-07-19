<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence\Projection;

use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionApproved;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionCreated;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionValidated;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionValidationFailed;

/**
 * Projection — Infrastructure layer.
 *
 * Single responsibility: maintain the Clinical Contribution Detail Read Model.
 *
 * Sole writer to the Clinical Contribution Detail Read Model store.
 * Applies idempotency check before processing each event (SA-006 §9).
 * Independently replayable (SA-007 §10.5).
 *
 * Consumes:
 *   — ClinicalContributionCreated          → creates detail record (Draft)
 *   — ClinicalContributionValidated        → updates status to Validated
 *   — ClinicalContributionValidationFailed → records failure reason
 *   — ClinicalContributionApproved         → updates status to Approved
 */
final class ClinicalContributionDetailProjection
{
    public function onClinicalContributionCreated(ClinicalContributionCreated $event): void
    {
        throw new \LogicException('Not yet implemented.');
    }

    public function onClinicalContributionValidated(ClinicalContributionValidated $event): void
    {
        throw new \LogicException('Not yet implemented.');
    }

    public function onClinicalContributionValidationFailed(ClinicalContributionValidationFailed $event): void
    {
        throw new \LogicException('Not yet implemented.');
    }

    public function onClinicalContributionApproved(ClinicalContributionApproved $event): void
    {
        throw new \LogicException('Not yet implemented.');
    }
}
