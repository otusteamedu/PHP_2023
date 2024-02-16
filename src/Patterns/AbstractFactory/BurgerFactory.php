<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\AbstractFactory;

use Exception;
use Patterns\Daniel\Products\Burger;
use Patterns\Daniel\Products\ProductInterface;

class BurgerFactory implements ProductFactoryInterface
{

    public function createBurger(): ProductInterface
    {
        return new Burger();
    }

    /**
     * @throws Exception
     */
    public function createSandwich(): ProductInterface
    {
        throw new Exception("Sandwiches are not made at BurgerFactory");
    }

    /**
     * @throws Exception
     */
    public function createHotDog(): ProductInterface
    {
        throw new Exception("Hot dogs are not made at BurgerFactory");
    }
}