<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw6\Chat;

class Client extends Base
{
    public function run()
    {
        $unix = $this->getUnixSocket();

        while (($line = fgets(STDIN)) !== false) {

            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            if (!$socket) {
                throw new \Exception(socket_strerror(socket_last_error()));
            }

            $connect = socket_connect($socket, $unix);
            if (!$connect) {
                throw new \Exception(socket_strerror(socket_last_error()));
            }

            socket_write($socket, $line);
            $data = socket_read($socket, static::MESSAGE_LENGTH);
            if (!$data) {
                continue;
            }
            fwrite(STDOUT, $data);
            socket_close($socket);
        }
    }
}
