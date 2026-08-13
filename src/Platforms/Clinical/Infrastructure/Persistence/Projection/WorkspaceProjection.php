<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence\Projection;

use App\Platforms\Clinical\Domain\ClinicalContribution\Event\ClinicalContributionApproved;

/**
 * Projection — Clinical Platform, Infrastructure layer.
 *
 * Single responsibility: refresh the Practitioner Workspace Read Model
 * when a Clinical Contribution is approved.
 *
 * Consumes ClinicalContributionApproved from the Internal Event Bus.
 * Intra-platform consumer — no Platform boundary crossed (ADR-0014 compliant).
 *
 * Sole writer to the Practitioner Workspace Read Model store.
 * Independently replayable (SA-007 §10.5).
 * Failure does not affect PatientTimelineProjection or ClinicalContributionDetailProjection.
 */
final class WorkspaceProjection
{
    public function onClinicalContributionApproved(ClinicalContributionApproved $event): void
    {
        throw new \LogicException('Not yet implemented.');
    }
}
