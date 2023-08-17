<?php

declare(strict_types=1);

namespace Root\App\Burger;

use Root\App\Product;
use Root\App\StrategyInterface;

class BurgerStrategy implements StrategyInterface
{
    public function cooking(Product $product): void
    {
        echo 'Cooking ', $product->getName(), ':', PHP_EOL;
        echo "\t add Lettuce = ", $product->getLettuce(), PHP_EOL;
        echo "\t add Onion = ", $product->getOnion(), PHP_EOL;
        echo "\t add Pepper = ", $product->getPepper(), PHP_EOL;
    }
}
