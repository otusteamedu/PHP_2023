<?php

namespace HW11\Elastic\DI;

use HW11\Elastic\DI\Product\Burger;
use HW11\Elastic\DI\Product\BurgerRecipeComponent;
use HW11\Elastic\DI\Product\Product;
use JetBrains\PhpStorm\Pure;

class DependencyContainer {
    /**
     * @return \HW11\Elastic\DI\Product\Product
     */
    #[Pure] public function createProduct(): Product {
        $recipeComponent = new BurgerRecipeComponent();
        return new Burger('Fatality Burger', 6.66, $recipeComponent);
    }
}
