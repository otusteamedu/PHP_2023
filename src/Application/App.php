<?php

namespace Dimal\Hw6\Application;

use Exception;
use Dimal\Hw6\Application\Server;
use Dimal\Hw6\Application\Client;

class App
{
    private string $socket_path = '';

    public function run()
    {
        global $argv;
        global $argc;

        $this->socket_path = __DIR__ . '/../../socket.sock';

        switch ($argv[1]) {
            case 'server':
                $this->runServer();
                break;
            case 'client':
                if ($argc < 3) {
                    throw new  Exception("Wrong argument count!");
                }
                $this->runClient($argv[2]);
                break;
            default:
                throw new Exception("Wrong run mode! Only client or server allowed");
                break;
        }
    }

    private function runServer()
    {

        $server = new Server($this->socket_path);
        $server->createSocket();
        $server->observe();
    }

    private function runClient($msg)
    {
        if (!$msg) {
            throw new Exception("Empty message!");
        }
        $client = new Client($this->socket_path);
        $client->sendMsg($msg);
    }
}
