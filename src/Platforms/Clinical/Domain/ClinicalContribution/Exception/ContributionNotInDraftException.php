<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Exception;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalContributionId;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionStatus;

/**
 * Thrown when validate() is called on a contribution that is not in Draft state.
 *
 * Protects BI-004: validation may only be attempted when status is Draft.
 *
 * This exception communicates a caller error in the business workflow —
 * the application attempted a state transition out of sequence.
 */
final class ContributionNotInDraftException extends ClinicalContributionException
{
    public function __construct(ClinicalContributionId $id, ContributionStatus $currentStatus)
    {
        parent::__construct(sprintf(
            'ClinicalContribution %s cannot be validated: current status is %s, expected Draft.',
            $id->value,
            $currentStatus->name,
        ));
    }
}
