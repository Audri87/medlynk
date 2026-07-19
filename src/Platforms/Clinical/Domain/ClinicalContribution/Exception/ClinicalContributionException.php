<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Exception;

/**
 * Base class for all domain exceptions in the ClinicalContribution bounded context.
 *
 * Extends \DomainException — PHP's semantic type for logic errors
 * that represent violations of domain invariants.
 *
 * All subclasses carry a specific business meaning.
 * No generic RuntimeException is used anywhere in the ClinicalContribution domain.
 */
abstract class ClinicalContributionException extends \DomainException {}
