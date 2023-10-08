<?php

declare(strict_types=1);

namespace App;

class Server
{
    private string $socketPath;

    /**
     * @param string $socketPath
     */
    public function __construct(string $socketPath)
    {
        $this->socketPath = $socketPath;
    }

    public function listen(): void
    {
        $socket = new Socket($this->socketPath);
        $socket->create();

        while (true) {
            echo "I'm waiting for a new message" . PHP_EOL;

            [$clientSocket, $message] = $socket->read();
            if ($message !== false) {
                echo 'Received message: ' . $message . PHP_EOL;
                $response = "Received " . strlen($message) . ' bytes';
                echo 'Reply to client' . PHP_EOL;
                $socket->write($clientSocket, $response);
            }
        }
    }
}
