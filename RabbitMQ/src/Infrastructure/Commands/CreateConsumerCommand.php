<?php

namespace App\Infrastructure\Commands;

use App\Application\UseCase\ConsumeMessageUseCase;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
class CreateConsumerCommand extends Command
{
    public function __construct(private readonly ConsumeMessageUseCase $consumeMessageUseCase) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('rabbitMQ:consumer-create');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->consumeMessageUseCase->run();

        return self::SUCCESS;
    }
}
