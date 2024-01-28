<?php

namespace App\Infrastructure\Commands;

use Bunny\Client;
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
        $channel->exchangeDeclare('events', exchangeType: 'direct', durable: true);

        return self::SUCCESS;
    }
}
