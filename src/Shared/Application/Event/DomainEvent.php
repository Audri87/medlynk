<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

/**
 * Technical transport interface for Domain Events.
 *
 * NOT a Kernel concept. NOT a BusinessEvent.
 * Carries a Domain Event through the event.bus after the transaction commits.
 * The Domain layer has no knowledge of this interface.
 */
interface DomainEvent
{
    public function occurredAt(): \DateTimeImmutable;
}
