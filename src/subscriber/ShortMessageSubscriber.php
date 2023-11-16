<?php

namespace src\subscriber;

use src\log\Log;

class ShortMessageSubscriber implements SubscriberInterface
{
    private const TYPE = 'sms';

    public function getType(): string
    {
        return $this::TYPE;
    }

    public function notify(): void
    {
        Log::info(__METHOD__);
    }
}
