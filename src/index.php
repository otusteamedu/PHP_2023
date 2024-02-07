<?php

declare(strict_types=1);

use Klobkovsky\App\DB;

require __DIR__ . '/vendor/autoload.php';

try {
    $pdo = new DB();

    $dates = $pdo->pdo->query("SELECT * FROM service_date")->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    var_export($dates);
    echo "</pre>";

    $data = $pdo->pdo->query("SELECT * FROM marketing_data")->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    var_export($data);
    echo "</pre>";
} catch (\PDOException $e) {
    echo $e->getMessage();
}
