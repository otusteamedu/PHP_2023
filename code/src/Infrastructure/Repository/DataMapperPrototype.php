<?php

declare(strict_types=1);

namespace Art\Php2023\Infrastructure\Repository;

use PDO;
use PDOStatement;

class DataMapperPrototype
{
    protected PDO $pdo;

    protected PDOStatement $selectStatement;

    protected PDOStatement $insertStatement;

    protected PDOStatement $updateStatement;

    protected PDOStatement $deleteStatement;

    protected PDOStatement $findAllStatement;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->pdo = $connection;
    }
}
