<?php

declare(strict_types=1);

namespace nikitaglobal\controllers\server;

use nikitaglobal\controllers\Socket as PhpSocket;

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
        return $this->socket->create(true);
    }

    /**
     * Bind socket
     *
     * @return void
     */
    public function bind()
    {
        $this->socket->bind();
    }

    /**
     * Listen socket
     *
     * @return void
     */
    public function listen()
    {
        $this->socket->listen();
    }

    /**
     * Accept socket
     *
     * @return mixed
     */
    public function accept()
    {
        return $this->socket->accept();
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
     * @return array
     */
    public function receive($socket): array
    {
        return $this->socket->receive($socket);
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
