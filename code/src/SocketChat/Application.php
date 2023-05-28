<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw6\SocketChat;

use VKorabelnikov\Hw6\SocketChat\Server;
use VKorabelnikov\Hw6\SocketChat\Client;

class Application
{
    public function run()
    {
        if ($_SERVER['argv'][1] == "server") {
            $obServer = new Server();
            $obServer->run();
        } else if ($_SERVER['argv'][1] == "client") {
            $obClient = new Client();
            $obClient->run();
        } else {
            throw new \Exception("Incorrect parameter");
        }
    }
}
