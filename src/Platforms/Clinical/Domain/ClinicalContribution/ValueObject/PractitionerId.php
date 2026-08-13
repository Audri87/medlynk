<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject;

use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\InvalidPractitionerIdException;

/**
 * Identifies a Practitioner within the Clinical Platform.
 *
 * Used for both contributing and approving roles: the same identity concept applies
 * regardless of the practitioner's position in the lifecycle. ContributorRoleType
 * captures the role; PractitionerId captures the identity.
 *
 * Why a Value Object: a Practitioner is a distinct actor. A raw string offers no
 * guarantee that the value represents a known practitioner — any string could
 * be passed where a practitioner identity is expected, making role enforcement impossible.
 *
 * Why immutable: practitioner identity recorded at a clinical moment (contribution,
 * approval) is an immutable historical fact. Retroactive modification would constitute
 * falsification of a clinical record.
 *
 * Why it protects the Domain: an unidentifiable practitioner cannot participate in a
 * clinical contribution. Format enforcement at construction ensures only valid identifiers
 * reach the Aggregate, enabling BI-003 and BI-007 to be enforced against known identities.
 */
final readonly class PractitionerId
{
    public function __construct(public readonly string $value)
    {
        if (!self::isValidUuidV4($value)) {
            throw new InvalidPractitionerIdException(
                sprintf('"%s" is not a valid UUID v4 identifier for Practitioner.', $value),
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
