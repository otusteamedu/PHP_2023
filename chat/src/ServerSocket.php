<?php

namespace Anna\Chat;

use Exception;

class ServerSocket extends Socket
{
    public function run()
    {
        $this->checkExists();
        $this->createSocket();
        $this->socketBind();
        socket_listen($this->socket, 3);

        while (true) {
            if (($connect = socket_accept($this->socket)) === false) {
                continue;
            }
            if (($message = socket_read($connect, 1024)) !== false) {
                echo $message;
                socket_write($connect, 'Received ' . mb_strlen($message, '8bit') . ' bytes' . PHP_EOL);
            }
        }
    }

    private function checkExists()
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }
    }

    /**
     * @throws Exception
     */
    protected function socketBind(): void
    {
        if (!socket_bind($this->socket, $this->host)) {
            throw new Exception("Unable to bind to 'chat.sock' reason: " . socket_strerror(socket_last_error($this->socket)));
        }
    }
}
