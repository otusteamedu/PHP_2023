<?php

namespace IilyukDmitryi\App\Workers\Socket;

use Exception;
use IilyukDmitryi\App\Workers\Workers;

abstract class Socket implements Workers
{
    protected const SOCKET_ADRESS = 'unix://';
    protected const SOCKET_FILE = '/socket/app.sock';
    protected const SOCKET_MESSAGE_MAX_LEN = 1024;
    protected const MESSAGE_EXIT = "exit";
    protected $socket;
    protected $stream;

    protected function isMessageDelivered($receivedMessage, $sendMessage): bool
    {
        return $receivedMessage === $this->getConfirmationMessage($sendMessage);
    }

    protected function getConfirmationMessage($message): string
    {
        return "Received " . strlen($message) . " bytes\n";
    }

    /**
     * @throws Exception
     */
    protected function getRemoteMessage(): bool|string
    {
        if (is_null($this->stream)) {
            throw new Exception('Stream  null');
        }
        return fread($this->stream, static::SOCKET_MESSAGE_MAX_LEN);
    }

    /**
     * @throws Exception
     */
    protected function sendMessage($message): void
    {
        if (is_null($this->stream)) {
            throw new Exception('Stream  null');
        }
        fputs($this->stream, $message);
    }

    protected function isExitMessage(string $message): bool
    {
        return $message === static::MESSAGE_EXIT . "\n";
    }

    protected function closeStream(): void
    {
        if ($this->stream) {
            fclose($this->stream);
        }
    }

    protected function closeSocket(): void
    {
        if ($this->socket) {
            fclose($this->socket);
        }
    }
}
