<?php

declare(strict_types=1);

namespace VLebedev\BookShop\Service\ElasticService;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use VLebedev\BookShop\Config;
use VLebedev\BookShop\Service\ElasticService\Exception\AuthenticationException;
use VLebedev\BookShop\Service\ElasticService\Exception\UploadingFileDataException;
use VLebedev\BookShop\Service\ServiceInterface;

class ElasticService implements ServiceInterface
{
    private Client $client;
    private ElasticQueryBuilder $queryBuilder;

    /**
     * @throws AuthenticationException
     */
    public function __construct(Config $config)
    {
        try {
            $this->client = ClientBuilder::create()
                ->setHosts([$config->getElasticHost()])
                ->setBasicAuthentication($config->getElasticUser(), $config->getElasticPassword())
                ->setCABundle(dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'http_ca.crt')
                ->build();
            $this->queryBuilder = new ElasticQueryBuilder();
        } catch (Exception $exception) {
            throw new AuthenticationException($exception->getMessage());
        }
    }

    /**
     * @throws ClientResponseException
     * @throws UploadingFileDataException
     * @throws ServerResponseException
     */
    public function uploadFileData(string $path): array
    {
        if (!$handle = fopen($path, 'r')) {
            throw new UploadingFileDataException('Unable to find data file with path ' . $path);
        }

        $i = 1;
        $params['body'] = [];
        while (($line = fgets($handle)) !== false) {
            $jsonLine = json_decode($line, true);
            $params['body'][] = $jsonLine;
            if ($i % 1000 === 0) {
                $responses = $this->client->bulk($params);
                unset($responses);
                $params['body'] = [];
            }
            $i++;
        }

        if (!empty($params['body'])) {
            $this->client->bulk($params);
        }

        return ['success' => 'Data loaded successfully'];
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function createIndex(array $params): void
    {
        $this->client->index($this->queryBuilder->buildCreateIndex(...$params));
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(array $params): array
    {
        return $this->client->search($this->queryBuilder->buildSearchQuery(...$params))['hits']['hits'];
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function getById(array $params): array
    {
        return $this->client->get($this->queryBuilder->buildGetQuery(...$params))['_source'];
    }
}
