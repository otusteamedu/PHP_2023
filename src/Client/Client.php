<?php

namespace App\Client;

use App\Socket\SocketInterface;
use PHP_CodeSniffer\Generators\Generator;
use Traversable;

class Client
{
    public function __construct(private readonly string $socketPath, private readonly SocketInterface $service)
    {
    }

    public function start(): Traversable
    {
        $socket = $this->service->create(AF_UNIX, SOCK_STREAM);
        $this->service->connect($socket, $this->socketPath);

        while (true) {
            $message = fgets(STDIN);
            $this->service->write($socket, $message);
            $response = $this->service->read($socket, 4096);
            yield $response . PHP_EOL;
            if (trim($message) === 'shutdown') {
                break;
            }
        }

        $this->service->close($socket);
    }
}
