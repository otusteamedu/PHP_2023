<?php

declare(strict_types=1);

namespace Gesparo\Hw\Client;

use Gesparo\Hw\App;
use Gesparo\Hw\Socket\ClientSocket;
use Gesparo\Hw\Socket\ServerSocket;

class ClientFactory
{
    public function create($type, string $pathToTheUnixFile): BaseClient
    {
        return match ($type) {
            App::SERVER => new Server(new ServerSocket($pathToTheUnixFile)),
            App::CLIENT => new UserClient(new ClientSocket($pathToTheUnixFile)),
            default => throw new \RuntimeException("Invalid type of the behaviour. '$type' provided."),
        };
    }
}