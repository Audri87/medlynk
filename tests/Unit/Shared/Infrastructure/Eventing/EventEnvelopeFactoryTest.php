<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Eventing;

use App\Shared\Domain\Event\DomainEventInterface;
use App\Shared\Infrastructure\Eventing\EventEnvelopeFactory;
use App\Shared\Infrastructure\Eventing\EventTypeConfig;
use App\Shared\Infrastructure\Eventing\EventTypeResolver;
use PHPUnit\Framework\TestCase;

final class EventEnvelopeFactoryTest extends TestCase
{
    private const AGGREGATE_ID    = 'aaaaaaaa-aaaa-4aaa-aaaa-aaaaaaaaaaaa';
    private const CORRELATION_ID  = 'cccccccc-cccc-4ccc-cccc-cccccccccccc';
    private const CAUSATION_ID    = 'dddddddd-dddd-4ddd-dddd-dddddddddddd';
    private const PLATFORM_ID     = 'clinical';

    public function test_create_returns_envelope_with_correct_fields(): void
    {
        $occurredAt  = new \DateTimeImmutable('2026-07-26T12:00:00+00:00');
        $event       = $this->makeEvent();
        $factory     = $this->makeFactory($event, $occurredAt);

        $envelope = $factory->create($event, self::CORRELATION_ID, self::CAUSATION_ID);

        $this->assertSame(self::AGGREGATE_ID, $envelope->aggregateId);
        $this->assertSame('TestAggregate', $envelope->aggregateType);
        $this->assertNull($envelope->aggregateVersion); // always null for MVP
        $this->assertSame('test.event.created', $envelope->eventType);
        $this->assertSame('1.0', $envelope->eventVersion);
        $this->assertSame(self::PLATFORM_ID, $envelope->platformId);
        $this->assertSame($occurredAt, $envelope->occurredAt);
        $this->assertSame(self::CORRELATION_ID, $envelope->correlationId);
        $this->assertSame(self::CAUSATION_ID, $envelope->causationId);
        $this->assertSame(['key' => 'value'], $envelope->payload);
        $this->assertSame([], $envelope->metadata);
    }

    public function test_create_generates_unique_event_id(): void
    {
        $event   = $this->makeEvent();
        $factory = $this->makeFactory($event, new \DateTimeImmutable());

        $e1 = $factory->create($event, self::CORRELATION_ID, self::CAUSATION_ID);
        $e2 = $factory->create($event, self::CORRELATION_ID, self::CAUSATION_ID);

        $this->assertNotSame($e1->eventId, $e2->eventId);
    }

    public function test_event_id_is_valid_uuid_v4(): void
    {
        $event   = $this->makeEvent();
        $factory = $this->makeFactory($event, new \DateTimeImmutable());

        $envelope = $factory->create($event, self::CORRELATION_ID, self::CAUSATION_ID);

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $envelope->eventId,
        );
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function makeEvent(): DomainEventInterface
    {
        return new class implements DomainEventInterface {};
    }

    private function makeFactory(DomainEventInterface $event, \DateTimeImmutable $occurredAt): EventEnvelopeFactory
    {
        $config = new EventTypeConfig(
            eventClass: $event::class,
            eventType: 'test.event.created',
            aggregateType: 'TestAggregate',
            eventVersion: '1.0',
            aggregateIdExtractor: static fn (): string => self::AGGREGATE_ID,
            occurredAtExtractor: static fn () => $occurredAt,
            payloadExtractor: static fn (): array => ['key' => 'value'],
        );

        $resolver = new EventTypeResolver([$event::class => $config]);

        return new EventEnvelopeFactory($resolver, self::PLATFORM_ID);
    }
}
