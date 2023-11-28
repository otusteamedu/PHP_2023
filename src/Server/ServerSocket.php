<?php

namespace Server;

use RuntimeException;

class ServerSocket
{
    private $socketPath;
    
    public function __construct($socketPath)
    {
        $this->socketPath = $socketPath;
    }
    
    public function create(): void
    {
        if (file_exists($this->socketPath)) {
            unlink($this->socketPath);
        }
        
        $this->socket = stream_socket_server('unix://' . $this->socketPath, $errno, $errstr, STREAM_SERVER_BIND|STREAM_SERVER_LISTEN);
        
        if (!$this->socket) {
            throw new RuntimeException("Не удалось создать серверный сокет: $errno - $errstr");
        }
    }
    
    public function accept()
    {
        return stream_socket_accept($this->socket, -1);
    }
    
    public function receive($clientSocket): string
    {
        return trim(fgets($clientSocket));
    }
    
    public function send($clientSocket, $message): void
    {
        fwrite($clientSocket, "Received " . strlen($message) . " bytes\n");
    }
}
