<?php

declare(strict_types=1);

namespace HW11\Elastic\Infrastructure;

use HW11\Elastic\Application\Storage\StorageInterface;

class EventController
{
    public function __construct(
        readonly StorageInterface $storage
    ) {
    }

    public function setEvent(int $priority, array $conditions, string $event): void
    {
        $this->storage->set($priority, $conditions, $event);
    }

    public function getEvent(array $params): array
    {
        return $this->storage->get($params);
    }

    public function clear(): void
    {
        $this->storage->clear();
    }

    public function getStorage(): StorageInterface
    {
        return $this->storage;
    }
}
