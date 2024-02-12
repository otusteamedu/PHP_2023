<?php

declare(strict_types=1);

namespace App\Observer;

use App\Builder\FoodInterface;

class CookingStatusPublisher implements CookingStatusPublisherInterface
{
    private FoodInterface $food;
    private array $subscribers = [];
    private string $status = 'accept';

    public function __construct(FoodInterface $food)
    {
        $this->food = $food;
    }

    public function subscribe(CookingStatusObserverInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(CookingStatusObserverInterface $subscriber): void
    {
        $index = array_search($subscriber, $this->subscribers, true);
        if ($index !== false) {
            unset($this->subscribers[$index]);
        }
    }

    public function notify(): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($this->food, $this->status);
        }
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
        $this->notify();
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
