<?php

namespace src\subscriber;

use src\log\Log;

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
        Log::warning('notifier uses the illegal way. Disabled it!');
        $this->nullSubscriber->notify();
    }
}
