<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\QueryHandler;

use App\Platforms\Clinical\Application\Port\PatientTimelineReadModelPort;
use App\Platforms\Clinical\Application\Query\GetPatientTimeline;
use App\Platforms\Clinical\Application\ReadModel\PatientTimelineView;

/**
 * Query Handler — UC-004: Query Patient Timeline.
 *
 * Single responsibility: retrieve the Patient Timeline View from the Read Model.
 * No transaction required. No side effects. No state mutation.
 *
 * Depends on: PatientTimelineReadModelPort only.
 * NEVER depends on: ClinicalContributionRepositoryPort (SA-007 I-012).
 */
final class GetPatientTimelineHandler
{
    public function __construct(
        private readonly PatientTimelineReadModelPort $readModel,
    ) {}

    /**
     * WHY this Handler accesses PatientTimelineReadModelPort and NOT ClinicalContributionRepositoryPort:
     * The Patient Timeline is a Read Model — a pre-computed projection derived from Domain Events.
     * Loading the ClinicalContribution aggregates from the Repository to build a timeline at query
     * time would be: (a) a CQRS violation (SA-007 I-012), (b) catastrophically expensive at scale,
     * and (c) architecturally wrong — the Repository exists to serve Command Handlers, not read views.
     * The Projection maintains the Read Model; this Handler reads from it. Concerns are separated.
     *
     * WHY no transaction is required:
     * Queries carry no side effects and mutate no state. No transaction boundary is needed.
     * The query.bus is configured without the doctrine_transaction middleware (SA-004 §bus config).
     *
     * WHY the Handler does not filter, sort, or transform the result:
     * The Read Model port returns a pre-shaped PatientTimelineView. Any filtering or sorting
     * belongs in the Projection that builds the Read Model — not in the Query Handler.
     * The Handler is a thin dispatcher: it passes the query parameters through and returns
     * the result without transformation. Business presentation decisions belong elsewhere.
     */
    public function __invoke(GetPatientTimeline $query): PatientTimelineView
    {
        return $this->readModel->getTimeline(
            $query->careRecordId,
            $query->pageSize,
            $query->pageToken,
        );
    }
}
