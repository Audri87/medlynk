<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\ClinicalContribution\Exception;

/**
 * Thrown when a ContributionTimestamp is constructed with a non-UTC DateTimeImmutable.
 *
 * All clinical timestamps are stored in UTC to guarantee unambiguous
 * temporal ordering across time zones.
 * A timestamp in any other timezone violates this invariant.
 */
final class InvalidContributionTimestampException extends ClinicalContributionException {}
