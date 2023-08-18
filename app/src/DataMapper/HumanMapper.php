<?php declare(strict_types=1);

namespace Neunet\App\DataMapper;

use Neunet\App\Model\Human;
use PDO;
use PDOStatement;

class HumanMapper
{
    private PDO $db;

    private PDOStatement $selectStmt;
    private PDOStatement $selectByAnimalStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;

    public function __construct(PDO $db)
    {
        $this->db = $db;

        $this->selectStmt = $db->prepare(
            "select name, phone from human where id = ?"
        );
        $this->selectByAnimalStmt = $db->prepare(
            "select name, phone from human where animalId = ?"
        );
        $this->insertStmt = $db->prepare(
            "insert into human (name, phone) values (?, ?)"
        );
        $this->updateStmt = $db->prepare(
            "update human set name = ?, phone = ? where id = ?"
        );
        $this->deleteStmt = $db->prepare("delete from human where id = ?");
    }

    public function findById(int $id): Human
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $human = $this->selectStmt->fetch();

        return new Human($id, $human['name'], $human['phone'], $human['animalId']);
    }

    public function findByAnimalId(int $animalId): Human
    {
        $this->selectByAnimalStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectByAnimalStmt->execute([$animalId]);
        $human = $this->selectByAnimalStmt->fetch();

        return new Human($human['id'], $human['name'], $human['phone'], $animalId);
    }

    public function insert(array $raw): Human
    {
        $this->insertStmt->execute([$raw['name'], $raw['phone']]);

        return new Human((int) $this->db->lastInsertId(), $raw['name'], $raw['phone'], $raw['animalId']);
    }

    public function update(Human $human): bool
    {
        return $this->updateStmt->execute([
            $human->getName(),
            $human->getPhone(),
            $human->getId()
        ]);
    }

    public function delete(Human $human): bool
    {
        return $this->deleteStmt->execute([$human->getId()]);
    }
}