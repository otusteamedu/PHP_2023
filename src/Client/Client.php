<?php

namespace Client;

use Exception;

class Client
{
    private $socket;
    
    public function __construct($socketPath)
    {
        $this->socket = new ClientSocket($socketPath);
    }
    
    public function run()
    {
        try {
            $this->socket->connect();
            
            while (true) {
                fwrite(STDOUT, "Введите сообщение: ");
                $input = trim(fgets(STDIN));
                
                $this->socket->send($this->socket, $input);
                $response = $this->socket->receive($this->socket);
                
                echo "Ответ от сервера: $response\n";
            }
        } catch (Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
