<?php

namespace IilyukDmitryi\App\Domain\Order\ChainResponsibility\Holiday;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\AbstarctStepOrder;

class DeliveryHolidayStep extends AbstarctStepOrder
{
    public function step(FoodInterface $food): void
    {
        if (rand() % 3 == 0) {
            throw new Exception("Поднос с " . $food->getNameFood() . ' уронили!');
        }
        parent::step($food);
    }
}
