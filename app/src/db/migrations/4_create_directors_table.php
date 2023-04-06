<?php
declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS directors (
                           id INT PRIMARY KEY,
                           first_name VARCHAR(255),
                           last_name VARCHAR(255)
)"
    );

    echo "Migration complete.\n";
};
