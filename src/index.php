<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Klobkovsky\App\DB;

try {
    $DB = new DB();

} catch (Throwable $e) {
    echo 'Error: ' . $e->getMessage();
}
