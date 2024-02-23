<?php

namespace Shabanov\Otusphp\Fabrics;

use Shabanov\Otusphp\Interfaces\ProductInterface;

abstract class AbstractProductFabric
{
    abstract public static function createProduct(): ProductInterface;
}
