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
        $params = [];

        $params[] = readline('Enter index to search: ');
        $params[] = readline('Enter "category" to search (leave empty to skip): ');

        $priceFrom = readline('Enter "price from" to search (leave empty to skip): ');
        $params[] = $priceFrom ? intval($priceFrom) : null;

        $priceTo = readline('Enter "price to" to search (leave empty to skip): ');
        $params[] = $priceTo ? intval($priceTo) : null;

        $params[] = readline('Enter "title" to search (leave empty to skip): ');

        $stock = readline('Enter "stock" to search (leave empty to skip): ');
        $params[] = $stock ? intval($stock) : null;
        return $params;
    }
}
