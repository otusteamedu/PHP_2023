<?php

namespace AYamaliev\Hw16\Application\ProductFactory;

use AYamaliev\Hw16\Domain\Entity\Product;

interface ProductFactoryInterface
{
    public function cook(string $title, float $price): Product;
}
