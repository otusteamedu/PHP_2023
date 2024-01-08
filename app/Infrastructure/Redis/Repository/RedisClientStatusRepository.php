<?php

namespace App\Infrastructure\Redis\Repository;

use App\Application\Log\Log;
use App\Infrastructure\GetterInterface;
use App\Infrastructure\MessageStatusRepositoryInterface;
use Redis;

class RedisClientStatusRepository implements MessageStatusRepositoryInterface
{
    public Redis $client;
    private GetterInterface $cfg;
    private Log $log;

    public function __construct(
        GetterInterface $config
    ) {
        $this->cfg = $config;

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

    public function clear(): void
    {
        $keys = $this->client->keys($this->getPrefixKey('*'));
        $this->client->del($keys);
    }

    public function get(string $uid): string
    {
        $key = $this->getPrefixKey($uid);
        $status = $this->client->get($key);

        $msg = sprintf(
            'Read `%s` -> `%s` [%s] [%s]',
            $key,
            $status,
            time(),
            hrtime(true)
        );
        $this->log->printOut($msg);

        return $status ?? '';
    }

    public function set(string $uid, string $status): void
    {
        $key = $this->getPrefixKey($uid);
        $this->client->set($key, $status);

        $msg = sprintf(
            'Set `%s` to `%s` [%s] [%s]',
            $key,
            $status,
            time(),
            hrtime(true)
        );
        $this->log->printOut($msg);
    }

    private function getPrefixKey(string $uid): string
    {
        return sprintf('%s:%s', 'uid', $uid);
    }
}
