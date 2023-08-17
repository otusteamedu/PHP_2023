<?php
declare(strict_types=1);

namespace Root\App\Burger;

use Root\App\Product;
use Root\App\ProductBuilderAbstract;

class BurgerStandartBuilder extends ProductBuilderAbstract
{
    public function build(): Product
    {
        $product = new Burger($this->lettuce, $this->onion, $this->pepper);

        echo 'Build ', $product->getName(), ' standart: Lettuce = ', $product->getLettuce(),
        ', Onion = ', $product->getOnion(), ', Pepper = ', $product->getPepper(), PHP_EOL;
        return $product;
    }
}