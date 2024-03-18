<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Infrastructure\Db;

use Elastic\Elasticsearch\Client;
use Yalanskiy\SearchApp\Domain\Entity\Book;
use Yalanskiy\SearchApp\Domain\Entity\BookCollection;
use Yalanskiy\SearchApp\Domain\Repository\DataRepositoryInterface;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

/**
 *
 */
class ElasticDatabaseProvider implements DataRepositoryInterface
{
    private Client $client;
    
    private array $mapping = [
        'mappings' => [
            'properties' => [
                'category' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
                'price' => [
                    'type' => 'long',
                ],
                'sku' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'text',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256,
                                ],
                            ],
                        ],
                        'stock' => [
                            'type' => 'long',
                        ],
                    ],
                ],
                'title' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
            ],
        ],
    ];
    
    private array $searchTemplate = [
        'index' => '',
        'scroll' => '1m',
        'size' => 50,
        'track_total_hits' => true,
        'body' => [
            'query' => [
                'bool' => [
                    'must' => [],
                    'filter' => [
                        [
                            'nested' => [
                                'path' => 'stock',
                                'query' => [
                                    'bool' => [
                                        'must' => []
                                    ]
                                ]
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ];
    
    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
                                     ->setHosts(['https://' . ELASTIC_SERVER . ':9200'])
                                     ->setBasicAuthentication(ELASTIC_USERNAME, ELASTIC_PASSWORD)
                                     ->setSSLVerification(false)
                                     ->build();

        if (!$this->isIndexExists(ELASTIC_INDEX_NAME)) {
            $this->createIndex(ELASTIC_INDEX_NAME);
        }
    }
    
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function find(array $searchParams): BookCollection
    {
        $this->searchTemplate['index'] = ELASTIC_INDEX_NAME;
        
        foreach ($searchParams as $type => $value) {
            switch ($type) {
                case 'title':
                    $this->searchTemplate['body']['query']['bool']['must'] = [
                        'match' => [
                            'title' => [
                                'query' => $value,
                                'fuzziness' => '2',
                                'operator' => 'and',
                            ],
                        ]
                    ];
                    break;
                case 'category':
                    $this->searchTemplate['body']['query']['bool']['filter'][] = [
                        'match' => [
                            'category' => $value,
                        ]
                    ];
                    break;
                case 'price':
                    $value = $this->normalizeOperatrion($value);
                    $this->searchTemplate['body']['query']['bool']['filter'][] = [
                        'range' => [
                            'price' => $value
                        ]
                    ];
                    break;
                case 'stock':
                    $value = $this->normalizeOperatrion($value);
                    $this->searchTemplate['body']['query']['bool']['filter'][0]['nested']['query']['bool']['must'] = [
                        'range' => [
                            'stock.stock' => $value
                        ]
                    ];
                    break;
            }
        }
        
        $searchResult =  $this->client->search($this->searchTemplate);

        $out = new BookCollection();

        if (count($searchResult['hits']['hits']) === 0) {
            return $out;
        }
        
        foreach ($searchResult['hits']['hits'] as $item) {
            $book = new Book(
                $item['_source']['sku'],
                $item['_source']['title'],
                $item['_source']['category'],
                $item['_source']['price'],
                $item['_source']['stock']
            );
            $book->setScore(number_format(floatval($item['_score']), decimals: 2));
            $out->add($book);
        }
        
        while (count($searchResult['hits']['hits']) > 0) {
            $searchResult = $this->client->scroll([
                'body' => [
                    'scroll_id' => $searchResult['_scroll_id'],
                    'scroll' => '1m',
                ],
            ]);

            foreach ($searchResult['hits']['hits'] as $item) {
                $book = new Book(
                    $item['_source']['sku'],
                    $item['_source']['title'],
                    $item['_source']['category'],
                    $item['_source']['price'],
                    $item['_source']['stock']
                );
                $book->setScore(number_format(floatval($item['_score']), decimals: 2));
                $out->add($book);
            }
        }
        
        return $out;
    }
    
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function add(Book $data): void
    {
        $params = [];
        $params[] = ['index' => ['_index' => ELASTIC_INDEX_NAME]];
        $params[] = ['create' => ['_index' => ELASTIC_INDEX_NAME, '_id' => $data->getId()]];
        $params[] = ['index' => ['_index' => ELASTIC_INDEX_NAME]];
        $params[] = [
            'title' => $data->getTitle(),
            'sku' => $data->getSku(),
            'category' => $data->getCategory(),
            'price' => $data->getPrice(),
            'stock' => $data->getStock()
        ];

        $this->client->bulk(['body' => $params]);
    }
    
    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function addBulk(BookCollection $data): void
    {
        $params = [];
        foreach ($data as $item) {
            $params[] = ['index' => ['_index' => ELASTIC_INDEX_NAME]];
            $params[] = ['create' => ['_index' => ELASTIC_INDEX_NAME, '_id' => $item->getId()]];
            $params[] = ['index' => ['_index' => ELASTIC_INDEX_NAME]];
            $params[] = [
                'title' => $item->getTitle(),
                'sku' => $item->getSku(),
                'category' => $item->getCategory(),
                'price' => $item->getPrice(),
                'stock' => $item->getStock()
            ];
        }
        
        $this->client->bulk(['body' => $params]);
    }
    
    /**
     * Normalize operators for Elastic
     *
     * @param string $value
     *
     * @return int[]
     */
    private function normalizeOperatrion(string $value): array
    {
        $digit = (int)preg_replace('/[><=]/', '', $value);
        
        $operators = [
            '<=' => 'lte',
            '>=' => 'gte',
            '<'  => 'lt',
            '>'  => 'gt',
        ];
        
        foreach ($operators as $operatorString => $operator) {
            if (str_contains($value, $operatorString)) {
                return [$operator => $digit];
            }
        }
        
        return [
            'lte' => $digit,
            'gte' => $digit,
        ];
    }
    
    /**
     * Check if index exists
     *
     * @param string $indexName Index Name
     * @return bool
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    private function isIndexExists(string $indexName): bool
    {
        return $this->client->indices()->exists(['index' => $indexName])->getStatusCode() === 200;
    }
    
    /**
     * Create index
     *
     * @param string $indexName Index name
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    private function createIndex(string $indexName): void
    {
        if ($this->isIndexExists($indexName)) {
            return;
        }
        
        $params = [
            'index' => $indexName,
            'body' => $this->mapping,
        ];
        $this->client->indices()->create($params);
    }
}