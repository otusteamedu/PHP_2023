<?php

declare(strict_types=1);

namespace Ro\Php2023\Controllers;

use Predis\Client;
use Ro\Php2023\Storage\Redis;
use Symfony\Component\HttpFoundation\Response;

class RedisController implements TestingControllerInterface
{
    private Client $redisClient;

    public function __construct(Client $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    public function ping(): Response
    {
        $store = new Redis($this->redisClient);
        return new Response($store->ping());
    }
}
