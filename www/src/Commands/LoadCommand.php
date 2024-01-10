<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Commands;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yalanskiy\SearchApp\ElasticService;

/**
 * Команда для загрузки индекса
 */
class LoadCommand extends Command
{
    private ElasticService $service;

    public function __construct(ElasticService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    protected function configure(): void
    {
        $this
            ->setName('load')
            ->setDescription("Load index from books.json")
            ->setHelp("Load index from books.json");
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->service->loadFromJson(APP_ROOT . '/books.json', 'otus-books');

        return Command::SUCCESS;
    }
}
