<?php
declare(strict_types=1);

namespace Ekovalev\Otus\App;

abstract class Socket
{
    private string $path;
    private int $maxLen;
    private $socket;
    private string $configPath = __DIR__ . '/../conf/sock.ini';
    public function __construct()
    {
        $config = parse_ini_file($this->configPath, true);
        $this->path = $config['socket']['path'];
        $this->maxLen = (int)$config['socket']['max_len'];
    }
    public function create($isServer = true): void
    {
        if ($isServer && file_exists($this->path)) unlink($this->path);
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }
    public function bind(): void
    {
        socket_bind($this->socket, $this->path);
    }
    public function listen(): void
    {
        socket_listen($this->socket);
    }
    public function connect(): void
    {
        socket_connect($this->socket, $this->path);
    }
    public function accept()
    {
        return socket_accept($this->socket);
    }
    public function receive($socket): string
    {
        socket_recv($socket, $message, $this->maxLen, 0);
        return $message ?? '';
    }
    public function write(string $message, $socket = null): void
    {
        socket_write($socket ?? $this->socket, $message, strlen($message));
    }
    public function close(): void
    {
        socket_close($this->socket);
    }
    public function showMessage(string $message)
    {
        return $message . PHP_EOL;
    }
    abstract protected function initSocket();
}