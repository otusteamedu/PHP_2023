<?php
$socketPath = "/tmp/unix.sock";

if (file_exists($socketPath)) {
    unlink($socketPath);
}

$socket = stream_socket_server("unix://$socketPath", $errno, $errstr);
if (!$socket) {
    die("$errstr ($errno)");
}

echo "Server started\n";

while ($conn = @stream_socket_accept($socket, -1)) {
    $message = trim(fread($conn, 1024));
    echo "Received message: $message\n";

    // Respond with the number of bytes received
    $response = "Received " . strlen($message) . " bytes";
    fwrite($conn, $response);

    // Close the connection if 'quit' is received
    if ($message === 'quit') {
        fwrite($conn, "Closing connection.\n");
        fclose($conn);
        break; // Here we should break if we want the server to stop after 'quit'
    }

    fclose($conn);
}

fclose($socket);
