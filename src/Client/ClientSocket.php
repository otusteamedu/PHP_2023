<?php

namespace Client;

use RuntimeException;

class ClientSocket
{
    private $socketPath;
    
    public function __construct($socketPath)
    {
        $this->socketPath = $socketPath;
    }
    
    public function connect()
    {
        $socket = stream_socket_client('unix://' . $this->socketPath, $errno, $errstr);
        
        if (!$socket) {
            throw new RuntimeException("Не удалось установить соединение с сервером: $errno - $errstr");
        }
        
        return $socket;
    }
    
    public function send($socket, $message): void
    {
        fwrite($socket, $message . PHP_EOL);
    }
    
    public function receive($socket)
    {
        return fgets($socket);
    }
}
