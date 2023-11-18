<?php

namespace src\domain\subscriber;

use src\infrastructure\log\FileLog;
use src\infrastructure\log\Log;

class FacebookDecoratorSubscriber implements SubscriberInterface
{
    private const TYPE = 'facebook-decorator';
    private NullSubscriber $nullSubscriber;

    public function __construct()
    {
        $this->nullSubscriber = new NullSubscriber();
    }

    public function getType(): string
    {
        return $this::TYPE;
    }

    public function notify(): void
    {
        (new Log(new FileLog()))->warning('(fb) notifier uses the illegal way. Disabled it!');
        $this->nullSubscriber->notify();
    }
}
