<?php

namespace src\application\notify;

use src\infrastructure\log\LogInterface;
use src\domain\subscriber\SubscriberInterface;

class NotifyService
{
    private LogInterface $log;

    public function __construct(LogInterface $log)
    {
        $this->log = $log;
    }

    public function notify(array $subscribers): void
    {
        /** @var SubscriberInterface $subscriber */
        foreach ($subscribers as $subscriber) {
            $this->log->info('notify:' . $subscriber->getType());
            $subscriber->notify();
        }
    }
}
