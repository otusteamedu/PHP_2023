<?php

namespace App\Infrastructure\Commands;

use App\Infrastructure\Factory\RabbitMqClientFactory;
use Bunny\Client;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateExchangeCommand extends Command
{
    public function __construct() {
        parent::__construct();
    }

    protected function configure()
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
        $channel->exchangeDeclare('events', exchangeType: 'direct', durable: true);

        return self::SUCCESS;
    }
}
