<?php

declare(strict_types=1);

namespace src\Application\Publisher;

use src\Domain\Entity\Food\FoodInterface;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber): void;

    public function unsubscribe(SubscriberInterface $subscriber): void;

    public function notify(FoodInterface $food, string $status);
}
