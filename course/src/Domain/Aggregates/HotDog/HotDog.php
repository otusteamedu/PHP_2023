<?php

namespace Cases\Php2023\Domain\Aggregates\HotDog;

use Cases\Php2023\Domain\Aggregates\Abstract\AbstractDish;
use Cases\Php2023\Domain\Aggregates\Interface\DishComponentInterface;
use Cases\Php2023\Domain\Aggregates\Interface\DishInterface;
use Cases\Php2023\Domain\Aggregates\ValueObject\Bread;
use Cases\Php2023\Domain\Aggregates\ValueObject\Meat;
use Cases\Php2023\Domain\Aggregates\ValueObject\Sausage;

class HotDog extends AbstractDish implements DishComponentInterface
{
    private Bread $bread;

    private Meat $meat;
    private Sausage $sausage;

    private string $name;

    private function __construct()
    {
    }

    public static function createClassic(): HotDog
    {
        $hotDog = new self();
        $hotDog->name = 'HotDog';
        $hotDog->bread = new Bread(Bread::TYPE_WHITE);
        $hotDog->meat = new Meat(Meat::TYPE_VEGETARIAN);
        $hotDog->sausage = new Sausage(Sausage::SAUCE_KETCHUNNAISE);
        $hotDog->addIngredient('лук');
        $hotDog->addIngredient('помидор');
        return $hotDog;
    }

    public function getName(): string
    {
        return $this->name;
    }
}