<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ\Repository;

use App\Application\Action\StatusUpdater\StatusUpdater;
use App\Application\Log\Log;
use App\Infrastructure\GetterInterface;
use App\Infrastructure\MessageQueueRepositoryInterface;

class RabbitMQClientQueueRepository implements MessageQueueRepositoryInterface
{
    private ClientInterface $clientMq;
    private string $uniqueName;
    private Log $log;
    private GetterInterface $cfg;

    public function __construct(
        GetterInterface $config
    ) {
        $this->cfg = $config;
        $this->uniqueName = $config->get('QUEUE_UNIQUE');

        $this->clientMq = new RabbitMQClient($config);

        $this->log = new Log();
        $this->log->useLogStep('RabbitMQ connected ...');
    }

    public function __destruct()
    {
        $this->clientMq->close();
        $this->log->useLogStep('RabbitMQ disconnected.');
    }

    public function add(string $message): void
    {
        $this->clientMq->publish(
            $this->uniqueName,
            $message
        );
    }

    public function clear(): void
    {
        $this->clientMq->clear(
            $this->uniqueName
        );
    }

    public function read(): void
    {
        $this->clientMq->readAndStatusUpdate(
            $this->uniqueName,
            new StatusUpdater($this->getConfig())
        );
    }

    public function getConfig(): GetterInterface
    {
        return $this->cfg;
    }
}
