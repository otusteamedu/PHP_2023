<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Infrastructure\Repository;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Transport\Exception\NoNodeAvailableException;
use Imitronov\Hw11\Application\Repository\ProductRepository;
use Imitronov\Hw11\Domain\Exception\ExternalServerException;
use Imitronov\Hw11\Infrastructure\Component\Transformer\ProductTransformer;

final class EsProductRepository implements ProductRepository
{
    public function __construct(
        private readonly Client $client,
        private readonly ProductTransformer $productTransformer,
        private readonly string $indexName,
    ) {
    }

    public function allByTitleAndCategoryAndPriceInStock(
        string $name,
        ?string $category,
        ?string $price,
    ): array {
        $params = [
            'index' => $this->indexName,
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'match' => [
                                'title' => [
                                    'query' => $name,
                                    'fuzziness' => 'auto',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $filters = [];

        if (null !== $price) {
            $filters[] = [
                'range' => [
                    'price' => [
                        'lte' => $price,
                    ],
                ],
            ];
            $filters[] = [
                'nested' => [
                    'path' => 'stock',
                    'query' => [
                        'bool' => [
                            'must' => []
                        ]
                    ]
                ],
            ];
        }

        if (null !== $category) {
            $filters[] = [
                'match' => [
                    'category' => $category,
                ],
            ];
        }

        if (count($filters) > 0) {
            $params['body']['query']['bool']['filter'] = $filters;
        }

        try {
            $response = $this->client->search($params);
            $result = $response->asArray();
        } catch (NoNodeAvailableException | ClientResponseException | ServerResponseException $exception) {
            throw new ExternalServerException('Не удалось получить товары из репозитория.', 0, $exception);
        }

        return array_map(
            fn ($product) => $this->productTransformer->transform($product['_source']),
            $result['hits']['hits'],
        );
    }
}
