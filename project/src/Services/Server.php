<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Vp\App\Config;
use Vp\App\DTO\InitResult;
use Vp\App\DTO\SocketMessage;

class Server implements SocketInterface
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
        set_time_limit(0);
        ob_implicit_flush();

        unlink($this->address);

        $this->output->show(SocketMessage::SERVER_APP);
        $initResult = $this->initSocket();

        if (!$initResult->isSuccess()) {
            $this->output->show($initResult->getError());
            return;
        }

        $sock = $initResult->getSocket();
        $this->output->show(SocketMessage::SOCKET_CREATE);

        while (true) {
            $msgSock = socket_accept($sock);

            if ($msgSock === false) {
                $this->output->show(
                    sprintf(SocketMessage::FAILED_RECEIVING_SOCKET, socket_strerror(socket_last_error()))
                );
                break;
            }

            $this->output->show(SocketMessage::RECEIVING_SOCKET);

            while (true) {
                $inbound = socket_read($msgSock, Config::getLength());

                if ($inbound === false) {
                    $this->output->show(
                        sprintf(SocketMessage::FAILED_READ_MESSAGE, socket_strerror(socket_last_error($msgSock)))
                    );
                    $this->close($msgSock);
                    break 2;
                }

                if ($inbound == 'stop') {
                    $this->output->show(SocketMessage::CLIENT_DISCONNECT);
                    $this->close($msgSock);
                    break 2;
                }

                $this->output->show(SocketMessage::MESSAGE_SEPARATOR);
                $this->output->show($inbound);

                $write = $this->sendResponse($inbound, $msgSock);

                if (!$write) {
                    $this->output->show(SocketMessage::ERROR_CLIENT_CLOSED);
                    $this->close($msgSock);
                    break 2;
                }
            }
        }

        $this->output->show(SocketMessage::CLOSE_SOCKET);
        $this->close($sock);
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

        $bound = socket_bind($socket, $this->address);

        if ($bound === false) {
            return new InitResult(
                false,
                sprintf(SocketMessage::FAILED_BIND_SOCKET, socket_strerror(socket_last_error($socket)))
            );
        }

        $listening = socket_listen($socket, 5);

        if ($listening === false) {
            return new InitResult(
                false,
                sprintf(SocketMessage::FAILED_LISTEN_SOCKET, socket_strerror(socket_last_error($socket)))
            );
        }

        return new InitResult(true, null, $socket);
    }

    private function close(\Socket $socket)
    {
        socket_close($socket);
    }

    private function sendResponse(string $inbound, \Socket $msgSock): int|false
    {
        $response = sprintf(SocketMessage::RESPONSE_MESSAGE, $inbound) . PHP_EOL;
        return socket_write($msgSock, $response, strlen($response));
    }
}
