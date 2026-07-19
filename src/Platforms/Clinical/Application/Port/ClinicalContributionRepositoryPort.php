<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Port;

use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;

/**
 * Persistence contract for the ClinicalContribution Aggregate Root.
 * Defined in the Application layer as a port — implemented in Infrastructure.
 *
 * Exposes only retrieve and persist. No search. No collection. No read-oriented operations.
 * Behaviour when the aggregate is not found: pending OD-002 resolution.
 *
 * SA-007 I-013, I-014.
 */
interface ClinicalContributionRepositoryPort
{
    public function retrieve(ClinicalContributionId $id): ClinicalContribution;

    public function persist(ClinicalContribution $contribution): void;
}
