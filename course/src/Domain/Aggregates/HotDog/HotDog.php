<?php

namespace Cases\Php2023\Domain\Aggregates\HotDog;

use Cases\Php2023\Domain\Aggregates\Abstract\AbstractDish;
use Cases\Php2023\Domain\Aggregates\Interface\DishInterface;
use Cases\Php2023\Domain\Aggregates\ValueObject\Bread;
use Cases\Php2023\Domain\Aggregates\ValueObject\Meat;
use Cases\Php2023\Domain\Aggregates\ValueObject\Sausage;

class HotDog extends AbstractDish
{
    private Bread $bread;

    private Meat $meat;
    private Sausage $sausage;

    private function __construct()
    {
    }

    public static function createCustomer(Bread $bread, Meat $meat, Sausage $sausage): HotDog
    {
        $hotDog = new self();
        $hotDog->bread = $bread;
        $hotDog->sausage = $sausage;
        $hotDog->meat = $meat;
        return $hotDog;
    }

    public static function createClassic(): HotDog
    {
        $hotDog = new self();
        $hotDog->bread = new Bread(Bread::TYPE_WHITE);
        $hotDog->meat = new Meat(Meat::TYPE_VEGETARIAN);
        $hotDog->sausage = new Sausage(Sausage::SAUCE_KETCHUNNAISE);
        $hotDog->addIngredient('лук');
        $hotDog->addIngredient('помидор');
        return $hotDog;
    }
}