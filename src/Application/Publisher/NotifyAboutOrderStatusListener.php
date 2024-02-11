<?php

declare(strict_types=1);

namespace src\Application\Publisher;

use src\Domain\Entity\Food\FoodAbstract;

class NotifyAboutOrderStatusListener implements SubscriberInterface
{

    public function update(FoodAbstract $food, string $status)
    {
        //TODO - отправляется уведомление о статусе приготовления
    }
}
