<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Infrastructure\Persistence\Repository;

use App\Platforms\Clinical\Application\Port\ClinicalContributionRepositoryPort;
use App\Platforms\Clinical\Domain\ClinicalContribution\ClinicalContribution;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;

/**
 * Repository implementation — Infrastructure layer.
 * Implements: ClinicalContributionRepositoryPort.
 *
 * Single responsibility: translate ClinicalContribution aggregate state
 * to and from its persistence representation, within the active Application transaction.
 *
 * Architectural guarantees (SA-007):
 *   — Persists exactly one Aggregate Root: ClinicalContribution (I-001, I-002).
 *   — Participates in the active transaction — does not own it (I-007).
 *   — Does not publish Domain Events (I-003).
 *   — Does not publish Integration Events (I-004).
 *   — Mapping logic confined to this Infrastructure class (I-010).
 *   — Concurrency control coordinated within Infrastructure layer (I-009).
 *
 * Invisible to Command Handlers — they depend on the Port, not this class.
 */
final class ClinicalContributionRepository implements ClinicalContributionRepositoryPort
{
    public function retrieve(ClinicalContributionId $id): ClinicalContribution
    {
        throw new \LogicException('Not yet implemented.');
    }

    public function persist(ClinicalContribution $contribution): void
    {
        throw new \LogicException('Not yet implemented.');
    }
}
