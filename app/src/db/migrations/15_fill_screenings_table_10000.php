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

    $values = [];
    for ($i = 0; $i < 10000; $i++) {
        $movie_id = $faker->numberBetween(1, 10000);
        $hall_id = $faker->numberBetween(1, 10000);
        $start_time = $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d H:i:s');
        $end_time = (new DateTime($start_time))->add(new DateInterval('PT2H'))->format('Y-m-d H:i:s');
        $ticket_price = $faker->numberBetween(5, 20);

        $values[] = "($movie_id, $hall_id, '$start_time', '$end_time', $ticket_price)";

        if (($i + 1) % 1000 === 0 || $i === 9999) {
            $query = "INSERT INTO screenings (movie_id, hall_id, start_time, end_time, ticket_price) VALUES " . implode(',', $values);
            $db->query($query);
            $values = [];
        }
    }

    echo "Migration complete.\n";
};
