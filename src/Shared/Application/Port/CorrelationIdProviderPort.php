<?php

declare(strict_types=1);

namespace App\Shared\Application\Port;

/**
 * Application port for reading the current correlation ID.
 *
 * Called by DomainEventPublisherMiddleware to populate EventEnvelope.correlationId.
 *
 * HTTP adapter: reads from CorrelationContext, populated by CorrelationIdRequestListener
 *   at the start of each HTTP request (from X-Correlation-ID header or generated UUID v4).
 *
 * Fallback (console, workers): generates a fresh UUID v4 per invocation.
 *
 * The returned value MUST never be null or empty (ADR-SA-013 R-047).
 *
 * Implemented by: Shared/Infrastructure/Http/CorrelationIdContextAdapter
 */
interface CorrelationIdProviderPort
{
    public function get(): string;
}
