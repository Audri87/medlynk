<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Exception;

/**
 * Thrown when a ClinicalText fails domain content invariants.
 *
 * Covers two distinct violations:
 *  — empty text after normalisation (BI-001)
 *  — text exceeding the domain-defined maximum length
 *
 * A contribution cannot carry clinically meaningless or unbounded content.
 */
final class InvalidClinicalTextException extends ClinicalContributionException {}
