<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Eventing;

use App\Shared\Application\Event\EventEnvelope;
use App\Shared\Domain\Event\DomainEventInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Creates an EventEnvelope from a Domain Event and the metadata provided by the Middleware.
 *
 * Single responsibility: assemble the EventEnvelope by delegating to EventTypeResolver
 * for all event-specific data (aggregateId, aggregateType, eventType, eventVersion,
 * occurredAt, payload) and accepting correlationId and causationId as parameters.
 *
 * Invariants (ADR-SA-013 R-027 through R-031):
 *   — correlationId and causationId are NEVER fetched internally. Always received as params.
 *   — occurredAt is copied from the Domain Event. Never set to the current wall clock.
 *   — A fresh UUID v4 is generated for eventId on every call.
 *   — aggregateVersion is always null for the MVP (ADR-SA-013 R-025).
 *   — Payload serialization is delegated to EventTypeResolver — never to json_encode directly.
 *
 * Dependencies:
 *   EventTypeResolver — resolves all event-specific metadata and payload.
 *   $platformId       — static string injected via DI (e.g. "clinical").
 */
final class EventEnvelopeFactory
{
    public function __construct(
        private readonly EventTypeResolver $typeResolver,
        private readonly string $platformId,
    ) {}

    public function create(
        DomainEventInterface $event,
        string $correlationId,
        string $causationId,
    ): EventEnvelope {
        $config = $this->typeResolver->resolve($event);

        return new EventEnvelope(
            eventId:          Uuid::v4()->toRfc4122(),
            aggregateId:      $config->extractAggregateId($event),
            aggregateType:    $config->aggregateType,
            aggregateVersion: null,
            eventType:        $config->eventType,
            eventVersion:     $config->eventVersion,
            platformId:       $this->platformId,
            occurredAt:       $config->extractOccurredAt($event),
            correlationId:    $correlationId,
            causationId:      $causationId,
            metadata:         [],
            payload:          $config->extractPayload($event),
        );
    }
}
