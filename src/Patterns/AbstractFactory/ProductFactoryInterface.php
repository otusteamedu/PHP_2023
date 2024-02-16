<?php

namespace App\Patterns\AbstractFactory;

use App\Products\ProductInterface;

interface ProductFactoryInterface
{
    /**
     * Создать бургер.
     *
     * @return ProductInterface Возвращает объект продукта, реализующий интерфейс ProductInterface.
     */
    public function createBurger(): ProductInterface;

    /**
     * Создать сэндвич.
     *
     * @return ProductInterface Возвращает объект продукта, реализующий интерфейс ProductInterface.
     */
    public function createSandwich(): ProductInterface;

    /**
     * Создать хот-дог.
     *
     * @return ProductInterface Возвращает объект продукта, реализующий интерфейс ProductInterface.
     */
    public function createHotDog(): ProductInterface;
}