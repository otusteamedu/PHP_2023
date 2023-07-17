<?php

declare(strict_types=1);

namespace Root\App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use Psr\Log\LoggerInterface;
use stdClass;

class Elastic implements StorageInterface
{
    private ?string $host;
    private ?string $index;

    private ?Client $client;
    private ?LoggerInterface $logger;

    private ?array $searchParam = null;

    /**
     * @throws AppException
     */
    public function __construct(string $host, string $index, ?LoggerInterface $logger = null)
    {
        $this->host = $host;
        $this->index = $index;
        $this->logger = $logger;

        try {
            $this->client = ClientBuilder::create()
                ->setHosts([$this->host])
                ->build();
        } catch (Exception $e) {
            throw new AppException('Error connect. (' . $e->getMessage() . ')');
        }
    }

    /**
     * @throws AppException
     */
    public function createIndex(string $mapping): void
    {
        $params = [
            'index' => $this->index,
            'body' => $mapping
        ];
        try {
            $this->client->indices()->create($params);
        } catch (Exception $e) {
            throw new AppException('Error create index (' . $e->getMessage() . ')');
        }
    }

    /**
     * @throws AppException
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function bulk(string $data): void
    {
        $params = ['body' => $data];
        $response = $this->client->bulk($params);
        $response = $response->asObject();

        if (!isset($response->errors) || !isset($response->items) || !is_array($response->items)) {
            throw new AppException('Bulk - unknown response');
        }

        $cnt = count($response->items);
        $this->logger?->info("Обработано {$cnt} записей. " . ($response->errors ? 'Имеются ошибки' : 'Успешно'));
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function exists(): bool
    {
        return $this->client->indices()->exists(['index' => $this->index])->getStatusCode() === 200;
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws AppException
     */
    public function find(array $params): array
    {
        $this->searchParam = $this->createBaseRequest();
        if (!empty($params['title'])) {
            $this->requestSetTitle($params['title']);
        }
        if (!empty($params['sku'])) {
            $this->requestSetSku($params['sku']);
        }
        if (!empty($params['category'])) {
            $this->requestSetCategory($params['category']);
        }
        if (!empty($params['price'])) {
            $this->requestSetPrice($params['price']);
        }
        if (!empty($params['quantity'])) {
            $this->requestSetQuantity($params['quantity']);
        }
        if (!empty($params['shop'])) {
            $this->requestSetShop($params['shop']);
        }
        $response = $this->client->search($this->searchParam)->asObject();

        return $this->parseResponse($response);
    }

    private function requestSetTitle(array $param): void
    {
        $should = [];
        foreach ($param as $value) {
            $should[] = ['match' => ['title' => ['query' => $value, 'fuzziness' => 2, 'operator' => 'and']]];
        }
        if (!empty($should)) {
            $this->searchParam['body']['query']['bool']['must'] = [
                'bool' => ['should' => $should]
            ];
        }
    }
    private function requestSetSku(array $param): void
    {
        $should = [];
        foreach ($param as $value) {
            $should[] = ['term' => ['sku' => ['value' => $value]]];
        }
        if (!empty($should)) {
            $this->searchParam['body']['query']['bool']['filter'][] = [
                'bool' => ['should' => $should]
            ];
        }
    }
    private function requestSetCategory(array $param): void
    {
        $should = [];
        foreach ($param as $value) {
            $should[] = ['term' => ['category' => ['value' => $value]]];
        }
        if (!empty($should)) {
            $this->searchParam['body']['query']['bool']['filter'][] = [
                'bool' => ['should' => $should]
            ];
        }
    }
    private function requestSetPrice(array $param): void
    {
        $range = [];
        foreach ($param as $value) {
            $range = array_merge($range, $this->parseNumberCondition($value));
        }
        $this->searchParam['body']['query']['bool']['filter'][] = [
            'range' => ['price' => $range]
        ];
    }
    private function requestSetQuantity(array $param): void
    {
        $range = [];
        foreach ($param as $value) {
            $range = array_merge($range, $this->parseNumberCondition($value));
        }

        $index = $this->findNested($this->searchParam['body']['query']['bool']['filter']);

        $this->searchParam['body']['query']['bool']['filter'][$index]['nested']['query']['bool']['must'][] = [
            'range' => ['stock.stock' => $range]
        ];
    }
    private function requestSetShop(array $param): void
    {
        $must = [];
        foreach ($param as $value) {
            $must[] = ['term' => ['stock.shop' => ['value' => $value]]];
        }
        $index = $this->findNested($this->searchParam['body']['query']['bool']['filter']);
        $this->searchParam['body']['query']['bool']['filter'][$index]['nested']['query']['bool']['must'] = array_merge(
            $this->searchParam['body']['query']['bool']['filter'][$index]['nested']['query']['bool']['must'],
            $must
        );
    }

    private function findNested(array $haystack): int
    {
        $index = 0;
        for ($i = 0; $index < count($haystack); $i++) {
            if (isset($haystack[$i]['nested'])) {
                $index = $i;
                break;
            }
        }
        return $index;
    }

    private function createBaseRequest(): array
    {
        return [
            'index' => $this->index,
            'size' => 100,
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
    }

    /**
     * @throws AppException
     */
    private function parseResponse($response): array
    {
        $ret = [];

        if (
            !property_exists($response, 'hits')
            || !($response->hits instanceof stdClass)
            || !property_exists($response->hits, 'hits')
            || !is_array($response->hits->hits)
        ) {
            throw new AppException('Search - unknown response');
        }
        if (!empty($response->hits->hits)) {
            foreach ($response->hits->hits as $item) {
                if (
                    !property_exists($item, '_source')
                    || !($item->_source instanceof stdClass)
                    || !property_exists($item, '_score')
                ) {
                    throw new AppException('Search - unknown response element');
                }
                $row = new TableRowDto();
                $row->score = $item->_score;
                $row->sku = $item->_source->sku;
                $row->title = $item->_source->title;
                $row->category = $item->_source->category;
                $row->price = $item->_source->price;
                $row->stock = [];
                if (is_array($item->_source->stock) && !empty($item->_source->stock)) {
                    foreach ($item->_source->stock as $item) {
                        $st = new StockDto();
                        $st->shop = $item->shop;
                        $st->stock = $item->stock;
                        $row->stock[] = $st;
                    }
                }
                $ret[] = $row;
            }
        }

        return  $ret;
    }

    private function parseNumberCondition($string): array
    {
        $num = intval(str_replace(['>', '<', '='], '', $string));
        switch ($string) {
            case str_contains($string, '>'):
                return ['gt' => $num];
            case str_contains($string, '>='):
                return ['gte' => $num];
            case str_contains($string, '<'):
                return ['lt' => $num];
            case str_contains($string, '<='):
                return ['lte' => $num];
            case str_contains($string, '='):
            default:
                return ['gte' => $num, 'lte' => $num];
        }
    }
}
