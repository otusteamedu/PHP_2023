<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $ticketsPerScreening = 10;
    $insertBatchSize = 50;
    $insertValues = [];
    $insertCount = 0;
    $totalTicketsCount = 0;
    $ticketsLimit = 10000;

    while ($totalTicketsCount < $ticketsLimit) {
        for ($i = 0; $i < $ticketsPerScreening; $i++) {
            if ($totalTicketsCount >= $ticketsLimit) {
                break 2;
            }

            $screening_id = $faker->numberBetween(1, 10000);
            $seat_id = $faker->numberBetween(1, 2000);
            $customer_id = $faker->numberBetween(1, 1000);
            $actual_price = $faker->numberBetween(5, 50);
            $sold_at = $faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s');
            $insertValues[] = "($screening_id, $seat_id, $customer_id, $actual_price, '$sold_at')";

            $insertCount++;
            $totalTicketsCount++;

            if ($insertCount === $insertBatchSize || $totalTicketsCount >= $ticketsLimit) {
                $insertQuery = "INSERT INTO tickets (screening_id, seat_id, customer_id, actual_price, sold_at) VALUES " . implode(',', $insertValues);
                $db->query($insertQuery);
                $insertValues = [];
                $insertCount = 0;
            }
        }
    }

    echo "Migration complete.\n";
};
