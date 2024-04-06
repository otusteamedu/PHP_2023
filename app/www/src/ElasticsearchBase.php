<?php

namespace App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchBase
{
    protected  Client $client;
    protected  const INDEX_NAME = 'otus-shop';
    protected  const FILE_NAME = __DIR__ . '/../books.json';

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://elasticsearch:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication('elastic', 'elastic123')
            ->build();
    }

    protected function getIndexName()
    {
        return self::INDEX_NAME;
    }

    protected function getFileName()
    {
        return self::FILE_NAME;
    }

}
