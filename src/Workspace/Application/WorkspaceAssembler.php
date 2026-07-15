<?php

declare(strict_types=1);

namespace App\Workspace\Application;

use App\Shared\Application\Port\Workspace\AttentionItem;
use App\Shared\Application\Port\Workspace\AttentionProvider;
use App\Shared\Application\Port\Workspace\WorkItem;
use App\Shared\Application\Port\Workspace\WorkItemProvider;
use App\Shared\Application\Port\Workspace\WorkspaceContributor;
use App\Shared\Application\Port\Workspace\WorkspaceSection;
use App\Shared\Domain\ValueObject\ActorId;
use App\Shared\Domain\ValueObject\ContextId;

final class WorkspaceAssembler
{
    /**
     * @param iterable<WorkspaceContributor> $contributors
     * @param iterable<AttentionProvider>    $attentionProviders
     * @param iterable<WorkItemProvider>     $workItemProviders
     */
    public function __construct(
        private readonly iterable $contributors,
        private readonly iterable $attentionProviders,
        private readonly iterable $workItemProviders,
    ) {}

    public function assemble(ActorId $actor, ContextId $context): Workspace
    {
        return new Workspace(
            $actor,
            $context,
            $this->collectSections($actor, $context),
            $this->collectAttentionItems($actor, $context),
            $this->collectWorkItems($actor, $context),
        );
    }

    /** @return WorkspaceSection[] */
    private function collectSections(ActorId $actor, ContextId $context): array
    {
        $sections = [];
        foreach ($this->contributors as $contributor) {
            if ($contributor->supports($actor, $context)) {
                array_push($sections, ...$contributor->sections($actor, $context));
            }
        }
        usort($sections, static fn (WorkspaceSection $a, WorkspaceSection $b) => $b->priority <=> $a->priority);

        return $sections;
    }

    /** @return AttentionItem[] */
    private function collectAttentionItems(ActorId $actor, ContextId $context): array
    {
        $items = [];
        foreach ($this->attentionProviders as $provider) {
            if ($provider->supports($actor, $context)) {
                array_push($items, ...$provider->attentionItems($actor, $context));
            }
        }
        usort($items, static fn (AttentionItem $a, AttentionItem $b) => $b->urgency <=> $a->urgency);

        return $items;
    }

    /** @return WorkItem[] */
    private function collectWorkItems(ActorId $actor, ContextId $context): array
    {
        $items = [];
        foreach ($this->workItemProviders as $provider) {
            if ($provider->supports($actor, $context)) {
                array_push($items, ...$provider->activeWorkItems($actor, $context));
            }
        }

        return $items;
    }
}
