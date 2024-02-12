<?php

declare(strict_types=1);

namespace App\Observer;

use App\Builder\FoodInterface;

class User implements CookingStatusObserverInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function update(FoodInterface $food, string $status): void
    {
        // Какая-то логика при изменении статуса заказа, для примера вывод
        echo "Для пользователя $this->name Блюдо:{$food->getName()} перешло в статус $status";
        echo "<br>";
    }
}
