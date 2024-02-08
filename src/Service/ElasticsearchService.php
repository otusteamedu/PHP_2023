<?php
declare(strict_types=1);

namespace WorkingCode\Hw11\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use JsonException;

class ElasticsearchService
{
    public function __construct(private readonly Client $ESClient)
    {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndex(string $name, array $params = null): bool
    {
        $paramsAll = ['index' => $name];

        if ($params) {
            $paramsAll['body'] = $params;
        }

        return $this->ESClient->indices()->create($paramsAll)->asBool();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws JsonException
     */
    public function importFromFile(string $filePath, string $indexName): bool
    {
        $rows = explode(PHP_EOL, file_get_contents($filePath));
        $bulk = [];

        foreach ($rows as $row) {
            $row = trim($row);

            if ($row) {
                $bulk[] = json_decode($row, true, flags: JSON_THROW_ON_ERROR);
            }
        }

        $params = [
            'index' => $indexName,
            'body'  => $bulk,
        ];

        return $this->ESClient->bulk($params)->asBool();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(array $params, string $indexName): array
    {
        $paramsAll = [
            'index' => $indexName,
            'body'  => [
                'from'  => 0,
                'size'  => 50,
                'query' => [
                    'bool' => [],
                ],
            ],
        ];

        if (
            array_key_exists('search', $params)
            && $params['search']
        ) {
            $paramsAll['body']['query']['bool'] = [
                'must' => [
                    'match' => [
                        'title' => [
                            'query'     => $params['search'],
                            'fuzziness' => 'auto',
                        ],
                    ],
                ],
            ];
        }

        if (
            array_key_exists('price_max', $params)
            && $params['price_max']
        ) {
            $paramsAll['body']['query']['bool']['filter'][] =
                ['range' => ['price' => ['lt' => (float)$params['price_max']]]];
        }

        if (
            array_key_exists('category', $params)
            && $params['category']
        ) {
            $paramsAll['body']['query']['bool']['filter'][] = ['term' => ['category' => $params['category']]];
        }

        if (
            array_key_exists('stock_min', $params)
            && $params['stock_min']
        ) {
            $paramsAll['body']['query']['bool']['filter'][] =
                ['range' => ['stock.stock' => ['gt' => (float)$params['stock_min']]]];
        }

        return $this->ESClient->search($paramsAll)->asArray();
    }
}
