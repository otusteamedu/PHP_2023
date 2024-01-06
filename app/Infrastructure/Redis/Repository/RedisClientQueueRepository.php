<?php

namespace App\Infrastructure\Redis\Repository;

use App\Application\Action\Notifier\Notifier;
use App\Application\Action\Notify\EmailNotify;
use App\Application\Action\Notify\TelegramNotify;
use App\Application\Log\Log;
use App\Infrastructure\QueueRepositoryInterface;
use NdybnovHw03\CnfRead\Storage;
use Redis;

class RedisClientQueueRepository implements QueueRepositoryInterface
{
    public Redis $client;
    private string $uniqName;
    private Storage $cfg;
    private Log $log;

    public function __construct(
        Storage $config
    ) {
        $this->cfg = $config;
        $this->uniqName = $config->get('QUEUE_UNIQUE');

        $this->client = new Redis();
        $this->client->connect(
            $config->get('REDIS_HOST'),
            $config->get('REDIS_PORT')
        );

        $this->log = new Log();
        $this->log->useLogStep('Redis connected ...');
    }

    public function __destruct()
    {
        $this->log->useLogStep('Redis disconnected.');
    }

    public function add(string $message): void
    {
        $this->client->publish(
            $this->uniqName,
            $message
        );
    }

    public function readMessagesAndNotify(string $par = ''): void
    {
        $notifier = new Notifier($this->cfg);
        $notifier->add(EmailNotify::class);
        $notifier->add(TelegramNotify::class);

        $log = $this->log;
        $this->client->subscribe(
            [$this->uniqName],
            function($redis, $channel, $message) use ($notifier, $log) {
                $msgCli = sprintf(
                    'Read from Redis message: %s',
                    $message
                );
                $log->printConsole($msgCli);
                $log->printConsole(PHP_EOL);
                $log->printConsole(PHP_EOL);
                $notifier->run($message);
                $log->printConsole(PHP_EOL);
            }
        );
    }

    public function clear(): void
    {
        $this->client->unsubscribe([$this->uniqName]);
    }
}
