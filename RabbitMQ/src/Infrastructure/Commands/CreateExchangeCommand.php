<?php

namespace App\Infrastructure\Commands;

use App\Infrastructure\Constants;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateExchangeCommand extends Command
{
    public function __construct() {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('rabbitMQ:exchange-create');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = RabbitMqClientFactory::create();
        $channel = $client->channel();
        $channel->exchangeDeclare(Constants::EXCHANGE_NAME, durable: true);

        return self::SUCCESS;
    }
}
