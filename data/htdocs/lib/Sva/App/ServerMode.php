<?php

namespace Sva\App;

use Exception;

class ServerMode
{
    protected bool $running = false;
    private \Socket $socket;
    /**
     * @var array|\ArrayAccess|mixed|null
     */
    private mixed $socketPath;

    /**
     * @return void
     * @throws Exception
     */
    public function start(): void
    {
        $this->running = true;

        $config = Config::getInstance();
        $this->socketPath = $config->get('socket');

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket === false) {
            throw new Exception("Unable to create socket: " . socket_strerror(socket_last_error()));
        }

        if (socket_bind($this->socket, $this->socketPath) === false) {
            throw new Exception("Unable to bind socket: " . "[" . socket_last_error() . "] " . socket_strerror(socket_last_error()));
        }

        if (socket_listen($this->socket) === false) {
            throw new Exception("Unable to listen on socket: " . socket_strerror(socket_last_error()));
        }

        while ($this->running) {
            $clientSocket = socket_accept($this->socket);
            if ($clientSocket === false) {
                throw new Exception("Unable to accept client connection: " . socket_strerror(socket_last_error()));
            }

            $message = socket_read($clientSocket, 1024);
            if ($message === false) {
                throw new Exception("Unable to read message from client: " . socket_strerror(socket_last_error()));
            }

            $response = "Получено сообщение(" . strlen($message) . " байт): " . $message;
            echo $response . "\n";

            if (socket_write($clientSocket, $response) === false) {
                throw new Exception("Unable to write response to client: " . socket_strerror(socket_last_error()));
            }

            socket_close($clientSocket);
        }

        socket_close($this->socket);
    }

    public function stop()
    {
        $this->running = false;
    }

    public function __destruct()
    {
        $this->stop();
    }
}
