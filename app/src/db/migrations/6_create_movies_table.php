<?php
declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS movies (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       title VARCHAR(255) NOT NULL,
                       duration TIME NOT NULL,
                       genre VARCHAR(255) NOT NULL,
                       release_date DATE,
                       rating VARCHAR(255) NOT NULL
)"
    );

    echo "Migration complete.\n";
};
