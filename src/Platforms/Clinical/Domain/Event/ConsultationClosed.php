<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\Event;

/**
 * ConsultationClosed — Clinical Platform Domain Event.
 *
 * Internal to the Clinical Platform.
 * Does NOT implement BusinessEvent — no cross-platform significance.
 * Used to update Clinical projections only.
 */
final class ConsultationClosed
{
    public function __construct(
        public readonly string $consultationId,
        public readonly string $patientId,
        public readonly string $practitionerId,
        public readonly \DateTimeImmutable $occurredAt,
    ) {}
}
