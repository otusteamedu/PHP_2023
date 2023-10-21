<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\DataMapper;

use VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Order;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage\DataMapper\OrderMapperInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\Exceptions\TableRowNotFoundException;
use PDOStatement;

class OrderMapper implements OrderMapperInterface
{
    /**
     * @var \PDO
     */
    private \PDO $pdo;

    private PDOStatement $selectByIdStatement;
    private PDOStatement $selectByStatementNumberStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS hw_order (id SERIAL NOT NULL PRIMARY KEY, status VARCHAR(10), statement_number VARCHAR(15), file_path text );"
        );

        $this->selectByIdStatement = $this->pdo->prepare(
            "SELECT * FROM hw_order WHERE id=:id LIMIT 1"
        );
        $this->selectByStatementNumberStatement = $this->pdo->prepare(
            "SELECT * FROM hw_order WHERE statement_number=:statement_number LIMIT 1"
        );
        $this->insertStatement = $this->pdo->prepare(
            "INSERT INTO hw_order (status, statement_number, file_path) VALUES (:status, :statement_number, :file_path)"
        );
        $this->updateStatement = $this->pdo->prepare(
            "UPDATE hw_order SET status=:status, file_path=:file_path, statement_number=:statement_number WHERE id = :id"
        );
        $this->deleteStatement = $this->pdo->prepare(
            "DELETE FROM hw_order WHERE id = :id"
        );
    }


    /**
     * @param int $id
     *
     * @return Order
     */
    public function findById(int $id): Order
    {
        $this->selectByIdStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByIdStatement->execute(["id" => $id]);
        $row = $this->selectByIdStatement->fetch();

        if (!$row) {
            throw new TableRowNotFoundException("order with id not found");
        }

        return new Order(
            $row['id'],
            $row['status'],
            $row['statement_number'],
            $row['file_path']
        );
    }

    public function findByStatementNumber(string $statementNumber): Order
    {
        $this->selectByStatementNumberStatement->setFetchMode(\PDO::FETCH_ASSOC);
        // var_dump($statementNumber);die("11111");
        $this->selectByStatementNumberStatement->execute(["statement_number" => $statementNumber]);
        $row = $this->selectByStatementNumberStatement->fetch();

        if (!$row) {
            throw new TableRowNotFoundException("order with id not found");
        }

        return new Order(
            $row['id'],
            $row['status'],
            $row['statement_number'],
            $row['file_path']
        );
    }

    

    public function insert(Order $order): void
    {
        $this->insertStatement->execute(
            [
                "status" => $order->getStatus(),
                "statement_number" => $order->getStatementNumber(),
                "file_path" => $order->getFilePath()
            ]
        );

        $order->setId(
            (int) $this->pdo->lastInsertId()
        );
    }

    public function update(Order $order): bool
    {
        return $this->updateStatement->execute([
            "id" => $order->getId(),
            "status" => $order->getStatus(),
            "statement_number" => $order->getStatementNumber(),
            "file_path" => $order->getFilePath()
        ]);
    }

    /**
     * @param Order $order
     *
     * @return bool
     */
    public function delete(Order $order): bool
    {
        return $this->deleteStatement->execute(["id" => $order->getId()]);
    }
}
