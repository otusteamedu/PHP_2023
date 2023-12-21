<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

class Client
{
    private const EXIT = '/exit';
    private const STOP_SERVER = '/stopserver';

    private SocketClient $socket;

    public function __construct()
    {
        $settings = new Settings();
        $this->socket = new SocketClient($settings);
    }

    public function run(): void
    {
        Console::write('Welcome to BrownChat Client!');

        Console::write('Connecting to server... ', false);
        $isRunning = $this->connectToServer();
        Console::write($isRunning ? 'SUCCESS' : 'FAIL');

        while ($isRunning) {
            $message = Console::read('>>> ');
            if ($message !== '') {
                $result = $this->sendMessage($message);
                $isRunning = $this->isClientRunning($message, $result);
                if ($result !== '') {
                    Console::write("\e[90mSRV $result\e[0m\n");
                }
            }
        }
    }

    private function connectToServer(): bool
    {
        try {
            $result = $this->socket->connect();
            return $result;
        } catch(\Exception $e) {
            return false;
        }
    }

    private function sendMessage(string $message): string
    {
        try {
            $this->socket->write($message);
            $confirmation = $this->socket->read();
            return $confirmation;
        } catch(\Exception $e) {
            return '';
        }
    }

    private function isClientRunning(string $message, string $result): bool
    {
        $running = ($result !== '')
            && $message !== self::EXIT
            && $message !== self::STOP_SERVER;

        return $running;
    }
}
