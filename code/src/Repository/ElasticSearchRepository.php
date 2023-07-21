<?php

declare(strict_types=1);

namespace Timerkhanov\Elastic\Repository;

use Timerkhanov\Elastic\Exception\EmptySearchQueryException;
use Timerkhanov\Elastic\Exception\FileNotFoundException;
use Timerkhanov\Elastic\Exception\RepositoryException;
use Timerkhanov\Elastic\QueryBuilder\SearchQueryBuilder;
use Timerkhanov\Elastic\Repository\Interface\RepositoryInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Timerkhanov\Elastic\App;

class ElasticSearchRepository implements RepositoryInterface
{
    private readonly Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([App::config('elastic_host')])
            ->build();
    }

    public function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException("File by path \"{$path}\" not found");
        }

        $books = file_get_contents($path);

        try {
            $this->client->bulk(['body' => $books]);
        } catch (ClientResponseException | ServerResponseException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    public function search(SearchQueryBuilder $queryBuilder): array
    {
        $query = $queryBuilder->getParams();

        if (empty($query)) {
            throw new EmptySearchQueryException('Search params are not set');
        }

        $params = [
            'index' => App::config('elastic_index'),
            'body' => [
                'query' => $query
            ]
        ];

        try {
            $response = $this->client->search($params);

            return $response->asArray()['hits']['hits'] ?? [];
        } catch (ClientResponseException | ServerResponseException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }
}
