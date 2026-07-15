<?php

declare(strict_types=1);

namespace App\Workspace\Application;

use App\Shared\Application\Port\Workspace\AttentionItem;
use App\Shared\Application\Port\Workspace\WorkItem;
use App\Shared\Application\Port\Workspace\WorkspaceSection;
use App\Shared\Domain\ValueObject\ActorId;
use App\Shared\Domain\ValueObject\ContextId;

/**
 * The computed work surface for an (Actor, Context) pair.
 * Assembles active Capabilities, Attention items and Work Items from available Platforms.
 * Medium-independent: it organizes information, not presentation.
 */
final readonly class Workspace
{
    /**
     * @param WorkspaceSection[] $sections
     * @param AttentionItem[]    $attentionItems
     * @param WorkItem[]         $workItems
     */
    public function __construct(
        public readonly ActorId $actor,
        public readonly ContextId $context,
        public readonly array $sections,
        public readonly array $attentionItems,
        public readonly array $workItems,
    ) {}
}
