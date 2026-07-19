<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Exception;

/**
 * Thrown when a CareRecordId is constructed from a value
 * that does not conform to the UUID v4 format.
 *
 * A contribution cannot reference a malformed Care Record.
 */
final class InvalidCareRecordIdException extends ClinicalContributionException {}
