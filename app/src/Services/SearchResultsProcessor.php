<?php

declare(strict_types=1);

namespace YuzyukRoman\Hw11\Services;

use YuzyukRoman\Hw11\DTO\BookDto;

class SearchResultsProcessor
{
    public static function processResults(array $data): array
    {
        $products = [];

        foreach ($data as $hit) {
            $title = $hit['_source']['title'];
            $sku = $hit['_id'];
            $category = $hit['_source']['category'];
            $price = $hit['_source']['price'];

            foreach ($hit['_source']['stock'] as $stock) {
                $shop = $stock['shop'];
                $stockAmount = $stock['stock'];

                $product = new BookDto($title, $sku, $category, $price, $shop, $stockAmount);
                $products[] = $product;
            }
        }

        return $products;
    }
}
