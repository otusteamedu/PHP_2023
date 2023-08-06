<?php

namespace MIgonin\ConsoleSocketChat;

use MIgonin\ConsoleSocketChat\Socket\ClientSocket;
use MIgonin\ConsoleSocketChat\Socket\ServerSocket;
use Exception;

class App
{
    public function run(): void
    {
        if (count($_SERVER['argv']) != 2 || ! in_array($_SERVER['argv'][1], ['server', 'client'])) {
            throw new Exception('Please choose the side "server" or "client".');
        }

        switch ($_SERVER['argv'][1]) {
            case 'server':
                $serverSocket = new ServerSocket();
                $serverSocket->consoleChat();
                break;
            case 'client':
                $clientSocket = new ClientSocket();
                $clientSocket->consoleChat();
                break;
        }
    }
}
