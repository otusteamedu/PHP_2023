<?php

namespace App\Server;

use App\Socket\SocketInterface;
use Traversable;

class Server
{
    public function __construct(private readonly string $socketPath, private readonly SocketInterface $service)
    {
    }

    public function start(): Traversable
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }

        $socket = $this->service->create(AF_UNIX, SOCK_STREAM);
        $this->service->bind($socket, $this->socketPath);
        $this->service->listen($socket);

        $client = $this->service->accept($socket);
        while (true) {
            $message = $this->service->read($client, 4096);
            yield $message . PHP_EOL;

            $response = 'Received ' . strlen($message) . ' bytes';
            $this->service->write($client, $response);

            if ($this->service->shutdown($message)) {
                break;
            }
        }

        $this->service->close($client);
        $this->service->close($socket);
    }
}
