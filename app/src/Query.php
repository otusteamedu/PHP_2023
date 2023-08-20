<?php

declare(strict_types=1);

namespace Root\App;

use ErrorException;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Query
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private string $queryName = 'app-query';


    /**
     * @throws AppException
     */
    public function __construct(array $config, ?string $queryName = null)
    {
        if (!empty($queryName)) {
            $this->queryName = $queryName;
        }

        try {
            $this->connection = new AMQPStreamConnection(
                $config['host'] ?? null,
                $config['port'] ?? null,
                $config['user'] ?? null,
                $config['password'] ?? null
            );
            $this->channel = $this->connection->channel();
            $this->channel->queue_declare($this->queryName);
        } catch (Exception $e) {
            throw new AppException('Error connect query. ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        try {
            $this->channel->close();
            $this->connection->close();
        } catch (Exception) {
            // none
        }
    }

    public function publish(string|array $message): void
    {
        if (is_array($message)) {
            $msg = new AMQPMessage(json_encode($message, JSON_UNESCAPED_UNICODE));
        } else {
            $msg = new AMQPMessage($message);
        }
        $this->channel->basic_publish($msg, '', $this->queryName);
    }

    /**
     * @throws AppException
     */
    public function listen(callable $callback): void
    {
        $this->channel->basic_consume($this->queryName, 'worker', false, true, false, false, $callback);
        try {
            $this->channel->consume();
        } catch (ErrorException $e) {
            throw new AppException('Error connect listen. ' . $e->getMessage());
        }
    }
}
