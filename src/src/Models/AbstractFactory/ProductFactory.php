<?php

namespace App\Models\AbstractFactory;

use App\Models\Products\Burger;
use App\Models\Products\Sandwich;
use App\Models\Products\HotDog;

class ProductFactory
{
    public function createBurger(): Burger
    {
        return new Burger();
    }

    public function createSandwich(): Sandwich
    {
        return new Sandwich();
    }

    public function createHotDog(): HotDog
    {
        return new HotDog();
    }
}
