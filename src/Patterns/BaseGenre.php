<?php

declare(strict_types=1);

namespace App\Patterns;

use PDO;
use PDOStatement;

abstract class BaseGenre
{
    protected PDOStatement $selectOneStatement;
    protected PDOStatement $selectAllStatement;
    protected PDOStatement $insertStatement;
    protected PDOStatement $updateStatement;
    protected PDOStatement $deleteStatement;

    public function __construct(protected readonly PDO $pdo)
    {
        $this->selectOneStatement = $this->pdo->prepare('SELECT * FROM genres WHERE genre_id = ?');
        $this->selectAllStatement = $this->pdo->prepare('SELECT * FROM genres');
        $this->insertStatement = $this->pdo->prepare('INSERT INTO genres (title) VALUES (?)');
        $this->updateStatement = $this->pdo->prepare('UPDATE genres SET title = ? WHERE genre_id = ?');
        $this->deleteStatement = $this->pdo->prepare('DELETE FROM genres WHERE genre_id = ?');
    }
}
