<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Infrastructure\Command;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Imitronov\Hw11\Domain\Exception\InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:products:import:elastic')]
final class ImportProductsToElasticCommand extends Command
{
    public function __construct(
        private readonly Client $client,
        private readonly string $indexName,
        private readonly string $indexConfigPath,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Импортировать данные в ElasticSearch из json-файла.');
        $this->addArgument('path', InputArgument::REQUIRED, 'Путь к json-файлу.');
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws InvalidArgumentException
     * @throws \JsonException
     * @throws MissingParameterException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!file_exists($input->getArgument('path'))) {
            throw new InvalidArgumentException('Файл для импорта не найден.');
        }

        try {
            $this->client->indices()->get(['index' => $this->indexName]);
        } catch (ClientResponseException) {
            if (!file_exists($this->indexConfigPath)) {
                throw new InvalidArgumentException('Файл настроек индекса не найден.');
            }

            $this->client->indices()->create([
                'index' => $this->indexName,
                'body' => json_decode(
                    file_get_contents($this->indexConfigPath),
                    true,
                    512,
                    JSON_THROW_ON_ERROR,
                ),
            ]);
        }

        $response = $this->client->bulk(['body' => file_get_contents($input->getArgument('path'))]);
        $io = new SymfonyStyle($input, $output);

        if ($response->getStatusCode() === 200) {
            $io->success('Импорт выполнен успешно.');
        }

        return self::SUCCESS;
    }
}
