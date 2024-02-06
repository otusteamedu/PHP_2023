<?php

namespace HW11\Elastic\DI\Product;

class Burger implements Product {
    private string $name;
    private float $price;
    private BurgerRecipeComponent $recipeComponent;
    public function __construct(string $name, float $price, BurgerRecipeComponent $recipeComponent) {
        $this->name = $name;
        $this->price = $price;
        $this->recipeComponent = $recipeComponent;
    }
    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
    /**
     * @return float
     */
    public function getPrice(): float {
        return $this->price;
    }
    /**
     * @return void
     */
    public function prepare(): void {
        $ingredients = $this->recipeComponent->getIngredients();
        echo "Подготовка бургера с ингредиентами: " . implode(', ', $ingredients) . "\n";
    }
}
