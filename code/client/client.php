<?php

$socketPath = "/tmp/unix.sock";

// Client waits for input from STDIN
$stdin = fopen('php://stdin', 'r');
echo "Please enter a message to send to the server:\n";
$input = fgets($stdin);

$socket = stream_socket_client("unix://$socketPath", $errno, $errstr);

if (!$socket) {
    die("$errstr ($errno)");
}

// Client sends a message to the server
fwrite($socket, $input);
$response = fread($socket, 1024);
echo $response . "\n"; // Client outputs the confirmation from the server to STDOUT

fclose($socket);
