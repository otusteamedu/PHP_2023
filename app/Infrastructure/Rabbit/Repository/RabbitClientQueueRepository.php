<?php

declare(strict_types=1);

namespace App\Infrastructure\Rabbit\Repository;

use App\Application\Action\Notifier\Notifier;
use App\Application\Action\Notify\EmailNotify;
use App\Application\Action\Notify\TelegramNotify;
use App\Application\Log\Log;
use App\Infrastructure\QueueRepositoryInterface;
use NdybnovHw03\CnfRead\Storage;

class RabbitClientQueueRepository implements QueueRepositoryInterface
{
    private ClientInterface $client;
    private string $uniqueName;
    private Log $log;
    private Storage $cfg;

    public function __construct(
        Storage $config
    ) {
        $this->cfg = $config;
        $this->uniqueName = $config->get('QUEUE_UNIQUE');

        $this->client = new RabbitClient($config);

        $this->log = new Log();
        $this->log->useLogStep('Rabbit connected ...');
    }

    public function __destruct()
    {
        $this->client->close();
        $this->log->useLogStep('Rabbit disconnected.');
    }

    public function add(string $message): void
    {
        $this->client->publish(
            $this->uniqueName,
            $message,
            $this->getWays()
        );
    }

    private function getWays(): array
    {
        $notifyWays = $this->cfg->get('NOTIFY_WAYS');
        $ways = [];
        foreach (explode(',', $notifyWays) as $way) {
            $type = strtolower(trim($way));
            $ways[$type] = $type;
        }

        return $ways;
    }

    public function clear(): void
    {
        $this->client->clear(
            $this->uniqueName
        );
    }

    public function readMessagesAndNotify(string $par = ''): void
    {
        $ways = [
            'email' => EmailNotify::class,
            'telegram' => TelegramNotify::class,
        ];

        if (isset($ways[$par])) {
            $notifier = new Notifier($this->cfg);
            $notifier->add($ways[$par]);

            $this->client->notify(
                $this->uniqueName,
                $notifier,
                $par
            );
        }
    }
}
