<?php

namespace Cases\Php2023\Domain\Aggregates\Interface;

use Cases\Php2023\Domain\Pattern\Composite\OrderComposite;

interface DishCreationStrategyInterface
{
    public function createDish(RequestOrderInterface $order): DishInterface;
}