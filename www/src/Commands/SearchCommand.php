<?php

declare(strict_types=1);

namespace Yalanskiy\HomeworkRedis\Commands;

use RedisException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Yalanskiy\HomeworkRedis\Services\RedisService;

/**
 * SearchCommand console command
 */
class SearchCommand extends Command
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
            ->setName('analytic:search')
            ->setDescription("Search data in DB")
            ->setHelp("Search data in DB");

        $this->addOption('limit', 'l', InputOption::VALUE_OPTIONAL, 'Number of found events');
    }

    /**
     * @throws RedisException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = (int)$input->getOption('limit');

        $events = $this->redis->search(REDIS_SEARCH_PARAMS, $limit);
        if (empty($events)) {
            echo 'Events not found!' . PHP_EOL;
        } else {
            echo '======================================' . PHP_EOL;
            foreach ($events as $event) {
                echo 'Event: ' . $event['event'] . PHP_EOL;
                echo 'Score: ' . $event['score'] . PHP_EOL;
                echo '======================================' . PHP_EOL;
            }
        }

        return Command::SUCCESS;
    }
}
