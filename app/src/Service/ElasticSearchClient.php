<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ElasticRequestException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Exception;
use Monolog\Level;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ElasticSearchClient
{
    private Client $client;

    public function __construct(
        #[Autowire(env: 'ELASTIC_HOST')]
        string $elasticHost,
        #[Autowire(env: 'ELASTIC_PORT')]
        string $elasticPort,
        #[Autowire(env: 'ELASTIC_USER')]
        string $elasticUser,
        #[Autowire(env: 'ELASTIC_PASSWORD')]
        string $elasticPassword,
        #[Autowire(env: 'ELASTIC_INDEX')]
        private readonly string $elasticIndex,
        private readonly LoggerInterface $logger,
    ) {
        $this->client = ClientBuilder::create()
            ->setHosts(["http://$elasticHost:$elasticPort"])
            ->setBasicAuthentication($elasticUser, $elasticPassword)
            ->build();
    }

    public function indexDocument(array $body): void
    {
        $this->client->index([
            'index' => $this->elasticIndex,
            'body' => $body
        ]);
    }

    public function deleteByQuery(array $query): void
    {
        $this->client->deleteByQuery([
            'index' => $this->elasticIndex,
            'body' => [
                'query' => $query
            ],
        ]);
    }

    /**
     * @throws ElasticRequestException
     */
    public function searchByQuery(array $query, array $setting = []): Elasticsearch
    {
        try {
            return $this->client->search([
                    'index' => $this->elasticIndex,
                    'body' => [
                        'query' => $query
                    ],
                    'setting' => $setting,
                ]
            );
        } catch (ClientResponseException $e) {
            $this->logger->log(Level::Error, $e->getMessage(), [
                'query' => $query,
                'trace' => $e->getTrace()
            ]);
            throw ElasticRequestException::clientError($e->getMessage());
        } catch (ServerResponseException|Exception $e) {
            $this->logger->log(Level::Error, $e->getMessage(), [
                'query' => $query,
                'trace' => $e->getTrace()
            ]);
            throw ElasticRequestException::serverError();
        }
    }
}