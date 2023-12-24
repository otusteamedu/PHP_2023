<?php

namespace HW11\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RuntimeException;

abstract class AbstractElasticSearch
{
    protected array $searchParams;
    protected Client $client;
    public const INDEX_NAME = 'otus-shop';
    public function __construct(
        private string $host,
        private string $user,
        private string $password,
    )
    {
        $this->connect();
        $this->initSearch();
    }
    protected function connect(): void
    {
        $client = ClientBuilder::create()
            ->setHosts([$this->host])
            ->setSSLVerification(false)
            ->setBasicAuthentication($this->user, $this->password)
            ->build();
        $this->client = $client;
    }
    protected function initSearch(): void
    {
        $this->searchParams = [
            'index' => self::INDEX_NAME,
            'from'  => 0,
            'size'  => 10,
            'body'  => [
                'query' => [
                    'bool' => [
                        'must'   => [],
                        'filter' => [
                            [
                                'nested' => [
                                    'path'  => 'stock',
                                    'query' => [
                                        'bool' => [
                                            'must' => [],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
