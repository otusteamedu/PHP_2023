<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $totalTicketsCount = 0;
    $ticketsLimit = 990000;

    $insertBatchSize = 50;
    $insertValues = [];
    $insertCount = 0;

    while ($totalTicketsCount < $ticketsLimit) {
        for ($i = 0; $i < $insertBatchSize; $i++) {
            $screening_id = $faker->numberBetween(1, 1000);
            $seat_id = $faker->numberBetween(1, 1000);
            $customer_id = $faker->numberBetween(1, 1000);
            $actual_price = $faker->numberBetween(5, 50);
            $sold_at = $faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s');

            $insertValues[] = "($screening_id, $seat_id, $customer_id, $actual_price, '$sold_at')";
            $totalTicketsCount++;

            if ($totalTicketsCount >= $ticketsLimit) {
                break;
            }
        }

        if (!empty($insertValues)) {
            $insertQuery = "INSERT INTO tickets (screening_id, seat_id, customer_id, actual_price, sold_at) VALUES " . implode(',', $insertValues);
            $db->query($insertQuery);
            $insertValues = [];
        }
    }

    echo "Migration complete.\n";
};
