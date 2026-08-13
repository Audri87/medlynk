<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Messenger;

use App\Shared\Domain\Event\DomainEventInterface;
use App\Shared\Infrastructure\Messenger\DomainEventCollector;
use PHPUnit\Framework\TestCase;

final class DomainEventCollectorTest extends TestCase
{
    private DomainEventCollector $collector;

    protected function setUp(): void
    {
        $this->collector = new DomainEventCollector();
    }

    public function test_flush_on_empty_collector_returns_empty_array(): void
    {
        $this->assertSame([], $this->collector->flush());
    }

    public function test_flush_returns_collected_events(): void
    {
        $event = $this->makeEvent();
        $this->collector->collect($event);

        $this->assertSame([$event], $this->collector->flush());
    }

    public function test_flush_returns_events_in_insertion_order(): void
    {
        $e1 = $this->makeEvent();
        $e2 = $this->makeEvent();
        $e3 = $this->makeEvent();

        $this->collector->collect($e1, $e2, $e3);

        $this->assertSame([$e1, $e2, $e3], $this->collector->flush());
    }

    public function test_multiple_collect_calls_preserve_global_order(): void
    {
        $e1 = $this->makeEvent();
        $e2 = $this->makeEvent();
        $e3 = $this->makeEvent();

        $this->collector->collect($e1, $e2);
        $this->collector->collect($e3);

        $this->assertSame([$e1, $e2, $e3], $this->collector->flush());
    }

    public function test_flush_clears_the_buffer(): void
    {
        $this->collector->collect($this->makeEvent());
        $this->collector->flush();

        $this->assertSame([], $this->collector->flush());
    }

    public function test_collect_after_flush_starts_fresh(): void
    {
        $e1 = $this->makeEvent();
        $e2 = $this->makeEvent();

        $this->collector->collect($e1);
        $this->collector->flush();
        $this->collector->collect($e2);

        $this->assertSame([$e2], $this->collector->flush());
    }

    public function test_collect_with_no_arguments_is_a_noop(): void
    {
        $this->collector->collect();

        $this->assertSame([], $this->collector->flush());
    }

    public function test_spread_operator_works_from_aggregate_release(): void
    {
        $e1 = $this->makeEvent();
        $e2 = $this->makeEvent();

        $events = [$e1, $e2];
        $this->collector->collect(...$events);

        $this->assertSame([$e1, $e2], $this->collector->flush());
    }

    private function makeEvent(): DomainEventInterface
    {
        return new class implements DomainEventInterface {};
    }
}
