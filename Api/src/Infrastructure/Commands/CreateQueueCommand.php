<?php

namespace App\Infrastructure\Commands;

use App\Infrastructure\Constants;
use App\Infrastructure\Factory\RabbitMqClientFactory;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateQueueCommand extends Command
{
    public function __construct() {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('rabbitMQ:queue-create');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = RabbitMqClientFactory::create();
        $channel = $client->channel();

        $channel->queueDeclare(Constants::QUEUE_NAME, durable: true);
        $channel->queueBind(
            Constants::QUEUE_NAME,
            Constants::EXCHANGE_NAME,
            Constants::ROUTING_KEY
        );

        return self::SUCCESS;
    }
}
