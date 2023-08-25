<?php

namespace IilyukDmitryi\App\Domain\Order\TemplateMethod;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;

abstract class AbstractOrder
{
    public function __construct(protected FoodInterface $food)
    {
    }

    /**
     * @throws Exception
     */
    final public function order(): void
    {
        $this->pay();
        $this->cook();
        $this->collect();
        $this->delivery();
    }

    abstract protected function pay(): void;

    abstract protected function cook(): void;

    /**
     * @throws Exception
     */
    protected function collect(): void
    {
        if (rand() % 2 == 0) {
            throw new Exception($this->food->getNameFood() . ' не влез на поднос!');
        }
    }

    /**
     * @throws Exception
     */
    protected function delivery(): void
    {
        if (rand() % 2 == 0) {
            throw new Exception("Поднос с " . $this->food->getNameFood() . ' уронили!');
        }
    }
}
