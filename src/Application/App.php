<?php

declare(strict_types=1);

namespace Dimal\Hw6\Application;

use Exception;
use Dimal\Hw6\Application\Server;
use Dimal\Hw6\Application\Client;

class App
{
    private string $socket_path = '';

    public function __construct()
    {
        $this->socket_path = getenv("SOCKET");
    }

    public function run($cmd): void
    {
        switch ($cmd) {
            case 'server':
                $this->runServer();
                break;
            case 'client':
                $this->runClient();
                break;
            default:
                throw new Exception("Wrong run mode! Only client or server allowed");
                break;
        }
    }

    private function runServer()
    {
        $server = new Server($this->socket_path);
        $server->observe();
    }

    private function runClient()
    {
        $stdin_handler = fopen("php://stdin", "r");
        $buf = '';
        echo "Hello to simple socket chat! (To quit type \"quit\" or \"exit\")\nPlease write message:\n";
        while ($chr = stream_get_contents($stdin_handler, 1)) {
            if (ord($chr) == 10) {
                if (!$buf) {
                    echo "Empty message!\n";
                    continue;
                }

                if ($buf == 'exit' || $buf == 'quit') {
                    echo("Goodbye!\n");
                    break;
                }
                echo "Send message: $buf\n";
                $this->sendMsg($buf);

                $buf = '';
            } else {
                $buf .= $chr;
            }
        }
    }

    private function sendMsg($msg)
    {
        if (!$msg) {
            throw new Exception("Empty message!");
        }
        $client = new Client($this->socket_path);
        $client->sendMsg($msg);
    }
}
