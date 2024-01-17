<?php

declare(strict_types=1);

namespace App;

use App\Cars;
use Fi1a\Collection\DataType\MapArrayObject;
use App\ObjectWatcher;
use PDO;

class CarsMapper
{
     /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $selectAllStmt;

    /**
     * @var \PDOStatement
     */
    private $selectStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

      /**
     * @var \PDOStatement
     */
    private $selectModelsForCarStmt;

    /**
     * @param $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectAllStmt = $pdo->query(
            "SELECT * FROM cars"
        );
        $this->selectStmt = $pdo->prepare(
            "SELECT name FROM cars where id = :id"
        );
        $this->insertStmt = $pdo->prepare(
            "INSERT INTO cars (name) values (:name)"
        );
        $this->updateStmt = $pdo->prepare(
            "UPDATE cars SET name = :name WHERE id = :id"
        );
        $this->deleteStmt = $pdo->prepare(
            "DELETE FROM cars WHERE id = :id"
        );
        $this->selectModelsForCarStmt = $pdo->prepare(
            "SELECT * FROM models WHERE car_id = :car_id"
        );
    }

    /**
     * @param int $id
     *
     * @return Cars
     */
    public function findAll(): MapArrayObject
    {
        $arrayObject = new MapArrayObject();
        $data = $this->selectAllStmt->fetchAll();
        foreach ($data as $row) {
            $arrayObject->add(new Cars($row['id'], $row['name']));
        }
        return $arrayObject;
    }

    /**
     * @param int $id
     *
     * @return Cars
     */
    public function findById(int $id): Cars
    {
        $key = 'key:' . $id;
        $obj = ObjectWatcher::getRecord($key);
        if (!$obj) {
            $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
            $this->selectStmt->bindValue(':id', $id);
            $this->selectStmt->execute();

            $result = $this->selectStmt->fetch();

            $obj = new Cars($id, $result['name']);

            $self = $this;
            $reference = function () use ($id, $self) {
                $models = [];
                $self->selectModelsForCarStmt->bindValue(':car_id', $id);
                $self->selectModelsForCarStmt->execute();
                $data = $self->selectModelsForCarStmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $row) {
                    $models[] = $row;
                }
                return $models;
            };

            $obj->setReference($reference);

            ObjectWatcher::addRecord($key, $obj);
        }

        return $obj;
    }

    /**
     * @param string $name
     *
     * @return Cars
     */
    public function insert(string $name): Cars
    {
        $this->insertStmt->bindValue(':name', $name);
        $this->insertStmt->execute();

        return new Cars(
            (int) $this->pdo->lastInsertId(),
            $name
        );
    }

    /**
     * @param Cars $cars
     *
     * @return bool
     */
    public function update(Cars $cars): bool
    {
        $this->updateStmt->bindValue(':name', $cars->getName());
        $this->updateStmt->bindValue(':id', $cars->getId());

        return $this->updateStmt->execute();
    }

    /**
     * @param Cars $cars
     *
     * @return bool
     */
    public function delete(Cars $cars): bool
    {
        $this->deleteStmt->bindValue(':id', $cars->getId());
        return $this->deleteStmt->execute();
    }
}
