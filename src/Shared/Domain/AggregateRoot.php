<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Event\DomainEventInterface;

/**
 * Base class for all Aggregate Roots in MedLink.
 *
 * Provides the Domain Event recording mechanism shared by every platform.
 * Subclasses MUST NOT redefine record() or releaseDomainEvents().
 *
 * Invariants (ADR-SA-013 R-005a):
 *   — releaseDomainEvents() returns events in FIFO order.
 *   — The internal collection is cleared immediately after the call.
 *   — A subsequent call without newly recorded events returns an empty array.
 *   — Events are recorded via record() — only callable from within the Aggregate.
 *
 * Usage:
 *   Subclasses call $this->record(new SomeDomainEvent(...)) inside business methods.
 *   The Repository calls $aggregate->releaseDomainEvents() after persist().
 */
abstract class AggregateRoot
{
    /** @var DomainEventInterface[] */
    private array $recordedDomainEvents = [];

    /**
     * Records a Domain Event produced by a business operation.
     *
     * Called exclusively by the Aggregate Root's own business methods.
     * MUST NOT be called from outside the Aggregate.
     *
     * Events are stored in insertion order and released atomically
     * by releaseDomainEvents() after the Aggregate is persisted.
     */
    final protected function record(DomainEventInterface $event): void
    {
        $this->recordedDomainEvents[] = $event;
    }

    /**
     * Returns all Domain Events recorded since the previous release and clears the collection.
     *
     * Called exclusively by the Repository after a successful persist().
     * The returned events are forwarded to DomainEventCollectorPort for post-commit publication.
     *
     * FIFO order is preserved. A second invocation without newly recorded events
     * returns an empty array.
     *
     * @return DomainEventInterface[]
     */
    final public function releaseDomainEvents(): array
    {
        $events = $this->recordedDomainEvents;
        $this->recordedDomainEvents = [];

        return $events;
    }
}
