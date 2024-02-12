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
            'host'      => $_ENV['RABBITMQ_HOST'],
            'vhost'     => $_ENV['RABBITMQ_VHOST'],
            'user'      => $_ENV['RABBITMQ_USER'],
            'password'  => $_ENV['RABBITMQ_PASSWORD'],
        ]);

        try {
            $client->connect();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $client;
    }
}
