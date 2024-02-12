<?php

namespace Dimal\Hw11\Infrastructure;

use Dimal\Hw11\Application\SearchQueryDTO;
use Dimal\Hw11\Domain\Entity\Book;
use Dimal\Hw11\Domain\Entity\StockShopCount;
use Dimal\Hw11\Domain\Repository\BookRepositoryInterface;
use Dimal\Hw11\Domain\ValueObject\Category;
use Dimal\Hw11\Domain\ValueObject\Id;
use Dimal\Hw11\Domain\ValueObject\Price;
use Dimal\Hw11\Domain\ValueObject\Shop;
use Dimal\Hw11\Domain\ValueObject\StockCount;
use Dimal\Hw11\Domain\ValueObject\Title;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElastickBookRepository implements BookRepositoryInterface
{
    private array $books = [];
    private Client $client;


    public function __construct()
    {
        $conf = parse_ini_file(".env");
        $cl = ClientBuilder::create();
        $cl->setHosts([$conf['ELASTIC_HOST']]);
        if ($conf['ELASTIC_PASSWORD']) {
            $cl->setApiKey($conf['ELASTIC_PASSWORD']);
        }
        $cl = $cl->build();
        $this->client = $cl;
    }

    public function add(Book $book): void
    {
        $this->books[] = $book;
    }

    public function search(SearchQueryDTO $searchQuery): array
    {
        $results = $this->client->search($this->makeSearchParams($searchQuery));

        $this->books = [];

        foreach ($results['hits']['hits'] as $item) {
            $source = $item['_source'];

            $stockCount = [];
            foreach ($source['stock'] as $stock) {
                $stockCount[] = new StockShopCount(
                    new Shop($stock['shop']),
                    new StockCount($stock['stock'])
                );
            }

            $book = new Book(
                new Id($source['sku']),
                new Title($source['title']),
                new Category($source['category']),
                new Price($source['price']),
                $stockCount
            );

            array_push($this->books, $book);
        }

        return $this->books;
    }

    public function getAll(): array
    {
        return $this->books;
    }

    private function makeSearchParams(SearchQueryDTO $searchQuery): array
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
