<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $seat_id = 1;
    $halls = $db->fetchAll($db->query("SELECT id FROM halls"));

    foreach ($halls as $hall) {
        $hall_id = $hall['id'];
        $values = [];

        for ($row = 1; $row <= 30; $row++) {
            for ($seat_number = 1; $seat_number <= 10; $seat_number++) {
                $values[] = "($seat_id, $hall_id, $seat_number, $row)";
                $seat_id++;
            }
        }

        $query = "INSERT INTO seats (id, hall_id, seat_number, seat_row) VALUES " . implode(',', $values);
        $db->query($query);
    }

    echo "Migration complete.\n";
};
