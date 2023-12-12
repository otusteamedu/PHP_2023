<?php
declare(strict_types=1);

namespace Ekovalev\Otus\App;

use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run($argv): void
    {
        $instanceName = $argv[1] ?? null;

        switch ($instanceName) {
            case 'server':
                $server = new Server();
                $server->initChat();
                break;
            case 'client':
                $client = new Client();
                $client->initChat();
                break;
            default:
                throw new Exception('This is a bad argument, you should use "server" or "client"' . PHP_EOL);
        }
    }
}