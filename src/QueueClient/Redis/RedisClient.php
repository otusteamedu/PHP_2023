<?php

declare(strict_types=1);

namespace App\QueueClient\Redis;

use App\Queue\QueueConstant;
use App\QueueClient\QueueClientInterface;
use Exception;
use Redis;
use RedisException;

class RedisClient implements QueueClientInterface
{
    private Redis $client;

    /**
     * @throws Exception
     */
    public function __construct(RedisConfigInterface $config)
    {
        $this->client = new Redis();

        try {
            $this->client->connect($config->getHost(), $config->getPort());
        } catch (RedisException $e) {
            throw new Exception($e->getMessage());
        }

        try {
            if (!$this->client->ping()) {
                throw new Exception('Хранилище недоступно');
            }
        } catch (RedisException $e) {
            throw new Exception($e->getMessage());
        }

    }

    /**
     * @throws RedisException
     */
    public function consume(): void
    {
        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($redis, $chan, $msg) {
            echo $msg . PHP_EOL;

            if ($msg === 'quit') {
                $this->close();
            }
        };

        $this->client->subscribe([QueueConstant::QUEUE_NAME], $callback);
    }

    /**
     * @throws RedisException
     */
    public function publish(string $message): void
    {
        $this->client->publish(QueueConstant::QUEUE_NAME, $message);
    }

    /**
     * @throws RedisException
     */
    public function close(): void
    {
        $this->client->close();
    }
}
