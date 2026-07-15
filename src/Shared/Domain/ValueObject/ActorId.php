<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

final readonly class ActorId
{
    public function __construct(public readonly string $value)
    {
        if ('' === $value) {
            throw new \InvalidArgumentException('ActorId cannot be empty.');
        }
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
