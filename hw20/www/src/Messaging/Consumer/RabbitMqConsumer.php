<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Messaging\Consumer;

use Doctrine\ORM\EntityManager;
use Shabanov\Otusphp\Connect\ChannelInterface;
use Shabanov\Otusphp\Connect\ConnectInterface;

class RabbitMqConsumer
{
    private ChannelInterface $channel;
    public function __construct(private readonly ConnectInterface $connect,
                                private readonly EntityManager $entityManager)
    {
        $this->channel = $connect->getClient();
        $this->init();
    }

    private function init(): void
    {
        $this->channel->setQueue($_ENV['BROKER_QUEUE']);
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $this->channel->consume($_ENV['BROKER_QUEUE'], $this->entityManager);
        $this->close();
    }

    /**
     * @throws \Exception
     */
    private function close(): void
    {
        $this->channel->close();
        $this->connect->close();
    }
}
