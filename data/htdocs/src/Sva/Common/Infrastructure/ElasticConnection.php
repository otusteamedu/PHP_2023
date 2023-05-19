<?php

namespace Sva\Common\Infrastructure;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Sva\Common\App\Env;

class ElasticConnection
{
    use \Sva\Singleton;

    private \Elastic\Elasticsearch\Client $connection;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $client = ClientBuilder::create()
            ->setHosts([Env::getInstance()->get('ELASTIC_HOST') . ':' . Env::getInstance()->get('ELASTIC_PORT')])
            ->setBasicAuthentication(Env::getInstance()->get('ELASTIC_USER'), Env::getInstance()->get('ELASTIC_PASSWORD'))
            ->build();

        $this->connection = $client;
    }

    /**
     * @return \Elastic\Elasticsearch\Client
     */
    public function getConnection(): \Elastic\Elasticsearch\Client
    {
        return $this->connection;
    }
}
