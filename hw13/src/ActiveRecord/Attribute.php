<?php
declare(strict_types=1);

namespace Elena\Hw13\ActiveRecord;

use PDO;
use PDOStatement;

class Attribute
{
    private ?int  $id=null;
    private ?int $id_type=null;
    private ?string  $name=null;
    private ?string  $type=null;
    private PDO      $pdo;
    private PDOStatement  $selectStatement;
    private PDOStatement  $insertStatement;
    private PDOStatement  $updateStatement;
    private PDOStatement  $deleteStatement;
    private PDOStatement  $selectTypeStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStatement = $pdo->prepare('SELECT * FROM attribute WHERE id = ?');
        $this->insertStatement = $pdo->prepare('INSERT INTO attribute (id_type, name) VALUES (?, ?)');
        $this->updateStatement = $pdo->prepare('UPDATE attribute SET id_type = ?, name = ?  WHERE id = ?');
        $this->deleteStatement = $pdo->prepare('DELETE FROM attribute WHERE id = ?');
        $this->selectTypeStatement = $pdo->prepare('SELECT * FROM typeAttribute WHERE id = ?');
    }

    public function findOneById(int $id)
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);
        $result = $this->selectStatement->fetch();

        return (new self($this->pdo))
            ->setID((int)$id)
            ->setName($result['name'])
            ->setIdType($result['id_type'])
            ->setType($result['id_type']);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdType(): ?int
    {
        return $this->id_type;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setIdType(?int $id_type): self
    {
        $this->id_type = $id_type;
        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function insert(): int
    {
        $this->insertStatement->execute([
            $this->id_type,
            $this->name,
        ]);
        $this->id = (int)$this->pdo->lastInsertId();
        return $this->id;
    }

    public function update(int $id): bool
    {
        return $this->updateStatement->execute([
            $this->id_type,
            $this->name,
            $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $result = $this->deleteStatement->execute([$id]);
        $this->id = null;
        return $result;
    }

    public function getType()
    {
           return $this->type;
    }

    public function setType($id_type)
    {
        if (!isset($this->type)) {
            $this->selectTypeStatement->setFetchMode(PDO::FETCH_ASSOC);
            $this->selectTypeStatement->execute([$id_type]);
            $this->type =  $this->selectTypeStatement->fetch(PDO::FETCH_ASSOC)['name'];
            return $this;
        }


    }

}

