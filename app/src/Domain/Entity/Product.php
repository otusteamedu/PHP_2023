<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Domain\Entity;

abstract class Product implements ProductInterface
{
    public function __construct(
        private string $title,
        private float $price,
    )
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function cook(): void
    {
        echo "Приготовление {$this->title}";
    }
}
