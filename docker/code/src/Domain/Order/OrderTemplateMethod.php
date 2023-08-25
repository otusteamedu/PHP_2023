<?php

namespace IilyukDmitryi\App\Domain\Order;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;
use IilyukDmitryi\App\Domain\Order\TemplateMethod\HolidayOrder;
use IilyukDmitryi\App\Domain\Order\TemplateMethod\WorkdayOrder;

class OrderTemplateMethod implements OrderStrategyInterface
{
    /**
     * @param FoodInterface $food
     * @return void
     * @throws Exception
     */
    public function order(FoodInterface $food): void
    {
        if ($this->isHoliday()) {
            $orderTemlate = new HolidayOrder($food);
        } else {
            $orderTemlate = new WorkdayOrder($food);
        }
        $orderTemlate->order();
    }

    protected function isHoliday(): bool
    {
        return rand() % 2 == 0;
    }
}
