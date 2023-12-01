<?php

$argument = $argv[1] ?? null;

switch ($argument) {
    case 'server':
        require './server/server.php';
        break;
    case 'client':
        require './client/client.php';
        break;
    default:
        echo "Usage: php app.php [server|client]\n";
        break;
}
