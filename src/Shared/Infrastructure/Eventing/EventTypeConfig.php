<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Eventing;

use App\Shared\Domain\Event\DomainEventInterface;

/**
 * Holds all metadata and extraction logic for one Domain Event class.
 *
 * Registered in EventTypeResolver via platform-specific registries
 * (e.g. ClinicalEventTypeRegistry). One config per Domain Event class.
 *
 * The three closures receive the concrete event instance and extract:
 *   aggregateIdExtractor — the Aggregate Root UUID as a raw string.
 *   occurredAtExtractor  — the business timestamp as DateTimeImmutable (UTC).
 *   payloadExtractor     — a JSON-safe array for the EventEnvelope.payload JSONB column.
 *
 * Closures use explicit field access — never reflection, never json_encode on the object.
 * Renaming a PHP class MUST NOT change eventType or aggregateType (ADR-SA-013 R-039).
 */
final class EventTypeConfig
{
    /**
     * @param \Closure(DomainEventInterface): string           $aggregateIdExtractor
     * @param \Closure(DomainEventInterface): \DateTimeImmutable $occurredAtExtractor
     * @param \Closure(DomainEventInterface): array<string, mixed> $payloadExtractor
     */
    public function __construct(
        public readonly string $eventClass,
        public readonly string $eventType,
        public readonly string $aggregateType,
        public readonly string $eventVersion,
        private readonly \Closure $aggregateIdExtractor,
        private readonly \Closure $occurredAtExtractor,
        private readonly \Closure $payloadExtractor,
    ) {}

    public function extractAggregateId(DomainEventInterface $event): string
    {
        return ($this->aggregateIdExtractor)($event);
    }

    public function extractOccurredAt(DomainEventInterface $event): \DateTimeImmutable
    {
        return ($this->occurredAtExtractor)($event);
    }

    /** @return array<string, mixed> */
    public function extractPayload(DomainEventInterface $event): array
    {
        return ($this->payloadExtractor)($event);
    }
}
