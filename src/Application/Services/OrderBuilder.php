<?php

declare(strict_types=1);

namespace User\Php2023\Application\Services;

use User\Php2023\Domain\Interfaces\Food;
use User\Php2023\Infrastructure\Order\Order;

class OrderBuilder
{
    private array $foods = [];

    public function addFood(Food $food): self
    {
        $this->foods[] = $food;
        return $this;
    }

    public function build(): Order
    {
        $order = new Order();
        foreach ($this->foods as $food) {
            $order->addItem($food);
        }
        return $order;
    }
}
