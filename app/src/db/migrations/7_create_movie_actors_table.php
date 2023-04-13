<?php
declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS movie_actors (
                             movie_id INT,
                             actor_id INT,
                             PRIMARY KEY (movie_id, actor_id),
                             FOREIGN KEY (movie_id) REFERENCES movies(id),
                             FOREIGN KEY (actor_id) REFERENCES actors(id)
)"
    );

    echo "Migration complete.\n";
};
