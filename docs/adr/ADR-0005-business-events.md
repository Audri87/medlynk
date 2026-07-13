# ADR-0005 — Business Events vs Platform Domain Events

**Status:** Accepted

## Decision

| Concept | Location | Nature |
|---|---|---|
| `BusinessEvent` | `Kernel/Domain/Event/` | Universal cross-platform language |
| Platform Domain Event | `Platforms/{Name}/Domain/Event/` | Platform-internal fact |

## BusinessEvent (Kernel)

```php
// Kernel/Domain/Event/BusinessEvent.php
interface BusinessEvent
{
    public function occurredAt(): \DateTimeImmutable;
}
```

- Belongs to the Platform Kernel.
- No infrastructure dependency.
- Represents a fact with cross-platform significance.
- The Kernel never knows about any Business Platform.

## Platform Domain Events

```php
// Platforms/Clinical/Domain/Event/ConsultationClosed.php
final class ConsultationClosed
{
    // Plain PHP class — internal to Clinical
    // No interface required for Platform-internal use
}
```

Platform Domain Events are plain PHP classes.
They live inside their Platform's `Domain/Event/` folder.
They are dispatched on the `event.bus` for projection updates within the Platform.

## Cross-platform communication

When a Platform Domain Event has significance beyond its Platform,
it implements `BusinessEvent`.

```php
// Platforms/Clinical/Domain/Event/PatientRegistered.php
final class PatientRegistered implements BusinessEvent
{
    // Cross-platform — Identity, Trust, Collaboration may react to this
}
```

This is opt-in. Not every Domain Event is a BusinessEvent.

## Rules

1. The Kernel never imports from any Platform.
2. A Platform Domain Event MAY implement BusinessEvent — never required to.
3. BusinessEvent is the only cross-platform contract.
4. Platform Domain Events dispatched on event.bus are plain PHP objects.
5. Symfony Messenger requires no interface to dispatch or handle events.

## Structure

```
Kernel/
    Domain/
        Event/
            BusinessEvent.php

Platforms/
    Clinical/
        Domain/
            Event/
                PatientRegistered.php    ← implements BusinessEvent (cross-platform)
                ConsultationClosed.php   ← plain class (Platform-internal)
```
