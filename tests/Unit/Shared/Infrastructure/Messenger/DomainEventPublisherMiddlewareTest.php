<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Messenger;

use App\Shared\Application\Event\EventEnvelope;
use App\Shared\Application\Port\CorrelationIdProviderPort;
use App\Shared\Application\Port\DomainEventCollectorPort;
use App\Shared\Application\Port\OutboxWriterPort;
use App\Shared\Domain\Event\DomainEventInterface;
use App\Shared\Infrastructure\Eventing\EventEnvelopeFactory;
use App\Shared\Infrastructure\Eventing\EventTypeConfig;
use App\Shared\Infrastructure\Eventing\EventTypeResolver;
use App\Shared\Infrastructure\Messenger\DomainEventPublisherMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

/**
 * Tests use a real EventEnvelopeFactory (final class — cannot be mocked).
 * All external boundaries (collector, outboxWriter, correlationIdProvider) are mocked.
 */
final class DomainEventPublisherMiddlewareTest extends TestCase
{
    private const AGGREGATE_ID   = 'aaaaaaaa-aaaa-4aaa-aaaa-aaaaaaaaaaaa';
    private const CORRELATION_ID = 'cccccccc-cccc-4ccc-cccc-cccccccccccc';

    private DomainEventCollectorPort&MockObject $collector;
    private OutboxWriterPort&MockObject $outboxWriter;
    private CorrelationIdProviderPort&MockObject $correlationIdProvider;
    private EventEnvelopeFactory $factory;
    private DomainEventPublisherMiddleware $middleware;

    protected function setUp(): void
    {
        $this->collector             = $this->createMock(DomainEventCollectorPort::class);
        $this->outboxWriter          = $this->createMock(OutboxWriterPort::class);
        $this->correlationIdProvider = $this->createMock(CorrelationIdProviderPort::class);

        $this->factory = $this->makeRealFactory();

        $this->middleware = new DomainEventPublisherMiddleware(
            $this->collector,
            $this->factory,
            $this->outboxWriter,
            $this->correlationIdProvider,
        );

        $this->correlationIdProvider->method('get')->willReturn(self::CORRELATION_ID);
    }

    public function test_writes_single_event_to_outbox_after_handler(): void
    {
        $event   = new TestDomainEvent(self::AGGREGATE_ID, new \DateTimeImmutable());
        $envelope = $this->makeEnvelope();

        $this->collector->method('flush')->willReturn([$event]);
        $this->outboxWriter->expects($this->once())->method('save')
            ->with($this->isInstanceOf(EventEnvelope::class));

        $this->middleware->handle($envelope, $this->successStack($envelope));
    }

    public function test_writes_multiple_events_in_collection_order(): void
    {
        $now = new \DateTimeImmutable();
        $e1  = new TestDomainEvent(self::AGGREGATE_ID, $now);
        $e2  = new TestDomainEvent(self::AGGREGATE_ID, $now);
        $e3  = new TestDomainEvent(self::AGGREGATE_ID, $now);

        $envelope = $this->makeEnvelope();
        $this->collector->method('flush')->willReturn([$e1, $e2, $e3]);

        $this->outboxWriter->expects($this->exactly(3))->method('save');

        $this->middleware->handle($envelope, $this->successStack($envelope));
    }

    public function test_no_outbox_write_when_collector_is_empty(): void
    {
        $this->collector->method('flush')->willReturn([]);
        $this->outboxWriter->expects($this->never())->method('save');

        $envelope = $this->makeEnvelope();
        $this->middleware->handle($envelope, $this->successStack($envelope));
    }

    public function test_causation_id_is_valid_uuid_v4(): void
    {
        $event   = new TestDomainEvent(self::AGGREGATE_ID, new \DateTimeImmutable());
        $envelope = $this->makeEnvelope();
        $this->collector->method('flush')->willReturn([$event]);

        $saved = null;
        $this->outboxWriter->method('save')
            ->willReturnCallback(static function (EventEnvelope $e) use (&$saved): void {
                $saved = $e;
            });

        $this->middleware->handle($envelope, $this->successStack($envelope));

        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            (string) $saved?->causationId,
        );
    }

    public function test_passes_correlation_id_from_provider(): void
    {
        $event   = new TestDomainEvent(self::AGGREGATE_ID, new \DateTimeImmutable());
        $envelope = $this->makeEnvelope();
        $this->collector->method('flush')->willReturn([$event]);

        $saved = null;
        $this->outboxWriter->method('save')
            ->willReturnCallback(static function (EventEnvelope $e) use (&$saved): void {
                $saved = $e;
            });

        $this->middleware->handle($envelope, $this->successStack($envelope));

        $this->assertSame(self::CORRELATION_ID, $saved?->correlationId);
    }

    public function test_envelope_aggregate_id_comes_from_event(): void
    {
        $event   = new TestDomainEvent(self::AGGREGATE_ID, new \DateTimeImmutable());
        $envelope = $this->makeEnvelope();
        $this->collector->method('flush')->willReturn([$event]);

        $saved = null;
        $this->outboxWriter->method('save')
            ->willReturnCallback(static function (EventEnvelope $e) use (&$saved): void {
                $saved = $e;
            });

        $this->middleware->handle($envelope, $this->successStack($envelope));

        $this->assertSame(self::AGGREGATE_ID, $saved?->aggregateId);
    }

    public function test_exception_from_handler_propagates_without_outbox_write(): void
    {
        $this->outboxWriter->expects($this->never())->method('save');
        $this->collector->expects($this->never())->method('flush');

        $envelope = $this->makeEnvelope();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('handler failed');

        $this->middleware->handle($envelope, $this->failingStack(new \RuntimeException('handler failed')));
    }

    public function test_returns_envelope_from_inner_stack(): void
    {
        $this->collector->method('flush')->willReturn([]);

        $envelope = $this->makeEnvelope();
        $result   = $this->middleware->handle($envelope, $this->successStack($envelope));

        $this->assertSame($envelope, $result);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function makeRealFactory(): EventEnvelopeFactory
    {
        $config = new EventTypeConfig(
            eventClass: TestDomainEvent::class,
            eventType: 'test.domain.event',
            aggregateType: 'TestAggregate',
            eventVersion: '1.0',
            aggregateIdExtractor: static fn (TestDomainEvent $e): string => $e->aggregateId,
            occurredAtExtractor: static fn (TestDomainEvent $e): \DateTimeImmutable => $e->occurredAt,
            payloadExtractor: static fn (TestDomainEvent $e): array => ['aggregate_id' => $e->aggregateId],
        );

        return new EventEnvelopeFactory(
            new EventTypeResolver([TestDomainEvent::class => $config]),
            'test_platform',
        );
    }

    private function makeEnvelope(): Envelope
    {
        return new Envelope(new \stdClass());
    }

    private function successStack(Envelope $returnEnvelope): StackInterface
    {
        $next = $this->createMock(MiddlewareInterface::class);
        $next->method('handle')->willReturn($returnEnvelope);

        $stack = $this->createMock(StackInterface::class);
        $stack->method('next')->willReturn($next);

        return $stack;
    }

    private function failingStack(\Throwable $error): StackInterface
    {
        $next = $this->createMock(MiddlewareInterface::class);
        $next->method('handle')->willThrowException($error);

        $stack = $this->createMock(StackInterface::class);
        $stack->method('next')->willReturn($next);

        return $stack;
    }
}

final readonly class TestDomainEvent implements DomainEventInterface
{
    public function __construct(
        public readonly string $aggregateId,
        public readonly \DateTimeImmutable $occurredAt,
    ) {}
}
