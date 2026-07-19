<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Port;

use App\Platforms\Clinical\Application\ReadModel\ClinicalContributionDetailView;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;

/**
 * Retrieval contract for the Clinical Contribution Detail Read Model.
 * Read-only. No write operations. Implemented in Infrastructure.
 * Accessed exclusively by GetClinicalContributionDetailHandler.
 *
 * SA-007 I-012, I-014.
 */
interface ClinicalContributionDetailReadModelPort
{
    public function getDetail(ClinicalContributionId $id): ClinicalContributionDetailView;
}
