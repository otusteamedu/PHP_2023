<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $values = [];
    for ($i = 0; $i < 10000; $i++) {
        $title = addslashes($faker->sentence(3));
        $duration = $faker->time('H:i');
        $genre = addslashes($faker->word);
        $release_date = $faker->date();
        $rating = addslashes($faker->randomElement(['G', 'PG', 'PG-13', 'R', 'NC-17']));
        $values[] = "('$title', '$duration', '$genre', '$release_date', '$rating')";

        if (($i + 1) % 1000 === 0 || $i === 9999) {
            $query = "INSERT INTO movies (title, duration, genre, release_date, rating) VALUES " . implode(',', $values);
            $db->query($query);
            $values = [];
        }
    }

    echo "Migration complete.\n";
};
