<?php

namespace Sva\App\Socket;

use Exception;
use Socket;
use Sva\App\Config;

class Connection
{
    private Socket $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    /**
     * @param string $message
     * @return Connection
     * @throws Exception
     */
    public function write(string $message): Connection
    {
        if (!socket_write($this->socket, $message, strlen($message))) {
            throw new Exception("Unable to write response to client: " . socket_strerror(socket_last_error()));
        }

        return $this;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function read(): string
    {
        $message = socket_read($this->socket, 1024);

        if ($message === false) {
            throw new Exception("Unable to read message from client: " . socket_strerror(socket_last_error()));
        }

        return $message;
    }

    public function close(): Connection
    {
        socket_close($this->socket);
        return $this;
    }

    /**
     * @param Manager $manager
     * @return static
     * @throws Exception
     */
    public static function accept(Manager $manager): static
    {
        $clientSocket = socket_accept($manager->getSocket());
        if ($clientSocket === false) {
            throw new Exception("Unable to accept client connection: " . socket_strerror(socket_last_error()));
        }

        return new self($clientSocket);
    }

    /**
     * @return static
     * @throws Exception
     */
    public static function connect(): self
    {
        $config = Config::getInstance();
        $socketPath = $config->get('socket');

        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            throw new Exception("Unable to create socket: " . socket_strerror(socket_last_error()));
        }

        if (socket_connect($socket, $socketPath) === false) {
            throw new Exception("Unable to connect socket: " . "[" . socket_last_error() . "] " . socket_strerror(socket_last_error()));
        }

        return new self($socket);
    }
}
