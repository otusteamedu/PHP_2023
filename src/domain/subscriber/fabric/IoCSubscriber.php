<?php

namespace src\domain\subscriber\fabric;

use src\config\domain\SubscribersConfig;
use src\domain\subscriber\exception\NotExistSubscriberException;
use src\domain\subscriber\SubscriberInterface;

class IoCSubscriber
{
    public static function create(string $typeEvent): SubscriberInterface
    {
        $events = self::describes();

        $type = strtolower($typeEvent);
        if (!isset($events[$type])) {
            throw new NotExistSubscriberException($type);
        }

        return new $events[$type]();
    }

    private static function describes(): array
    {
        return SubscribersConfig::describes();
    }
}
