<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use DateInterval;
use DateTime;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $totalScreenings = 990000;
    $batchSize = 1000;

    for ($i = 0; $i < $totalScreenings; $i += $batchSize) {
        $values = [];

        for ($j = 0; $j < $batchSize; $j++) {
            $movie_id = $faker->numberBetween(1, 10000);
            $hall_id = $faker->numberBetween(1, 10000);
            $start_time = $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d H:i:s');
            $end_time = (new DateTime($start_time))->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s');
            $ticket_price = $faker->numberBetween(5, 20);

            $values[] = "($movie_id, $hall_id, '$start_time', '$end_time', $ticket_price)";
        }

        $query = "INSERT INTO screenings (movie_id, hall_id, start_time, end_time, ticket_price) VALUES " . implode(',', $values);
        $db->query($query);
        $values = [];
    }

    echo "Migration complete.\n";
};
