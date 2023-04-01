<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use LucidFrame\Console\ConsoleTable;
use Vp\App\DTO\SearchParams;
use Vp\App\Services\Container;
use Vp\App\Storage\Search;

class CommandSearch implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(array $argv): void
    {
        $searchParams = new SearchParams(query: $argv[2] ?? null, category: $argv[3] ?? null, maxPrice: $argv[4] ?? null);
        $search = Container::getInstance()->get(Search::class);
        $result = $search->work($searchParams);
        $table = $this->createConsoleTable($result->getResult());

        fwrite(STDOUT, $result . PHP_EOL);
        $table->display();
    }

    private function createConsoleTable(array $documents): ConsoleTable
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('title')
            ->addHeader('sku')
            ->addHeader('score')
            ->addHeader('category')
            ->addHeader('price')
            ->addHeader('total_stock');

        foreach ($documents as $document) {
            $table->addRow()
                ->addColumn($document['_source']['title'])
                ->addColumn($document['_source']['sku'])
                ->addColumn(round($document['_score'], 2))
                ->addColumn($document['_source']['category'])
                ->addColumn($document['_source']['price'])
                ->addColumn($this->getTotalStock($document['_source']['stock']));
        }
        return $table;
    }

    private function getTotalStock(array $stock): int
    {
        $total = 0;

        foreach ($stock as $shop) {
            $total += $shop['stock'];
        }

        return $total;
    }
}
