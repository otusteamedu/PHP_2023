<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yalanskiy\SearchApp\Application\AddBookBulk;
use Yalanskiy\SearchApp\Application\Dto\AddBookBulkRequest;
use Yalanskiy\SearchApp\Application\Dto\AddBookRequest;
use Yalanskiy\SearchApp\Application\ValueObject\AddBookBulkCollection;
use Yalanskiy\SearchApp\Domain\Repository\DataRepositoryInterface;

/**
 * Команда для загрузки индекса
 */
class LoadCommand extends Command
{
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
            ->setName('load')
            ->setDescription("Load index from books.json")
            ->setHelp("Load index from books.json");
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = file_get_contents(APP_ROOT . '/books.json');
        $lines = explode("\n", $data);
        
        $request = new AddBookBulkCollection();
        $id = '';
        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }
            $json = json_decode($line, true);
            
            if (isset($json['create'])) {
                $id = $json['create']['_id'];
            }
            else {
                
                $request->add(new AddBookRequest(
                    $json['sku'],
                    $json['title'],
                    $json['category'],
                    $json['price'],
                    $json['stock'],
                    $id
                ));
            }
        }
        
        (new AddBookBulk($this->provider))(new AddBookBulkRequest($request));

        return Command::SUCCESS;
    }
}