<?php

namespace App\Factory;

use Ehann\RediSearch\AbstractIndex;
use Ehann\RediSearch\Index;
use Ehann\RedisRaw\RedisClientAdapter;

class RedisIndexFactory implements IndexFactoryInterface
{
    private const REDIS_HOST_NAME = 'redis';

    public function create(): AbstractIndex
    {
        $client = new RedisClientAdapter();
        $client->connect(self::REDIS_HOST_NAME);
        $index = new Index($client);

        $index
            ->addNumericField('priority')
            ->addNumericField('param1')
            ->addNumericField('param2')
            ->addTextField('event')
            ->create();

        return $index;
    }
}
