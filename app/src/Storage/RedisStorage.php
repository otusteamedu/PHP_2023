<?php

/**
 * Класс хранилища Redis
 */

namespace App\Storage;

use Ehann\RediSearch\{AbstractIndex, Index};
use Ehann\RedisRaw\{RedisRawClientInterface, RedisClientAdapter};
use Exception;

class RedisStorage implements Storage
{
    private RedisRawClientInterface $redis;

    private AbstractIndex $index;

    public function __construct(string $host, string $indexName)
    {
        $this->redis = (new RedisClientAdapter())->connect($host);
        $this->index = $this->createIndex($this->redis, $indexName);
    }

    private function createIndex(RedisRawClientInterface $client, string $indexName): AbstractIndex
    {
        $index = new Index($client, $indexName);
        $index->addNumericField('priority')
            ->addTextField('event')
            ->addNumericField('param1')
            ->addNumericField('param2')
            ->create();

        return $index;
    }

    /**
     * @throws Exception
     */
    public function add(int $priority, array $conditions, string $event): void
    {
        $this->index->add(array_merge(['priority' => 2000, 'event' => $event], $conditions));
    }

    /**
     * @throws Exception
     */
    public function clear(): void
    {
        $this->index->drop();
    }

    /**
     * @throws Exception
     */
    public function get(array $params): array
    {
        $builder = $this->index->sortBy('priority', 'DESC');

        foreach ($params as $k => $v) {
            $builder = $builder->numericFilter($k, $v, $v);
        }

        $result = $builder->search('', true);

        return $result->getDocuments()[0] ?? [];
    }
}
