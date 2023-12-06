<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Socket;

class ServerSocket extends AbstractSocket
{
    private \Socket $socket;
    private string $response = 'Hello from server';

    public function __construct()
    {
        try {
            $this->socket = $this->create();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        if ($this->bind() && $this->listen()) {
            while (true) {
                $clientSocket = $this->accept();
                $data = $this->read($clientSocket);
                $this->write($clientSocket, $this->response);
                $this->close($clientSocket);
            }
            $this->close($this->socket);
        } else {
            throw new \Exception('don\'t connect to the Socket');
        }
    }

    private function bind(): bool
    {
        return socket_bind($this->socket, self::SOCKET_FILE);
    }

    private function listen(): bool
    {
        return socket_listen($this->socket);
    }

    private function accept(): \Socket|false
    {
        return socket_accept($this->socket);
    }
}
