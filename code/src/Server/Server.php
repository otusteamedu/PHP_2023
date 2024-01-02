<?php

declare(strict_types=1);

namespace App\Server;

use Exception;

class Server
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

        $serverSideSock = dirname(__FILE__) . "/server.sock";
        if (!socket_bind($socket, $serverSideSock)) {
            throw new Exception("Unable to bind to $serverSideSock");
        }

        while (1) {
            if (!socket_set_block($socket)) {
                throw new Exception('Unable to set blocking mode for socket');
            }

            $msg = '';
            $from = '';
            echo "Ready to receive...\n";

            $bytesReceived = socket_recvfrom($socket, $msg, 65536, 0, $from);
            if ($bytesReceived == -1) {
                throw new Exception('An error occurred while receiving from the socket');
            }

            echo "Received: $msg";

            if (!socket_set_nonblock($socket)) {
                throw new Exception('Unable to set nonblocking mode for socket');
            }

            $len = strlen($msg);
            $bytesSent = socket_sendto($socket, $msg, $len, 0, $from);
            if ($bytesSent == -1) {
                throw new Exception('An error occurred while sending to the socket');
            } elseif ($bytesSent != $len) {
                throw new Exception($bytesSent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
            }
        }
    }
}
