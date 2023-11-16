<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\Mongo;

use MongoDB\Client;
use MongoDB\Database;

class ConnectionCreator
{
    private string $host;
    private string $user;
    private string $password;
    private string $database;

    public function __construct(string $host, string $user, string $password, string $database)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }

    public function create(): Database
    {
        return (new Client("mongodb://$this->user:$this->password@$this->host:27017/"))->selectDatabase($this->database);
    }
}
