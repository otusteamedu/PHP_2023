<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Queue;

use DEsaulenko\Hw19\Interfaces\ClientInterface;
use DEsaulenko\Hw19\Rabbit\Client;
use DEsaulenko\Hw19\Rabbit\Config;

class QueueClient
{
    private static ?QueueClient $instance = null;
    protected ClientInterface $client;
    protected ?string $exchange = null;

    public static function getInstance(): QueueClient
    {
        if (!static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        switch (getenv('QUEUE_TYPE')) {
            case QueueConstant::TYPE_CLIENT_RABBIT:
                $config = new Config(
                    getenv('RABBIT_HOST'),
                    getenv('RABBIT_PORT'),
                    getenv('RABBIT_LOGIN'),
                    getenv('RABBIT_PASSWORD'),
                    getenv('RABBIT_VHOST')
                );
                $this->client = new Client(
                    QueueConstant::QUEUE_NAME,
                    $config,
                    $this->exchange
                );
                break;
            default:
                throw new \Exception('Не задан тип очереди в .env');
        }
    }

    /**
     * @return string|null
     */
    public function getExchange(): ?string
    {
        return $this->exchange;
    }

    /**
     * @param string|null $exchange
     */
    public function setExchange(?string $exchange): self
    {
        $this->exchange = $exchange;
        return $this;
    }

    /**
     * @return ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }
}
