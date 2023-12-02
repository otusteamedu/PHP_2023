<?php
$socketPath = "/tmp/socket.sock";



while (true) {
    $client = stream_socket_client("unix:/$socketPath", $errno, $errstr);
    if (!$client) {
        die("$errstr ($errno)\n");
    }

    $line = readline("Enter message: ");
    fwrite($client, $line);
    $response = fread($client, 1024);
    echo $response;
    fclose($client);
}