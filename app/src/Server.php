<?php

namespace Builov\Chat;

use Exception;

class Server
{
    private $socket_path = '/tmp/socket.sock';
    private $buffer = 2048;
    private bool $isRunning = false;

    public function __construct()
    {
        if (file_exists($this->socket_path)) {
            unlink($this->socket_path);
        }
    }

    public function run(): iterable
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$socket) {
            throw new Exception('Не удалось создать сокет: ' . socket_strerror(socket_last_error()));
        }

        if (!socket_bind($socket, $this->socket_path) || !socket_listen($socket)) {
            throw new Exception('Ошибка подключения к сокету: ' . socket_strerror(socket_last_error()));
        }

        $this->isRunning = true;

        while ($this->isRunning) {
            $client = socket_accept($socket); //возвращает экземпляр Socket или false

            if ($client !== false) {
                $received_data = socket_read($client, $this->buffer); //возвращает данные в виде строки в случае успешного выполнения, или false

                $response = 'Сервером получено ' . strlen($received_data) . ' байт.' . PHP_EOL;
                socket_write($client, $response, strlen($response));

                yield $received_data . PHP_EOL;

                socket_close($client);
            }
        }
    }
}
