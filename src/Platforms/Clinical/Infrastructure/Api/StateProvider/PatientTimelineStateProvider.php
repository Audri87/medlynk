<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Api\StateProvider;

use App\Platforms\Clinical\Application\ClinicalContributionFacade;

/**
 * API Platform State Provider — Infrastructure layer, Presentation boundary.
 *
 * Single responsibility: translate HTTP read requests into Queries
 * and dispatch them through the ClinicalContributionFacade.
 *
 * HTTP layer only. No business logic. No persistence. No domain knowledge.
 * Depends on: ClinicalContributionFacade (Application layer).
 * Does not depend on: Domain classes, Repository, Projections, Read Model implementations.
 */
final class PatientTimelineStateProvider
{
    public function __construct(
        private readonly ClinicalContributionFacade $facade,
    ) {}

    public function provide(array $uriVariables = [], array $context = []): object
    {
        throw new \LogicException('Not yet implemented.');
    }
}
