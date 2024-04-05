<?php

declare(strict_types=1);

namespace App;

class Server
{
    protected Socket $socket;
    private $isRunning = true;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    public function start()
    {
        $this->socket->bind();
        $this->socket->listen();
        $this->socket->accept();

        while ($this->isRunning) {
            $message = $this->socket->receive();

            if ($message === 'exit') {
                $this->isRunning = false;
                $this->socket->close();
            } else {
                echo "Received: {$message}\n";
                $this->socket->write("Received " . strlen($message) . " bytes");
            }
        }
    }
}
