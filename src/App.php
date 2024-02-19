<?php

declare(strict_types=1);

namespace Patterns\Daniel;

use Patterns\Daniel\Patterns\AbstractFactory\ProductFactoryInterface;
use Patterns\Daniel\Patterns\Adapter\PizzaAdapter;
use Patterns\Daniel\Patterns\Builder\OrderBuilderInterface;
use Patterns\Daniel\Patterns\Decorator\IngredientsDecorator;
use Patterns\Daniel\Patterns\Observer\ObserverInterface;
use Patterns\Daniel\Products\Pizza;

class App
{
    public function __construct(
        private readonly ProductFactoryInterface $productFactory,
        private readonly OrderBuilderInterface   $orderBuilder,
        private readonly ObserverInterface       $preparationObserver,
    )
    {

    }

    public function run(): void
    {
        $burger = $this->productFactory->createBurger();

        // Adding ingredients using the decorator
        $customBurger = new IngredientsDecorator(new IngredientsDecorator($burger, "Sauce", 0.20), "Cheese", 0.50);

        // Using the pizza adapter
        $pizza = new Pizza(); // A pizza that does not implement ProductInterface initially.
        $pizzaAdapter = new PizzaAdapter($pizza);

        $this->orderBuilder->addProduct($customBurger)->addProduct($pizzaAdapter);
        $order = $this->orderBuilder->getOrder();

        $this->processOrder($order);
    }

    protected function processOrder($order): void
    {
        echo "Start of order processing...\n";

        // There could be logic here to check and prepare the order, for example:
        foreach ($order as $item) {
            // Simulate processing of each order item
            echo "Preparing: {$item['product']->getName()}\n";
            // Assume we have a method to notify observers
            $this->preparationObserver->update('order_prepared', ['orderId' => 123, 'status' => 'prepared']);
        }

        echo "The order is ready and can be handed over to the customer.\n";
    }
}
