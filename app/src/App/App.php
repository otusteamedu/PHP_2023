<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\App;

use DmitryEsaulenko\Hw15\Chat\Client\Factory\ClientFactorySocket;
use DmitryEsaulenko\Hw15\Chat\Server\Factory\ServerFactorySocket;
use DmitryEsaulenko\Hw15\Constants;

class App
{
    private string $typeApp;

    public function __construct()
    {
        $this->typeApp = $this->getTypeApp();
    }

    public function run()
    {
        switch ($this->typeApp) {
            case Constants::TYPE_APP_CLIENT:
                $this->runClient();
                break;
            case Constants::TYPE_APP_SERVER:
                $this->runServer();
                break;
            default:
                throw new \Exception('Undefined type app');
        }
    }

    public function runClient(): void
    {
        $type = getenv(Constants::SOCKET_TYPE);
        $client = match ($type) {
            Constants::SOCKET_TYPE => (new ClientFactorySocket())->createClient(),
            default => throw new \Exception('Undefined type socket_type'),
        };
        $client->run();
    }

    public function runServer(): void
    {
        $type = getenv(Constants::SOCKET_TYPE);
        $server = match ($type) {
            Constants::SOCKET_TYPE => (new ServerFactorySocket())->createServer(),
            default => throw new \Exception('Undefined type socket_type'),
        };
        $server->run();
    }

    protected function getTypeApp(): string
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
