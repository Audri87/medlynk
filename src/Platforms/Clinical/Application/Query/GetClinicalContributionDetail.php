<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Query;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;

/**
 * Intent: retrieve the full detail of one Clinical Contribution.
 * Dispatched via query.bus → GetClinicalContributionDetailHandler.
 * No side effects. Immutable data carrier.
 */
final readonly class GetClinicalContributionDetail
{
    public function __construct(
        public readonly ClinicalContributionId $clinicalContributionId,
    ) {}
}
