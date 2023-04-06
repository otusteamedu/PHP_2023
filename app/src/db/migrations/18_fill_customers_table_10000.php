<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $insertBatchSize = 100;
    $insertValues = [];
    $insertCount = 0;
    $totalCustomersCount = 0;
    $customersLimit = 10000;

    while ($totalCustomersCount < $customersLimit) {
        $first_name = $db->escapeString($faker->firstName);
        $last_name = $db->escapeString($faker->lastName);
        $email = $db->escapeString($faker->unique()->safeEmail);
        $phone = $db->escapeString($faker->unique()->phoneNumber);

        $insertValues[] = "('$first_name', '$last_name', '$email', '$phone')";

        $insertCount++;
        $totalCustomersCount++;

        if ($insertCount === $insertBatchSize || $totalCustomersCount >= $customersLimit) {
            $insertQuery = "INSERT INTO customers (first_name, last_name, email, phone) VALUES " . implode(',', $insertValues);
            $db->query($insertQuery);
            $insertValues = [];
            $insertCount = 0;
        }
    }

    echo "Migration complete.\n";
};
