<?php

declare(strict_types=1);

namespace Yevgen87\App\Services;

use Exception;

class Server
{
    /**
     * @var string
     */
    private string $address;

    /**
     * @var integer
     */
    private int $port;

    /**
     * @param $string
     */
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

        if (!socket_bind($socket, $this->address, $this->port)) {
            throw new Exception("Could not bind socket");
        }

        socket_listen($socket);
        while (($client = socket_accept($socket))) {
            do {
                if ($message = socket_read($client, 1024)) {
                    echo $message;

                    socket_write($client, 'Received ' . mb_strlen($message) . ' bytes');
                };
            } while (true);
        }

        socket_close($socket);
    }
}
