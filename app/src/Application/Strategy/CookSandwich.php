<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Application\Strategy;

use AYamaliev\Hw16\Domain\Entity\ProductInterface;

class CookSandwich implements CookProductInterface
{
    public function cook(ProductInterface $product): void
    {
        $product->cook();
    }
}