<?php

declare(strict_types=1);

namespace nikitaglobal\controllers\client;

use nikitaglobal\controllers\Socket as PhpSocket;

/**
 * Socket class. Wrapper for PhpSocket
**/
class Socket
{
    private Socket $socket;

    public string $exitCommand = '';

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this->socket      = new Socket($config);
        $this->exitCommand = $this->socket->exitCommand;
    }

    /**
     * Create socket
     *
     * @return bool|PhpSocket
     */
    public function create(): bool|PhpSocket
    {
        return $this->socket->create();
    }

    /**
     * Connect to socket
     *
     * @return void
     */
    public function connect()
    {
        $this->socket->connect();
    }

    /**
     * Write message to socket
     *
     * @param string $message
     * @param mixed $socket
     *
     * @return void
     */
    public function write($message, $socket = null)
    {
        $this->socket->write($message, $socket);
    }

    /**
     * Read message from socket
     *
     * @param mixed $socket
     *
     * @return string
     */
    public function read($socket = null)
    {
        return $this->socket->read($socket);
    }

    /**
     * Close socket
     *
     * @param mixed $socket
     *
     * @return void
     */
    public function close($socket = null): void
    {
        $this->socket->close($socket);
    }
}
