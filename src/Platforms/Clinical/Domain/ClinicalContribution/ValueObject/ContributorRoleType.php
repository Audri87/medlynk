<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject;

/**
 * The role held by the Practitioner at the moment of contribution — per ADR-0007.
 * Vocabulary is domain-certified. No other values are permitted.
 */
enum ContributorRoleType
{
    case PrimaryPractitioner;
    case ConsultingPractitioner;
    case SupervisingPractitioner;
}
