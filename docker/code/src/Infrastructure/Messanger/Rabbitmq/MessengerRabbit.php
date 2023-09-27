<?php


namespace IilyukDmitryi\App\Infrastructure\Messanger\Rabbitmq;

use Exception;
use IilyukDmitryi\App\Application\Contract\Messenger\MessageInterface;
use IilyukDmitryi\App\Application\Contract\Messenger\MessengerInterface;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MessengerRabbit implements MessengerInterface
{
    private string $host;
    private string $port;
    private string $user;
    private string $pass;
    private int $recivetime;

    public function __construct()
    {
        $this->fillSettings();
    }

    protected function fillSettings(): void
    {
        $settings = ConfigApp::get();

        $this->host = $settings->getMessangerHost();
        $this->port = $settings->getMessangerPort();
        $this->user = $settings->getMessangerUser();
        $this->pass = $settings->getMessangerPass();
        $this->recivetime = $settings->getMessangerReciveTime();
    }

    /**
     * @throws Exception
     */
    private function getConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection($this->host, $this->port, $this->user, $this->pass);
    }

    /**
     * @param MessageInterface $message
     * @return bool
     * @throws Exception
     */
    public function recive(MessageInterface &$message): bool
    {
        $connection = $this->getConnection();
        $channel = $connection->channel();
        $time = time();

        $messageAMPQ = $channel->basic_get($message->getType());
        if ($messageAMPQ instanceof AMQPMessage) {
            $messageAMPQ->ack();
            $channel->close();
            $connection->close();
            $message->setBody($messageAMPQ->body);
            return true;
        }

        $channel->close();
        $connection->close();
        return false;
    }

    /**
     * @param MessageInterface $message
     * @return void
     * @throws Exception
     */
    public function send(MessageInterface $message): void
    {
        $connection = $this->getConnection();
        $channel = $connection->channel();
        $queue = $message->getType();
        $channel->queue_declare($queue, false, false, false, false);

        $msg = new AMQPMessage($message->getBody(), array('delivery_mode' => 2));
        $channel->basic_publish($msg, '', $queue);

        $channel->close();
        $connection->close();
    }
}
