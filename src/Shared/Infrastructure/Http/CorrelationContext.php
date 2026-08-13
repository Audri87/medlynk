<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

/**
 * Request-scoped holder for the current correlation ID.
 *
 * Populated by CorrelationIdRequestListener at the start of each HTTP request.
 * Read by CorrelationIdContextAdapter to satisfy CorrelationIdProviderPort.
 *
 * Registered as a singleton service so that the listener and the adapter
 * share the same instance within a request.
 */
final class CorrelationContext
{
    private ?string $correlationId = null;

    public function set(string $correlationId): void
    {
        $this->correlationId = $correlationId;
    }

    public function get(): ?string
    {
        return $this->correlationId;
    }
}
