<?php

namespace Radovinetch\Hw11\document;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Radovinetch\Hw11\Storage;

class Book extends Document
{
    protected array $tableHead = [
        'Название'  => 'title',
        'SKU'       => 'sku',
        'Категория' => 'category',
        'Цена'      => 'price'
    ];

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public static function search(Storage $storage, array $params = []): array
    {
        if (!isset($params['query'], $params['price'])) {
            return [];
        }

        $documents = [];

        $result = $storage->search($params['query'], $params['price']);
        foreach ($result['hits']['hits'] as $hit) {
            $book = new self();
            $book->setFills($hit['_source']);

            $documents[] = $book;
        }

        return $documents;
    }
}