<?php

namespace Gkarman\Otuselastic\Elastic;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ElasticClient
{
    /**
     * @throws AuthenticationException
     */
    public function init(): \Elastic\Elasticsearch\Client
    {
        $client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication('otus', 'otus')
            ->build();

        return $client;
    }
}
