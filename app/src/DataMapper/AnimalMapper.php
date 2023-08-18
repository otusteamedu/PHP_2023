<?php declare(strict_types=1);

namespace Neunet\App\DataMapper;

use Neunet\App\Model\Animal;
use PDO;
use PDOStatement;

class AnimalMapper
{
    private PDO $db;

    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(Animal $animal): void
    {

    }
}