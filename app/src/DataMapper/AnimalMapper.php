<?php

declare(strict_types=1);

namespace Neunet\App\DataMapper;

use Neunet\App\Model\Animal;
use PDO;
use PDOStatement;

class AnimalMapper
{
    private PDO $db;

    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $deleteStmt;

    public function __construct(PDO $db)
    {
        $this->db = $db;

        $this->selectStmt = $db->prepare(
            "select type, male, name, age, price from animal where id = ?"
        );
        $this->insertStmt = $db->prepare(
            "insert into animal (type, male, name, age, price) values (?, ?, ?, ?, ?)"
        );
        $this->deleteStmt = $db->prepare("delete from animal where id = ?");
    }

    public function findById(int $id): Animal
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $animal = $this->selectStmt->fetch();

        return new Animal($id, $animal['type'], $animal['male'], $animal['name'], $animal['age'], $animal['price']);
    }

    public function insert(array $raw): Animal
    {
        $this->insertStmt->execute([$raw['type'], $raw['male'], $raw['name'], $raw['age'], $raw['price']]);

        return new Animal(
            (int) $this->db->lastInsertId(),
            $raw['type'],
            $raw['male'],
            $raw['name'],
            $raw['age'],
            $raw['price']
        );
    }

    public function update(array $raw, int $id): bool
    {
        $query = "update animal set ";
        foreach ($raw as $name => $value) {
            $query .= "$name = ?,";
        }
        $query = rtrim($query, ',') . " where id = $id";

        return $this->db->prepare($query)->execute();
    }

    public function delete(Animal $animal): bool
    {
        return $this->deleteStmt->execute([$animal->getId()]);
    }
}
