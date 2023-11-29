<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchCommonService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200'])
            ->setBasicAuthentication('elastic', '123456')
            ->setCABundle('http_ca.crt')
            ->build();
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
