<?php

namespace Cases\Php2023\Domain\Aggregates\Burger;

use Cases\Php2023\Domain\Aggregates\Abstract\AbstractDish;
use Cases\Php2023\Domain\Aggregates\Interface\DishInterface;
use Cases\Php2023\Domain\Aggregates\ValueObject\Bread;
use Cases\Php2023\Domain\Aggregates\ValueObject\Meat;
use Cases\Php2023\Domain\Aggregates\ValueObject\Sausage;
use Iterator;

class Burger extends AbstractDish
{
    private Bread $bread;
    private Meat $meat;
    private Sausage $sausage;

    private function __construct()
    {
    }

    public static function createCustomer(
        Bread $bread,
        Meat $meat,
        Sausage $sausage
    ): Burger
    {
        $burger = new self();
        $burger->bread = $bread;
        $burger->meat = $meat;
        $burger->sausage = $sausage;
        return $burger;
    }

    public static function createClassic(): Burger
    {
        $burger = new self();
        $burger->bread = new Bread(Bread::TYPE_WHITE);
        $burger->meat = new Meat(Meat::TYPE_VEGETARIAN);
        $burger->sausage = new Sausage(Sausage::SAUCE_KETCHUNNAISE);
        $burger->addIngredient('лук');
        $burger->addIngredient('помидор');
        return $burger;
    }


}