<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence\ReadModel;

use App\Platforms\Clinical\Application\Port\ClinicalContributionDetailReadModelPort;
use App\Platforms\Clinical\Application\ReadModel\ClinicalContributionDetailView;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;

/**
 * Read Model implementation — Infrastructure layer.
 * Implements: ClinicalContributionDetailReadModelPort.
 *
 * Single responsibility: read Clinical Contribution detail from the Read Model store
 * and return a ClinicalContributionDetailView.
 *
 * Store is independent from the Aggregate Persistence store (SA-007 I-011, §10.3).
 * Written exclusively by ClinicalContributionDetailProjection (SA-007 §10.4).
 */
final class ClinicalContributionDetailReadModel implements ClinicalContributionDetailReadModelPort
{
    public function getDetail(ClinicalContributionId $id): ClinicalContributionDetailView
    {
        throw new \LogicException('Not yet implemented.');
    }
}
