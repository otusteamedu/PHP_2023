<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Client\Client;

try {
    $client = new Client();
    $client->run();
} catch (Exception $e) {
    echo $e->__toString();
}