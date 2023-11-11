<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Order;

use User\Php2023\Domain\Interfaces\Food;

class Order {

    private $items = [];

    public function addItem(Food $item): void
    {
        $this->items[] = $item;
        $item->adding();
    }

    public function getItems(): array {
        return $this->items;
    }
}
