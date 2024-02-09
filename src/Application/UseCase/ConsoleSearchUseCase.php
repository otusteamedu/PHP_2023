<?php

namespace Dimal\Hw11\Application\UseCase;

use Dimal\Hw11\Application\InputSearchQueryInterface;
use Dimal\Hw11\Application\StockSearchInterface;
use Dimal\Hw11\Application\TableViewInterface;
use Dimal\Hw11\Domain\Entity\Book;
use Dimal\Hw11\Infrastructure\BookRepository;
use Dimal\Hw11\Infrastructure\Console\ConsoleInputSearchQuery;
use Dimal\Hw11\Infrastructure\ElasticSearchStockSearch;
use Dimal\Hw11\Presentation\ConsoleTableView;
use Elastic\Elasticsearch\ClientBuilder;

class ConsoleSearchUseCase
{
    private TableViewInterface $view;
    private StockSearchInterface $stockSearch;
    private InputSearchQueryInterface $inputSearch;

    public function __construct()
    {
        $this->view = new ConsoleTableView();

        $conf = parse_ini_file(".env");
        $cl = ClientBuilder::create();
        $cl->setHosts([$conf['ELASTIC_HOST']]);
        if ($conf['ELASTIC_PASSWORD']) {
            $cl->setApiKey($conf['ELASTIC_PASSWORD']);
        }
        $cl = $cl->build();
        $this->stockSearch = new ElasticSearchStockSearch($cl);

        $this->inputSearch = new ConsoleInputSearchQuery();
    }


    public function __invoke($params)
    {

        $this->show(
            $this->stockSearch->search(
                call_user_func($this->inputSearch, $params)
            )
        );
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

        $this->view->showTable($cols, $rows);
    }
}
