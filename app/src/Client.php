<?php

namespace Builov\Chat;

use Exception;

class Client
{
    private string $socket_path = '/tmp/socket.sock';
    private int $buffer = 2048;

    /**
     * @throws Exception
     */
    public function run(): iterable
    {
        while (true) {

            if ($message = trim(fread(STDIN, 1024))) {
                $socket = socket_create(AF_UNIX, SOCK_STREAM, 0); //возвращает экземпляр Socket в случае успешного выполнения, или false

                if (!$socket) {
                    throw new Exception('Не удалось создать сокет: ' . socket_strerror(socket_last_error()));
                }

                if (!socket_connect($socket, $this->socket_path)) {
                    throw new Exception('Не удалось подключиться к сокету: ' . socket_strerror(socket_last_error()));
                }

                $sent = socket_write($socket, $message, strlen($message)); //Возвращает количество байт, успешно записанных в сокет или false

                if (!$sent) {
                    throw new Exception('Сообщение не отправлено: ' . socket_strerror(socket_last_error()));
                }
            }

            if ($received_data = socket_read($socket, $this->buffer)) {
                yield $received_data;
            }
        }
    }
}
