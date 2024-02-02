<?php

declare(strict_types=1);

namespace Dimal\Hw11\Application;

use Dimal\Hw11\Domain\Entity\Book;
use Dimal\Hw11\Domain\Entity\SearchQuery;
use Dimal\Hw11\Domain\ValueObject\Category;
use Dimal\Hw11\Domain\ValueObject\Price;
use Dimal\Hw11\Domain\ValueObject\Title;
use Dimal\Hw11\Infrastructure\BookRepository;
use Dimal\Hw11\Infrastructure\ElasticSearchStockSearch;
use Dimal\Hw11\Presentation\ConsoleTableView;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;


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
        $minPrice = new Price();
        $maxPrice = new Price();
        $category = new Category();
        $name = '';
        for ($i = 1; $i < count($params); $i++) {
            if ($params[$i] == '--min-price') {
                $minPrice->setPrice((float)trim(str_replace(',', '.', $params[$i + 1])));
                $i++;
                continue;
            }

            if ($params[$i] == '--max-price') {
                $maxPrice->setPrice((float)trim(str_replace(',', '.', $params[$i + 1])));
                $i++;
                continue;
            }

            if ($params[$i] == '--category') {
                $category->setName(trim($params[$i + 1]));
                $i++;
                continue;
            }

            $name .= ' ' . trim($params[$i]);
        }

        $title = new Title(trim($name));

        return new SearchQuery($title, $category, $minPrice, $maxPrice);
    }

    private function search(SearchQuery $sq): BookRepository
    {
        $conf = parse_ini_file(".env");

        $cl = ClientBuilder::create();
        $cl->setHosts([$conf['ELASTIC_HOST']]);
        if ($conf['ELASTIC_PASSWORD']) {
            $cl->setApiKey($conf['ELASTIC_PASSWORD']);
        }
        $cl = $cl->build();

        $st = new ElasticSearchStockSearch($cl);
        $bookRepository = $st->search($sq);
        return $bookRepository;
    }

    private function show(BookRepository $booksRepository): void
    {

        $cols = [
            'category' => ['title' => 'Категория', 'width' => 20],
            'title' => ['title' => 'Наименование', 'width' => 50],
            'id' => ['title' => 'sku', 'width' => 10],
            'price' => ['title' => 'Цена', 'width' => 10],
            'avail' => ['title' => 'Наличие', 'width' => 25]
        ];

        $rows = [];
        $books = $booksRepository->getAll();
        foreach ($books as $book) {
            /** @var Book $book */
            $row = [
                'category' => $book->getCategory()->getName(),
                'title' => $book->getTitle()->getTitle(),
                'id' => $book->getId()->getId(),
                'price' => $book->getPrice()->getFormattedPrice(),
                'avail' => $book->getAvailiable()->getShopCountToString()
            ];

            array_push($rows, $row);
        }

        $view = new ConsoleTableView($cols, $rows);
        $view->showTable();
    }
}
