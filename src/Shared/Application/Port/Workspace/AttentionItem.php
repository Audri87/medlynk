<?php

declare(strict_types=1);

namespace App\Shared\Application\Port\Workspace;

final readonly class AttentionItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $platform,
        public readonly string $type,
        public readonly string $label,
        public readonly int $urgency,
        public readonly \DateTimeImmutable $since,
        public readonly array $metadata,
    ) {}
}
