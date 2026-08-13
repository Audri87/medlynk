<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Eventing;

use App\Shared\Domain\Event\DomainEventInterface;

/**
 * Resolves the EventTypeConfig for a given Domain Event instance.
 *
 * Holds an explicit configuration map (eventClass => EventTypeConfig) built
 * by platform-specific registries (e.g. ClinicalEventTypeRegistry).
 *
 * Using the PHP class name as an eventType identifier is forbidden (ADR-SA-013 R-038).
 * All mappings are explicit and stable across class renames.
 *
 * Throws \UnexpectedValueException if an unregistered event class is encountered.
 * This is intentional: a missing registration is a configuration error that must
 * fail loudly, not silently produce a broken EventEnvelope.
 */
final class EventTypeResolver
{
    /** @param array<class-string, EventTypeConfig> $configs */
    public function __construct(private readonly array $configs) {}

    /**
     * @throws \UnexpectedValueException if no config is registered for this event class
     */
    public function resolve(DomainEventInterface $event): EventTypeConfig
    {
        $class = $event::class;

        return $this->configs[$class]
            ?? throw new \UnexpectedValueException(
                sprintf(
                    'No EventTypeConfig registered for Domain Event class "%s". '
                    . 'Register it in the platform EventTypeRegistry.',
                    $class,
                )
            );
    }
}
