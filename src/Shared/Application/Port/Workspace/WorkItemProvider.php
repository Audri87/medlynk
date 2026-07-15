<?php

declare(strict_types=1);

namespace App\Shared\Application\Port\Workspace;

use App\Shared\Domain\ValueObject\ActorId;
use App\Shared\Domain\ValueObject\ContextId;

/**
 * Business contract through which a Platform exposes active work items for an Actor in a Context.
 */
interface WorkItemProvider
{
    /** @return WorkItem[] */
    public function activeWorkItems(ActorId $actor, ContextId $context): array;

    public function supports(ActorId $actor, ContextId $context): bool;
}
