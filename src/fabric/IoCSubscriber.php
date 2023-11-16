<?php

namespace src\fabric;

use src\exception\NotExistSubscriberException;
use src\subscriber\FacebookSubscriber;
use src\subscriber\MailSubscriber;
use src\subscriber\ShortMessageSubscriber;
use src\subscriber\SubscriberInterface;

class IoCSubscriber
{
    public static function create(string $typeEvent): SubscriberInterface
    {
        $events = [
            'mail' => MailSubscriber::class,
            'sms' => ShortMessageSubscriber::class,
            'facebook' => FacebookSubscriber::class,
        ];

        $type = strtolower($typeEvent);
        if (!isset($events[$type])) {
            throw new NotExistSubscriberException($type);
        }

        return new $events[$type]();
    }
}
