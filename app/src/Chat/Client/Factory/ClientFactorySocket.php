<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\Chat\Client\Factory;

use DmitryEsaulenko\Hw15\Chat\Client\ClientInterface;
use DmitryEsaulenko\Hw15\Chat\Client\ClientSocket;
use DmitryEsaulenko\Hw15\Constants;

class ClientFactorySocket extends ClientFactory
{
    public function createClient(): ClientInterface
    {
        $socketFactory = new \Socket\Raw\Factory();
        $socketPath = getenv(Constants::SOCKET_VAR);
        $address = Constants::SOCKET_TYPE . $socketPath;
        $socket = $socketFactory->createClient($address);
        return new ClientSocket($socket);
    }
}
