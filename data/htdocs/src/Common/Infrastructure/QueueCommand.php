<?php

namespace Common\Infrastructure;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueCommand extends Command
{
    protected function configure()
    {
        $this->setName('queue:listen');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = config()->get('rabbit-mq.host');
        $port = config()->get('rabbit-mq.port');
        $user = config()->get('rabbit-mq.user');
        $password = config()->get('rabbit-mq.password');
        $vhost = config()->get('rabbit-mq.vhost');

        $connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
        $channel = $connection->channel();

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);
        $channel->consume();

        return 0;
    }
}
