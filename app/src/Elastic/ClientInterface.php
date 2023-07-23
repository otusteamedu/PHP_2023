<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11\Elastic;

interface ClientInterface
{
    public static function connect(string $host): \Elastic\Elasticsearch\Client;
}
