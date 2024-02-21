<?php

namespace Shabanov\Otusphp;

use Shabanov\Otusphp\Adapter\PizzaAdapter;
use Shabanov\Otusphp\Builder\ProductBuilder;
use Shabanov\Otusphp\Decorator\OnionIngradient;
use Shabanov\Otusphp\Decorator\PepperIngradient;
use Shabanov\Otusphp\Decorator\SaladIngradient;
use Shabanov\Otusphp\Entity\Client;
use Shabanov\Otusphp\Interfaces\ProductInterface;
use Shabanov\Otusphp\Observer\Event;
use Shabanov\Otusphp\Services\Cooking;

class App
{
    private const PRODUCT = 'Shabanov\Otusphp\Fabrics\BurgerFabric';
    private Event $event;
    public function __construct() {}

    public function run()
    {
        /**
         * Создадим клиентов и слушатель событий
         */
        $this->createClients();
        /**
         * Создадим продукт
         */
        $product = $this->createProduct();
        $product = (new ProductBuilder($product))
            ->addOnion()
            ->addPepper()
            ->addSalad()
            ->build();
        /**
         * Приготовим продукт
         */
        $cooking = new Cooking($product, $this->event);
        $cooking->run();
        /**
         * Пиццу приготовим через адаптер
         */
        $pizzaAdapter = new PizzaAdapter($this->event);
        $pizzaAdapter->cook();
    }

    private function createProduct(): ProductInterface
    {
        return self::PRODUCT::createProduct();
    }

    private function createClients(): void
    {
        $client1 = new Client('Вячеслав');
        $client2 = new Client('Сергей');
        $this->event = new Event();
        $this->event->addSubscriber($client1)
            ->addSubscriber($client2);
    }
}
