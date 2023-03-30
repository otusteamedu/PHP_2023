<?php

declare(strict_types=1);

namespace Aporivaev\Hw09;


use Exception;
use Socket;

class Server extends AppSocket
{
    public ?string $name;
    private ?Socket $clientSocket = null;
    private ?string $clientName = null;

    public function __construct(string $fileName, string $name = null)
    {
        parent::__construct($fileName);
        $this->name = !empty($name) ? $name : 'Server';
    }

    /** @throws Exception */
    public function run(): void
    {
        $this->serverListen();

        $end = false;
        $inBuffer = '';
        while (!$end) {
            if ($this->readStdIn($inBuffer)) {
                $end = $inBuffer === $this->commandQuit;
                if (!$end) {
                    $this->sendMessageClient($inBuffer);
                }
                $inBuffer = '';
            }

            $this->newClient(socket_accept($this->socket));

            if ($this->clientSocket) {
                if ($input = $this->read($this->clientSocket)) {
                    if ($input === $this->commandQuit) {
                        $this->closeClient();
                    } else {
                        $this->sendEchoClient($input);
                    }
                }
            }
        }

        $this->close($this->socket);
        if ($this->clientSocket) {
            $this->close($this->clientSocket);
        }
    }

    private function newClient(Socket | false $connection): void
    {
        if ($connection !== false) {
            socket_set_nonblock($connection);
            do {
                $input = $this->read($connection);
            } while (!is_string($input));
            $this->clientSocket = $connection;
            $this->clientName = $input;
            echo "New connection: {$this->clientName}\n";
        }
    }
    private function closeClient(): void
    {
        echo "Disconnection: {$this->clientName}\n";
        $this->close($this->clientSocket);
        $this->clientSocket = null;
    }

    /** @throws AppException */
    private function sendMessageClient(string $message): void
    {
        if ($this->clientSocket !== null) {
            $this->write($message, $this->clientSocket);
        } else {
            echo "No client connection\n";
        }
    }
    private function sendEchoClient(string $message): void
    {
        echo "{$this->clientName}: $message\n";

        $response = "Received " . strlen($message) . " bytes";
        socket_write($this->clientSocket, $response);
    }
}
