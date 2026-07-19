<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject;

/**
 * Captures who approved a contribution and at what moment.
 * Atomic — approver identity and approval timestamp are inseparable. Immutable.
 */
final readonly class ApprovalReference
{
    public function __construct(
        public readonly PractitionerId $approvingPractitionerId,
        public readonly ContributionTimestamp $approvedAt,
    ) {}
}
