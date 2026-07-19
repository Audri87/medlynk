<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\QueryHandler;

use App\Platforms\Clinical\Application\Port\ClinicalContributionDetailReadModelPort;
use App\Platforms\Clinical\Application\Query\GetClinicalContributionDetail;
use App\Platforms\Clinical\Application\ReadModel\ClinicalContributionDetailView;

/**
 * Query Handler — UC-004 (detail): Query Clinical Contribution Detail.
 *
 * Single responsibility: retrieve the Clinical Contribution Detail View from the Read Model.
 * No transaction required. No side effects. No state mutation.
 *
 * Depends on: ClinicalContributionDetailReadModelPort only.
 * NEVER depends on: ClinicalContributionRepositoryPort (SA-007 I-012).
 */
final class GetClinicalContributionDetailHandler
{
    public function __construct(
        private readonly ClinicalContributionDetailReadModelPort $readModel,
    ) {}

    /**
     * WHY this Handler uses ClinicalContributionDetailReadModelPort and NOT the Repository:
     * A detail view is a pre-shaped Read Model maintained by ClinicalContributionDetailProjection.
     * Loading the ClinicalContribution aggregate from the Repository to serve a read request
     * violates SA-007 I-012 (Query Handlers must never access Repository Ports), exposes
     * aggregate internals to the presentation layer, and forces aggregate reconstruction
     * for a read-only operation. The Read Model port returns exactly the shape the caller needs.
     *
     * WHY no transaction is required:
     * This handler performs no state mutation. No transaction boundary is opened (SA-004).
     *
     * WHY the Handler is three lines:
     * The Handler's role is dispatch: translate the query object into a port call and return
     * the result. Any logic beyond that would be misplaced. If filtering or transformation
     * is needed, it belongs in the Read Model implementation (Infrastructure), not here.
     */
    public function __invoke(GetClinicalContributionDetail $query): ClinicalContributionDetailView
    {
        return $this->readModel->getDetail($query->clinicalContributionId);
    }
}
