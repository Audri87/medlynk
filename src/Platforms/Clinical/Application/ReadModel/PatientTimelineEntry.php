<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\ReadModel;

/**
 * One entry in the Patient Timeline — a single approved Clinical Contribution.
 * Projection-derived. Read-only. Carries no aggregate state.
 */
final readonly class PatientTimelineEntry
{
    public function __construct(
        public readonly string $clinicalContributionId,
        public readonly string $clinicalText,
        public readonly string $contributingPractitionerId,
        public readonly string $status,
        public readonly \DateTimeImmutable $occurredAt,
    ) {}
}
