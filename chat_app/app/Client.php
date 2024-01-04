<?php

declare(strict_types=1);

namespace Vasilaki;

class Client
{
    private $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    public function start()
    {
        while (true) {
            $message = readline("Enter message: ");

            $this->socket->write(socket_create(AF_UNIX, SOCK_STREAM, 0), $message);

            $confirmation = $this->socket->read($clientSocket);
            echo "Server says: $confirmation\n";
        }
    }
}