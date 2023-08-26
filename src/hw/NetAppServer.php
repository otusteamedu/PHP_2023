<?php

namespace Ndybnov\Hw05\hw;

error_reporting(E_ERROR);

use Ndybnov\Hw05\hw\interface\NetworkApplicationInterface;
use NdybnovHw03\CnfRead\ConfigStorage;

class NetAppServer implements NetworkApplicationInterface
{
    private $socket;
    private $server_side_sock;

    private string $message;
    private string $messageWithSize;
    private string $from;

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
        $configStorage = (new ConfigStorage())->fromDotEnvFile([$pathToSrc, 'config.ini']);
        $this->server_side_sock = $configStorage->get('socket-share-file');
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
            Output::info(PHP_EOL . 'Server:: unbinding ...' . $this->server_side_sock . PHP_EOL);

            Output::info(PHP_EOL . 'Server:: close socket' . PHP_EOL);
            \socket_close($this->socket);
            Output::info(PHP_EOL . 'Server:: closed socket' . PHP_EOL);

            if (\file_exists($this->server_side_sock)) {
                Output::info(PHP_EOL . 'Server:: unlink file: ' . $this->server_side_sock . PHP_EOL);
                \unlink($this->server_side_sock);
            }

            $this->startSocket();
        }
    }

    public function bindSocket()
    {
        $server_side_sock = $this->server_side_sock;

        Output::info(PHP_EOL . 'Server:: binding ... ' . PHP_EOL);
        Output::info(PHP_EOL . 'Server::' . $server_side_sock . PHP_EOL);
        Output::info(PHP_EOL . 'Server:: socket' . ($this->socket ?'+':'-') . PHP_EOL);

        if (!\socket_bind($this->socket, $server_side_sock)) {
            throw new \RuntimeException("Server:: Unable to bind to $server_side_sock.");
        }
    }

    public function setBockModeSocket()
    {
        if (!\socket_set_block($this->socket)) {
            throw new \RuntimeException('Unable to set blocking mode for socket');
        }
    }

    public function getMessage(): string
    {
        Output::info('Server: getMessage');
        Output::log('Log-server:: Ready to receive...');

        $buf = '';
        $from = '';
        $bytes_received = \socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            throw new \RuntimeException('An error occured while receiving from the socket');
        }
        Output::show("Server: Received [$buf] from [$from]");

        $this->message = $buf;
        $this->from = $from;

        return $buf;
    }

    public function message()
    {
        Output::debug('Server: message');
        $calcBytes = \mb_strlen($this->message, '8bit');
        $responseWithBytes = 'Received ' . $calcBytes . ' bytes';
        $buf = $this->message . "->Response " . ('(' . $responseWithBytes . ')');

        $this->messageWithSize = $buf;
    }

    public function confirm()
    {
        Output::debug('Server: confirm');

        if (!socket_set_nonblock($this->socket)) {
            throw new \RuntimeException('Unable to set nonblocking mode for socket');
        }

        $lenMsgWithSize = \mb_strlen($this->messageWithSize);
        $bytes_sent = \socket_sendto($this->socket, $this->messageWithSize, $lenMsgWithSize, 0, $this->from);
        if ($bytes_sent != $lenMsgWithSize) {
            throw new \RuntimeException($bytes_sent . ' bytes have been sent instead of the ' . $lenMsgWithSize . ' bytes expected');
        }
        if ($bytes_sent == -1) {
            throw new \RuntimeException('An error occured while sending to the socket');
        }

        Output::info("Server: BiteSent: " . $bytes_sent);
        Output::info("Server: Request processed");
    }

    public function determineNeedToWait()
    {
        Output::debug('Server-determineNeedToWait: buf: `' . $this->message .'`');

        if ('server-off' === $this->message) {
            Output::info( 'Server: stopping');
            $this->stateServer->setStop();
        }
        if ('all-turn-off' === $this->message) {
            Output::debug('Server:: debug: turn-off');
            $this->stopSocket();
            $this->stateServer->setStop();
        }
    }

    public function stopSocket()
    {
        \socket_close($this->socket);

        $server_side_sock = $this->server_side_sock;
        \unlink($server_side_sock);
    }
}
