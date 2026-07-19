<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\ReadModel;

/**
 * Query result: full detail of one Clinical Contribution.
 * Projection-derived. Read-only. Returned by GetClinicalContributionDetailHandler.
 * Never sourced from a Repository — sourced from ClinicalContributionDetailReadModelPort exclusively.
 */
final readonly class ClinicalContributionDetailView
{
    public function __construct(
        public readonly string $clinicalContributionId,
        public readonly string $careRecordId,
        public readonly string $clinicalText,
        public readonly string $contributingPractitionerId,
        public readonly string $status,
        public readonly ?string $approvingPractitionerId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly ?\DateTimeImmutable $approvedAt,
    ) {}
}
