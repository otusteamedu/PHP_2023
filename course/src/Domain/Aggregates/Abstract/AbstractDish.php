<?php

namespace Cases\Php2023\Domain\Aggregates\Abstract;

use Cases\Php2023\Domain\Aggregates\Interface\DishInterface;
use Cases\Php2023\Domain\Pattern\Iterator\IngredientsIterator;


abstract class AbstractDish implements DishInterface
{

    private string $name;
    private array $ingredients = [];

    public function addIngredient($ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    public function addIngredientsFromIterator(IngredientsIterator $iterator): void
    {
        foreach ($iterator as $ingredient) {
            $this->addIngredient($ingredient);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }


}