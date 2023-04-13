<?php
declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS halls (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      cinema_id INT,
                      name VARCHAR(255) NOT NULL,
                      capacity INT NOT NULL,
                      FOREIGN KEY (cinema_id) REFERENCES cinemas(id)
)"
    );


    echo "Migration complete.\n";
};
