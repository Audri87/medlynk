<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence;

use App\Shared\Application\Event\EventEnvelope;
use App\Shared\Application\Port\OutboxWriterPort;
use Doctrine\DBAL\Connection;

/**
 * DBAL adapter for writing EventEnvelopes to the domain_event_outbox table.
 *
 * This is NOT a DDD Repository. It is an Infrastructure adapter that persists
 * EventEnvelopes — technical transport contracts — not Aggregate Roots.
 *
 * Called exclusively by DomainEventPublisherMiddleware inside the active
 * doctrine_transaction. The write is atomic with the Aggregate persist
 * (ADR-SA-013 R-020).
 *
 * ON CONFLICT (event_id) DO NOTHING ensures idempotent writes: duplicate
 * EventEnvelopes are silently ignored (ADR-SA-013 R-042).
 *
 * MUST NOT call beginTransaction() or commit() — the transaction is owned
 * by the doctrine_transaction middleware (ADR-SA-013 R-043).
 */
final class OutboxRepository implements OutboxWriterPort
{
    public function __construct(private readonly Connection $connection) {}

    public function save(EventEnvelope $envelope): void
    {
        $this->connection->executeStatement(
            <<<'SQL'
            INSERT INTO domain_event_outbox (
                event_id,
                aggregate_id,
                aggregate_type,
                aggregate_version,
                event_type,
                event_version,
                platform,
                payload,
                metadata,
                correlation_id,
                causation_id,
                occurred_at
            ) VALUES (
                :event_id,
                :aggregate_id,
                :aggregate_type,
                :aggregate_version,
                :event_type,
                :event_version,
                :platform,
                :payload,
                :metadata,
                :correlation_id,
                :causation_id,
                :occurred_at
            )
            ON CONFLICT (event_id) DO NOTHING
            SQL,
            [
                'event_id'          => $envelope->eventId,
                'aggregate_id'      => $envelope->aggregateId,
                'aggregate_type'    => $envelope->aggregateType,
                'aggregate_version' => $envelope->aggregateVersion,
                'event_type'        => $envelope->eventType,
                'event_version'     => $envelope->eventVersion,
                'platform'          => $envelope->platformId,
                'payload'           => json_encode($envelope->payload, JSON_THROW_ON_ERROR),
                'metadata'          => json_encode($envelope->metadata, JSON_THROW_ON_ERROR),
                'correlation_id'    => $envelope->correlationId,
                'causation_id'      => $envelope->causationId,
                'occurred_at'       => $envelope->occurredAt->format(\DateTimeInterface::ATOM),
            ],
        );
    }
}
