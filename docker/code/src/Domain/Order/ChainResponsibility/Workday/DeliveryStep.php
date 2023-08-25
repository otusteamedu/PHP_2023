<?php

namespace IilyukDmitryi\App\Domain\Order\ChainResponsibility\Workday;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\AbstarctStepOrder;

class DeliveryStep extends AbstarctStepOrder
{
    public function step(FoodInterface $food): void
    {
        if (rand() % 2 == 0) {
            throw new Exception("Поднос с " . $food->getNameFood() . ' уронили!');
        }
        parent::step($food);
    }
}
