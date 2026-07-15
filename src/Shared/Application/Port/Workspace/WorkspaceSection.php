<?php

declare(strict_types=1);

namespace App\Shared\Application\Port\Workspace;

final readonly class WorkspaceSection
{
    public function __construct(
        public readonly string $id,
        public readonly string $platform,
        public readonly string $title,
        public readonly int $priority,
        public readonly array $payload,
    ) {}
}
