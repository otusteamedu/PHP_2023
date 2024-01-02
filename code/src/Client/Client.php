<?php

declare(strict_types=1);

namespace App\Client;

use Exception;

class Client
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded.');
        }

        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$socket) {
            throw new Exception('Unable to create AF_UNIX socket');
        }

        $clientSideSock = dirname(__FILE__) . "/client.sock";
        if (!socket_bind($socket, $clientSideSock)) {
            throw new Exception("Unable to bind to $clientSideSock");
        }

        while (1) {
            if (!socket_set_nonblock($socket)) {
                throw new Exception('Unable to set nonblocking mode for socket');
            }

            $serverSideSock = dirname(__FILE__) . "/../Server/server.sock";

            echo 'Enter your message:  ';
            fopen('php://stdin', 'r');
            $msg = fread(STDIN, 1024);
            $len = strlen($msg);

            $bytesSent = socket_sendto($socket, $msg, $len, 0, $serverSideSock);
            if ($bytesSent == -1) {
                throw new Exception('An error occurred while sending to the socket');
            } elseif ($bytesSent != $len) {
                throw new Exception($bytesSent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
            }

            if (!socket_set_block($socket)) {
                throw new Exception('Unable to set blocking mode for socket');
            }

            $msg = '';
            $from = '';

            $bytesReceived = socket_recvfrom($socket, $msg, 65536, 0, $from);
            if ($bytesReceived == -1) {
                throw new Exception('An error occurred while receiving from the socket');
            }
            echo "Received: $msg";
        }
    }
}
