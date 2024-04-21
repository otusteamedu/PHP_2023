<?php

namespace Anna\Chat;

class ClientSocket extends Socket
{
    public function run()
    {
        while (true) {
            echo 'Введите сообщение: ';
            $message = trim(fgets(STDIN)) . PHP_EOL;
            $this->createSocket();
            socket_connect($this->socket, $this->host);
            socket_write($this->socket, $message);

            if (($message = socket_read($this->socket, 1024)) !== false) {
                echo $message;
            }
        }
    }
}
