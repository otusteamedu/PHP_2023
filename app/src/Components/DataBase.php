<?php

namespace App\Components;

class DataBase
{
    private \PDO $connection;

    public function __construct(
        string $host,
        string $port,
        string $name,
        string $user,
        string $password,
    ) {
        $this->connection = new \PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s',
                $host,
                $port,
                $name,
            ),
            $user,
            $password,
        );
    }

    public function fetchQuery(string $query): array
    {
        $sth = $this->connection->query($query);
        $sth->execute();

        return (array) $sth->fetch(\PDO::FETCH_ASSOC);
    }
}
