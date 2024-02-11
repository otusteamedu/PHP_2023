<?php

namespace App\Infrastructure\Factory;

use Bunny\Client;
use Exception;

class RabbitMqClientFactory
{
    /**
     * @throws Exception
     */
    static function create(): Client
    {
        $client = new Client([
            'host'      => '127.0.0.1:5673',
            'vhost'     => '/',
            'user'      => 'guest',
            'password'  => 'guest',
        ]);

        try {
            $client->connect();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $client;
    }
}
