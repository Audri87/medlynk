<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Domain\Event;

use App\Kernel\Domain\Event\BusinessEvent;

/**
 * PatientRegistered — Clinical Platform Domain Event.
 *
 * Implements BusinessEvent because patient registration
 * has cross-platform significance (Identity, Trust, Collaboration).
 */
final class PatientRegistered implements BusinessEvent
{
    public function __construct(
        public readonly string $patientId,
        public readonly string $givenName,
        public readonly string $familyName,
        private readonly \DateTimeImmutable $occurredAt,
    ) {}

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
