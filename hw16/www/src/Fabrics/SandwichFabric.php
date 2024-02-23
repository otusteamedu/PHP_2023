<?php

namespace Shabanov\Otusphp\Fabrics;

use Shabanov\Otusphp\Entity\Sandwich;
use Shabanov\Otusphp\Interfaces\ProductInterface;

class SandwichFabric extends AbstractProductFabric
{

    public static function createProduct(): ProductInterface
    {
        return new Sandwich();
    }
}
