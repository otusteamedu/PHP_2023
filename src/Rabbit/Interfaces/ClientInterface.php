<?php

declare(strict_types=1);

namespace App\Rabbit\Interfaces;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

interface ClientInterface
{
    public function getConnection(): AMQPStreamConnection;

    public function getChannel(): AMQPChannel;

    public function close(): void;
}
