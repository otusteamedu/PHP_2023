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
            "select id, price, showtime_id, customer_id, seat_in_hall_id from tickets where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into tickets (price, showtime_id, customer_id, seat_in_hall_id) values (?, ?, ?, ?)"
        );
        $this->deleteStmt = $pdo->prepare("delete from tickets where id = ?");
    }

    public function getById(int $id): array
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        return (array)$this->selectStmt->fetch();
    }

    public function insert(float $price, int $showtime_id, int $customer_id, int $seat_in_hall_id): int
    {
        $this->insertStmt->execute([$price, $showtime_id, $customer_id, $seat_in_hall_id]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(
        int $id,
        float $price = null,
        int $showtime_id = null,
        int $customer_id = null,
        int $seat_in_hall_id = null
    ): bool
    {
        $dictionaryValues = array_filter(
            [
                'price' => $price,
                'showtime_id' => $showtime_id,
                'customer_id' => $customer_id,
                'seat_in_hall_id' => $seat_in_hall_id
            ],
            fn($value) => $value !== null
        );

        $stringValues = $this->getQueryString($dictionaryValues);

        $this->updateStmt = $this->pdo->prepare(
            "update tickets set " . $stringValues . " where id = ?"
        );

        $this->updateStmt->setFetchMode(\PDO::FETCH_ASSOC);

        $arrayValues = array_values($dictionaryValues);
        $arrayValues[] = $id;
        return $this->updateStmt->execute($arrayValues);
    }

    private function getQueryString(array $values): string
    {
        $stringValues = '';

        for ($i = 0; $i < count($values); $i++) {
            $value = key($values);
            next($values);
            if ($values[$value] === null) {
                break;
            }
            if ($i == count($values) - 1) {
                $stringValues .= $value . ' = ? ';
                break;
            }
            $stringValues .= $value . ' = ?, ';
        }

        return $stringValues;
    }

    public function delete(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}
