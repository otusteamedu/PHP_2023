<?php

declare(strict_types=1);

namespace Dimal\Hw11;

use Exception;
use Dimal\Hw11\Entity\SearchQuery;
use Dimal\Hw11\Infrastructure\ElasticSearchStockSearch;
use Dimal\Hw11\Presentation\ConsoleTableView;
use Elastic\Elasticsearch\ClientBuilder;

class App
{
    public function run(array $params): void
    {
        if (count($params) < 2) {
            throw new Exception("Empty Search query!");
        }
        $sq = $this->getSearchQuery($params);
        $books = $this->search($sq);
        $this->show($books);
    }

    private function getSearchQuery(array $params): SearchQuery
    {
        $min_price = 0;
        $max_price = 0;
        $category = '';
        $name = '';
        for ($i = 1; $i < count($params); $i++) {
            if ($params[$i] == '--min-price') {
                $min_price = (float)trim(str_replace(',', '.', $params[$i + 1]));
                $i++;
                continue;
            }

            if ($params[$i] == '--max-price') {
                $max_price = (float)trim(str_replace(',', '.', $params[$i + 1]));
                $i++;
                continue;
            }

            if ($params[$i] == '--category') {
                $category = trim($params[$i + 1]);
                $i++;
                continue;
            }

            $name .= ' ' . trim($params[$i]);
        }
        $name = trim($name);

        return new SearchQuery($name, $category, $min_price, $max_price);
    }

    private function search(SearchQuery $sq): array
    {
        $conf = parse_ini_file(".env");

        $cl = ClientBuilder::create();
        $cl->setHosts([$conf['ELASTIC_HOST']]);
        if ($conf['ELASTIC_PASSWORD']) {
            $cl->setApiKey($conf['ELASTIC_PASSWORD']);
        }
        $cl = $cl->build();

        $st = new ElasticSearchStockSearch($cl);
        $book_array = $st->search($sq);
        return $book_array;
    }

    private function show($books): void
    {

        $cols = [
            'category' => ['title' => 'Категория', 'width' => 20],
            'title' => ['title' => 'Наименование', 'width' => 50],
            'id' => ['title' => 'sku', 'width' => 10],
            'price' => ['title' => 'Цена', 'width' => 10],
            'avail' => ['title' => 'Наличие', 'width' => 25]
        ];

        $rows = [];
        foreach ($books as $book) {
            $row = [
                'category' => $book->getCategory(),
                'title' => $book->getTitle(),
                'id' => $book->getId(),
                'price' => $book->getPrice(),
                'avail' => $book->getAvailToString()
            ];

            array_push($rows, $row);
        }

        $view = new ConsoleTableView($cols, $rows);
        $view->showTable();
    }
}
