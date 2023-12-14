<?php

namespace App\Storage;

use Ehann\RediSearch\AbstractIndex;
use Ehann\RediSearch\Index;
use Ehann\RedisRaw\RedisClientAdapter;
use Ehann\RedisRaw\RedisRawClientInterface;

class RedisStorage implements StorageInterface
{
    private const REDIS_HOST = 'redis';

    private AbstractIndex $redisIndex;

    public function __construct()
    {
        $this->redisIndex = $this->createRedisIndex((new RedisClientAdapter())->connect(self::REDIS_HOST));
    }

    public function add(int $priority, string $event, array $conditions): void
    {
        $this->redisIndex->add(array_merge(['priority' => $priority, 'event' => $event], $conditions));
    }

    public function get(array $params): array
    {
        $builder = $this->redisIndex->sortBy('priority', 'DESC');

        foreach ($params as $k => $v) {
            $builder = $builder->numericFilter($k, $v, $v);
        }

        $result = $builder->search('', true);

        return $result->getDocuments()[0] ?? [];
    }

    public function clear(): void
    {
        $this->redisIndex->drop();
    }

    private function createRedisIndex(RedisRawClientInterface $client): AbstractIndex
    {
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
