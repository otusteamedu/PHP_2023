<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Vp\App\Config;
use Vp\App\DTO\InitResult;
use Vp\App\DTO\SocketMessage;

class Client implements SocketInterface
{
    private Output $output;
    private string $address;

    public function __construct(Output $output)
    {
        $this->output = $output;
        $this->address = Config::getSocketPath();
    }
    public function work()
    {
        $this->output->show(SocketMessage::CLIENT_APP);
        $initResult = $this->initSocket();

        if (!$initResult->isSuccess()) {
            $this->output->show($initResult->getError());
            return;
        }

        $socket = $initResult->getSocket();
        $this->output->show(SocketMessage::CLIENT_WELCOME);

        while (true) {
            $message = $this->getMessage();
            $write = $this->sendMessage($socket, $message);

            if (!$write) {
                $this->output->show(SocketMessage::ERROR_SERVER_CLOSED);
                break;
            }

            if (trim($message) === 'stop') {
                break;
            }

            $inbound = socket_read($socket, Config::getLength());
            $this->output->show(sprintf(SocketMessage::SERVER_MESSAGE, $inbound));
        }

        $this->output->show(SocketMessage::CLOSE_SOCKET);
        $this->close($socket);
    }

    private function initSocket(): InitResult
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($socket === false) {
            return new InitResult(
                false,
                sprintf(SocketMessage::FAILED_CREATE_SOCKET, socket_strerror(socket_last_error()))
            );
        }

        $result = socket_connect($socket, $this->address, 0);

        if ($result === false) {
            return new InitResult(
                false,
                sprintf(SocketMessage::FAILED_SOCKET_CONNECT, socket_strerror(socket_last_error($socket)))
            );
        }

        return new InitResult(true, null, $socket);
    }

    private function getMessage(): string|false
    {
        $message = stream_get_line(STDIN, Config::getLength(), PHP_EOL);
        return $message;
    }

    private function sendMessage(?\Socket $socket, bool|string $message): int|false
    {
        return socket_write($socket, $message, strlen($message));
    }

    private function close(\Socket $socket)
    {
        socket_close($socket);
    }
}
