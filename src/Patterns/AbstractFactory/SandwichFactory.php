<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\AbstractFactory;

use Exception;
use Patterns\Daniel\Products\ProductInterface;
use Patterns\Daniel\Products\Sandwich;

class SandwichFactory implements ProductFactoryInterface
{
    public function createSandwich(): ProductInterface
    {
        return new Sandwich();
    }

    /**
     * @throws Exception
     */
    public function createBurger(): ProductInterface
    {
        throw new Exception("Burgers are not made at SandwichFactory");
    }

    /**
     * @throws Exception
     */
    public function createHotDog(): ProductInterface
    {
        throw new Exception("Hot dogs are not made at SandwichFactory.");
    }
}