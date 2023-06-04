<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Exception;
use Vp\App\Application\Contract\InitDataInterface;
use Vp\App\Application\Dto\Output\ResultInit;
use Vp\App\Application\Message;
use Vp\App\Application\OrderStatus;
use Vp\App\Domain\Contract\DatabaseInterface;

class InitData implements InitDataInterface
{
    private \PDO $conn;

    public function __construct(DatabaseInterface $database)
    {
        $this->conn = $database->getConnection();
    }

    public function work(): ResultInit
    {
        $this->dropOrdersTable();
        $this->dropStatusesTable();

        $this->createStatusesTable();
        $this->createOrdersTable();

        try {
            $this->fillData();
        } catch (Exception $e) {
            return new ResultInit(false, $e->getMessage());
        }

        return new ResultInit(true, Message::SUCCESS_CREATE_DATA);
    }

    private function dropOrdersTable(): void
    {
        $this->conn->exec('DROP TABLE IF EXISTS orders');
    }

    private function dropStatusesTable(): void
    {
        $this->conn->exec('DROP TABLE IF EXISTS statuses');
    }

    private function createStatusesTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS statuses (
                        id serial PRIMARY KEY,
                        code VARCHAR(50) NOT NULL,
                        name VARCHAR(50) NOT NULL,
                        UNIQUE (code)
                        )";
        $this->conn->exec($sql);
    }

    private function createOrdersTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS orders (
                        id serial PRIMARY KEY,
                        product_id INT NOT NULL,
                        quantity INT NOT NULL,
                        status_id INT NOT NULL,
                        CONSTRAINT c_fk_type FOREIGN KEY (status_id) REFERENCES statuses (id) ON DELETE CASCADE
                        )";
        $this->conn->exec($sql);
    }

    private function fillData(): void
    {
        $this->fillStatuses();
    }

    private function fillStatuses(): void
    {
        $statuses = $this->getStatuses();

        foreach ($statuses as $status) {
            $sql = 'INSERT INTO statuses (name, code) VALUES(:name, :code)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':name', $status['name']);
            $stmt->bindValue(':code', $status['code']);
            $stmt->execute();
        }
    }

    private function getStatuses(): array
    {
        return [
            [
                'name' => 'Создан',
                'code' => OrderStatus::created->name
            ],
            [
                'name' => 'На сборке',
                'code' => OrderStatus::assembly->name
            ],
            [
                'name' => 'Передан в службу доставки',
                'code' => OrderStatus::delivery->name
            ],
            [
                'name' => 'Доставлен',
                'code' => OrderStatus::delivered->name
            ]
        ];
    }
}
