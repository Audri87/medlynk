<?php

declare(strict_types=1);

namespace App\Shared\Application\Port\Workspace;

use App\Shared\Domain\ValueObject\ActorId;
use App\Shared\Domain\ValueObject\ContextId;

/**
 * Business contract through which a Platform contributes sections to the Workspace.
 * Platforms implement this. Workspace consumes it. Neither knows about the other.
 */
interface WorkspaceContributor
{
    /** @return WorkspaceSection[] */
    public function sections(ActorId $actor, ContextId $context): array;

    public function supports(ActorId $actor, ContextId $context): bool;
}
