<?php

declare(strict_types=1);

namespace Vasilaki;

class Server
{
    private $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    public function start()
    {
        while (true) {
            $clientSocket = $this->socket->accept();
            $message = $this->socket->read($clientSocket);

            echo "Received: $message\n";

            $this->socket->write($clientSocket, "Received " . strlen($message) . " bytes");

            socket_close($clientSocket);
        }
    }
}

