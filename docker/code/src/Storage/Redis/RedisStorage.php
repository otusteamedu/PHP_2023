<?php

namespace IilyukDmitryi\App\Storage\Redis;

use IilyukDmitryi\App\Config\ConfigApp;
use IilyukDmitryi\App\Storage\Base\EventStorageInterface;
use IilyukDmitryi\App\Storage\Base\StorageInterface;
use IilyukDmitryi\App\Storage\Redis\Entity\EventStorage;
use Predis\Client;

class RedisStorage implements StorageInterface
{
    private Client $client;
    
    public function __construct()
    {
        $settings = ConfigApp::get();
        $host = $settings->getRadisHost();
        $port = $settings->getRadisPort();
        
        $client = new Client(['host' => $host, 'port' => $port]);
        $this->client = $client;
    }
    
    /**
     * @return EventStorageInterface
     */
    public function getEventStorage(): EventStorageInterface
    {
        return new EventStorage($this->client);
    }
}
