<?php

namespace IilyukDmitryi\App\Infrastructure\Broker\Rabbitmq;

use Exception;
use IilyukDmitryi\App\Application\Dto\MessageReciveResponse;
use IilyukDmitryi\App\Infrastructure\Broker\Base\ReciverBrokerInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Reciver implements ReciverBrokerInterface
{
    private string $host;
    private string $port;
    private string $user;
    private string $pass;
    private string $queue;
    private int $recivetime;

    public function __construct()
    {
        $this->fillSettings();
    }

    protected function fillSettings(): void
    {
        $settings = ConfigApp::get();

        $this->host = $settings->getReciverHost();
        $this->port = $settings->getReciverPort();
        $this->user = $settings->getReciverUser();
        $this->pass = $settings->getReciverPass();
        $this->queue = $settings->getReciverQueue();
        $this->recivetime = $settings->getReciveTime();
    }

    /**
     * @return MessageReciveResponse
     * @throws Exception
     */
    public function recive(): MessageReciveResponse
    {
        $connection = new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass);
        $channel = $connection->channel();
        $time = time();
        while (true) {
            $message = $channel->basic_get($this->queue);
            if ($message instanceof AMQPMessage) {
                $message->ack();
                $channel->close();
                $connection->close();
                return new MessageReciveResponse($message->body);
            }
            if (time() - $time > $this->recivetime) {
                break;
            }
        }

        $channel->close();
        $connection->close();

        return new MessageReciveResponse("");
    }
}
