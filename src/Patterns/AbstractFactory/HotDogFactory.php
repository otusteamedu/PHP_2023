<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\AbstractFactory;

use Exception;
use Patterns\Daniel\Products\HotDog;
use Patterns\Daniel\Products\ProductInterface;

class HotDogFactory implements ProductFactoryInterface
{
    public function createHotDog(): ProductInterface
    {
        return new HotDog();
    }

    /**
     * @throws Exception
     */
    public function createBurger(): ProductInterface
    {
        throw new Exception("Burgers are not made at HotDogFactory");
    }

    /**
     * @throws Exception
     */
    public function createSandwich(): ProductInterface
    {
        throw new Exception("Sandwiches are not made at HotDogFactory.");
    }
}
