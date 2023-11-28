<?php

use Client\Client;
use Server\Server;

class Application
{
    private $server;
    private $client;
    
    public function __construct($serverSocketPath, $clientSocketPath)
    {
        $this->server = new Server($serverSocketPath);
        $this->client = new Client($clientSocketPath);
    }
    
    public function run()
    {
        try {
            $command = $_SERVER['argv'][1] ?? '';
            
            switch ($command) {
                case 'server':
                    $this->server->run();
                    break;
                case 'client':
                    $this->client->run();
                    break;
                default:
                    echo "Неизвестная команда\n";
                    break;
            }
        } catch (\Exception $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
    }
}
