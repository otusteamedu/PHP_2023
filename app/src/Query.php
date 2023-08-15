<?php

declare(strict_types=1);

namespace Root\App;

use ErrorException;
use Exception;
use JsonSerializable;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Query
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;
    private string $queryName;

    public function __construct(AMQPStreamConnection $connection, string $queryName)
    {
        $this->connection = $connection;

        $this->queryName = $queryName;

        $this->channel = $connection->channel();
        $this->channel->queue_declare($this->queryName, false, true, false, false);
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

    public function publish(string|JsonSerializable $message): void
    {
        if (is_string($message)) {
            $msg = new AMQPMessage($message);
        } else {
            $msg = new AMQPMessage(json_encode($message, JSON_UNESCAPED_UNICODE));
        }
        $this->channel->basic_publish($msg, '', $this->queryName);
    }

    /**
     * @throws AppException
     */
    public function listen(string $tag, callable $callback): void
    {
        $this->channel->basic_consume($this->queryName, $tag, false, false, false, false, $callback);
        try {
            $this->channel->consume();
        } catch (ErrorException $e) {
            throw new AppException('Error connect listen. ' . $e->getMessage());
        }
    }
}
