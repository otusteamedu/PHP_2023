<?php

namespace Dimal\Hw11\Infrastructure;

use Dimal\Hw11\Domain\Entity\Book;
use Dimal\Hw11\Domain\Entity\BookAvailable;
use Dimal\Hw11\Domain\Entity\SearchQuery;
use Dimal\Hw11\Domain\ValueObject\Category;
use Dimal\Hw11\Domain\ValueObject\Id;
use Dimal\Hw11\Domain\ValueObject\Price;
use Dimal\Hw11\Domain\ValueObject\Title;
use Elastic\Elasticsearch\Client;

class ElasticSearchStockSearch extends AbstractStockSearch
{
    private $client;

    public function __construct(Client $cl)
    {
        $this->client = $cl;
        /*
        $this->client->setHosts([$host]);
        if ($password) {
            $this->client->setApiKey($password);
        }

        $this->client = $this->client->build();
        */
    }

    public function search(SearchQuery $sq): BookRepository
    {
        $query = [
            'must' => [
                'match' => [
                    'title' => [
                        "query" => $sq->getTitle()->getTitle(),
                        'fuzziness' => "auto"
                    ]
                ],
            ]
        ];

        if ($sq->getCategory()->getName()) {
            $query['filter'] = [
                'term' => [
                    'category' => $sq->getCategory()->getName()
                ],
            ];
        }

        if ($sq->getMinPrice()->getPrice() || $sq->getMaxPrice()->getPrice()) {
            $range = [];
            if ($sq->getMinPrice()->getPrice()) {
                $range['gte'] = $sq->getMinPrice()->getPrice();
            }

            if ($sq->getMaxPrice()->getPrice()) {
                $range['lte'] = $sq->getMaxPrice()->getPrice();
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

        $results = $this->client->search($params);

        $bookRepository = new BookRepository();

        foreach ($results['hits']['hits'] as $item) {
            $source = $item['_source'];
            //$book = new Book($source['sku'], $source['title'], $source['category'], $source['price'], $avail);
            //array_push($search_result, $book);


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
}
