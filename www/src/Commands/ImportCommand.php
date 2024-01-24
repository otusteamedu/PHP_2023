<?php

declare(strict_types=1);

namespace Yalanskiy\HomeworkRedis\Commands;

use JsonException;
use RedisException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yalanskiy\HomeworkRedis\Services\RedisService;

/**
 * ImportCommand console command
 */
class ImportCommand extends Command
{
    private RedisService $redis;

    public function __construct(RedisService $redis)
    {
        parent::__construct();

        $this->redis = $redis;
    }

    protected function configure(): void
    {
        $this
            ->setName('analytic:import')
            ->setDescription("Import data from data.json")
            ->setHelp("Import data from data.json");
    }

    /**
     * @throws RedisException
     * @throws JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = file_get_contents(DATA_FILE);
        if (empty($data)) {
            throw new JsonException("Incorrect data.json file.");
        }

        $json = json_decode($data, true);
        if (empty($json)) {
            throw new JsonException("Incorrect data.json file.");
        }

        $this->redis->clear();
        foreach ($json as $item) {
            $this->redis->add($item['event'], (int)$item['priority'], $item['conditions']);
        }

        echo 'Imported: ' . count($json) . ' items' . PHP_EOL;

        return Command::SUCCESS;
    }
}
