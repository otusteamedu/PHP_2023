<?php

declare(strict_types=1);

namespace src\Application\Publisher;

use src\Domain\Entity\Food\FoodAbstract;

interface SubscriberInterface
{
    public function update(FoodAbstract $food, string $status);
}
