<?php

declare(strict_types=1);

namespace src\Application\Publisher;

use src\Domain\Entity\Food\FoodAbstract;

class Publisher implements PublisherInterface
{
    /**
     * @var SubscriberInterface[]
     */
    private array $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        // TODO: Implement unsubscribe() method.
    }

    public function notify(FoodAbstract $food, string $status): void
    {
        foreach ($this->subscribers as $subscriber){
            $subscriber->update($food, $status);
        }
    }
}
