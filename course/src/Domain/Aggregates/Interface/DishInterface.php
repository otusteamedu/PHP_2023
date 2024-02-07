<?php

namespace Cases\Php2023\Domain\Aggregates\Interface;

use Cases\Php2023\Domain\Pattern\Iterator\IngredientsIterator;

interface DishInterface
{
    public static function createClassic();

    public function addIngredient($ingredient);
    public function addIngredientsFromIterator(IngredientsIterator $iterator);
}