<?php

namespace Sva\App;

use Exception;

class ClientMode
{
    /**
     * @throws Exception
     */
    public function start(): void
    {
        $config = Config::getInstance();
        $socketPath = $config->get('socket');

        if ($f = fopen('php://stdin', 'r')) {
            $running = true;

            while ($running) {
                echo "Введите сообщение для сервера\n";

                echo "> ";

                $message = trim(fgets($f));

                if ($message == 'exit') {
                    break;
                }

                $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
                if ($this->socket === false) {
                    throw new Exception("Unable to create socket: " . socket_strerror(socket_last_error()));
                }

                if (socket_connect($this->socket, $socketPath) === false) {
                    throw new Exception("Unable to connect socket: " . "[" . socket_last_error() . "] " . socket_strerror(socket_last_error()));
                }

                if (socket_write($this->socket, $message, strlen($message)) === false) {
                    throw new Exception("Unable to write message to server: " . socket_strerror(socket_last_error()));
                }

                $response = socket_read($this->socket, 1024);
                if ($response === false) {
                    throw new Exception("Unable to read response from server: " . socket_strerror(socket_last_error()));
                }

                echo $response;
                echo "\n";

                socket_close($this->socket);
            }

            $running = false;
            fclose($f);
        }
    }
}
