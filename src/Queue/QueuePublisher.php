<?php

namespace Rabbit\Daniel\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueuePublisher {
    private $connection;
    private $channel;

    public function __construct(AMQPStreamConnection $connection) {
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('queue_name', false, true, false, false);
    }

    public function publish($data) {
        $msg = new AMQPMessage(json_encode($data));
        $this->channel->basic_publish($msg, '', 'queue_name');
    }

    public function __destruct() {
        $this->channel->close();
        $this->connection->close();
    }
}