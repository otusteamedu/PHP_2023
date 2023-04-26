<?php

namespace App;

use Predis\Client;

class Redis
{
    public static function test(): ?string
    {
        $client = new Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]);
        $client->set('foo', 'success');
        return $client->get('foo');
    }
}
