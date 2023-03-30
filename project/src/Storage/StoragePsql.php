<?php

namespace Vp\App\Storage;

use Vp\App\Storage\Connections\ConnectionPsql;
use WS\Utils\Collections\Collection;

class StoragePsql implements StorageInterface
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = ConnectionPsql::getInstance()->getConnection();
    }

    public function add(string $eventId, string $params, string $event): void
    {
        // TODO: Implement add() method.
    }

    public function find(array $eventParams): ?Collection
    {
        // TODO: Implement find() method.
    }

    public function delete(string $eventId): void
    {
        // TODO: Implement delete() method.
    }
}
