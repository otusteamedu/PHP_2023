<?php

declare(strict_types=1);

namespace Aporivaev\Hw09;

use Error;
use Exception;
use Socket;

class AppSocket
{
    protected string $fileName;
    protected ?Socket $socket = null;
    protected int $socketBacklog = 10;
    protected int $bufferLength = 1000;

    protected string $commandQuit = ':q';

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /** @throws AppException */
    private function unlinkFile(): void {
        if (file_exists($this->fileName)) {
            if (!unlink($this->fileName)) {
                throw new AppException('Error, socket already in use');
            }
        }
    }
    /** @throws AppException */
    private function create(): void {
        try {
            $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        } catch (Error $e) {
            throw new AppException('Error create socket', 0, $e->getMessage());
        }
    }
    /** @throws AppException */
    private function bind(): void
    {
        if (!socket_bind($this->socket, $this->fileName)) {
            throw $this->createException('Error bind socket');
        }
    }
    /** @throws AppException */
    private function listen(): void
    {
        if (!socket_listen($this->socket, $this->socketBacklog)) {
            throw $this->createException('Error listen socket');
        }
        socket_set_nonblock($this->socket);
    }
    /** @throws AppException */
    private function connect(): void
    {
        if (!socket_connect($this->socket, $this->fileName)) {
            throw $this->createException('Error connect socket');
        }
        socket_set_nonblock($this->socket);
    }
    /** @throws AppException */
    protected function write(string $string, ?Socket $dest = null): void {
        if ($dest === null) {
            $dest = $this->socket;
        }
        if (socket_write($dest, $string) === false) {
            throw $this->createException('Error write socket');
        }
    }
    protected function read(?Socket $from = null): bool|string {
        if ($from === null) {
            $from = $this->socket;
        }
        return socket_read($from, $this->bufferLength);
    }
    protected function close(?Socket $socket = null): void {
        if ($socket === null) {
            $socket = $this->socket;
        }
        socket_close($socket);
    }

    /** @throws AppException */
    protected function serverListen(): void {
        try {
            $this->unlinkFile();
            $this->create();
            $this->bind();
            $this->listen();
        } catch (AppException $e) {
            throw new AppException('Error listen socket', 0, $e->__toString());
        }
    }
    /** @throws AppException */
    protected function clientConnect(string $name): void {
        $this->create();
        $this->connect();
        $this->write($name);
    }

    protected function createException($message): AppException
    {
        $code = socket_last_error($this->socket);
        return new AppException($message, $code, socket_strerror($code));
    }

    /** @throws Exception */
    protected function readStdIn(string &$buffer): bool
    {
        $read = [STDIN];
        $write = [];
        $except = [];
        $result = stream_select($read, $write, $except, 0);
        if ($result === false) {
            throw new Exception('stream_select failed');
        }
        if ($result === 0) {
            return false;
        }
        $buffer = trim(stream_get_line(STDIN, $this->bufferLength, "\n"));
        return true;
    }
}
