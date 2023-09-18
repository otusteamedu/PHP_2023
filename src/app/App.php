<?php

namespace chat;

use chat\Socket\ClientSocket;
use chat\Socket\ServerSocket;
use Exception;

class App
{
  /**
   * @throws Exception
   */
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
