<?php
declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS screenings (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           movie_id INT,
                           hall_id INT,
                           start_time DATETIME NOT NULL,
                           end_time DATETIME NOT NULL,
                           ticket_price INT NOT NULL,
                           FOREIGN KEY (movie_id) REFERENCES movies(id),
                           FOREIGN KEY (hall_id) REFERENCES halls(id)
)"
    );

    echo "Migration complete.\n";
};
