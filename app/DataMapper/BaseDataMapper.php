<?php
declare(strict_types=1);

namespace App\DataMapper;

use PDO;

class BaseDataMapper {
    public function __construct(protected PDO $pdo) {}

    protected function fetchAll($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}