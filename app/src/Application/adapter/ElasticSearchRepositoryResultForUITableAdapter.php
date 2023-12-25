<?php

namespace App\Application\adapter;

use App\Domain\Entity\Book;

class ElasticSearchRepositoryResultForUITableAdapter implements AdapterInterface
{
    public function convert(array $result): array
    {
        foreach ($result as &$item) {
            $item = new Book(
                $item['sku'],
                $item['title'],
                $item['category'],
                $item['price'],
                $item['stock']
            );
        }

        return $result;
    }
}
