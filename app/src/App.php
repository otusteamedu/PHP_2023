<?php

declare(strict_types=1);

namespace Agrechuha\Otus;

use Exception;

class App
{
    /**
     * @param $argv
     *
     * @return void
     * @throws Exception
     */
    public function run($argv): void
    {
        $arg = $argv[1] ?? null;

        switch ($arg) {
            case 'server':
                $server = new ServerSocket();
                $server->createChatServer();

                break;
            case 'client':
                $client = new ClientSocket();
                $client->connectToChat();

                break;
            default:
                throw new Exception('Invalid argument. You can use "client" or "server"' . PHP_EOL);
        }
    }
}
