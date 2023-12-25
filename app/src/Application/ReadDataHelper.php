<?php

namespace App\Application;

class ReadDataHelper
{
    private function getStockToString(array $stocks): string
    {
        return implode(
            '; ',
            array_map(
                static fn($item): string => sprintf('%s:%2d', $item['shop'], $item['stock']),
                $stocks
            )
        );
    }

    public function doing(): array
    {
        $file = __DIR__ . '/../../data/books.json';
        if (!file_exists($file)) {
            exit();
        }
        $handle = fopen($file, 'rb');

        $rows = [];
        $id = 1;
        while (!feof($handle)) {
            $line = fgets($handle);

            if (!empty($line)) {
                $document = json_decode($line, true);

                if (isset($document['title'])) {
                    $title = $document['title'];
                    $sku = $document['sku'];
                    $category = $document['category'];
                    $price = $document['price'];
                    $stock = $document['stock'];

                    $strStock = $this->getStockToString($stock);

                    $rows[] = [$id++, $title, $sku, $category, $price, $strStock];
                }
            }
        }

        return $rows;
    }
}
