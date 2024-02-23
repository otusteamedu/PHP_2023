<?php

namespace Shabanov\Otusphp\Adapter;

use Shabanov\Otusphp\Builder\ProductBuilder;
use Shabanov\Otusphp\Entity\Pizza;
use Shabanov\Otusphp\Interfaces\ProductInterface;
use Shabanov\Otusphp\Observer\Event;
use Shabanov\Otusphp\Services\Cooking;

class PizzaAdapter
{
    private ProductInterface $pizza;
    private Cooking $cooking;
    public function __construct(private Event $event)
    {
        $this->createPizza();
        $this->cooking = new Cooking($this->pizza, $this->event);
    }

    private function createPizza(): void
    {
        $this->pizza = (new ProductBuilder(new Pizza()))
            ->addSalad()
            ->addOnion()
            ->build();
    }

    public function cook(): void
    {
        $this->cooking->run();
    }
}
