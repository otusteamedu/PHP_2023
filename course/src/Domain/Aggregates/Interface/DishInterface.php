<?php

namespace Cases\Php2023\Domain\Aggregates\Interface;

use Cases\Php2023\Domain\Pattern\Iterator\IngredientsIterator;

interface DishInterface extends \Cases\Php2023\Domain\Aggregates\Interface\DishComponentInterface
{
    public static function createClassic();

    public function addIngredient($ingredient);
    public function addIngredientsFromIterator(IngredientsIterator $iterator);

    public function getName(): string;
}