<?php

namespace src\notify;

use src\log\Log;
use src\subscriber\SubscriberInterface;

class NotifyService
{
    public function notify(array $subscribers): void
    {
        /** @var SubscriberInterface $subscriber */
        foreach ($subscribers as $subscriber) {
            Log::info('notify:' . $subscriber->getType());
            $subscriber->notify();
        }
    }
}
