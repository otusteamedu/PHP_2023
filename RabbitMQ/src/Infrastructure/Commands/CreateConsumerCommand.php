<?php

namespace App\Infrastructure\Commands;

use App\Infrastructure\Factory\RabbitMqClientFactory;
use Bunny\Channel;
use Bunny\Message;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateConsumerCommand extends Command
{
    public function __construct() {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('rabbitMQ:consumer-create');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = RabbitMqClientFactory::create();
        $channel = $client->channel();
        $channel->qos(prefetchCount: 1);

        $channel->consume(function (Message $message, Channel $channel): void {
            var_dump($message->content);
            $channel->ack($message);
        }, 'events.analytics-service');

        $client->run();

        return self::SUCCESS;
    }
}
