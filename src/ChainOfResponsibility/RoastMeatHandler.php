<?php

declare(strict_types=1);

namespace App\ChainOfResponsibility;

use App\Builder\FoodInterface;

class RoastMeatHandler extends FoodHandler
{
    public function handle(FoodInterface $food): void
    {
        $this->roastMeat($food->getIngredients());
        parent::handle($food);
    }

    private function roastMeat(array $getIngredients)
    {
        // roast the meat
    }
}
