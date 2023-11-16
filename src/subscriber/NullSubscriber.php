<?php

namespace src\subscriber;

use src\log\Log;

class NullSubscriber implements SubscriberInterface
{
    private const TYPE = 'null';

    public function getType(): string
    {
        return $this::TYPE;
    }

    public function notify(): void
    {
        Log::info(__METHOD__);
    }
}
