<?php

declare(strict_types=1);

namespace App\Kernel\Domain\Event;

/**
 * BusinessEvent — Platform Kernel concept.
 *
 * Represents an immutable fact with cross-platform significance.
 * This is the universal language of MedLink.
 *
 * A Platform Domain Event may implement this interface
 * when it needs to communicate across Platform boundaries.
 *
 * The Kernel never knows about Clinical, Collaboration, or any Business Platform.
 */
interface BusinessEvent
{
    public function occurredAt(): \DateTimeImmutable;
}
