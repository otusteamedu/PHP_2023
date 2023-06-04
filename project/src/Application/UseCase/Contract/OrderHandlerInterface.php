<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase\Contract;

use PhpAmqpLib\Message\AMQPMessage;

interface OrderHandlerInterface
{
    public function handle(AMQPMessage $message): void;
}
