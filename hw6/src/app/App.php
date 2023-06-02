<?php

namespace AShashkov\ConsoleSocketChat;

use \Exception;

class App
{
    public function run(): void
    {
        if (count($_SERVER['argv']) != 2 || ! in_array($_SERVER['argv'][1], ['server', 'client'])) {
            throw new Exception('Please choose the side "server" or "client".');
        }

        switch ($_SERVER['argv'][1]) {
            case 'server':
                $serverSocket = new Socket();
                $serverSocket->create(true);
                $serverSocket->bind();
                $serverSocket->listen();

                echo 'Awaiting for client message...' . PHP_EOL;

                $client = $serverSocket->accept();

                while (true) {
                    $message = $serverSocket->receive($client);
                    if (! is_null($message['message'])) {
                        echo $message['message'] . PHP_EOL;

                        $serverSocket->write($message['length'], $client);
                    }
                }
                break;
            case 'client':
                $clientSocket = new Socket();
                $clientSocket->create();
                $clientSocket->connect();

                while (true) {
                    echo 'Type message and press Return key: ';
                    $message = readline();
                    $clientSocket->write($message);

                    echo 'The server received ' . $clientSocket->read() . ' bytes.' . PHP_EOL;
                }
                break;
        }
    }
}
