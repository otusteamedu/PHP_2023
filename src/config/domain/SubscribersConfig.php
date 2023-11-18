<?php

namespace src\config\domain;

use src\domain\subscriber\FacebookSubscriber;
use src\domain\subscriber\MailSubscriber;
use src\domain\subscriber\ShortMessageSubscriber;

class SubscribersConfig
{
    public static function describes(): array
    {
        return [
            'mail' => MailSubscriber::class,
            'sms' => ShortMessageSubscriber::class,
            'facebook' => FacebookSubscriber::class,
        ];
    }
}
