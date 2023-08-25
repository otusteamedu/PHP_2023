<?php

namespace IilyukDmitryi\App\Domain\Order\TemplateMethod;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;

class WorkdayOrder extends AbstractOrder
{

    public function __construct(FoodInterface $food)
    {
        parent::__construct($food);
        if ($this->isLunch()) {
            $this->priceLunch();
        }
    }

    protected function isLunch(): bool
    {
        return rand() % 2 == 0;
    }

    protected function priceLunch(): void
    {
        $this->food->setPrice($this->food->getPrice() - 1);
    }

    /**
     * @throws Exception
     */
    protected function cook(): void
    {
        if ($this->isLunch()) {
            if (rand() % 2 == 0) {
                throw new Exception($this->food->getNameFood() . ' не входит в бизнес-ланч. Выберите другое блюдо!');
            }
        } elseif (rand() % 2 == 0) {
            throw new Exception("На " . $this->food->getNameFood() . ' все съели :-( Попробуйте позже!');
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
