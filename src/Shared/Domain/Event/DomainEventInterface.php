<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

/**
 * Marker interface for all Domain Events in MedLink.
 *
 * Every Domain Event emitted by an Aggregate Root MUST implement this interface.
 * It carries no methods — its sole purpose is to identify a class as a Domain Event
 * in the dependency chain, enabling the Application and Infrastructure layers to
 * reference Domain Events without depending on concrete platform classes.
 *
 * Invariants (ADR-SA-013 R-001 through R-005):
 *   — Zero methods. Zero business logic. Zero infrastructure knowledge.
 *   — The implementing class MUST be immutable (no setters, no mutation methods).
 *   — The implementing class MUST NOT reference Application or Infrastructure classes.
 *   — Event-specific metadata (aggregateId, occurredAt) is extracted by EventTypeResolver
 *     via its configuration map — not via methods on this interface.
 */
interface DomainEventInterface {}
