<?php

namespace App\Storage;

use Ehann\RediSearch\AbstractIndex;

class RedisStorage implements StorageInterface
{
    public function __construct(private readonly AbstractIndex $redisIndex)
    {
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


}
