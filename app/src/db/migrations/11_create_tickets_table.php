<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS tickets (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    screening_id INT,
                    seat_id INT,
                    customer_id INT,
                    actual_price INT,
                    sold_at DATETIME,
                    FOREIGN KEY (screening_id) REFERENCES screenings(id),
                    FOREIGN KEY (seat_id) REFERENCES seats(id),
                    FOREIGN KEY (customer_id) REFERENCES customers(id)
                )");

    echo "Migration complete.\n";
};
