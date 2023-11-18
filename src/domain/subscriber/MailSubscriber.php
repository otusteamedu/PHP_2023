<?php

namespace src\domain\subscriber;

use src\infrastructure\log\FileLog;
use src\infrastructure\log\Log;

class MailSubscriber implements SubscriberInterface
{
    private const TYPE = 'mail';

    public function getType(): string
    {
        return $this::TYPE;
    }

    public function notify(): void
    {
        (new Log(new FileLog()))->info(__METHOD__);
    }
}
