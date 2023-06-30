<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\Subscriber;
use App\Services\Notification\LoggingNotificationDecorator;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     * @throws \Exception
     */
    public function created(Event $event)
    {
        $subscribers = $event->type->subscribers;

        /** @var Subscriber $subscriber */
        foreach ($subscribers as $subscriber) {
            $subscriber->events()->attach($event);

            $strategy = $subscriber->getPreferredNotificationStrategy();
            (new LoggingNotificationDecorator($strategy))->send($event, $subscriber);
        }
    }


    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }
}
