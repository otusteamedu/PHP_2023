<?php

use Cases\Php2023\Domain\Pattern\ChainOfResponsibility\CookingCompleteHandler;
use Cases\Php2023\Domain\Pattern\ChainOfResponsibility\CookingStatusHandler;
use Cases\Php2023\Domain\Pattern\Factory\DishFactory;
use Cases\Php2023\Domain\Pattern\Iterator\IngredientsIterator;

$isClassic = $_POST['classic']; // true
$typeDish = $_POST['typeDish']; // Burger
$ingredients = $_POST['ingredients']; // ['салат', 'лук']


/**
 * Создали блюдо
 */
$dish = null;
if ($isClassic) {
    $dish = DishFactory::createDishClassic($typeDish);
}

$ingredientsIterator = new IngredientsIterator($ingredients);

/**
 * Добавили игредиенты
 */
$dish?->addIngredientsFromIterator($ingredientsIterator);

/**
 *  цепочка обязанностей
 */
$cookingHandler = new CookingStatusHandler();
$completeHandler = new CookingCompleteHandler();
$cookingHandler->setNext($completeHandler);
$cookingHandler->handle();