<?php

declare(strict_types=1);

namespace Patterns\Daniel\Products;

interface ProductInterface
{
    public function getName(): string;

    public function getPrice(): float;

    public function getIngredients(): array;
}