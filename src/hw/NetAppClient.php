<?php

namespace Ndybnov\Hw05\hw;

error_reporting(E_ERROR);

use Ndybnov\Hw05\hw\interface\NetworkApplicationInterface;
use NdybnovHw03\CnfRead\ConfigStorage;

class NetAppClient implements NetworkApplicationInterface
{
    private string $message;
    private $socket;
    private string $client_side_sock;
    private string $server_side_sock;
    private int|false $bytes_sent;

    private StateServer $stateServer;

    public function startWaiting()
    {
        $this->stateServer->setWait();
    }

    public function isWait()
    {
        return $this->stateServer->isWaiting();
    }

    public function __construct()
    {
        $this->init();
        $this->stateServer = new StateServer();
    }

    private function init()
    {
        $pathToSrc = dirname(__DIR__);
        Output::debug('Client:: path: ' . $pathToSrc);

        $configStorage = (new ConfigStorage())->fromDotEnvFile([$pathToSrc, 'config.ini']);

        $this->server_side_sock = $configStorage->get('socket-share-file');
        Output::debug('Client:: server_side_sock: ' . $this->server_side_sock);

        $client_path_to_sockets = $configStorage->get('socket-client-path');
        $client_postfix_name_ile_sockets = $configStorage->get('socket-client-template-name-file');

        $correctPathToClientSocket = $this->buildClientNameSocket(
            $client_path_to_sockets,
            $client_postfix_name_ile_sockets
        );
        Output::debug($correctPathToClientSocket);

        $this->client_side_sock = $correctPathToClientSocket;
    }

    private function buildClientNameSocket(string $pathBeforeSocket, string $templateNameSocket): string
    {
        return $pathBeforeSocket . DIRECTORY_SEPARATOR . $this->generateUniqSocketName() . $templateNameSocket;
    }

    private function generateUniqSocketName(): string
    {
        return uniqid('file_', false) . '_';
    }

    public function startSocket()
    {
        $this->socket = \socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket) {
            throw new \RuntimeException('Unable to create AF_UNIX socket');
        }
    }

    public function refreshSocket(string $command = '')
    {
        if ($command) {
            \socket_close($this->socket);
            Output::info(PHP_EOL . 'Client:: socket closed.' . PHP_EOL);

            if (\file_exists($this->client_side_sock)) {
                \unlink($this->client_side_sock);
                Output::info(PHP_EOL . 'Client:: unlinked: ' . $this->client_side_sock . PHP_EOL);
            }

            $this->startSocket();
        }
    }

    public function bindSocket()
    {
        if (!\socket_bind($this->socket, $this->client_side_sock)) {
            throw new \RuntimeException("Unable to bind to $this->client_side_sock");
        }
    }

    public function setBockModeSocket()
    {
        $socket = $this->socket;
        if (!\socket_set_nonblock($socket)) {
            throw new \RuntimeException('Unable to set nonblocking mode for socket');
        }
        $this->socket = $socket;
    }


    public function getMessage(): string
    {
        $prompt = 'Please, input your message (on `off` for turn off chat): ';
        $this->message = \readline($prompt);

        return $this->message;
    }

    public function message()
    {
        Output::info( 'client: send message to server');

        $msg = $this->message;
        $len = \mb_strlen($msg);
        // at this point 'server' process must be running and bound to receive from serv.sock
        $this->bytes_sent = \socket_sendto($this->socket, $msg, $len, 0, $this->server_side_sock);
        if (false === $this->bytes_sent) {
            throw new ServerUnavailableRuntimeException();
        }
        if ($this->bytes_sent != $len) {
            $this->stopSocket();
            throw new \RuntimeException($this->bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected ' . $this->server_side_sock);
        }
        if ($this->bytes_sent == -1) {
            throw new \RuntimeException('An error occured while sending to the socket');
        }

        $this->message = $msg;
    }

    public function confirm()
    {
        Output::info( 'client: show got confirmation');

        if (!\socket_set_block($this->socket)) {
            throw new \RuntimeException('Unable to set blocking mode for socket');
        }
        $buf = '';
        $from = '';
        $bytes_received = \socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            throw new \RuntimeException('An error occured while receiving from the socket');
        }
        Output::info("Client: Received [$buf] from [$from]\n");
        Output::show("Log:: [$buf] from [$from]");
    }


    public function determineNeedToWait()
    {
        if ('logout' === $this->message) {
            Output::debug('Client:: debug: is-out-message');
            $this->stopSocket();
            $this->stateServer->setStop();
        }

        if ('all-turn-off' === $this->message) {
            Output::debug('Client:: debug: turn-off');
            $this->stopSocket();
            $this->stateServer->setStop();
        }
    }

    public function stopSocket()
    {
        \socket_close($this->socket);

        \unlink($this->client_side_sock);
    }
}
