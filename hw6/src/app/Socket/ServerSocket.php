<?php

namespace AShashkov\ConsoleSocketChat\Socket;

class ServerSocket extends Socket
{
    public function consoleChat()
    {
        $this->initSocket();

        echo 'Awaiting for client message...' . PHP_EOL;

        $client = $this->accept();

        while (true) {
            $message = $this->receive($client);
            if (! is_null($message['message'])) {
                echo $message['message'] . PHP_EOL;

                $this->write($message['length'], $client);
            }
        }
    }

    private function initSocket()
    {
        $this->create(true);
        $this->bind();
        $this->listen();
    }
}
