<?php

declare(strict_types=1);

namespace App\Observer;

interface CookingStatusPublisherInterface
{
    public function subscribe(CookingStatusObserverInterface $subscriber): void;

    public function unsubscribe(CookingStatusObserverInterface $subscriber): void;

    public function notify(): void;
}
