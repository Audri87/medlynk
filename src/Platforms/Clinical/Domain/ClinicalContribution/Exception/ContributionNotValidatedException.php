<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Exception;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionStatus;

/**
 * Thrown when approve() is called on a contribution that is not in Validated state.
 *
 * Protects BI-005: approval may only be attempted when status is Validated.
 * Protects BI-006 (partially): an Approved contribution cannot be re-approved.
 *
 * Clinical approval is a formal endorsement. Approving a Draft contribution
 * — which has not passed domain invariant checks — would violate clinical safety.
 */
final class ContributionNotValidatedException extends ClinicalContributionException
{
    public function __construct(ClinicalContributionId $id, ContributionStatus $currentStatus)
    {
        parent::__construct(sprintf(
            'ClinicalContribution %s cannot be approved: current status is %s, expected Validated.',
            $id->value,
            $currentStatus->name,
        ));
    }
}
