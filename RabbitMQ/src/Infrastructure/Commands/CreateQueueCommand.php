<?php

namespace App\Infrastructure\Commands;

use Bunny\Client;
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $bunny = new Client([
            'host'      => 'rabbitmq',
            'vhost'     => '/',
            'user'      => 'guest',
            'password'  => 'guest',
        ]);

        $bunny->connect();

        $channel = $bunny->channel();

        $channel->queueDeclare('events.analytics-service', durable: true);
        $channel->queueBind('events.analytics-service', 'events', 'payment_succeeded');
        //$channel->publish('{"paymentId": 1}', exchange: 'events', routingKey: 'payment_succeeded');

        return self::SUCCESS;
    }
}