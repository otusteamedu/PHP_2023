<?php

namespace IilyukDmitryi\App\Domain\Order;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\CreatorFood\CreatorFoodStrategyInterface;
use IilyukDmitryi\App\Domain\Food\FoodInterface;

class Order
{
    protected ?FoodInterface $food = null;
    protected OrderStrategyInterface $orderStrategy;

    public function __construct(protected CreatorFoodStrategyInterface $creatorFood)
    {
    }

    /**
     * @throws Exception
     */
    public function exec(): void
    {
        $this->food = $this->creatorFood->build();
        $this->makeOrderStrategy();
        $this->orderStrategy->order($this->food);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    protected function makeOrderStrategy(): void
    {
        $this->orderStrategy = Di::getContainer()->get(OrderStrategyInterface::class);
    }

    public function getFood(): FoodInterface
    {
        return $this->food;
    }
}
