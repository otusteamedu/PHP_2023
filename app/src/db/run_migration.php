<?php

require_once __DIR__ . '/../../vendor/autoload.php';

if ($argc < 2) {
    echo "Usage: php run_migration.php <migration_file_or_directory>\n";
    exit(1);
}

$path = $argv[1];

if (!file_exists($path)) {
    echo "Error: Migration file or directory not found: $path\n";
    exit(1);
}

if (is_dir($path)) {
    $migrations = array_diff(scandir($path), array('..', '.'));
    sort($migrations, SORT_NATURAL);

    foreach ($migrations as $migrationFile) {
        $migrationPath = $path . '/' . $migrationFile;

        if (!is_file($migrationPath)) {
            continue;
        }

        $migration = require $migrationPath;

        if ($migration instanceof \Closure) {
            $migration();
            echo "Migration successfully executed: $migrationFile\n";
        } else {
            echo "Error: Migration is not a Closure: $migrationFile\n";
            exit(1);
        }
    }
} else {
    $migration = require $path;

    if ($migration instanceof \Closure) {
        $migration();
        echo "Migration successfully executed: $path\n";
    } else {
        echo "Error: Migration is not a Closure: $path\n";
        exit(1);
    }
}
