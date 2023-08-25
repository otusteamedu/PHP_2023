<?php

namespace IilyukDmitryi\App\Domain\Order\ChainResponsibility\Workday;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;
use IilyukDmitryi\App\Domain\Order\ChainResponsibility\AbstarctStepOrder;

class CollectStep extends AbstarctStepOrder
{
    public function step(FoodInterface $food): void
    {
        if (rand() % 2 == 0) {
            throw new Exception($food->getNameFood() . ' не влез на поднос!');
        }
        parent::step($food);
    }
}
