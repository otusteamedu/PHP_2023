<?php

declare(strict_types=1);

namespace Vp\App\Application\Producer;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Builder\Contract\RabbitSenderBuilderInterface;
use Vp\App\Application\Dto\Output\ResultSend;
use Vp\App\Application\Producer\Contract\SenderInterface;

class RabbitSender implements SenderInterface
{
    private string $host;
    private string $port;
    private string $user;
    private string $password;

    public function __construct(RabbitSenderBuilderInterface $builder)
    {
        $this->host = $builder->getHost();
        $this->port = $builder->getPort();
        $this->user = $builder->getUser();
        $this->password = $builder->getPassword();
    }

    public function send(string $queueName, string $message): ResultSend
    {
        $msg = new AMQPMessage($message,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        try {
            $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->password);
            $channel = $connection->channel();
            $channel->confirm_select();
            $channel->queue_declare($queueName, false, true, false, false);
            $channel->basic_publish($msg, '', $queueName);
            $channel->wait_for_pending_acks(2.000);
            $channel->close();
            $connection->close();
            return new ResultSend(true, 'Job added to the queue');
        } catch (\Exception $e) {
            return new ResultSend(false, 'An error occurred while adding a job to the queue, contact the application administrator');
        }
    }
}
