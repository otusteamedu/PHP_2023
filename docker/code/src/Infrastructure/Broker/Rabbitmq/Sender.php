<?php

namespace IilyukDmitryi\App\Infrastructure\Broker\Rabbitmq;

use Exception;
use IilyukDmitryi\App\Application\Dto\MessageSendRequest;
use IilyukDmitryi\App\Infrastructure\Broker\Base\SenderBrokerInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Sender implements SenderBrokerInterface
{
    private string $host;
    private string $port;
    private string $user;
    private string $pass;
    private string $queue;

    public function __construct()
    {
        $this->fillSettings();
    }

    protected function fillSettings(): void
    {
        $settings = ConfigApp::get();

        $this->host = $settings->getSenderHost();
        $this->port = $settings->getSenderPort();
        $this->user = $settings->getSenderUser();
        $this->pass = $settings->getSenderPass();
        $this->queue = $settings->getSenderQueue();
    }

    /**
     * @param MessageSendRequest $messageSendRequest
     * @return void
     * @throws Exception
     */
    public function send(MessageSendRequest $messageSendRequest): void
    {
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass);
        $channel = $connection->channel();

        $channel->queue_declare($this->queue, false, false, false, false);

        $msg = new AMQPMessage($messageSendRequest->getBody(), array('delivery_mode' => 2));
        $channel->basic_publish($msg, '', $this->queue);

        $channel->close();
        $connection->close();
    }
}

