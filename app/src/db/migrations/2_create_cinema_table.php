<?php
declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS cinemas (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL
)");


    echo "Migration complete.\n";
};