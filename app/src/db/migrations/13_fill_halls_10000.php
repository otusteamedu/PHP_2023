<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $limit = 1000;
    $offset = 0;

    while (true) {
        $values = [];
        $query = "SELECT * FROM cinemas LIMIT $offset, $limit";
        $result = $db->query($query);
        $cinemas = $db->fetchAll($result);

        if (empty($cinemas)) {
            break;
        }

        foreach ($cinemas as $cinema) {
            $name = addslashes($faker->company);
            $cinemaId = $cinema['id'];
            $capacity = 300;
            $values[] = "($cinemaId, '$name', $capacity)";
        }

        $query = "INSERT INTO halls (cinema_id, name, capacity) VALUES " . implode(',', $values);
        $db->query($query);

        $offset += $limit;
    }

    echo "Migration complete.\n";
};
