<?php

namespace Alexgaliy\ConsoleChat;

use Exception;

class Server
{
    private $socket;
    private $address;
    private $port;

    public function __construct($address)
    {
        $this->address = $address;
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket === false) {
            throw new Exception("Не удалось создать сокет: " . socket_strerror(socket_last_error()));
        }

        // Удаляем старый сокет, если он существует
        if (file_exists($this->address)) {
            unlink($this->address);
        }

        if (socket_bind($this->socket, $this->address) === false) {
            throw new Exception("Не удалось привязать сокет: " . socket_strerror(socket_last_error($this->socket)));
        }

        if (socket_listen($this->socket, 5) === false) {
            throw new Exception("Не удалось слушать сокет: " . socket_strerror(socket_last_error($this->socket)));
        }
    }

    public function run()
    {
        // echo "Сервер запущен и слушает на $this->address...\n";
        fwrite(STDOUT, 'Сервер запущен и слушает на ' . $this->address . PHP_EOL);
        while (true) {
            $clientSocket = socket_accept($this->socket);
            if ($clientSocket !== false) {
                $this->handleClient($clientSocket);
                socket_close($clientSocket);
            }
        }
    }

    private function handleClient($clientSocket)
    {
        $input = socket_read($clientSocket, 1024);
        if ($input !== false) {
            // echo "Получено сообщение: $input\n";
            fwrite(STDOUT, "Получено сообщение: " . $input . PHP_EOL);
            $response = "Вы сказали: " . trim($input);
            socket_write($clientSocket, $response, strlen($response));
        }
    }

    public function __destruct()
    {
        socket_close($this->socket);
        if (file_exists($this->address)) {
            unlink($this->address);
        }
    }
}
