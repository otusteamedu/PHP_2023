<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\App;

use DmitryEsaulenko\Hw15\Chat\Client\Client;
use DmitryEsaulenko\Hw15\Chat\Server\Server;
use DmitryEsaulenko\Hw15\Constants;

class App
{
    public function run()
    {
        $typeClient = $this->getTypeClient();
        $socket = getenv(Constants::SOCKET);
        $type = getenv(Constants::SOCKET_TYPE);
        $address = $type . $socket;
        $factory = new \Socket\Raw\Factory();
        switch ($typeClient) {
            case Constants::TYPE_APP_CLIENT:
                $socket = $factory->createClient($address);
                (new Client($socket))->run();
                break;
            case Constants::TYPE_APP_SERVER:
                unlink($socket);
                $socket = $factory->createServer($address)->listen();
                (new Server($socket))->run();
                break;
            default:
                throw new \Exception('Undefined type app');
        }
    }

    protected function getTypeClient(): string
    {
        global $argv;
        if (
            count($argv) < 2
            || !$argv[1]
        ) {
            throw new \Exception('Please set type app');
        }

        return $argv[1];
    }
}
