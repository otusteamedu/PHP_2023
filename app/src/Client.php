<?php

namespace Sherweb;

use Exception;

class Client
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        while ($line = fgets(STDIN)) {
            $this->sendMessage($line);
        }
    }

    /**
     * @throws Exception
     */
    private function sendMessage($message): void
    {
        $socket = new Socket($this->config['PATH_CLIENT_SOCKET_FILE']);
        if (!$socket->bind()) {
            throw new Exception('Unable to bind to files!');
        }
        $bytes_sent = $socket->sendMessage($message, $this->config['PATH_SERVER_SOCKET_FILE']);
        if ($bytes_sent == -1) {
            throw new Exception('An error occured while sending to the socket!');
        }
        if (!$socket->setBlock()) {
            throw new Exception('Unable to set blocking mode for socket!');
        }
        $data = $socket->getMessage();
        if ($data['bytes_received'] == -1) {
            throw new Exception('An error occured while receiving from the socket!');
        }
        fwrite(STDOUT, $data['buf'] . PHP_EOL);
        if (!$socket->setNonBlock()) {
            throw new Exception('Unable to set nonblocking mode for socket!');
        }
    }
}