<?php

declare(strict_types=1);

namespace src\Infrastructure\DBGateway;

class Tickets
{
    private \PDO $pdo;

    private \PDOStatement $selectStmt;
    private \PDOStatement $insertStmt;
    private \PDOStatement $updateStmt;
    private \PDOStatement $deleteStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select price, showtime_id, customer_id, seat_in_hall_id from tickets where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into tickets (price, showtime_id, customer_id, seat_in_hall_id) values (?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update tickets set price = ?, showtime_id = ?, customer_id = ?, seat_in_hall_id = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from tickets where id = ?");
    }

    public function getById(int $id): array
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        return (array)$this->selectStmt->fetch();
    }
}
