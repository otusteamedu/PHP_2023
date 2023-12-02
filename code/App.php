<?php

namespace Daniel\Socketchat;

class App
{
    public function run(string|null $argument)
    {
        switch ($argument) {
            case 'server':
                require 'UnixSocketServer.php';
                break;
            case 'client':
                require 'UnixSocketClient.php';
                break;
            default:
                echo "Usage: php index.php [server|client]\n";
                break;
        }
    }
}