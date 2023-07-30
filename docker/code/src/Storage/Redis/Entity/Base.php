<?php

namespace IilyukDmitryi\App\Storage\Redis\Entity;

use Predis\Client;

abstract class Base
{
    protected Client $client;
    
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
