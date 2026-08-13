<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messenger;

use App\Shared\Application\Port\CorrelationIdProviderPort;
use App\Shared\Application\Port\DomainEventCollectorPort;
use App\Shared\Application\Port\OutboxWriterPort;
use App\Shared\Infrastructure\Eventing\EventEnvelopeFactory;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Orchestrates the complete Domain Event → EventEnvelope → Outbox pipeline.
 *
 * Position in the command.bus middleware stack (ADR-SA-013 §6.5, R-014):
 *   [doctrine_transaction] (outer) → [DomainEventPublisherMiddleware] (inner) → [handler]
 *
 * Execution order (middleware stack unwinds after handler returns):
 *   1. doctrine_transaction opens the PostgreSQL transaction.
 *   2. This middleware passes control to the handler (stack.next().handle()).
 *   3. Handler executes: Aggregate business method + Repository.persist() + Collector.collect().
 *   4. This middleware unwinds: flushes collector, creates EventEnvelopes, writes to Outbox.
 *   5. doctrine_transaction unwinds: COMMIT — Aggregate write + Outbox write are atomic.
 *
 * On exception from the handler (transaction will be rolled back by doctrine_transaction):
 *   The exception propagates immediately. No envelopes are created. No Outbox writes occur.
 *   The collector is not flushed — events describe a state that was never committed.
 *
 * correlationId source: CorrelationIdProviderPort (set by HTTP listener, fallback UUID).
 * causationId: generated as UUID v4 per command dispatch.
 *   ADR-SA-013 referenced UniqueIdStamp (Symfony Messenger) for causationId, but this class
 *   does not exist in symfony/messenger v7.4. Options: (A) create a custom CommandIdStamp
 *   added by a dedicated middleware; (B) keep per-dispatch UUID v4 (current — loses
 *   command→event link); (C) upgrade Symfony when UniqueIdStamp becomes available.
 *   OPEN — awaiting architecture decision before changing this behaviour.
 *
 * ADR-SA-013 R-014 through R-020.
 */
final class DomainEventPublisherMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly DomainEventCollectorPort $collector,
        private readonly EventEnvelopeFactory $envelopeFactory,
        private readonly OutboxWriterPort $outboxWriter,
        private readonly CorrelationIdProviderPort $correlationIdProvider,
    ) {}

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        $correlationId = $this->correlationIdProvider->get();
        $causationId   = Uuid::v4()->toRfc4122();

        foreach ($this->collector->flush() as $domainEvent) {
            $eventEnvelope = $this->envelopeFactory->create($domainEvent, $correlationId, $causationId);
            $this->outboxWriter->save($eventEnvelope);
        }

        return $envelope;
    }
}
