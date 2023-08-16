<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Redis\Entity;

use Predis\Client;

abstract class Base
{
    protected Client $client;
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
