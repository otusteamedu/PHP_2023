<?php

namespace Dimal\Hw11\Infrastructure;

use Dimal\Hw11\Application\StockSearchInterface;
use Dimal\Hw11\Domain\Entity\Book;
use Dimal\Hw11\Domain\Entity\BookAvailable;
use Dimal\Hw11\Domain\Entity\SearchQuery;
use Dimal\Hw11\Domain\ValueObject\Category;
use Dimal\Hw11\Domain\ValueObject\Id;
use Dimal\Hw11\Domain\ValueObject\Price;
use Dimal\Hw11\Domain\ValueObject\Title;
use Elastic\Elasticsearch\Client;

class ElasticSearchStockSearch implements StockSearchInterface
{
    private Client $client;

    public function __construct(Client $cl)
    {
        $this->client = $cl;
    }


    public function search(SearchQuery $searchQuery): BookRepository
    {

        $results = $this->client->search($this->makeParams($searchQuery));

        $bookRepository = new BookRepository();

        foreach ($results['hits']['hits'] as $item) {
            $source = $item['_source'];

            $book = new Book(
                new Id($source['sku']),
                new Title($source['title']),
                new Category($source['category']),
                new Price($source['price']),
                new BookAvailable($source['stock'])
            );

            $bookRepository->add($book);
        }

        return $bookRepository;
    }

    private function makeParams(SearchQuery $searchQuery): array
    {
        $query = [
            'must' => [
                'match' => [
                    'title' => [
                        "query" => $searchQuery->getTitle()->getTitle(),
                        'fuzziness' => "auto"
                    ]
                ],
            ]
        ];

        if ($searchQuery->getCategory()->getName()) {
            $query['filter'] = [
                'term' => [
                    'category' => $searchQuery->getCategory()->getName()
                ],
            ];
        }

        if ($searchQuery->getMinPrice()->getPrice() || $searchQuery->getMaxPrice()->getPrice()) {
            $range = [];
            if ($searchQuery->getMinPrice()->getPrice()) {
                $range['gte'] = $searchQuery->getMinPrice()->getPrice();
            }

            if ($searchQuery->getMaxPrice()->getPrice()) {
                $range['lte'] = $searchQuery->getMaxPrice()->getPrice();
            }
            $query['should'] = [
                'range' => ['price' => $range]
            ];
        }

        $params = [
            'index' => 'otus-shop',
            'size' => 20,
            'body' => [
                'query' => [
                    'bool' => $query
                ]
            ]
        ];

        return $params;
    }
}
