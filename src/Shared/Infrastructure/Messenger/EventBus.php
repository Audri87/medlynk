<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messenger;

use Symfony\Component\Messenger\MessageBusInterface;

final readonly class EventBus
{
    public function __construct(
        private MessageBusInterface $eventBus,
    ) {}

    public function dispatch(object $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
