<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw6\Chat;

class Server extends Base
{
    public function run()
    {
        $unix = $this->getUnixSocket();
        unlink($unix);

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (socket_bind($socket, $unix) === false) {
            throw new \Exception(socket_strerror(socket_last_error()));
        }

        if (!socket_listen($socket)) {
            throw new \Exception(socket_strerror(socket_last_error()));
        }

        while (true) {
            $conn = socket_accept($socket);
            $data = socket_read($conn, static::MESSAGE_LENGTH);
            $answer = $this->getAnswer($data);
            fwrite(STDOUT, $data);
            socket_write($conn, $answer . PHP_EOL);
            socket_close($conn);
            unset($data);
            unset($answer);
        }
    }

    protected function getAnswer(string $data): string
    {
        $messageLength = mb_strlen($data);
        return "Received $messageLength bytes";
    }
}
