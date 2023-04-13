<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS seats (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    hall_id INT,
                    seat_number INT,
                    seat_row INT,
                    FOREIGN KEY (hall_id) REFERENCES halls(id)
                )");

    echo "Migration complete.\n";
};
