<?php

namespace Cases\Php2023\Domain\Pattern\Strategy;

use Cases\Php2023\Domain\Aggregates\Burger\Burger;
use Cases\Php2023\Domain\Aggregates\Interface\DishCreationStrategyInterface;
use Cases\Php2023\Domain\Aggregates\Interface\DishInterface;
use Cases\Php2023\Domain\Aggregates\Interface\RequestOrderInterface;
use Cases\Php2023\Domain\Aggregates\Sandwich\Sandwich;
use Cases\Php2023\Domain\Pattern\ChainOfResponsibility\CookingCompleteHandler;
use Cases\Php2023\Domain\Pattern\ChainOfResponsibility\CookingStatusHandler;
use Cases\Php2023\Domain\Pattern\Iterator\IngredientsIterator;

class SandwichCreationStrategy implements DishCreationStrategyInterface
{

    /**
     * Стратегия создания
     */
    public function createDish(RequestOrderInterface $order): DishInterface
    {

        /**
         * Создали блюдо
         */
        $dish = Sandwich::createClassic();

        /**
         * Добавили игредиенты Итератор
         */
        $ingredientsIterator = new IngredientsIterator($order->addIngredients);
        $dish->addIngredientsFromIterator($ingredientsIterator);

        /**
         *  цепочка обязанностей
         */
        $cookingHandler = new CookingStatusHandler();
        $completeHandler = new CookingCompleteHandler();
        $cookingHandler->setNext($completeHandler);
        $cookingHandler->handle();

        return $dish;
    }
}