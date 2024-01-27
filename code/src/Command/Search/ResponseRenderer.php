<?php

declare(strict_types=1);

namespace Application\Command\Search;

use Symfony\Component\Console\Helper\Table;

class ResponseRenderer
{
    public static function render($output, $response): object
    {
        $data = [];

        foreach ($response['hits']['hits'] as $item) {
            $data[] = [
                $item['_source']['sku'],
                $item['_source']['title'],
                $item['_source']['price'],
            ];
        }

        $table = new Table($output);
        $table
            ->setHeaders(['SKU', 'TITLE', 'PRICE'])
            ->setRows($data);

        return $table;
    }
}
