<?php

namespace Shabanov\Otusphp\Fabrics;

use Shabanov\Otusphp\Entity\HotDog;
use Shabanov\Otusphp\Interfaces\ProductInterface;

class HotDogFabric extends AbstractProductFabric
{

    public static function createProduct(): ProductInterface
    {
        return new HotDog();
    }
}
