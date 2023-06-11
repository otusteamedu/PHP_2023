<?php

declare(strict_types=1);

namespace App\Interface;

use App\Transport\Socket\SocketInterface;

class CLI
{
    private SocketInterface $transport;
    public function __construct(SocketInterface $transport) {
        $this->transport = $transport;
    }

    public function start(): void
    {
        $this->transport->create()->connect();

        while (true) {
            $message = readline("Message: ");

            if (!$message) {
                continue;
            }

            $this->transport->write($message);
            echo $this->transport->read() . PHP_EOL;
        }
    }
}