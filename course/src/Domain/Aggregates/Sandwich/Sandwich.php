<?php

namespace Cases\Php2023\Domain\Aggregates\Sandwich;

use Cases\Php2023\Domain\Aggregates\Abstract\AbstractDish;
use Cases\Php2023\Domain\Aggregates\Interface\DishComponentInterface;
use Cases\Php2023\Domain\Aggregates\Interface\DishInterface;
use Cases\Php2023\Domain\Aggregates\ValueObject\Bread;
use Cases\Php2023\Domain\Aggregates\ValueObject\Meat;
use Cases\Php2023\Domain\Aggregates\ValueObject\Sausage;

class Sandwich extends AbstractDish implements DishComponentInterface
{
    private Bread $bread;
    private Meat $meat;
    private Sausage $sausage;

    private string $name;

    private function __construct()
    {
    }

    public static function createClassic(): Sandwich
    {
        $sandwich = new self();
        $sandwich->name = 'Sandwich';
        $sandwich->bread = new Bread(Bread::TYPE_WHITE);
        $sandwich->meat = new Meat(Meat::TYPE_VEGETARIAN);
        $sandwich->sausage = new Sausage(Sausage::SAUCE_KETCHUNNAISE);
        $sandwich->addIngredient('огурец');
        $sandwich->addIngredient('помидор');
        return $sandwich;
    }

    public function getName(): string
    {
        return $this->name;
    }
}