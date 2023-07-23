<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11\Elastic;

use Elastic\Elasticsearch\ClientBuilder;

class Client implements ClientInterface
{
    public static function connect(string $host): \Elastic\Elasticsearch\Client
    {
        return ClientBuilder::create()
            ->setHosts([$host])
            ->build();
    }
}
