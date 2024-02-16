<?php

namespace App;

use App\Patterns\AbstractFactory\BurgerFactory;
use App\Patterns\AbstractFactory\ProductFactoryInterface;
use App\Patterns\Adapter\PizzaAdapter;
use App\Patterns\Builder\OrderBuilder;
use App\Patterns\Decorator\IngredientsDecorator;
use App\Patterns\Observer\PreparationObserver;
use App\Products\Pizza;

class App
{
    /**
     * @var ProductFactoryInterface
     */
    private ProductFactoryInterface $productFactory;

    /**
     * @var OrderBuilder
     */
    private OrderBuilder $orderBuilder;

    /**
     * @var PreparationObserver
     */
    private PreparationObserver $preparationObserver;

    public function __construct()
    {
        $this->productFactory = new BurgerFactory();
        $this->orderBuilder =  new OrderBuilder();
        $this->preparationObserver = new PreparationObserver();
    }

    /**
     * Запуск приложения.
     */
    public function run()
    {
        // Добавление ингредиентов с использованием декоратора
        $burger = $this->productFactory->createBurger();
        $customBurger = new IngredientsDecorator(new IngredientsDecorator($burger, "Соус", 0.20), "Сыр", 0.50);

// Использование адаптера для пиццы
        $pizza = new Pizza(); // Пицца, не реализующая ProductInterface изначально.
        $pizzaAdapter = new PizzaAdapter($pizza);

// Обработка заказа с кастомным бургером и пиццей через адаптер
        $this->orderBuilder->addProduct($customBurger)->addProduct($pizzaAdapter);
        $order = $this->orderBuilder->getOrder();

        $this->processOrder($order);
    }

    protected function processOrder($order): void
    {
        echo "Начало обработки заказа...\n";

        // Здесь могла бы быть логика проверки и подготовки заказа, например:
        foreach ($order as $item) {
            // Имитация обработки каждого элемента заказа
            echo "Подготавливается: {$item['product']->getName()}\n";
            // Предполагаем, что у нас есть метод для уведомления наблюдателей
            $this->preparationObserver->update('order_prepared', ['orderId' => 123, 'status' => 'prepared']);
        }

        echo "Заказ готов и может быть передан клиенту.\n";
    }
}
