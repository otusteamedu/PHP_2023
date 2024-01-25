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
        $settings = Settings::getSettings();

        $client = ClientBuilder::create()
            ->setHosts([$settings['host']])
            ->setBasicAuthentication(
                $settings['elastic']['login'],
                $settings['elastic']['pass']
            )
            ->build();

        $params = new BodyBuilder();
        $params->setIndex($settings['index']);
        $params->setQuery($input->getOption('query'));
        $params->setLt($input->getOption('lt'));

        $response = $client->search($params->build());

        $table = ResponseRenderer::render($output, $response);
        $table->render();

        return Command::SUCCESS;
    }
}
