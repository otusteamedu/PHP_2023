<?php

namespace Cases\Php2023\Domain\Aggregates\Sandwich;

use Cases\Php2023\Domain\Aggregates\Abstract\AbstractDish;
use Cases\Php2023\Domain\Aggregates\Interface\DishInterface;
use Cases\Php2023\Domain\Aggregates\ValueObject\Bread;
use Cases\Php2023\Domain\Aggregates\ValueObject\Meat;
use Cases\Php2023\Domain\Aggregates\ValueObject\Sausage;

class Sandwich extends AbstractDish
{
    private Bread $bread;
    private Meat $meat;
    private Sausage $sausage;

    private function __construct()
    {
    }

    public static function createCustomer(Bread $bread, Meat $meat, Sausage $sausage): Sandwich
    {
        $sandwich = new self();
        $sandwich->bread = $bread;
        $sandwich->meat = $meat;
        $sandwich->sausage = $sausage;
        return $sandwich;
    }

    public static function createClassic(): Sandwich
    {
        $sandwich = new self();
        $sandwich->bread = new Bread(Bread::TYPE_WHITE);
        $sandwich->meat = new Meat(Meat::TYPE_VEGETARIAN);
        $sandwich->sausage = new Sausage(Sausage::SAUCE_KETCHUNNAISE);
        $sandwich->addIngredient('лук');
        $sandwich->addIngredient('помидор');
        return $sandwich;
    }
}