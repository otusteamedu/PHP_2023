<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Domain\ValueObject;

final class Stock
{
    public function __construct(
        private readonly string $name,
        private readonly int $quantity,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
