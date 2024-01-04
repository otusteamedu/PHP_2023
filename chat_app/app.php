<?php

declare(strict_types=1);

use Vasilaki\Config;
use Vasilaki\Client;
use Vasilaki\Server;
use Vasilaki\Socket;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $config = new Config('config.ini');
    $socketPath = $config->get('socket', 'path');

    if ($argc < 2) {
        throw new Exception("Invalid arguments. Usage: php app.php server|client");
    }

    $appType = $argv[1];

    if ($appType === 'server') {
        $socket = new Socket($socketPath);
        $server = new Server($socket);
        $server->start();
    } elseif ($appType === 'client') {
        $socket = new Socket($socketPath);
        $client = new Client($socket);
        $client->start();
    } else {
        throw new Exception("Invalid application type. Use 'server' or 'client'.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
