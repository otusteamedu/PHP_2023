<?php

$socketPath = "/tmp/unix.sock";

if (file_exists($socketPath)) {
    unlink($socketPath);
}

$socket = stream_socket_server("unix://$socketPath", $errno, $errstr);
if (!$socket) {
    die("$errstr ($errno)");
}

// Server is always up first
echo "Server started\n";

while ($conn = @stream_socket_accept($socket, -1)) {
    $message = fread($conn, 1024);
    echo "Received message: $message\n";
    $response = "Received " . strlen($message) . " bytes";
    fwrite($conn, $response);
    fclose($conn);
}

fclose($socket);
