<?php

declare(strict_types=1);

namespace App\Rabbit\Interfaces;

use PhpAmqpLib\Message\AMQPMessage;

interface ConsumerInterFace
{
    public function consume(): void;

    public function readMessage(AMQPMessage $msg): void;
}
