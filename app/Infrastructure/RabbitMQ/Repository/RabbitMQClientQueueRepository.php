<?php

declare(strict_types=1);

namespace App\Infrastructure\RabbitMQ\Repository;

use App\Application\Action\Notifier\Notifier;
use App\Application\Action\Notify\EmailNotify;
use App\Application\Action\Notify\TelegramNotify;
use App\Application\Log\Log;
use App\Infrastructure\QueueRepositoryInterface;
use NdybnovHw03\CnfRead\Storage;

class RabbitMQClientQueueRepository implements QueueRepositoryInterface
{
    private ClientInterface $clientMq;
    private string $uniqueName;
    private Log $log;
    private Storage $cfg;

    public function __construct(
        Storage $config
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

    public function add(string $message): void {
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

    public function readMessagesAndNotify(string $par = ''): void
    {
        $notifier = new Notifier($this->cfg);
        $notifier->add(EmailNotify::class);
        $notifier->add(TelegramNotify::class);

        $this->clientMq->notify(
            $this->uniqueName,
            $notifier
        );
    }
}
