<?php

namespace src\subscriber;

class FacebookSubscriber implements SubscriberInterface
{
    private const TYPE = 'facebook';
    private FacebookDecoratorSubscriber $subscriber;

    public function __construct()
    {
        $this->subscriber = new FacebookDecoratorSubscriber();
    }


    public function getType(): string
    {
        return $this::TYPE;
    }

    public function notify(): void
    {
        $this->subscriber->notify();
    }
}
