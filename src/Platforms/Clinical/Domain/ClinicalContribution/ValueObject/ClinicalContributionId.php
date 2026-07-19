<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject;

use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\InvalidClinicalContributionIdException;

/**
 * Unique identity of a ClinicalContribution aggregate.
 *
 * Why a Value Object: a raw string gives no type-safe guarantee that a given value
 * represents a contribution identity. Wrapping it forces all callers to name their intent.
 *
 * Why immutable: aggregate identity is established once and never changes.
 * Changing an identity mid-lifecycle would corrupt all downstream projections
 * and external references to that aggregate.
 *
 * Why it protects the Domain: an invalid UUID — or any arbitrary string — can never
 * be accepted as an aggregate identity. Enforcement at construction means the Domain
 * never processes a malformed identifier.
 */
final readonly class ClinicalContributionId
{
    public function __construct(public readonly string $value)
    {
        if (!self::isValidUuidV4($value)) {
            throw new InvalidClinicalContributionIdException(
                sprintf('"%s" is not a valid UUID v4 identifier for ClinicalContribution.', $value),
            );
        }
    }

    private static function isValidUuidV4(string $value): bool
    {
        return (bool) preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $value,
        );
    }
}
