<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw6\App;

use DmitryEsaulenko\Hw6\Chat\Client;
use DmitryEsaulenko\Hw6\Chat\Server;
use DmitryEsaulenko\Hw6\Constants;

class App
{
    public function run()
    {
        $typeClient = $this->getTypeClient();
        switch ($typeClient) {
            case Constants::TYPE_APP_CLIENT:
                $client = new Client();
                $client->run();
                break;
            case Constants::TYPE_APP_SERVER:
                $server = new Server();
                $server->run();
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
