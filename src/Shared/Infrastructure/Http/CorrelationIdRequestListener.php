<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Uid\Uuid;

/**
 * Populates CorrelationContext at the start of each HTTP request.
 *
 * Priority 256 ensures this listener runs before any application logic,
 * so correlationId is always available when the first Command is dispatched.
 *
 * ID selection (ADR-SA-013 R-045):
 *   1. Use the X-Correlation-ID header value if present and non-empty.
 *   2. Generate a UUID v4 otherwise.
 *
 * Only processes the main request — subrequests inherit the same correlation ID
 * via the shared CorrelationContext singleton.
 */
#[AsEventListener(event: KernelEvents::REQUEST, priority: 256)]
final class CorrelationIdRequestListener
{
    public function __construct(private readonly CorrelationContext $context) {}

    public function __invoke(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $header = $event->getRequest()->headers->get('X-Correlation-ID');
        $correlationId = ($header !== null && $header !== '')
            ? $header
            : Uuid::v4()->toRfc4122();

        $this->context->set($correlationId);
    }
}
