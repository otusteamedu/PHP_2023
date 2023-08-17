<?php

declare(strict_types=1);

namespace Root\App\Sandwich;

use Root\App\Product;
use Root\App\ProductBuilderAbstract;

class SandwichStandartBuilder extends ProductBuilderAbstract
{
    public function __construct()
    {
        $this->onion = 1;
        $this->lettuce = 2;
        $this->pepper = 0;
    }

    public function build(): Product
    {
        $product = new Sandwich($this->lettuce, $this->onion, $this->pepper);

        echo 'Build ', $product->getName(), ' standart: Lettuce = ', $product->getLettuce(),
        ', Onion = ', $product->getOnion(), ', Pepper = ', $product->getPepper(), PHP_EOL;
        return $product;
    }
}
