<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution;

use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ClinicalText;
use App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject\ContributionTimestamp;

/**
 * Entity within the ClinicalContribution aggregate.
 *
 * Single responsibility: hold the structured clinical payload of one contribution —
 * the textual content and the timestamp at which it was recorded.
 *
 * No independent lifecycle. Not persisted separately. Owned exclusively by
 * ClinicalContribution; it is created and destroyed with the Aggregate.
 *
 * Why an Entity and not a Value Object: ClinicalContent occupies a position within
 * the Aggregate (it is not interchangeable with another ClinicalContent carrying
 * the same values). Its identity is its position within the owning Aggregate.
 *
 * Getters are exposed for the Aggregate's use in Domain Event construction and
 * for the Infrastructure layer's persistence mapping. No setter methods exist.
 */
final class ClinicalContent
{
    public function __construct(
        private readonly ClinicalText $text,
        private readonly ContributionTimestamp $recordedAt,
    ) {}

    public function getText(): ClinicalText
    {
        return $this->text;
    }

    public function getRecordedAt(): ContributionTimestamp
    {
        return $this->recordedAt;
    }
}
