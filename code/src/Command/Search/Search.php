<?php

declare(strict_types=1);

namespace Application\Command\Search;

use Application\Settings;
use Elastic\Elasticsearch\ClientBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:search')]
class Search extends Command
{
    protected function configure(): void
    {
        $this->addOption('query', null, InputOption::VALUE_REQUIRED);
        $this->addOption('lt', null, InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST']])
            ->setBasicAuthentication(
                $_ENV['ELASTIC_LOGIN'],
                $_ENV['ELASTIC_PASSWORD']
            )
            ->build();

        $params = new BodyBuilder();
        $params->setIndex($_ENV['ELASTIC_INDEX']);
        $params->setQuery($input->getOption('query'));
        $params->setLt($input->getOption('lt'));

        $response = $client->search($params->build());

        $table = ResponseRenderer::render($output, $response);
        $table->render();

        return Command::SUCCESS;
    }
}
