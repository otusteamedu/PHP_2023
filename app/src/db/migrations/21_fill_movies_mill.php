<?php

declare(strict_types=1);

namespace App\DB\Migrations;

use App\db\Database;
use Faker\Factory;

$db = require __DIR__ . '/../db.php';

return function () use ($db) {
    $faker = Factory::create();

    $totalMovies = 990000;
    $batchSize = 1000;

    for ($i = 0; $i < $totalMovies; $i += $batchSize) {
        $values = [];

        for ($j = 0; $j < $batchSize; $j++) {
            $title = addslashes($faker->sentence(3));
            $duration = $faker->time('H:i');
            $genre = addslashes($faker->word);
            $release_date = $faker->date();
            $rating = addslashes($faker->randomElement(['G', 'PG', 'PG-13', 'R', 'NC-17']));
            $values[] = "('$title', '$duration', '$genre', '$release_date', '$rating')";
        }

        $query = "INSERT INTO movies (title, duration, genre, release_date, rating) VALUES " . implode(',', $values);
        $db->query($query);
    }

    echo "Migration complete.\n";
};
