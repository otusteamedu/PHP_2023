<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Rabbit;

use DEsaulenko\Hw19\Interfaces\ClientInterface;
use DEsaulenko\Hw19\Interfaces\PublisherInterface;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher implements PublisherInterface
{
    public const DEFAULT_TYPE_MESSAGE = 'text/plain';
    private ClientInterface $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function execute(AMQPMessage $message): void
    {
        $this->client->getChannel()->basic_publish($message, $this->client->getExchange());
        $this->client->shutdown();
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }
}
