<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

/**
 * Immutable transport contract for a Domain Event.
 *
 * Represents the technical form of a Domain Event for Outbox persistence and
 * downstream delivery. Transport-protocol-agnostic: contains no topic names,
 * routing keys, queue identifiers, TTL, or priority fields.
 *
 * All fields are set at construction. No setters. No with*() methods.
 * Once created, an EventEnvelope is immutable for its entire lifecycle.
 *
 * Field semantics (ADR-SA-013 §5.3):
 *   eventId          — UUID v4, unique per envelope, used as idempotency key by consumers.
 *   aggregateId      — UUID of the Aggregate Root that produced the event.
 *   aggregateType    — Stable string identifier for the Aggregate type (e.g. "clinical.contribution").
 *   aggregateVersion — Always null for the MVP. Reserved for optimistic locking (ADR-SA-013 R-025).
 *   eventType        — Stable dot-notation identifier (e.g. "clinical.contribution.validated").
 *   eventVersion     — Schema version of the payload (e.g. "1.0").
 *   platformId       — Platform that produced the event (e.g. "clinical").
 *   occurredAt       — Business timestamp copied from the Domain Event (not envelope creation time).
 *   correlationId    — UUID tracing the originating HTTP request.
 *   causationId      — UUID of the Command message that triggered this event.
 *   metadata         — Reserved for future use. Empty array for the MVP.
 *   payload          — JSON-safe array produced by EventSerializer. Stored as JSONB.
 */
final readonly class EventEnvelope
{
    /**
     * @param array<string, mixed> $metadata
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public string $eventId,
        public string $aggregateId,
        public string $aggregateType,
        public ?int $aggregateVersion,
        public string $eventType,
        public string $eventVersion,
        public string $platformId,
        public \DateTimeImmutable $occurredAt,
        public string $correlationId,
        public string $causationId,
        public array $metadata,
        public array $payload,
    ) {}
}
