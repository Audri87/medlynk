<?php

declare(strict_types=1);

namespace App\Platforms\Clinical\Application\Port;

/**
 * Application Port — Domain Event collection contract.
 *
 * Single responsibility: accept Domain Events emitted by an Aggregate Root
 * after its business operation, and hold them until the active transaction commits.
 *
 * WHY this port exists in the Application layer:
 * The Application layer coordinates the full use-case lifecycle — including making
 * Domain Events available for publication. The Handler cannot publish directly
 * because publication must occur AFTER the transaction commits (SA-005 D-008).
 * This port decouples the Handler's "collect" responsibility from the Infrastructure's
 * "publish" responsibility.
 *
 * WHY the Handler uses this port and not the event.bus directly:
 * Dispatching to the event.bus inside the transaction would make events observable
 * before the aggregate state is committed. If the transaction rolls back, the events
 * would already exist in the bus. This port holds events post-operation, pre-commit.
 * The Infrastructure implementation defers publication to post-commit (SA-005 §13.3).
 *
 * WHY publication is NOT part of this port's contract:
 * Publication — routing events to the Internal Event Bus — is an Infrastructure
 * responsibility. The Application layer's obligation ends at collection and propagation.
 * The implementation decides how and when to publish (SA-005 §13.4, SA-006 §5).
 *
 * Implemented by: Infrastructure/EventBus/ (PR-004 scope).
 * Used by: Command Handlers exclusively.
 * Never used by: Query Handlers, Domain classes, Projections.
 */
interface DomainEventCollectorPort
{
    /**
     * Accepts Domain Events pulled from an Aggregate Root after its business operation.
     *
     * Called by Command Handlers immediately after persist(), still inside the transaction.
     * Events are not published here. The Infrastructure implementation defers publication
     * until the transaction commits (SA-005 D-008, SA-007 §6.5).
     *
     * If the transaction rolls back, the implementation MUST discard collected events.
     * Discarded events are structurally absent — they never existed in the observable system.
     *
     * @param object[] $events Domain Events produced by pullPendingEvents()
     */
    public function collect(array $events): void;
}
