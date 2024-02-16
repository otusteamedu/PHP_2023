<?php

namespace App\Patterns\AbstractFactory;

use App\Products\HotDog;
use App\Products\ProductInterface;

class HotDogFactory implements ProductFactoryInterface
{
    /**
     * Создает экземпляр хот-дога.
     *
     * @return ProductInterface Возвращает хот-дог, реализующий интерфейс ProductInterface.
     */
    public function createHotDog(): ProductInterface
    {
        return new HotDog();
    }

    /**
     * Создание бургера не поддерживается этой фабрикой.
     */
    public function createBurger(): ProductInterface
    {
        throw new \Exception("Бургеры не производятся в HotDogFactory");
    }

    /**
     * Создание сэндвича не поддерживается этой фабрикой.
     */
    public function createSandwich(): ProductInterface
    {
        throw new \Exception("Сэндвичи не производятся в HotDogFactory");
    }
}