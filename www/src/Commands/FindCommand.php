<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Commands;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yalanskiy\SearchApp\ElasticService;

/**
 * Команда для поиска книг
 */
class FindCommand extends Command
{
    protected ElasticService $service;
    protected Elasticsearch|Promise $searchResult;

    public function __construct(ElasticService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('find')
            ->setDescription("Find data by parameters")
            ->setHelp(
                "Find data by parameters"
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->searchResult = $this->service->search();

        return Command::SUCCESS;
    }
}
