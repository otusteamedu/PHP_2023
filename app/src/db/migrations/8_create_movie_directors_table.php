<?php
declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $db->query("CREATE TABLE IF NOT EXISTS movie_directors (
                                movie_id INT,
                                director_id INT,
                                PRIMARY KEY (movie_id, director_id),
                                FOREIGN KEY (movie_id) REFERENCES movies(id),
                                FOREIGN KEY (director_id) REFERENCES directors(id)
)"
    );

    echo "Migration complete.\n";
};
