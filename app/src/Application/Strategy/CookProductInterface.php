<?php

namespace AYamaliev\Hw16\Application\Strategy;

use AYamaliev\Hw16\Domain\Entity\Product;

interface CookProductInterface
{
    public function cook(Product $product): void;
}
