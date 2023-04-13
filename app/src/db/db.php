<?php
declare(strict_types=1);

namespace App\DB;

use App\db\Database;

$config = require __DIR__ . '/../config/database.php';
$dbConfig = $config['connections']['mysql'];

return new Database(
    $dbConfig['driver'],
    $dbConfig['username'],
    $dbConfig['password'],
    $dbConfig['database']
);
