<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject;

use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\InvalidClinicalTextException;

/**
 * The structured clinical payload of a contribution.
 *
 * Why a Value Object: clinical text is not an arbitrary string — it is a domain
 * concept with explicit quality constraints. A plain string parameter offers no
 * guarantee that the content meets those constraints. This VO enforces them at the
 * domain boundary before any content reaches the Aggregate.
 *
 * Why immutable: a clinical record is a statement of fact at a moment in time.
 * Permitting post-creation mutation would compromise the integrity of the clinical
 * record. If content must change, a new contribution is the correct domain model.
 *
 * Why it protects the Domain:
 *  — Empty clinical text is clinically meaningless (BI-001).
 *  — Unbounded content length introduces uncontrolled growth in clinical records.
 *  Both are rejected at construction; no invalid content can reach the Aggregate.
 *
 * MAX_LENGTH is a domain constant, not an infrastructure concern.
 * 10,000 characters accommodates extended clinical notes while bounding growth.
 * Infrastructure storage decisions must respect this bound, never the inverse.
 */
final readonly class ClinicalText
{
    public const MAX_LENGTH = 10_000;

    public function __construct(public readonly string $value)
    {
        if (trim($value) === '') {
            throw new InvalidClinicalTextException(
                'Clinical text must not be empty. A contribution must carry substantive content (BI-001).',
            );
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new InvalidClinicalTextException(
                sprintf(
                    'Clinical text exceeds the maximum allowed length of %d characters (%d provided).',
                    self::MAX_LENGTH,
                    mb_strlen($value),
                ),
            );
        }
    }
}
