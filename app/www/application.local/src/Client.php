<?php

declare(strict_types=1);

namespace App;

class Client
{
    protected Socket $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    public function start()
    {
        $this->socket->connect();

        echo "To exit, type 'exit'\n";

        while (true) {
            $message = readline("Enter message: ");

            if ($message === 'exit') {
                $this->socket->write($message);
                $this->socket->close();
                break;
            }

            $this->socket->write($message);
            $confirmation = $this->socket->read();
            echo "Server confirmation: {$confirmation}\n";
        }
    }
}
