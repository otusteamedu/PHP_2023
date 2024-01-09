<?php

declare(strict_types=1);

namespace App\Service;

use App\Config;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RuntimeException;

class ElasticSearchService
{
    private Client $client;

    private string $index;

    public function __construct(Config $config)
    {
        $this->index = $config->getIndex();

        try {
            $this->client = ClientBuilder::create()
                ->setHosts([$config->getHost()])
                ->setBasicAuthentication($config->getUser(), $config->getPassword())
                ->setSSLVerification(false)
                ->build();
        } catch (AuthenticationException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function search(array $searchParameters)
    {
        $searchBuilder = new ElasticQueryBuilder();

        try {
            return $this->client->search($searchBuilder->buildSearchQuery($this->index, ...$searchParameters))['hits'];
        } catch (ClientResponseException|ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
