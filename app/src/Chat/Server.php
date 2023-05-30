<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw6\Chat;

class Server extends Base
{
    public function run()
    {
        $socket = stream_socket_server(
            $this->getServerAddress(),
            $errno,
            $errstr
        );

        if (!$socket) {
            http_response_code($errno);
            throw new \Exception($errstr);
        }

        while (true) {
            while ($conn = stream_socket_accept($socket)) {
                $data = fread($conn, static::MESSAGE_LENGTH);
                $answer = $this->getAnswer($data);
                fwrite(STDOUT, $data);
                fwrite($conn, $answer . PHP_EOL);
                fclose($conn);
                unset($data);
                unset($answer);
            }
        }
    }

    protected function getAnswer(string $data): string
    {
        $messageLength = mb_strlen($data);
        return "Received $messageLength bytes";
    }
}
