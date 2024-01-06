<?php

namespace App\Application\Helper;

class ValidateHelper
{
    private NotifyHelper $notify;
    private QueueHelper $queue;

    public function __construct()
    {
        $this->notify = new NotifyHelper();
        $this->queue = new QueueHelper();
    }

    public function validateNotify(string $way): bool
    {
        return in_array(
            $way,
            $this->notify->getSupports()
        );
    }

    public function validateQueue(string $way): bool
    {
        return in_array(
            $way,
            $this->queue->getSupports()
        );
    }
}
