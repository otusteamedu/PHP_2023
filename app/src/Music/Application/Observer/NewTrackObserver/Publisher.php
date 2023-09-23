<?php

declare(strict_types=1);

namespace App\Music\Application\Observer\NewTrackObserver;

use App\Music\Domain\Entity\Track;

class Publisher implements PublisherInterface
{
    /**
     * @var SubscriberInterface[]
     */
    private array $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $this->unsubscribe($subscriber);
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        foreach ($this->subscribers as $existingSubscriber) {
            if ($existingSubscriber instanceof $subscriber::class) {
                unset($existingSubscriber);
            }
        }
    }

    public function notify(Track $track): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($track);
        }
    }
}
