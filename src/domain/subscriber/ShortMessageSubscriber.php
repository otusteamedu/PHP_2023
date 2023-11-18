<?php

namespace src\domain\subscriber;

use src\infrastructure\log\FileLog;
use src\infrastructure\log\Log;

class ShortMessageSubscriber implements SubscriberInterface
{
    private const TYPE = 'sms';

    public function getType(): string
    {
        return $this::TYPE;
    }

    public function notify(): void
    {
        (new Log(new FileLog()))->info(__METHOD__);
    }
}
