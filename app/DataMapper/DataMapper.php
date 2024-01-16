<?php


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
    
    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->pdo = $connection;
    }
}
