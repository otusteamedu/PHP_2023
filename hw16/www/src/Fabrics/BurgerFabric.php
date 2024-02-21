<?php

namespace Shabanov\Otusphp\Fabrics;

use Shabanov\Otusphp\Entity\Burger;
use Shabanov\Otusphp\Interfaces\ProductInterface;

class BurgerFabric extends AbstractProductFabric
{

    public static function createProduct(): ProductInterface
    {
        return new Burger();
    }
}
