<?php

declare(strict_types=1);

namespace App\Application\Storage\redis;

use App\Application\Storage\StorageInterface;
use App\Domain\Factory\RedisEventEntityFactory;
use App\Domain\RedisEventEntity;
use Ehann\RediSearch\Exceptions\FieldNotInSchemaException;
use Ehann\RedisRaw\PredisAdapter;
use Ehann\RedisRaw\RedisRawClientInterface;

class RedisStorage implements StorageInterface
{
    private RedisRawClientInterface $client;

    private RedisEventEntity $eventEntity;

    public function __construct(string $eventName)
    {
        $this->client = (new PredisAdapter())->connect();
        $this->eventEntity = (new RedisEventEntityFactory($this->client, $eventName))->createEvent();
    }

    /**
     * @throws FieldNotInSchemaException
     */
    public function set(int $priority, array $conditions, string $event): void
    {
        $this->eventEntity->add(array_merge(['priority' => $priority, 'event' => $event], $conditions));
    }

    public function get(array $params): array
    {
        $builder = $this->eventEntity->sortBy('priority', 'DESC');

        foreach ($params as $key => $value) {
            $builder = $builder->numericFilter($key, $value, $value);
        }

        $result = $builder->search('', true);

        return $result->getDocuments()[0] ?? [];
    }

    public function clear(): void
    {
        $this->eventEntity->drop();
    }
}
