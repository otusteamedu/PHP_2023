<?php

declare(strict_types=1);

namespace Root\App\HotDog;

use Root\App\Product;
use Root\App\ProductBuilderAbstract;

class HotDogBuilder extends ProductBuilderAbstract
{
    public function build(): Product
    {
        $product = new HotDogAdapter($this->lettuce, $this->onion, $this->pepper);

        echo 'Build ', $product->getName(), ' standart: Lettuce = ', $product->getLettuce(),
        ', Onion = ', $product->getOnion(), ', Pepper = ', $product->getPepper(), PHP_EOL;
        return $product;
    }
}
