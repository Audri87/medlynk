<?php

declare(strict_types=1);

namespace App\Shared\Application\Port;

use App\Shared\Application\Event\EventEnvelope;

/**
 * Application port for writing EventEnvelopes to the Outbox.
 *
 * Called by DomainEventPublisherMiddleware inside the active doctrine_transaction,
 * after the command handler returns and domain events have been enveloped.
 *
 * The write is atomic with the Aggregate persist: both operations share the
 * same PostgreSQL transaction (ADR-SA-013 R-020).
 *
 * Implementations MUST use ON CONFLICT (event_id) DO NOTHING semantics
 * to guarantee idempotent writes (ADR-SA-013 R-042).
 *
 * Implemented by: Shared/Infrastructure/Persistence/OutboxRepository
 */
interface OutboxWriterPort
{
    public function save(EventEnvelope $envelope): void;
}
