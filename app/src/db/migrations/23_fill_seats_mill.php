<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $totalSeats = 990000;
    $seatsPerHall = 300;
    $requiredHalls = (int) ceil($totalSeats / $seatsPerHall);

    $halls = $db->fetchAll($db->query("SELECT id FROM halls LIMIT 0, $requiredHalls"));

    foreach ($halls as $hall) {
        $hall_id = $hall['id'];
        $values = [];

        for ($row = 1; $row <= 30; $row++) {
            for ($seat_number = 1; $seat_number <= 10; $seat_number++) {
                $values[] = "($hall_id, $seat_number, $row)";
            }
        }

        $query = "INSERT INTO seats (hall_id, seat_number, seat_row) VALUES " . implode(',', $values);
        $db->query($query);
    }

    echo "Migration complete.\n";
};
