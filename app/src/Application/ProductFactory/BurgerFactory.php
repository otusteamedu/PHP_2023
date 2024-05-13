<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Application\ProductFactory;

use AYamaliev\Hw16\Domain\Entity\Burger;
use AYamaliev\Hw16\Domain\Entity\Product;

class BurgerFactory implements ProductFactoryInterface
{
    public function cook(string $title, float $price): Product
    {
        return new Burger($title, $price);
    }
}
