<?php

namespace Radovinetch\Chat\Socket;

use http\Exception\RuntimeException;
use Radovinetch\Chat\Utils;

class Server
{
    protected bool $isServerStart = false;

    public function __construct(
        protected Utils $utils
    ) {}

    public function run(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, SOL_SOCKET);
        if (!$socket) {
            throw new RuntimeException('Не удалось создать сокет');
        }

        $socketFile = dirname(__DIR__, 2) . '/' . 'server.sock';
        $clientSocketFIle = dirname(__DIR__, 2) . '/' . 'client.sock';

        if (!socket_bind($socket, $socketFile)) {
            throw new RuntimeException('Не получилось забиндить сокет');
        }

        $this->isServerStart = true;

        while ($this->isServerStart) {
            @socket_recv($socket, $data, 2048, MSG_WAITALL);

            socket_set_nonblock($socket);

            if ($data === 'STOP') {
                $this->utils->log('Останаливаем сервер');

                $msg = 'STOP';
                $length = strlen($msg);
                socket_sendto($socket, $msg, $length, 0, $clientSocketFIle);

                unlink($socketFile);
                unlink($clientSocketFIle);

                $this->isServerStart = false;
            }

            $this->utils->log('Получено от клиента: ' . $data);

            $sendData = 'Received ' . strlen($data) . ' bytes';
            $sendDataLength = strlen($sendData);

            socket_sendto($socket, $sendData, $sendDataLength, 0, $clientSocketFIle);

            socket_set_block($socket);
        }
    }
}