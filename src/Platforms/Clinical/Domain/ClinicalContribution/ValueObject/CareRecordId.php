<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject;

use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\InvalidCareRecordIdException;

/**
 * Reference to the Care Record that receives this Clinical Contribution.
 * Cross-aggregate reference — this VO never causes the CareRecord to be loaded.
 *
 * Why a Value Object: a Care Record is a distinct aggregate. Referencing it by a
 * plain string removes type-safe navigation and makes the cross-aggregate relationship
 * invisible to the type system.
 *
 * Why immutable: a contribution belongs to exactly one Care Record for its entire
 * lifetime. Reassigning the reference would sever the contribution from its patient
 * context — a clinical safety invariant.
 *
 * Why it protects the Domain: a malformed UUID cannot represent a Care Record.
 * Enforcing format at construction prevents contributions from referencing nothing.
 */
final readonly class CareRecordId
{
    public function __construct(public readonly string $value)
    {
        if (!self::isValidUuidV4($value)) {
            throw new InvalidCareRecordIdException(
                sprintf('"%s" is not a valid UUID v4 identifier for CareRecord.', $value),
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
