<?php

namespace App\Patterns\AbstractFactory;

use App\Products\Sandwich;
use App\Products\ProductInterface;

class SandwichFactory implements ProductFactoryInterface
{
    /**
     * Создает экземпляр сэндвича.
     *
     * @return ProductInterface Возвращает сэндвич, реализующий интерфейс ProductInterface.
     */
    public function createSandwich(): ProductInterface
    {
        return new Sandwich();
    }

    /**
     * Создание бургера не поддерживается этой фабрикой.
     */
    public function createBurger(): ProductInterface
    {
        throw new \Exception("Бургеры не производятся в SandwichFactory");
    }

    /**
     * Создание хот-дога не поддерживается этой фабрикой.
     */
    public function createHotDog(): ProductInterface
    {
        throw new \Exception("Хот-доги не производятся в SandwichFactory");
    }
}