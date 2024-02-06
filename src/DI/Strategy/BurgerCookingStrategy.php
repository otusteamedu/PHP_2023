<?php

namespace HW11\Elastic\DI\Strategy;

use HW11\Elastic\DI\Product\Product;
// Стратегия
class BurgerCookingStrategy implements CookingStrategy {
    public function cook(Product $product): void {
        echo "Приготовление бургера с использованием стратегии бургера\n";
    }
}
