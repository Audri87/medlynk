<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Exception;

/**
 * Thrown when a ClinicalContributionId is constructed from a value
 * that does not conform to the UUID v4 format.
 *
 * An invalid identifier can never reach the Aggregate.
 */
final class InvalidClinicalContributionIdException extends ClinicalContributionException {}
