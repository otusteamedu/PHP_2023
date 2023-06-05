<?php

namespace AShashkov\ConsoleSocketChat\Socket;

class ClientSocket extends Socket
{
    public function consoleChat()
    {
        $this->initSocket();

        while (true) {
            echo 'Type message and press Return key: ';
            $message = readline();
            $this->write($message);

            echo 'The server received ' . $this->read() . ' bytes.' . PHP_EOL;
        }
    }

    private function initSocket()
    {
        $this->create();
        $this->connect();
    }
}
