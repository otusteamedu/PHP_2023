<?php

namespace App\Patterns\AbstractFactory;

use App\Products\Burger;
use App\Products\ProductInterface;

class BurgerFactory implements ProductFactoryInterface
{
    /**
     * Создает экземпляр бургера.
     *
     * @return ProductInterface Возвращает бургер, реализующий интерфейс ProductInterface.
     */
    public function createBurger(): ProductInterface
    {
        return new Burger();
    }

    /**
     * Создание сэндвича не поддерживается этой фабрикой.
     * @throws \Exception
     */
    public function createSandwich(): ProductInterface
    {
        throw new \Exception("Сэндвичи не производятся в BurgerFactory");
    }

    /**
     * Создание хот-дога не поддерживается этой фабрикой.
     * @throws \Exception
     */
    public function createHotDog(): ProductInterface
    {
        throw new \Exception("Хот-доги не производятся в BurgerFactory");
    }
}