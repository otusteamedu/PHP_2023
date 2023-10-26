<?php

declare(strict_types=1);

namespace App\Storage\redis;

use App\Storage\StorageInterface;
use Ehann\RediSearch\AbstractIndex;
use Ehann\RediSearch\Exceptions\FieldNotInSchemaException;
use Ehann\RedisRaw\PredisAdapter;
use Ehann\RedisRaw\RedisRawClientInterface;

class RedisStorage implements StorageInterface
{
    private RedisRawClientInterface $client;

    private AbstractIndex $index;

    public function __construct(string $host, string $indexName)
    {
        $this->client = (new PredisAdapter())->connect($host);
        $this->index = (new Index($this->client, $indexName))->createIndex();
    }

    /**
     * @throws FieldNotInSchemaException
     */
    public function set(int $priority, array $conditions, string $event): void
    {
        $this->index->add(array_merge(['priority' => $priority, 'event' => $event], $conditions));
    }

    public function get(array $params): array
    {
        $builder = $this->index->sortBy('priority', 'DESC');

        foreach ($params as $key => $value) {
            $builder = $builder->numericFilter($key, $value, $value);
        }

        $result = $builder->search('', true);

        return $result->getDocuments()[0] ?? [];
    }

    public function clear(): void
    {
        $this->index->drop();
    }
}