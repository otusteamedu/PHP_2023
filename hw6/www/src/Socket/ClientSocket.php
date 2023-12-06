<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Socket;

class ClientSocket extends AbstractSocket
{
    private \Socket $socket;
    private string $data = "Hello from client";

    /**
     * @throws \Exception
     */
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
        if ($this->connect()) {
            $this->write($this->socket, $this->data);
            $response = $this->read($this->socket);
            $this->close($this->socket);
        } else {
            throw new \Exception('don\'t connect to the Socket');
        }
    }

    private function connect(): bool
    {
        return socket_connect($this->socket, self::SOCKET_FILE);
    }
}
