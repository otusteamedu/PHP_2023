<?php

namespace HW11\Elastic\DI\Product;

class BurgerRecipeComponent
{
    public function getIngredients(): array
    {
        return ['Булка', 'Котлетка', 'Помидор', 'Огурец', 'Сыр'];
    }
}
