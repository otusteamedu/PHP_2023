<?php

declare(strict_types=1);

namespace Vp\App\Application\Handler\Contract;

use PhpAmqpLib\Message\AMQPMessage;

interface EmailHandlerInterface
{
    public function handle(AMQPMessage $message): void;
}
