<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence\Repository;

use App\Platforms\Clinical\Application\Port\ClinicalContributionRepositoryPort;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;
use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\ClinicalContributionNotFoundException;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Shared\Application\Port\DomainEventCollectorPort;
use Doctrine\DBAL\Connection;

/**
 * Repository implementation — Infrastructure layer.
 * Implements: ClinicalContributionRepositoryPort.
 *
 * Single responsibility: translate ClinicalContribution aggregate state
 * to and from its persistence representation, within the active Application transaction.
 *
 * Architectural guarantees (SA-007):
 *   — Persists exactly one Aggregate Root: ClinicalContribution (D-001).
 *   — Participates in the active transaction — does not own it (D-003).
 *   — Does not publish Domain Events (D-002).
 *   — Does not publish Integration Events (D-002).
 *   — Mapping delegated to ClinicalContributionMapper (D-006, ADR-SA-008 D-006).
 *
 * Invisible to Command Handlers — they depend on the Port, not this class.
 */
final class ClinicalContributionRepository implements ClinicalContributionRepositoryPort
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ClinicalContributionMapper $mapper,
        private readonly DomainEventCollectorPort $collector,
    ) {}

    public function persist(ClinicalContribution $contribution): void
    {
        $p = $this->mapper->toPersistence($contribution);

        $this->connection->executeStatement(
            'INSERT INTO clinical_contributions (
                id, care_record_id, status, clinical_text, recorded_at,
                contributing_practitioner_id, contributor_role,
                approving_practitioner_id, approved_at
            ) VALUES (
                :id, :care_record_id, :status, :clinical_text, :recorded_at,
                :contributing_practitioner_id, :contributor_role,
                :approving_practitioner_id, :approved_at
            )
            ON CONFLICT (id) DO UPDATE SET
                status                    = EXCLUDED.status,
                approving_practitioner_id = EXCLUDED.approving_practitioner_id,
                approved_at               = EXCLUDED.approved_at,
                updated_at                = NOW()',
            $p,
        );

        $this->collector->collect(...$contribution->releaseDomainEvents());
    }

    public function retrieve(ClinicalContributionId $id): ClinicalContribution
    {
        $row = $this->connection->fetchAssociative(
            'SELECT id, care_record_id, status, clinical_text, recorded_at,
                    contributing_practitioner_id, contributor_role,
                    approving_practitioner_id, approved_at
             FROM clinical_contributions
             WHERE id = :id',
            ['id' => $id->value],
        );

        if ($row === false) {
            throw new ClinicalContributionNotFoundException($id);
        }

        return $this->mapper->toDomain($row);
    }
}
