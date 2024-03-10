<?php
declare(strict_types=1);
require 'vendor/autoload.php';

use App\Application\App;

try {
    $query = $argv[1] ?? '';
    $app = new App($query);

    $app->run();
} catch (Exception $exception) {

}