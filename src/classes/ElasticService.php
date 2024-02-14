<?php

declare(strict_types=1);

namespace Klobkovsky\App;

use Klobkovsky\App\Exceptions\DocumentCreateException;
use Klobkovsky\App\Exceptions\DocumentSearchException;
use Klobkovsky\App\Exceptions\IndexCreateException;
use Klobkovsky\App\Exceptions\IndexDeleteException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;
use Klobkovsky\App\Model\Interface\ElasticEntityInterface;

class ElasticService
{
    private const FILE_DIR =  __DIR__ . '/../';

    private Client $client;
    private ElasticEntityInterface $elasticEntity;

    public function __construct(ElasticEntityInterface $elasticEntity)
    {
        $this->elasticEntity = $elasticEntity;
        $this->client = ClientBuilder::create()
            ->setHosts(['https://elasticsearch:' . $_ENV['ELASTIC_PORT']])
            ->setSSLVerification(false)
            ->setBasicAuthentication($_ENV['ELASTIC_USER'], $_ENV['ELASTIC_PASSWORD'])
            ->build();
    }

    public function getIndexName(): string
    {
        return $this->elasticEntity->getIndexName();
    }

    public function createDocument(): void
    {
        $handle = fopen(self::FILE_DIR . $this->elasticEntity->getDataFile(), 'r');

        while (!feof($handle)) {
            $line = fgets($handle);

            if (!empty($line)) {
                $document = json_decode($line, true);

                if (isset($document['create'])) {
                    $index = $document['create']['_index'];
                    $id = $document['create']['_id'];
                    $indexAndId = [
                        'index' => $index,
                        'id' => $id
                    ];
                }

                if (isset($document['title'])) {
                    $body = ['body' => $document];
                    $param = array_merge($indexAndId, $body);

                    try {
                        $this->client->index($param);
                    } catch (ClientResponseException | MissingParameterException | ServerResponseException $e) {
                        throw new DocumentCreateException($e->getMessage());
                    }
                }
            }
        }

        fclose($handle);
    }

    public function createIndex(): void
    {
        try {
            $this->client->indices()->create($this->elasticEntity->getIndexParam());
        } catch (ClientResponseException | MissingParameterException | ServerResponseException $e) {
            throw new IndexCreateException($e->getMessage());
        }
    }

    public function deleteIndex(): void
    {
        try {
            $this->client->indices()->delete(['index' => $this->elasticEntity->getIndexName()]);
        } catch (ClientResponseException | MissingParameterException | ServerResponseException $e) {
            throw new IndexDeleteException($e->getMessage());
        }
    }

    public function searchDocument(string $title = '', string $category = '', int $price = 0): Elasticsearch|Promise
    {
        try {
            $response = $this->client->search($this->elasticEntity->getSearchParam([
                'title' => $title,
                'category' => $category,
                'price' => $price
            ]));
        } catch (ClientResponseException | ServerResponseException | DocumentSearchException $e) {
            throw new DocumentSearchException($e->getMessage());
        }

        return $response;
    }
}
