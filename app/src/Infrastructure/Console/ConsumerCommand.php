<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Infrastructure\Component\Consumer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:consume')]
final class ConsumerCommand extends Command
{
    public function __construct(
        private readonly Consumer $consumer,
    ) {
        parent::__construct();
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
