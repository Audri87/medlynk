<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messenger;

use App\Shared\Application\Port\DomainEventCollectorPort;
use App\Shared\Domain\Event\DomainEventInterface;

/**
 * In-memory Domain Event collector.
 *
 * Holds Domain Events between the Repository's collect() call and the
 * DomainEventPublisherMiddleware's flush() call, both of which occur inside
 * the same doctrine_transaction.
 *
 * Registered as a singleton service. The Repository and the Middleware
 * reference the same instance within a single request lifecycle.
 *
 * If the transaction rolls back, the middleware propagates the exception
 * before reaching the flush loop — events are never enveloped or persisted
 * to the Outbox for a rolled-back transaction.
 *
 * Thread safety: PHP is single-threaded per request. No locking needed.
 */
final class DomainEventCollector implements DomainEventCollectorPort
{
    /** @var DomainEventInterface[] */
    private array $collected = [];

    public function collect(DomainEventInterface ...$events): void
    {
        foreach ($events as $event) {
            $this->collected[] = $event;
        }
    }

    /**
     * @return DomainEventInterface[]
     */
    public function flush(): array
    {
        $events = $this->collected;
        $this->collected = [];

        return $events;
    }
}
