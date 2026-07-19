<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\ValueObject;

use App\Platforms\Clinical\Domain\ClinicalContribution\Exception\InvalidContributionTimestampException;

/**
 * A UTC-enforced timestamp representing any moment in the contribution lifecycle.
 *
 * Why a Value Object: a plain DateTimeImmutable carries no guarantee of timezone
 * consistency. Two timestamps in different timezones compare incorrectly without
 * prior normalisation. This VO enforces UTC at construction so all timestamps in
 * the Domain are unconditionally and correctly comparable.
 *
 * Why immutable: a clinical moment — when a contribution was created, validated,
 * or approved — is a historical fact. It cannot be revised. DateTimeImmutable
 * guarantees no mutation; this VO adds the UTC invariant on top.
 *
 * Why it protects the Domain: without UTC enforcement, a contribution recorded
 * at 14:00 Europe/Paris and another at 14:00 America/New_York would appear
 * temporally equal yet be six hours apart. In a clinical record, temporal ordering
 * is safety-critical. The Domain must be immune to timezone ambiguity.
 */
final readonly class ContributionTimestamp
{
    public function __construct(public readonly \DateTimeImmutable $value)
    {
        if ($this->value->getTimezone()->getName() !== 'UTC') {
            throw new InvalidContributionTimestampException(
                sprintf(
                    'ContributionTimestamp requires UTC. Timezone "%s" was provided. '
                    . 'Construct with: new \DateTimeImmutable(\'now\', new \DateTimeZone(\'UTC\')).',
                    $this->value->getTimezone()->getName(),
                ),
            );
        }
    }

    /**
     * Convenience factory for the current UTC moment.
     *
     * The Application layer SHOULD prefer passing an explicit timestamp
     * to support deterministic testing. Use this factory only when the current
     * wall-clock time is the intended value and no external clock is available.
     */
    public static function now(): self
    {
        return new self(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
    }
}
