<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility;

use App\Builder\FoodInterface;

class CutVegetableHandler extends FoodHandler
{
    public function handle(FoodInterface $food): void
    {
        $this->cutVegetable($food->getIngredients());
        parent::handle($food);
    }

    private function cutVegetable(array $ingredients): void
    {
        // cut the vegetable
    }
}
