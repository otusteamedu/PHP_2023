<?php

declare(strict_types=1);

namespace Vp\App\Application\RabbitMq\Contract;

use PhpAmqpLib\Connection\AMQPStreamConnection;

interface AmqpConnectionInterface
{
    public function getConnection(): AMQPStreamConnection;
}
