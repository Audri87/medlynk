<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Exception;

/**
 * Thrown when a PractitionerId is constructed from a value
 * that does not conform to the UUID v4 format.
 *
 * An unidentifiable practitioner cannot be a contributor or approver.
 */
final class InvalidPractitionerIdException extends ClinicalContributionException {}
