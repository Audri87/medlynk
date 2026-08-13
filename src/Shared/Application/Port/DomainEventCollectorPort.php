<?php

declare(strict_types=1);

namespace App\Shared\Application\Port;

use App\Shared\Domain\Event\DomainEventInterface;

/**
 * Cross-platform port for Domain Event collection.
 *
 * The Repository calls collect() immediately after persisting an Aggregate,
 * passing the events returned by Aggregate::releaseDomainEvents().
 *
 * The DomainEventPublisherMiddleware calls flush() after the command handler
 * returns, still inside the active doctrine_transaction. The middleware then
 * wraps each event in an EventEnvelope and writes it to the Outbox.
 *
 * Implemented by: Shared/Infrastructure/Messenger/DomainEventCollector
 *
 * ADR-SA-013 R-006 through R-008.
 */
interface DomainEventCollectorPort
{
    public function collect(DomainEventInterface ...$events): void;

    /**
     * Returns all collected Domain Events in insertion order and clears the buffer.
     *
     * Called by DomainEventPublisherMiddleware inside the active transaction.
     *
     * @return DomainEventInterface[]
     */
    public function flush(): array;
}
