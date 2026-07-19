<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence\Projection;

use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionApproved;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionCreated;
use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionValidated;

/**
 * Projection — Infrastructure layer.
 *
 * Single responsibility: maintain the Patient Timeline Read Model
 * by consuming Clinical Contribution Domain Events.
 *
 * Sole writer to the Patient Timeline Read Model store (SA-007 §10.4, SA-006 §12.6).
 * Applies idempotency check before processing each event (SA-006 §9).
 * Independently replayable — store is separate from Aggregate Persistence store (SA-007 §10.5).
 * Failure does not affect other Projections or Aggregate state (SA-006 §12.2).
 *
 * NEVER depends on: ClinicalContributionRepositoryPort, Application Handlers,
 *                   other Projections, Domain Services.
 *
 * Consumes:
 *   — ClinicalContributionCreated  → appends pending entry
 *   — ClinicalContributionValidated → updates entry to Validated
 *   — ClinicalContributionApproved  → updates entry to Approved; marks visible
 */
final class PatientTimelineProjection
{
    public function onClinicalContributionCreated(ClinicalContributionCreated $event): void
    {
        throw new \LogicException('Not yet implemented.');
    }

    public function onClinicalContributionValidated(ClinicalContributionValidated $event): void
    {
        throw new \LogicException('Not yet implemented.');
    }

    public function onClinicalContributionApproved(ClinicalContributionApproved $event): void
    {
        throw new \LogicException('Not yet implemented.');
    }
}
