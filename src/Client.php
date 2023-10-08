<?php

declare(strict_types=1);

namespace App;

use Exception;

class Client
{
    private string $socketPath;

    public function __construct(string $socketPath)
    {
        $this->socketPath = $socketPath;
    }

    /**
     * @throws Exception
     */
    public function connect(): void
    {
        $socket = new Socket($this->socketPath);

        while (true) {
            $isConnected = $socket->connect();

            if (!$isConnected) {
                throw new Exception('Cannot connect to server');
            }

            echo 'Connected to the server' . PHP_EOL;

            echo 'Enter your message: ';
            $message = trim(fgets(STDIN));
            echo 'got message. Try to write it' . PHP_EOL;

            $socket->write($socket->getSocket(), $message);
            echo 'Wrote message. Try to get response' . PHP_EOL;

            $response = $socket->clientRead();
            echo "Server: {$response}" . PHP_EOL;
        }
    }
}
