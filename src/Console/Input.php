<?php

declare(strict_types=1);

namespace VLebedev\BookShop\Console;

use VLebedev\BookShop\Exception\InputException;

class Input
{
    /**
     * @throws InputException
     */
    public function getCommand(array $commandList): int
    {
        $input = readline('Enter command number: ');

        if (!is_numeric($input) || !isset($commandList[$input - 1])) {
            throw new InputException('Command with this number does not exist');
        }

        return $input - 1;
    }

    public function getUploadFilePath(): string
    {
        return readline('Enter file path to upload: ');
    }

    public function getSearchByIdParams(): array
    {
        $params = [];
        $params[] = readline('Enter index to search: ');
        $params[] = readline('Enter id to search: ');
        return $params;
    }

    public function getSearchParams(): array
    {
        $filter = [];
        $must = [];
        $should = [];

        $index = readline('Enter index to search: ');

        if ($category = readline('Enter "category" to search (leave empty to skip): ')) {
            $filter['match']['category.keyword'] = $category;
        }

        if ($priceFrom = readline('Enter "price from" to search (leave empty to skip): ')) {
            $filter['range']['price']['gte'] = intval($priceFrom);
        }

        if ($priceTo = readline('Enter "price to" to search (leave empty to skip): ')) {
            $filter['range']['price']['lte'] = intval($priceTo);
        }

        if ($title = readline('Enter "title" to search (leave empty to skip): ')) {
            $must['match']['title']['query'] = $title;
            $must['match']['title']['fuzziness'] = 2;
        }

        if ($stock = readline('Enter "stock" to search (leave empty to skip): ')) {
            $should['range']['stock.stock']['gte'] = $stock;
            $should['range']['stock.stock']['lte'] = $stock;
        }

        return [$index, $filter, $must, $should];
    }
}
