<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject;

/**
 * Lifecycle states of a ClinicalContribution. Transitions: Draft → Validated → Approved.
 * An Approved contribution is immutable — no further transitions are permitted.
 */
enum ContributionStatus
{
    case Draft;
    case Validated;
    case Approved;
}
