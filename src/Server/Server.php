<?php

namespace Server;

use Exception;

class Server
{
    private $socket;
    
    public function __construct($socketPath)
    {
        $this->socket = new ServerSocket($socketPath);
    }
    
    public function run(): void
    {
        try {
            $this->socket->create();
            while (true) {
                $clientSocket = $this->socket->accept();
                $message = $this->socket->receive($clientSocket);
                echo "Сервер получил сообщение: $message\n";
                $this->socket->send($clientSocket, $message);
                fclose($clientSocket);
            }
        } catch (Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
