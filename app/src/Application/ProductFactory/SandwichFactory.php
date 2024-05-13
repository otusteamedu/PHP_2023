<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Application\ProductFactory;

use AYamaliev\Hw16\Domain\Entity\Product;
use AYamaliev\Hw16\Domain\Entity\Sandwich;

class SandwichFactory implements ProductFactoryInterface
{
    public function cook(string $title, float $price): Product
    {
        return new Sandwich($title, $price);
    }
}
