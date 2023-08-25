<?php

namespace IilyukDmitryi\App\Domain\Order\ChainResponsibility\Holiday;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\AbstarctStepOrder;

class PayHolidayStep extends AbstarctStepOrder
{
    public function step(FoodInterface $food): void
    {
        if (rand() % 3 == 0) {
            throw new Exception($food->getNameFood() . '  стоит больше, пополните карту!');
        }
        parent::step($food);
    }
}
