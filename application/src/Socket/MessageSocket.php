<?php

declare(strict_types=1);

namespace Gesparo\Hw\Socket;

class MessageSocket
{
    private const ERROR_OF_BLOCK_RECEIVING_MESSAGE = 11;
    private const MESSAGE_LENGTH = 50;

    private \Socket $socket;
    private bool $doNotCloseSocket;

    /**
     * @param \Socket $socket
     * @param bool $doNotCloseSocket - it will be closed by caller
     */
    public function __construct(\Socket $socket, bool $doNotCloseSocket = false)
    {
        $this->socket = $socket;
        $this->doNotCloseSocket = $doNotCloseSocket;
    }

    public function read(): \Generator
    {
        while(($message = socket_read($this->socket, self::MESSAGE_LENGTH, PHP_BINARY_READ)) !== '') {
            if ($message === false) {
                if (socket_last_error($this->socket) === self::ERROR_OF_BLOCK_RECEIVING_MESSAGE) {
                    break;
                }

                throw new SocketException(socket_strerror(socket_last_error($this->socket)), socket_last_error($this->socket));
            }

            if ($message === '') {
                break;
            }

            yield $message;
        }
    }

    public function write(string $message): void
    {
        if (socket_write($this->socket, $message, strlen($message)) === false) {
            throw new SocketException(socket_strerror(socket_last_error($this->socket)), socket_last_error($this->socket));
        }
    }

    public function __destruct()
    {
        if (!$this->doNotCloseSocket) {
            socket_close($this->socket);
        }
    }
}