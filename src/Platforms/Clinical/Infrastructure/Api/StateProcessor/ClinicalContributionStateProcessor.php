<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Api\StateProcessor;

use App\Platforms\Clinical\Application\ClinicalContributionFacade;
use App\Platforms\Clinical\Infrastructure\Api\Resource\ClinicalContributionResource;

/**
 * API Platform State Processor — Infrastructure layer, Presentation boundary.
 *
 * Single responsibility: translate HTTP write requests into Commands
 * and dispatch them through the ClinicalContributionFacade.
 *
 * HTTP layer only. No business logic. No persistence. No domain knowledge.
 * Depends on: ClinicalContributionFacade (Application layer).
 * Does not depend on: Domain classes, Repository, Projections.
 */
final class ClinicalContributionStateProcessor
{
    public function __construct(
        private readonly ClinicalContributionFacade $facade,
    ) {}

    public function process(ClinicalContributionResource $data, array $context = []): void
    {
        throw new \LogicException('Not yet implemented.');
    }
}
