<?php

namespace App\Infrastructure\Repository;

use App\Application\action\bulk\BulkCommand;
use App\Domain\Entity\Book;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;


class ElasticSearchRepository implements RepositoryInterface
{
    public Client $client;

    private string $index;

    private int $size;
    private array $params;
    private string $bulkFileName;
    private string $url;

    public function __construct(
        string $url,
        string $user,
        string $password,
        string $index,
        string $size,
        array $params,
        string $bulkFileName
    )
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$url])
            ->setBasicAuthentication($user, $password)
            ->build();
        $this->index = $index;
        $this->size = $size;
        $this->params = $params;
        $this->bulkFileName = $bulkFileName;
        $this->url = $url;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function searchByTitle(string $title): array
    {
        return $this->search(self::queryByTitle($title));
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function searchByTitleCategoryPrice(
        string $title,
        string $category,
        string $price
    ): array
    {
        return $this->search(
            self::queryByTitleCategoryPrice(
                $title,
                $category,
                $price
        ));
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    private function search($query): array
    {
        $params = [
            'index' => $this->index,
            'size' => $this->getSize(),
            'body' => [
                'sort' => [
                    [ 'sku' => ['order' => 'asc']]
                ],
                'query' => $query
            ],
        ];

        $results = $this->client->search($params)->asArray();

        if (empty($results['hits']['hits'])) {
            return [];
        }

        $results = array_map(
            static fn ($item) => $item['_source'],
            $results['hits']['hits']
        );

        return $results;
    }

    private static function queryByTitle(string $title): array
    {
        return [
            'match' => [
                'title' => [
                    'query' => $title,
                    'fuzziness' => 'auto'
                ]
            ]
        ];
    }

    private static function queryByTitleCategoryPrice(
        string $title,
        string $category,
        string $price
    ): array
    {
        $operations = [
            '>=' => 'gte',
            '<=' => 'lte'
        ];
        $operation = $operations[substr($price, 0, 2)];

        return [
            'bool' => [
                'must' => [self::queryByTitle($title)],
                'filter' => [
                    ['term' => ['category' => $category]],
                    ['range' => [
                            'price' => [$operation => substr($price, 2)]
                        ]
                    ]

                ]
            ]
        ];
    }

    private function getSize(): int
    {
        return $this->size;
    }

    public function isDataValid(): bool
    {
        $response = $this->client->indices()->exists([
            'index' => $this->index
        ]);

        return (200 === $response->getStatusCode());
    }

    public function init(): void
    {
        $this->createIndices();
        $this->loadBulkFile();
        sleep(1);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    private function createIndices(): void
    {
        $this->client->indices()->create($this->params);
    }

    private function loadBulkFile(): void
    {
        $url = $this->url;
        $bulkFileName = $this->bulkFileName;
        $command = new BulkCommand();
        $command->run($url, $bulkFileName);
    }

    public function clearData(): void
    {
        $this->client->indices()->delete(['index' => $this->index]);
    }
}
