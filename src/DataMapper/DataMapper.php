<?php

declare(strict_types=1);

namespace App\DataMapper;

use PDO;
use PDOStatement;

abstract class DataMapper
{
    protected PDO $pdo;
    protected PDOStatement $selectStatement;
    protected PDOStatement $insertStatement;
    protected PDOStatement $updateStatement;
    protected PDOStatement $deleteStatement;
    protected PDOStatement $findAllStatement;
    protected IdentityMap $identityMap;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->identityMap = new IdentityMap();
    }

    abstract public static function getTableName(): string;
}
