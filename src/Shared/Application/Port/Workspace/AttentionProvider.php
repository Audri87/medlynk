<?php

declare(strict_types=1);

namespace App\Shared\Application\Port\Workspace;

use App\Shared\Domain\ValueObject\ActorId;
use App\Shared\Domain\ValueObject\ContextId;

/**
 * Business contract through which a Platform surfaces items requiring the Actor's attention.
 * Priority and urgency ordering is the Workspace Engine's responsibility.
 */
interface AttentionProvider
{
    /** @return AttentionItem[] */
    public function attentionItems(ActorId $actor, ContextId $context): array;

    public function supports(ActorId $actor, ContextId $context): bool;
}
