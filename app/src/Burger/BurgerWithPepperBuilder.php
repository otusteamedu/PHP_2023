<?php

declare(strict_types=1);

namespace Root\App\Burger;

use Root\App\Product;
use Root\App\ProductBuilderAbstract;

class BurgerWithPepperBuilder extends ProductBuilderAbstract
{
    protected int $pepper = 1;
    public function build(): Product
    {
        $product = new Burger($this->lettuce, $this->onion, $this->pepper);

        echo 'Build Burger with pepper: Lettuce = ', $product->getLettuce(),
        ', Onion = ', $product->getOnion(), ', Pepper = ', $product->getPepper(), PHP_EOL;
        return $product;
    }
}
