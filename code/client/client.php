<?php

$socketPath = "/tmp/unix.sock";
$socket = stream_socket_client("unix://$socketPath", $errno, $errstr);

if (!$socket) {
    die("$errstr ($errno)");
}

$stdin = fopen('php://stdin', 'r');

while (true) {
    // Establish a new connection every time
    $socket = stream_socket_client("unix://$socketPath", $errno, $errstr);
    if (!$socket) {
        die("$errstr ($errno)");
    }

    echo "Enter a message to send to the server (type 'quit' to exit):\n";
    $input = trim(fgets(STDIN));

    // Client sends a message to the server
    fwrite($socket, $input);
    $response = fread($socket, 1024);
    echo $response . "\n"; // Client outputs the confirmation from the server to STDOUT

    // Close the connection after sending the message
    fclose($socket);

    // Break the loop if 'quit' is sent
    if ($input === 'quit') {
        break;
    }
}

fclose($socket);

