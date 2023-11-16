<?php

namespace src\subscriber;

use src\log\Log;

class MailSubscriber implements SubscriberInterface
{
    private const TYPE = 'mail';

    public function getType(): string
    {
        return $this::TYPE;
    }

    public function notify(): void
    {
        Log::info(__METHOD__);
    }
}
