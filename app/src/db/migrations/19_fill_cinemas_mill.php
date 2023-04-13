<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $values = [];
    for ($i = 0; $i < 990000; $i++) {
        $name = addslashes($faker->company);
        $values[] = "('$name')";
        if (($i + 1) % 1000 === 0 || $i === 989999) {
            $query = "INSERT INTO cinemas (name) VALUES " . implode(',', $values);
            $db->query($query);
            $values = [];
        }
    }

    echo "Migration complete.\n";
};
