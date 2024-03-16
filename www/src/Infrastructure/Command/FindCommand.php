<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yalanskiy\SearchApp\Application\Dto\FindBookRequest;
use Yalanskiy\SearchApp\Application\FindBook;
use Yalanskiy\SearchApp\Domain\Repository\DataRepositoryInterface;

/**
 * Команда для поиска книг
 */
class FindCommand extends Command
{
    private array $options = [
        [
            'name' => 'title',
            'shortcut' => 't',
            'description' => 'Book title'
        ],
        [
            'name' => 'category',
            'shortcut' => 'c',
            'description' => 'Book category'
        ],
        [
            'name' => 'price',
            'shortcut' => 'p',
            'description' => 'Book price (>=1000, 1000, <=1000)'
        ],
        [
            'name' => 'stock',
            'shortcut' => 's',
            'description' => 'Stock amount (>=5, 5, <=5)'
        ],
    ];

    public function __construct(
        private DataRepositoryInterface $provider
    )
    {
        parent::__construct();
    }
    
    protected function configure(): void
    {
        parent::configure();
        
        $this
            ->setName('find')
            ->setDescription("Find books by parameters")
            ->setHelp(
                "Find books by parameters"
            );
        
        foreach ($this->options as $option) {
            $this->addOption($option['name'], $option['shortcut'], InputOption::VALUE_OPTIONAL, $option['description']);
        }
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $searchParams = [];
        foreach ($this->options as $option) {
            if ($value = $input->getOption($option['name'])) {
                $searchParams[$option['name']] = $value;
            }
        }

        $result = (new FindBook($this->provider))(new FindBookRequest($searchParams));
        
        $table = new Table($output);
        $table->setHeaders([
            'Scores',
            'SKU',
            'Title',
            'Category',
            'Price',
            'Stock'
        ]);
        foreach ($result->response as $item) {
            $stock = '';
            
            foreach ($item->getStock() as $store) {
                $stock .= "{$store['shop']}: {$store['stock']}\n";
            }
            
            $table->addRow([
                number_format(floatval($item->getScore()), decimals: 2),
                $item->getSku(),
                $item->getTitle(),
                $item->getCategory(),
                $item->getPrice(),
                $stock
            ]);
        }
        $table->render();
        
        return Command::SUCCESS;
    }
}