<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Domain\ValueObject;

final class Condition
{
    public function __construct(
        private readonly string $key,
        private readonly string|int $value,
    ) {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string|int
    {
        return $this->value;
    }
}
