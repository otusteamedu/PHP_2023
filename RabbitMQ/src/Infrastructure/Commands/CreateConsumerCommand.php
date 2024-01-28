<?php

namespace App\Infrastructure\Commands;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = new Client([
            'host'      => 'rabbitmq',
            'vhost'     => '/',
            'user'      => 'guest',
            'password'  => 'guest',
        ]);

        $client->connect();

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
