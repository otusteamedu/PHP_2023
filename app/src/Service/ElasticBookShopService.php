<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\BookSearchDto;
use App\Exception\ElasticRequestException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Exception;
use Http\Promise\Promise;
use Monolog\Level;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class ElasticBookShopService implements BookShopServiceInterface
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
        #[Autowire(env: 'ELASTIC_CERT')]
        string $caCertPath,
        #[Autowire(env: 'ELASTIC_INDEX')]
        private readonly string $elasticIndex,
        private readonly LoggerInterface $logger,
        private readonly ElasticSearchRequestFactory $elastucRequestFactory,
    ) {
        $this->client = ClientBuilder::create()
            ->setHosts(["https://$elasticHost:$elasticPort"])
            ->setBasicAuthentication($elasticUser, $elasticPassword)
            ->setCABundle($caCertPath)
            ->build();
    }

    /**
     * @throws ElasticRequestException
     */
    public function search(BookSearchDto $searchDto): SearchResult
    {
        $response = $this->request([
            'body' => $this->elastucRequestFactory->createBody($searchDto),
            'setting' => $this->elastucRequestFactory->createSettings($searchDto),
            'size' => $searchDto->size,
            'from' => $searchDto->getFrom(),
        ]);

        $books = [];

        foreach ($response['hits']['hits'] as $book) {
            $stock = [];
            foreach ($book['_source']['stock'] as $shopStock) {
                $stock[$shopStock['shop']] = $shopStock['stock'];
            }
            $books[] = new Book(
                $book['_source']['title'],
                $book['_source']['sku'],
                $book['_source']['category'],
                $book['_source']['price'],
                $stock
            );
        }

        return new SearchResult($books, $response['hits']['total']['value']);
    }

    /**
     * @return string[]
     * @throws ElasticRequestException
     */
    public function getAvailableCategories(): array
    {
        $response = $this->request(
            [
                'body' => [
                    'aggs' => [
                        'distinct_categories' => [
                            'terms' => [
                                'field' => 'category',
                            ]
                        ]
                    ]
                ]
            ]
        );

        return array_map(static function (array $value) {
            return $value['key'];
        }, $response['aggregations']['distinct_categories']['buckets']);
    }

    /**
     * @return string[]
     * @throws ElasticRequestException
     */
    public function getAvailableShops(): array
    {
        $response = $this->request([
            'body' => [
                'aggs' => [
                    'nested_stock' => [
                        'nested' => [
                            'path' => 'stock'

                        ],
                        'aggs' => [
                            'distinct_shops' => [
                                'terms' => [
                                    'field' => 'stock.shop',
                                ]
                            ]
                        ],

                    ]
                ]
            ]
        ]);

        return array_map(static function (array $value) {
            return $value['key'];
        }, $response['aggregations']['nested_stock']['distinct_shops']['buckets']);
    }

    /**
     * @throws ElasticRequestException
     */
    private function request(
        array $request,
    ): Elasticsearch|Promise {
        try {
            $request['index'] = $this->elasticIndex;
            return $this->client->search($request);
        } catch (ClientResponseException $e) {
            $this->logger->log(Level::Error, $e->getMessage(), [
                'request' => $request,
                'trace' => $e->getTrace()
            ]);
            throw ElasticRequestException::clientError($e->getMessage());
        } catch (ServerResponseException|Exception $e) {
            $this->logger->log(Level::Error, $e->getMessage(), [
                'request' => $request,
                'trace' => $e->getTrace()
            ]);
            throw ElasticRequestException::serverError();
        }
    }
}