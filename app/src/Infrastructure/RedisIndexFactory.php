<?php

namespace App\Infrastructure;

use Ehann\RediSearch\AbstractIndex;
use Ehann\RediSearch\Index;
use Ehann\RedisRaw\RedisClientAdapter;

class RedisIndexFactory implements IndexFactoryInterface
{
    private const PRIORITY_FIELD_NAME = 'priority';
    private const EVENT_FIELD_NAME = 'name';
    private const PARAM_FIELD_NAME = 'param';

    public function __construct(private readonly RedisClientAdapter $client)
    {
    }

    public function create(): AbstractIndex
    {
        $index = new Index($this->client);

        $index->addNumericField(self::PRIORITY_FIELD_NAME)
            ->addTextField(self::EVENT_FIELD_NAME);

        for ($i = 1; $i < 5; $i++) {
            $index->addNumericField(self::PARAM_FIELD_NAME . $i);
        }

        return $index;
    }
}
