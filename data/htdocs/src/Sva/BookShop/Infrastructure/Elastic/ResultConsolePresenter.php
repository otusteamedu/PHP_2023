<?php

namespace Sva\BookShop\Infrastructure\Elastic;

use Sva\BookShop\App\Elastic\ResultPresenterInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class ResultConsolePresenter implements ResultPresenterInterface
{
    public function print(array $arResult): void
    {
        $out = new ConsoleOutput();
        $table = new Table($out);
        $table->setHeaders(['Title', 'Category', 'Price']);
        foreach ($arResult['hits']['hits'] as $book) {
            $stock = '';
            foreach ($book['_source']['stock'] as $key => $value) {
                $stock .= $value['shop'] . ': ' . $value['stock'] . "; ";
            }

            $table->addRow([
                $book['_source']['title'],
                $book['_source']['category'],
                $book['_source']['price'],
                $stock

            ]);
        }
        $table->render();
    }
}
