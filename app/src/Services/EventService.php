<?php

declare(strict_types=1);

namespace Yevgen87\App\Services;

use Yevgen87\App\Services\Storage\RedisStorage;

class EventService
{
    private RedisStorage $storage;

    public function __construct()
    {
        $this->storage = new RedisStorage();
    }

    public function store(int $priority, array $params, string $event)
    {
        $this->storage->store($priority, $params, $event);
    }

    public function deleteAll()
    {
        $this->storage->deleteAll();
    }

    public function getRelevant(array $data)
    {
        return $this->storage->getRelevant($data);
    }
}
