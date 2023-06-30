<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Subscriber;
use Illuminate\Support\Collection;

class SubscriberEventsProxy
{
    private Subscriber $subscriber;
    private ?Collection $events = null;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function getEvents(): Collection
    {
        if ($this->events === null) {
            $this->events = $this->subscriber->events;
        }

        return $this->events;
    }
}
