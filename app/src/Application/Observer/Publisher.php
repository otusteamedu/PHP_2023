<?php

declare(strict_types=1);

namespace App\Application\Observer;

final class Publisher implements PublisherInterface
{
    /**
     * @var array<class-string, SubscriberInterface>
     */
    private array $subscribers = [];

    public function __construct(\Traversable $subscribers)
    {
        $this->subscribers = iterator_to_array($subscribers);
    }

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $this->subscribers[$subscriber::class] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        if (!array_key_exists($subscriber::class, $this->subscribers)) {
            return;
        }

        unset($this->subscribers[$subscriber::class]);
    }

    public function notify(EventInterface $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($event);
        }
    }
}
