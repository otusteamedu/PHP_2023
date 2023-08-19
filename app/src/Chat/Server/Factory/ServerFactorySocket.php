<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\Chat\Server\Factory;

use DmitryEsaulenko\Hw15\Chat\Client\ClientInterface;
use DmitryEsaulenko\Hw15\Chat\Client\ClientSocket;
use DmitryEsaulenko\Hw15\Chat\Client\Factory\ClientFactory;
use DmitryEsaulenko\Hw15\Chat\Server\ServerInterface;
use DmitryEsaulenko\Hw15\Chat\Server\ServerSocket;
use DmitryEsaulenko\Hw15\Constants;

class ServerFactorySocket extends ServerFactory
{
    function createServer(): ServerInterface
    {
        $socketFactory = new \Socket\Raw\Factory();
        $socketPath = getenv(Constants::SOCKET_VAR);
        $address = $socketPath . Constants::SOCKET_TYPE;
        $socket = $socketFactory->createServer($address)->listen();
        unlink($socketPath);
        return new ServerSocket($socket);
    }
}
