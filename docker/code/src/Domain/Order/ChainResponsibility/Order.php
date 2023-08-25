<?php

namespace IilyukDmitryi\App\Domain\Order\ChainResponsibility;

use IilyukDmitryi\App\Domain\Food\FoodInterface;

class Order
{
    public function __construct(protected FoodInterface $food)
    {
    }

    public function goStep(StepOrderInterface $stepOrder): void
    {
        $stepOrder->step($this->food);
    }
}
