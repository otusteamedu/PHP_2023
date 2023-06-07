<?php
declare(strict_types=1);

class MySQLAdapter implements DatabaseAdapterInterface
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll(string $table): Generator
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$table}");
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            yield $row;
        }
    }
}
