<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Command;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;

/**
 * Intent: trigger domain invariant validation on a Draft contribution.
 * Dispatched via command.bus → ValidateClinicalContributionHandler.
 * Immutable data carrier. No behaviour.
 */
final readonly class ValidateClinicalContribution
{
    public function __construct(
        public readonly ClinicalContributionId $clinicalContributionId,
    ) {}
}
