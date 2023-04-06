<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $totalHalls = 990000;
    $batchSize = 1000;

    for ($i = 0; $i < $totalHalls; $i += $batchSize) {
        $values = [];

        for ($j = 0; $j < $batchSize; $j++) {
            $cinemaId = $faker->numberBetween(1, 1000000);
            $name = addslashes($faker->company);
            $capacity = 300;
            $values[] = "($cinemaId, '$name', $capacity)";
        }

        $query = "INSERT INTO halls (cinema_id, name, capacity) VALUES " . implode(',', $values);
        $db->query($query);
    }

    echo "Migration complete.\n";
};
