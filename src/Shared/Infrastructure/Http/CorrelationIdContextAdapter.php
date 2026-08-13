<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use App\Shared\Application\Port\CorrelationIdProviderPort;
use Symfony\Component\Uid\Uuid;

/**
 * Implements CorrelationIdProviderPort by reading from CorrelationContext.
 *
 * HTTP requests: returns the ID set by CorrelationIdRequestListener (from the
 *   X-Correlation-ID header, or a UUID v4 generated at request start).
 *
 * Console / Worker contexts: CorrelationContext.get() returns null (no listener
 *   fired). A fresh UUID v4 is generated per invocation, providing command-level
 *   correlation even outside the HTTP request lifecycle.
 *
 * The returned value is never null or empty (ADR-SA-013 R-047).
 */
final class CorrelationIdContextAdapter implements CorrelationIdProviderPort
{
    public function __construct(private readonly CorrelationContext $context) {}

    public function get(): string
    {
        return $this->context->get() ?? Uuid::v4()->toRfc4122();
    }
}
