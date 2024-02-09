<?php

namespace HW11\Elastic\DI\Restaurant;

use HW11\Elastic\DI\Factory\ProductFactory;
use HW11\Elastic\DI\Decorator\SaladDecorator;
use HW11\Elastic\DI\Observer\CookingStatusObserver;
use HW11\Elastic\DI\Proxy\CookingProxy;
use HW11\Elastic\DI\Strategy\BurgerCookingStrategy;
use HW11\Elastic\DI\Observer\CookingSubject;

class Restaurant
{
    private ProductFactory $factory;
    private CookingSubject $cookingSubject;
    public function __construct(ProductFactory $factory, CookingSubject $cookingSubject)
    {
        $this->factory        = $factory;
        $this->cookingSubject = $cookingSubject;
    }
    /**
     * @return void
     */
    public function orderProduct(): void
    {
        $product = $this->factory->createProduct();
        $product = new SaladDecorator($product);
        $product = new CookingProxy($product);
        // Добавляем наблюдателя
        $this->cookingSubject->addObserver(new CookingStatusObserver());
        // Стратегия приготовления
        $cookingStrategy = new BurgerCookingStrategy();
        // Приготовление продукта
        $cookingStrategy->cook();
        $product->prepare();
        // Обновляем статус приготовления
        $this->cookingSubject->setStatus("Product is Ready");
    }
}
