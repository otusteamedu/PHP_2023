<?php

namespace Radovinetch\Chat\Socket;

use http\Exception\RuntimeException;
use Radovinetch\Chat\Utils;
use Socket;

class Client
{
    protected Socket $socket;

    protected string $socketFile;

    protected string $serverSock;

    public function __construct(
        protected Utils $utils
    ) {}

    public function run(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, SOL_SOCKET);
        if (!$this->socket) {
            throw new RuntimeException('Не удалось создать сокет');
        }

        $this->socketFile = dirname(__DIR__, 2) . '/' . 'client.sock';
        $this->serverSock = dirname(__DIR__, 2) . '/' . 'server.sock';

        if (!socket_bind($this->socket, $this->socketFile)) {
            throw new RuntimeException('Не получилось забиндить сокет');
        }

        socket_set_nonblock($this->socket);

        $this->read();
    }

    private function read(): void
    {
        $message = readline('Введите сообщение для сервера: ');
        $this->send($message);
    }

    private function send(string $msg): void
    {
        $length = strlen($msg);
        socket_sendto($this->socket, $msg, $length, 0, $this->serverSock);

        while (true) {
            @socket_recvfrom($this->socket, $data, 2048, 0, $this->socketFile);
            if ($data !== null) {
                var_dump($data);

                if ($data === 'STOP') {
                    $this->utils->log('Получен сигнал завершения от сервера.');
                    break;
                }

                $this->utils->log('Получено от сервера: ' . $data);
                $this->read();
                break;
            }
        }
    }
}