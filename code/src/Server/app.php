<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Server\Server;

try {
    $server = new Server();
    $server->run();
} catch (Exception $e) {
    echo $e->__toString();
}