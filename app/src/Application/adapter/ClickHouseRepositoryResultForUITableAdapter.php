<?php

namespace App\Application\adapter;

use App\Domain\Entity\Book;

class ClickHouseRepositoryResultForUITableAdapter implements AdapterInterface
{
    public function convert(array $result): array
    {
        foreach ($result as &$item) {
            $item = new Book(
                $item['sku'],
                $item['title'],
                $item['category'],
                $item['price'],
                $this->getStockToArray($item['stock'])
            );
        }

        return $result;
    }

    private function getStockToArray(string $stock): array
    {
        return (
        array_map(
            static function ($ar): array {
                [$arr['shop'], $arr['stock']] = explode(':', $ar);
                $arr['stock'] = (int)($arr['stock']);
                return $arr;
            },
            explode('; ', $stock)
        ));
    }
}
