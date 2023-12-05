<?php

declare(strict_types=1);

namespace Yalanskiy\Chat;

use RuntimeException;

/**
 * Class Server
 */
class Server
{
    private Socket $socket;
    public function __construct()
    {
        $this->socket = new Socket();
    }

    /**
     * Run Server
     * @return void
     */
    public function run(): void
    {
        try {
            $this->socket->create();
            echo "Server started" . PHP_EOL;
            while ($this->socket->accept()) {
                $message = $this->socket->receive();
                fwrite(STDOUT, "Received message: {$message}" . PHP_EOL);
                $this->socket->send("Received " . mb_strlen($message) . " bytes");
                $this->socket->close();
                if ($message === "quit") {
                    break;
                }
            }
        } catch (RuntimeException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}
