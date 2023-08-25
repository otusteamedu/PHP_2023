<?php

namespace IilyukDmitryi\App\Domain\Order\TemplateMethod;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;

class HolidayOrder extends AbstractOrder
{
    public function __construct(FoodInterface $food)
    {
        parent::__construct($food);
        $this->priceHoliday();
    }

    protected function priceHoliday(): void
    {
        $this->food->setPrice($this->food->getPrice() + 2);
    }

    /**
     * @throws Exception
     */
    protected function cook(): void
    {
        if (rand() % 2 == 0) {
            throw new Exception("На " . $this->food->getNameFood() . ' не хватило ингредиентов!');
        }
    }

    /**
     * @throws Exception
     */
    protected function pay(): void
    {
        if (rand() % 2 == 0) {
            throw new Exception($this->food->getNameFood() . '  стоит больше, пополните карту!');
        }
    }
}
