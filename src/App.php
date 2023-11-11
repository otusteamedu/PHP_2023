<?php

declare(strict_types=1);

namespace User\Php2023;

use Exception;
use User\Php2023\Application\Observers\MobileAppObserver;
use User\Php2023\Application\Services\CookingProcess;
use User\Php2023\Application\Services\OrderBuilder;
use User\Php2023\Domain\ObjectValues\FoodType;
use User\Php2023\Infrastructure\Cooking\CookingProxy;
use User\Php2023\Infrastructure\Food\FoodFactory;
use User\Php2023\Infrastructure\Order\OrderIterator;

class App {

    public function __construct(
        private readonly FoodFactory $foodFactory,
        private readonly OrderBuilder $orderBuilder,
        private readonly CookingProcess $cookingProcess,
        private readonly CookingProxy $cookingProxy
    ) {
    }

    /**
     * @throws Exception
     */
    public function run(): void {
        foreach (FoodType::cases() as $foodType) {
            $count = random_int(0, 5);
            for ($i = 0; $i < $count; $i++) {
                $foodItem = $this->foodFactory->createFood($foodType);
                $this->orderBuilder->addFood($foodItem);
            }
        }

        $order = $this->orderBuilder->build();
        $orderIterator = new OrderIterator($order->getItems());
        $mobileAppObserver = new MobileAppObserver();
        $this->cookingProcess->attach($mobileAppObserver);
        foreach ($orderIterator as $item) {
            $this->cookingProcess->food = $item;
            $this->cookingProxy->cook($item);
            echo $item->type->getFoodName() . " #" . $item->number . ": " . $this->cookingProxy->getStatus()->getStatusName() . "\n";
        }
    }
}
