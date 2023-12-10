<?php

declare(strict_types=1);

namespace Yevgen87\App\Services;

use Exception;

class Client
{
    /**
     * @var string
     */
    private string $address;

    /**
     * @var integer
     */
    private int $port;

    public function __construct(string $address, int $port)
    {
        $this->address = $address;
        $this->port = $port;
    }

    public function __destruct()
    {
        if (
            $this->address
            && file_exists($this->address)
        ) {
            unlink($this->address);
        }
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if (false == ($socket = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
            throw new Exception("Could not create socket");
        }

        if (!socket_connect($socket, $this->address)) {
            throw new Exception("Could not connect socket");
        }

        do {
            $stdin = fopen('php://stdin', 'r');
            $line = fgets($stdin);

            socket_write($socket, $line);

            if ($message = socket_read($socket, 2048)) {
                echo $message  . PHP_EOL;
            }
        } while (true);

        socket_close($socket);
    }
}
