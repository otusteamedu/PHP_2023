<?php

declare(strict_types=1);

namespace App\Service;

use App\Config;
use App\Console\Input;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RuntimeException;

class ElasticSearchService
{
    private Client $client;

    private array $params;

    public function __construct(Config $config)
    {
        $this->params = [
            'index' => $config->getIndex(),
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [],
                        'filter' => []
                    ]
                ]
            ]
        ];

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

    public function search(Input $input)
    {
        if ($input->getQuery()) {
            $this->params['body']['query']['bool']['must'] =
                [
                    'match' => [
                        'title' => [
                            'query' => $input->getQuery(),
                            'fuzziness' => 'auto'

                        ]
                    ]
                ];
        }

        if ($input->getCategory()) {
            $this->params['body']['query']['bool']['filter'][] =
                [
                    'match' => [
                        'category' => $input->getCategory()
                    ]
                ];
        }

        if ($input->getPrice()) {
            $this->params['body']['query']['bool']['filter'][] =
                [
                    'range' => [
                        'price' => [
                            'lte' => $input->getPrice()
                        ]
                    ]
                ];
        }

        try {
            return $this->client->search($this->params)['hits'];
        } catch (ClientResponseException|ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

}
