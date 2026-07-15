<?php

declare(strict_types=1);

namespace App\Shared\Application\Port\Workspace;

final readonly class WorkItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $platform,
        public readonly string $type,
        public readonly string $label,
        public readonly string $status,
        public readonly \DateTimeImmutable $startedAt,
    ) {}
}
