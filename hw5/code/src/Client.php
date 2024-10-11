<?php

namespace Alexgaliy\ConsoleChat;

use Exception;

class Client
{
    private $socketPath;
    private $client;

    public function __construct($socketPath)
    {
        $this->socketPath = $socketPath;
        $this->client = null;
    }

    public function run()
    {
        // Основной код
        try {
            foreach ($this->getUserInput() as $message) {
                $this->connect();
                // Получаем ответ от сервера
                $response = $this->sendMessage($message);
                echo "Ответ от сервера: $response\n";
            }
        } catch (Exception $e) {
            return $e->getMessage() . PHP_EOL;
        }
    }

    public function connect()
    {
        // Создаем Unix-сокет
        $this->client = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->client === false) {
            throw new Exception("Не удалось создать сокет: " . socket_strerror(socket_last_error()));
        }

        // Подключаемся к серверу
        if (socket_connect($this->client, $this->socketPath) === false) {
            throw new Exception("Не удалось подключиться к серверу: " . socket_strerror(socket_last_error($this->client)));
        }
    }

    public function sendMessage($message)
    {
        // Отправляем сообщение серверу
        socket_write($this->client, $message, strlen($message));
        // Читаем ответ от сервера
        $response = socket_read($this->client, 1024);
        return $response;
    }

    public function disconnect()
    {
        // Закрываем соединение с сервером
        if ($this->client) {
            socket_close($this->client);
        }
    }

    private function getUserInput()
    {
        while (true) {
            // Вводим сообщение
            $message = readline("Введите сообщение: ");
            yield $message; // Возвращаем введенное сообщение
        }
    }
}
