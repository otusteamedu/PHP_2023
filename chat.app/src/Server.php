<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

use Dshevchenko\Brownchat\SocketServer;

class Server
{
    private const EXIT = '/exit';
    private const STOP_SERVER = '/stopserver';

    private SocketServer $socket;

    public function __construct()
    {
        $settings = new Settings();
        $this->socket = new SocketServer($settings);
    }

    public function run(): void
    {
        Console::write('Welcome to BrownChat Server!');

        Console::write('Creating socket... ', false);
        $isRunning = $this->createSocket();
        Console::write($isRunning ? 'SUCCESS' : 'FAIL');

        while ($isRunning) {
            Console::write('Waiting for client... ', false);
            if ($this->acceptClient()) {
                Console::write('CONNECTED');
                $isReading = true;
            } else {
                $isReading = false;
                $isRunning = false;
            }

            while ($isRunning && $isReading) {
                $message = $this->readFromClient();
                if ($this->isClientDisconnected($message)) {
                    $isReading = false;
                } elseif ($this->isServerStopped($message)) {
                    $isRunning = false;
                } else {
                    Console::write('>>> ' . $message);
                    $isReading = $this->confirmReading($message);
                }

                if (!$isReading) {
                    Console::write('Client is disconnected');
                    $this->dropClient();
                }
            }
        }
    }

    private function createSocket(): bool
    {
        try {
            $result = $this->socket->create();
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function acceptClient(): bool
    {
        try {
            $result = $this->socket->accept();
            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function dropClient(): void
    {
        $this->socket->drop();
    }

    private function readFromClient(): string
    {
        $incomingMsg = $this->socket->read();
        return $incomingMsg;
    }

    private function confirmReading(string $message): bool
    {
        $messageLen = strlen($message);
        try {
            $this->socket->write('Received ' . (string)$messageLen . ' bytes');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function isClientDisconnected(string $message): bool
    {
        $disconnected = ($message === self::EXIT) || ($message === '');
        return $disconnected;
    }

    private function isServerStopped(string $message): bool
    {
        $stopped = ($message === self::STOP_SERVER);
        return $stopped;
    }
}
