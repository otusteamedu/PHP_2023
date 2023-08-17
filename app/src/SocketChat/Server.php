<?php

declare(strict_types=1);

namespace Otus\SocketChat\SocketChat;

use Exception;
use Otus\SocketChat\Exception\WriteToStdoutException;
use Otus\SocketChat\Service\SocketService;
use Otus\SocketChat\Utils\ConfigInterface;
use Socket;

class Server
{
    private ConfigInterface $config;
    private Socket|false $socket;
    private Socket|false|null $connection = null;
    private SocketService $socketService;

    public function __construct(ConfigInterface $config, SocketService $socketService)
    {
        $this->config = $config;
        $this->socketService = $socketService;
    }

    public function run(): void
    {
        try {
            $socketFile = $this->config->get('socket_path');
            $this->initSocket($socketFile);
            $this->initSocketConnection();
            $this->handleInputMessage();
        } catch (Exception $exception) {
            $this->writeToStdout($exception->getMessage());
        } finally {
            $this->closeConnection($socketFile ?? null);
        }
    }

    private function initSocket(string $socketFile): void
    {
        $this->writeToStdout('start creating socket...');

        $this->socket = $this->socketService->createSocket();
        $this->socketService->bindSocketToFile($this->socket, $socketFile);
        $this->socketService->listenSocket($this->socket);

        $this->writeToStdout('socket was initialized successful');
    }

    private function initSocketConnection(): void
    {
        $this->writeToStdout('start connecting to socket...');

        $this->connection = $this->socketService->acceptSocketConnection($this->socket);

        $this->writeToStdout('Connection was established successful');
    }

    private function handleInputMessage(): void
    {
        $this->writeToStdout('Waiting for messages (Press "exit" to close connection)...');

        do {
            $input = $this->socketService->readFromSocket($this->connection);
            if ($input !== '') {
                $this->writeToStdout($input);
                $this->socketService->writeToSocket($this->connection, 'Received ' . strlen($input) . ' bytes');
            }
        } while ($input !== 'exit');
    }

    private function closeConnection(?string $socketFile): void
    {
        if ($this->connection) {
            socket_close($this->connection);
        }
        if ($this->socket) {
            socket_close($this->socket);
        }

        if (!is_null($socketFile) && file_exists($socketFile)) {
            unlink($socketFile);
        }
        $this->writeToStdout('Connection was closed');
    }

    private function writeToStdout(string $output): void
    {
        $bytes = fwrite(STDOUT, $output . PHP_EOL);
        if (false === $bytes) {
            throw new WriteToStdoutException();
        }
    }
}