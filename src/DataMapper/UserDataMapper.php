<?php

namespace App\DataMapper;

use App\IdentityMap;
use PDO;
use PDOStatement;

class UserDataMapper
{
    private PDOStatement $selectStmt;

    private PDOStatement $updateStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $deleteStmt;

    private IdentityMap $identityMap;

    public function __construct(private readonly PDO $pdo)
    {
        $this->selectStmt = $this->pdo->prepare(
            "select name, genre, year_of_release, duration from films where id = ?"
        );
        $this->insertStmt = $this->pdo->prepare(
            "insert into films (name, genre, year_of_release, duration) values (?, ?, ?, ?)"
        );
        $this->updateStmt = $this->pdo->prepare(
            "update films set name = ?, genre = ?, year_of_release = ?, duration = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from films where id = ?");

        $this->identityMap = new IdentityMap();
    }

    public function findAll(): array
    {
        $identityMapObjects = $this->identityMap->getObjects();
        $bdObjects = $this->selectStmt->fetchAll();

        $diffObjects = array_diff_key($identityMapObjects, $bdObjects);

        if (empty($diffObjects)) {
            return $identityMapObjects;
        }

        $this->identityMap->resetObjects();
        $this->identityMap->setObjects($bdObjects);

        return $this->identityMap->getObjects();
    }
}
