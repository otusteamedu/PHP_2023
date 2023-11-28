<?php

try {
    $serverSocketPath = "/var/run/server_socket.sock";
    $clientSocketPath = "/var/run/client_socket.sock";
    
    $app = new Application($serverSocketPath, $clientSocketPath);
    $app->run();
} catch (\Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
