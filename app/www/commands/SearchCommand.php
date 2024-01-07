<?php

declare(strict_types=1);

namespace Commands;

use Ahc\Cli\Input\Command;
use Ahc\Cli\IO\Interactor;
use App\Elasticsearch\SearchAction;

class SearchCommand extends Command
{
    public function __construct()
    {
        parent::__construct('Search', 'Search data');

        $this
             ->option('-c --category', 'The category')
             ->option('-s --minPrice', 'The minimum price')
             ->option('-e --maxPrice', 'The maximum price')
             ->option('-i --inStock', 'Available in stock');
    }

    public function interact(Interactor $io): void
    {
        if (!$this->query) {
            $this->set('query', $io->prompt('Enter Query'));
        }
    }

    public function execute()
    {
        $io = $this->app()->io();

        $params = [
            'category' => $this->category,
            'query' => $this->query,
            'minPrice' => $this->minPrice,
            'maxPrice' => $this->maxPrice,
            'inStock'  => $this->inStock
        ];

        $search = new SearchAction($params);
        $search->do();

        $rows = [];
        foreach ($search->getResult() as $row) {
            // var_dump($row['_source']);
            $data = $row['_source'];
            $rows[] = [
                'title'    => $data['title'],
                'sku'      => $data['sku'],
                'category' => $data['category'],
                'price '   => $data['price']
            ];
        }

        $io->table(
            $rows,
            [
                'head' => 'boldGreen',
                'odd'  => 'bold',
                'even' => 'comment'
            ]
        );

        exit();
    }
}
