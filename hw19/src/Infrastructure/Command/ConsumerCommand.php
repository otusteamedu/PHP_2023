<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Infrastructure\Component\Consumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends Command
{
    public function __construct(
        private readonly Consumer $consumer,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('consume:start-consumer');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->consumer->consume(
            function ($message) {
                echo $message . PHP_EOL;
            },
        );

        return self::SUCCESS;
    }
}
