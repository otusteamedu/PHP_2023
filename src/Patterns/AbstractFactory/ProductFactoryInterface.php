<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\AbstractFactory;

use Patterns\Daniel\Products\ProductInterface;

interface ProductFactoryInterface
{
    public function createBurger(): ProductInterface;

    public function createSandwich(): ProductInterface;

    public function createHotDog(): ProductInterface;
}
